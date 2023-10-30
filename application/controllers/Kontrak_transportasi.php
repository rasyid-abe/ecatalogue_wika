<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Kontrak_transportasi extends Admin_Controller
{

    protected $cont = 'kontrak_transportasi';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kontrak_transportasi_model', 'model');
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
            0 => 'kontrak_transportasi.id',
            1 => 'kontrak_transportasi.no_contract',
            2 => 'vendor.name',
            3 => 'kontrak_transportasi.tgl_kontrak',
            4 => 'start_contract',
            5 => 'end_contract',
        );
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $where = array('kontrak_transportasi.is_deleted <>' => 2);

        $limit = 0;
        $start = 0;

        $totalData = $this->model->getCountAllBy($limit, $start, $search, $order, $dir, $where);

        if (!empty($this->input->post('search')['value'])) {
            $search_value = $this->input->post('search')['value'];
            $search = array(
                "kontrak_transportasi.no_contract" => $search_value,
                "vendor.name" => $search_value,
                "kontrak_transportasi.start_date" => $search_value,
                "kontrak_transportasi.end_date" => $search_value,
                "kontrak_transportasi.tgl_kontrak" => $search_value
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
                $generateHargaUrl = "";
                $amandemen_url = "";
                $detail_url = "";
                $delete_permanent_url = "";

                if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
                    $edit_url = "<a href='" . base_url() . $this->cont . "/edit/" . $data->id . "' class='btn btn-xs btn-info'><i class='fa fa-pencil'></i> Ubah</a>";
                    $generateHargaUrl = "<a href='" . base_url() . $this->cont . "/generate/" . $data->id . "' class='btn btn-xs btn-info'><i class='fa fa-dollar'></i> Generate Harga</a>";
                    $amandemen_url = "<a href='" . base_url() . $this->cont . "/amandemen/" . $data->id . "' class='btn btn-xs btn-warning'><i class='fa fa-bookmark'></i>Amandemen</a>";
                    $detail_url = "<a href='" . base_url() . $this->cont . "/detail/" . $data->id . "' class='btn btn-xs btn-success'><i class='fa fa-bars'></i>Detail</a>";
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
                $nestedData['no_contract'] = $data->no_contract . ($data->no_amandemen ? '-Amd' . $data->no_amandemen : '');
                $nestedData['vendor_name'] = $data->vendor_name;
                $nestedData['start_date'] = tgl_indo($data->start_contract);
                $nestedData['end_date'] = tgl_indo($data->end_contract);
                $nestedData['tgl_kontrak'] = tgl_indo($data->tgl_kontrak);
                $nestedData['action'] = $edit_url . " " . $delete_url . " " . $amandemen_url . ' ' . $generateHargaUrl . ' ' . $detail_url . " " . $delete_permanent_url;
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

    public function vendor_create_validation($str)
    {
        $where = [
            'vendor_id' => $str,
            'is_deleted <>' => 2,
        ];

        if ($this->db->get_where('kontrak_transportasi', $where)->num_rows() > 0) {
            $this->form_validation->set_message('vendor_create_validation', 'Vendor tersebut sudah ada kontraknya !');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function create()
    {
        $this->form_validation->set_rules('vendor_id', "Vendor", 'trim|required|callback_vendor_create_validation');
        $this->form_validation->set_rules('no_contract', "No Kontrak", 'trim|required');
        $this->form_validation->set_rules('start_date', "Start Date", 'trim|required');
        $this->form_validation->set_rules('end_date', "End Date", 'trim|required');
        $this->form_validation
            ->set_rules('tgl_kontrak', "Tanggal Kontrak", 'trim|required');
        //->set_rules('data_trailer',"Data Trailer", 'trim|required');

        if ($this->form_validation->run() === TRUE) {
            $data = array(
                'no_contract'   => $this->input->post('no_contract'),
                'vendor_id'     => $this->input->post('vendor_id'),
                'start_date'    => $this->input->post('start_date'),
                'end_date'      => $this->input->post('end_date'),
                'created_by'    => $this->data['users']->id,
                'tgl_kontrak'   => $this->input->post('tgl_kontrak'),
                //    'data_trailer'   => implode(',', $this->input->post('data_trailer')),
                //    'weight_minimum' => $this->input->post('weight_minimum'),
            );
            $upload = 1;
            if ($_FILES['file_contract']['name']) {
                $config['upload_path']          = './file_contract_transportasi/';
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
            $insert = $this->model->insert($data);

            if ($insert === FALSE) {
                $this->session->set_flashdata('message_error', "Kontrak transportasi gagal disimpan");
                redirect($this->cont);
            } else {
                $this->session->set_flashdata('message', "Kontrak transportasi berhasil disimpan");
                redirect($this->cont);
            }
        }

        $this->load->model('Transportasi_model');
        $this->data['vendor'] = $this->Transportasi_model->getVendorTransportasi();
        $this->data['content'] = 'admin/' . $this->cont . '/create_v';
        $this->load->view('admin/layouts/page', $this->data);
    }

    public function vendor_edit_validation($str, $id)
    {
        $where = [
            'id <>' => $id,
            'vendor_id' => $str,
            'is_deleted <>' => 2,
        ];

        if ($this->db->get_where('kontrak_transportasi', $where)->num_rows() > 0) {
            $this->form_validation->set_message('vendor_edit_validation', 'Vendor tersebut sudah ada kontraknya !');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('vendor_id', "Vendor", 'trim|required|callback_vendor_edit_validation[' . $id . ']');
        $this->form_validation->set_rules('no_contract', "No Kontrak", 'trim|required');
        $this->form_validation->set_rules('start_date', "Start Date", 'trim|required');
        $this->form_validation->set_rules('end_date', "End Date", 'trim|required');
        $this->form_validation
            ->set_rules('tgl_kontrak', "Tanggal Kontrak", 'trim|required');
        // ->set_rules('data_trailer',"Data Trailer", 'trim|required');

        if ($this->form_validation->run() === TRUE) {
            $data = array(
                'no_contract'   => $this->input->post('no_contract'),
                'vendor_id'     => $this->input->post('vendor_id'),
                'start_date'    => $this->input->post('start_date'),
                'end_date'      => $this->input->post('end_date'),
                'updated_by'    => $this->data['users']->id,
                'tgl_kontrak'   => $this->input->post('tgl_kontrak'),
                //    'data_trailer'   => implode(',', $this->input->post('data_trailer')),
                //    'weight_minimum' => $this->input->post('weight_minimum'),
            );
            $upload = 1;
            if ($_FILES['file_contract']['name']) {
                $config['upload_path']          = './file_contract_transportasi/';
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

            $update = $this->model->update($data, ['id' => $id]);


            if ($update === FALSE) {
                $this->session->set_flashdata('message_error', "Kontrak transportasi gagal diubah");
                redirect($this->cont, "refresh");
            } else {
                $this->session->set_flashdata('message', "Kontrak transportasi berhasil diubah");
                redirect($this->cont, "refresh");
            }
        }


        $this->data['id'] = $id;
        $data = $this->model->getOneBy(array("id" => $this->data['id']));
        if ($data === FALSE) {
            redirect($this->cont);
        }

        $this->data['data'] = $data;
        $this->load->model('Transportasi_model');
        $this->data['vendor'] = $this->Transportasi_model->getVendorTransportasi();
        $this->data['content'] = 'admin/' . $this->cont . '/edit_v';
        $this->load->view('admin/layouts/page', $this->data);
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

    public function get_list_kategori_feedback()
    {
        $ret = [];
        $ret['data'] = $this->model->getAllById(['is_deleted' => 0]);
        echo json_encode($ret);
    }

    public function generate($id)
    {
        $this->data['id'] = $id;
        $this->data['content'] = 'admin/' . $this->cont . '/generate_v';
        $this->load->view('admin/layouts/page', $this->data);
    }

    public function get_harga_for_generate($id)
    {
        $ret = [];
        $kontrak = $this->model->getOneBy(['id' => $id]);
        $ret['status'] = $status = $kontrak->status;

        $ret['column'] = [
            ['data' => 'transportasi_id', 'readOnly' => TRUE],
            ['data' => 'sda_name', 'readOnly' => TRUE],
            ['data' => 'vendor_name', 'readOnly' => TRUE],
            ['data' => 'asal', 'readOnly' => TRUE],
            ['data' => 'tujuan', 'readOnly' => TRUE],
            ['data' => 'berat_minimum'],
            ['data' => 'harga_fot_scf'],
            ['data' => 'harga_fot_tt'],
            ['data' => 'harga_fog_scf'],
            ['data' => 'harga_fog_tt'],
        ];
        $ret['data'] = $this->model->getHargaTransportasi(['transportasi.vendor_id' => $kontrak->vendor_id], $status);
        $ret['header'] = ['ID', 'SUMBER DAYA TRANSPORT', 'VENDOR', 'ASAL', 'POYEK',  'BERAT MIN', 'FOT SCF 180', 'FOT TT', 'FOG SCF 180', 'FOG TT'];

        echo json_encode($ret);
    }

    public function act_generate_harga()
    {
        $status = $this->input->post('status');
        $kontrak_transportasi_id = $this->input->post('kontrak_transportasi_id');
        $data = $this->input->post('data');

        $data_insert = [];
        $this->db->trans_start();

        if ($status == 0) {
            $this->model->update(['status' => 1], ['id' => $kontrak_transportasi_id]);
        } else if ($status == 1 || $status == 2) {
            $this->db->where(['kontrak_transportasi_id' => $kontrak_transportasi_id, 'is_deleted' => 0]);
            $this->db->update('generate_transport_price', ['is_deleted' => 1]);
        }

        foreach ($data as $k => $v) {
            $amandemen_id = $this->model->getOneBy(['id' => $kontrak_transportasi_id])->last_amandemen_id;

            $data_insert[] = [
                'kontrak_transportasi_id' => $kontrak_transportasi_id,
                'transport_id' => $v[0],
                'weight_minimum' => $v[5],
                'price_fot_scf' => $v[6],
                'price_fot_tt' => $v[7],
                'price_fog_scf' => $v[8],
                'price_fog_tt' => $v[9],
                'amandemen_id' => $amandemen_id,
                'created_by' => $this->data['users']->id,
            ];
        }

        $data_aktifitias_user = [
            'user_id' => $this->data['users']->id,
            'description' => 'Generate harga transport',
            'id_reff' => $kontrak_transportasi_id,
            'aktifitas_category' => 5,
        ];
        $this->db->insert('aktifitas_user', $data_aktifitias_user);

        $this->db->insert_batch('generate_transport_price', $data_insert);
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

    public function amandemen($id)
    {
        $this->form_validation->set_rules('kontrak_transportasi_id', "Nilai Asuransi", 'trim|required');
        $this->form_validation->set_rules('start_date', "Start Date", 'trim|required');
        $this->form_validation->set_rules('end_date', "End Date", 'trim|required');

        if ($this->form_validation->run() === TRUE) {
            $this->load->model('Transport_amandemen_model', 'amandemen');

            $no_amandemen = $this->amandemen->get_no_amandemen_terakhir($this->input->post('kontrak_transportasi_id'));
            $no_amandemen = $no_amandemen->no_amandemen ? $no_amandemen->no_amandemen + 1 : 1;

            $data = [
                'kontrak_transportasi_id' => $this->input->post('kontrak_transportasi_id'),
                'no_amandemen'          => $no_amandemen,
                'start_contract'        => $this->input->post('start_date'),
                'end_contract'          => $this->input->post('end_date'),
                'created_at'            => date('Y-m-d H:i:s'),
                'created_by'            => $this->data['users']->id,
            ];


            $this->db->trans_start();
            $insert = $this->amandemen->insert($data);
            $this->model->update(['last_amandemen_id' => $insert, 'status' => 2], ['id' =>  $this->input->post('kontrak_transportasi_id')]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->session->set_flashdata('message', "Amandemen Transportasi Berhasil dibuat");
                redirect($this->cont);
            } else {
                $this->session->set_flashdata('message_error', "Amandemen Transportasi Gagal dibuat");
                redirect($this->cont);
            }
        }

        $this->data['id'] = $id;
        $data = $this->model->getOneBy(array("id" => $this->data['id']));
        if ($data === FALSE) {
            redirect($this->cont);
        }

        if ($data->last_amandemen_id) {
            $this->load->model('Transport_amandemen_model');
            $dataAmandemen = $this->Transport_amandemen_model->getOneBy(['id' => $data->last_amandemen_id]);
            if ($dataAmandemen) {
                $data->start_date = $dataAmandemen->start_contract;
                $data->end_date = $dataAmandemen->end_contract;
            }
        }

        $this->data['data'] = $data;
        $this->load->model('Transportasi_model');
        $this->data['vendor'] = $this->Transportasi_model->getVendorTransportasi();
        $this->data['content'] = 'admin/' . $this->cont . '/amandemen_v';
        $this->load->view('admin/layouts/page', $this->data);
    }


    public function detail($id)
    {
        $detail = $this->model->get_detail_kontrak(['kontrak_transportasi.id' => $id]);
        if ($detail === FALSE) {
            $this->session->set_flashdata('message', "Tidak Ada Data Amandemen");
            redirect($this->cont);
        }

        $this->data['detail_amandemen'] = $detail;
        $this->data['kontrak_transportasi_id'] = $id;
        $this->data['content'] = 'admin/' . $this->cont . '/detail_v';
        $this->load->view('admin/layouts/page', $this->data);
    }

    public function detail_dataList($kontrak_transportasi_id)
    {

        $columns = array(
            0 => 'transport_amandemen.no_amandemen',
            1 => 'vendor.name',
            2 => 'transport_amandemen.start_contract',
            3 => 'transport_amandemen.end_contract',
        );
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $where['kontrak_transportasi.id'] = $kontrak_transportasi_id;
        $limit = 0;
        $start = 0;
        $this->load->model('Transport_amandemen_model');
        $totalData = $this->Transport_amandemen_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;


        if ($isSearchColumn) {
            $totalFiltered = $this->Transport_amandemen_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
        } else {
            $totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $datas = $this->Transport_amandemen_model->getAllBy($limit, $start, $search, $order, $dir, $where);
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
                $nestedData['vendor_name'] = $data->vendor_name;
                $nestedData['start_contract'] = tgl_indo($data->start_contract);
                $nestedData['end_contract'] = tgl_indo($data->end_contract);

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
}
