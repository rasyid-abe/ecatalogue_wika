<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Location extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('location_model');
    }

    public function index()
    {
        $this->load->helper('url');
        if ($this->data['is_can_read']) {
            $this->data['content']  = 'admin/location/list_v';
        } else {
            redirect('restrict');
        }
        $this->load->view('admin/layouts/page', $this->data);
    }

    public function create()
    {
        $this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');
        $this->form_validation->set_rules(
            'location_id',
            "Kode Lokasi",
            'is_unique[location.id]',
            ['is_unique' => 'Kode lokasi sudah digunakan, gunakan kode lainnya']
        );

        if ($this->form_validation->run() === TRUE) {
            $data = array(
                'name' => $this->input->post('name'),
                'created_by' => $this->data['users']->id,
                'id' => $this->input->post('location_id'),
                'is_editable' => 1,
                // 'description' => $this->input->post('description')
            );
            if ($this->location_model->insert($data)) {
                $this->session->set_flashdata('message', "Lokasi Baru Berhasil Disimpan");
                redirect("location");
            } else {
                $this->session->set_flashdata('message_error', "Lokasi Baru Gagal Disimpan");
                redirect("location");
            }
        } else {
            $this->data['content'] = 'admin/location/create_v';
            $this->load->view('admin/layouts/page', $this->data);
        }
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('name', "Name Harus Diisi", 'trim|required');

        if ($this->form_validation->run() === TRUE) {
            $id = $this->input->post('id');
            $data = array(
                'name' => $this->input->post('name'),
                'updated_by' => $this->data['users']->id,
            );
            $update = $this->location_model->update($data, array("location.id" => $id));
            if ($update) {
                $this->session->set_flashdata('message', "Lokasi Berhasil Diubah");
                redirect("location", "refresh");
            } else {
                $this->session->set_flashdata('message_error', "Lokasi Gagal Diubah");
                redirect("location", "refresh");
            }
        } else {
            if (!empty($_POST)) {
                $id = $this->input->post('id');
                $this->session->set_flashdata('message_error', validation_errors());
                return redirect("location/edit/" . $id);
            } else {
                $this->data['id'] = $this->uri->segment(3);
                $location = $this->location_model->getOneBy(array("location.id" => $this->data['id']));
                $this->data['name'] =   (!empty($location)) ? $location->name : "";
                // $this->data['description'] =   (!empty($location))?$location->description:"";

                $this->data['content'] = 'admin/location/edit_v';
                $this->load->view('admin/layouts/page', $this->data);
            }
        }
    }

    public function dataList()
    {
        $columns = array(
            0 => 'location.id',
            1 => 'location.name',
        );


        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $where = array();
        $limit = 0;
        $start = 0;
        $totalData = $this->location_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);


        if (!empty($this->input->post('search')['value'])) {
            $search_value = $this->input->post('search')['value'];
            $search = array(
                "location.name" => $search_value,
                // "location.description"=>$search_value,
            );
            $totalFiltered = $this->location_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
        } else {
            $totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $datas = $this->location_model->getAllBy($limit, $start, $search, $order, $dir, $where);

        $new_data = array();
        if (!empty($datas)) {
            foreach ($datas as $key => $data) {

                $edit_url = "";
                $delete_url = "";

                if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
                    $edit_url =  "<a href='" . base_url() . "location/edit/" . $data->id . "' data-id='" . $data->id . "' style='color: white;' class='btn btn-sm btn-primary'>Edit</a>";
                }
                if ($this->data['is_can_delete']) {
                    if ($data->is_deleted == 0) {
                        $delete_url = "<a href='#'
                            data-id='" . $data->id . "' data-isdeleted='" . $data->is_deleted . "' class='btn btn-sm btn-danger white delete' url='" . base_url() . "location/destroy/" . $data->id . "/" . $data->is_deleted . "' >Set To Inactive
                            </a>";
                    } else {
                        $delete_url = "<a href='#'
                            data-id='" . $data->id . "' data-isdeleted='" . $data->is_deleted . "' class='btn btn-sm btn-success white delete'
                             url='" . base_url() . "location/destroy/" . $data->id . "/" . $data->is_deleted . "'>Set To Active
                            </a>";
                    }
                }
                $nestedData['id'] = $start + $key + 1;
                $nestedData['name'] = $data->name;
                // $nestedData['description'] = substr(strip_tags($data->description),0,50);
                if ($data->is_deleted == 0) {
                    $nestedData['status']       = "Active";
                } else {
                    $nestedData['status']       = "Inactive";
                }
                $nestedData['action']           = $data->is_editable == '1' ? ($edit_url . " " . $delete_url) : '';
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
            $update = $this->location_model->update($data, array("id" => $id));

            $response_data['data'] = $data;
            $response_data['status'] = true;
        } else {
            $response_data['msg'] = "ID Harus Diisi";
        }

        echo json_encode($response_data);
    }

    public function cekLocation()
    {
        $location_id = $this->input->post('location_id');
        $id = $this->input->post('id');
        $where = [];
        if ($location_id == $id) {
            $ret = [];
            $ret = ['status' => TRUE];
            echo json_encode($ret);
            return;
        }

        if ($location_id != $id) {
            $where = [
                'id' => $location_id,
            ];
        }
        $cekLokasi = $this->db->where($where)->get('location');
        $ret = [];
        $ret = ['status' => $cekLokasi->num_rows() > 0 ? FALSE : TRUE];
        echo json_encode($ret);
    }

    public function cekProyek()
    {
        $location_id = $this->input->post('location_project');
        $desa = $this->db->get_where('ref_locations', ['location_id' => $location_id])->row_array();
        $kecamatan = $this->db->get_where('ref_locations', ['location_id' => $desa['parent_id']])->row_array();
        $kabupaten = $this->db->get_where('ref_locations', ['location_id' => $kecamatan['parent_id']])->row_array();
        $return['location_id'] = (!empty($kabupaten)) ? $kabupaten['location_id'] : "";

        echo json_encode($return);
    }
}
