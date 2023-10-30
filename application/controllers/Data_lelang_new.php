<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Data_lelang_new extends Admin_Controller
{

    protected $cont = 'data_lelang_new';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Data_lelang_model_new', 'model');
        $this->load->model('Project_new_model');
        $this->load->model('Resources_code_model');
        $this->load->model('uoms_model');
        $this->data['cont'] = $this->cont;
    }

    public function index()
    {
        if ($this->data['is_can_read']) {
            $this->data['kategori'] = $this->model->get_combo_kategori();
            $this->data['departemen'] = $this->model->get_combo_departemen();
            $this->data['vendor'] = $this->model->get_combo_vendor();
            $this->data['content'] = 'admin/' . $this->cont . '/list_v';
        } else {
            redirect('restrict');
        }

        $this->load->view('admin/layouts/page', $this->data);
    }

    public function dataList()
    {
        $columns = array(
            2 => 'departemen',
            3 => 'kategori',
            4 => 'nama_sumber_daya',
            5 => 'No_kontrak',
            6 => 'nama',
            7 => 'vendor',
            8 => 'tgl_terkontrak',
            9 => 'tgl_akhir_kontrak',
            10 => 'currency',
            11 => 'harga',
            12 => 'volume',
            13 => 'satuan',
            14 => 'proyek_pengguna',
            15 => 'lokasi',
            16 => 'keterangan'
        );

        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $where_and = array();
        $where['is_deleted'] = 0;

        $limit = 0;
        $start = 0;

        $totalData = $this->model->getCountAllBy($limit, $start, $search, $order, $dir, $where, $where_and);


        $isSearchColumn =  false;
        if (($value = $this->input->post('search')['value']) != '') {
            $isSearchColumn = true;
            $search['proyek_pengguna'] = $value;
            $search['vendor'] = $value;
            $search['keterangan'] = $value;
            $search['tgl_terkontrak'] = $value;
            $search['tgl_akhir_kontrak'] = $value;
        }

        $searchColumn = $this->input->post('columns');

        $user_id = $this->data['users']->id;
        $this->load->model('User_model');
        $users = $this->User_model->getDepartmentUser($user_id);
        $departemen_id = $users->group_id;

        if (!$this->data['is_superadmin']) {
            $where['departemen'] = $departemen_id;
        } else {
            if (!empty($searchColumn[2]['search']['value'])) {
                $value = $searchColumn[2]['search']['value'];
                $isSearchColumn = true;
                $where['departemen'] = $value;
                //die('ada?');
            }
        }


        if (!empty($searchColumn[4]['search']['value'])) {
            $value = $searchColumn[4]['search']['value'];
            $isSearchColumn = true;
            $where_and['nama'] = $value;
        }

        if (!empty($searchColumn[6]['search']['value'])) {
            $value = $searchColumn[6]['search']['value'];
            $isSearchColumn = true;
            $where['vendor'] = $value;
        }

        if (!empty($searchColumn[7]['search']['value'])) {
            $value = $searchColumn[7]['search']['value'];
            $isSearchColumn = true;
            //$this->model->escape = FALSE;
            $where["STR_TO_DATE(tgl_terkontrak, '%d/%m/%Y') >= '$value'"] = NULL;
        }

        if (!empty($searchColumn[8]['search']['value'])) {
            $value = $searchColumn[8]['search']['value'];
            $isSearchColumn = true;
            $where["STR_TO_DATE(tgl_akhir_kontrak, '%d/%m/%Y') <= '$value'"] = NULL;
        }

        if (!empty($searchColumn[12]['search']['value'])) {
            $value = $searchColumn[12]['search']['value'];
            $isSearchColumn = true;
            $where['lokasi'] = $value;
        }

        if (!empty($searchColumn[0]['search']['value'])) {
            $value = $searchColumn[0]['search']['value'];
            $isSearchColumn = true;
            $where['keterangan'] = $value;
        }

        if ($isSearchColumn) {
            $totalFiltered = $this->model->getCountAllBy($limit, $start, $search, $order, $dir, $where, $where_and);
        } else {
            $totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        //kondisi data hanya yg belum di hapus
        $where['is_deleted'] = 0;
        $datas = $this->model->getAllBy($limit, $start, $search, $order, $dir, $where, $where_and);
        //die(print_r($datas));
        //die($this->db->last_query());
        $new_data = array();
        if (!empty($datas)) {
            foreach ($datas as $key => $data) {

                $edit_url = "";
                if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
                    $edit_url =  "<a href='" . base_url() . "data_lelang_new/edit/" . $data->id . "' data-id='" . $data->id . "' class='btn btn-xs btn-warning modalUbah'>
                    <i class='fa fa-pencil'></i></a>";
                }
                $delete_url = "";
                if ($this->data['is_can_delete']) {
                    $delete_url = "<input type='checkbox' class='check-item' name='id[]' value='" . $data->id . "'>";
                }
                $this->load->model('Groups_model');
                $groups = $this->Groups_model->getAllById(['id' => $data->departemen]);
                if ($groups) {
                    foreach ($groups as $v) {
                        $departemen = $v->name;
                    }
                }
                $this->load->model('vendor_model');
                $vendor = $this->vendor_model->getvendor(['id' => $data->vendor]);
                if ($vendor) {
                    foreach ($vendor as $v) {
                        $vendor = $v->name;
                    }
                }
                $this->load->model('uoms_model');
                $satuan = $this->uoms_model->getAllById(['id' => $data->satuan]);
                if ($satuan) {
                    foreach ($satuan as $v) {
                        $satuan = $v->name;
                    }
                }
                $this->load->model('Project_new_model');
                $proyek_pengguna = $this->Project_new_model->getAllById(['id' => $data->proyek_pengguna]);
                if ($proyek_pengguna) {
                    foreach ($proyek_pengguna as $v) {
                        $proyek_pengguna = $v->name;
                        $proyek_lokasi = $v->location_id;
                    }
                }
                $this->load->model('Location_model');
                $lokasi = $this->Location_model->getAllById2(['location_id' => $proyek_lokasi]);
                if ($lokasi) {
                    foreach ($lokasi as $v) {
                        $lokasi = $v->full_name;
                    }
                }
                $resources_code = $this->db->get_where('resources_code', ['code' => $data->kategori])->row();

                $nestedData['delete_url'] = $delete_url;
                $nestedData['departemen'] = $departemen;
                $nestedData['kategori'] = $data->kategori;
                $nestedData['nama_sumber_daya'] = $resources_code->name;
                $nestedData['no_kontrak'] = $data->no_kontrak;
                $nestedData['nama'] = $data->nama;
                $nestedData['currency'] = $data->currency;
                $nestedData['harga'] = number_format($data->harga, 2);
                $nestedData['proyek_pengguna'] = $proyek_pengguna;
                $nestedData['vendor'] = $vendor;
                $nestedData['keterangan'] = $data->keterangan;
                $nestedData['tgl_terkontrak'] = $data->tgl_terkontrak;
                $nestedData['tgl_akhir_kontrak'] = $data->tgl_akhir_kontrak;
                $nestedData['volume'] = $data->volume;
                $nestedData['satuan'] = $satuan;
                $nestedData['lokasi'] = $lokasi;
                $nestedData['keterangan'] = $data->keterangan;



                $nestedData['action'] = $edit_url;
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

    public function detail_data_lelang()
    {
        $data = $this->model->get_detail_data_lelang($this->input->post());
        $ret = [];
        $ret['data'] = $data;

        echo json_encode($ret);
    }

    public function import_csv()
    {
        if (empty($_FILES['data_lelang']['name'])) {
            $this->session->set_flashdata('message_error', "File Harus Diisi");
            redirect($this->cont . '/create', "refresh");
        }

        $this->load->library('csvimport');
        $filename = pathinfo($_FILES["data_lelang"]["name"]);
        $extension = $filename['extension'];

        if ($extension != 'csv') {
            $this->session->set_flashdata('message_error', "File Yang Dimasukkan Harus Berekstensi CSV");
            redirect($this->cont . '/create', "refresh");
        }

        $file_data = $this->csvimport->get_array($_FILES["data_lelang"]["tmp_name"]);
        if (empty($file_data)) {
            $this->session->set_flashdata('message_error', "Minimal harus ada 1 baris data Lelang");
            redirect($this->cont . '/create', "refresh");
        }

        if (count($file_data[0]) == 1) {
            $file_data = $this->csvimport->get_array($_FILES["data_lelang"]["tmp_name"], FALSE, FALSE, FALSE, ';');
        } else {
            $file_data = $this->csvimport->get_array($_FILES["data_lelang"]["tmp_name"], FALSE, FALSE, FALSE, ',');
        }

        $this->db->trans_start();
        $dataHistory = [
            'jml_row' => count($file_data),
            'created_by' => $this->data['users']->id,
        ];

        $this->db->insert('data_lelang_upload_history', $dataHistory);
        $upload_history_id = $this->db->insert_id();

        $data_insert = [];

        $header = [
            'NO', 'DEPARTEMEN', 'KATEGORI', 'NAMA', 'SPESIFIKASI', 'MATA_UANG', 'HARGA', 'VENDOR', 'TANGGAL_TERKONTRAK', 'TANGGAL_BERAKHIR_KONTRAK', 'VOLUME', 'SATUAN', 'PROYEK_PENGGUNA', 'LOKASI', 'KETERANGAN'
        ];
        $cek_header = [];
        $i = 0;
        foreach ($file_data as $k => $v) {
            if ($i == 0) {
                $header != array_keys($v);
                if (($header == array_keys($v)) === FALSE) {
                    $this->session->set_flashdata('message_error', "File Yang Dimasukkan Tidak Sesuai dengan Format");
                    redirect($this->cont . '/create', "refresh");
                }
            }
            $i++;

            $data_insert[] = [
                'no' => $v['NO'],
                'departemen' => $v['DEPARTEMEN'],
                'kategori' => $v['KATEGORI'],
                'nama' => $v['NAMA'],
                'spesifikasi' => $v['SPESIFIKASI'],
                'currency' => $v['MATA_UANG'],
                'harga' => $v['HARGA'],
                'vendor' => $v['VENDOR'],
                'tgl_terkontrak' => $v['TANGGAL_TERKONTRAK'],
                'tgl_akhir_kontrak' => $v['TANGGAL_BERAKHIR_KONTRAK'],
                'volume' => $v['VOLUME'],
                'satuan' => $v['SATUAN'],
                'proyek_pengguna' => $v['PROYEK_PENGGUNA'],
                'lokasi' => $v['LOKASI'],
                'keterangan' => $v['KETERANGAN'],
                'upload_history_id' => $upload_history_id,
            ];
        }

        if (!empty($data_insert)) {
            $insert = $this->db->insert_batch('data_lelang', $data_insert);
            $this->db->trans_complete();
            if ($insert !== FALSE) {
                $this->session->set_flashdata('message', "Data Berhasil Diupload");
                //die();
                redirect($this->cont, "refresh");
            } else {
                $this->session->set_flashdata('message_error', "Data Gagal diupload");
                redirect($this->cont . '/create', "refresh");
            }
        }
    }

    public function HandsonDataLelang()
    {
        $retr = [];

        $this->load->model('Location_model');
        $this->load->model('Data_lelang_model_new');
        $this->load->model('Project_new_model');
        $this->load->model('Uoms_model');

        $retr = [
            // 'kategoriArr' => $this->model->getResourcesCodeArrName(),
            // 'vendorArr' => $this->model->getVendorTransportasiHandson(['vendor.id' => $vendorId]),
            // 'projectArr' => $this->Project_new_model->getAllProjectArrName(),
            // 'locationArr' => $this->Location_model->getAllLocationArrName(),
            // 'satuanArr' => $this->Uoms_model->getUomArrNameHands(),
        ];

        echo json_encode($retr);
    }

    public function create()
    {

        $this->form_validation->set_rules('name', "nama", 'trim|required');

        if ($this->form_validation->run() === TRUE) {

            //die(var_dump($this->input->post()));
            $jenis = $this->input->post('jenis');
            $level3 = $this->input->post('level3');
            $level4 = $this->input->post('level4');
            $level5 = $this->input->post('level5');
            if (!empty($jenis) && empty($level3))
                $kategori = $this->input->post('jenis');
            elseif (!empty($level3) && empty($level4))
                $kategori = $this->input->post('level3');
            elseif (!empty($level4) && empty($level5))
                $kategori = $this->input->post('level4');
            elseif (!empty($level5))
                $kategori = $this->input->post('level5');
            else
                $kategori = $this->input->post('kategori');

            $user_id = $this->data['users']->id;
            $this->load->model('User_model');
            $users = $this->User_model->getDepartmentUser($user_id);
            $departemen_id = $users->group_id;

            $data = array(
                'departemen'          => $departemen_id,
                'kategori'       => $kategori,
                'no_kontrak'   => $this->input->post('no_kontrak'),
                'nama'      => $this->input->post('name'),
                'tgl_terkontrak' => $this->input->post('start_contract'),
                'tgl_akhir_kontrak' => $this->input->post('end_contract'),
                'vendor' => $this->input->post('vendor_id'),
                'proyek_pengguna' => $this->input->post('proyek_id'),
                'lokasi' => $this->input->post('location_id'),
                'harga' => $this->input->post('harga'),
                'volume' => $this->input->post('volume'),
                'keterangan' => $this->input->post('keterangan'),
                'created_by' => $this->data['users']->id,
                'satuan' => $this->input->post('satuan_id'),
            );

            $this->db->trans_begin();
            $insert = $this->model->insert($data);

            $data_aktifitias_user = [
                'user_id' => $this->data['users']->id,
                'description' => 'Tambah Data Lelang ' . $this->input->post('name'),
                'id_reff' => $insert,
                // category 2 = order
                'aktifitas_category' => 3,
            ];
            $this->db->insert('aktifitas_user', $data_aktifitias_user);


            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $pesan_error = "Data Lelang Baru Gagal Disimpan";
                $this->session->set_flashdata('message_error', $pesan_error);
                redirect($this->cont);
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Data Lelang Baru Berhasil Disimpan");
                redirect($this->cont);
            }
        } else {
            $this->data['kategori'] = $this->Resources_code_model->getResourcesCodeArrName();
            $this->load->model('Groups_model');
            $this->data['groups'] = $this->Groups_model->getAllById();
            $this->load->model('Project_new_model');
            $this->data['proyek'] = $this->Project_new_model->getAllProjectArrName();
            $this->load->model('Uoms_model');
            $this->data['uoms'] = $this->Uoms_model->getUomArrName();
            $this->load->model('Location_model');
            $this->data['location'] = $this->Location_model->get_dropdown2(['level in (2,3)' => null]);

            // $where_vendor = array();
            // if ($this->data['users_groups']->id == 3) {
            //     $where_vendor['vendor.id'] = $this->data['users']->vendor_id;
            // }
            $this->load->model('vendor_model');
            $this->data['vendor'] = $this->vendor_model->get_dropdown();

            $this->data['content'] = 'admin/' . $this->cont . '/create_v';
            $this->load->view('admin/layouts/page', $this->data);
        }
    }
    public function actSimpanData()
    {
        $allSDA = $this->Resources_code_model->getAllById(['level in (2,3,4,5,6)' => null]);
        $sdaByName = [];
        if ($allSDA) {
            foreach ($allSDA as $key => $value) {
                $sdaByName[$value->name] = $value->code;
            }
        }
        $this->load->model('Vendor_model');
        $allVendor = $this->Vendor_model->getAllById(['is_deleted' => 0]);
        $vendorByName = [];
        if ($allVendor) {
            foreach ($allVendor as $key => $value) {
                $vendorByName[$value->name] = $value->id;
            }
        }
        $allUom = $this->uoms_model->getAllById(['is_deleted' => 0]);
        $uomByName = [];
        if ($allUom) {
            foreach ($allUom as $key => $value) {
                $uomByName[$value->name] = $value->id;
            }
        }
        $allProject = $this->Project_new_model->getAllById(['is_deleted' => 0]);
        $projectByName = [];
        if ($allProject) {
            foreach ($allProject as $key => $value) {
                $projectByName[$value->name] = $value->id;
            }
        }



        $user_id = $this->data['users']->id;
        $this->load->model('User_model');
        $users = $this->User_model->getDepartmentUser($user_id);
        $departemen_id = $users->group_id;
        $dataInsert = [];
        $count = 0;
        $this->db->trans_start();
        if ($this->input->post('data')) {
            foreach ($this->input->post('data') as $key => $value) {
                // var_dump($value);
                if (!isset($sdaByName[$value[0]])) {
                    continue;
                }
                $date1 = str_replace('/', '-', $value[7]);
                $tgl_terkontrak = date("Y-m-d", strtotime($date1));
                $date2 = str_replace('/', '-', $value[8]);
                $tgl_akhir_kontrak = date("Y-m-d", strtotime($date2));
                $data = [
                    'departemen' => $departemen_id,
                    'kategori' => $sdaByName[$value[0]],
                    'no_kontrak' => $value[1],
                    'nama' => $value[2],
                    'vendor' => $vendorByName[$value[3]],
                    'harga' => $value[4],
                    'volume' => $value[5],
                    'satuan' => $uomByName[$value[6]],
                    'tgl_terkontrak' => $tgl_terkontrak,
                    'tgl_akhir_kontrak' => $tgl_akhir_kontrak,
                    'proyek_pengguna' => $projectByName[$value[9]],
                    'keterangan' => $value[10],
                ];

                // klo 0 berarti Insert, sisanya update
                $data['created_by'] = $user_id;
                $dataInsert[] = $data;
                $count++;
            }

            if (!empty($dataInsert)) {
                $this->db->insert_batch('data_lelang_new', $dataInsert);
                $dataHistory = [
                    'jml_row' => $count,
                    'created_by' => $this->data['users']->id,
                ];

                $this->db->insert('data_lelang_upload_history', $dataHistory);
            }
        }



        $this->db->trans_complete();
        $ret = [
            'status' => $this->db->trans_status(),
        ];

        echo json_encode($ret);
    }


    public function edit($id)
    {
        $this->form_validation->set_rules('name', "name", 'trim|required');
        $this->form_validation->set_rules('no_kontrak', "No Kontrak", 'trim|required');
        $this->form_validation->set_rules('vendor_id', "Vendor", 'trim|required');
        $this->form_validation->set_rules('harga', "Harga", 'trim|required');
        $this->form_validation->set_rules('volume', "Volume", 'trim|required');
        //$this->form_validation->set_rules('departemen',"Departemen", 'trim|required');

        if ($this->form_validation->run() === TRUE) {
            $level2 = $this->input->post('level2');
            $level3 = $this->input->post('level3');
            if (!empty($level2) && empty($level3))
                $kode_sda = $this->input->post('level2');
            elseif (!empty($level3))
                $kode_sda = $this->input->post('level3');
            else
                $kode_sda = $this->input->post('level1');
            $data = array(
                'kategori'          => $kode_sda,
                'nama'          => $this->input->post('name'),
                'no_kontrak' => $this->input->post('no_kontrak'),
                'spesifikasi' => $this->input->post('spesifikasi'),
                'vendor' => $this->input->post('vendor_id'),
                'volume' => $this->input->post('volume'),
                'harga' => $this->input->post('harga'),
                'tgl_terkontrak' => $this->input->post('tgl_terkontrak'),
                'tgl_akhir_kontrak' => $this->input->post('tgl_akhir_kontrak'),
                'satuan' => $this->input->post('satuan'),
                'proyek_pengguna' => $this->input->post('proyek_pengguna'),
                'keterangan' => $this->input->post('keterangan'),
            );

            $id = $this->input->post('id');
            $update = $this->model->update($data, ['id' => $id]);

            if ($update === FALSE) {
                $this->session->set_flashdata('message_error', "Data Lelang Gagal Diubah");
                redirect($this->cont, "refresh");
            } else {
                $this->session->set_flashdata('message', "Data Lelang Berhasil Diubah");
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
                $this->data['name'] = (!empty($data)) ? $data->nama : "";
                $this->data['no_kontrak'] = (!empty($data)) ? $data->no_kontrak : "";
                $this->data['spesifikasi'] = (!empty($data)) ? $data->spesifikasi : "";
                $this->data['vendor_id'] = (!empty($data)) ? $data->vendor : "";
                $this->data['volume'] = (!empty($data)) ? $data->volume : "";
                $this->data['harga'] = (!empty($data)) ? $data->harga : "";
                $this->data['tgl_terkontrak'] = (!empty($data)) ? $data->tgl_terkontrak : "";
                $this->data['tgl_akhir_kontrak'] = (!empty($data)) ? $data->tgl_akhir_kontrak : "";
                $this->data['satuan'] =   (!empty($data)) ? $data->satuan : "";
                $this->data['proyek_pengguna'] = (!empty($data)) ? $data->proyek_pengguna : "";
                $this->data['keterangan'] = (!empty($data)) ? $data->keterangan : "";
                //var_dump($this->data['end_contract']);
                $kode_sda = (!empty($data)) ? $data->kategori : "";
                $level3 = $this->db->get_where('resources_code', ['code' => $kode_sda])->row_array();
                $level2 = $level3['level'] == 2 ? $this->db->get_where('resources_code', ['code' => $kode_sda])->row_array() : $this->db->get_where('resources_code', ['code' => $level3['parent_code']])->row_array();
                $level1 = $level3['level'] == 1 ? $this->db->get_where('resources_code', ['code' => $kode_sda])->row_array() : $this->db->get_where('resources_code', ['code' => $level2['parent_code']])->row_array();
                $this->data['level3'] = (!empty($level3)) ? $level3['code'] : "";
                $this->data['level2'] = (!empty($level2)) ? $level2['code'] : "";
                $this->data['level1'] = (!empty($level1)) ? $level1['code'] : "";

                $this->data['sel_level1'] = $this->Resources_code_model->get_dropdown3(['level' => 1, 'status' => 1]);
                $this->data['sel_level2'] = $this->Resources_code_model->get_dropdown3(['level' => 2, 'parent_code' => $level1['code'], 'status' => 1]);
                $this->data['sel_level3'] = $this->Resources_code_model->get_dropdown3(['level' => 3, 'parent_code' => $level2['code'], 'status' => 1]);

                $this->load->model('Uoms_model');
                $this->data['uom'] = $this->Uoms_model->getAllById();

                $this->data['proyek'] = $this->Project_new_model->getAllById();


                $this->load->model('vendor_model');
                $this->data['vendor'] = $this->vendor_model->getvendor();

                //var_dump($this->data['arr_products']);

                $this->data['content'] = 'admin/' . $this->cont . '/edit_v';
                $this->load->view('admin/layouts/page', $this->data);
            }
        }
    }

    public function destroy()
    {
        $idDataLelang = $_POST['id']; // Ambil data ID yang dikirim oleh view.php melalui form submit
        if ($idDataLelang == NULL) {
            $this->session->set_flashdata('message_error', "Tidak Ada Data yang Anda Pilih Untuk Dihapus");
            redirect("data_lelang_new");
        } else {
            $updateArray = array();

            for ($x = 0; $x < sizeof($idDataLelang); $x++) {
                $dataupdate[] = 1;
                $updateArray[] = array(
                    'id' => $idDataLelang[$x],
                    'is_deleted' => $dataupdate[$x]
                );
            }
            $update = $this->db->update_batch('data_lelang_new', $updateArray, 'id');
            if ($update) {
                $this->session->set_flashdata('message', "Data Anda Berhasil Dihapus");
                redirect("data_lelang_new");
            } else {
                $this->session->set_flashdata('message_error', "Data Anda Tidak Berhasil Dihapus");
                redirect("data_lelang_new");
            }
        }
    }

    private function send_notif_product_to_vendor($vendor_id, $arr_products)
    {
        $this->load->model('User_model');
        $user_vendor = $this->User_model->getOneUserByVendor_id(['vendor_id' => $vendor_id])->id;
        //die($this->db->last_query());

        $this->load->model('Product_model');
        $list_product = $this->Product_model->get_product_with_code(['a.id IN (' . implode(',', $arr_products) . ')' => NULL]);

        $data_notif = [];
        foreach ($list_product as $product) {
            $deskripsi = "Produk " . $product->full_code . " " . $product->name;
            $deskripsi .= " perlu diganti harga sesuai kontrak, agar kontrak menjadi aktif";

            $data_notif[] = [
                'id_pengirim' => $this->data['users']->id,
                'id_penerima' => $user_vendor,
                'deskripsi' => $deskripsi,
            ];
        }

        $this->db->insert_batch('notification', $data_notif);
    }

    public function download_format($format = 'comma')
    {

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename=data_lelang_' . time() . '.csv');
        header('Pragma: no-cache');
        header("Expires: 0");

        $fp = fopen('php://memory', 'r+');;

        $header = [
            'NO', 'DEPARTEMEN', 'KATEGORI', 'NAMA', 'SPESIFIKASI', 'MATA_UANG', 'HARGA', 'VENDOR', 'TANGGAL_TERKONTRAK', 'TANGGAL_BERAKHIR_KONTRAK', 'VOLUME', 'SATUAN', 'PROYEK_PENGGUNA', 'LOKASI', 'KETERANGAN'
        ];

        $separator = $format == 'comma' ? ',' : ';';

        fputcsv($fp, $header, $separator);
        rewind($fp);
        $csv_line = stream_get_contents($fp);
        echo rtrim($csv_line);
    }

    public function exportToExcel()
    {
        $where = [];
        $search = [];
        $where_and = [];
        if ($this->input->get('departemen')) {
            $where['departemen'] = $this->input->get('departemen');
        }

        if ($this->input->get('nama')) {
            $where_and['nama'] = $this->input->get('nama');
        }

        if ($this->input->get('spesifikasi')) {
            $where_and['spesifikasi'] = $this->input->get('spesifikasi');
        }

        if ($this->input->get('vendor')) {
            $where['vendor'] = $this->input->get('vendor');
        }

        if ($this->input->get('start_contract')) {
            $where["STR_TO_DATE(tgl_terkontrak, '%d/%m/%Y') >= '" . $this->input->get('start_contract') . "'"] = NULL;
        }

        if ($this->input->get('end_contract')) {
            $where["STR_TO_DATE(tgl_akhir_kontrak, '%d/%m/%Y') <= '" . $this->input->get('end_contract') . "'"] = NULL;
        }

        if ($this->input->get('lokasi')) {
            $where['lokasi'] = $this->input->get('lokasi');
        }

        if ($this->input->get('keterangan')) {
            $where['keterangan'] = $this->input->get('keterangan');
        }

        $data['data'] = $this->model->getAllBy(0, 0, $search, NULL, NULL, $where, $where_and);
        $this->load->view('admin/' . $this->cont . '/export_to_excel_v', $data);
    }
    public function history()
    {
        $this->data['content'] = 'admin/' . $this->cont . '/history';
        $this->load->view('admin/layouts/page', $this->data);
    }
    public function history_upload_dataList()
    {
        $this->load->model('Data_lelang_upload_history_model');
        $columns = array(
            'data_lelang_upload_history.id',
            'users.first_name',
            'groups.name',
            'data_lelang_upload_history.jml_row',
            'data_lelang_upload_history.created_at',
        );

        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $where = [];

        $limit = 0;
        $start = 0;

        $totalData = $this->Data_lelang_upload_history_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);


        $isSearchColumn =  false;
        if (($value = $this->input->post('search')['value']) != '') {
            $isSearchColumn = true;
            $search['users.first_name'] = $value;
            $search['data_lelang_upload_history.jml_row'] = $value;
        }

        if ($isSearchColumn) {
            $totalFiltered = $this->Data_lelang_upload_history_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
        } else {
            $totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $datas = $this->Data_lelang_upload_history_model->getAllBy($limit, $start, $search, $order, $dir, $where);

        $new_data = array();
        if (!empty($datas)) {
            foreach ($datas as $key => $data) {

                $nestedData['id'] = $start + $key + 1;
                $nestedData['first_name'] = $data->first_name;
                $nestedData['name'] = $data->name;
                $nestedData['jml_row'] = $data->jml_row;
                $nestedData['created_at'] = tgl_indo($data->created_at, TRUE);

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
}
