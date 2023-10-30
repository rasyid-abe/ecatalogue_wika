<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Asuransi extends Admin_Controller
{

    protected $cont = 'asuransi';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Asuransi_model', 'model');
        $this->load->model('Amandemen_asuransi_model', 'amandemen');
        $this->load->model('Project_model');
        $this->load->model('Vendor_model');
        $this->load->model('Category_model');
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
            0 => 'asuransi.id',
            1 => 'asuransi.no_contract',
            2 => 'vendor.name',
            3 => 'asuransi.tgl_kontrak',
            4 => 'asuransi.start_date',
            5 => 'asuransi.end_date',
            6 => 'asuransi.nilai_asuransi',
        );
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $where = ['asuransi.is_deleted <>' => 2];

        $limit = 0;
        $start = 0;

        $totalData = $this->model->getCountAllBy($limit, $start, $search, $order, $dir, $where);

        if (!empty($this->input->post('search')['value'])) {
            $search_value = $this->input->post('search')['value'];
            $search = array(
                "asuransi.no_contract" => $search_value,
                "vendor.name" => $search_value,
                "asuransi.start_date" => $search_value,
                "asuransi.end_date" => $search_value,
                "asuransi.nilai_asuransi" => $search_value,
                "asuransi.tgl_kontrak" => $search_value
            );

            $totalFiltered = $this->model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
        } else {
            $totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $datas = $this->model->getAllBy($limit, $start, $search, $order, $dir, $where);

        $new_data = array();
        if (!empty($datas)) {
            foreach ($datas as $key => $data) {

                $edit_url = "";
                $delete_url = "";
                $amandemen_url = "";
                $detail_url = "";
                $delete_permanent_url = "";


                if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
                    if ($data->last_amandemen_id == NULL) {
                        $edit_url = "<a href='" . base_url() . $this->cont . "/edit/" . $data->id . "' class='btn btn-sm btn-info'><i class='fa fa-pencil'></i> Ubah</a>";
                    }
                    $amandemen_url = "<a href='" . base_url() . $this->cont . "/amandemen/" . $data->id . "' class='btn btn-sm btn-warning'><i class='fa fa-bookmark'></i> Amandemen </a>";
                    $detail_url = "<a href='" . base_url() . $this->cont . "/detail/" . $data->id . "' class='btn btn-sm btn-success'><i class='fa fa-bars'></i> Detail</a>";
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
                $nestedData['vendor_name'] = $data->vendor_name;
                if ($data->no_amandemen) {
                    $nestedData['no_contract'] = $data->no_contract . '-Amd ' . $data->no_amandemen;
                } else {
                    $nestedData['no_contract'] = $data->no_contract;
                }
                $nestedData['start_date'] = tgl_indo($data->start_contract2);
                $nestedData['tgl_kontrak'] = $data->tgl_kontrak ? tgl_indo($data->tgl_kontrak) : '';
                $nestedData['end_date'] = tgl_indo($data->end_date2);
                $nestedData['nilai_asuransi'] = rupiah($data->nilai_asuransi2, 3) . ($data->jenis_asuransi2 == 'percent' ? ' %' : ' /Kg');

                $nestedData['action'] = $edit_url . " " . $delete_url . " " . $amandemen_url . " " . $detail_url . " " . $delete_permanent_url;
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
        $this->form_validation
            ->set_rules('vendor_id', "Vendor", 'trim|required')
            ->set_rules('no_contract', "No Kontrak", 'trim|required')
            ->set_rules('nilai_asuransi', "Nilai Asuransi", 'trim|required')
            ->set_rules('start_date', "Start Date", 'trim|required')
            ->set_rules('end_date', "End Date", 'trim|required')
            ->set_rules('jenis_asuransi', "Jenis Asuransi", 'trim|required')
            ->set_rules('tahun', "Tahun", 'trim|required')
            ->set_rules('no_cargo_insurance', "No Kargo Insurance", 'trim|required');

        if ($this->form_validation->run() === TRUE) {

            $data = [
                'no_contract'   => $this->input->post('no_contract'),
                'vendor_id'     => $this->input->post('vendor_id'),
                'nilai_asuransi' => $this->input->post('nilai_asuransi'),
                'start_date'    => $this->input->post('start_date'),
                'end_date'      => $this->input->post('end_date'),
                'jenis_asuransi' => $this->input->post('jenis_asuransi'),
                'tgl_kontrak'   => $this->input->post('tgl_kontrak'),
                'nilai_harga_minimum'   => $this->input->post('nilai_harga_minimum'),
                'tahun'                 => $this->input->post('tahun'),
                'no_cargo_insurance'    => $this->input->post('no_cargo_insurance'),
            ];
            $insert = $this->model->insert($data);
            if ($insert !== FALSE) {
                $this->session->set_flashdata('message', "Asuransi Berhasil Disimpan");
                redirect($this->cont);
            } else {
                $this->session->set_flashdata('message_error', "Asuransi Gagal Disimpan");
                redirect($this->cont);
            }
        }

        $where_vendor = ['is_deleted' => 0];
        if (!$this->data['is_superadmin']) {
            $where_vendor['id'] = $this->data['users']->vendor_id;
        }

        $this->data['vendor'] = $this->Vendor_model->get_dropdown($where_vendor);
        $this->data['content'] = 'admin/' . $this->cont . '/create_v';
        $this->load->view('admin/layouts/page', $this->data);
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('vendor_id', "Vendor", 'trim|required');
        $this->form_validation->set_rules('no_contract', "No Kontrak", 'trim|required');
        $this->form_validation->set_rules('nilai_asuransi', "Nilai Asuransi", 'trim|required');
        $this->form_validation->set_rules('start_date', "Start Date", 'trim|required');
        $this->form_validation->set_rules('end_date', "End Date", 'trim|required');
        $this->form_validation
            ->set_rules('jenis_asuransi', "Jenis Asuransi", 'trim|required')
            ->set_rules('tahun', "Tahun", 'trim|required')
            ->set_rules('no_cargo_insurance', "No Kargo Insurance", 'trim|required');

        if ($this->form_validation->run() === TRUE) {
            $data = [
                'no_contract' => $this->input->post('no_contract'),
                'vendor_id' => $this->input->post('vendor_id'),
                'nilai_asuransi' => $this->input->post('nilai_asuransi'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'jenis_asuransi' => $this->input->post('jenis_asuransi'),
                'tgl_kontrak'   => $this->input->post('tgl_kontrak'),
                'nilai_harga_minimum'   => $this->input->post('nilai_harga_minimum'),
                'tahun'                 => $this->input->post('tahun'),
                'no_cargo_insurance'    => $this->input->post('no_cargo_insurance'),
            ];

            $id = $this->input->post('id');
            $update = $this->model->update($data, ['id' => $id]);
            if ($update !== FALSE) {
                $this->session->set_flashdata('message', "Asuransi Berhasil dirubah");
                redirect($this->cont);
            } else {
                $this->session->set_flashdata('message_error', "Asuransi Gagal dirubah");
                redirect($this->cont);
            }
        }

        $data = $this->model->getOneBy(['id' => $id]);
        if ($data === FALSE) {
            $this->session->set_flashdata('message_error', "Data tidak ditemukan");
            redirect($this->cont, "refresh");
        }
        $this->data['id'] = $id;
        $this->data['data'] = $data;
        $where_vendor = ['is_deleted' => 0];
        if (!$this->data['is_superadmin']) {
            $where_vendor['id'] = $this->data['users']->vendor_id;
        }

        $this->data['vendor'] = $this->Vendor_model->get_dropdown($where_vendor);

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

    public function detail_dataList($id_asuransi)
    {

        $columns = array(
            0 => 'no_amandemen',
            1 => 'name_vendor',
            2 => 'start_contract',
            3 => 'end_contract',
            4 => 'nilai_min',
            5 => 'nilai_asuransi',
            6 => 'jenis_asuransi',
        );
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $where['id_asuransi'] = $id_asuransi;
        $limit = 0;
        $start = 0;
        $totalData = $this->amandemen->getCountAllBy($limit, $start, $search, $order, $dir);

        if (!empty($this->input->post('search')['value'])) {
            $search_value = $this->input->post('search')['value'];
            $search = array(
                "asuransi.no_contract" => $search_value,
                "vendor.name" => $search_value,
                "amandemen_asuransi.start_contract" => $search_value,
                "amandemen_asuransi.end_contract" => $search_value,
                "amandemen_asuransi.nilai_harga_minimum" => $search_value,
                "amandemen_asuransi.nilai_asuransi" => $search_value

            );


            $totalFiltered = $this->amandemen->getCountAllBy($limit, $start, $search, $order, $dir);
        } else {
            $totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $where['id_asuransi'] = $id_asuransi;
        $datas = $this->amandemen->getAllBy($limit, $start, $search, $order, $dir, $where);

        $new_data = array();
        if (!empty($datas)) {
            foreach ($datas as $key => $data) {

                $edit_url = "";
                $delete_url = "";
                $detail_url = "<a href='javascript:;' class='btn btn-sm white detail' data-id='" . $data->id . "'><i class='fa fa-bars'></i> Detail</a>";
                $amandemen_url = '';

                $nestedData['id']                   = $start + $key + 1;
                $nestedData['no_kontrak']           = $data->no_contract . '-Amd' . $data->no_amandemen;
                $nestedData['vendor_name']          = $data->vendor_name;
                $nestedData['start_contract']       = tgl_indo($data->start_contract);
                $nestedData['end_contract']         = tgl_indo($data->end_contract);
                $nestedData['nilai_harga_minimum']  = rupiah($data->nilai_harga_minimum, 2);
                $nestedData['nilai_asuransi']       = rupiah($data->nilai_asuransi, 3);
                if ($data->jenis_asuransi == 'percent') {
                    $nestedData['jenis_asuransi'] = 'Menggunakan Persentase (Asuransi akan dihitung berdasarkan persentase * Nilai PO)';
                } else {
                    $nestedData['jenis_asuransi'] = 'Nilai Fix (Asuransi akan dikali weight )';
                }
                // $nestedData['action'] = $edit_url." ".$delete_url . " " . $amandemen_url . " " .$detail_url ;
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

    public function amandemen($id)
    {
        $this->form_validation->set_rules('nilai_asuransi', "Nilai Asuransi", 'trim|required');
        $this->form_validation->set_rules('start_date', "Start Date", 'trim|required');
        $this->form_validation->set_rules('end_date', "End Date", 'trim|required');
        $this->form_validation->set_rules('jenis_asuransi', "Jenis Asuransi", 'trim|required');

        if ($this->form_validation->run() === TRUE) {
            $no_amandemen = $this->amandemen->get_no_amandemen_terakhir($id);
            $no_amandemen = $no_amandemen->no_amandemen ? $no_amandemen->no_amandemen + 1 : 1;
            date_default_timezone_set('Asia/Jakarta');
            $data = [
                'id_asuransi'           => $id,
                'no_amandemen'          => $no_amandemen,
                'start_contract'        => $this->input->post('start_date'),
                'end_contract'          => $this->input->post('end_date'),
                'nilai_harga_minimum'   => $this->input->post('nilai_harga_minimum'),
                'nilai_asuransi'        => $this->input->post('nilai_asuransi'),
                'jenis_asuransi'        => $this->input->post('jenis_asuransi'),
                'created_at'            => date('Y-m-d H:i:s'),
                'created_by'            => $this->data['users']->id,

            ];

            $insert = $this->amandemen->insert($data);
            // update asuransi
            $this->db->set('last_amandemen_id', $insert)
                ->where('id', $id)
                ->update('asuransi');
            if ($insert) {
                $this->session->set_flashdata('message', "Asuransi Berhasil dibuat");
                redirect($this->cont);
            } else {
                $this->session->set_flashdata('message_error', "Asuransi Gagal dibuat");
                redirect($this->cont);
            }
        } else {
            $cekAmandemen = $this->db->get_where('asuransi', ['id' => $id])->row();
            if ($cekAmandemen->last_amandemen_id == NULL) {
                $data = $this->model->getOneBy(['id' => $id]);
                $where_vendor = ['is_deleted' => 0];
                if (!$this->data['is_superadmin']) {
                    $where_vendor['id'] = $this->data['users']->vendor_id;
                }
                if ($data === FALSE) {
                    $this->session->set_flashdata('message_error', "Data tidak ditemukan");
                    redirect($this->cont, "refresh");
                }
            } else {
                $data = $this->amandemen->get_detail(['amandemen_asuransi.id' => $cekAmandemen->last_amandemen_id]);
                $where_vendor['id'] = $cekAmandemen->vendor_id;
            }

            $this->data['id'] = $id;
            $this->data['data'] = $data;
            $this->data['vendor'] = $this->Vendor_model->get_dropdown($where_vendor);

            $this->data['content'] = 'admin/' . $this->cont . '/amandemen_v';
            $this->load->view('admin/layouts/page', $this->data);
        }
    }

    public function detail($id)
    {

        $detail = $this->amandemen->get_detail(['amandemen_asuransi.id_asuransi' => $id]);


        if ($detail === FALSE) {
            $this->session->set_flashdata('message', "Tidak Ada Data Amandemen");
            redirect($this->cont);
        }
        $this->data['detail_amandemen'] = $detail;
        $this->data['id_asuransi'] = $id;
        $this->data['content'] = 'admin/' . $this->cont . '/detail_v';
        $this->load->view('admin/layouts/page', $this->data);
    }
}
