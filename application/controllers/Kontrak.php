<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Kontrak extends Admin_Controller
{

    protected $cont = 'kontrak';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Project_model', 'model');
        $this->load->model('Groups_model');
        $this->load->model('Payment_method_model');
        $this->load->model('Product_model');
        $this->load->model('Payment_product_model');
        $this->load->model('Category_model');
        $this->load->model('Resources_code_model');
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

    public function cek()
    {
        echo DIRECTORY_SEPARATOR;
    }
    public function dataList()
    {
        $columns = array(
            0 => 'id',
            1 => 'project.name',
            2 => 'project.no_surat',
            3 => 'project.tanggal',
        );
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $where = ['project.is_deleted <>' => 2];
        $limit = 0;
        $start = 0;

        $totalData = $this->model->getCountAllBy($limit, $start, $search, $order, $dir, $where);

        if (!empty($this->input->post('search')['value'])) {
            $search_value = $this->input->post('search')['value'];
            $search = array(
                "project.name" => $search_value,
                "project.tanggal" => $search_value
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
                $detail_url = '';
                $amandemen_url = '';
                $generate_url = '';
                $delete_permanent_url = "";

                if ($data->is_deleted == 0) {
                    $amandemen_url = "<a href='" . base_url() . $this->cont . "/amandemen/" . $data->id . "' class='btn btn-sm btn-warning'><i class='fa fa-bookmark'></i> Amandemen </a>";
                    $detail_url = "<a href='" . base_url() . $this->cont . "/detail/" . $data->id . "' class='btn btn-sm btn-success'><i class='fa fa-bars'></i> Detail</a>";
                    $generate_url = "<a href='" . base_url() . $this->cont . "/generate/" . $data->id . "' class='btn btn-sm btn-info'><i class='fa fa-dollar'></i> Generate Harga</a>";
                }

                if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
                    $edit_url = "<a href='" . base_url() . $this->cont . "/edit/" . $data->id . "' class='btn btn-sm btn-info'><i class='fa fa-pencil'></i> Ubah</a>";
                }

                if ($this->data['is_can_delete']) {
                    if ($data->is_deleted == 0) {
                        $delete_url = "<a href='javascript:;'
	        				url='" . base_url() . $this->cont . "/destroy/" . $data->id . "/" . $data->is_deleted . "'
	        				class='btn btn-sm btn-danger delete' >NonAktifkan
	        				</a>";
                    } else {
                        $delete_url = "<a href='javascript:;'
	        				url='" . base_url() . $this->cont . "/destroy/" . $data->id . "/" . $data->is_deleted . "'
	        				class='btn btn-sm btn-danger delete'
	        				 >Aktifkan
	        				</a>";

                        $delete_permanent_url = "<a href='javascript:;'
                        url='" . base_url() . $this->cont . "/delete/" . $data->id . "'
                        class='btn btn-sm btn-warning delete'
                        > <i class='fa fa-trash-o'></i> Hapus
                        </a>";
                    }
                }


                $nestedData['id'] = $start + $key + 1;
                $nestedData['name'] = $data->name;
                $nestedData['no_surat'] = $data->no_surat;
                $nestedData['tanggal'] = $data->tanggal;



                $nestedData['action'] = $edit_url . " " . $delete_url . " " . $amandemen_url . " " . $detail_url . " " . $generate_url . ' ' . $delete_permanent_url;
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

    public function create()
    {
        $this->form_validation->set_rules('name', "name", 'trim|required');
        $this->form_validation->set_rules('deskripsi', "Deskripsi", 'trim|required');
        $this->form_validation->set_rules('tgl', "Tanggal", 'trim|required');
        $this->form_validation->set_rules('departemen_pemantau', "Departemen Pemantau", 'trim|required');
        $this->form_validation->set_rules('user_pemantau', "User Pemantau", 'trim|required');
        $this->form_validation->set_rules('harga', "Harga", 'trim|required');
        $this->form_validation->set_rules('volume', "Volume", 'trim|required');
        $this->form_validation->set_rules('level2', "Jenis", 'trim|required');

        if ($this->form_validation->run() === TRUE) {

            //die(var_dump($this->input->post()));
            $data = array(
                'name'          => $this->input->post('name'),
                'tanggal'       => $this->input->post('tgl'),
                'description'   => $this->input->post('deskripsi'),
                'no_surat'      => $this->input->post('no_surat'),
                'start_contract' => $this->input->post('start_contract'),
                'end_contract' => $this->input->post('end_contract'),
                'no_contract' => $this->input->post('no_contract'),
                'vendor_id' => $this->input->post('vendor_id'),
                'departemen_pemantau_id' => $this->input->post('departemen_pemantau'),
                'user_pemantau_id' => $this->input->post('user_pemantau'),
                'harga' => $this->input->post('harga'),
                'volume' => $this->input->post('volume'),
                'payment_method_id' => $this->input->post('payment_method'),
                'created_by' => $this->data['users']->id,
                'volume_sisa' => $this->input->post('volume'),
                'category_id' => $this->input->post('level2'),
            );

            $upload = 1;
            if ($_FILES['file_contract']['name']) {
                $config['upload_path']          = './file_contract/';
                $config['allowed_types']        = '*';
                $config['max_size']             = 20000;
                $random = rand(1000, 9999);
                $do_upload = 'file_contract';
                $filename = pathinfo($_FILES['file_contract']["name"]);
                $extension = $filename['extension'];
                $config['file_name'] = $random . "_" . time() . "." . $extension;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload($do_upload)) {
                    $data['file_contract'] = $config['file_name'];
                    $upload = 1;
                } else {
                    $upload = 0;
                }
            }


            $this->db->trans_begin();
            $insert = $this->model->insert($data);

            $data_group = array();
            foreach ($this->input->post('departemen') as $v) {
                $data_group[] = array(
                    'project_id' => $insert,
                    'group_id' => $v,
                );
            }

            $this->db->insert_batch('project_departement', $data_group);

            if ($this->input->post('users')) {
                $data_user = array();
                foreach ($this->input->post('users') as $v) {
                    $data_user[] = array(
                        'project_id' => $insert,
                        'user_id' => $v,
                    );
                }

                $this->db->insert_batch('project_users', $data_user);
            }

            $is_barang_terkontrak = FALSE;
            $list_barang_terkontrak = [];
            if ($this->input->post('product_id')) {
                $data_product = array();

                //find department
                $find_department_pemantau = $this->Groups_model->findAllById(['groups.id' => $this->input->post('departemen_pemantau')]);
                $nama_department_pemantau = '';
                if ($find_department_pemantau) {
                    $nama_department_pemantau = $find_department_pemantau->name;
                }

                //find payment_method
                $find_payment = $this->Payment_method_model->getOneBy(['payment_method.id' => $this->input->post('payment_method')]);
                $nama_metode_pembayaran = '';
                if ($find_payment) {
                    $nama_metode_pembayaran = $find_payment->full_name;
                }

                foreach ($this->input->post('product_id') as $v) {
                    $data_product[] = array(
                        'project_id' => $insert,
                        'product_id' => $v,
                    );

                    $find_product = $this->Product_model->findAllDataProduct(['product.id' => $v]);
                    if ($this->Product_model->cek_is_terkontrak($v) === TRUE) {
                        $is_barang_terkontrak = TRUE;
                        $list_barang_terkontrak[] = "Produk " . $find_product->full_name . " sudah terkontrak";
                    }

                    if ($find_product) {
                        $find_price = $this->Payment_product_model->getOneBy(['payment_product.product_id' => $v, 'payment_product.payment_id' => $this->input->post('payment_method')]);
                        $price = 0;
                        if ($find_price) {
                            if ($find_price->price) {
                                $price = $find_price->price;
                            }
                        }
                        //insert to data lelang
                        $data_lelang[] = array(
                            'departemen' => $nama_department_pemantau,
                            'kategori' => "BARANG",
                            'nama' => $find_product->name,
                            'spesifikasi' => $find_product->size_name,
                            'harga' => $price,
                            'vendor' => $find_product->vendor_name,
                            'tgl_terkontrak' => $this->input->post('start_contract'),
                            'tgl_akhir_kontrak' => $this->input->post('end_contract'),
                            'volume' => $find_product->default_weight,
                            'satuan' => $find_product->uom_name,
                            'proyek_pengguna' => $this->input->post('name'),
                            'lokasi' => $find_product->location_name,
                            'keterangan' => $nama_metode_pembayaran,
                        );
                    }
                }

                $this->db->insert_batch('project_products', $data_product);
                $this->db->insert_batch('data_lelang', $data_lelang);
                //$this->send_notif_product_to_vendor($this->input->post('vendor_id'), $this->input->post('product_id'), $this->input->post('no_contract'), $this->input->post('payment_method'));
            }

            $data_aktifitias_user = [
                'user_id' => $this->data['users']->id,
                'description' => 'Tambah Kontrak ' . $this->input->post('name'),
                'id_reff' => $insert,
                // category 2 = order
                'aktifitas_category' => 3,
            ];
            $this->db->insert('aktifitas_user', $data_aktifitias_user);


            if ($this->db->trans_status() === FALSE || $is_barang_terkontrak === TRUE) {
                $this->db->trans_rollback();
                $pesan_error = "Project Baru Gagal Disimpan";
                if ($is_barang_terkontrak === TRUE) {
                    $pesan_error .= '<br>';
                    $pesan_error .= implode('<br>', $list_barang_terkontrak);
                }
                $this->session->set_flashdata('message_error', $pesan_error);
                redirect($this->cont);
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Project Baru Berhasil Disimpan");
                redirect($this->cont);
            }
        } else {
            //die(var_dump($this->input->post()));

            $this->load->model('Groups_model');
            $this->data['groups'] = $this->Groups_model->getAllById();

            $this->load->model('vendor_model');
            $where_vendor = array();

            if ($this->data['users_groups']->id == 3) {
                $where_vendor['vendor.id'] = $this->data['users']->vendor_id;
            }

            $this->data['vendor'] = $this->vendor_model->getvendor($where_vendor);
            $this->data['category'] = $this->Category_model->get_dropdown(['is_deleted' => 0]);
            $this->data['level1'] = $this->Resources_code_model->get_dropdown2(['level' => 1, 'status' => 1]);
            $this->data['content'] = 'admin/' . $this->cont . '/create_v';
            $this->load->view('admin/layouts/page', $this->data);
        }
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('name', "name", 'trim|required');
        $this->form_validation->set_rules('deskripsi', "Deskripsi", 'trim|required');
        $this->form_validation->set_rules('tgl', "Tanggal", 'trim|required');
        $this->form_validation->set_rules('departemen_pemantau', "Departemen Pemantau", 'trim|required');
        $this->form_validation->set_rules('user_pemantau', "User Pemantau", 'trim|required');
        $this->form_validation->set_rules('harga', "Harga", 'trim|required');
        $this->form_validation->set_rules('volume', "Volume", 'trim|required');
        $this->form_validation->set_rules('level2', "Jenis", 'trim|required');

        if ($this->form_validation->run() === TRUE) {
            $data_lama = $this->model->getOneBy(['id' => $this->input->post('id')]);
            if ($this->input->post('volume') < $data_lama->volume_terpakai) {
                $this->session->set_flashdata('message_error', "Projek  Gagal Diubah, volume tidak boleh kurang dari volume yang sudah terpakai");
                redirect($this->cont, "refresh");
            }

            $selisih = $this->input->post('volume') - $data_lama->volume;

            $data = array(
                'name'          => $this->input->post('name'),
                'tanggal'       => $this->input->post('tgl'),
                'description'   => $this->input->post('deskripsi'),
                'no_surat'      => $this->input->post('no_surat'),
                'start_contract' => $this->input->post('start_contract'),
                'end_contract' => $this->input->post('end_contract'),
                'no_contract' => $this->input->post('no_contract'),
                'vendor_id' => $this->input->post('vendor_id'),
                'departemen_pemantau_id' => $this->input->post('departemen_pemantau'),
                'user_pemantau_id' => $this->input->post('user_pemantau'),
                'harga' => $this->input->post('harga'),
                'volume' => $this->input->post('volume'),
                'payment_method_id' => $this->input->post('payment_method'),
                'category_id' => $this->input->post('level2'),
                'updated_by' => $this->data['users']->id,
            );

            $upload = 1;
            if ($_FILES['file_contract']['name']) {
                $config['upload_path']          = './file_contract/';
                $config['allowed_types']        = '*';
                $config['max_size']             = 20000;
                $random = rand(1000, 9999);
                $do_upload = 'file_contract';
                $filename = pathinfo($_FILES['file_contract']["name"]);
                $extension = $filename['extension'];
                $config['file_name'] = $random . "_" . time() . "." . $extension;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload($do_upload)) {
                    $data['file_contract'] = $config['file_name'];
                    $upload = 1;
                } else {
                    $upload = 0;
                }
            }

            $id = $this->input->post('id');
            $this->db->trans_begin();

            if ($selisih != 0) {
                if ($selisih < 0) {
                    $this->db->set('volume_sisa', '`volume_sisa` - ' . $selisih, FALSE);
                } else {
                    $this->db->set('volume_sisa', '`volume_sisa` + ' . $selisih, FALSE);
                }
            }

            $this->db->where('id', $id)
                ->update('project', $data);
            //$update = $this->model->update($data, ['id' => $id]);

            $this->load->model('Project_departement_model');
            $this->Project_departement_model->delete(['project_id' => $id]);
            $data_group = array();
            foreach ($this->input->post('departemen') as $v) {
                $data_group[] = array(
                    'project_id' => $id,
                    'group_id' => $v,
                );
            }

            $this->db->insert_batch('project_departement', $data_group);

            $this->load->model('Project_users_model');
            $this->Project_users_model->delete(['project_id' => $id]);
            if ($this->input->post('users')) {
                $data_user = array();
                foreach ($this->input->post('users') as $v) {
                    $data_user[] = array(
                        'project_id' => $id,
                        'user_id' => $v,
                    );
                }

                $this->db->insert_batch('project_users', $data_user);
            }

            $this->load->model('Project_products_model');
            $list_product = $this->Project_products_model->getAllById(['project_id' => $id, 'is_deleted' => 0]);

            $arr_list_product = [];
            if ($list_product) {
                foreach ($list_product as $v) {
                    $arr_list_product[] = $v->product_id;
                }
            }

            if ($this->input->post('product_id') && $data_lama->status == 0) {
                $data_product = array();
                foreach ($this->input->post('product_id') as $v) {
                    if (!in_array($v, $arr_list_product)) {
                        $data_product[] = array(
                            'project_id' => $id,
                            'product_id' => $v,
                        );
                    }
                }
                if ($data_product)
                    $this->db->insert_batch('project_products', $data_product);

                // set is delete data yang tidak ada
                foreach ($arr_list_product as $v) {
                    if (!in_array($v, $this->input->post('product_id'))) {
                        $where_product = [
                            'project_id' => $id,
                            'product_id' => $v,
                        ];

                        $this->Project_products_model->update(['is_deleted' => 1], $where_product);
                        $this->db->where($where_product)->update('project_product_price', ['is_deleted' => 1]);
                    }
                }
            }

            $data_aktifitias_user = [
                'user_id' => $this->data['users']->id,
                'description' => 'Edit Kontrak ' . $data_lama->name,
                'id_reff' => $id,
                // category 2 = order
                'aktifitas_category' => 3,
            ];
            $this->db->insert('aktifitas_user', $data_aktifitias_user);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message_error', "Projek  Gagal Diubah");
                redirect($this->cont, "refresh");
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Projek  Berhasil Diubah");
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
                $this->data['name'] = (!empty($data)) ? $data->name : "";
                $this->data['description'] = (!empty($data)) ? $data->description : "";
                $this->data['tanggal'] = (!empty($data)) ? $data->tanggal : "";
                $this->data['no_surat'] = (!empty($data)) ? $data->no_surat : "";
                $this->data['no_contract'] = (!empty($data)) ? $data->no_contract : "";
                $this->data['start_contract'] = (!empty($data)) ? $data->start_contract : "";
                $this->data['end_contract'] = (!empty($data)) ? $data->end_contract : "";
                $this->data['vendor_id'] = (!empty($data)) ? $data->vendor_id : "";
                $this->data['departemen_pemantau_id'] = (!empty($data)) ? $data->departemen_pemantau_id : "";
                $this->data['user_pemantau_id'] = (!empty($data)) ? $data->user_pemantau_id : "";
                $this->data['volume'] = (!empty($data)) ? $data->volume : "";
                $this->data['harga'] = (!empty($data)) ? $data->harga : "";
                $this->data['status'] = (!empty($data)) ? $data->status : "";
                $this->data['category_id'] = (!empty($data)) ? $data->category_id : "";

                $kode_sda = (!empty($data)) ? $data->category_id : "";
                $level2 = $this->db->get_where('resources_code', ['code' => $kode_sda])->row_array();
                $level1 = $level2['level'] == 1 ? $this->db->get_where('resources_code', ['code' => $kode_sda])->row_array() : $this->db->get_where('resources_code', ['code' => $level2['parent_code']])->row_array();
                $this->data['level2'] = (!empty($level2)) ? $level2['code'] : "";
                $this->data['level1'] = (!empty($level1)) ? $level1['code'] : "";

                $this->data['sel_level1'] = $this->Resources_code_model->get_dropdown3(['level' => 1, 'status' => 1]);
                $this->data['sel_level2'] = $this->Resources_code_model->get_dropdown3(['level' => 2, 'parent_code' => $level1['code'], 'status' => 1]);

                $this->load->model('Project_departement_model');
                $groups = $this->Project_departement_model->getAllById(['project_id' => $id]);
                $arr_group = array();
                if ($groups) {
                    foreach ($groups as $v) {
                        $arr_group[] = $v->group_id;
                    }
                }
                $this->data['group_id'] = $arr_group;

                $this->load->model('Project_users_model');
                $users = $this->Project_users_model->getAllById(['project_id' => $id]);
                $arr_user = array();
                if ($users) {
                    foreach ($users as $v) {
                        $arr_user[] = $v->user_id;
                    }
                }
                $this->data['user_ids'] = $arr_user;

                $this->load->model('Groups_model');
                $this->data['groups'] = $this->Groups_model->getAllById();

                $this->load->model('user_model');

                $this->data['user_id'] = array();
                if (!empty($arr_group)) {
                    $this->data['user_id'] = $this->user_model->getAllById(['users.group_id IN (' . implode(',', $arr_group) . ')' => NULL]);
                }

                $this->data['user_pemantau_list'] =  $this->user_model->getAllById(['users.group_id' => $this->data['departemen_pemantau_id']]);


                $this->load->model('vendor_model');
                $where_vendor = array();

                if ($this->data['users_groups']->id == 3) {
                    $where_vendor['vendor.id'] = $this->data['users']->vendor_id;
                }
                $this->data['vendor'] = $this->vendor_model->getvendor($where_vendor);

                $this->load->model('Product_model');
                $this->data['products'] = $this->Product_model->getAllDataProduct(array('product.vendor_id' => $this->data['vendor_id']));

                $this->load->model('Project_products_model');
                $arr_products = array();
                $products = $this->Project_products_model->getAllById(array('project_id' => $id, 'is_deleted' => 0));
                if ($products) {
                    foreach ($products as $v) {
                        $arr_products[] = $v->product_id;
                    }
                }
                $this->data['arr_products'] = $arr_products;

                $this->data['category'] = $this->Category_model->get_dropdown(['is_deleted' => 0]);

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

    private function send_notif_product_to_vendor($vendor_id, $arr_products, $no_kontrak, $payment_method_id)
    {
        $this->load->model('User_model');
        $user_vendor = $this->User_model->getOneUserByVendor_id(['vendor_id' => $vendor_id])->id;
        //die($this->db->last_query());
        $this->load->model('Payment_method_model');
        $q_payment_method = $this->Payment_method_model->getOneBy(['payment_method.id' => $payment_method_id]);
        $payment_method_name = $q_payment_method ? $q_payment_method->full_name : '';

        $this->load->model('Product_model');
        $list_product = $this->Product_model->get_product_with_code(['a.id IN (' . implode(',', $arr_products) . ')' => NULL]);

        $data_notif = [];
        foreach ($list_product as $product) {
            $deskripsi = "Produk " . $product->full_code . " " . $product->name;
            $deskripsi .= " dengan metode pembayaran " . $payment_method_name . " perlu diganti harga sesuai kontrak " . $no_kontrak;

            $data_notif[] = [
                'id_pengirim' => $this->data['users']->id,
                'id_penerima' => $user_vendor,
                'deskripsi' => $deskripsi,
            ];
        }

        $this->db->insert_batch('notification', $data_notif);
    }

    public function amandemen($id)
    {
        $this->form_validation->set_rules('harga', "Harga", 'trim|required');
        $this->form_validation->set_rules('volume', "Volume", 'trim|required');

        if ($this->form_validation->run() === TRUE) {
            $this->load->model('Amandemen_model');
            $id = $this->input->post('id');

            // handel untuk amandemen, tidak boleh volumenya lebih kecil dari amandemen sebelumnya
            $volume_lama = 0;
            $data_project = $this->model->getOneBy(['id' => $id]);
            if ($data_project->last_amandemen_id == '') {
                $volume_lama = $data_project->volume;
            } else {
                $data_amandemen = $this->Amandemen_model->getOneBy(['id' => $data_project->last_amandemen_id]);
                $volume_lama = $data_amandemen->volume;
            }
            // volume_lama = 1000, volume_baru = 900, ditolak, harus lebih besar
            if ($this->input->post('volume') < $volume_lama) {
                $this->session->set_flashdata('message_error', 'Volume amandemen tidak boleh lebih kecil dari volume sebelumnya');
                redirect($this->cont . '/amandemen/' . $id);
            }
            //die($volume_lama);

            $selisih = $this->input->post('volume') - $volume_lama;

            $no_amandemen = $this->Amandemen_model->get_no_amandemen_terakhir($id);

            $no_amandemen = $no_amandemen->no_amandemen ? $no_amandemen->no_amandemen + 1 : 1;

            $data = array(
                'no_amandemen' => $no_amandemen,
                'id_project' => $id,
                'start_contract' => $this->input->post('start_contract'),
                'end_contract' => $this->input->post('end_contract'),
                'harga' => $this->input->post('harga'),
                'volume' => $this->input->post('volume'),
                'created_by' => $this->data['users']->id,
            );

            $this->db->trans_begin();
            $insert = $this->Amandemen_model->insert($data);
            // update project
            $this->db->set('status', 2)
                ->set('last_amandemen_id', $insert)
                ->set('volume_sisa', 'volume_sisa + ' . $selisih, FALSE)
                ->where('id', $id)
                ->update('project');
            //$this->model->update(['status' => 2, 'last_amandemen_id' => $insert], ['id' => $id]);
            //die(my_print_r($this->input->post('harga_product')));
            if ($this->input->post('product_id')) {
                $data_aman_product = [];
                foreach ($this->input->post('product_id') as $k => $v) {
                    $data_aman_product[] = [
                        'amandemen_id' => $insert,
                        'product_id' => $v,
                        //'harga' => $v
                    ];
                }

                $this->db->insert_batch('amandemen_products', $data_aman_product);
            }

            $data_aktifitias_user = [
                'user_id' => $this->data['users']->id,
                'description' => 'Amandemen Ke-' . $no_amandemen . ' Kontrak ' . $data_project->name,
                'id_reff' => $insert,
                // category 2 = order
                'aktifitas_category' => 4,
            ];
            $this->db->insert('aktifitas_user', $data_aktifitias_user);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message_error', "Amandemen Gagal Diubah");
                redirect($this->cont, "refresh");
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Amandemen Berhasil Dibuat");
                redirect($this->cont, "refresh");
            }
        } else {
            if (!empty($_POST)) {
                $id = $this->input->post('id');
                $this->session->set_flashdata('message_error', validation_errors());
                return redirect($this->cont . "/amandemen/" . $id);
            } else {
                $this->data['id'] = $id;
                $data = $this->model->getOneBy(array("id" => $this->data['id']));
                $this->data['name'] = (!empty($data)) ? $data->name : "";
                $this->data['description'] = (!empty($data)) ? $data->description : "";
                $this->data['tanggal'] = (!empty($data)) ? $data->tanggal : "";
                $this->data['no_surat'] = (!empty($data)) ? $data->no_surat : "";
                $this->data['no_contract'] = (!empty($data)) ? $data->no_contract : "";
                $this->data['vendor_id'] = (!empty($data)) ? $data->vendor_id : "";
                $this->data['departemen_pemantau_id'] = (!empty($data)) ? $data->departemen_pemantau_id : "";
                $this->data['user_pemantau_id'] = (!empty($data)) ? $data->user_pemantau_id : "";
                $this->data['payment_method_id'] = (!empty($data)) ? $data->payment_method_id : "";
                $this->data['category_id'] = (!empty($data)) ? $data->category_id : "";

                $kode_sda = (!empty($data)) ? $data->category_id : "";
                $level2 = $this->db->get_where('resources_code', ['code' => $kode_sda])->row_array();
                $level1 = $level2['level'] == 1 ? $this->db->get_where('resources_code', ['code' => $kode_sda])->row_array() : $this->db->get_where('resources_code', ['code' => $level2['parent_code']])->row_array();
                $this->data['level2'] = (!empty($level2)) ? $level2['code'] : "";
                $this->data['level1'] = (!empty($level1)) ? $level1['code'] : "";

                $this->data['sel_level1'] = $this->Resources_code_model->get_dropdown3(['level' => 1]);
                $this->data['sel_level2'] = $this->Resources_code_model->get_dropdown3(['level' => 2, 'parent_code' => $level1['code']]);

                $this->load->model('Amandemen_model');
                $amandemen_terakhir = $this->Amandemen_model->get_row_amandemen_terakhir($id);

                if ($amandemen_terakhir) {
                    $this->data['start_contract'] = $amandemen_terakhir->start_contract;
                    $this->data['end_contract'] = $amandemen_terakhir->end_contract;
                    $this->data['harga'] = $amandemen_terakhir->harga;
                    $this->data['volume'] = $amandemen_terakhir->volume;

                    $this->load->model('Amandemen_products_model');
                    $arr_products = array();
                    $products = $this->Amandemen_products_model->getAllById(array('amandemen_id' => $amandemen_terakhir->id));
                    if ($products) {
                        foreach ($products as $v) {
                            $arr_products[] = $v->product_id;
                        }
                    }
                    $this->data['arr_products'] = $arr_products;
                } else {
                    $this->data['start_contract'] = (!empty($data)) ? $data->start_contract : "";
                    $this->data['end_contract'] = (!empty($data)) ? $data->end_contract : "";
                    $this->data['harga'] = (!empty($data)) ? $data->harga : "";
                    $this->data['volume'] = (!empty($data)) ? $data->volume : "";

                    $this->load->model('Project_products_model');
                    $arr_products = array();
                    $products = $this->Project_products_model->getAllById(array('project_id' => $id, 'is_deleted' => 0));
                    if ($products) {
                        foreach ($products as $v) {
                            $arr_products[] = $v->product_id;
                        }
                    }
                    $this->data['arr_products'] = $arr_products;
                }


                //var_dump($this->data['end_contract']);

                $this->load->model('Project_departement_model');
                $groups = $this->Project_departement_model->getAllById(['project_id' => $id]);
                $arr_group = array();
                if ($groups) {
                    foreach ($groups as $v) {
                        $arr_group[] = $v->group_id;
                    }
                }
                $this->data['group_id'] = $arr_group;

                $this->load->model('Project_users_model');
                $users = $this->Project_users_model->getAllById(['project_id' => $id]);
                $arr_user = array();
                if ($users) {
                    foreach ($users as $v) {
                        $arr_user[] = $v->user_id;
                    }
                }
                $this->data['user_ids'] = $arr_user;

                $this->load->model('Groups_model');
                $this->data['groups'] = $this->Groups_model->getAllById();

                $this->load->model('user_model');

                $this->data['user_id'] = array();
                if (!empty($arr_group)) {
                    $this->data['user_id'] = $this->user_model->getAllById(['users.group_id IN (' . implode(',', $arr_group) . ')' => NULL]);
                }

                $this->data['user_pemantau_list'] =  $this->user_model->getAllById(['users.group_id' => $this->data['departemen_pemantau_id']]);


                $this->load->model('vendor_model');
                $where_vendor = array();
                if (!$this->data['is_superadmin']) {
                    $where_vendor['vendor.id'] = $this->data['users']->vendor_id;
                }
                $this->data['vendor'] = $this->vendor_model->getvendor($where_vendor);

                $this->load->model('Product_model');
                $this->data['products'] = $this->Product_model->getAllDataProduct(array('product.vendor_id' => $this->data['vendor_id']));
                $this->data['category'] = $this->Category_model->get_dropdown(['is_deleted' => 0]);
                $this->data['content'] = 'admin/' . $this->cont . '/amandemen_v';
                $this->load->view('admin/layouts/page', $this->data);
            }
        }
    }

    public function detail($id)
    {
        $detail = $this->model->get_detail_kontrak(['project.id' => $id]);
        if ($detail === FALSE) {
            $this->session->set_flashdata('message', "Tidak Ada Data Amandemen");
            redirect($this->cont);
        }

        $this->data['detail_kontrak'] = $detail;
        $this->data['id_project'] = $id;
        $this->data['content'] = 'admin/' . $this->cont . '/detail_v';
        $this->load->view('admin/layouts/page', $this->data);
    }

    public function detail_dataList($id_project)
    {

        $columns = array(
            0 => 'a.no_amandemen',
            1 => 'd.name',
            2 => 'c.name',
            3 => 'a.start_contract',
            4 => 'a.end_contract',
            5 => 'a.volume',
            6 => 'a.harga',
        );
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $where['b.id'] = $id_project;
        $limit = 0;
        $start = 0;
        $this->load->model('Amandemen_model');
        $totalData = $this->Amandemen_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;


        if ($isSearchColumn) {
            $totalFiltered = $this->Amandemen_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
        } else {
            $totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $datas = $this->Amandemen_model->getAllBy($limit, $start, $search, $order, $dir, $where);
        //die(print_r($datas));
        $new_data = array();
        if (!empty($datas)) {
            foreach ($datas as $key => $data) {

                $edit_url = "";
                $delete_url = "";
                $detail_url = "<a href='javascript:;' class='btn btn-sm white detail' data-id='" . $data->id . "'><i class='fa fa-bars'></i> Detail</a>";
                $amandemen_url = '';


                $nestedData['id'] = $start + $key + 1;
                $nestedData['no_kontrak'] = $data->no_contract . '-Amd' . $data->no_amandemen;
                $nestedData['departemen_name'] = $data->departemen_name;
                $nestedData['vendor_name'] = $data->vendor_name;
                $nestedData['start_contract'] = tgl_indo($data->start_contract);
                $nestedData['end_contract'] = tgl_indo($data->end_contract);
                $nestedData['tgl_amandemen'] = tgl_indo($data->tgl_amandemen);
                $nestedData['volume'] = $data->volume;
                $nestedData['harga'] = rupiah($data->harga);



                $nestedData['action'] = $edit_url . " " . $delete_url . " " . $amandemen_url . " " . $detail_url;
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

    function get_detail_amandemen($id_amandemen)
    {
        $this->load->model('Amandemen_model');
        $query = $this->Amandemen_model->get_detail_amandemen_list_by(['b.id' => $id_amandemen]);

        $ret = [];
        $ret['data'] = $query;
        echo json_encode($ret);
    }

    function generate($id)
    {
        $this->data['id'] = $id;
        $this->data['content'] = 'admin/' . $this->cont . '/generate_v';
        $this->load->view('admin/layouts/page', $this->data);
    }

    function get_harga_for_generate($id)
    {
        $ret = [];
        $project = $this->model->getOneBy(['id' => $id]);
        $ret['status'] = $status = $project->status;

        if ($status == 0) {
            $ret['data'] = $this->model->get_harga_for_generate_status_0($id);
        }

        echo json_encode($ret);
    }

    private function _getLocationNameByLocationId($arrLocation, $arrLocationId)
    {
        // return '<a href="" data-toogle="tooltip" title="jangan coba coba"><i class="fa fa-exclamation-circle"></i></a>';
        $ret = [];
        foreach (explode(',', $arrLocationId) as $location_id) {
            if (isset($arrLocation[$location_id])) {
                $ret[] = $arrLocation[$location_id];
            }
        }
        return '<a href="javascript:;" data-toogle="tooltip" title="' . implode(',', $ret) . '"><i class="fa fa-exclamation-circle"></i></a>';
        // return ;
    }

    public function get_harga_for_generate2($id)
    {
        $ret = [];
        $project = $this->model->getOneBy(['id' => $id]);
        $ret['status'] = $status = $project->status;
        //$ret['status'] = $status = 1;
        $this->load->model('Location_model');
        $arrAllLocation = $this->Location_model->getAllLocationArr2();

        if ($status == 0) {
            $arr_size = [5, 50];
            $arr_header = [
                'P1', 'NAMA PRODUK'
            ];
            $arr_id_header = []; // array untuk menampung id method pembayaran
            $arr_id_location = [];
            $arr_column = [
                ['data' => 'product_id', 'readOnly' => true],
                ['data' => 'nama_product', 'readOnly' => true],
            ];
            $header = $this->model->get_header_generate_harga($id);
            foreach ($header as $v) {
                $arr_header[] = $v->full_payment . ' ' . $this->_getLocationNameByLocationId($arrAllLocation, $v->location_id);
                $arr_id_header[] = $v->payment_id;
                $arr_id_location[] = $v->location_id;
                $arr_size[] = 30;
                $arr_column[] = ['data' => 'payment_' . $v->payment_id . '_' . str_replace(',', '_', $v->location_id)];
            }

            $ret['column'] = $arr_column;
            $ret['size'] = $arr_size;
            $ret['header'] = $arr_header;
            $ret['id_header'] = $arr_id_header;
            $ret['id_location'] = $arr_id_location;

            $ret['data'] = $this->model->get_harga_for_generate_status_0($id, $arr_id_header, $arr_id_location);
        } else if ($status == 1) {
            $arr_size = [5, 50];
            $arr_header = [
                'P1', 'NAMA PRODUK'
            ];
            $arr_id_header = []; // array untuk menampung id method pembayaran
            $arr_id_location = [];
            $arr_column = [
                ['data' => 'product_id', 'readOnly' => true],
                ['data' => 'nama_product', 'readOnly' => true],
            ];

            $header = $this->model->get_header_generate_harga_status_1(['a.project_id' => $id, 'amandemen_id IS NULL' => NULL]);
            foreach ($header as $v) {
                $arr_header[] = $v->full_payment . ' ' . $this->_getLocationNameByLocationId($arrAllLocation, $v->location_id);
                $arr_id_header[] = $v->payment_id;
                $arr_id_location[] = $v->location_id;
                $arr_size[] = 30;
                $arr_column[] = ['data' => 'payment_' . $v->payment_id . '_' . str_replace(',', '_', $v->location_id)];
            }

            $ret['column'] = $arr_column;
            $ret['size'] = $arr_size;
            $ret['header'] = $arr_header;
            $ret['id_header'] = $arr_id_header;
            $ret['id_location'] = $arr_id_location;

            $ret['data'] = $this->model->get_harga_for_generate_status_1($id, $arr_id_header, $arr_id_location);
        } else if ($status == 2) {
            $last_amandemen_id = $project->last_amandemen_id;
            $arr_size = [5, 50];
            $arr_header = [
                'P1', 'NAMA PRODUK'
            ];
            $arr_id_header = []; // array untuk menampung id method pembayaran
            $arr_id_location = [];
            $arr_column = [
                ['data' => 'product_id', 'readOnly' => true],
                ['data' => 'nama_product', 'readOnly' => true],
            ];

            $header = $this->model->get_header_generate_harga_status_2($last_amandemen_id);
            foreach ($header as $v) {
                $arr_header[] = $v->full_payment . ' ' . $this->_getLocationNameByLocationId($arrAllLocation, $v->location_id);
                $arr_id_header[] = $v->payment_id;
                $arr_id_location[] = $v->location_id;
                $arr_size[] = 30;
                $arr_column[] = ['data' => 'payment_' . $v->payment_id . '_' . str_replace(',', '_', $v->location_id)];
            }

            $ret['column'] = $arr_column;
            $ret['size'] = $arr_size;
            $ret['header'] = $arr_header;
            $ret['id_location'] = $arr_id_location;
            $ret['id_header'] = $arr_id_header;

            $ret['data'] = $this->model->get_harga_for_generate_status_2($id, $last_amandemen_id, $arr_id_header, $arr_id_location);
        }
        echo json_encode($ret);
    }

    public function act_generate_harga()
    {
        $status = $this->input->post('status');
        $project_id = $this->input->post('project_id');
        $data = $this->input->post('data');
        $id_payment_method = $this->input->post('id_payment_method');
        // status nya cman ada 0, 1, 2. if na gak guna. hhe
        if ($status == 0 || $status == 1 || $status == 2) {
            $data_insert = [];
            $this->db->trans_start();

            if ($status == 0) {
                $this->model->update(['status' => 1], ['id' => $project_id]);
            } else if ($status == 1 || $status == 2) {
                $this->db->where(['project_id' => $project_id, 'is_deleted' => 0]);
                $this->db->update('project_product_price', ['is_deleted' => 1]);
            }

            foreach ($data as $k => $v) {
                foreach ($v as $k2 => $v2) {
                    if (in_array($k2, [0, 1]) || in_array($v2, ['-', '0'])) {
                        continue;
                    }

                    if ($status == 1 || $status == 0) {
                        $data_insert[] = [
                            'project_id' => $project_id,
                            'product_id' => $v[0],
                            'payment_id' => $id_payment_method[$k2 - 2],
                            'location_id' => $this->input->post('id_location')[$k2 - 2],
                            'price' => $v2,
                        ];
                    } else {
                        $amandemen_id = $this->model->getOneBy(['id' => $project_id])->last_amandemen_id;
                        $data_insert[] = [
                            'project_id' => $project_id,
                            'product_id' => $v[0],
                            'payment_id' => $id_payment_method[$k2 - 2],
                            'location_id' => $this->input->post('id_location')[$k2 - 2],
                            'amandemen_id' => $amandemen_id,
                            'price' => $v2,
                        ];
                    }
                }
            }
            // var_dump($data_insert);
            // die();

            $data_aktifitias_user = [
                'user_id' => $this->data['users']->id,
                'description' => 'Generate harga produk',
                'id_reff' => $project_id,
                // category 2 = order
                'aktifitas_category' => 3,
            ];
            $this->db->insert('aktifitas_user', $data_aktifitias_user);

            $this->db->insert_batch('project_product_price', $data_insert);
            $this->db->trans_complete();
            $ret = [];
            if ($this->db->trans_status() !== FALSE) {
                $ret['status'] = TRUE;
                $ret['msg'] = 'Data Berhasil Disimpan';
            } else {
                $ret['status'] = FALSE;
                $ret['msg'] = 'Data Gagal Disimpan';
            }
            echo json_encode($ret);
        }
        //my_print_r($this->db->queries);
    }
}
