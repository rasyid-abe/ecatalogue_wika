<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Mycart extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('payment_method_model');
        $this->load->model('shipping_model');
        $this->load->model('order_model');
        $this->load->model('Groups_model');
        $this->load->model('Project_model');
        $this->load->model('Project_new_model');
        $this->load->model('Asuransi_model');
        $this->load->model('Transportasi_model');
        $this->load->model('Location_model');

        if ($this->data['users_groups']->id == 3) {
            redirect('dashboard');
        }
    }

    public function index()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        } else {
            // handle ketika tidak ada departemen atau departemen itu tidak ada GM nya;
            $is_no_gm = FALSE;
            // tidak ada group_id nya
            if (!$this->data['users']->group_id) {
                $is_no_gm = TRUE;
                $this->data['departemencode'] = '';
            } else {
                $this->load->model('Groups_model');
                $groups = $this->Groups_model->findAllById(['id' => $this->data['users']->group_id]);
                $this->data['departemencode'] = $groups->departemen_code;
            }

            //$this->data['project'] = $this->Project_model->getProjectByUserId();
            $this->data['project'] = $this->Project_model->getProjectByUserIdNew();
            //var_dump($this->data['project']);
            $this->data['payment_method'] = $this->payment_method_model->getAllById();
            $this->data['shipping'] = $this->shipping_model->getAllById();
            $cekCart = $this->session->userdata('cart_session');
            if ($cekCart) {
                usort($cekCart, function ($a, $b) {
                    return strcmp($a["for_order"], $b["for_order"]);
                });
            }
            //die(var_dump($cekCart));

            $ses = $this->session->userdata('cart_session');
            // $d_ses = $this->db->get_where('order', ['order_no' => $ses[0]['order_no']])->row_array();
            $d_ses = $this->order_model->get_revisi_data($ses[0]['order_no']);
            $proj_id = $d_ses['project_id'];
            // echo "<pre>";
            // print_r($d_ses);
            // die;

            $this->data['val_perihal'] = $ses[0]['is_rev'] > 0 ? $d_ses['perihal'] : '';
            $this->data['val_catatan'] = $ses[0]['is_rev'] > 0 ? $d_ses['catatan'] : '';
            $this->data['val_shipping_id'] = $ses[0]['is_rev'] > 0 ? $d_ses['shipping_id'] : '';
            $this->data['val_tgl_diambil'] = $ses[0]['is_rev'] > 0 ? $d_ses['tgl_diambil'] : '';
            $this->data['val_project_id'] = $ses[0]['is_rev'] > 0 ? $d_ses['project_id'] : '';
            $this->data['val_location_id'] = $ses[0]['is_rev'] > 0 ? $d_ses['location_id'] : '';
            $this->data['val_location_name'] = $ses[0]['is_rev'] > 0 ? $d_ses['regency_name'] : '';
            $this->data['val_asuransi_id'] = $ses[0]['is_rev'] > 0 ? $d_ses['asuransi_id'] : '';
            $this->data['val_is_rev'] = $ses[0]['is_rev'];
            // $this->data['val_asuransi'] = $ses[0]['is_rev'] > 0 ? $d_ses['asuransi'] : '';


            $this->data['cart'] = $cekCart;
            $whereLocation = ['level in (2,3)' => null];
            $this->data['location'] = $this->Location_model->get_dropdown2($whereLocation);
            $this->data['transportasi'] = $this->Transportasi_model->get_dropdown_transportasi();
            $this->data['asuransi'] = $this->Asuransi_model->get_dropdown_asuransi();

            $this->data['content']  = 'frontend/mycart/detail';
            $this->load->view('frontend/layouts/page', $this->data);
        }
    }

    public function get_smcb()
    {
        $project_id = $this->input->post('data', true);
        $data = $this->Project_model->get_smcb_data($project_id);

        echo json_encode($data);
    }

    public function price_smcb()
    {
        $smcb = $this->input->post('data', true);
        $data = $this->Project_model->get_price_smcb($smcb);

        echo json_encode($data);
    }

    public function pay()
    {
        $this->load->model('Product_model');
        // handle ketika tidak ada departemen atau departemen itu tidak ada GM nya;
        $is_no_gm = FALSE;
        // tidak ada group_id nya
        if (!$this->data['users']->group_id) {
            $is_no_gm = TRUE;
        } else {
            $this->load->model('Groups_model');
            $groups = $this->Groups_model->findAllById(['id' => $this->data['users']->group_id]);

            if ($groups === FALSE) {
                $is_no_gm = TRUE;
            } else {
                if ($groups->role_id_general_manager == FALSE) {
                    $is_no_gm = TRUE;
                }
            }
        }

        // check revisi dan Belanja
        $rev_s = false;
        $no_orders = $this->input->post('noOrder', true);
        $no_surats = $this->input->post('noSurat', true);
        $is_revs = $this->input->post('isRev', true);
        $v_id = $this->input->post('vendor_id', true);
        $pay_id = $this->input->post('arr_payment_method_id', true);

        if ($is_revs == 0) {
            for ($i = 1; $i < count($v_id); $i++) {
                if ($v_id[0] != $v_id[$i]) {
                    $data_return['status']  = FALSE;
                    $data_return['data']    = [];
                    $data_return['messages'] = "Tidak bisa order, Vendor berbeda antara Revisi dengan Produk baru.";
                    echo json_encode($data_return);
                    exit();
                }
            }

            for ($i = 1; $i < count($pay_id); $i++) {
                if ($pay_id[0] != $pay_id[$i]) {
                    $data_return['status']  = FALSE;
                    $data_return['data']    = [];
                    $data_return['messages'] = "Tidak bisa order, Metode pembayaran berbeda antara Revisi dengan Produk Baru.";
                    echo json_encode($data_return);
                    exit();
                }
            }

            for ($i = 1; $i < count($is_revs); $i++) {
                if ($is_revs[0] != $is_revs[$i]) {
                    $rev_s = true;
                    break;
                }
            }
        }

        if ($is_no_gm === TRUE) {
            $data_return['status']  = FALSE;
            $data_return['data']    = [];
            $data_return['messages'] = "Tidak bisa order, General Manager tidak ada / belum di set";
            echo json_encode($data_return);
            return;
        }

        // end handle jika tidak ada GM

        // handle jika tidak ada role_id penanda tangan di approve_po_rules per departemen_id
        $q_approve_rules = $this->db->where(['departemen_id' => $this->data['users']->group_id])->get('approve_po_rules');
        if ($q_approve_rules->num_rows() == 0) {
            $data_return['status']  = FALSE;
            $data_return['data']    = [];
            $data_return['messages'] = "Tidak bisa order, User Approve belum di set";
            echo json_encode($data_return);
            return;
        }
        // end handle tidak ada role

        // untuk menampung order dikelompokan sesuai indexnya
        $order = array();


        // untuk menampung total price per order sesuai indexnya;
        $total_price = array();
        $product    = $this->input->post('arr_product_id');
        $price      = $this->input->post('arr_price');
        $weight     = $this->input->post('arr_weight');
        $contract     = $this->input->post('arr_product_contract');
        $quantity   = $this->input->post('quantity');
        $vendor_id  = $this->input->post('vendor_id');
        $uom_id     = $this->input->post('arr_uom_id');
        $arr_payment_method_id    = $this->input->post('arr_payment_method_id');
        //$include_price = $this->input->post('include_price');
        //$json_include_price = $this->input->post('json_include');
        $location_id     = $this->input->post('location_id');
        $location_name   = $this->input->post('location_name');

        $perihal    = $this->input->post('perihal');
        $shipping_id   = $this->input->post('shipping_id');
        $user_id    = $this->input->post('user_id');
        $is_matgis    = $this->input->post('is_matgis');


        //Untuk Array Lokasi vendor, 1 vendor bisa hold beberapa lokasi,
        // jika lokasi barang tidak ada / tidak sama dengan lokasi vendor nya , maka order ditolak
        // contoh : $arrLocationVendor['3'] = [31,33,3273]; vendor id = 3, lokasinya 31,33, 3273
        $this->load->model('Vendor_lokasi_model');
        $arrLocationVendor = $this->Vendor_lokasi_model->getArrLocationVendor($vendor_id);
        // untuk mengecek loksi vendor error
        $isLocationError = FALSE;
        $locationErrorMessage = [];

        $data_order_product = array();
        // teruntuk bapak arif; kwkwkw
        $vendor_id_for_feedback = [];
        // key = id_kontrak, value = total_volume_yang_diorder
        $volume_per_kontrak = [];
        $product_kontrak = [];
        $volume_sisa = $this->Product_model->cek_is_terkontrak($product, TRUE);
        $kontrak_product = [];
        // key = id_kontrak, value = volume_sisa
        $kontrak_volume = [];
        if ($volume_sisa !== FALSE) {
            foreach ($volume_sisa as $k => $v) {
                $kontrak_product[$v->project_id][] = $v->product_id;
                $product_kontrak[$v->product_id] = $v->project_id;
                if (!array_key_exists($v->project_id, $kontrak_volume)) {
                    $kontrak_volume[$v->project_id] = $v->volume_sisa;
                }
            }
        }

        // cek lokasi project_id, klo lokasinya masih NULL, return false
        $dataProject = $this->Project_new_model->getOneBy(['id' => $this->input->post('project_id')]);
        if ($dataProject->location_id == FALSE) {
            $data_return['status']  = FALSE;
            $data_return['data']    = [];
            $data_return['messages'] = "Tidak bisa order, Lokasi project belum di set";
            echo json_encode($data_return);
            return;
        }

        // cek barang kontrak dan tidak trkontrak
        $count_contract = count(array_count_values($contract));
        if ($count_contract == 2) {
            $data_return['status']  = FALSE;
            $data_return['data']    = [];
            $data_return['messages'] = "Tidak bisa order, mohon cek kembali kontrak produk anda";
            echo json_encode($data_return);
            return;
        }

        // cek barang kontrak tidak bisa menggunakan asuransi dan transportasi
        if (in_array("0", $contract) && ($this->input->post('is_use_transport') || $this->input->post('is_use_asuransi'))) {
            $data_return['status']  = FALSE;
            $data_return['data']    = [];
            $data_return['messages'] = "Tidak bisa order, pembelian tidak bisa menggunakan transportasi atau asuransi";
            echo json_encode($data_return);
            return;
        }

        // buat set asuransi, jika asuransi nya di ceklis;

        /*
        *
        * PO dibagi 3, PO Product, PO Transport, PO Asuransi
        * semua PO, ada di Looping ini, tiap PO dipisahkan oleh komen, biar gak lieur;
        * klo ada yang ditanyakan, hubungi polsek setempaat. kwkwkw
        *
        */

        // init Array untuk PO Transport dan PO Asuransi
        // PO Asuransinya diatas ^
        $orderTransport = [];
        $orderTransportDetail = [];
        $orderAsuransi = [];
        $orderAsuransiDetail = [];

        // begin looping nya
        for ($i = 0; $i < count($product); $i++) {

            // cek dulu, lokasinya sesuai dengan vendornya atau tidak
            if (!isset($arrLocationVendor[$vendor_id[$i]]) || !in_array($location_id[$i], $arrLocationVendor[$vendor_id[$i]])) {
                $isLocationError = TRUE;
                $locationErrorMessage[] = '- Barang ' . $this->input->post('full_name_product')[$i] . ' dengan Lokasi ' . $location_name[$i]
                    . ' tidak ada di lokasi vendor ' . $this->input->post('vendor_name')[$i] . '<br> <br>';
            }

            // BEGIN ORDER_PRODUCT
            if (!in_array($vendor_id[$i], $vendor_id_for_feedback)) {
                $vendor_id_for_feedback[] = $vendor_id[$i];
            }
            // indexnya vendor_id digabung sama payment_method_id , location dan is_matgis;
            $kontrak_id = 0;
            if (array_key_exists($product[$i], $product_kontrak)) {
                $kontrak_id = $product_kontrak[$product[$i]];
            }

            $cek_contract = $contract[$i];

            // untuk set transport;
            $biayaTransport = 0;
            $keterangan_tranport = NULL;
            $transportasiId = NULL;
            $transportOriginId = NULL;
            $transportDestinationId = NULL;
            $transportVendorId = NULL;
            $transportWeightMinimum = 0;

            $whereTransport = [
                'transportasi.id' => $this->input->post('sda_transportasi')[$this->input->post('vendor_id')[$i]][$location_id[$i]][$this->input->post('category_id')[$i]],
            ];
            $harga_transport = $this->input->post('harga_transportasi')[$this->input->post('vendor_id')[$i]][$location_id[$i]][$this->input->post('category_id')[$i]];
            $keterangan_tranport = $this->input->post('keterangan_satuan_tranport')[$this->input->post('vendor_id')[$i]][$location_id[$i]][$this->input->post('category_id')[$i]];
            $dataTransport = $this->Transportasi_model->getHargaByLastAmandemen($whereTransport);
            if ($dataTransport !== FALSE) {
                $biayaTransport = $harga_transport;
                $keterangan_tranport = $keterangan_tranport;
                $transportasiId = $dataTransport->id;
                $transportOriginId = $dataTransport->origin_location_id;
                $transportDestinationId = $dataTransport->destination_location_id;
                $transportVendorId = $dataTransport->vendor_id;
                $transportWeightMinimum = $dataTransport->weight_minimum;
            }
            // end set transport

            if (!array_key_exists($vendor_id[$i] . '_' . $arr_payment_method_id[$i] . '_' . $location_id[$i] . '_' . $is_matgis[$i] . '_' . $kontrak_id, $order)) {
                $index = $vendor_id[$i] . '_' . $arr_payment_method_id[$i] . '_' . $location_id[$i] . '_' . $is_matgis[$i] . '_' . $kontrak_id;
                if ($rev_s) {
                    $order_no = $no_orders[0];
                } else {
                    $order_no = $no_orders[$i] == '' ? $this->generate_order_no() : $no_orders[$i];
                }
                $order[$index] = array(
                    'order_no'          => $order_no,
                    "perihal"           => $perihal,
                    //"payment_method_id" =>$payment_method_id,
                    "shipping_id"       => $shipping_id,
                    "order_status"      => 1,
                    "created_by"        => $user_id,
                    'catatan'           => $this->input->post('catatan'),
                    'project_id'        => $this->input->post('project_id'),
                    'tgl_diambil'       => $this->input->post('tgl_diambil'),
                    'payment_method_id' => $arr_payment_method_id[$i],
                    'location_id'       => $location_id[$i],
                    'location_name'     => $location_name[$i],
                    'vendor_id'             => $this->input->post('vendor_id')[$i],
                    'vendor_name'           => $this->input->post('vendor_name')[$i],
                    'is_matgis'     => $is_matgis[$i],
                    'kontrak_id'    => $kontrak_id,
                    //'nilai_asuransi' => $nilaiAsuransi,
                    //'asuransi_id' => $asuransiId,
                    //'jenis_asuransi' => $jenisAsuransi,
                );

                $total_price[$index] = 0;
                // order_transportasi
                if ($this->input->post('sda_transportasi')[$this->input->post('vendor_id')[$i]][$location_id[$i]][$this->input->post('category_id')[$i]]) {
                    $orderTransport[$index] = [
                        'order_no'          => $order_no,
                        "perihal"           => $perihal,
                        'catatan'           => $this->input->post('catatan'),
                        'biaya_transport'   => $biayaTransport,
                        'keterangan_transport'   => $keterangan_tranport,
                        'transportasi_id'   => $transportasiId,
                        'vendor_id'         => $transportVendorId,
                        'location_origin_id' => $location_id[$i],
                        'location_destination_id'   => $transportDestinationId,
                        'category_id'   => $this->input->post('category_id')[$i],
                        'project_id'        => $this->input->post('project_id'),
                        "created_by"        => $user_id,
                        'weight_minimum' => $transportWeightMinimum,
                    ];
                }

                // order_asuransi
                $nilaiAsuransi = 0;
                $asuransiId = NULL;
                $jenisAsuransi = NULL;
                $hargaMinAsuransi = NULL;
                if ($this->input->post('is_use_asuransi')) {
                    $dataAsuransi = $this->Asuransi_model->getHargaByLastAmandemen(['asuransi.id' => $this->input->post('asuransi_id')]);
                    if ($dataAsuransi === FALSE) {
                        $data_return['status']  = FALSE;
                        $data_return['data']    = [];
                        $data_return['messages'] = "Tidak bisa order, data Asuransi tidak ditemukan";
                        echo json_encode($data_return);
                        return;
                    }

                    $nilaiAsuransi = $dataAsuransi->nilai_asuransi;
                    $asuransiId = $dataAsuransi->id;
                    $jenisAsuransi = $dataAsuransi->jenis_asuransi;
                    $hargaMinAsuransi = $dataAsuransi->nilai_harga_minimum;

                    $orderAsuransi[$index] = [
                        'order_no'          => $order_no,
                        "perihal"           => $perihal,
                        'catatan'           => $this->input->post('catatan'),
                        'project_id'        => $this->input->post('project_id'),
                        "created_by"        => $user_id,
                        'nilai_asuransi'    => $nilaiAsuransi,
                        'asuransi_id'       => $asuransiId,
                        'jenis_asuransi'    => $jenisAsuransi,
                        'vendor_id'         => $dataAsuransi->vendor_id,
                        'nilai_harga_minimum' => $hargaMinAsuransi,
                    ];
                }
            }

            $total_price[$index] += round($price[$i] * $quantity[$i] * $weight[$i], 2);

            // untuk order_product
            $data_order_product[] = array(
                'order_no'              => $order[$index]['order_no'],
                'product_id'            => $product[$i],
                'qty'                   => $quantity[$i],
                'product_uom_id'        => $uom_id[$i],
                'order_product_status'  => 1,
                'created_by'            => $user_id,
                'payment_method_id'     => $arr_payment_method_id[$i],
                'price'                 => $price[$i],
                'weight'                => $weight[$i],
                'full_name_product'     => $this->input->post('full_name_product')[$i],
                'payment_mehod_name'    => $this->input->post('payment_method_full')[$i],
                'uom_name'              => $this->input->post('uom_name')[$i],
                'vendor_id'             => $this->input->post('vendor_id')[$i],
                'vendor_name'           => $this->input->post('vendor_name')[$i],
                'biaya_transport'       => $biayaTransport,
                'transportasi_id'       => $transportasiId,
                'id_smcb'               => $this->input->post('smcb_data', true)[$i],
                'periode_smcb'          => $this->input->post('periode_pengadaan_pmcs', true)[$i],
                'price_smcb'            => $this->input->post('price_pmcs', true)[$i],
                // 'json_include_price'    => $json_include_price[$i],
            );

            // untuk menjumlahkan semua product per project;
            if (array_key_exists($product[$i], $product_kontrak)) {
                $ix = $product_kontrak[$product[$i]];
                if (!array_key_exists($ix, $volume_per_kontrak)) {
                    $volume_per_kontrak[$ix] = 0;
                }

                $volume_per_kontrak[$ix] += ($weight[$i] * $quantity[$i]);
            }
            // END ORDER_PRODUCT


            // Begin OrderTransport
            // klo dia ceklis menggunakan transportasi

            if ($this->input->post('sda_transportasi')[$this->input->post('vendor_id')[$i]][$location_id[$i]][$this->input->post('category_id')[$i]]) {
                $orderTransportDetail[] = [
                    'order_no'              => $order[$index]['order_no'],
                    'product_id'            => $product[$i],
                    'qty'                   => $quantity[$i],
                    'price'                 => $price[$i],
                    'weight'                => $weight[$i],
                    'full_name_product'     => $this->input->post('full_name_product')[$i],
                ];
            }
            // End OrderTransport

            // begin OrderAsuransi
            // ini untuk order_asuransi_d, order_asuransi nya sebelum looping
            if ($this->input->post('is_use_asuransi')) {
                $orderAsuransiDetail[] = [
                    'order_no'              => $order[$index]['order_no'],
                    'product_id'            => $product[$i],
                    'qty'                   => $quantity[$i],
                    'price'                 => $price[$i],
                    'weight'                => $weight[$i],
                    'full_name_product'     => $this->input->post('full_name_product')[$i],
                ];
            }
            // END OrderAsuransi

        }
        // end looping product

        // cek, produk tidak terkontrak hanya bisa order dibawah 50 juta
        $sum_total_price = array_sum($total_price);
        if ($sum_total_price > 100000000 && $cek_contract == 0) {
            $data_return['status']  = FALSE;
            $data_return['data']    = [];
            $data_return['messages'] = "Tidak bisa order, produk tidak dikontrak hanya bisa diorder tidak lebih dari 50 juta";
            echo json_encode($data_return);
            return;
        }
        // cek, jika lokasi berbeda dengan vendor, maka order berhenti / ditolak;
        if ($isLocationError === TRUE) {
            $data_return['status']  = FALSE;
            $data_return['data']    = [];
            $data_return['messages'] = $locationErrorMessage;
            echo json_encode($data_return);
            return;
        }

        // pengecekan jika ada order yang melebihi volume_sisa
        $error_product = [];
        foreach ($volume_per_kontrak as $k => $v) {
            // order melebihi volume sisa, beri error;
            if ($v > $kontrak_volume[$k]) {
                foreach ($kontrak_product[$k] as $k2 => $v2) {
                    $ix_post = array_search($v2, $product);
                    $error_product[] = "Product " . $this->input->post('full_name_product')[$ix_post] . " melebihi volume kontrak. tidak bisa order";
                }
            }
        }
        /*
        if(!empty($error_product))
        {
            $data_return['status']  = FALSE;
            $data_return['data']    = [];
            $data_return['messages'] = implode("<br>", $error_product);
            ob_end_clean();
            echo json_encode($data_return);
            return;
        }
        */
        $groups || $groups = $this->Groups_model->findAllById(['id' => $this->data['users']->group_id]);

        $params_no_surat = [
            'tanggal' => date('Y-m-d'),
            'perihal' => $perihal,
            'nama_user' => $this->data['users']->username,
            'penandatangan' => $groups->general_manager,
            'nip' => '4CCFD310AA',
            'unit_kerja' => $groups->departemen_code2 != '' ? $groups->departemen_code2 : $groups->departemen_code,
        ];

        // INSERT ORDER ATARU VERISI ORDER
        if ($no_orders[0] != '') {

            $this->db->insert('order_gabungan', ['created_by' => $user_id]);
            $orderGabId = $this->db->insert_id();

            for ($i = 0; $i < count($no_orders); $i++) {
                $this->db->where('order_no', $no_orders[$i]);
                $this->db->update('approve_po_list', ['status_approve' => 0]);

                $this->db->where('order_no', $no_orders[$i]);
                $this->db->update('order', ['is_approve_complete' => 0,'approve_sequence' => 0]);

                // $this->db->where('order_no', $no_orders[$i]);
                // $this->db->update('order_product', $data_order_product[$i]);
            }
            $this->db->where('order_no', $no_orders[0]);
            $del = $this->db->delete('order_product');
            if ($del) {
                $this->db->insert_batch('order_product', $data_order_product);
            } else {
                echo "revisi order produk gagal";
                die;
            }

            $sequence = $this->db->order_by('sequence', 'asc')->where('departemen_id', $this->data['users']->group_id)->get('approve_po_rules')->result();
            $approve_list = [];
            $data_order = array();
            $notifikasi_list = [];
            $aktifitas_user = [];
            // email array, taro disini, nanti panggil setelah tidak ada error.
            $email_array = [];

            $ix = 0;
            foreach ($order as $k => $v) {

                if ($groups->departemen_code == 'WG') {
                    $no_surat = $this->input->post('nosuratmanual');
                    if ($no_surat === '') {
                        //die(var_dump($no_surat));
                        $data_return['status']  = FALSE;
                        $data_return['data']    = [];
                        $data_return['messages'] = "Tidak Bisa Order, No Surat Belum Di isi";
                        ob_end_clean();
                        echo json_encode($data_return);
                        return;
                    }
                } else {
                    // di file_helper
                    $no_surat = $no_surats[$ix];
                    // jika error ketika no _surat
                    if ($no_surat === FALSE) {
                        //die(var_dump($no_surat));
                        $data_return['status']  = FALSE;
                        $data_return['data']    = [];
                        $data_return['messages'] = "Tidak Bisa Order, No Surat Error";
                        ob_end_clean();
                        echo json_encode($data_return);
                        return;
                    }
                }


                // tambah aktifitas user
                $aktifitas_user[] = [
                    'user_id' => $user_id,
                    'description' => 'Revisi PO. No PO : ' . $v['order_no'],
                    'id_reff' => $v['order_no'],
                    // category 2 = order
                    'aktifitas_category' => 2,
                ];
                foreach ($sequence as $k2 => $v2) {
                    if ($k2 == 0) {
                        $message = "No Order " . $v['order_no'] . " dengan no surat " . $no_surat . " Perlu di approve";
                        // di file_helper
                        send_notifikasi_by_role_id($v2->role_id, $message);
                        // sms di comment dulu
                        send_sms_by_role_id($v2->role_id, $message);
                        $email_array[$v['order_no']] = $v2->role_id;
                    }
                    $approve_list[] = [
                        'order_no' => $v['order_no'],
                        'role_id' => $v2->role_id,
                        'created_by' => $this->data['users']->id,
                        'sequence' => $v2->sequence,
                    ];
                }
                $data_order[] =  array_merge($v, array('total_price' => $total_price[$k], 'no_surat' => $no_surat, 'order_gabungan_id' => $orderGabId));

                $ix++;
            }

            // untuk mengurangi volume_sisa di kontrak
            foreach ($volume_per_kontrak as $k => $v) {

                $this->db->set('volume_sisa', 'volume_sisa - ' . round($v, 4), FALSE)
                    ->set('volume_terpakai', 'volume_terpakai + ' . round($v, 4), FALSE)
                    ->where('id', $k)
                    ->update('project');
                //echo $this->db->last_query();
                //die();
            }

            // insert orderGabId ke Transport dan Asuransi
            $orderAsuransiFix = [];
            foreach ($orderAsuransi as $k => $v) {
                $orderAsuransiFix[] = array_merge($orderAsuransi[$k], ['order_gabungan_id' => $orderGabId]);
            }

            if (!empty($orderAsuransi)) {
                for ($i = 0; $i < count($no_orders); $i++) {
                    $this->db->where('order_no', $no_orders[$i]);
                    $this->db->update('order_asuransi', $orderAsuransiFix[$i]);
                }
            }

            if (!empty($orderAsuransiDetail)) {
                for ($i = 0; $i < count($no_orders); $i++) {
                    $this->db->where('order_no', $no_orders[$i]);
                    $this->db->update('order_asuransi_d', $orderAsuransiDetail[$i]);
                }
            }

            $orderTransportFix = [];
            foreach ($orderTransport as $k => $v) {
                $orderTransportFix[] = array_merge($orderTransport[$k], ['order_gabungan_id' => $orderGabId]);
            }

            if (!empty($orderTransportFix)) {
                for ($i = 0; $i < count($no_orders); $i++) {
                    $this->db->where('order_no', $no_orders[$i]);
                    $this->db->update('order_transportasi', $orderTransportFix[$i]);
                }
            }

            if (!empty($orderTransportDetail)) {
                for ($i = 0; $i < count($no_orders); $i++) {
                    $this->db->where('order_no', $no_orders[$i]);
                    $this->db->update('order_transportasi_d', $orderTransportDetail[$i]);
                }
            }

            if ($rev_s) {
                $this->db->where('order_no', $no_orders[0]);
                $this->db->update('order', $data_order[0]);
            } else {
                for ($i = 0; $i < count($no_orders); $i++) {
                    $this->db->where('order_no', $no_orders[$i]);
                    $this->db->update('order', $data_order[$i]);

                    // $this->db->where('order_no', $no_orders[$i]);
                    // $this->db->update('approve_po_list', $approve_list[$i]);
                }
            }

            $this->db->insert_batch('aktifitas_user', $aktifitas_user);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();

                $data_return['status']  = FALSE;
                $data_return['data']    = [];
                $data_return['messages'] = "Gagal Melakukan Pembayaran";
            } else {

                $this->db->trans_commit();
                // generatepdf dan kirim email ke role tujuan
                $this->load->library('email_po');
                $isEmailSend = TRUE;
                foreach ($order as $k => $v) {
                    $this->generatepdf($v['order_no']);
                    $this->datalelangproduct($v['order_no']);
                    $isEmailSend = $this->email_po->sendDetailPOByRoleId($email_array[$v['order_no']], $v['order_no']);
                }
                $this->session->unset_userdata('cart_session');
                $data_return['status']  = TRUE;
                $data_return['data']    = $data_order;
                $data_return['messages'] = "Sukses Melakukan Pembayaran";
                $data_return['email_send'] = $isEmailSend;
            }

            ob_end_clean();
            echo json_encode($data_return);
        } else {
            //$this->db->trans_begin();
            // order_gabungan_id, biar tahu PO2 mana saja yang dibuat dalam waktu yang sama
            $this->db->insert('order_gabungan', ['created_by' => $user_id]);
            $orderGabId = $this->db->insert_id();
            $this->db->insert_batch('order_product', $data_order_product);

            $sequence = $this->db->order_by('sequence', 'asc')->where('departemen_id', $this->data['users']->group_id)->get('approve_po_rules')->result();
            $approve_list = [];
            $data_order = array();
            $notifikasi_list = [];
            $aktifitas_user = [];
            // email array, taro disini, nanti panggil setelah tidak ada error.
            $email_array = [];
            foreach ($order as $k => $v) {

                if ($groups->departemen_code == 'WG') {
                    $no_surat = $this->input->post('nosuratmanual');
                    if ($no_surat === '') {
                        //die(var_dump($no_surat));
                        $data_return['status']  = FALSE;
                        $data_return['data']    = [];
                        $data_return['messages'] = "Tidak Bisa Order, No Surat Belum Di isi";
                        ob_end_clean();
                        echo json_encode($data_return);
                        return;
                    }
                } else {
                    // di file_helper
                    $no_surat = get_no_surat_api_wika(array_merge($params_no_surat, ['tujuan' => $v['vendor_name']]));
                    // jika error ketika no _surat
                    if ($no_surat === FALSE) {
                        //die(var_dump($no_surat));
                        $data_return['status']  = FALSE;
                        $data_return['data']    = [];
                        $data_return['messages'] = "Tidak Bisa Order, No Surat Error";
                        ob_end_clean();
                        echo json_encode($data_return);
                        return;
                    }
                }


                // tambah aktifitas user
                $aktifitas_user[] = [
                    'user_id' => $user_id,
                    'description' => 'Membuat PO. No PO : ' . $v['order_no'],
                    'id_reff' => $v['order_no'],
                    // category 2 = order
                    'aktifitas_category' => 2,
                ];
                foreach ($sequence as $k2 => $v2) {
                    if ($k2 == 0) {
                        $message = "No Order " . $v['order_no'] . " dengan no surat " . $no_surat . " Perlu di approve";
                        // di file_helper
                        send_notifikasi_by_role_id($v2->role_id, $message);
                        // sms di comment dulu
                        send_sms_by_role_id($v2->role_id, $message);
                        $email_array[$v['order_no']] = $v2->role_id;
                    }
                    $approve_list[] = [
                        'order_no' => $v['order_no'],
                        'role_id' => $v2->role_id,
                        'created_by' => $this->data['users']->id,
                        'sequence' => $v2->sequence,
                    ];
                }
                $data_order[] =  array_merge($v, array('total_price' => $total_price[$k], 'no_surat' => $no_surat, 'order_gabungan_id' => $orderGabId));
            }

            // untuk mengurangi volume_sisa di kontrak
            foreach ($volume_per_kontrak as $k => $v) {

                $this->db->set('volume_sisa', 'volume_sisa - ' . round($v, 4), FALSE)
                    ->set('volume_terpakai', 'volume_terpakai + ' . round($v, 4), FALSE)
                    ->where('id', $k)
                    ->update('project');
                //echo $this->db->last_query();
                //die();
            }

            // insert orderGabId ke Transport dan Asuransi
            $orderAsuransiFix = [];
            foreach ($orderAsuransi as $k => $v) {
                $orderAsuransiFix[] = array_merge($orderAsuransi[$k], ['order_gabungan_id' => $orderGabId]);
            }

            if (!empty($orderAsuransi)) {
                $this->db->insert_batch('order_asuransi', $orderAsuransiFix);
            }

            if (!empty($orderAsuransiDetail)) {
                $this->db->insert_batch('order_asuransi_d', $orderAsuransiDetail);
            }

            $orderTransportFix = [];
            foreach ($orderTransport as $k => $v) {
                $orderTransportFix[] = array_merge($orderTransport[$k], ['order_gabungan_id' => $orderGabId]);
            }

            if (!empty($orderTransportFix)) {
                $this->db->insert_batch('order_transportasi', $orderTransportFix);
            }

            if (!empty($orderTransportDetail)) {
                $this->db->insert_batch('order_transportasi_d', $orderTransportDetail);
            }

            $this->db->insert_batch('order', $data_order);
            $this->db->insert_batch('approve_po_list', $approve_list);
            $this->db->insert_batch('aktifitas_user', $aktifitas_user);
            $data_order['list_id_vendor'] = implode("-", $vendor_id_for_feedback);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();

                $data_return['status']  = FALSE;
                $data_return['data']    = [];
                $data_return['messages'] = "Gagal Melakukan Pembayaran";
            } else {

                $this->db->trans_commit();
                // generatepdf dan kirim email ke role tujuan
                $this->load->library('email_po');
                $isEmailSend = TRUE;
                foreach ($order as $k => $v) {
                    $this->generatepdf($v['order_no']);
                    $this->datalelangproduct($v['order_no']);
                    $isEmailSend = $this->email_po->sendDetailPOByRoleId($email_array[$v['order_no']], $v['order_no']);
                }
                $this->session->unset_userdata('cart_session');
                $data_return['status']  = TRUE;
                $data_return['data']    = $data_order;
                $data_return['messages'] = "Sukses Melakukan Pembayaran";
                $data_return['email_send'] = $isEmailSend;
            }
            ob_end_clean();
            echo json_encode($data_return);
        }
    }
    public function datalelangproduct($order_no)
    {
        $this->load->model('order_product_model');
        $this->load->model('Order_transportasi_model');
        $this->load->model('order_model');
        $this->load->model('User_model');
        $order = $this->order_model->getDataOneBy(['order.order_no' => $order_no]);
        $order_menu = $this->order_product_model->getAllDataById(['order_product.order_no' => $order_no]);
        $department = $this->User_model->getDepartmentUser($order->created_by);
        $orderTransportasi = $this->Order_transportasi_model->getDataPdfTransport(['order_transportasi.order_no' => $order_no]);

        //echo json_encode($orderTransportasi);
        //die;
        $no_contract = "";
        $tgl_contract = "";
        $end_contract = "";
        $project_id = "";
        $count = 0;
        //berarti kontrak_id di table order ada, langsung ambil no kontrak na
        if ($order->kontrak_id != '' && $order->kontrak_id != '0') {
            $tgl_contract = $order->tgl_contract;
            $end_contract = $order->end_contract;
            $no_contract = $order->no_contract;
            $project_id = $order->project_id;
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
                    $end_contract = $v->end_contract;
                    $no_contract = $v->no_contract;
                    if ($v->no_amandemen != '') {
                        $no_contract .= '-Amd' . $v->no_amandemen;
                    }
                }
            }
        }
        if (!empty($order_menu)) {
            foreach ($order_menu as $k => $v) {
                $data_produk = array(
                    "departemen" => $department->group_id,
                    "kategori" => $v->code_1,
                    "nama" => $v->full_name_product,
                    "no_kontrak" => $no_contract,
                    "vendor" =>  $v->vendor_id,
                    "tgl_terkontrak" =>  $tgl_contract,
                    "tgl_akhir_kontrak" =>  $end_contract,
                    "harga" =>  $v->price,
                    "volume" =>  $v->qty,
                    "satuan" =>  $v->product_uom_id,
                    "proyek_pengguna" =>  $project_id,
                    "keterangan" =>  $v->payment_mehod_name,
                    "created_by" =>  $order->created_by

                );
                $this->db->insert('data_lelang_new', $data_produk);
                $count++;
            }
        }
        if (!empty($orderTransportasi)) {
            $t = $orderTransportasi;
            $data_transportasi = array(
                "departemen" => $department->group_id,
                "kategori" => $t->kode_sda,
                "nama" => $t->sda_name,
                "no_kontrak" => $t->no_kontrak_transport,
                "vendor" =>  $t->vendor_id,
                "tgl_terkontrak" =>  $t->tgl_kontrak,
                "tgl_akhir_kontrak" =>  $t->tgl_akhir_kontrak,
                "harga" =>  $t->biaya_transport,
                "volume" => $t->total_weight,
                "satuan" =>  2,
                "proyek_pengguna" =>  $t->project_id,
                "keterangan" =>  $t->keterangan_transport,
                "created_by" =>  $order->created_by

            );
            $this->db->insert('data_lelang_new', $data_transportasi);
            $count++;
        }
        if (!empty($order_menu)) {
            $dataHistory = [
                'jml_row' => $count,
                'created_by' => $this->data['users']->id,
            ];

            $this->db->insert('data_lelang_upload_history', $dataHistory);
        }
    }
    public function generatepdf($order_no)
    {

        $this->load->model('order_product_model');
        $this->load->model('order_model');
        $order = $this->order_model->getDataOneBy(['order.order_no' => $order_no]);
        $order_menu = $this->order_product_model->getAllDataById(['order_product.order_no' => $order_no]);
        $this->load->model('User_model');
        $data['department'] = $this->User_model->getDepartmentUser($order->created_by);
        $data['pake_ttd'] = FALSE;
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
        //$this->load->view('frontend/email/order_po',$data);


        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
        $html = $this->load->view('frontend/email/order_po', $data, true);
        $mpdf->WriteHTML($html);
        $mpdf->SetMargins(0, 0, 0);
        $filename = "PO_" . $order_no . '_' . time();
        $mpdf->Output("pdf/po/" . $filename . ".pdf", "F");
        //die($filename);
        $this->order_model->update(['pdf_name' => $filename . ".pdf"], ['order_no' => $order_no]);
    }

    public function pay_old_jangan_dulu_dihapus_bisi_lupa()
    {
        $order_no   = $this->generate_order_no();
        $product    = $this->input->post('arr_product_id');
        $uom_id     = $this->input->post('arr_uom_id');
        $price      = $this->input->post('arr_price');
        $weight     = $this->input->post('arr_weight');
        $quantity   = $this->input->post('quantity');
        $perihal    = $this->input->post('perihal');
        $user_id    = $this->input->post('user_id');
        $arr_payment_method_id    = $this->input->post('arr_payment_method_id');
        //$payment_method_id   = $this->input->post('payment_method_id');
        $shipping_id   = $this->input->post('shipping_id');
        $arr_include_price = $this->input->post('arr_include_price');

        $total_order  =  count($product);
        $data_order_menu = array();
        $data_order = array();
        $this->db->trans_begin(); # Starting Transaction
        $this->db->trans_strict(TRUE);
        $total_price = 0;
        for ($i = 0; $i < $total_order; $i++) {
            $total_price += $price[$i] * $quantity[$i] * $weight[$i];
            $total_price += $arr_include_price[$i];
            $data_order_menu[$i]['order_no']        = $order_no;
            $data_order_menu[$i]['product_id']      = $product[$i];
            $data_order_menu[$i]['qty']             = $quantity[$i];
            $data_order_menu[$i]['product_uom_id']  = $uom_id[$i];
            $data_order_menu[$i]['order_product_status']  = 1;
            $data_order_menu[$i]['created_by']  = $user_id;
            $data_order_menu[$i]['payment_method_id']  = $arr_payment_method_id[$i];
            $data_order_menu[$i]['price']  = $price[$i];
            $data_order_menu[$i]['include_price']  = $arr_include_price[$i];
            $data_order_menu[$i]['weight']  = $weight[$i];
            $data_order_menu[$i]['full_name_product']  = $this->input->post('full_name_product')[$i];
            $data_order_menu[$i]['payment_mehod_name']  = $this->input->post('payment_method_full')[$i];
            $data_order_menu[$i]['uom_name']  = $this->input->post('uom_name')[$i];
            $data_order_menu[$i]['vendor_id']  = $this->input->post('vendor_id')[$i];
            $data_order_menu[$i]['vendor_name']  = $this->input->post('vendor_name')[$i];
        }

        //die(var_dump($product));
        $this->db->insert_batch('order_product', $data_order_menu);

        $data_order = array(
            "order_no" => $order_no,
            "total_price" => $total_price,
            "perihal" => $perihal,
            //"payment_method_id" =>$payment_method_id,
            "shipping_id" => $shipping_id,
            "order_status" => 1,
            "created_by" => $user_id,

        );
        //die(var_dump($data_order));
        $this->db->insert('order', $data_order);

        if ($this->db->trans_status() === FALSE) {
            # Something went wrong.
            $this->db->trans_rollback();

            $data_return['status']  = FALSE;
            $data_return['data']    = [];
            $data_return['messages'] = "Gagal Melakukan Pembayaran";
        } else {
            # Everything is Perfect.
            # Committing data to the database.
            $data['order_no'] = $order_no;
            $this->db->trans_commit();
            $this->session->unset_userdata('cart_session');
            $data_return['status']  = TRUE;
            $data_return['data']    = $data;
            $data_return['messages'] = "Sukses Melakukan Pembayaran";
        }

        echo json_encode($data_return);
    }

    /*
    $jenisPo = 1 => produk, 2 => transportasi, 3 asuransi
    */

    public function generate_order_no($jenisPo = 1)
    {
        $date = new DateTime(null, new DateTimeZone('Asia/Jakarta'));
        $now = $date->format('Y-m-d H:i:s');
        $year = $date->format('y');
        $month = $date->format('m');
        $day = $date->format('d');
        $this->db->insert('stored_id', ['dummy_column' => 1, 'jenis_po' => $jenisPo]);
        $where = array();
        $where['DATE(created_at) = DATE(NOW())'] = null;
        $where['jenis_po'] = $jenisPo;
        $max = $this->order_model->getmaxcounttoday($where);
        if ($max->total) {
            $max = $max->total + 1;
            $max = str_pad($max, 4, "0", STR_PAD_LEFT);
        } else {
            $max = 1;
            $max = str_pad($max, 4, "0", STR_PAD_LEFT);
        }

        $order_no = $year . $month . $day . $max;

        return $order_no;
    }


    public function orderhistory()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        } else {
            $this->data['order'] = $this->order_model->getAllDataBy(['order.created_by' => $this->data['users']->id]);
            // echo "<pre>";
            // print_r($this->data['order']);
            $this->data['departemen'] = $this->Groups_model->get_dropdown();
            $this->data['content']  = 'frontend/mycart/history';
            $this->load->view('frontend/layouts/page', $this->data);
        }
    }
}
