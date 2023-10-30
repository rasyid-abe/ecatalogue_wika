<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Project extends Admin_Controller
{

    protected $cont = 'project';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Project_new_model', 'model');
        $this->load->model('Location_model');
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
            0 => 'project_new.id',
            1 => 'project_new.name',
            2 => 'project_new.no_spk',
            3 => 'groups.name',
            4 => 'location.name',
        );
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $where = array('project_new.is_deleted <>' => 2);

        $limit = 0;
        $start = 0;

        $totalData = $this->model->getCountAllBy($limit, $start, $search, $order, $dir, $where);

        if (!empty($this->input->post('search')['value'])) {
            $search_value = $this->input->post('search')['value'];
            $search = array(
                "project_new.name" => $search_value,
                "groups.name" => $search_value,
                'project_new.no_spk' => $search_value,
                "location.name" => $search_value,
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
                $delete_permanent_url = "";

                if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
                    $edit_url = "<a href='" . base_url() . $this->cont . "/edit/" . $data->id . "' class='btn btn-xs btn-info'><i class='fa fa-pencil'></i> Ubah</a>";
                }

                if ($this->data['is_can_delete']) {
                    if ($data->is_deleted == 0) {
                        $delete_url = "<a href='javascript:;'
	        				url='" . base_url() . $this->cont . "/destroy/" . $data->id . "/" . $data->is_deleted . "'
	        				class='btn btn-xs btn-danger delete' >NonAktifkan
	        				</a>";
                    } else {
                        $delete_url = "<a href='javascript:;'
	        				url='" . base_url() . $this->cont . "/destroy/" . $data->id . "/" . $data->is_deleted . "'
	        				class='btn btn-xs btn-danger delete'
	        				 >Aktifkan
	        				</a>";

                        $delete_permanent_url = "<a href='javascript:;'
                        url='" . base_url() . $this->cont . "/delete/" . $data->id . "'
                        class='btn btn-xs btn-warning delete'
                        > <i class='fa fa-trash-o'></i> Hapus
                        </a>";
                    }
                }


                $nestedData['id'] = $start + $key + 1;
                $nestedData['name'] = $data->name;
                $nestedData['departemen_name'] = $data->departemen_name;
                $nestedData['location_name'] = $data->location_name;
                $nestedData['no_spk'] = $data->no_spk;

                $nestedData['action'] = $edit_url . " " . $delete_url . ' ' . $delete_permanent_url;
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
        $this->form_validation->set_rules('name', "name", 'trim|required');
        $this->form_validation->set_rules('departemen_id', "departemen_id", 'trim|required');
        $this->form_validation->set_rules('kategori_id', "kategori_id", 'trim|required');
        $this->form_validation->set_rules('desa', "desa", 'trim|required');
        $this->form_validation
            ->set_rules('no_spk', "No SPK", 'trim|required')
            ->set_rules('alamat', "Alamat", 'trim|required')
            ->set_rules('contact_person', "Contact Person", 'trim|required')
            ->set_rules('no_hp', "No HP", 'trim|required');

        if ($this->form_validation->run() === TRUE) {

            $data = array(
                'name'          => $this->input->post('name'),
                'departemen_id' => $this->input->post('departemen_id'),
                'kategori_id' => $this->input->post('kategori_id'),
                'jenis_id' => $this->input->post('jenis_id'),
                'location_id' => $this->input->post('desa'),
                'no_spk' => $this->input->post('no_spk'),
                'alamat' => $this->input->post('alamat'),
                'lat' => $this->input->post('latitude'),
                'long' => $this->input->post('longitude'),
                'contact_person' => $this->input->post('contact_person'),
                'no_hp' => $this->input->post('no_hp'),
            );

            $insert = $this->model->insert($data);

            if ($insert === FALSE) {
                $this->session->set_flashdata('message_error', "Project Baru Gagal Disimpan");
                redirect($this->cont);
            } else {
                $this->session->set_flashdata('message', "Project Baru Berhasil Disimpan");
                redirect($this->cont);
            }
        } else {


            $this->load->model('Groups_model');
            $this->data['groups'] = $this->Groups_model->getAllById();
            $this->load->model('Kategori_project_model');
            $this->data['kategori'] = $this->Kategori_project_model->getAllById(['level' => 1]);

            $this->data['provinsi'] = $this->Location_model->get_dropdown2(['level' => 2]);
            $this->data['content'] = 'admin/' . $this->cont . '/create_v';
            $this->load->view('admin/layouts/page', $this->data);
        }
    }

    public function get_kabupaten()
    {
        $provinsi = $this->input->post('provinsi', true);
        $data = $this->db->get_where('ref_locations', ['parent_id' => $provinsi])->result_array();
        echo json_encode($data);
    }

    public function get_kecamatan()
    {
        $kabupaten = $this->input->post('kabupaten', true);
        $data = $this->db->get_where('ref_locations', ['parent_id' => $kabupaten])->result_array();
        echo json_encode($data);
    }

    public function get_desa()
    {
        $kecamatan = $this->input->post('kecamatan', true);
        $data = $this->db->get_where('ref_locations', ['parent_id' => $kecamatan])->result_array();
        echo json_encode($data);
    }
    public function get_jenis()
    {
        $kategori = $this->input->post('kategori', true);
        $data = $this->db->get_where('kategori_project', ['parent_id' => $kategori])->result_array();
        echo json_encode($data);
    }
    public function edit($id)
    {
        $this->form_validation->set_rules('name', "name", 'trim|required');
        $this->form_validation->set_rules('departemen_id', "departemen_id", 'trim|required');
        $this->form_validation->set_rules('kategori_id', "kategori_id", 'trim|required');
        $this->form_validation->set_rules('desa', "desa", 'trim|required');
        $this->form_validation
            ->set_rules('no_spk', "No SPK", 'trim|required')
            ->set_rules('alamat', "Alamat", 'trim|required')
            ->set_rules('contact_person', "Contact Person", 'trim|required')
            ->set_rules('no_hp', "No HP", 'trim|required');

        if ($this->form_validation->run() === TRUE) {
            $data = array(
                'name'          => $this->input->post('name'),
                'departemen_id' => $this->input->post('departemen_id'),
                'kategori_id' => $this->input->post('kategori_id'),
                'jenis_id' => $this->input->post('jenis_id'),
                'location_id' => $this->input->post('desa'),
                'no_spk' => $this->input->post('no_spk'),
                'alamat' => $this->input->post('alamat'),
                'lat' => $this->input->post('latitude'),
                'long' => $this->input->post('longitude'),
                'contact_person' => $this->input->post('contact_person'),
                'no_hp' => $this->input->post('no_hp'),
            );

            $id = $this->input->post('id');
            $update = $this->model->update($data, ['id' => $id]);

            if ($update === FALSE) {
                $this->session->set_flashdata('message_error', "Project Gagal Diubah");
                redirect($this->cont, "refresh");
            } else {
                $this->session->set_flashdata('message', "Project Berhasil Diubah");
                redirect($this->cont, "refresh");
            }
        } else {
            if (!empty($_POST)) {
                $id = $this->input->post('id');
                $this->session->set_flashdata('message_error', validation_errors());
                redirect($this->cont . "/edit/" . $id);
            } else {
                $this->data['id'] = $id;
                $data = $this->model->getOneBy(array("id" => $this->data['id']));
                $this->data['name'] = (!empty($data)) ? $data->name : "";
                $this->data['departemen_id'] = (!empty($data)) ? $data->departemen_id : "";
                $this->data['kategori_id'] = (!empty($data)) ? $data->kategori_id : "";
                $this->data['jenis_id'] = (!empty($data)) ? $data->jenis_id : "";
                $this->data['no_spk'] = (!empty($data)) ? $data->no_spk : "";
                $this->data['alamat'] = (!empty($data)) ? $data->alamat : "";
                $this->data['latitude'] = (!empty($data)) ? $data->lat : "";
                $this->data['longitude'] = (!empty($data)) ? $data->long : "";
                $this->data['contact_person'] = (!empty($data)) ? $data->contact_person : "";
                $this->data['no_hp'] = (!empty($data)) ? $data->no_hp : "";

                $location_id = (!empty($data)) ? $data->location_id : "";
                $desa = $this->db->get_where('ref_locations', ['location_id' => $location_id])->row_array();
                $kecamatan = $this->db->get_where('ref_locations', ['location_id' => $desa['parent_id']])->row_array();
                $kabupaten = $this->db->get_where('ref_locations', ['location_id' => $kecamatan['parent_id']])->row_array();
                $provinsi = $this->db->get_where('ref_locations', ['location_id' => $kabupaten['parent_id']])->row_array();
                $this->data['desa'] = (!empty($desa)) ? $desa['location_id'] : "";
                $this->data['kecamatan'] = (!empty($kecamatan)) ? $kecamatan['location_id'] : "";
                $this->data['kabupaten'] = (!empty($kabupaten)) ? $kabupaten['location_id'] : "";
                $this->data['provinsi'] = (!empty($provinsi)) ? $provinsi['location_id'] : "";

                $this->load->model('Groups_model');
                $this->data['groups'] = $this->Groups_model->getAllById();
                $this->load->model('Kategori_project_model');
                $this->data['kategori'] = $this->Kategori_project_model->getAllById(['level' => 1]);
                $this->data['jenis'] = $this->Kategori_project_model->getAllById(['level' => 2, 'parent_id' => $data->kategori_id]);

                $this->data['sel_provinsi'] = $this->Location_model->get_dropdown2(['level' => 2]);
                $this->data['sel_kabupaten'] = $this->Location_model->get_dropdown2(['level' => 3, 'parent_id' => $provinsi['location_id']]);
                $this->data['sel_kecamatan'] = $this->Location_model->get_dropdown2(['level' => 4, 'parent_id' => $kabupaten['location_id']]);
                $this->data['sel_desa'] = $this->Location_model->get_dropdown2(['level' => 5, 'parent_id' => $kecamatan['location_id']]);
                $this->data['content'] = 'admin/' . $this->cont . '/edit_v';
                $this->load->view('admin/layouts/page', $this->data);
            }
        }
    }

    public function delete()
    {
        $response_data = array();
        $response_data['status'] = false;
        $response_data['msg'] = "";
        $response_data['data'] = array();

        $id = $this->uri->segment(3);

        if (!empty($id)) {

            $data = array(
                'is_deleted' => 2,
                'deleted_by' => $this->data['users']->id,
                'deleted_time' => $this->data['now_datetime']
            );

            $update = $this->model->update($data, array("id" => $id));

            $response_data['data'] = $data;
            $response_data['status'] = true;
        } else {
            $response_data['msg'] = "ID Harus Diisi";
        }

        echo json_encode($response_data);
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
