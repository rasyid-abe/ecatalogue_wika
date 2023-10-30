<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Orderhistory extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('payment_method_model');
        $this->load->model('shipping_model');
        $this->load->model('order_model');
        $this->load->model('order_product_model');
        $this->load->model('product_model');
        if ($this->data['users_groups']->id == 3) {
            redirect('dashboard');
        }
    }

    public function index()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        } else {

            $this->data['content']  = 'frontend/mycart/history';
            $this->load->view('frontend/layouts/page', $this->data);
        }
    }


    public function dataList()
    {
        $columns = array(
            0 => 'order.order_no',
            1 => 'order.no_surat',
            // 2=> 'order.payment_method_id',
            2 => 'order.vendor_name',
            3 => 'project_new.name',
            4 => 'order.total_price',
            5 => 'order.created_at',
        );


        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $where = array();
        if (!$this->data['is_superadmin']) {
            $where['order.created_by'] = $this->data['users']->id;
        }
        $limit = 0;
        $start = 0;
        $totalData = $this->order_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);

        $searchColumn = $this->input->post('columns');

        // print_r($searchColumn);
        $isSearchColumn = false;

        if (!empty($searchColumn[0]['search']['value'])) {
            $value = $searchColumn[0]['search']['value'];
            $isSearchColumn = true;
            $search['order.order_no'] = $value;
        }

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

        // if(!empty($searchColumn[2]['search']['value'])){
        // 	$value = $searchColumn[2]['search']['value'];
        // 	$isSearchColumn = true;
        //           $tgl = explode('-',$value);
        //           $where['order.created_at >='] = date('Y-m-d',strtotime($tgl[0]));
        //           $where['order.created_at <='] = date('Y-m-d',strtotime($tgl[1]));
        // }

        if ($isSearchColumn) {
            $totalFiltered = $this->order_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
        } else {
            $totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');

        $datas = $this->order_model->getAllBy($limit, $start, $search, $order, $dir, $where);

        $new_data = array();
        if (!empty($datas)) {
            foreach ($datas as $key => $data) {

                $jml_yg_sdh_approve = $this->db->select("count(*) as count")
                    ->where('order_no', $data->order_no)
                    ->get('approve_po_list')->row()->count;

                $edit_url = "";
                $delete_url = "";
                $batal_url = "";
                $pdf = "";

                $edit_url =  "<a href='" . base_url() . "orderhistory/detail/" . $data->order_no . "' data-id='" . $data->id . "' style='color: white;'><div class='btn btn-sm btn-primary btn-blue btn-editview '>Detail</div></a>";

                $status = "";
                if ($data->is_approve_complete == 0 && $data->order_status != 4) {
                    $status = "<a data-id='" . $data->id . "' style='color: white;'><div class='btn btn-sm btn-primary btn-warning'>Waiting approval " . ($data->approve_sequence + 1) . "</div></a>";
                } else if ($data->order_status == 4) {
                    if ($data->created_by == $this->data['users']->id) {
                        if ($jml_yg_sdh_approve == $data->approve_sequence) {
                            $status = "<button type='button' value='" . $data->order_no . "' style='color: white;' class='btn btn-sm btn-primary btn-secondary' id='revisi_btn'>Revisi Vendor</button> ";
                            $batal_url = "<button type='button' value='" . $data->order_no . "' style='color: white;' class='btn btn-sm btn-primary btn-danger' id='cancel_btn'>Tolak Revisi</button> ";
                        } else
                            $status = "<button type='button' value='" . $data->order_no . "' style='color: white;' class='btn btn-sm btn-primary btn-secondary' id='revisi_btn'>Revisi</button> ";
                    } else
                        $status = "<a data-id='" . $data->id . "' style='color: white;'><div class='btn btn-sm btn-primary btn-secondary'>Revisi</div></a>";
                    // $status = "<a data-id='" . $data->id . "' style='color: white;'><div class='btn btn-sm btn-primary btn-secondary' id='revisi_btn'>Revisiaa</div></a>";
                } else {
                    if ($data->order_status == 2) {
                        $status = "<a data-id='" . $data->id . "' style='color: white;'><div class='btn btn-sm btn-primary btn-success'>Approved</div></a>";
                    } else if ($data->order_status == 3) {

                        if ($jml_yg_sdh_approve == $data->approve_sequence)
                            $status = "<a data-id='" . $data->id . "' style='color: white;'><div class='btn btn-sm btn-primary btn-danger'>Canceled Vendor</div></a>";
                        else
                            $status = "<a data-id='" . $data->id . "' style='color: white;'><div class='btn btn-sm btn-primary btn-danger'>Canceled</div></a>";
                    }
                }

                // if($data->pdf_name && is_file("pdf/po/".$data->pdf_name)){
                //     $pdf = "<a target='_blank' href='".base_url()."pdf/po/".$data->pdf_name."' style='color: white;'><div class='btn btn-sm btn-primary btn-danger mtop-5'>Lihat Pdf</div></a>";
                // }

                $approve_btn = "";
                if ($data->role_id_approver == $this->data['users_groups']->id) {
                    $approve_btn = "<a href='javascript:;'
                        url='" . base_url() . "order/approve_po/" . $data->order_no . "/" . $data->role_id_approver . "'
                        class='btn btn-sm btn-warning approve' >Approve PO
                        </a>";
                    $approve_btn .= " <a href='javascript:;'
                        url='" . base_url() . "order/reject/" . $data->order_no . "/" . $data->role_id_approver . "'
                        class='btn btn-sm btn-danger reject'>Reject PO
                        </a>";
                }

                $nestedData['order_no']         = $data->order_no;
                $nestedData['no_surat']         = $data->no_surat;
                $nestedData['project_name']     = $data->project_name;
                $nestedData['vendor_name']      = $data->vendor_name;
                // $nestedData['perihal']          = $data->perihal;
                //$nestedData['full_name']        = $data->full_name;
                // $nestedData['shipping_name']    = $data->shipping_name;
                $nestedData['total_price']      = number_format($data->total_price);
                $nestedData['created_at']       = tgl_indo($data->created_at, TRUE);
                $nestedData['status']           = $status . " " . $batal_url;
                $nestedData['action']           = $edit_url . " " . $pdf ;
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

    public function act_revisi()
    {
        $product_cart = array();
        $order_no = $this->input->post('id', true);
        $o = $this->db->get_where('order', ['order_no' => $order_no])->row_array();
        $d = $this->db->get_where('order_product', ['order_no' => $order_no])->row_array();
        $category = $this->db->get_where('product', ['id' => $d['product_id']])->row('category_id');

        if ($this->session->userdata('cart_session')) {
            $old = $this->session->userdata('cart_session');
            foreach ($old as $key => $value) {
                if ($value['order_no'] == $order_no) {

                    echo json_encode([
                        'status' => false,
                        'no_order' => $order_no,
                    ]);
                    exit;
                }
            }
        }

        $product = array(
            "is_rev"                => 1,
            "order_no"              => $order_no,
            "no_surat"              => $o['no_surat'],
            "quantity"              => $d['qty'],
            "product_id"            => $d['product_id'],
            "product_contract"      => $this->product_model->cek_is_terkontrak($d['product_id']),
            "product_name"          => $d['full_name_product'],
            "product_uom_name"      => $d['uom_name'],
            "product_price"         => $d['price'],
            "product_weight"        => $d['weight'],
            "product_total_price"   => ($d['price'] * $d['qty'] * $d['weight']),
            "product_vendor_name"   => $d['vendor_name'],
            "product_uom_id"        => $d['product_uom_id'],
            "payment_method_full"   => $d['payment_mehod_name'],
            "payment_method_id"     => $d['payment_method_id'],
            "include_price"         => $d['include_price'],
            "vendor_id"             => $d['vendor_id'],
            "vendor_name"           => $d['vendor_name'],
            "full_product_name"     => $d['full_name_product'],
            "id_session"            => $d['product_id'] . "_" . time() . rand(10000, 99999),
            'includes'              => 0,
            'location_id'           => $o['location_id'],
            'location_name'         => $o['location_name'],
            'image'                 => $this->db->get_where('product_gallery', ['product_id' => $d['product_id']])->row('filename'),
            'is_matgis'             => $o['is_matgis'],
            'category_id'           => $category,
            'for_order'             => $o['vendor_id'] . '_' . $o['location_id'] . '_' . $category,
        );

        if ($this->session->userdata('cart_session')) {
            $product_cart = $this->session->userdata('cart_session');
            array_push($product_cart, $product);
            $this->session->set_userdata('cart_session', $product_cart);
        } else {
            array_push($product_cart, $product);
            $this->session->set_userdata('cart_session', $product_cart);
            $product_cart = $this->session->userdata('cart_session');
        }

        echo json_encode(['status' => true]);
    }

    public function act_cancel_revisi()
    {
        $order_no = $this->input->post('id', true);
        $q = $this->order_model->getOneBy(['order_no' => $order_no]);
        $this->db->trans_start();
        $this->db->where('order_no', $order_no)->update('order', ['is_approve_complete' => 1, 'order_status' => 2]);
        $pesan = "No Order " . $order_no . " dengan no surat " . $q->no_surat . " Cancel revisi";
        $data_notif[] = [
            'id_pengirim' => 1,
            'id_penerima' => $q->created_by,
            'deskripsi' => $pesan,
        ];
        $this->db->insert_batch('notification', $data_notif);

        $this->db->trans_complete();

        $ret['status'] = $this->db->trans_status();
        ob_end_clean();
        echo json_encode($ret);
    }

    public function export_to_excel()
    {
        $where = [];
        $search = [];
        if (!$this->data['is_superadmin']) {
            $where['order.created_by'] = $this->data['users']->id;
        }

        if ($this->input->get('daterange') != '') {
            $value = $this->input->get('daterange');
            $tgl = explode('-', $value);
            $where['DATE(order.created_at) >='] = date('Y-m-d', strtotime($tgl[0]));
            $where['DATE(order.created_at) <='] = date('Y-m-d', strtotime($tgl[1]));
        }

        if ($this->input->get('order_no') != '') {
            $search['order.order_no'] = $this->input->get('order_no');
        }

        if ($this->input->get('nm_project') != '') {
            $search['project_new.name'] = $this->input->get('nm_project');
        }

        if ($this->input->get('no_surat') != '') {
            $search['order.no_surat'] = $this->input->get('no_surat');
        }

        if ($this->input->get('vendor_name') != '') {
            $search['order.vendor_name'] = $this->input->get('vendor_name');
        }

        if ($this->input->get('location_name') != '') {
            $search['order.location_name'] = $this->input->get('location_name');
        }

        if ($this->input->get('perihal') != '') {
            $search['order.perihal'] = $this->input->get('perihal');
        }

        if ($this->input->get('jenis_po') != 'all') {
            $search['order.is_matgis'] = $this->input->get('jenis_po');
        }

        if ($this->input->get('po_status') != 'all') {
            if ($this->input->get('po_status') == 1) {
                $where['order.order_status'] = 1;
                $where['order.is_approve_complete'] = 0;
            } else if ($this->input->get('po_status') == '0') {
                $where['order.order_status'] = 2;
                $where['order.is_approve_complete'] = 1;
            } else if ($this->input->get('po_status') == 3) {
                $where['order.order_status'] = 3;
                $where['order.is_approve_complete'] = 1;
            }
        }

        $datas = $this->order_model->getAllBy(0, 0, $search, NULL, NULL, $where);
        //die($this->db->last_query());
        $data['data'] = $datas;
        $this->load->view('frontend/riwayat_export_to_excel', $data);
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
                $r_t = $this->db->get_where('log_cancel_po', ['no_order' => $order_no, 'status_cancel' => 3])->num_rows();
                $this->data['rev_time'] = $r_t > 0 ? 'Rev. ' . $r_t : '';
                $this->data['order_no'] = $order_no;
                $this->data['detail_order'] = $this->order_model->detail_order(['a.order_no' => $order_no]);
                if (!$this->data['detail_order']) {
                    redirect('ErrorPage');
                }
                $this->data['list_approval_name'] = $array_approval;
                $this->data['role_id'] = $this->db->get_where('approve_po_list', ['order_no' => $order_no])->result();
                $cekApporval = $this->db->get_where('order', ['order_no' => $order_no])->row();
                $this->data['cekApporval'] = $cekApporval->is_approve_complete;
                $this->data['cekStatusOrder'] = $cekApporval->order_status;
                $this->data['cekRole'] = $this->db->get_where('approve_po_list', ['order_no' => $order_no, 'sequence' => $cekApporval->approve_sequence + 1])->row();

                $this->data['order'] = $this->order_model->getDataOneBy(['order.order_no' => $order_no]);
                $this->data['role_session'] = $this->data['users_groups']->id;

                // untuk order_transportasi
                $this->load->model('Order_transportasi_model');
                $this->data['orderTransportasi'] = $this->Order_transportasi_model->getDataPdfTransport(['order_transportasi.order_no' => $order_no]);
                $this->data['orderTransportasiDetail'] = $this->Order_transportasi_model->getDataPekerjaan(['order_no' => $order_no]);

                // order Asuransi
                $this->load->model('Order_asuransi_model');
                $this->data['orderAsuransi'] = $this->Order_asuransi_model->getDataPdfAsuransi(['order_asuransi.order_no' => $order_no]);
                $this->data['orderAsuransiDetail'] = $this->Order_asuransi_model->getAllDataById(['order_asuransi_d.order_no' => $order_no]);

                $query = $this->db->query('select * from alasan_cancel where jenis = 1');
                $this->data['alasans'] = $query->result();

                $log_cancel = $this->db->query("select lc.*,ac.alasan, users.first_name  from log_cancel_po lc left join alasan_cancel ac on lc.id_alasan=ac.id left join users on users.id=lc.user_id where no_order = $order_no");
                $this->data['log_cancel'] = $log_cancel->result();

                $this->data['content']  = 'frontend/mycart/detailorder';
                $this->load->view('frontend/layouts/page', $this->data);
            } else {
                $this->load->view('errors/html/error_404');
            }
        }
    }

    public function cek_table($table)
    {
        $q = $this->db->get($table);
        my_print_r($q->result());
    }

    public function cek_email()
    {
        $this->load->library('Email_po');
        $this->Email_po->sendEmailPOToVendor('agussobari.16@gmail.com', '1908160002');
    }
}
