<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Iklan extends Admin_Controller
{

    protected $cont = 'iklan';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Iklan_model', 'model');
        $this->data['cont'] = $this->cont;
    }

    public function index()
    {
        if ($this->data['is_can_read']) {
            $this->data['content'] = 'admin/' . $this->cont . '/list_v';
        } else {
            redirect('restrict');
        }

        $this->load->view('admin/layouts/page', $this->data);
    }

    public function dataList()
    {
        $columns = array(
            0 => 'id',
            1 => 'b.name',
            2 => 'a.description',
            3 => '',
        );
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $where['a.is_deleted !='] = 2;

        $limit = 0;
        $start = 0;

        $totalData = $this->model->getCountAllBy($limit, $start, $search, $order, $dir, $where);

        $searchColumn = $this->input->post('columns');
        // $isSearchColumn = false;


        if (!empty($this->input->post('search')['value'])) {
            $search_value = $this->input->post('search')['value'];
            $search = array(
                "b.name" => $search_value,
                "a.description" => $search_value,
            );
            $totalFiltered = $this->model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
        } else {
            $totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $datas = $this->model->getAllBy($limit, $start, $search, $order, $dir, $where);
        //die(print_r($datas));
        $new_data = array();
        if (!empty($datas)) {
            foreach ($datas as $key => $data) {

                $edit_url = "";
                $delete_url = "";
                $delete_permanent = "";

                if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
                    $edit_url =  "<a href='" . base_url() . "iklan/edit/" . $data->id . "' data-id='" . $data->id . "' style='color: white;'><div class='btn btn-sm btn-primary btn-blue btn-editview'>Ubah</div></a>";
                }

                if ($this->data['is_can_delete']) {
                    if ($data->is_deleted == 0) {
                        $delete_url = "<a href='#'
                            data-id='" . $data->id . "' data-isdeleted='" . $data->is_deleted . "' class='btn btn-sm btn-danger white delete' url='" . base_url() . "iklan/destroy/" . $data->id . "/" . $data->is_deleted . "' >Non Aktifkan
                            </a>";
                    } else {
                        $delete_url = "<a href='#'
                            data-id='" . $data->id . "' data-isdeleted='" . $data->is_deleted . "' class='btn btn-sm btn-success white delete'
                             url='" . base_url() . "iklan/destroy/" . $data->id . "/" . $data->is_deleted . "'>Aktifkan
                            </a>";
                        $delete_permanent = "<a  href='#' url='" . base_url() . "iklan/destroy_permanent/" . $data->id . "' class='btn btn-sm btn-danger white delete'><i class='fa fa-trash-o'></i> Hapus</a>";
                    }
                }


                $nestedData['id'] = $start + $key + 1;
                $nestedData['role_name'] = $data->role_name;
                $nestedData['description'] = $data->description;

                $nestedData['action'] = $edit_url . " " . $delete_url . " " . $delete_permanent;
                $new_data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $new_data
        );

        echo json_encode($json_data);
    }

    public function create()
    {
        $this->form_validation->set_rules(
            'role_id',
            "Role",
            'trim|required|is_unique[iklan.role_id]',
            ['is_unique' => 'Role Tersebut sudah ada Iklannya']
        );
        $this->form_validation->set_rules('description', "Deskripsi", 'trim|required');

        if ($this->form_validation->run() === TRUE) {

            $data = [];
            if ($_FILES['image_iklan']['name']) {
                $config['upload_path']          = './image_upload/iklan/';
                $config['allowed_types']        = '*';
                $config['max_size']             = 20000;
                $random = rand(1000, 9999);
                $do_upload = 'image_iklan';
                $filename = pathinfo($_FILES['image_iklan']["name"]);
                $extension = $filename['extension'];
                $config['file_name'] = $random . time() . "." . $extension;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload($do_upload)) {
                    $data['image'] = $config['file_name'];
                } else {
                    echo $this->upload->display_errors();
                }
            }

            $data['role_id'] = $this->input->post('role_id');
            $data['description'] = $this->input->post('description');
            $data['created_by'] = $this->data['users']->id;

            $insert = $this->model->insert($data);

            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('message_error', "Iklan gagal disimpan");
                redirect($this->cont);
            } else {
                $this->session->set_flashdata('message', "Iklan berhasil disimpan");
                redirect($this->cont);
            }
        } else {

            $this->load->model('Roles_model');

            $this->data['roles'] = $this->Roles_model->get_dropdown([], NULL);
            $this->data['content'] = 'admin/' . $this->cont . '/create_v';
            $this->load->view('admin/layouts/page', $this->data);
        }
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('role_id', "Role", 'trim|required');
        $this->form_validation->set_rules('description', "Deskripsi", 'trim|required');

        if ($this->form_validation->run() === TRUE) {
            $data = array(
                'role_id'       => $this->input->post('role_id'),
                'description'   => $this->input->post('description'),
                'updated_by'    => $this->data['users']->id,
            );

            $id = $this->input->post('id');

            $update = $this->model->update($data, ['id' => $id]);


            if ($update === FALSE) {
                $this->session->set_flashdata('message_error', "Iklan gagal diubah");
                redirect($this->cont, "refresh");
            } else {
                $this->session->set_flashdata('message', "Iklan berhasil diubah");
                redirect($this->cont, "refresh");
            }
        } else {
            if (!empty($_POST)) {
                $id = $this->input->post('id');
                $this->session->set_flashdata('message_error', validation_errors());
                return redirect($this->cont . "/edit/" . $id);
            } else {
                $this->data['id'] = $id;
                $data = $this->model->getOneBy(array("id" => $this->data['id']));
                if ($data === FALSE) {
                    redirect($this->cont);
                }

                $this->data['data'] = $data;

                $this->load->model('Roles_model');
                $this->data['roles'] = $this->Roles_model->get_mydropdown();
                $this->data['roles'][0] = 'Semua Role';
                $this->data['content'] = 'admin/' . $this->cont . '/edit_v';
                $this->load->view('admin/layouts/page', $this->data);
            }
        }
    }

    public function destroy()
    {
        $response_data = array();
        $response_data['status'] = false;
        $response_data['msg'] = "";
        $response_data['data'] = array();

        $id = $this->uri->segment(3);
        $is_deleted = $this->uri->segment(4);
        if (!empty($id)) {

            $data = array(
                'is_deleted' => ($is_deleted == 1) ? 0 : 1,
                'updated_by' => $this->data['users']->id,
            );
            $update = $this->model->update($data, array("id" => $id));

            $response_data['data'] = $data;
            $response_data['status'] = true;
        } else {
            $response_data['msg'] = "ID Harus Diisi";
        }

        echo json_encode($response_data);
    }

    public function destroy_permanent()
    {
        $response_data = array();
        $response_data['status'] = false;
        $response_data['msg'] = "";
        $response_data['data'] = array();

        $id = $this->uri->segment(3);
        $is_deleted = $this->uri->segment(4);
        if (!empty($id)) {
            $data = array(
                'is_deleted'    => 2,
                'deleted_by'    => $this->data['users']->id,
                'deleted_time'  => $this->data['now_datetime']
            );
            $update = $this->model->update($data, array("id" => $id));

            $response_data['data'] = $data;
            $response_data['status'] = true;
        } else {
            $response_data['msg'] = "ID Harus Diisi";
        }

        echo json_encode($response_data);
    }
}
