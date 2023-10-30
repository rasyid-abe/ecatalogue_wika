<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Product extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
        $this->load->model('product_gallery_model');
        $this->load->model('vendor_model');
        $this->load->model('location_model');
        $this->load->model('size_model');
        $this->load->model('uoms_model');
        $this->load->model('Resources_code_model');
        $this->load->model('specification_model');
        $this->load->model('tod_model');
        $this->load->model('category_model');
    }

    public function cek()
    {
        echo json_encode([]);
    }

    public function index()
    {
        $this->load->helper('url');
        if ($this->data['is_can_read']) {
            $where_vendor = [];

            if ($this->data['users_groups']->id == 3) {
                $where_vendor['vendor.id'] = $this->data['users']->vendor_id;
            }

            $this->data['json_size'] = json_encode($this->size_model->getAllById());
            $this->data['vendor'] = $this->vendor_model->getvendor($where_vendor);
            $this->data['category'] = $this->category_model->getAllById();
            $this->data['specification'] = $this->specification_model->getAllById();
            $this->data['location'] = $this->location_model->getAllById();
            $this->data['kode_sda'] = $this->product_model->get_combo_sumber_daya();
            $this->data['content']  = 'admin/product/list_v';
        } else {
            redirect('restrict');
        }
        $this->load->view('admin/layouts/page', $this->data);
    }

    public function create()
    {
        $this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');
        //$this->form_validation->set_rules('specification_id', "Spesifikasi Harus Diisi", 'trim|required');
        // $this->form_validation->set_rules('size_id',"Ukuran Harus Diisi", 'trim|required');
        $this->form_validation->set_rules('vendor_id', "Vendor Harus Diisi", 'trim|required');
        //$this->form_validation->set_rules('term_of_delivery_id',"Term Of Delivery Harus Diisi", 'trim|required');
        $this->form_validation->set_rules('uom_id', "Satuan Harus Diisi", 'trim|required');
        $this->form_validation->set_rules('level1', "Sumber Daya Harus Diisi", 'trim|required');


        if ($this->form_validation->run() === TRUE) {
            $level2 = $this->input->post('level2');
            $level3 = $this->input->post('level3');
            $level4 = $this->input->post('level4');
            $level5 = $this->input->post('level5');
            $level6 = $this->input->post('level6');
            if (!empty($level2) && empty($level3))
                $kode_sda = $this->input->post('level2');
            elseif (!empty($level3) && empty($level4))
                $kode_sda = $this->input->post('level3');
            elseif (!empty($level4) && empty($level5))
                $kode_sda = $this->input->post('level4');
            elseif (!empty($level5) && empty($level6))
                $kode_sda = $this->input->post('level5');
            elseif (!empty($level6))
                $kode_sda = $this->input->post('level6');
            else
                $kode_sda = $this->input->post('level1');


            $date = new DateTime(null, new DateTimeZone('Asia/Jakarta'));
            $now = $date->format('Y-m-d H:i:s');
            $data = array(
                'name' => $this->input->post('name'),
                'note' => $this->input->post('note'),
                'code_1' => $kode_sda,
                //'code' => $this->input->post('code_2'),
                'volume' => 0,
                //'specification_id' => $this->input->post('specification_id'),
                //'size_id' => $this->input->post('size_id'),
                'vendor_id' => $this->input->post('vendor_id'),
                'location_id' => $this->input->post('location_id'),
                'term_of_delivery_id' => $this->input->post('term_of_delivery_id'),
                'berat_unit' => $this->input->post('berat_unit'),
                'uom_id' => $this->input->post('uom_id'),
                //'category_id' => $kode_sda,
                'created_by' => $this->data['users']->id,
                'created_at' => $now,
            );
            $upload = 1;
            $this->db->trans_begin();

            $insert = $this->product_model->insert($data);
            if ($insert) {
                $gallery = array();
                for ($i = 0; $i < 4; $i++) {
                    if ($_FILES['product_gallery' . $i]['name']) {
                        $config['upload_path']          = './product_gallery/';
                        $config['allowed_types']        = '*';
                        $config['max_size']             = 20000;
                        $random = rand(1000, 9999);
                        $do_upload = 'product_gallery' . $i;
                        $filename = pathinfo($_FILES['product_gallery' . $i]["name"]);
                        $extension = $filename['extension'];
                        $config['file_name'] = $random . time() . "." . $extension;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload($do_upload)) {
                            $gallery = array(
                                "product_id" => $insert,
                                "filename" => $config['file_name'],
                            );
                            $this->product_gallery_model->insert($gallery);
                            $upload = 1;
                        } else {
                            $upload = 0;
                        }
                    }
                }

                if ($this->input->post('harga')) {
                    $data_harga = [];
                    foreach ($this->input->post('harga') as $key => $v) {
                        $data_harga[] = [
                            'product_id' => $insert,
                            'payment_id' => $this->input->post('payment_id')[$key],
                            'price' => $v,
                            'location_id' => isset($this->input->post('location_id_ar')[$key]) ? implode(',', $this->input->post('location_id_ar')[$key]) : NULL,
                            'notes' => isset($this->input->post('notes')[$key]) ? $this->input->post('notes')[$key] : NULL,
                        ];
                    }

                    $this->db->insert_batch('payment_product', $data_harga);
                }

                if ($this->input->post('include_desc') || $this->input->post('include_price')) {
                    $data_include = [];
                    foreach ($this->input->post('include_desc') as $key => $v) {
                        $data_include[] = array(
                            'product_id' => $insert,
                            'price'      => $this->input->post('include_price')[$key],
                            'description' => $v
                        );
                    }

                    $this->db->insert_batch('product_include_price', $data_include);
                }

                $data_akt = [
                    'user_id' => $this->data['users']->id,
                    'description' => 'Tambah Product ' . $this->input->post('name'),
                    'aktifitas_category' => 1,
                    'id_reff' => $insert
                ];

                $this->db->insert('aktifitas_user', $data_akt);

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message_error', "Data Produk Disimpan, Sebagian File Gagal Diupload");
                    redirect("product");
                } else {
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Produk Baru Berhasil Disimpan");
                    redirect("product");
                }
            } else {
                $this->session->set_flashdata('message_error', "Produk Baru Gagal Disimpan");
                redirect("product");
            }
        } else {
            if ($this->data['is_can_create']) {
                $this->data['specification'] = $this->specification_model->getAllById(['specification.is_deleted' => 0]);
                $where_vendor = array();
                $where_vendor['vendor.is_deleted'] = 0;
                if (!$this->data['is_superadmin']) {
                    $where_vendor['vendor.id'] = $this->data['users']->vendor_id;
                }
                $this->data['vendor'] = $this->vendor_model->getvendor($where_vendor);
                $this->data['category'] = $this->category_model->getAllById(['category.is_deleted' => 0]);
                $this->data['location'] = $this->location_model->getAllById(['location.is_deleted' => 0]);
                $this->data['uom'] = $this->uoms_model->getAllById(['uoms.is_deleted' => 0]);
                $this->data['json_size'] = json_encode($this->size_model->getAllById(['size.is_deleted' => 0]));
                $this->data['tod'] = $this->tod_model->getAllById(['tod.is_deleted' => 0]);
                $this->data['level1'] = $this->Resources_code_model->get_dropdown2(['level' => 1, 'status' => 1]);
                $this->load->model('payment_method_model');
                $this->data['payment_method'] = $this->payment_method_model->getAllById(['payment_method.is_deleted' => 0]);
                $this->data['content']  = 'admin/product/create_v';
            } else {
                redirect('restrict');
            }
            $this->load->view('admin/layouts/page', $this->data);
        }
    }

    public function edit($id)
    {
        $this->load->helper('url');
        $this->data['id'] = $this->uri->segment(3);

        if ($this->data['is_can_edit']) {
            $this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');
            //$this->form_validation->set_rules('specification_id', "Spesifikasi Harus Diisi", 'trim|required');
            // $this->form_validation->set_rules('size_id',"Ukuran Harus Diisi", 'trim|required');
            $this->form_validation->set_rules('vendor_id', "Vendor Harus Diisi", 'trim|required');
            // $this->form_validation->set_rules('term_of_delivery_id',"Term Of Delivery Harus Diisi", 'trim|required');
            $this->form_validation->set_rules('uom_id', "Satuan Harus Diisi", 'trim|required');
            $this->form_validation->set_rules('level1', "Sumber Daya Harus Diisi", 'trim|required');

            if ($this->form_validation->run() === TRUE) {
                $level2 = $this->input->post('level2');
                $level3 = $this->input->post('level3');
                $level4 = $this->input->post('level4');
                $level5 = $this->input->post('level5');
                $level6 = $this->input->post('level6');
                if (!empty($level2) && empty($level3))
                    $kode_sda = $this->input->post('level2');
                elseif (!empty($level3) && empty($level4))
                    $kode_sda = $this->input->post('level3');
                elseif (!empty($level4) && empty($level5))
                    $kode_sda = $this->input->post('level4');
                elseif (!empty($level5) && empty($level6))
                    $kode_sda = $this->input->post('level5');
                elseif (!empty($level6))
                    $kode_sda = $this->input->post('level6');
                else
                    $kode_sda = $this->input->post('level1');

                $data = array(
                    'name' => $this->input->post('name'),
                    'note' => $this->input->post('note'),
                    'code_1' => $kode_sda,
                    //'code' => $this->input->post('code_2'),
                    'volume' => 0,
                    //'specification_id' => $this->input->post('specification_id'),
                    //'size_id' => $this->input->post('size_id'),
                    'vendor_id' => $this->input->post('vendor_id'),
                    'location_id' => $this->input->post('location_id'),
                    'term_of_delivery_id' => $this->input->post('term_of_delivery_id'),
                    'berat_unit' => $this->input->post('berat_unit'),
                    'uom_id' => $this->input->post('uom_id'),
                    //'category_id' => $kode_sda,
                    'updated_by' => $this->data['users']->id,
                    //'is_include'    => $this->input->post('is_include') ? 1 : 0,
                    //'include_price' => $this->input->post('include_price'),
                );
                $upload = 1;
                $gallery = array();
                for ($i = 0; $i < 4; $i++) {
                    if ($_FILES['product_gallery' . $i]['name']) {
                        $config['upload_path']          = './product_gallery/';
                        $config['allowed_types']        = '*';
                        $config['max_size']             = 20000;
                        $random = rand(1000, 9999);
                        $do_upload = 'product_gallery' . $i;
                        $filename = pathinfo($_FILES['product_gallery' . $i]["name"]);
                        $extension = $filename['extension'];
                        $config['file_name'] = $random . time() . "." . $extension;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload($do_upload)) {
                            $gallery = array(
                                "product_id" => $id,
                                "filename" => $config['file_name'],
                            );
                            $this->product_gallery_model->insert($gallery);
                            if ($this->input->post('old_filename' . $i)) {
                                unlink($config['upload_path'] . $this->input->post('old_filename' . $i));
                                $this->product_gallery_model->delete(['product_gallery.filename' => $this->input->post('old_filename' . $i)]);
                            }
                            $upload = 1;
                        } else {
                            $upload = 0;
                        }
                    }
                }

                $harga_lama = $this->product_model->findproduct(array("product.id" => $id))->price;
                $update = $this->product_model->update($data, array("product.id" => $id));

                if ($update || $upload) {
                    $this->db->trans_begin();
                    /*
                berisi list_project dan methode_pembayarannya
                list_project indexnya, methode_pembayarannya valuenya
                */
                    $this->load->model('Project_model');
                    $list_project = $this->Project_model->get_project_contain_product_id($id);

                    if ($this->input->post('harga')) {
                        $this->load->model('Project_products_model');

                        $this->load->model('payment_product_model');
                        $this->payment_product_model->delete(['product_id' => $id]);
                        $data_harga = [];
                        foreach ($this->input->post('harga') as $key => $v) {
                            $data_harga[] = [
                                'product_id' => $id,
                                'payment_id' => $this->input->post('payment_id')[$key],
                                'price' => $v,
                                'location_id' => isset($this->input->post('location_id_ar')[$key]) ? implode(',', $this->input->post('location_id_ar')[$key]) : NULL,
                                'notes' => isset($this->input->post('notes')[$key]) ? $this->input->post('notes')[$key] : NULL,
                            ];
                        }

                        $this->db->insert_batch('payment_product', $data_harga);
                    }
                    //die();
                    $this->load->model('Product_include_price_model');
                    // hapus data include_price
                    if ($this->input->post('id_yang_dihapus') != '') {
                        $arr = explode(',', $this->input->post('id_yang_dihapus'));
                        foreach ($arr as $v) {
                            $this->Product_include_price_model->update(['is_deleted' => 1], ['id' => $v]);
                        }
                    }

                    // update atau insert include_price
                    if ($this->input->post('include_desc') || $this->input->post('include_price')) {
                        foreach ($this->input->post('include_desc') as $k => $v) {
                            if ($this->input->post('ket')[$k] == 'update') {
                                $data = array(
                                    'description' => $v,
                                    'price'       => $this->input->post('include_price')[$k],
                                );
                                $this->Product_include_price_model->update($data, ['id' => $this->input->post('pkey')[$k]]);
                            } else if ($this->input->post('ket')[$k] == 'insert') {
                                $data = array(
                                    'description' => $v,
                                    'price'       => $this->input->post('include_price')[$k],
                                    'product_id'  => $id,
                                );

                                $this->Product_include_price_model->insert($data);
                            }
                        }
                    }
                    //die();
                    $data_akt = [
                        'user_id' => $this->data['users']->id,
                        'description' => 'Edit Product ' . $this->input->post('name'),
                        'aktifitas_category' => 1,
                        'id_reff' => $id
                    ];

                    $this->db->insert('aktifitas_user', $data_akt);

                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message_error', "Produk Gagal Diubah");
                    } else {
                        $this->db->trans_commit();
                        $this->session->set_flashdata('message', "Produk Berhasil Diubah");
                    }
                    redirect("product", "refresh");
                } else {
                    $this->session->set_flashdata('message_error', "Produk Gagal Diubah");
                    redirect("product", "refresh");
                }
            } else {
                $this->data['content']  = 'admin/product/edit_v';
                $data = $this->product_model->findproduct(array("product.id" => $this->data['id']));
                $this->data['name'] =   (!empty($data)) ? $data->name : "";
                $this->data['code'] =   (!empty($data)) ? $data->code : "";
                $this->data['specification_id'] =   (!empty($data)) ? $data->specification_id : "";
                $this->data['size_id'] =   (!empty($data)) ? $data->size_id : "";
                $this->data['price'] =   (!empty($data)) ? $data->price : "";
                $this->data['reference'] =   (!empty($data)) ? $data->reference : "";
                $this->data['vendor_id'] =   (!empty($data)) ? $data->vendor_id : "";
                $this->data['location_id'] =   (!empty($data)) ? $data->location_id : "";
                $this->data['term_of_delivery_id'] =   (!empty($data)) ? $data->term_of_delivery_id : "";
                $this->data['volume'] =   (!empty($data)) ? $data->volume : "";
                $this->data['berat_unit'] =   (!empty($data)) ? $data->berat_unit : "";
                $this->data['uom_id'] =   (!empty($data)) ? $data->uom_id : "";
                $this->data['note'] =   (!empty($data)) ? $data->note : "";
                $this->data['category_id'] =   (!empty($data)) ? $data->category_id : "";
                $this->data['is_include'] =   (!empty($data)) ? $data->is_include : "";
                $this->data['include_price'] =   (!empty($data)) ? $data->include_price : "";
                $this->data['code_1'] =   (!empty($data)) ? $data->code_1 : "";

                $kode_sda = (!empty($data)) ? $data->code_1 : "";
                $level6 = $this->db->get_where('resources_code', ['code' => $kode_sda])->row_array();
                $level5 = $level6['level'] == 5 ? $this->db->get_where('resources_code', ['code' => $kode_sda])->row_array() : $this->db->get_where('resources_code', ['code' => $level6['parent_code']])->row_array();
                $level4 = $level6['level'] == 4 ? $this->db->get_where('resources_code', ['code' => $kode_sda])->row_array() : $this->db->get_where('resources_code', ['code' => $level5['parent_code']])->row_array();
                $level3 = $level6['level'] == 3 ? $this->db->get_where('resources_code', ['code' => $kode_sda])->row_array() : $this->db->get_where('resources_code', ['code' => $level4['parent_code']])->row_array();
                $level2 = $level6['level'] == 2 ? $this->db->get_where('resources_code', ['code' => $kode_sda])->row_array() : $this->db->get_where('resources_code', ['code' => $level3['parent_code']])->row_array();
                $level1 = $level6['level'] == 1 ? $this->db->get_where('resources_code', ['code' => $kode_sda])->row_array() : $this->db->get_where('resources_code', ['code' => $level2['parent_code']])->row_array();
                $this->data['level6'] = (!empty($level6)) ? $level6['code'] : "";
                $this->data['level5'] = (!empty($level5)) ? $level5['code'] : "";
                $this->data['level4'] = (!empty($level4)) ? $level4['code'] : "";
                $this->data['level3'] = (!empty($level3)) ? $level3['code'] : "";
                $this->data['level2'] = (!empty($level2)) ? $level2['code'] : "";
                $this->data['level1'] = (!empty($level1)) ? $level1['code'] : "";

                $this->data['sel_level1'] = $this->Resources_code_model->get_dropdown3(['level' => 1, 'status' => 1]);
                $this->data['sel_level2'] = $this->Resources_code_model->get_dropdown3(['level' => 2, 'parent_code' => $level1['code'], 'status' => 1]);
                $this->data['sel_level3'] = $this->Resources_code_model->get_dropdown3(['level' => 3, 'parent_code' => $level2['code'], 'status' => 1]);
                $this->data['sel_level4'] = $this->Resources_code_model->get_dropdown3(['level' => 4, 'parent_code' => $level3['code'], 'status' => 1]);
                $this->data['sel_level5'] = $this->Resources_code_model->get_dropdown3(['level' => 5, 'parent_code' => $level4['code'], 'status' => 1]);
                $this->data['sel_level6'] = $this->Resources_code_model->get_dropdown3(['level' => 6, 'parent_code' => $level5['code'], 'status' => 1]);



                $where_vendor = array();
                $where_vendor['vendor.is_deleted'] = 0;
                if (!$this->data['is_superadmin']) {
                    $where_vendor['vendor.id'] = $this->data['users']->vendor_id;
                }
                $this->data['vendor'] = $this->vendor_model->getvendor($where_vendor);
                $this->data['category'] = $this->category_model->getAllById(['category.is_deleted' => 0]);
                $this->data['location'] = $this->location_model->getAllById(['location.is_deleted' => 0]);
                $this->data['specification'] = $this->specification_model->getAllById(['is_deleted' => 0]);
                if ($data->berat_unit > 0)
                    $this->data['uom'] = $this->uoms_model->getAllById(['uoms.is_deleted' => 0, 'uoms.id' => $data->uom_id]);
                else
                    $this->data['uom'] = $this->uoms_model->getAllById(['uoms.is_deleted' => 0]);

                $where_size = array();
                $where_size['size.is_deleted'] = 0;
                if ($this->data['specification_id']) {
                    $where_size['size.specification_id'] = $this->data['specification_id'];
                }
                $this->data['size'] = $this->size_model->getAllById($where_size);
                $this->data['json_size'] = json_encode($this->size_model->getAllById(['size.is_deleted' => 0]));

                $product_gallery = $this->product_gallery_model->getAllById(['product_gallery.product_id' => $id]);
                for ($i = 0; $i < 4; $i++) {
                    $this->data['old_product_gallery'][$i] = base_url() . "assets/images/noimage.png";
                    $this->data['old_filename'][$i] = "";
                }

                if ($product_gallery) {
                    foreach ($product_gallery as $key => $value) {
                        $this->data['old_product_gallery'][$key] = base_url() . "product_gallery/" . $value->filename;
                        $this->data['old_filename'][$key] = $value->filename;
                    }
                }
                $data_berat = $this->db->get_where('resources_berat', ['code' => $kode_sda])->result_array();
                for ($x = 1; $x <= 3; $x++) {
                    foreach ($data_berat as $row) {
                        $coba[$x]['berat'] = $row['berat' . $x];
                        $coba[$x]['satuan'] = $row['satuan' . $x];
                    }
                }
                $this->data['sel_berat'] =  $coba;
                $this->load->model('Vendor_lokasi_model');
                $this->data['arrLocationVendor'] = $this->Vendor_lokasi_model->getAllById(['vendor_id' => $this->data['vendor_id']]);
                $this->data['tod'] = $this->tod_model->getAllById(['tod.is_deleted' => 0]);
                $this->load->model('payment_method_model');
                $this->load->model('payment_product_model');
                $this->load->model('Product_include_price_model');
                $this->data['payment_method'] = $this->payment_method_model->getAllById(['payment_method.is_deleted' => 0]);
                $this->data['payment_product'] = $this->payment_product_model->getAllById(['product_id' => $id]);
                $this->data['product_include_price'] = $this->Product_include_price_model->getAllById(['product_id' => $id, 'is_deleted' => 0]);
            }
        } else {
            redirect('restrict');
        }
        $this->load->view('admin/layouts/page', $this->data);
    }
    public function get_jenis()
    {
        $kategori = $this->input->post('kategori', true);
        $data = $this->db->get_where('resources_code', ['parent_code' => $kategori, 'status' => 1])->result_array();
        echo json_encode($data);
    }

    public function get_level3()
    {
        $jenis = $this->input->post('jenis', true);
        $data = $this->db->get_where('resources_code', ['parent_code' => $jenis, 'status' => 1])->result_array();
        echo json_encode($data);
    }

    public function get_level4()
    {
        $level3 = $this->input->post('level3', true);
        $data = $this->db->get_where('resources_code', ['parent_code' => $level3, 'status' => 1])->result_array();
        echo json_encode($data);
    }
    public function get_level5()
    {
        $level4 = $this->input->post('level4', true);
        $data = $this->db->get_where('resources_code', ['parent_code' => $level4, 'status' => 1])->result_array();
        echo json_encode($data);
    }
    public function get_level6()
    {
        $level5 = $this->input->post('level5', true);
        $data = $this->db->get_where('resources_code', ['parent_code' => $level5, 'status' => 1])->result_array();
        echo json_encode($data);
    }
    public function get_berat()
    {
        $level = $this->input->post('level');
        $data = $this->db->get_where('resources_berat', ['code' => $level])->result_array();
        for ($x = 1; $x <= 3; $x++) {
            foreach ($data as $row) {
                $coba[$x]['berat'] = $row['berat' . $x];
                $coba[$x]['satuan'] = $row['satuan' . $x];
            }
        }
        echo json_encode($coba);
    }
    public function get_uom()
    {
        $satuan = $this->input->post('satuan');
        $data = $this->db->get_where('uoms', ['id' => $satuan])->result_array();
        echo json_encode($data);
    }
    public function dataList()
    {
        $columns = array(
            0 => 'product.id',
            1 => 'vendor.name',
            2 => 'product.name',
            3 => 'product.code_1',
            4 => 'resources_code.name',
            5 => 'size.name',
        );


        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $where['product.is_deleted !='] = 2;

        if ($this->data['users_groups']->id == 3) {
            $where['product.vendor_id'] = $this->data['users']->vendor_id;
        }

        $limit = 0;
        $start = 0;
        $totalData = $this->product_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
        // print_r($totalData);

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;

        if (!empty($this->input->post('search')['value'])) {
            $isSearchColumn = true;
            $search_value = $this->input->post('search')['value'];
            $search = array(
                "product.name" => $search_value,
                "product.code" => $search_value,
                "product.code_1" => $search_value,
            );
        }

        if (!empty($searchColumn[3]['search']['value'])) {
            $value = $searchColumn[3]['search']['value'];
            $isSearchColumn = true;
            $where['product.vendor_id'] = $value;
        }
        if (!empty($searchColumn[4]['search']['value'])) {
            $value = $searchColumn[4]['search']['value'];
            $isSearchColumn = true;
            $where['product.code_1'] = $value;
        }
        //$tes = $searchColumn[4]['search']['value'];
        //echo json_encode($where);
        //die;

        if ($isSearchColumn) {
            $totalFiltered = $this->product_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
        } else {
            $totalFiltered = $totalData;
        }

        // print_r($totalFiltered);
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $datas = $this->product_model->getAllBy($limit, $start, $search, $order, $dir, $where);

        $new_data = array();
        if (!empty($datas)) {
            foreach ($datas as $key => $data) {

                $edit_url = "";
                $delete_url = "";
                $delete_permanent = "";

                if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
                    $edit_url =  "<a href='" . base_url() . "product/edit/" . $data->id . "' data-id='" . $data->id . "' style='color: white;'><div class='btn btn-sm btn-primary btn-blue btn-editview '>Edit</div></a>";
                }
                if ($this->data['is_can_delete']) {
                    if ($data->is_deleted == 0) {
                        $delete_url = "<a href='#'
                            data-id='" . $data->id . "' data-isdeleted='" . $data->is_deleted . "' class='btn btn-sm btn-danger white delete' url='" . base_url() . "product/destroy/" . $data->id . "/" . $data->is_deleted . "' >Non Aktifkan
                            </a>";
                    } else {
                        $delete_url = "<a href='#'
                            data-id='" . $data->id . "' data-isdeleted='" . $data->is_deleted . "' class='btn btn-sm btn-success white delete'
                             url='" . base_url() . "product/destroy/" . $data->id . "/" . $data->is_deleted . "'>Aktifkan
                            </a>";
                        $delete_permanent = "<a  href='#' url='" . base_url() . "product/destroy_permanent/" . $data->id . "' class='btn btn-sm btn-danger white delete'><i class='fa fa-trash-o'></i> Hapus</a>";
                    }
                }
                $nestedData['id']             = $start + $key + 1;;
                $nestedData['vendor_name']    = $data->vendor_name;
                $nestedData['name']           = $data->name;
                $nestedData['specification_name']  = $data->specification_name;
                $nestedData['vendor_name']    = $data->vendor_name;
                $nestedData['size_name']      = $data->size_name;
                $nestedData['uom_name']       = $data->uom_name;
                $nestedData['code']       = $data->code_1;
                if ($data->is_deleted == 0) {
                    $nestedData['status']     = "Active";
                } else {
                    $nestedData['status']     = "Inactive";
                }
                $nestedData['action']         = $edit_url . " " . $delete_url . " " . $delete_permanent;
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
            $this->db->trans_start();
            $data = array(
                'is_deleted' => ($is_deleted == 1) ? 0 : 1
            );
            $update = $this->product_model->update($data, array("id" => $id));

            $data_akt = [
                'user_id' => $this->data['users']->id,
                'description' => 'Set ' . ($is_deleted == 1 ? 'Active' : 'Inactive') . ' Product',
                'aktifitas_category' => 1,
                'id_reff' => $id
            ];

            $this->db->insert('aktifitas_user', $data_akt);

            $this->db->trans_complete();

            $response_data['data'] = $data;
            $response_data['status'] = $this->db->trans_status();
        } else {
            $response_data['msg'] = "ID Harus Diisi";
        }

        echo json_encode($response_data);
    }

    function cek_find_all_data_product()
    {
        $this->product_model->findAllDataProduct(['product.id' => 15]);
    }

    public function getProductsByVenId()
    {
        $return = [];
        $vendor_id = $this->input->post('vendor_id');
        $level2 = $this->input->post('level2');
        $string_level2 = substr($level2, 0, 2);
        //$where['product.vendor_id'] = $vendor_id;
        //$where['product.code_1'] = $string_level2;
        $return['data'] = $this->product_model->getAllDataProduct(['product.vendor_id' => $vendor_id, "product.code_1 like '" . $string_level2 . "%'" => NULL,'product.is_deleted' => 0]);
        // /$return ['cek'] = $this->db->last_query();

        echo json_encode($return);
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
            $update = $this->product_model->update($data, array("id" => $id));

            $response_data['data'] = $data;
            $response_data['status'] = true;
        } else {
            $response_data['msg'] = "ID Harus Diisi";
        }

        echo json_encode($response_data);
    }
}
