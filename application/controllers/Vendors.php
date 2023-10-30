<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Vendors extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('vendor_model');
    }

    public function index()
    {
        $this->load->helper('url');
        if ($this->data['is_can_read']) {
            $this->data['content']  = 'admin/vendors/list_v';
        } else {
            redirect('restrict');
        }
        $this->load->view('admin/layouts/page', $this->data);
        // $this->load->view('errors/html/error_404');
    }

    public function create()
    {
        //  redirect('vendors');
        $this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');
        $this->form_validation->set_rules('email', "Email Harus Diisi", 'trim|required');
        $this->form_validation->set_rules('address', "Alamat Harus Diisi", 'trim|required');
        $this->form_validation->set_rules('nama_direktur', "Nama Direktur Harus Diisi", 'required');
        $this->form_validation->set_rules('no_telp', "No Telp Harus Diisi", 'required');
        $this->form_validation->set_rules('no_fax', "No Fax Harus Diisi", 'required');

        if ($this->form_validation->run() === TRUE) {
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'email' => $this->input->post('email'),
                'address' => $this->input->post('address'),
                'start_contract' => $this->input->post('start_contract'),
                'end_contract' => $this->input->post('end_contract'),
                'no_contract' => $this->input->post('no_contract'),
                'is_margis' => $this->input->post('is_margis'),
                'department'    => $this->input->post('department'),
                'nama_direktur'    => $this->input->post('nama_direktur'),
                'no_telp'    => $this->input->post('no_telp'),
                'no_fax'    => $this->input->post('no_fax'),
                'created_by' => $this->data['users']->id,
            );

            /*
            $upload = 1;
            if($_FILES['file_contract']['name']){
                $config['upload_path']          = './file_contract/';
                $config['allowed_types']        = '*';
                $config['max_size']             = 20000;
                $random = rand(1000,9999);
                $do_upload = 'file_contract';
                $filename = pathinfo($_FILES['file_contract']["name"]);
                $extension = $filename['extension'];
                $config['file_name'] = $random."_".time().".".$extension;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload($do_upload)){
                    $data['file_contract'] = $config['file_name'];
                    $upload = 1;
                }else{
                    $upload = 0;
                }
            }
            */

            $this->load->library('ion_auth');
            $data_user = [
                'username' => $this->input->post('username'),
                'first_name' => $this->input->post('name'),
                'active' => 1,
                'email' => $this->input->post('email'),
                'is_deleted' => 0
            ];



            $this->db->trans_begin();
            $this->vendor_model->insert($data);
            $data_user['vendor_id'] = $this->db->insert_id();
            $insert_user = $this->ion_auth->register($this->input->post('username'), $this->input->post('password'), $this->input->post('email'), $data_user, [3]);
            if (!$insert_user)
                $this->db->trans_rollback();
            else
                $this->db->trans_commit();

            if ($this->db->trans_status() === TRUE && $insert_user) {

                $this->session->set_flashdata('message', "Vendor Baru Berhasil Disimpan");

                redirect("vendors");
            } else {
                $pesan = !$insert_user ? ' Email Sudah digunakan' : '';
                $this->session->set_flashdata('message_error', "Vendor Baru Gagal Disimpan" . $pesan);
                redirect("vendors");
            }
        } else {
            if ($this->data['is_can_create']) {
                $this->data['content']  = 'admin/vendors/create_v';
            } else {
                redirect('restrict');
            }
            $this->load->view('admin/layouts/page', $this->data);
        }
    }

    public function edit($id)
    {
        // redirect('vendors');
        $this->load->helper('url');
        $this->data['id'] = $this->uri->segment(3);

        if ($this->data['is_can_edit']) {
            $this->form_validation->set_rules('id', "Id", 'trim|required');

            if ($this->form_validation->run() === TRUE) {
                $data = [
                    'ttd_name' => $this->input->post('ttd_name'),
                    'ttd_pos' => $this->input->post('ttd_pos'),
                ];
                /*
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'email' => $this->input->post('email'),
                'address' => $this->input->post('address'),
                'start_contract' => $this->input->post('start_contract'),
                'end_contract' => $this->input->post('end_contract'),
                'no_contract' => $this->input->post('no_contract'),
                'is_margis' => $this->input->post('is_margis'),
                'department'    => $this->input->post('department'),
                'nama_direktur'    => $this->input->post('nama_direktur'),
                'no_telp'    => $this->input->post('no_telp'),
                'no_fax'    => $this->input->post('no_fax'),
                'updated_by' => $this->data['users']->id,
            );
            */

                /*
            $upload = 1;
            if($_FILES['file_contract']['name']){
                $config['upload_path']          = './file_contract/';
                $config['allowed_types']        = '*';
                $config['max_size']             = 20000;
                $random = rand(1000,9999);
                $do_upload = 'file_contract';
                $filename = pathinfo($_FILES['file_contract']["name"]);
                $extension = $filename['extension'];
                $config['file_name'] = $random."_".time().".".$extension;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload($do_upload)){
                    $data['file_contract'] = $config['file_name'];
                    if($this->input->post('old_file_contract')){
                        unlink($config['upload_path'].$this->input->post('old_file_contract'));
                    }
                    $upload = 1;
                }else{
                    $upload = 0;
                }
            }
            */
                //$contract_lama = $this->vendor_model->findvendor(array("vendor.id"=>$id))->no_contract;
                $update = $this->vendor_model->update($data, array("vendor.id" => $id));
                if ($update) {
                    /*
                if($contract_lama != $this->input->post('no_contract'))
                {
                    $this->load->model('vendor_contract_history_model');
                    $data_history = [
                        'vendor_id'     => $id,
                        'old_contract'  => $contract_lama,
                        'new_contract'  => $this->input->post('no_contract'),
                        'created_by'    => $this->session->userdata('user_id'),
                    ];
                    $this->vendor_contract_history_model->insert($data_history);
                }
                */

                    $this->session->set_flashdata('message', "Vendor Berhasil Diubah");
                    redirect("vendors", "refresh");
                } else {
                    $this->session->set_flashdata('message_error', "Vendor Gagal Diubah");
                    redirect("vendors", "refresh");
                }
            } else {
                $this->data['content']  = 'admin/vendors/edit_v';
                $data = $this->vendor_model->findvendor(array("vendor.id" => $this->data['id']));
                $this->data['name'] =   (!empty($data)) ? $data->name : "";
                $this->data['description'] =   (!empty($data)) ? $data->description : "";
                $this->data['email'] =   (!empty($data)) ? $data->email : "";
                $this->data['address'] =   (!empty($data)) ? $data->address : "";
                $this->data['start_contract'] =   (!empty($data)) ? $data->start_contract : "";
                $this->data['end_contract'] =   (!empty($data)) ? $data->end_contract : "";
                $this->data['file_contract'] =   (!empty($data)) ? $data->file_contract : "";
                $this->data['no_contract'] =   (!empty($data)) ? $data->no_contract : "";
                $this->data['is_margis']  =  (!empty($data)) ? $data->is_margis : "";
                $this->data['department']  =  (!empty($data)) ? $data->department : "";
                $this->data['nama_direktur'] =   (!empty($data)) ? $data->nama_direktur : "";
                $this->data['no_telp']  =  (!empty($data)) ? $data->no_telp : "";
                $this->data['no_fax']  =  (!empty($data)) ? $data->no_fax : "";
                $this->data['ttd_name']  =  (!empty($data)) ? $data->ttd_name : "";
                $this->data['ttd_pos']  =  (!empty($data)) ? $data->ttd_pos : "";

                $this->load->model('user_model');
                $data_user = $this->user_model->getOneBy(array("users.vendor_id" => $this->data['id']));
                $this->data['email_user'] =   (!empty($data_user)) ? $data_user->email : "";
                $this->data['firtname']  =  (!empty($data_user)) ? $data_user->first_name : "";
            }
        } else {
            redirect('restrict');
        }
        $this->load->view('admin/layouts/page', $this->data);
    }

    public function dataList()
    {
        $columns = array(
            0 => 'vendor.id',
            1 => 'vendor.name',
            2 => 'vendor.address',
            3 => 'vendor.email',
            4 => 'users.email',
            5 => 'vendor.no_telp',
            // 6=> 'vendor.is_deleted',
        );


        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $where = array();
        $limit = 0;
        $start = 0;
        $totalData = $this->vendor_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
        $searchColumn = $this->input->post('columns');
        if (!empty($searchColumn[3]['search']['value'])) {
            $value = $searchColumn[3]['search']['value'];
            $isSearchColumn = true;
            if ($value == 2) {
                $value = 0; //table need is_margis 0
            }
            $where['vendor.is_margis'] = $value;
            // echo "string";
        }

        if (!empty($this->input->post('search')['value'])) {
            $search_value = $this->input->post('search')['value'];
            $search = array(
                "vendor.name" => $search_value,
                "vendor.address" => $search_value,
                "vendor.email" => $search_value,
                "users.email" => $search_value,
                "vendor.no_telp" => $search_value,
                "vendor.nama_direktur" => $search_value
            );
            $totalFiltered = $this->vendor_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
        } else {
            $totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $datas = $this->vendor_model->getAllBy($limit, $start, $search, $order, $dir, $where);

        $new_data = array();
        if (!empty($datas)) {
            foreach ($datas as $key => $data) {

                $edit_url = "";
                $delete_url = "";

                if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
                    $edit_url =  "<a href='" . base_url() . "vendors/edit/" . $data->id . "' data-id='" . $data->id . "' style='color: white;'>
                    <div class='btn btn-sm btn-primary btn-blue btn-editview'>Ubah</div></a>";
                }
                if ($this->data['is_can_delete']) {
                    if ($data->is_deleted == 0) {
                        $delete_url = "<a href='#'
                            data-id='" . $data->id . "' data-isdeleted='" . $data->is_deleted . "' class='btn btn-sm btn-danger white delete'
                            url='" . base_url() . "vendors/destroy/" . $data->id . "/" . $data->is_deleted . "' >Non Aktifkan
                            </a>";
                    } else {
                        $delete_url = "<a href='#'
                            data-id='" . $data->id . "' data-isdeleted='" . $data->is_deleted . "' class='btn btn-sm btn-success white delete'
                             url='" . base_url() . "vendors/destroy/" . $data->id . "/" . $data->is_deleted . "'>Aktifkan
                            </a>";
                    }
                }
                $nestedData['id']               = $start + $key + 1;;
                $nestedData['name']             = $data->name;
                $nestedData['description']      = $data->description;
                $nestedData['address']          = $data->address;
                $nestedData['no_telp']          = $data->no_telp;
                $nestedData['email']          = $data->email;
                $nestedData['users_vendor_email']          = $data->users_vendor_email;
                $nestedData['nama_direktur']          = $data->nama_direktur;
                // $nestedData['is_margis']        = $data->is_margis == 0 ? 'Non Margis' : 'Margis';
                // $nestedData['start_contract']   = $data->start_contract;
                // $nestedData['end_contract']     = $data->end_contract;
                // $nestedData['no_contract']     = $data->no_contract;
                if ($data->is_deleted == 0) {
                    $nestedData['status']       = "Active";
                } else {
                    $nestedData['status']       = "Inactive";
                }
                $nestedData['action']             = $edit_url . ' ' . $delete_url;
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
            $update = $this->vendor_model->update($data, array("id" => $id));

            $response_data['data'] = $data;
            $response_data['status'] = true;
        } else {
            $response_data['msg'] = "ID Harus Diisi";
        }

        echo json_encode($response_data);
    }

    public function cek()
    {
        $id = $this->input->get('id');
        $query = $this->db->query("SELECT * FROM vendor WHERE id = '$id' ");
        //echo $this->db->last_query();
        echo json_encode($query->result());
        //foreach($query->result())
    }
}
