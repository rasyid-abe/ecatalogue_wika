<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Peralatan extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('peralatan_model');
        $this->load->model('jenis_model');
        $this->load->model('project_new_model');
        $this->load->model('groups_model');

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

    public function index()
    {
        $this->load->helper('url');
        if ($this->data['is_can_read']) {
        
            $this->data['jenis'] = $this->jenis_model->getAllById();
            $this->data['kode_sda'] = $this->project_new_model->getAllById();
            $this->data['content']  = 'admin/peralatan/list_v';
        } else {
            redirect('restrict');
        }
        $this->load->view('admin/layouts/page', $this->data);
    }

    public function create()
    {
        $this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');
        $this->form_validation->set_rules('sub_kategori', "Sub Kategori Harus Diisi", 'trim|required');
        // $this->form_validation->set_rules('size_id',"Ukuran Harus Diisi", 'trim|required');
        // $this->form_validation->set_rules('vendor_id', "Vendor Harus Diisi", 'trim|required');
        // $this->form_validation->set_rules('term_of_delivery_id',"Term Of Delivery Harus Diisi", 'trim|required');
        // $this->form_validation->set_rules('uom_id', "Satuan Harus Diisi", 'trim|required');
        // $this->form_validation->set_rules('level1', "Sumber Daya Harus Diisi", 'trim|required');


        if ($this->form_validation->run() === TRUE) {
            $date = new DateTime(null, new DateTimeZone('Asia/Jakarta'));
            $now = $date->format('Y-m-d H:i:s');
            $data = array(
                'id_jenis' => $this->input->post('sub_kategori'),
                'name' => $this->input->post('name'),
                'merek' => $this->input->post('merek'),
                'no_inventaris' => $this->input->post('no_inventaris'),
                'qty' => $this->input->post('qty'),
                'no_rangka' => $this->input->post('no_rangka'),
                'no_mesin' => $this->input->post('no_mesin'),
                'posisi' => $this->input->post('posisi'),
                'kondisi' => $this->input->post('kondisi'),
                'id_proyek' => $this->input->post('proyek'),
                'id_divisi' => $this->input->post('divisi'),
                'asset_status' => $this->input->post('asset_status'),
                'operation_status' => $this->input->post('operation_status'),
                'tahun_beli' => $this->input->post('tahun_beli'),
                'harga_beli' => $this->input->post('harga_beli'),
                'deskripsi' => $this->input->post('deskripsi'),
                //'category_id' => $kode_sda,
                'user_pic' => $this->data['users']->id,
                'created_by' => $this->data['users']->id,
                'created_at' => $now,
            );
            $this->db->trans_begin();

            $insert = $this->peralatan_model->insert($data);
            if ($insert) {
                $po = array();
                if ($_FILES['pdf_po']['name']) {
                    $config['upload_path']          = './pdf/peralatan_po/';
                    $config['allowed_types']        = '*';
                    $config['max_size']             = 20000;
                    $random = rand(1000, 9999);
                    $do_upload = 'pdf_po';
                    $filename = pathinfo($_FILES['pdf_po']["name"]);
                    $extension = $filename['extension'];
                    $config['file_name'] = time() . "_" . $_FILES['pdf_po']['name'];
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload($do_upload)) {
                        $po = array(
                            "pdf_po" => $config['file_name'],
                        );
                        $this->peralatan_model->update($po,array("peralatan.id" => $insert));
                    }
                }
                $bukti_bayar = array();
                if ($_FILES['pdf_bukti_bayar']['name']) {
                    $config['upload_path']          = './pdf/peralatan_po/';
                    $config['allowed_types']        = '*';
                    $config['max_size']             = 20000;
                    $random = rand(1000, 9999);
                    $do_upload = 'pdf_bukti_bayar';
                    $filename = pathinfo($_FILES['pdf_bukti_bayar']["name"]);
                    $extension = $filename['extension'];
                    $config['file_name'] = time() . "_" . $_FILES['pdf_bukti_bayar']['name'];
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload($do_upload)) {
                        $bukti_bayar = array(
                            "pdf_bukti_bayar" => $config['file_name'],
                        );
                        $this->peralatan_model->update($bukti_bayar,array("peralatan.id" => $insert));
                    }
                }
                
                $data_akt = [
                    'user_id' => $this->data['users']->id,
                    'description' => 'Tambah asset/peralatan ' . $this->input->post('name'),
                    'aktifitas_category' => 1,
                    'id_reff' => $insert
                ];

                $this->db->insert('aktifitas_user', $data_akt);

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message_error', "Data peralatan Disimpan, Sebagian File Gagal Diupload");
                    redirect("peralatan");
                } else {
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Produk peralatan Berhasil Disimpan");
                    redirect("peralatan");
                }
            } else {
                $this->session->set_flashdata('message_error', "Produk peralatan Gagal Disimpan");
                redirect("peralatan");
            }
        } else {
            if ($this->data['is_can_create']) {
                $this->data['kategori'] = $this->jenis_model->get_dropdown(['is_deleted' => 0, 'level' => 1]);
                $this->data['proyek'] = $this->project_new_model->get_dropdown(['is_deleted' => 0]);
                $this->data['divisi'] = $this->groups_model->get_dropdown(['is_deleted' => 0]);
                $this->data['kondisi'] = $this->peralatan_model->get_dropdown(['status' => 1]);
                $this->data['asset_status'] = $this->peralatan_model->get_dropdown(['status' => 2]);
                $this->data['operation_status'] = $this->peralatan_model->get_dropdown(['status' => 3]);
                $this->data['content']  = 'admin/peralatan/create_v';
            } else {
                redirect('restrict');
            }
            $this->load->view('admin/layouts/page', $this->data);
        }
    }
    public function history()
    {
        $this->load->helper('url');
        if ($this->data['is_can_read']) {
        
            $this->data['jenis'] = $this->jenis_model->getAllById();
            $this->data['kode_sda'] = $this->project_new_model->getAllById();
            $this->data['content']  = 'admin/peralatan/list_history';
        } else {
            redirect('restrict');
        }
        $this->load->view('admin/layouts/page', $this->data);
    }

    public function edit($id)
    {
        $this->load->helper('url');
        $this->data['id'] = $this->uri->segment(3);

        if ($this->data['is_can_edit']) {
            $this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');
            $this->form_validation->set_rules('sub_kategori', "Jenis Harus Diisi", 'trim|required');

            if ($this->form_validation->run() === TRUE) {
                $data = array(
                    'id_jenis' => $this->input->post('sub_kategori'),
                    'name' => $this->input->post('name'),
                    'merek' => $this->input->post('merek'),
                    'no_inventaris' => $this->input->post('no_inventaris'),
                    'qty' => $this->input->post('qty'),
                    'no_rangka' => $this->input->post('no_rangka'),
                    'no_mesin' => $this->input->post('no_mesin'),
                    'posisi' => $this->input->post('posisi'),
                    'kondisi' => $this->input->post('kondisi'),
                    'id_proyek' => $this->input->post('proyek'),
                    'id_divisi' => $this->input->post('divisi'),
                    'asset_status' => $this->input->post('asset_status'),
                    'operation_status' => $this->input->post('operation_status'),
                    'tahun_beli' => $this->input->post('tahun_beli'),
                    'harga_beli' => $this->input->post('harga_beli'),
                    'deskripsi' => $this->input->post('deskripsi'),
                    //'category_id' => $kode_sda,
                    //'user_pic' => $this->data['users']->id,
                    'updated_by' => $this->data['users']->id,
                    
                );
                
                $upload = 1;
                $upload2 = 1;
                
                $po = array();
                if ($_FILES['pdf_po']['name']) {
                    $config['upload_path']          = './pdf/peralatan_po/';
                    $config['allowed_types']        = '*';
                    $config['max_size']             = 20000;
                    $random = rand(1000, 9999);
                    $do_upload = 'pdf_po';
                    $filename = pathinfo($_FILES['pdf_po']["name"]);
                    $extension = $filename['extension'];
                    $config['file_name'] =   time() . "_" . $_FILES['pdf_po']['name'];
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload($do_upload)) {
                        $po = array(
                            "pdf_po" => $config['file_name'],
                        );
                        $this->peralatan_model->update($po,array("peralatan.id" => $id));
                        unlink($config['upload_path'] . $this->input->post('old_pdf_po'));
                        $upload = 1;
                    } else {
                        $upload = 0;
                    }
                }
                $bukti_bayar = array();
                if ($_FILES['pdf_bukti_bayar']['name']) {
                    $config['upload_path']          = './pdf/peralatan_po/';
                    $config['allowed_types']        = '*';
                    $config['max_size']             = 20000;
                    $random = rand(1000, 9999);
                    $do_upload = 'pdf_bukti_bayar';
                    $filename = pathinfo($_FILES['pdf_bukti_bayar']["name"]);
                    $extension = $filename['extension'];
                    $config['file_name'] = time() . "_" . $_FILES['pdf_bukti_bayar']['name'];
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload($do_upload)) {
                        $bukti_bayar = array(
                            "pdf_bukti_bayar" => $config['file_name'],
                        );
                        $this->peralatan_model->update($bukti_bayar,array("peralatan.id" => $id));
                        unlink($config['upload_path'] . $this->input->post('old_pdf_bukti_bayar'));
                        $upload2 = 1;
                    } else {
                        $upload2 = 0;
                    }
                }

                $update = $this->peralatan_model->update($data, array("peralatan.id" => $id));

                if ($update || $upload || $upload2) {
                    $this->db->trans_begin();
                    $data_akt = [
                        'user_id' => $this->data['users']->id,
                        'description' => 'Edit Peralatan ' . $this->input->post('name'),
                        'aktifitas_category' => 1,
                        'id_reff' => $id
                    ];

                    $this->db->insert('aktifitas_user', $data_akt);

                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message_error', "Peralatan Gagal Diubah");
                    } else {
                        $this->db->trans_commit();
                        $this->session->set_flashdata('message', "Peralatan Berhasil Diubah");
                    }
                    redirect("peralatan", "refresh");
                } else {
                    $this->session->set_flashdata('message_error', "Peralatan Gagal Diubah");
                    redirect("peralatan", "refresh");
                }
            } else {
                $this->data['content']  = 'admin/peralatan/edit_v';
                $data = $this->peralatan_model->findperalatan(array("peralatan.id" => $this->data['id']));
                $this->data['id_peralatan'] =   (!empty($data)) ? $data->id : "";
                $this->data['id_kategori'] =   (!empty($data)) ? $data->id_jenis : "";
                $this->data['name'] =   (!empty($data)) ? $data->name : "";
                $this->data['merek'] =   (!empty($data)) ? $data->merek : "";
                $this->data['no_inventaris'] =   (!empty($data)) ? $data->no_inventaris : "";
                $this->data['qty'] =   (!empty($data)) ? $data->qty : "";
                $this->data['no_rangka'] =   (!empty($data)) ? $data->no_rangka : "";
                $this->data['no_mesin'] =   (!empty($data)) ? $data->no_mesin : "";
                $this->data['posisi'] =   (!empty($data)) ? $data->posisi : "";
                $this->data['id_kondisi'] =   (!empty($data)) ? $data->kondisi : "";
                $this->data['id_proyek'] =   (!empty($data)) ? $data->id_proyek : "";
                $this->data['id_divisi'] =   (!empty($data)) ? $data->id_divisi : "";
                $this->data['id_asset_status'] =   (!empty($data)) ? $data->asset_status : "";
                $this->data['id_operation_status'] =   (!empty($data)) ? $data->operation_status : "";
                $this->data['tahun_beli'] =   (!empty($data)) ? $data->tahun_beli : "";
                $this->data['harga_beli'] =   (!empty($data)) ? $data->harga_beli : "";
                $this->data['deskripsi'] =   (!empty($data)) ? $data->deskripsi : "";
                $this->data['pdf_po'] =   (!empty($data)) ? $data->pdf_po : "";
                $this->data['pdf_bukti_bayar'] =   (!empty($data)) ? $data->pdf_bukti_bayar : "";
                
                $kode_sub_kategori = (!empty($data)) ? $data->id_jenis : "";
                $kode_kategori = $this->db->get_where('jenis', ['id' => $kode_sub_kategori])->row_array();

                $this->data['kode_sub_kategori'] = (!empty($kode_sub_kategori)) ? $kode_sub_kategori : "";
                $this->data['kode_kategori'] = (!empty($kode_kategori)) ? $kode_kategori['parent_id'] : "";
                
                $this->data['kategori'] = $this->jenis_model->get_dropdown(['is_deleted' => 0, 'level' => 1]);
                $this->data['sel_kategori'] = $this->jenis_model->get_dropdown(['level' => 1, 'is_deleted' => 0]);
                $this->data['sel_sub_kategori'] = $this->jenis_model->get_dropdown(['level' => 2, 'is_deleted' => 0, 'parent_id' => $kode_kategori['parent_id']]);
                
                $this->data['proyek'] = $this->project_new_model->get_dropdown(['is_deleted' => 0]);
                $this->data['divisi'] = $this->groups_model->get_dropdown(['is_deleted' => 0]);
                $this->data['kondisi'] = $this->peralatan_model->get_dropdown(['status' => 1]);
                $this->data['asset_status'] = $this->peralatan_model->get_dropdown(['status' => 2]);
                $this->data['operation_status'] = $this->peralatan_model->get_dropdown(['status' => 3]);
            }
        } else {
            redirect('restrict');
        }
        $this->load->view('admin/layouts/page', $this->data);
    }
    public function dataList()
    {
        $columns = array(
            2 => 'jenis.name',
            3 => 'peralatan.name',
            4 => 'peralatan.no_inventaris',
            5 => 'project_new.name',
            6 => 'users.user_name',
            7 => 'peralatan.updated_at',
        );


        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $where['peralatan.is_deleted !='] = 2;

        // if ($this->data['users_groups']->id == 3) {
        //     $where['product.vendor_id'] = $this->data['users']->vendor_id;
        // }

        $limit = 0;
        $start = 0;
        $totalData = $this->peralatan_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
        // print_r($totalData);

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;

        if (!empty($this->input->post('search')['value'])) {
            $isSearchColumn = true;
            $search_value = $this->input->post('search')['value'];
            $search = array(
                "peralatan.name" => $search_value,
                "jenis.name" => $search_value,
                "project_new.name" => $search_value,
            );
        }

        if (!empty($searchColumn[3]['search']['value'])) {
            $value = $searchColumn[3]['search']['value'];
            $isSearchColumn = true;
            $where['peralatan.id_jenis'] = $value;
        }
        if (!empty($searchColumn[4]['search']['value'])) {
            $value = $searchColumn[4]['search']['value'];
            $isSearchColumn = true;
            $where['peralatan.id_proyek'] = $value;
        }
        //$tes = $searchColumn[4]['search']['value'];
        //echo json_encode($where);
        //die;

        if ($isSearchColumn) {
            $totalFiltered = $this->peralatan_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
        } else {
            $totalFiltered = $totalData;
        }

        // print_r($totalFiltered);
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $datas = $this->peralatan_model->getAllBy($limit, $start, $search, $order, $dir, $where);
        // print_r($datas);
        // die;
        $new_data = array();
        if (!empty($datas)) {
            foreach ($datas as $key => $data) {

                $edit_url = "";
                $delete_url = "";
                $delete_permanent = "";

                if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
                    $edit_url =  "<a href='" . base_url() . "peralatan/edit/" . $data->id . "' data-id='" . $data->id . "' style='color: white;'><div class='btn btn-sm btn-primary btn-blue btn-editview '>Edit</div></a>";
                }
                if ($this->data['is_can_delete']) {
                    if ($data->is_deleted == 0) {
                        $delete_url = "<a href='#'
                            data-id='" . $data->id . "' data-isdeleted='" . $data->is_deleted . "' class='btn btn-sm btn-danger white delete' url='" . base_url() . "peralatan/destroy/" . $data->id . "/" . $data->is_deleted . "' >Non Aktifkan
                            </a>";
                    } else {
                        $delete_url = "<a href='#'
                            data-id='" . $data->id . "' data-isdeleted='" . $data->is_deleted . "' class='btn btn-sm btn-success white delete'
                             url='" . base_url() . "peralatan/destroy/" . $data->id . "/" . $data->is_deleted . "'>Aktifkan
                            </a>";
                        $delete_permanent = "<a  href='#' url='" . base_url() . "peralatan/destroy_permanent/" . $data->id . "' class='btn btn-sm btn-danger white delete'><i class='fa fa-trash-o'></i> Hapus</a>";
                    }
                }
                
                $nestedData['cek_data']   ="<input type='checkbox' name='idsData[]' class='check_delete' value='" . $data->id . "' />";
                $nestedData['id']             = $start + $key + 1;;
                $nestedData['jenis_name2']    = $data->jenis_name2;
                $nestedData['jenis_name']    = $data->jenis_name;
                $nestedData['name']           = $data->name;
                $nestedData['no_inventaris']  = $data->no_inventaris;
                $nestedData['project_name']    = $data->project_name;
                $nestedData['user_name']    = $data->user_name;
                $nestedData['updated_at']    = $data->updated_at;
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
    public function list_history()
    {
        $columns = array(
            1 => 'peralatan_download.tender',
            2 => 'peralatan_download.owner',
            3 => 'peralatan_download.tgl_tender',
            4 => 'users.username',
            5 => 'groups.name',
            6 => 'jenis.name',
            7 => 'peralatan.name',
            8 => 'peralatan.merek',
            9 => 'peralatan.no_inventaris',
            10 => 'peralatan.posisi',
            11 => 'project_new.name',
            12 => 'peralatan_download.created_at',
        );


        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $where['peralatan.is_deleted !='] = 2;

        // if ($this->data['users_groups']->id == 3) {
        //     $where['product.vendor_id'] = $this->data['users']->vendor_id;
        // }

        $limit = 0;
        $start = 0;
        $totalData = $this->peralatan_model->getCountAllBy2($limit, $start, $search, $order, $dir, $where);
        // print_r($totalData);

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;

        if (!empty($this->input->post('search')['value'])) {
            $isSearchColumn = true;
            $search_value = $this->input->post('search')['value'];
            $search = array(
                "peralatan.name" => $search_value,
                "jenis.name" => $search_value,
                "project_new.name" => $search_value,
            );
        }

        if ($isSearchColumn) {
            $totalFiltered = $this->peralatan_model->getCountAllBy2($limit, $start, $search, $order, $dir, $where);
        } else {
            $totalFiltered = $totalData;
        }

        // print_r($totalFiltered);
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $datas = $this->peralatan_model->getAllBy2($limit, $start, $search, $order, $dir, $where);
        // print_r($datas);
        // die;
        $new_data = array();
        if (!empty($datas)) {
            foreach ($datas as $key => $data) {
                $nestedData['id']             = $start + $key + 1;;
                $nestedData['tender']    = $data->tender;
                $nestedData['owner']           = $data->owner;
                $nestedData['tgl_tender']  = $data->tgl_tender;
                $nestedData['user_name']    = $data->user_name;
                $nestedData['divisi_name']    = $data->divisi_name;
                $nestedData['jenis_name']    = $data->jenis_name;
                $nestedData['name']           = $data->name;
                $nestedData['merek']    = $data->merek;
                $nestedData['no_inventaris']  = $data->no_inventaris;
                $nestedData['posisi']    = $data->posisi;
                $nestedData['project_name']    = $data->project_name;
                $nestedData['created_at']    = $data->tgl_download;
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
    public function get_kategori()
    {
        $kategori = $this->input->post('kategori', true);
        $data = $this->db->get_where('jenis', ['parent_id' => $kategori,'is_deleted' => 0])->result_array();
        echo json_encode($data);
    }
    public function download()
    {
        if ($this->data['is_can_create']) {
            if (!empty($_POST)) {
                $this->load->library('zip');
                $tender = $this->input->post('tender', true);
                $owner = $this->input->post('owner', true);
                $tgl_tender = $this->input->post('tgl_tender', true);
                $id = $this->input->post('ids', true);
                $id_explode = explode(',',$id);
                foreach ($id_explode as $key=>$value)
                {
                    $date = new DateTime(null, new DateTimeZone('Asia/Jakarta'));
                    $now = $date->format('Y-m-d H:i:s');
                    $data = array(
                        'id_peralatan' => $value,
                        'tender' => $tender ,
                        'owner' => $owner,
                        'tgl_tender' => $tgl_tender,
                        'created_by' => $this->data['users']->id,
                        'created_at' => $now,
                    );
                    $this->peralatan_model->insert_download($data);
                    $data = $this->peralatan_model->findperalatan(array("peralatan.id" => $value));
                    $pdf_po =   (!empty($data)) ? $data->pdf_po : "";
                    $pdf_bukti_bayar =   (!empty($data)) ? $data->pdf_bukti_bayar : "";
                    $filepath1 = FCPATH.'/pdf/peralatan_po/'.$pdf_po;
                    $filepath2 = FCPATH.'/pdf/peralatan_po/'.$pdf_bukti_bayar;
                    $this->zip->read_file($filepath1);
                    $this->zip->read_file($filepath2);
                    
                }
                
                $this->session->set_flashdata('message',"Kode sumber daya Berhasil disimpan");
                
                $filename = "download.zip";
                $this->zip->download($filename);
                redirect("peralatan");
            
            }
        } else {
            redirect('peralatan');
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
            $this->db->trans_start();
            $data = array(
                'is_deleted' => ($is_deleted == 1) ? 0 : 1
            );
            $update = $this->peralatan_model->update($data, array("id" => $id));

            $data_akt = [
                'user_id' => $this->data['users']->id,
                'description' => 'Set ' . ($is_deleted == 1 ? 'Active' : 'Inactive') . ' asset/peralatan',
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
        $return['data'] = $this->product_model->getAllDataProduct(['product.vendor_id' => $vendor_id, "product.code_1 like '" . $string_level2 . "%'" => NULL]);
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
            $update = $this->peralatan_model->update($data, array("id" => $id));

            $response_data['data'] = $data;
            $response_data['status'] = true;
        } else {
            $response_data['msg'] = "ID Harus Diisi";
        }

        echo json_encode($response_data);
    }
}
