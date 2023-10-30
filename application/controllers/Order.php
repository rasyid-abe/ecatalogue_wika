<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
//require_once BASEPATH . 'vendor/autoload.php';
//use Mpdf\Mpdf;
class Order extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('order_model');
        $this->load->model('order_product_model');
        $this->load->model('payment_method_model');
        $this->load->model('shipping_model');
        $this->load->model('ion_auth_model');
        $this->load->model('Groups_model');
        //$this->load->helper("file");
    }
    public function index()
    {
        $this->load->helper('url');
        if ($this->data['is_can_read']) {
            $this->load->model('Groups_model');
            $this->data['groups'] = $this->Groups_model->getAllById();
            $this->data['content'] = 'admin/order/list_v';
        } else {
            redirect('restrict');
        }
        $this->data['departemen'] = $this->Groups_model->get_dropdown();
        $this->data['payment_method'] = $this->payment_method_model->getAllById();
        $this->data['shipping'] = $this->shipping_model->getAllById();
        $this->load->view('admin/layouts/page', $this->data);
    }


    public function create()
    {
        redirect('order');
    }

    public function edit($id)
    {
        redirect('order');
    }

    public function dataList()
    {
        $columns = array(
            0 => 'order.id',
            1 => 'order.order_no',
            2 => 'order.perihal',
            3 => 'order_product.payment_mehod_name',
            4 => 'order.shipping_id',
            5 => 'order.total_price',
            6 => 'order.created_at',
        );


        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $where = array();
        if ($this->ion_auth->in_group(3)) {
            $where['order.vendor_id'] = $this->data['users']->vendor_id;
            $where['order.order_status in (2,4)'] = null;
            $where['order.is_approve_complete'] = 1;
        }
        //if(!$this->data['is_superadmin']){$where['order_product.vendor_id'] = $this->data['users']->vendor_id;}
        $limit = 0;
        $start = 0;
        $totalData = $this->order_model->getCountAllBy2($limit, $start, $search, $order, $dir, $where);

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;

        /*
        if(!empty($searchColumn[1]['search']['value'])){
            $value = $searchColumn[1]['search']['value'];
            $isSearchColumn = true;
            $search['order.order_no'] = $value;
        }
        */
        if (!empty($searchColumn[1]['search']['value'])) {
            $value = $searchColumn[1]['search']['value'];
            $isSearchColumn = true;
            // $search['project_new.name'] = $value;
            $filterjs = json_decode($value);

            if ($filterjs[0]->order_no) {
                $search['order.order_no'] = $filterjs[0]->order_no;
            }

            if ($filterjs[0]->nm_project) {
                $search['project_new.name'] = $filterjs[0]->nm_project;
            }

            if ($filterjs[0]->no_surat) {
                $search['order.no_surat'] = $filterjs[0]->no_surat;
            }

            if ($filterjs[0]->vendor_name) {
                $search['order.vendor_name'] = $filterjs[0]->vendor_name;
            }

            if ($filterjs[0]->location_name) {
                $search['order.location_name'] = $filterjs[0]->location_name;
            }

            if ($filterjs[0]->perihal) {
                $search['order.perihal'] = $filterjs[0]->perihal;
            }

            if ($filterjs[0]->departemen_id != '') {
                $where['project_new.departemen_id'] = $filterjs[0]->departemen_id;
            }

            if ($filterjs[0]->po_status == 1) {
                $where['order.order_status'] = 1;
                $where['order.is_approve_complete'] = 0;
            }
            if ($filterjs[0]->po_status == 3) {
                $where['order.order_status'] = 3;
                $where['order.is_approve_complete'] = 1;
            }
            if ($filterjs[0]->po_status == 0) {
                $where['order.order_status'] = 2;
                $where['order.is_approve_complete'] = 1;
            }

            if ($filterjs[0]->daterange != '') {
                $value = $filterjs[0]->daterange;
                $tgl = explode('-', $value);
                $where['DATE(order.created_at) >='] = date('Y-m-d', strtotime($tgl[0]));
                $where['DATE(order.created_at) <='] = date('Y-m-d', strtotime($tgl[1]));
            }

            // print_r($filterjs);
        }

        if (!empty($searchColumn[2]['search']['value'])) {
            $value = $searchColumn[2]['search']['value'];
            $isSearchColumn = true;
            $search['order.perihal'] = $value; // agar menjadi atau di sql code nya
        }

        if (!empty($searchColumn[3]['search']['value'])) {
            $value = $searchColumn[3]['search']['value'];
            $isSearchColumn = true;
            $where['order.payment_method_id'] = $value;
        }

        if (!empty($searchColumn[4]['search']['value'])) {
            $value = $searchColumn[4]['search']['value'];
            $isSearchColumn = true;
            $where['order.shipping_id'] = $value;
        }

        if (!empty($searchColumn[5]['search']['value'])) {
            $value = $searchColumn[5]['search']['value'];
            $isSearchColumn = true;
            $value = explode('-', $value);
            $awal = date('Y-m-d', strtotime($value[0]));
            $akhir = date('Y-m-d', strtotime($value[1]));
            //die(var_dump($awal));
            $where['order.created_at >='] = $awal;
            $where['order.created_at <='] = $akhir;
        }

        if (!empty($searchColumn[6]['search']['value'])) {
            $value = $searchColumn[6]['search']['value'];
            $isSearchColumn = true;
            $where['project_new.departemen_id'] = $value;
        }

        /*
        if(!empty($searchColumn[6]['search']['value'])){
            $value = $searchColumn[6]['search']['value'];
            $isSearchColumn = true;
            $where['order.created_at <='] = $value;
        }
        */

        if ($isSearchColumn) {
            $totalFiltered = $this->order_model->getCountAllBy2($limit, $start, $search, $order, $dir, $where);
        } else {
            $totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $datas = $this->order_model->getAllBy2($limit, $start, $search, $order, $dir, $where);

        $new_data = array();
        $this->order_rules = $this->db->get('approve_po_rules')->result();
        if (!empty($datas)) {
            foreach ($datas as $key => $data) {
                $this->db->select('(SELECT SUM(order_product.qty) * SUM(order_product.weight) FROM order_product WHERE order_product.order_no = ' . $data->order_no . ') AS tonase', FALSE);
                $berat = $this->db->get();


                $edit_url = "";
                $delete_url = "";
                $download_url = "";

                if ($data->order_status == 2 && file_exists('./pdf/po/' . $data->pdf_name) && $data->pdf_name != '') {
                    $download_url = '<a href="' . base_url() . 'pdf/po/' . $data->pdf_name . '" download class="btn btn-xs btn-primary">download pdf</a>';
                }

                $edit_url =  "<a href='" . base_url() . "order/detail/" . $data->order_no . "' data-id='" . $data->id . "' style='color: white;'><div class='btn btn-xs btn-primary btn-blue btn-editview '>Detail</div></a>";

                $nestedData['id'] = $start + $key + 1;
                $nestedData['order_no']         = 'V' . $data->order_no;
                $nestedData['perihal']          = $data->no_surat;
                $nestedData['full_name']        = $data->vendor_name;
                $nestedData['payment_method_name']        = $data->vendor_name;
                $nestedData['shipping_name']    = $data->project_name;
                $nestedData['tonase']    = rupiah($berat->row('tonase'), 2);
                $nestedData['total_price']      = "Rp. " . number_format($data->total_price, '0', ',', '.');
                $nestedData['created_at']       = $data->created_at;
                if ($data->order_status == 1) {
                    $nestedData['status']           = "<a style='color: white;'><div data-id='" . $data->order_no . "' class='btn btn-sm btn-primary btn-danger btn-editview btn-process'>Process</div></a>";
                } else if ($data->order_status == 2) {
                    $nestedData['status']           = "<a data-id='" . $data->id . "' style='color: white;'><div class='btn btn-sm btn-primary btn-success btn-editview btn-status'>On procces</div></a>";
                }
                $status = $this->_get_status_order($data);
                $nestedData['action']           = $edit_url . " " . $status . " " . $download_url;
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

    private function _get_status_order($data)
    {
        $rules = [];
        $ret = '';
        if (!isset($this->ion_auth->user($data->created_by)->row()->group_id)) {
            return $ret;
        }
        $group_id = $this->ion_auth->user($data->created_by)->row()->group_id;
        $list_approval = $this->db->get_where('approve_po_list', ['order_no' => $data->order_no])->result();
        foreach ($list_approval as $v) {
            $rules[$v->sequence] = $v->role_id;
        }

        if ($data->is_approve_complete == 1) {
            if ($data->order_status == 1) {
                $ret = "<a style='color: white;'><div data-id='" . $data->order_no . "' class='btn btn-xs btn-primary btn-danger btn-editview btn-process'>Process</div></a>";
            } else if ($data->order_status == 2) {
                $ret = "<a data-id='" . $data->id . "' style='color: white;'><div class='btn btn-xs btn-primary btn-success btn-editview btn-status'>On procces</div></a>";
            } else if ($data->order_status == 3) {
                $ret = "<a data-id='" . $data->id . "' style='color: white;'><div class='btn btn-xs btn-danger'>Canceled</div></a>";
            } else if ($data->order_status == 4) {
                $ret = "<a data-id='" . $data->id . "' style='color: white;'><div class='btn btn-xs btn-danger'>Revisi</div></a>";
            }

            return $ret;
        } else {
            if ($data->order_status == 3) {
                $ret = "<a data-id='" . $data->id . "' style='color: white;'><div class='btn btn-xs btn-danger'>Canceled</div></a>";
            } else if ($data->order_status == 4) {
                $ret = "<a data-id='" . $data->id . "' style='color: white;'><div class='btn btn-xs btn-danger'>Revisi</div></a>";
            } else {
                $role_id = isset($rules[$data->approve_sequence + 1]) ? $rules[$data->approve_sequence + 1] : 1;
                if ($this->data['is_superadmin'] || $this->ion_auth->in_group($role_id)) {
                    $ret = "<a href='javascript:;'
                    url='" . base_url() . "order/approve_po/" . $data->order_no . "/" . $role_id . "'
                    class='btn btn-xs btn-warning approve' >Approve
                    </a>";
                    $ret .= " <a href='javascript:;'
                    url='" . base_url() . "order/reject/" . $data->order_no . "/" . $role_id . "'
                    class='btn btn-xs btn-danger reject'>Reject
                    </a>";
                    //$ret = 'approve ke ' . ($data->approve_sequence + 1);
                }
            }
        }

        return $ret;
    }

    public function copy_data($order_no)
    {
        $this->load->library('curl');
        $this->load->model('Order_transportasi_model');
        $this->load->model('Order_asuransi_model');
        $q = $this->order_model->detail_order(['a.order_no' => $order_no]);
        $a = $this->order_model->detail_user(['a.order_no' => $order_no, 'a.sequence' => '2']);
        $u = $this->order_model->detail_user_role(['a.id' => $q->created_by]);
        $totalproduct = $this->order_product_model->getBiayaProduct(['order_no' => $order_no]);
        $product = $this->order_product_model->getAllDataById(['order_product.order_no' => $order_no]);
        // $totaltransport = $this->Order_transportasi_model->getBiayaTransport(['order_transportasi.order_no' => $order_no]);
        // $totalasuransi = $this->Order_asuransi_model->getBiayaAsuransi(['order_asuransi.order_no' => $order_no]);
        // $ppn = $totalproduct * 10 / 100;
        $pph = $totalproduct * 1.5 / 100;

        $data = array(
            'creator_employee'       =>  $q->created_by,
            'creator_pos'       =>  $u->role_name,
            'contract_id'       =>  $q->kontrak_id,
            'vendor_id'       =>  $q->scm_id,
            'vendor_name'       =>  $q->vendor_name,
            'created_date'       =>  $q->created_at,
            'start_contract'       =>  $q->start_contract,
            'end_contract'       =>  $q->end_contract,
            'nilai_kontrak'       =>  $q->nilai_kontrak,
            'no_spk'       =>  $q->no_spk,
            'project_name'       =>  $q->project_name,
            'tgl_diambil'       =>  $q->tgl_diambil,
            'no_surat'       =>  $q->no_surat,
            'catatan'       =>  $q->catatan,
            'approved_date'       =>  $a->updated_at,
            'current_approver_pos'       =>  $a->role_name,
            'current_approver_id'       =>  $a->updated_by,
            'departemen_code'       =>  $a->departemen_code,
            'departemen_id'       =>  $a->departemen_id,
            'file_contract'       =>  $a->file_contract,
            //    'si_total'       =>  $totaltransport,
            //    'sj_total'       =>  $totalasuransi,
            //    'invoice_total'       =>  $totalproduct,
            'sppm_total'       =>  $totalproduct - $pph,
            'product'       =>  $product,
        );
        $this->curl->simple_post('http://localhost/escm_dev/auth/inject_wo', json_encode($data));
    }
    public function approve_po($order_no, $role_id)
    {
        // untuk memastikan klo yang approve adalah role yang bersangkutan
        // get _group_id
        $alasan = $this->input->post('alasan');
        $keterangan = $this->input->post('keterangan');

        $group_id = NULL;
        $q = $this->order_model->getOneBy(['order_no' => $order_no]);
        if ($q) {
            $group_id = $this->ion_auth->user($q->created_by)->row()->group_id;
        }

        if (!$this->data['is_superadmin']) {
            $role_id = $this->ion_auth->get_users_groups()->row()->id;
        }

        $data_update_list = [
            'status_approve' => 1,
            'updated_by' => $this->data['users']->id,
        ];

        //$jml_yg_harus_approve = $this->db->select("count(*) as count")->where('departemen_id', $group_id)->get('approve_po_rules')->row()->count;
        $jml_yg_harus_approve = $this->db->select("count(*) as count")->where('order_no', $order_no)->get('approve_po_list')->row()->count;

        $this->db->trans_start();
        $this->db->where('order_no', $order_no)
            ->where('role_id', $role_id)
            ->update('approve_po_list', $data_update_list);

        $jml_yg_sdh_approve = $this->db->select("count(*) as count")
            ->where('order_no', $order_no)
            ->where('status_approve', 1)->get('approve_po_list')->row()->count;

        $data_update_order = [
            'approve_sequence' => $jml_yg_sdh_approve
        ];

        // tambah log cancel
        $data_cancel = [
            'user_id' => $this->data['users']->id,
            'no_order' => $order_no,
            'status_cancel' => 1,
            'id_alasan' => $alasan,
            'keterangan' => $keterangan,
        ];
        $this->db->insert('log_cancel_po', $data_cancel);

        $data_aktifitias_user = [
            'user_id' => $this->data['users']->id,
            'description' => 'Approve PO. No PO : ' . $order_no,
            'id_reff' => $order_no,
            // category 2 = order
            'aktifitas_category' => 2,
        ];
        $this->db->insert('aktifitas_user', $data_aktifitias_user);
        // approve sudah kirim notif ke vendor dan ke users
        if ($jml_yg_sdh_approve == $jml_yg_harus_approve) {
            $data_update_order['is_approve_complete'] = 1;
            $data_update_order['generatepdf_time'] = $this->data['now_datetime'];
            $this->db->where('order_no', $order_no)->update('order', $data_update_order);

            // untuk update time pdf_transportasi
            $this->load->model('Order_transportasi_model');
            if ($this->Order_transportasi_model->getOneBy(['order_no' => $order_no]) !== FALSE) {
                $this->Order_transportasi_model->update(['generatepdf_time' => $this->data['now_datetime']], ['order_no' => $order_no]);
            }

            $this->curl_order_set($order_no);
            $pesan = "No Order " . $order_no . " dengan no surat " . $q->no_surat . " Sudah di approve";
            $data_notif = [
                [
                    'id_pengirim' => 1,
                    'id_penerima' => $q->created_by,
                    'deskripsi' => $pesan
                ],
            ];
            sendsms($q->phone, $pesan);
            $q_vendor = $this->db->get_where('users', ['vendor_id' => $q->vendor_id]);
            if ($q_vendor->num_rows() > 0) {
                $data_notif[] = [
                    'id_pengirim' => 1,
                    'id_penerima' => $q_vendor->row()->id,
                    'deskripsi' => $pesan
                ];
                sendsms($q_vendor->row()->phone, $pesan);
                // send_email_po($q_vendor->email, $q->pdf_name, $order_no, []);
            }
            $this->db->insert_batch('notification', $data_notif);

            // insert data ke db postgre
            $this->copy_data($order_no);
        }
        // approve PO, masih ada proses selanjutnya, kirim ke notif ke role berikutnya
        else {
            //$q_role = $this->db->get_where('approve_po_rules',['departemen_id' => $group_id, 'sequence' => ($jml_yg_sdh_approve + 1)]);
            // library buat kirim email;
            $this->load->library('email_po');
            $q_role = $this->db->get_where('approve_po_list', ['order_no' => $order_no, 'sequence' => ($jml_yg_sdh_approve + 1)]);
            if ($q_role->num_rows() > 0) {
                $role_id = $q_role->row()->role_id;
                $message = "No Order " . $order_no . " dengan no surat " . $q->no_surat . " Perlu di approve";
                send_notifikasi_by_role_id($role_id, $message);
                send_sms_by_role_id($role_id, $message);
                $this->email_po->sendDetailPOByRoleId($role_id, $order_no);
            }
            $this->db->where('order_no', $order_no)->update('order', $data_update_order);
        }


        $this->db->trans_complete();

        $ret['status'] = $this->db->trans_status();
        ob_end_clean();
        echo json_encode($ret);
    }
    public function get_alasan()
    {
        $status = $this->input->post('status', true);
        $data = $this->db->get_where('alasan_cancel', ['jenis' => $status])->result_array();
        echo json_encode($data);
    }
    public function reject($order_no, $role_id)
    {
        $alasan = $this->input->post('alasan');
        $keterangan = $this->input->post('keterangan');

        $q = $this->order_model->getOneBy(['order_no' => $order_no]);
        // untuk memastikan klo yang approve adalah role yang bersangkutan
        if (!$this->data['is_superadmin']) {
            $role_id = $this->ion_auth->get_users_groups()->row()->id;
        }

        $data_update_list = [
            'status_approve' => 2,
            'updated_by' => $this->data['users']->id,
        ];

        $this->load->model('Order_product_model');
        $order_products = $this->Order_product_model->getAllById(['order_no' => $order_no]);
        $list_product = [];
        if ($order_products) {
            foreach ($order_products as $k => $v) {
                $list_product[] = $v->product_id;
            }
        }

        $this->load->model('Product_model');
        $projects = $this->Product_model->cek_is_terkontrak($list_product, TRUE);
        $product_project = [];
        if ($projects) {
            foreach ($projects as $k => $v) {
                $product_project[$v->product_id] = $v->project_id;
            }
        }

        $project_volume = [];
        if ($order_products) {
            $x = 0;
            foreach ($order_products as $k => $v) {
                $ix = $product_project[$v->product_id];
                if (!array_key_exists($ix, $project_volume)) {
                    $project_volume[$ix] = 0;
                }
                $project_volume[$ix] += round($v->weight * $v->qty, 4);
            }
        }

        $this->db->trans_start();

        foreach ($project_volume as $k => $v) {
            $this->db->set('volume_sisa', 'volume_sisa + ' . round($v, 4), FALSE)
                ->set('volume_terpakai', 'volume_terpakai - ' . round($v, 4), FALSE)
                ->where('id', $k)
                ->update('project');
        }

        $this->db->where('order_no', $order_no)
            ->where('role_id', $role_id)
            ->update('approve_po_list', $data_update_list);

        // tambah log cancel
        $data_cancel = [
            'user_id' => $this->data['users']->id,
            'no_order' => $order_no,
            'status_cancel' => 2,
            'id_alasan' => $alasan,
            'keterangan' => $keterangan,
        ];
        $this->db->insert('log_cancel_po', $data_cancel);

        // tambah aktifitas_user
        $data_aktifitias_user = [
            'user_id' => $this->data['users']->id,
            'description' => 'Reject PO. No PO : ' . $order_no,
            'id_reff' => $order_no,
            // category 2 = order
            'aktifitas_category' => 2,
        ];
        $this->db->insert('aktifitas_user', $data_aktifitias_user);

        $this->db->where('order_no', $order_no)->update('order', ['is_approve_complete' => 1, 'order_status' => 3]);
        $pesan = "No Order " . $order_no . " dengan no surat " . $q->no_surat . " direject";
        $data_notif[] = [
            'id_pengirim' => 1,
            'id_penerima' => $q->created_by,
            'deskripsi' => $pesan,
        ];
        $this->db->insert_batch('notification', $data_notif);
        sendsms($q->phone, $pesan);

        $this->db->trans_complete();

        $ret['status'] = $this->db->trans_status();
        ob_end_clean();
        echo json_encode($ret);
    }

    public function revisi($order_no, $role_id)
    {
        $alasan = $this->input->post('alasan');
        $keterangan = $this->input->post('keterangan');

        $q = $this->order_model->getOneBy(['order_no' => $order_no]);
        // untuk memastikan klo yang approve adalah role yang bersangkutan
        if (!$this->data['is_superadmin']) {
            $role_id = $this->ion_auth->get_users_groups()->row()->id;
        }

        $data_update_list = [
            'status_approve' => 0,
            //    'updated_by' => $this->data['users']->id,
        ];

        $this->load->model('Order_product_model');
        $order_products = $this->Order_product_model->getAllById(['order_no' => $order_no]);
        $list_product = [];
        if ($order_products) {
            foreach ($order_products as $k => $v) {
                $list_product[] = $v->product_id;
            }
        }

        $this->load->model('Product_model');
        $projects = $this->Product_model->cek_is_terkontrak($list_product, TRUE);
        $product_project = [];
        if ($projects) {
            foreach ($projects as $k => $v) {
                $product_project[$v->product_id] = $v->project_id;
            }
        }

        $project_volume = [];
        if ($order_products) {
            $x = 0;
            foreach ($order_products as $k => $v) {
                $ix = $product_project[$v->product_id];
                if (!array_key_exists($ix, $project_volume)) {
                    $project_volume[$ix] = 0;
                }
                $project_volume[$ix] += round($v->weight * $v->qty, 4);
            }
        }

        $this->db->trans_start();

        foreach ($project_volume as $k => $v) {
            $this->db->set('volume_sisa', 'volume_sisa + ' . round($v, 4), FALSE)
                ->set('volume_terpakai', 'volume_terpakai - ' . round($v, 4), FALSE)
                ->where('id', $k)
                ->update('project');
        }

        $this->db->where('order_no', $order_no)
            ->update('approve_po_list', $data_update_list);

        // tambah log cancel
        $data_cancel = [
            'user_id' => $this->data['users']->id,
            'no_order' => $order_no,
            'status_cancel' => 3,
            'id_alasan' => $alasan,
            'keterangan' => $keterangan,
        ];
        $this->db->insert('log_cancel_po', $data_cancel);

        // tambah aktifitas_user
        $data_aktifitias_user = [
            'user_id' => $this->data['users']->id,
            'description' => 'Reject PO. No PO : ' . $order_no,
            'id_reff' => $order_no,
            // category 2 = order
            'aktifitas_category' => 2,
        ];
        $this->db->insert('aktifitas_user', $data_aktifitias_user);

        $this->db->where('order_no', $order_no)->update('order', ['order_status' => 4]);
        $pesan = "No Order " . $order_no . " dengan no surat " . $q->no_surat . " direvisi";
        $data_notif[] = [
            'id_pengirim' => 1,
            'id_penerima' => $q->created_by,
            'deskripsi' => $pesan,
        ];
        $this->db->insert_batch('notification', $data_notif);
        sendsms($q->phone, $pesan);

        $this->db->trans_complete();

        $ret['status'] = $this->db->trans_status();
        $ret['url'] = base_url() . "order";
        ob_end_clean();
        echo json_encode($ret);
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
            $this->load->model("order_model");
            $data = array(
                'is_deleted' => ($is_deleted == 1) ? 0 : 1
            );
            $update = $this->order_model->update($data, array("id" => $id));

            $response_data['data'] = $data;
            $response_data['status'] = true;
        } else {
            $response_data['msg'] = "ID Harus Diisi";
        }

        echo json_encode($response_data);
    }

    public function detail()
    {
        $order_no = $this->uri->segment(3);
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        } else {

            $this->data['order_product'] = $this->order_product_model->getAllDataById(['order_product.order_no' => $order_no]);
            $getapprovename = $this->order_model->getapprovename(['order_no' => $order_no]);
            $array_approval = [];
            if ($getapprovename) {
                $index = 0;
                foreach ($getapprovename as $key => $value) {
                    $array_approval[$value->role_id]['approve_name'][$index] = $value->approval_name;
                    if ($value->updated_by) {
                        $array_approval[$value->role_id]['approve_acc'][$index] = $value->approval_name;
                    }
                    $array_approval[$value->role_id]['user_approve_name'] = $value->user_approve_name;
                    $array_approval[$value->role_id]['status_approve'] = $value->status_approve;
                    $index++;
                }
            }
            if ($this->data['order_product']) {
                $this->data['order_no'] = $order_no;
                $this->data['order'] = $this->order_model->getDataOneBy(['order.order_no' => $order_no]);
                $this->data['detail_order'] = $this->order_model->detail_order(['a.order_no' => $order_no]);
                $list_approval = $this->db->get_where('approve_po_list', ['order_no' => $order_no])->row();
                $this->data['role_id'] = $list_approval->role_id;
                $cekApporval = $this->db->get_where('order', ['order_no' => $order_no])->row();
                $this->data['cekApporval'] = $cekApporval->is_approve_complete;
                $this->data['cekStatusOrder'] = $cekApporval->order_status;
                $this->data['cekRole'] = $this->db->get_where('approve_po_list', ['order_no' => $order_no, 'sequence' => $cekApporval->approve_sequence + 1])->row();
                $this->data['list_approval_name'] = $array_approval;

                // untuk order_transportasi
                $this->load->model('Order_transportasi_model');
                $this->data['orderTransportasi'] = $this->Order_transportasi_model->getDataPdfTransport(['order_transportasi.order_no' => $order_no]);
                $this->data['orderTransportasiDetail'] = $this->Order_transportasi_model->getDataPekerjaan(['order_no' => $order_no]);

                // order Asuransi
                $this->load->model('Order_asuransi_model');
                $this->data['orderAsuransi'] = $this->Order_asuransi_model->getDataPdfAsuransi(['order_asuransi.order_no' => $order_no]);
                $this->data['orderAsuransiDetail'] = $this->Order_asuransi_model->getAllDataById(['order_asuransi_d.order_no' => $order_no]);
                if (!$this->data['detail_order']) {
                    redirect('ErrorPage');
                }

                $query = $this->db->query('select * from alasan_cancel where jenis = 2');
                $this->data['alasans'] = $query->result();

                $log_cancel = $this->db->query("select lc.*,ac.alasan  from log_cancel_po lc left join alasan_cancel ac on lc.id_alasan=ac.id  where no_order = $order_no");
                $this->data['log_cancel'] = $log_cancel->result();

                $this->data['content']  = 'admin/order/detail';
                $this->load->view('admin/layouts/page', $this->data);
            } else {
                $this->load->view('errors/html/error_404');
            }
        }
    }

    public function set()
    {
        $order_no = $this->input->post('order_id');
        $data = array(
            'dp' => $this->input->post('dp'),
            //'no_surat'=> $this->input->post('no_surat'),
            'order_status' => 2,
        );

        $update = $this->order_model->update($data, ['order_no' => $order_no]);
        if ($update) {
            $this->generatepdf($order_no);
            $this->session->set_flashdata('message', "Data Order Berhasil Diubah");
            redirect("order", "refresh");
        } else {
            $this->session->set_flashdata('message_error', "Data Order Gagal Diubah");
            redirect("order", "refresh");
        }
    }

    public function curl_order_set($order_no)
    {
        $data = array(
            'order_status' => 2,
        );

        $update = $this->order_model->update($data, ['order_no' => $order_no]);
        $this->generatepdf($order_no);
        $this->load->model('Order_transportasi_model');
        if ($this->Order_transportasi_model->getOneBy(['order_no' => $order_no]) !== FALSE) {
            $this->generatepdfTransport($order_no);
        }
    }

    public function generatepdfTransport($order_no, $generate_ulang = 0)
    {
        $this->load->model('Order_transportasi_model');
        $dataOrder = $this->Order_transportasi_model->getDataPdfTransport(['order_transportasi.order_no' => $order_no]);
        $this->data['dataPekerjaan'] = $this->Order_transportasi_model->getDataPekerjaan(['order_transportasi_d.order_no' => $order_no]);
        $data = $this->db->get_where('order', ['order_no' => $order_no])->row();
        $this->data['dataOrder'] = $dataOrder;

        $this->data['tgl_kontrak']          =   tgl_indo($dataOrder->tgl_kontrak);
        $this->data['no_kontrak_transport'] =   $dataOrder->no_kontrak_transport . ($dataOrder->no_amandemen != '' ? '-Amd' . $dataOrder->no_amandemen : '');
        $this->data['nama_project']         =   $dataOrder->nama_project;
        $this->data['nama_vendor']          =   $dataOrder->nama_vendor;
        $this->data['nama_direktur']        =   $dataOrder->nama_direktur;
        $this->data['jabatan']              =   $dataOrder->jabatan;
        $this->data['departemen']           =   $dataOrder->departemen;
        $this->data['gm']                   =   $dataOrder->gm;
        $this->data['dataOrder']            =   $dataOrder;
        $this->data['tgl_approve']          =   tgl_indo($dataOrder->generatepdf_time);
        $this->data['tgl_order']          =   tgl_indo($data->created_at);
        $this->data['order_no']             =   $order_no;
        $this->load->model('Order_model');
        $this->data['detail_order'] = $this->Order_model->detail_order(['a.order_no' => $order_no]);
        //$html = $this->load->view('admin/order/pdf_transport_v2', $this->data);

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
        $html = $this->load->view('admin/order/pdf_transport_v2', $this->data, true);
        $mpdf->WriteHTML($html);
        $filename = "PO_TRANSPORTASI" . $order_no . '_' . time();
        $mpdf->Output("pdf/po/" . $filename . ".pdf", "F");
        // kirim email
        $this->load->helper('email_helper');
        $this->load->model('User_model');
        $q_users = $this->User_model->getOneBy(['users.vendor_id' => $dataOrder->vendor_id]);
        if ($q_users !== FALSE) {
            if ($generate_ulang == 0) {
                send_email_po($q_users->email, $filename . ".pdf", $order_no);
            }
        }


        $this->Order_transportasi_model->update(['pdf_name' => $filename . ".pdf"], ['order_no' => $order_no]);
        if ($generate_ulang == 1) {
            echo json_encode([
                'status' => TRUE,
                'message' => 'Berhasil generate ulang'
            ]);
        }
    }

    public function cekAh()
    {
        die($_SERVER['DOCUMENT_ROOT']);
    }

    public function generatepdf($order_no, $generate_ulang = '0')
    {

        $order = $this->order_model->getDataOneBy(['order.order_no' => $order_no]);
        $order_menu = $this->order_product_model->getAllDataById(['order_product.order_no' => $order_no]);

        $this->load->model('User_model');
        $data['department'] = $this->User_model->getDepartmentUser($order->created_by);
        $data['pake_ttd'] = TRUE;

        $users = $this->User_model->getAllById(['users.id' => $order->created_by]);

        $cc = [];
        if ($users) {
            foreach ($users as $v) {
                $cc[] = $v->email;
            }
        }

        $data['hari'] = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu'
        ];

        $no_contract = "";
        $tgl_contract = "";
        //berarti kontrak_id di table order ada, langsung ambil no kontrak na
        if ($order->kontrak_id != '' && $order->kontrak_id != '0') {
            $tgl_contract = $order->tgl_contract;
            $no_contract = $order->no_contract;
            if ($order->no_amandemen != '') {
                $no_contract .= '-Amd' . $order->no_amandemen;
            }
        }
        // jika tidak ada, ambil 1 produk dari order menu
        else {
            $_temp_product_id = $order_menu[0]->product_id;
            $this->load->model('Product_model');
            $res = $this->Product_model->cek_is_terkontrak($_temp_product_id, TRUE);
            if ($res !== FALSE) {
                foreach ($res as $k => $v) {
                    if ($k > 0) {
                        break;
                    }
                    $tgl_contract = $v->tgl_contract;
                    $no_contract = $v->no_contract;
                    if ($v->no_amandemen != '') {
                        $no_contract .= '-Amd' . $v->no_amandemen;
                    }
                }
            }
        }

        $data['tgl_contract'] = $tgl_contract;
        $data['no_contract'] = $no_contract;
        $data['order'] = $order;
        $data['order_menu'] = $order_menu;
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
        //var_dump(is_file(BASEPATH . 'vendor/autoload.php'));
        //die();
        $footer = '<table border="1">
    		<tr>
    			<td width="10%" style="height:50px"></td>
    			<td width="10%"></td>
    			<td width="10%"></td>
    			<td width="10%"></td>
    			<td width="20%" style="border-top:none;border-bottom:none"></td>
    			<td width="10%"></td>
    			<td width="10%"></td>
    			<td width="10%"></td>
    			<td width="10%"></td>
    		</tr>
    	</table>';
        $mpdf->defaultfooterline = 0;
        $mpdf->SetMargins(0, 0, 0);
        $mpdf->setFooter($footer);
        $html = $this->load->view('frontend/email/order_po', $data, true);
        $mpdf->WriteHTML($html);
        $filename = "PO_" . $order_no . '_' . time();
        $mpdf->Output("pdf/po/" . $filename . ".pdf", "F");
        if ($generate_ulang == "0") {
            $this->load->helper('email_helper');
            $this->load->model('User_model');
            $q_users = $this->User_model->getOneBy(['users.vendor_id' => $order_menu[0]->vendor_id]);
            if ($q_users !== FALSE) {
                send_email_po($q_users->email, $filename . ".pdf", $order_no, $cc);
            }
        }
        $this->order_model->update(['pdf_name' => $filename . ".pdf"], ['order_no' => $order_no]);
        //$this->model->update([''])
        //unlink("./pdf/po/".$filename.".pdf");
    }

    public function cek()
    {
        $this->load->helper('email_helper');
        cek_cc();
    }

    public function cek_email_po($order_no = '1906250003')
    {
        $data['order_product'] = $this->order_product_model->getAllDataById(['order_product.order_no' => $order_no]);
        $getapprovename = $this->order_model->getapprovename(['order_no' => $order_no]);
        $array_approval = [];
        if ($getapprovename) {
            $index = 0;
            foreach ($getapprovename as $key => $value) {
                $array_approval[$value->role_id]['approve_name'][$index] = $value->approval_name;
                if ($value->updated_by) {
                    $array_approval[$value->role_id]['approve_acc'][$index] = $value->approval_name;
                }
                $array_approval[$value->role_id]['user_approve_name'] = $value->user_approve_name;
                $array_approval[$value->role_id]['status_approve'] = $value->status_approve;
                $index++;
            }
        }

        if ($data['order_product']) {
            $data['order_no'] = $order_no;
            $data['detail_order'] = $this->order_model->detail_order(['a.order_no' => $order_no]);
            $data['list_approval_name'] = $array_approval;
        }

        $this->load->view('admin/order/email_po', $data);
    }

    public function cekSendPhpMailer()
    {
        $this->load->library('email_po');
        $this->email_po->sendDetailPOByRoleId();
        //$content = $this->load->view('admin/order/email_po', [], TRUE);
        //$this->email_po->sendPhpMailer('agussobari.16@gmail.com', 'Agus Sobari', 'Approval PO di aplikasi eCatalogue WIKA', $content);
    }


    // public function pdfTransport($order_no = '1907300003', $transportasi_id = '5')
    public function pdfTransport($order_no, $transportasi_id)
    {

        $dataOrder = $this->order_model->getDataPdfTransport(['order_product.order_no' => $order_no, 'order_product.transportasi_id' => $transportasi_id]);
        $this->data['dataPekerjaan'] = $this->order_model->getDataPekerjaan(['order_product.order_no' => $order_no, 'order_product.transportasi_id' => $transportasi_id]);

        $this->data['tgl_kontrak']          =   tgl_indo($dataOrder->tgl_kontrak);
        $this->data['no_kontrak_transport'] =   $dataOrder->no_kontrak_transport;
        $this->data['nama_project']         =   $dataOrder->nama_project;
        $this->data['nama_vendor']          =   $dataOrder->nama_vendor;
        $this->data['nama_direktur']        =   $dataOrder->nama_direktur;
        $this->data['jabatan']              =   $dataOrder->jabatan;
        $this->data['departemen']           =   $dataOrder->departemen;
        $this->data['gm']                   =   $dataOrder->gm;

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
        $html = $this->load->view('admin/order/pdf_transport_v', $this->data, true);
        $mpdf->WriteHTML($html);
        $filename = "PO_TRANSPORTASI" . $order_no . '_' . time();
        $mpdf->Output("pdf/po/" . $filename . ".pdf", "I");
    }
}
