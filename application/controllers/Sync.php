<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Sync extends Admin_Controller {

    // public $postgre ;
    protected $cont = 'sync';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('sync_history_model');
        $this->data['cont'] = $this->cont;
    }

    public function index()
    {
        $this->load->helper('url');
        if($this->data['is_can_read']){
            $this->data['content'] = 'admin/sync/list_v';
        }else{
            redirect('restrict');
        }

        $this->load->view('admin/layouts/page',$this->data);
    }

    public function create()
    {
        $this->form_validation->set_rules('sync_code','Sync Code', 'required|trim');

        if($this->form_validation->run() === TRUE)
        {
            $sync_code = $this->input->post('sync_code');
            $this->load->model('Sync_code_model');
            $sync = $this->Sync_code_model->getOneBy(['id' => $sync_code]);
            if($sync === FALSE)
            {
                $this->session->set_flashdata('message_error', 'Jenis Sync tidak ditemukan');
                redirect($this->cont . '/create');
            }

            $sync_name = $sync->sync_name;
            $method = str_replace(' ','_',$sync_name);
            $method = strtolower($method);
            // klo jenis = vendor, panggil this->sync_vendor, dst
            if (! method_exists($this, 'show_' . $method))
            {
                $this->session->set_flashdata('message_error', 'Fungsi Sync ' . $sync_name . ' belum tersedia');
                redirect($this->cont . '/create');
            }

            redirect('sync/show_'.$method .'/'.$method);
        }

        $this->load->model('Sync_code_model');
        $this->data['sync_code'] = $this->Sync_code_model->get_dropdown([],NULL,'id', 'sync_name');
        $this->data['content'] = 'admin/sync/create_v';
        $this->load->view('admin/layouts/page',$this->data);
    }

    private function api_data($uri)
    {
        include('httpful.phar');
        $response = Httpful\Request::get($uri)
        ->sendsJson()
        ->addHeader('Accept', 'application/json')
        ->send();
        $data = $response->body->data;

        if (isset($response->body->total)) {
            $ret = [
                'total' => $response->body->total,
                'data' => $data,
            ];

            return $ret;
        } else {
            return $data;
        }

    }

    public function show_vendor($method)
    {
        $api_uri = 'https://scm.wika.co.id/sync/vendor';
        $vendor = $this->api_data($api_uri);

        $data = [];
        foreach ($vendor as $key => $value) {
            $scm = $value->vendor_id;
            $sql = $this->db->get_where('vendor', ['scm_id' => $scm])->row_array();
            if ($sql == NULL) {
                $data[] = [
                    'api_vendor_id'         => $value->vendor_id,
                    'api_vendor_name'       => $value->vendor_name,
                    'api_contact_name'      => $value->contact_name,
                    'api_contact_phone_no'  => $value->contact_phone_no,
                    'api_contact_email'     => $value->contact_email,
                    'api_address_street'    => $value->address_street,
                    'api_login_id'          => $value->login_id,
                    'api_password'          => $value->password,
                    'api_dir_name'          => $value->dir_name,
                    'api_dir_pos'           => $value->dir_pos,
                    'sql_name'              => '',
                    'sql_address'           => '',
                    'sql_email'             => '',
                    'sql_no_telp'           => '',
                    'sql_nama_direktur'     => '',
                    'sql_dir_pos'           => '',
                ];
            } else {
                $data[] = [
                    'api_vendor_id'         => $value->vendor_id,
                    'api_vendor_name'       => $value->vendor_name,
                    'api_contact_name'      => $value->contact_name,
                    'api_contact_phone_no'  => $value->contact_phone_no,
                    'api_contact_email'     => $value->contact_email,
                    'api_address_street'    => $value->address_street,
                    'api_login_id'          => $value->login_id,
                    'api_password'          => $value->password,
                    'api_dir_name'          => $value->dir_name,
                    'api_dir_pos'           => $value->dir_pos,
                    'sql_name'              => $sql['name'],
                    'sql_address'           => $sql['address'],
                    'sql_email'             => $sql['email'],
                    'sql_no_telp'           => $sql['no_telp'],
                    'sql_nama_direktur'     => $sql['nama_direktur'],
                    'sql_dir_pos'           => $sql['dir_pos'],
                ];
            }
        }

        $this->data['total_api_data'] = count($vendor);
        $this->data['data'] = $data;
        $this->data['ajax_url'] = 'sync_' . $method;
        $this->data['title'] = ucfirst($method);
        $this->data['content'] = 'admin/sync/'.$method.'_v';
        $this->load->view('admin/layouts/page',$this->data);
    }

    public function sync_vendor()
    {
        $total_sync = $this->input->post('total_api_data', true);
        $ajax = $this->input->post('data', true);
        if ($ajax == 'all_api') {
            $api_uri = 'https://scm.wika.co.id/sync/vendor';
            $arr_post = $this->api_data($api_uri);
        } else {
            $arr_post = [];
            foreach ($ajax as $key => $val) {
                $arr_post[] = (object)[
                'vendor_id' => $val[0],
                'vendor_name' => $val[1],
                'contact_name' => $val[2],
                'contact_phone_no' => $val[3],
                'contact_email' => $val[4],
                'address_street' => $val[5],
                'login_id' => $val[6],
                'password' => $val[7],
                'dir_name' => $val[8],
                'dir_pos' => $val[9],
                ];
            }
        }

        $this->load->model('Vendor_model');
        $arr_vendor = $this->Vendor_model->get_all_scm_vendor();
        $total_sync = $this->input->post('total_api_data', true);

        $success = $failed = 0;
        foreach ($arr_post as $k => $v) {
            if ( in_array($v->vendor_id, $arr_vendor) ) {
                // update
                $data_update_vendor = [
                'name'          => $v->vendor_name,
                'address'       => $v->address_street,
                'email'         => $v->contact_email,
                'no_telp'       => $v->contact_phone_no,
                'nama_direktur' => $v->dir_name,
                'dir_pos'       => $v->dir_pos,
                ];

                // cari keynya , keynya = primary key
                $vendor_id = array_search($v->vendor_id, $arr_vendor);
                $this->Vendor_model->update($data_update_vendor, ['id' => $vendor_id]);

                $data_update_users = [
                'username'  => $v->login_id,
                'password'  => $v->password,
                'scm_password'  => $v->password,
                'email'  => $v->login_id,
                'first_name'  => $v->vendor_name,
                'phone' => $v->contact_phone_no,
                ];

                $data_insert_users = [
                'ip_address' => '::1',
                'username'  => $v->login_id,
                'password'  => $v->password,
                'scm_password'  => $v->password,
                'email'  => $v->contact_email,
                'created_on' => time(),
                'active' => 1,
                'first_name'  => $v->vendor_name,
                'phone' => $v->contact_phone_no,
                'is_deleted' => 0,
                'vendor_id' => $vendor_id,
                ];

                $this->db->where('vendor_id', $vendor_id);
                $cek = $this->db->get('users');
                if($cek->num_rows() == 0)
                {
                    $this->db->insert('users',$data_insert_users);
                    $users_id = $this->db->insert_id();
                    // role vendor = 3;
                    $this->db->insert('users_roles', ['user_id' => $users_id, 'role_id' => 3]);
                }
                else
                {
                    $this->db->where('vendor_id', $vendor_id);
                    $this->db->update('users', $data_update_users);
                    $users_id = $cek->row()->id;

                    $cek_roles = $this->db->get_where('users_roles',['user_id' => $users_id]);
                    if($cek_roles->num_rows() == 0)
                    {
                        $this->db->insert('users_roles', ['user_id' => $users_id, 'role_id' => 3]);
                    }

                }

                $input = $users_id != '' ? true : false;

            } else {
                // insert
                $data_insert_vendor = [
                'name'          => $v->vendor_name,
                'address'       => $v->address_street,
                'email'         => $v->contact_email,
                'no_telp'       => $v->contact_phone_no,
                'nama_direktur' => $v->dir_name,
                'dir_pos'       => $v->dir_pos,
                'scm_id'        => $v->vendor_id,
                ];

                $vendor_id = $this->Vendor_model->insert($data_insert_vendor);

                $data_insert_users = [
                'ip_address' => '::1',
                'username'  => $v->login_id,
                'password'  => $v->password,
                'scm_password'  => $v->password,
                'email'  => $v->login_id,
                'created_on' => time(),
                'active' => 1,
                'first_name'  => $v->vendor_name,
                'phone' => $v->contact_phone_no,
                'is_deleted' => 0,
                'vendor_id' => $vendor_id,
                ];

                $this->db->insert('users', $data_insert_users);
                $users_id = $this->db->insert_id();
                // role vendor = 3;
                $this->db->insert('users_roles', ['user_id' => $users_id, 'role_id' => 3]);

                $input = $users_id != '' ? true : false;
            }

            if ($input) {
                $success++;
            } else {
                $failed++;
            }
        }

        $data_history = [
        'sync_code_id' => 1,
        'sync_all' => count($arr_post) == $total_sync ? 1 : 0,
        ];

        $this->db->insert('sync_history', $data_history);

        $result = [
        'status' => true,
        'success' => $success,
        'failed' => $failed,
        ];

        $this->session->set_flashdata('message', 'Sync Vendor berhasil !');
        echo json_encode($result);
    }

    public function show_kontrak($method)
    {
        // $this->load->model('Sync_history_model');
        // $sync_vendor = $this->Sync_history_model->get_last_sync(1);
        // $sync_departemen = $this->Sync_history_model->get_last_sync(3);
        //
        // $err_msg_vendor = '';
        // if ($sync_vendor['status'] == 0) {
        //     $err_msg_vendor = $sync_vendor['msg'] . "\n";
        // }
        // $err_msg_departemen = '';
        // if ($sync_departemen['status'] == 0) {
        //     $err_msg_departemen = $sync_departemen['msg'];
        // }
        //
        // if (($sync_vendor['status'] == 0) || ($sync_departemen['status'] == 0)) {
        //     $this->session->set_flashdata('message_error', $err_msg_vendor);
        //     $this->session->set_flashdata('message_error1', $err_msg_departemen);
        //     redirect($this->cont . '/create');
        //
        // } else {

        $api_uri = 'https://scm.wika.co.id/sync/kontrak';
        $kontrak = $this->api_data($api_uri);

        $data = [];
        foreach ($kontrak as $key => $value) {
            $scm = $value->id;
            $sql = $this->db->get_where('project', ['scm_id' => $scm])->row_array();
            if ($sql == NULL) {
                $data[] = [
                    'api_nama_spk_full' => $value->nama_spk_full,
                    'api_kode_spk'      => $value->kode_spk,
                    'api_updated_date'  => $value->updated_date,
                    'api_kddivisi'      => $value->kddivisi,
                    'api_divisiname'    => $value->divisiname,
                    'api_kd_pemilik'    => $value->kd_pemilik,
                    'api_nm_pemilik'    => $value->nm_pemilik,
                    'api_nomorkontrak'  => $value->nomorkontrak,
                    'api_tgl_mulai'     => $value->tgl_mulai,
                    'api_tgl_selesai'   => $value->tgl_selesai,
                    'api_id'            => $value->id,
                    'sql_name'          => '',
                    'sql_no_surat'      => '',
                    'sql_no_kontrak'    => '',
                    'sql_start_contract'=> '',
                ];
            } else {
                $data[] = [
                    'api_nama_spk_full' => $value->nama_spk_full,
                    'api_kode_spk'      => $value->kode_spk,
                    'api_updated_date'  => $value->updated_date,
                    'api_kddivisi'      => $value->kddivisi,
                    'api_divisiname'    => $value->divisiname,
                    'api_kd_pemilik'    => $value->kd_pemilik,
                    'api_nm_pemilik'    => $value->nm_pemilik,
                    'api_nomorkontrak'  => $value->nomorkontrak,
                    'api_tgl_mulai'     => $value->tgl_mulai,
                    'api_tgl_selesai'   => $value->tgl_selesai,
                    'api_id'            => $value->id,
                    'sql_name'          => $sql['name'],
                    'sql_no_surat'      => $sql['no_surat'],
                    'sql_no_kontrak'    => $sql['no_kontrak'],
                    'sql_start_contract'=> $sql['start_contract'],
                ];
            }
        }
        // }
        $this->data['total_api_data'] = count($kontrak);
        $this->data['data'] = $data;
        $this->data['ajax_url'] = 'sync_' . $method;
        $this->data['title'] = ucfirst($method);
        $this->data['content'] = 'admin/sync/'.$method.'_v';
        $this->load->view('admin/layouts/page',$this->data);
    }

    public function sync_kontrak()
    {
        $total_sync = $this->input->post('total_api_data', true);
        $ajax = $this->input->post('data', true);
        if ($ajax == 'all_api') {
            $api_uri = 'https://scm.wika.co.id/sync/kontrak';
            $arr_post = $this->api_data($api_uri);
        } else {
            $arr_post = [];
            foreach ($ajax as $key => $val) {
                $arr_post[] = (object)[
                    'nama_spk_full' => $val[0],
                    'kode_spk' => $val[1],
                    'updated_date' => $val[2],
                    'kddivisi' => $val[3],
                    'divisiname' => $val[4],
                    'kd_pemilik' => $val[5],
                    'nm_pemilik' => $val[6],
                    'nomorkontrak' => $val[7],
                    'tgl_mulai' => $val[8],
                    'tgl_selesai' => $val[9],
                    'id' => $val[10],
                ];
            }
        }

        $this->load->model('Project_model');
        $this->load->model('Vendor_model');
        $this->load->model('Groups_model');

        $arr_kontrak = $this->Project_model->get_all_scm_kontrak();
        $arr_vendor = $this->Vendor_model->get_all_scm_vendor();
        $arr_dept = $this->Groups_model->get_all_code_departemen();


        $success = $failed = 0;
        foreach ($arr_post as $k => $v) {
            $groups_id = array_search($v->kddivisi, $arr_dept);
            $vendor_id = array_search($v->kd_pemilik, $arr_vendor);
            $project_id = array_search($v->id, $arr_kontrak);
            echo "<pre>";
            // print_r($v->kddivisi);
            // print_r(true !== false);
            // print_r($project_id);
            // print_r($arr_dept);
            print_r(true === array_search($v->kd_pemilik, $arr_vendor));
            die;
            if ( in_array($v->id, $arr_kontrak) ){
                $data_update = [
                    'name'              => $v->nama_spk_full,
                    'no_surat'          => $v->kode_spk,
                    'tanggal'           => $v->updated_date,
                    'updated_by'        => 1,
                    'no_contract'       => $v->nomorkontrak,
                    'start_contract'    => $v->tgl_mulai,
                    'end_contract'      => $v->tgl_selesai,
                ];

                // klo kode_vendor dan kode_dept gak ada di mysql maka lakukan trans
                if ( true === array_search($v->kddivisi, $arr_dept)
                &&  true === array_search($v->kd_pemilik, $arr_vendor)
                )
                {
                    $groups_id = array_search($v->kddivisi, $arr_dept);
                    $vendor_id = array_search($v->kd_pemilik, $arr_vendor);
                    $data_update['group_id'] = $groups_id;
                    $data_update['vendor_id'] = $vendor_id;
                    // echo "update dong"; die;
                    $project_id = array_search($v->id, $arr_kontrak);
                    $this->db->where('id', $project_id);
                    $process_sync = $this->db->update('project', $data_update);
                }
                // echo "lewat aja 2"; die;
            } else {
                $data_insert = [
                    'name'              => $v->nama_spk_full,
                    'no_surat'          => $v->kode_spk,
                    'tanggal'           => $v->updated_date,
                    'created_by'        => 1,
                    'no_contract'       => $v->nomorkontrak,
                    'start_contract'    => $v->tgl_mulai,
                    'end_contract'      => $v->tgl_selesai,
                    'scm_id'            => $v->id
                ];

                // klo kode_vendor dan kode_dept gak ada di mysql maka lakukan trans
                if ( FALSE !== array_search($v->kddivisi, $arr_dept)
                &&  FALSE !== array_search($v->kd_pemilik, $arr_vendor)
                )
                {
                    $groups_id = array_search($v->kddivisi, $arr_dept);
                    $vendor_id = array_search($v->kd_pemilik, $arr_vendor);
                    $data_insert['group_id'] = $groups_id;
                    $data_insert['vendor_id'] = $vendor_id;
                    echo "jalan dong"; die;
                    $process_sync = $this->db->insert('project', $data_insert);
                }
                print_r($arr_dept);
                print_r($v->kddivisi);
                print_r($arr_vendor);
                print_r($v->kd_pemilik);
                echo "lewat aja 1"; die;
            }

            if ($process_sync) {
                $success++;
            } else {
                $failed++;
            }
        }

        $data_history = [
            'sync_code_id' => 2,
            'sync_all' => count($arr_post) == $total_sync ? 1 : 0,
        ];

        $this->db->insert('sync_history', $data_history);

        $result = [
            'status' => true,
            'success' => $success,
            'failed' => $failed,
        ];

        $this->session->set_flashdata('message', 'Sync Kontrak berhasil !');
        echo json_encode($result);
    }

    public function show_departemen($method)
    {
        $api_uri = 'https://scm.wika.co.id/sync/departement';
        $department = $this->api_data($api_uri);

        $data = [];
        foreach ($department as $val) {
            $scm = $val->dept_id;
            $sql = $this->db->get_where('groups', ['scm_id' => $scm])->row_array();
            if ($sql == NULL) {
                $data[] = [
                    'api_dept_id' => $val->dept_id,
                    'api_dept_name' => $val->dept_name,
                    'api_dep_code' => $val->dep_code,
                    'api_pos_id' => $val->pos_id,
                    'api_pos_name' => $val->pos_name,
                    'api_complete_name' => $val->complete_name,
                    'sql_scm_id' => $sql->scm_id,
                    'sql_name' => '',
                    'sql_gen_manager' => '',
                    'sql_role_id_gm' => '',
                    'sql_dept_code' => '',
                ];
            } else {
                $data[] = [
                    'api_dept_id' => $val->dept_id,
                    'api_dept_name' => $val->dept_name,
                    'api_dep_code' => $val->dep_code,
                    'api_pos_id' => $val->pos_id,
                    'api_pos_name' => $val->pos_name,
                    'api_complete_name' => $val->complete_name,
                    'sql_scm_id' => $sql['scm_id'],
                    'sql_name' => $sql['name'],
                    'sql_gen_manager' => $sql['general_manager'],
                    'sql_role_id_gm' => $sql['role_id_general_manager'],
                    'sql_dept_code' => $sql['departemen_code2'],
                ];
            }
        }

        $this->data['total_api_data'] = count($department);
        $this->data['data'] = $data;
        $this->data['ajax_url'] = 'sync_' . $method;
        $this->data['title'] = ucfirst($method);
        $this->data['content'] = 'admin/sync/'.$method.'_v';
        $this->load->view('admin/layouts/page',$this->data);
    }

    public function sync_departemen()
    {
        $total_sync = $this->input->post('total_api_data', true);
        $ajax = $this->input->post('data', true);
        if ($ajax == 'all_api') {
            $api_uri = 'https://scm.wika.co.id/sync/departement';
            $arr_post = $this->api_data($api_uri);
        } else {
            $arr_post = [];
            foreach ($ajax as $key => $val) {
                $arr_post[] = (object)[
                'dept_id' => $val[0],
                'dept_name' => $val[1],
                'dep_code' => $val[2],
                'pos_id' => $val[3],
                'pos_name' => $val[4],
                'complete_name' => $val[5],
                ];
            }
        }

        $this->load->model('Groups_model');
        $this->load->model('Roles_model');
        $arr_role = $this->Roles_model->get_all_scm_roles();
        $arr_dept = $this->Groups_model->get_all_scm_departemen();

        $success = $failed = 0;
        foreach ($arr_post as $k => $v) {
            // data ada, berarti diupdate
            if ( in_array($v->dept_id, $arr_dept) )
            {
                $data_update = [
                'name' => $v->dept_name,
                'general_manager' => $v->complete_name,
                'role_id_general_manager' => array_search($v->pos_id, $arr_role) !== FALSE ? array_search($v->pos_id, $arr_role) : NULL,
                'departemen_code2' => $v->dep_code
                ];

                // cari keynya , keynya = primary key
                $groups_id = array_search($v->dept_id, $arr_dept);
                $input = $this->Groups_model->update($data_update, ['id' => $groups_id]);
            }
            // data gak ada, insert !
            else
            {
                $data_insert = [
                'name' => $v->dept_name,
                'general_manager' => $v->complete_name,
                'scm_id' => $v->dept_id,
                'role_id_general_manager' => array_search($v->pos_id, $arr_role) !== FALSE ? array_search($v->pos_id, $arr_role) : NULL,
                'departemen_code2' => $v->dep_code
                ];

                $input = $this->Groups_model->insert($data_insert);
            }

            if ($input) {
                $success++;
            } else {
                $failed++;
            }
        }

        $data_history = [
        'sync_code_id' => 3,
        'sync_all' => count($arr_post) == $total_sync ? 1 : 0,
        ];

        $this->db->insert('sync_history', $data_history);

        $result = [
        'status' => true,
        'success' => $success,
        'failed' => $failed,
        ];

        $this->session->set_flashdata('message', 'Sync Departemen berhasil !');
        echo json_encode($result);
    }

    public function show_data_lelang($method)
    {
        $api_uri = 'https://scm.wika.co.id/sync/data_lelang';
        $data_lelang = $this->api_data($api_uri);

        $data = [];
        foreach ($data_lelang as $val) {
            $scm = $val->contract_item_id;
            $sql = $this->db->get_where('data_lelang', ['scm_id' => $scm])->row_array();
            if ($sql == NULL) {
                $data[] = [
                    'api_subject_work' => $val->subject_work,
                    'api_ptm_dept_name' => $val->ptm_dept_name,
                    'api_vendor_name' => $val->vendor_name,
                    'api_start_date' => $val->start_date,
                    'api_end_date' => $val->end_date,
                    'api_currency' => $val->currency,
                    'api_item_code' => $val->item_code,
                    'api_long_description' => $val->long_description,
                    'api_price' => $val->price,
                    'api_qty' => $val->qty,
                    'api_contract_item_id' => $val->contract_item_id,
                    'sql_departemen' => '',
                    'sql_vendor' => '',
                    'sql_harga' => '',
                    'sql_volume' => '',
                ];
            } else {
                $data[] = [
                    'api_subject_work' => $val->subject_work,
                    'api_ptm_dept_name' => $val->ptm_dept_name,
                    'api_vendor_name' => $val->vendor_name,
                    'api_start_date' => $val->start_date,
                    'api_end_date' => $val->end_date,
                    'api_currency' => $val->currency,
                    'api_item_code' => $val->item_code,
                    'api_long_description' => $val->long_description,
                    'api_price' => $val->price,
                    'api_qty' => $val->qty,
                    'api_contract_item_id' => $val->contract_item_id,
                    'sql_departemen' => $sql['departemen'],
                    'sql_vendor' => $sql['vendor'],
                    'sql_harga' => $sql['harga'],
                    'sql_volume' => $sql['volume'],
                ];
            }
        }

        $this->data['total_api_data'] = count($data_lelang);
        $this->data['data'] = $data;
        $this->data['ajax_url'] = 'sync_' . $method;
        $this->data['title'] = 'Data Lelang';
        $this->data['content'] = 'admin/sync/'.$method.'_v';
        $this->load->view('admin/layouts/page',$this->data);
    }

    public function sync_data_lelang()
    {
        $total_sync = $this->input->post('total_api_data', true);
        $ajax = $this->input->post('data', true);
        if ($ajax == 'all_api') {
            $api_uri = 'https://scm.wika.co.id/sync/data_lelang';
            $arr_post = $this->api_data($api_uri);
        } else {
            $arr_post = [];
            foreach ($ajax as $key => $val) {
                $arr_post[] = (object)[
                'subject_work' => $val[0],
                'ptm_dept_name' => $val[1],
                'vendor_name' => $val[2],
                'start_date' => $val[3],
                'end_date' => $val[4],
                'currency' => $val[5],
                'item_code' => $val[6],
                'long_description' => $val[7],
                'price' => $val[8],
                'qty' => $val[9],
                'contract_item_id' => $val[10],
                ];
            }
        }

        $this->load->model('Data_lelang_model');
        $arr_data_lelang = $this->Data_lelang_model->get_all_scm_data_lelang();

        $success = $failed = 0;
        foreach ($arr_post as $k => $v) {
            // data ada, berarti diupdate
            if ( in_array($v->contract_item_id, $arr_data_lelang) )
            {
                $data_update = [
                'departemen' => $v->ptm_dept_name,
                'kategori' => '',
                'nama' => $v->item_code,
                'spesifikasi' => $v->long_description,
                'harga' => $v->price,
                'vendor' => $v->vendor_name,
                'tgl_terkontrak' => $v->start_date,
                'tgl_akhir_kontrak' => $v->end_date,
                'volume' => $v->qty,
                'satuan' => '',
                'proyek_pengguna' => $v->subject_work,
                'lokasi' => '',
                'keterangan' => '',
                'currency' => $v->currency,
                ];

                // cari keynya , keynya = primary key
                $data_lelang_id = array_search($v->contract_item_id, $arr_data_lelang);
                $this->db->where('id', $data_lelang_id);
                $input = $this->db->update('data_lelang', $data_update);
            }
            // data gak ada, insert !
            else
            {
                $data_insert = [
                'departemen' => $v->ptm_dept_name,
                'kategori' => '',
                'nama' => $v->item_code,
                'spesifikasi' => $v->long_description,
                'harga' => $v->price,
                'vendor' => $v->vendor_name,
                'tgl_terkontrak' => $v->start_date,
                'tgl_akhir_kontrak' => $v->end_date,
                'volume' => $v->qty,
                'satuan' => '',
                'proyek_pengguna' => $v->subject_work,
                'lokasi' => '',
                'keterangan' => '',
                'currency' => $v->currency,
                'scm_id' => $v->contract_item_id
                ];

                $input = $this->db->insert('data_lelang', $data_insert);
            }

            if ($input) {
                $success++;
            } else {
                $failed++;
            }
        }

        $data_history = [
        'sync_code_id' => 4,
        'sync_all' => count($arr_post) == $total_sync ? 1 : 0,
        ];

        $this->db->insert('sync_history', $data_history);

        $result = [
        'status' => true,
        'success' => $success,
        'failed' => $failed,
        ];

        $this->session->set_flashdata('message', 'Sync Data Lelang berhasil !');
        echo json_encode($result);
    }

    public function show_role($method)
    {
        $api_uri = 'https://scm.wika.co.id/sync/role';
        $role = $this->api_data($api_uri);

        $data = [];
        foreach ($role as $key => $value) {
            $scm = $value->pos_id;
            $sql = $this->db->get_where('roles', ['scm_id' => $scm])->row_array();
            if ($sql == NULL) {
                $data[] = [
                    'api_pos_id' => $value->pos_id,
                    'api_pos_name' => $value->pos_name,
                    'api_dept_id' => $value->dept_id,
                    'api_district_id' => $value->district_id,
                    'api_job_title' => $value->job_title,
                    'sql_name' => '',
                    'sql_description' =>'',
                    'sql_scm_id' => '',
                ];
            } else {
                $data[] = [
                    'api_pos_id' => $value->pos_id,
                    'api_pos_name' => $value->pos_name,
                    'api_dept_id' => $value->dept_id,
                    'api_district_id' => $value->district_id,
                    'api_job_title' => $value->job_title,
                    'sql_name' => $sql['name'],
                    'sql_description' => $sql['description'],
                    'sql_scm_id' =>$sql['scm_id'],
                ];
            }
        }

        $this->data['total_api_data'] = count($role);
        $this->data['data'] = $data;
        $this->data['ajax_url'] = 'sync_' . $method;
        $this->data['title'] = ucfirst($method);
        $this->data['content'] = 'admin/sync/'.$method.'_v';
        $this->load->view('admin/layouts/page',$this->data);
    }

    public function sync_role()
    {
        $total_sync = $this->input->post('total_api_data', true);
        $ajax = $this->input->post('data', true);
        if ($ajax == 'all_api') {
            $api_uri = 'https://scm.wika.co.id/sync/role';
            $arr_post = $this->api_data($api_uri);
        } else {
            $arr_post = [];
            foreach ($ajax as $key => $val) {
                $arr_post[] = (object)[
                    'pos_id' => $val[0],
                    'pos_name' => $val[1],
                    'dept_id' => $val[2],
                    'district_id' => $val[3],
                    'job_title' => $val[4],
                ];
            }
        }

        $this->load->model('Roles_model');
        $arr_role = $this->Roles_model->get_all_scm_roles();

        $success = $failed = 0;
        foreach ($arr_post as $k => $v) {
            if ( in_array($v->pos_id, $arr_role))
            {
                $data_update = [
                    'name' => $v->pos_name,
                    'description' => $v->pos_name,
                ];

                // cari keynya , keynya = primary key
                $role_id = array_search($v->pos_id, $arr_role);
                $input = $this->Roles_model->update($data_update, ['id' => $role_id]);
            }
            else
            {
                $data_insert = [
                    'name' => $v->pos_name,
                    'description' => $v->pos_name,
                    'scm_id' => $v->pos_id,
                ];

                $input = $this->Roles_model->insert($data_insert);
            }

            if ($input) {
                $success++;
            } else {
                $failed++;
            }
        }

        $data_history = [
            'sync_code_id' => 5,
            'sync_all' => count($arr_post) == $total_sync ? 1 : 0,
        ];

        $this->db->insert('sync_history', $data_history);

        $result = [
            'status' => true,
            'success' => $success,
            'failed' => $failed,
        ];

        $this->session->set_flashdata('message', 'Sync Role berhasil !');
        echo json_encode($result);
    }

    public function show_user($method)
    {
        $this->load->model('Sync_history_model');
        $sync_role = $this->Sync_history_model->get_last_sync(5);
        $sync_departemen = $this->Sync_history_model->get_last_sync(3);

        $err_msg_role = '';
        if ($sync_role['status'] == 0) {
            $err_msg_role = $sync_role['msg'] . "\n";
        }
        $err_msg_departemen = '';
        if ($sync_departemen['status'] == 0) {
            $err_msg_departemen = $sync_departemen['msg'];
        }

        if (($sync_role['status'] == 0) || ($sync_departemen['status'] == 0)) {
            $this->session->set_flashdata('message_error', $err_msg_role);
            $this->session->set_flashdata('message_error1', $err_msg_departemen);
            redirect($this->cont . '/create');

        } else {

            $api_uri = 'https://scm.wika.co.id/sync/user';
            $user = $this->api_data($api_uri);

            $data = [];
            foreach ($user as $key => $value) {
                $scm = $value->id;
                $sql = $this->db->get_where('users', ['scm_id' => $scm])->row_array();
                if ($sql == null) {
                    $data[] = [
                        'api_id' => $value->id,
                        'api_complete_name' => $value->complete_name,
                        'api_pos_id' => $value->pos_id,
                        'api_pos_name' => $value->pos_name,
                        'api_user_name' => $value->user_name,
                        'api_email' => $value->email,
                        'api_password' => $value->password,
                        'api_dept_id' => $value->dept_id,
                        'sql_complete_name' => '',
                        'sql_user_name' => '',
                        'sql_email' => '',
                    ];
                } else {
                    $data[] = [
                        'api_id' => $value->id,
                        'api_complete_name' => $value->complete_name,
                        'api_pos_id' => $value->pos_id,
                        'api_pos_name' => $value->pos_name,
                        'api_user_name' => $value->user_name,
                        'api_email' => $value->email,
                        'api_password' => $value->password,
                        'api_dept_id' => $value->dept_id,
                        'sql_complete_name' => $sql['first_name'],
                        'sql_user_name' => $sql['username'],
                        'sql_email' => $sql['email'],
                    ];
                }
            }
        }

        $this->data['total_api_data'] = count($user);
        $this->data['data'] = $data;
        $this->data['ajax_url'] = 'sync_' . $method;
        $this->data['title'] = ucfirst($method);
        $this->data['content'] = 'admin/sync/'.$method.'_v';
        $this->load->view('admin/layouts/page',$this->data);
    }

    public function sync_user()
    {
        $total_sync = $this->input->post('total_api_data', true);
        $ajax = $this->input->post('data', true);
        if ($ajax == 'all_api') {
            $api_uri = 'https://scm.wika.co.id/sync/user';
            $arr_post = $this->api_data($api_uri);
        } else {
            $arr_post = [];
            foreach ($ajax as $key => $val) {
                $arr_post[] = (object)[
                    'id' => $val[0],
                    'complete_name' => $val[1],
                    'pos_id' => $val[2],
                    'pos_name' => $val[3],
                    'user_name' => $val[4],
                    'email' => $val[5],
                    'password' => $val[6],
                    'dept_id' => $val[7],
                ];
            }
        }

        $this->load->model('Groups_model');
        $this->load->model('User_model');
        $this->load->model('Roles_model');
        $arr_users = $this->User_model->get_all_scm_users();
        $arr_dept = $this->Groups_model->get_all_scm_departemen();
        $arr_roles = $this->Roles_model->get_all_scm_roles();

        $success = $failed = 0;
        foreach ($arr_post as $k => $v) {
            if ( in_array($v->id, $arr_users) )
            {
                $data_update = [
                    'username' => $v->user_name,
                    'email' => $v->email,
                    'first_name' => $v->complete_name,
                    'password'  => $v->password,
                    'scm_password' => $v->password,
                    'group_id' => array_search($v->dept_id, $arr_dept) !== FALSE ? array_search($v->dept_id, $arr_dept) : NULL,
                ];

                $users_id = array_search($v->id, $arr_users);
                $input = $this->User_model->update($data_update, ['id' => $users_id]);

                // ada beberapa row yang pos_id nya NULL
                if($v->pos_id != '')
                {
                    // role_id menyesuaikan dengan yang ada di mysql, dengan scm_id = post_id;
                    $role_id = array_search($v->pos_id, $arr_roles);
                    $this->db->where('user_id', $users_id);
                    $this->db->update('users_roles', ['user_id' => $users_id, 'role_id' => $role_id]);
                }
            }
            else
            {
                $data_insert = [
                    'ip_address' => '::1',
                    'username' => $v->user_name,
                    'password'  => $v->password,
                    'email' => $v->email,
                    'created_on' => time(),
                    'active' => 1,
                    'first_name' => $v->complete_name,
                    'is_deleted' => 0,
                    'scm_password' => $v->password,
                    'scm_id' => $v->id,
                    'group_id' => array_search($v->dept_id, $arr_dept) !== FALSE ? array_search($v->dept_id, $arr_dept) : NULL,
                ];

                $input = $this->db->insert('users', $data_insert);
                $users_id = $this->db->insert_id();

                // ada beberapa row yang pos_id nya NULL
                if($v->pos_id != '')
                {
                    // role_id menyesuaikan dengan yang ada di mysql, dengan scm_id = post_id;
                    $role_id = array_search($v->pos_id, $arr_roles);
                    $this->db->insert('users_roles', ['user_id' => $users_id, 'role_id' => $role_id]);
                }

            }

            if ($input) {
                $success++;
            } else {
                $failed++;
            }
        }

        $data_history = [
            'sync_code_id' => 6,
            'sync_all' => count($arr_post) == $total_sync ? 1 : 0,
        ];

        $this->db->insert('sync_history', $data_history);

        $result = [
            'status' => true,
            'success' => $success,
            'failed' => $failed,
        ];

        $this->session->set_flashdata('message', 'Sync User berhasil !');
        echo json_encode($result);
    }

    public function show_amandemen($method)
    {
        $api_uri = 'https://scm.wika.co.id/sync/amandemen';
        $amandemen = $this->api_data($api_uri);

        $data = [];
        foreach ($amandemen as $val) {
            $scm = $val->ammend_id;
            $sql = $this->db->get_where('data_lelang', ['scm_id' => $scm])->row_array();
            if ($sql == NULL) {
                $data[] = [
                    'api_ammend_id' => $val->ammend_id,
                    'api_contract_id' => $val->contract_id,
                    'api_start_date' => $val->start_date,
                    'api_end_date' => $val->end_date,
                    'api_currency' => $val->currency,
                    'api_contract_amount' => $val->contract_amount,
                    'api_ammend_description' => $val->ammend_description,
                    'api_ammend_reason' => $val->ammend_reason,
                    'api_status' => $val->status,
                    'api_current_approver_pos' => $val->current_approver_pos,
                    'api_ammended_date' => $val->ammended_date,
                    'api_contract_type' => $val->contract_type,
                    'api_contract_type_2' => $val->contract_type_2,
                    'api_contract_number' => $val->contract_number,
                    'api_rental_payment_period' => $val->rental_payment_period,
                    'api_rental_payment_unit' => $val->rental_payment_unit,
                    'api_rental_payment_term' => $val->rental_payment_term,
                    'api_current_approver_level' => $val->current_approver_level,
                    'api_subject_work' => $val->subject_work,
                    'api_scope_work' => $val->scope_work,
                    'api_ammend_doc' => $val->ammend_doc,
                    'sql_no_amandemen' => '',
                    'sql_start_contract' => '',
                    'sql_end_contract' => '',
                    'sql_harga' => '',
                ];
            } else {
                $data[] = [
                    'api_ammend_id' => $val->ammend_id,
                    'api_contract_id' => $val->contract_id,
                    'api_start_date' => $val->start_date,
                    'api_end_date' => $val->end_date,
                    'api_currency' => $val->currency,
                    'api_contract_amount' => $val->contract_amount,
                    'api_ammend_description' => $val->ammend_description,
                    'api_ammend_reason' => $val->ammend_reason,
                    'api_status' => $val->status,
                    'api_current_approver_pos' => $val->current_approver_pos,
                    'api_ammended_date' => $val->ammended_date,
                    'api_contract_type' => $val->contract_type,
                    'api_contract_type_2' => $val->contract_type_2,
                    'api_contract_number' => $val->contract_number,
                    'api_rental_payment_period' => $val->rental_payment_period,
                    'api_rental_payment_unit' => $val->rental_payment_unit,
                    'api_rental_payment_term' => $val->rental_payment_term,
                    'api_current_approver_level' => $val->current_approver_level,
                    'api_subject_work' => $val->subject_work,
                    'api_scope_work' => $val->scope_work,
                    'api_ammend_doc' => $val->ammend_doc,
                    'sql_no_amandemen' => $sql['no_amandemen'],
                    'sql_start_contract' => $sql['start_contract'],
                    'sql_end_contract' => $sql['end_contract'],
                    'sql_harga' => $sql['harga'],
                ];
            }
        }

        $this->data['total_api_data'] = count($amandemen);
        $this->data['data'] = $data;
        $this->data['ajax_url'] = 'sync_' . $method;
        $this->data['title'] = ucfirst($method);
        $this->data['content'] = 'admin/sync/'.$method.'_v';
        $this->load->view('admin/layouts/page',$this->data);
    }

    public function sync_amandemen()
    {
        $total_sync = $this->input->post('total_api_data', true);
        $ajax = $this->input->post('data', true);
        if ($ajax == 'all_api') {
            $api_uri = 'https://scm.wika.co.id/sync/amandemen';
            $arr_post = $this->api_data($api_uri);
        } else {
            $arr_post = [];
            foreach ($ajax as $key => $val) {
                $arr_post[] = (object)[
                    'ammend_id' => $val[0],
                    'contract_id' => $val[1],
                    'start_date' => $val[2],
                    'end_date' => $val[3],
                    'currency' => $val[4],
                    'contract_amount' => $val[5],
                    'ammend_description' => $val[6],
                    'ammend_reason' => $val[7],
                    'status' => $val[8],
                    'current_approver_pos' => $val[9],
                    'ammended_date' => $val[10],
                    'contract_type' => $val[11],
                    'contract_type_2' => $val[12],
                    'contract_number' => $val[13],
                    'rental_payment_period' => $val[14],
                    'rental_payment_unit' => $val[15],
                    'rental_payment_term' => $val[16],
                    'current_approver_level' => $val[17],
                    'subject_work' => $val[18],
                    'scope_work' => $val[19],
                    'ammend_doc' => $val[20],
                ];
            }
        }

        $this->load->model('Amandemen_model');
        $this->load->model('Project_model');
        $arr_amandemen = $this->Amandemen_model->get_all_scm_amandemen();
        $arr_kontrak = $this->Project_model->get_all_scm_kontrak();

        echo "<pre>";
        // print_r(array_search($v->contract_id, $arr_kontrak));
        print_r($arr_kontrak);
        die;

        $success = $failed = 0;
        foreach ($arr_post as $k => $v) {
            // data ada, berarti diupdate
            if( in_array($v->ammend_id, $arr_amandemen) )
            {
                $data_update = [
                    'no_amandemen' => $v->ammend_id,
                    'start_contract' => $v->start_date,
                    'end_contract' => $v->end_date,
                    'volume' => 0,
                    'harga' => $v->contract_amount,
                    'created_by' => 1,
                ];

                if ( array_search($v->contract_id, $arr_kontrak) !== FALSE)
                {
                    $project_id = array_search($v->contract_id, $arr_kontrak);
                    $data_update['id_project'] = $project_id;
                    $this->db->where('id', array_search($v->ammend_id, $arr_amandemen));
                    $input = $this->db->update('amandemen', $data_update);
                }
            }
            else
            {
                $data_insert = [
                    'no_amandemen' => $v->ammend_id,
                    'start_contract' => $v->start_date,
                    'end_contract' => $v->end_date,
                    'volume' => 0,
                    'harga' => $v->contract_amount,
                    'created_by' => 1,
                    'scm_id' => $v->ammend_id,
                ];

                if ( array_search($v->contract_id, $arr_kontrak) !== FALSE)
                {
                    $project_id = array_search($v->contract_id, $arr_kontrak);
                    $data_insert['id_project'] = $project_id;
                    $input = $this->db->insert('amandemen', $data_insert);
                }
            }

            if ($input) {
                $success++;
            } else {
                $failed++;
            }
        }

        $data_history = [
            'sync_code_id' => 7,
            'sync_all' => count($arr_post) == $total_sync ? 1 : 0,
        ];

        $this->db->insert('sync_history', $data_history);

        $result = [
            'status' => true,
            'success' => $success,
            'failed' => $failed,
        ];

        $this->session->set_flashdata('message', 'Sync Amandemen berhasil !');
        echo json_encode($result);
    }

    public function show_project($method)
    {
        $api_uri = 'https://scm.wika.co.id/sync/project';
        $project = $this->api_data($api_uri);

        $data = [];
        foreach ($project as $key => $value) {
            $sql = $this->db->get_where('project_new', ['no_spk' => $value->kode_spk])->row_array();
            if ($sql == NULL) {
                $data[] = [
                    'api_kode_spk' => $value->kode_spk,
                    'api_nama_spk' => $value->nama_spk,
                    'api_kddivisi' => $value->kddivisi,
                    'api_updated_date' => $value->updated_date,
                    'api_alamatproyek' => $value->alamatproyek,
                    'api_manager_proyek' => $value->manager_proyek,
                    'api_telp_manager' => $value->telp_manajer,
                    'sql_no_spk' => '',
                    'sql_name' => '',
                    'sql_departemen_id' =>'',
                    'sql_created_at' => '',
                    'sql_alamat' => '',
                    'sql_contact_person' => '',
                    'sql_no_hp' => '',
                ];
            } else {
                $data[] = [
                    'api_kode_spk' => $value->kode_spk,
                    'api_nama_spk' => $value->nama_spk,
                    'api_kddivisi' => $value->kddivisi,
                    'api_updated_date' => $value->updated_date,
                    'api_alamatproyek' => $value->alamatproyek,
                    'api_manager_proyek' => $value->manager_proyek,
                    'api_telp_manager' => $value->telp_manajer,
                    'sql_no_spk' =>$sql['no_spk'],
                    'sql_name' =>$sql['name'],
                    'sql_departemen_id' =>$sql['departemen_id'],
                    'sql_created_at' =>$sql['created_at'],
                    'sql_alamat' =>$sql['alamat'],
                    'sql_contact_person' =>$sql['contact_person'],
                    'sql_no_hp' =>$sql['no_hp'],
                ];
            }
        }

        $this->data['total_api_data'] = count($project);
        $this->data['data'] = $data;
        $this->data['ajax_url'] = 'sync_' . $method;
        $this->data['title'] = ucfirst($method);
        $this->data['content'] = 'admin/sync/'.$method.'_v';
        $this->load->view('admin/layouts/page',$this->data);
    }

    public function sync_project()
    {
        $total_sync = $this->input->post('total_api_data', true);
        $ajax = $this->input->post('data', true);
        if ($ajax == 'all_api') {
            $api_uri = 'https://scm.wika.co.id/sync/role';
            $arr_post = $this->api_data($api_uri);
        } else {
            $arr_post = [];
            foreach ($ajax as $key => $val) {
                $arr_post[] = (object)[
                    'kode_spk' => $val[0],
                    'nama_spk' => $val[1],
                    'kddivisi' => $val[2],
                    'updated_date' => $val[3],
                    'alamatproyek' => $val[4],
                    'manager_proyek' => $val[5],
                    'telp_manager' => $val[6],
                ];
            }
        }

        $arr_spk = [];
        $get_spk = $this->db->get('project_new')->result();
        foreach ($get_spk as $v) {
            $arr_spk[$v->id] = $v->no_spk;
        }

        $success = $failed = 0;
        foreach ($arr_post as $k => $v) {
            if ( in_array($v->kode_spk, $arr_spk))
            {
                $data_update = [
                    'name' => $v->nama_spk,
                    'departemen_id' => $this->db->get_where('groups', ['departemen_code2' => $v->kddivisi])->row('id'),
                    'created_at' => $v->updated_date,
                    // 'location_id' => $v->pos_name,
                    'no_spk' => $v->kode_spk,
                    'alamat' => $v->alamatproyek,
                    'contact_person' => $v->manager_proyek,
                    'no_hp' => $v->telp_manager,
                ];

                // cari keynya , keynya = primary key
                $no_spk = array_search($v->kode_spk, $arr_spk);
                $this->db->where('no_spk', $no_spk);
                $input = $this->db->update('project_new', $data_update);
            }
            else
            {
                $data_insert = [
                    'name' => $v->nama_spk,
                    'departemen_id' => $this->db->get_where('groups', ['departemen_code2' => $v->kddivisi])->row('id'),
                    'created_at' => $v->updated_date,
                    // 'location_id' => $v->pos_name,
                    'no_spk' => $v->kode_spk,
                    'alamat' => $v->alamatproyek,
                    'contact_person' => $v->manager_proyek,
                    'no_hp' => $v->telp_manager,
                ];

                $input = $this->db->insert('project_new', $data_insert);
            }

            if ($input) {
                $success++;
            } else {
                $failed++;
            }
        }

        $data_history = [
            'sync_code_id' => 8,
            'sync_all' => count($arr_post) == $total_sync ? 1 : 0,
        ];

        $this->db->insert('sync_history', $data_history);

        $result = [
            'status' => true,
            'success' => $success,
            'failed' => $failed,
        ];

        $this->session->set_flashdata('message', 'Sync Project berhasil !');
        echo json_encode($result);
    }

    public function show_prc_plan($method)
    {
        $c = "SELECT COUNT(id) total FROM sumber_data_pmcs";
        $rows = $this->db->query($c)->row('total');

        $api_uri = 'https://scm.wika.co.id/sync/prc_plan?row='.$rows;
        $res_prc_plan = $this->api_data($api_uri);

        $total_sync_yet = $res_prc_plan['total'];
        $prc_plan = $res_prc_plan['data'];
        
        $data = [];
        foreach ($prc_plan as $key => $value) {
            $sql = $this->db->get_where('sumber_data_pmcs', ['id_scm' => $value->id])->row_array();
            if ($sql == NULL) {
                $data[] = [
                    'api_id' => $value->id,
                    'api_spk_code' => $value->spk_code,
                    'api_project_name' => $value->project_name,
                    'api_dept_code' => $value->dept_code,
                    'api_dept_name' => $value->dept_name,
                    'api_group_smbd_code' => $value->group_smbd_code,
                    'api_group_smbd_name' => $value->group_smbd_name,
                    'api_smbd_type' => $value->smbd_type,
                    'api_smbd_code' => $value->smbd_code,
                    'api_smbd_name' => $value->smbd_name,
                    'api_unit' => $value->unit,
                    'api_smbd_quantity' => $value->smbd_quantity,
                    'api_periode_pengadaan' => $value->periode_pengadaan,
                    'api_price' => $value->price,
                    'api_total' => $value->total,
                    'api_coa_code' => $value->coa_code,
                    'api_coa_name' => $value->coa_name,
                    'api_currency' => $value->currency,
                    'api_user_id' => $value->user_id,
                    'api_user_name' => $value->user_name,
                    'api_periode_locking' => $value->periode_locking,
                    'api_created_date' => $value->created_date,
                    'api_updated_date' => $value->updated_date,
                    'api_is_matgis' => $value->is_matgis,
                    'sql_spk_code' => '',
                    'sql_project_name' => '',
                    'sql_smbd_name' =>'',
                ];
            } else {
                $data[] = [
                    'api_id' => $value->id,
                    'api_spk_code' => $value->spk_code,
                    'api_project_name' => $value->project_name,
                    'api_dept_code' => $value->dept_code,
                    'api_dept_name' => $value->dept_name,
                    'api_group_smbd_code' => $value->group_smbd_code,
                    'api_group_smbd_name' => $value->group_smbd_name,
                    'api_smbd_type' => $value->smbd_type,
                    'api_smbd_code' => $value->smbd_code,
                    'api_smbd_name' => $value->smbd_name,
                    'api_unit' => $value->unit,
                    'api_smbd_quantity' => $value->smbd_quantity,
                    'api_periode_pengadaan' => $value->periode_pengadaan,
                    'api_price' => $value->price,
                    'api_total' => $value->total,
                    'api_coa_code' => $value->coa_code,
                    'api_coa_name' => $value->coa_name,
                    'api_currency' => $value->currency,
                    'api_user_id' => $value->user_id,
                    'api_user_name' => $value->user_name,
                    'api_periode_locking' => $value->periode_locking,
                    'api_created_date' => $value->created_date,
                    'api_updated_date' => $value->updated_date,
                    'api_is_matgis' => $value->is_matgis,
                    'sql_spk_code' => $sql['spk_code'],
                    'sql_project_name' => $sql['project_name'],
                    'sql_smbd_name' =>$sql['smbd_name'],
                ];
            }
        }
        
        $this->data['total_sync_yet'] = number_format($total_sync_yet);
        $this->data['total_api_data'] = count($prc_plan);
        $this->data['data'] = $data;
        $this->data['ajax_url'] = 'sync_' . $method;
        $this->data['title'] = 'PRC Plan';
        $this->data['content'] = 'admin/sync/'.$method.'_v';
        $this->load->view('admin/layouts/page',$this->data);
    }

    public function sync_prc_plan()
    {
        $total_sync = $this->input->post('total_api_data', true);
        $total_sync_yet = $this->input->post('total_sync_yet', true);
        $ajax = $this->input->post('data', true);

        if ($ajax == 'all_api') {
            $rows = $this->db->get('sumber_data_pmcs')->num_rows();

            $api_uri = 'https://scm.wika.co.id/sync/prc_plan?row='.$rows;
            $res_prc_plan = $this->api_data($api_uri);

            $total_sync_yet = $res_prc_plan['total'];
            $arr_post = $res_prc_plan['data'];

        } else {
            $arr_post = [];
            foreach ($ajax as $key => $val) {
                $arr_post[] = (object)[
                    'id' => $val[0],
                    'spk_code' => $val[1],
                    'project_name' => $val[2],
                    'dept_code' => $val[3],
                    'dept_name' => $val[4],
                    'group_smbd_code' => $val[5],
                    'group_smbd_name' => $val[6],
                    'smbd_type' => $val[7],
                    'smbd_code' => $val[8],
                    'smbd_name' => $val[9],
                    'unit' => $val[10],
                    'smbd_quantity' => $val[11],
                    'periode_pengadaan' => $val[12],
                    'price' => $val[13],
                    'total' => $val[14],
                    'coa_code' => $val[15],
                    'coa_name' => $val[16],
                    'currency' => $val[17],
                    'user_id' => $val[18],
                    'user_name' => $val[19],
                    'periode_locking' => $val[20],
                    'created_date' => $val[21],
                    'updated_date' => $val[22],
                    'is_matgis' => $val[23],
                ];
            }
        }
        
        
        $success = $failed = 0;
        foreach ($arr_post as $k => $v) {
            
                $data_insert = [
                    'id_scm' => $v->id,
                    'spk_code' => $v->spk_code,
                    'project_name' => $v->project_name,
                    'dept_code' => $v->dept_code,
                    'dept_name' => $v->dept_name,
                    'group_smbd_code' => $v->group_smbd_code,
                    'group_smbd_name' => $v->group_smbd_name,
                    'smbd_type' => $v->smbd_type,
                    'smbd_code' => $v->smbd_code,
                    'smbd_name' => $v->smbd_name,
                    'unit' => $v->unit,
                    'smbd_quantity' => $v->smbd_quantity,
                    'periode_pengadaan' => $v->periode_pengadaan,
                    'price' => $v->price,
                    'total' => $v->total,
                    'coa_code' => $v->coa_code,
                    'coa_name' => $v->coa_name,
                    'currency' => $v->currency,
                    'user_id' => $v->user_id,
                    'user_name' => $v->user_name,
                    'periode_locking' => $v->periode_locking,
                    'created_date' => $v->created_date,
                    'updated_date' => $v->updated_date,
                    'is_matgis' => $v->is_matgis,
                ];

                $input = $this->db->insert('sumber_data_pmcs', $data_insert);
            

            if ($input) {
                $success++;
            } else {
                $failed++;
            }
        }

        $data_history = [
            'sync_code_id' => 9,
            'sync_all' => count($arr_post) == $total_sync ? 1 : 0,
        ];

        $this->db->insert('sync_history', $data_history);

        $result = [
            'status' => true,
            'success' => $success,
            'failed' => $failed,
        ];

        $this->session->set_flashdata('message', 'Sync PRC Plan berhasil !');
        echo json_encode($result);
    }

    public function show_vpi($method)
    {
        $api_uri = 'https://scm.wika.co.id/sync/vpi';
        $vpi = $this->api_data($api_uri);

        $data = [];
        foreach ($vpi as $key => $value) {
            $sql = $this->db->get_where('vpi_vendor', ['vk_id' => $value->vk_id])->row_array();
            if ($sql == NULL) {
                $data[] = [
                    'api_vk_id' => $value->vk_id,
                    'api_vvh_id' => $value->vvh_id,
                    'api_vk_score_total' => $value->vk_score_total,
                    'api_vvh_vendor_id' => $value->vvh_vendor_id,
                    'api_vendor_name' => $value->vendor_name,
                    'api_vvh_date' => $value->vvh_date,
                    'sql_vk_id' => '',
                    'sql_vvh_id' => '',
                    'sql_vk_score_total' =>'',
                    'sql_vvh_vendor_id' =>'',
                    'sql_vendor_name' =>'',
                ];
            } else {
                $data[] = [
                    'api_vk_id' => $value->vk_id,
                    'api_vvh_id' => $value->vvh_id,
                    'api_vk_score_total' => $value->vk_score_total,
                    'api_vvh_vendor_id' => $value->vvh_vendor_id,
                    'api_vendor_name' => $value->vendor_name,
                    'api_vvh_date' => $value->vvh_date,
                    'sql_vk_id' =>$sql['vk_id'],
                    'sql_vvh_id' =>$sql['vvh_id'],
                    'sql_vk_score_total' =>$sql['vk_score_total'],
                    'sql_vvh_vendor_id' =>$sql['vvh_vendor_id'],
                    'sql_vendor_name' =>$sql['vendor_name'],
                ];
            }
        }

        $this->data['total_api_data'] = count($vpi);
        $this->data['data'] = $data;
        $this->data['ajax_url'] = 'sync_' . $method;
        $this->data['title'] = ucfirst($method);
        $this->data['content'] = 'admin/sync/'.$method.'_v';
        $this->load->view('admin/layouts/page',$this->data);
    }

    public function sync_vpi()
    {
        $total_sync = $this->input->post('total_api_data', true);
        $ajax = $this->input->post('data', true);
        if ($ajax == 'all_api') {
            $api_uri = 'https://scm.wika.co.id/sync/vpi';
            $arr_post = $this->api_data($api_uri);
        } else {
            $arr_post = [];
            foreach ($ajax as $key => $val) {
                $arr_post[] = (object)[
                    'vk_id' => $val[0],
                    'vvh_id' => $val[1],
                    'vk_score_total' => $val[4],
                    'vvh_vendor_id' => $val[2],
                    'vendor_name' => $val[3],
                    'vvh_date' => $val[5],
                ];
            }
        }

        $arr_spk = [];
        $get_spk = $this->db->get('vpi_vendor')->result();
        foreach ($get_spk as $v) {
            $arr_spk[$v->vk_id] = $v->vk_id;
        }

        $success = $failed = 0;
        foreach ($arr_post as $k => $v) {
            if ( in_array($v->vk_id, $arr_spk))
            {
                $data_update = [
                    'vvh_id' => $v->vvh_id,
                    'vk_score_total' => $v->vk_score_total,
                    'vvh_vendor_id' => $v->vvh_vendor_id,
                    'vendor_name' => $v->vendor_name,
                    'vvh_date' => $v->vvh_date,
                ];

                // cari keynya , keynya = primary key
                $no_spk = array_search($v->vk_id, $arr_spk);
                $this->db->where('vk_id', $no_spk);
                $input = $this->db->update('vpi_vendor', $data_update);
            }
            else
            {
                $data_insert = [
                    'vvh_id' => $v->vvh_id,
                    'vk_score_total' => $v->vk_score_total,
                    // 'location_id' => $v->pos_name,
                    'vvh_vendor_id' => $v->vvh_vendor_id,
                    'vendor_name' => $v->vendor_name,
                    'vvh_date' => $v->vvh_date,
                    'vk_id' => $v->vk_id,
                    
                ];

                $input = $this->db->insert('vpi_vendor', $data_insert);
            }

            if ($input) {
                $success++;
            } else {
                $failed++;
            }
        }

        $data_history = [
            'sync_code_id' => 10,
            'sync_all' => count($arr_post) == $total_sync ? 1 : 0,
        ];

        $this->db->insert('sync_history', $data_history);

        $result = [
            'status' => true,
            'success' => $success,
            'failed' => $failed,
        ];

        $this->session->set_flashdata('message', 'Sync VPI berhasil !');
        echo json_encode($result);
    }

    public function cek_postgre($table, $col = NULL, $isi = NULL)
    {
        $where = [];
        if($col && $isi)
        {
            $where = [$col => $isi];
        }

        $q = $this->postgre->get_where($table, $where)->result();
        my_print_r($q);
    }

    public function dataList()
    {
        $columns = array(
            0 =>'sync_history.id',
            1 =>'sync_code.sync_name',
            2 =>'sync_history.created_at'
        );

        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $limit = 0;
        $start = 0;
        $totalData = $this->sync_history_model->getCountAllBy($limit,$start,$search,$order,$dir);


        if(!empty($this->input->post('search')['value'])){
            $search_value = $this->input->post('search')['value'];
            $search = array(

            );
            $totalFiltered = $this->sync_history_model->getCountAllBy($limit,$start,$search,$order,$dir);
        }else{
            $totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $datas = $this->sync_history_model->getAllBy($limit,$start,$search,$order,$dir);

        $new_data = array();
        if(!empty($datas))
        {

            foreach ($datas as $key=>$data)
            {
                $nestedData['id'] = $start+$key+1;
                $nestedData['created_at'] = tgl_indo($data->created_at, TRUE);
                $nestedData['sync_name'] = $data->sync_name;
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

    public function startsync(){

        echo "string";


    }

}
