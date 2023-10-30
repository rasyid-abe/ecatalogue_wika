<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Transportasi extends Admin_Controller
{

    protected $cont = 'transportasi';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Transportasi_model', 'model');
        $this->load->model('Vendor_model');
        $this->load->model('Location_model');
        $this->load->model('Project_new_model');
        $this->load->model('Resources_code_model');
        $this->data['cont'] = $this->cont;
    }

    public function index()
    {
        if ($this->data['is_can_read']) {
            $where_vendor = ['is_deleted' => 0];
            /*if (!$this->data['is_superadmin']) {
            $where_vendor['id'] = $this->data['users']->vendor_id;
            }*/
            if ($this->data['users_groups']->id == 3) {
                $where_vendor['vendor.id'] = $this->data['users']->vendor_id;
            }

            $this->data['vendor'] = $this->Vendor_model->get_dropdown($where_vendor);

            $this->data['sda'] = $this->Resources_code_model->get_dropdown2(["code like 'EB%'" => null, 'status' => 1]);
            $this->data['location'] = $this->Location_model->get_dropdown2(['level in (2,3)' => null]);
            $this->data['location_destination'] = $this->Project_new_model->get_dropdown(['is_deleted' => 0]);
            $this->data['content'] = 'admin/' . $this->cont . '/list_v';
        } else {
            redirect('restrict');
        }

        $this->load->view('admin/layouts/page', $this->data);
    }

    public function dataList()
    {
        $columns = array(
            0 => 'transportasi.id',
            1 => 'vendor.name',
            2 => 'location.name',
            3 => 'location2.name',
            4 => 'transportasi.price',
        );
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $where = [
            'transportasi.is_deleted <>' => 2,
        ];

        $limit = 0;
        $start = 0;

        $totalData = $this->model->getCountAllBy($limit, $start, $search, $order, $dir, $where);

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;

        if (!empty($searchColumn[1]['search']['value'])) {
            $value = $searchColumn[1]['search']['value'];
            $isSearchColumn = true;
            $where['transportasi.vendor_id'] = $value;
        }

        if (!empty($searchColumn[2]['search']['value'])) {
            $value = $searchColumn[2]['search']['value'];
            $isSearchColumn = true;
            $search['transportasi.origin_location_id'] = $value;
        }

        if (!empty($searchColumn[3]['search']['value'])) {
            $value = $searchColumn[3]['search']['value'];
            $isSearchColumn = true;
            $search['transportasi.destination_location_id'] = $value;
        }

        if (!empty($searchColumn[4]['search']['value'])) {
            $value = $searchColumn[4]['search']['value'];
            $isSearchColumn = true;
            $search['transportasi.price'] = $value;
        }

        if ($isSearchColumn) {
            $totalFiltered = $this->model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
        } else {
            $totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $datas = $this->model->getAllBy($limit, $start, $search, $order, $dir, $where);
        // die($this->db->last_query());
        // die(print_r($datas));
        $new_data = array();
        if (!empty($datas)) {
            foreach ($datas as $key => $data) {

                $edit_url = "";
                $delete_url = "";
                $delete_permanent_url = "";

                if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
                    $edit_url = "<a href='" . base_url() . $this->cont . "/edit/" . $data->id . "' class='btn btn-xs btn-info'><i class='fa fa-pencil'></i> Ubah</a>";
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
                $nestedData['vendor_name'] = $data->vendor_name;
                $nestedData['origin_name'] = $data->origin_name;
                $nestedData['destination_name'] = $data->destination_name;
                $nestedData['price'] = rupiah($data->price);



                $nestedData['action'] = $edit_url . " " . $delete_url . ' ' . $delete_permanent_url;
                $new_data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $new_data,
        );

        echo json_encode($json_data);
    }

    public function create()
    {
        $this->form_validation->set_rules('vendor_id', "Vendor", 'trim|required');
        $this->form_validation->set_rules('origin_location_id', "Origin", 'trim|required');
        $this->form_validation->set_rules('destination_location_id', "Destinasi", 'trim|required');
        $this->form_validation->set_rules('price', "Harga", 'trim|required');

        if ($this->form_validation->run() === TRUE) {
            // pengecekan data, gak boleh ada yang sama
            $where = [
                'vendor_id' => $this->input->post('vendor_id'),
                'origin_location_id' => $this->input->post('origin_location_id'),
                'destination_location_id' => $this->input->post('destination_location_id')
            ];

            $cekData = $this->model->getOneBy($where);
            if ($cekData !== FALSE) {
                $this->session->set_flashdata('message_error', 'Vendor dengan Origin dan Destinasi tersebut sudah ada. silahkan coba lagi');
                redirect($this->cont . '/create');
            }

            $data = array_merge(['price' => $this->input->post('price'), 'created_by' => $this->data['users']->id], $where);
            $insert = $this->model->insert($data);
            if ($insert !== FALSE) {
                $this->session->set_flashdata('message', "Transportasi Berhasil Disimpan");
                redirect($this->cont);
            } else {
                $this->session->set_flashdata('message_error', "Transportasi Gagal Disimpan");
                redirect($this->cont);
            }
        }

        $where_vendor = ['is_deleted' => 0];
        /*if (!$this->data['is_superadmin']) {
            $where_vendor['id'] = $this->data['users']->vendor_id;
        }*/
        if ($this->data['users_groups']->id == 3) {
            $where_vendor['vendor.id'] = $this->data['users']->vendor_id;
        }

        $this->data['vendor'] = $this->Vendor_model->get_dropdown($where_vendor);
        $this->data['location'] = $this->Location_model->get_dropdown(['is_deleted' => 0]);
        $this->data['location_destination'] = $this->Location_model->get_dropdown(['is_deleted' => 0, 'is_prov' => 0]);
        $this->data['content'] = 'admin/' . $this->cont . '/create_v';
        $this->load->view('admin/layouts/page', $this->data);
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('vendor_id', "Vendor", 'trim|required');
        $this->form_validation->set_rules('origin_location_id', "Origin", 'trim|required');
        $this->form_validation->set_rules('destination_location_id', "Destinasi", 'trim|required');
        $this->form_validation->set_rules('price', "Harga", 'trim|required');

        if ($this->form_validation->run() === TRUE) {
            $where = [
                'vendor_id' => $this->input->post('vendor_id'),
                'origin_location_id' => $this->input->post('origin_location_id'),
                'destination_location_id' => $this->input->post('destination_location_id')
            ];

            $id = $this->input->post('id');
            $dataLama = $this->model->getOneBy(['id' => $id]);
            if (
                $dataLama->vendor_id != $this->input->post('vendor_id')
                || $dataLama->origin_location_id != $this->input->post('origin_location_id')
                || $dataLama->destination_location_id != $this->input->post('destination_location_id')
            ) {
                $cekData = $this->model->getOneBy($where);
                if ($cekData !== FALSE) {
                    $this->session->set_flashdata('message_error', 'Vendor dengan Origin dan Destinasi tersebut sudah ada. silahkan coba lagi');
                    redirect($this->cont . '/edit/' . $id);
                }
            }

            $data = array_merge(['price' => $this->input->post('price'), 'updated_by' => $this->data['users']->id], $where);
            $update = $this->model->update($data, ['id' => $id]);
            if ($update !== FALSE) {
                $this->session->set_flashdata('message', "Transportasi Berhasil dirubah");
                redirect($this->cont);
            } else {
                $this->session->set_flashdata('message_error', "Transportasi Gagal dirubah");
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
        $this->data['location'] = $this->Location_model->get_dropdown(['is_deleted' => 0, 'is_prov' => 0]);

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

    public function cekVendor()
    {
        $date = date("Y-m-d");
        $where = [
            'transportasi.destination_location_id' => $this->input->post('project_id'),
            'transportasi.origin_location_id' => $this->input->post('origin_location_id'),
            'transportasi.vendor_barang' => $this->input->post('data_vendor'),
            'IFNULL(transport_amandemen.start_contract,kontrak_transportasi.start_date) <=' => $date,
            'IFNULL(transport_amandemen.end_contract,kontrak_transportasi.end_date) >=' => $date,
        ];
        $location_id = $this->input->post('destination_location_id');
        $desa = $this->db->get_where('ref_locations', ['location_id' => $location_id])->row_array();
        $kecamatan = $this->db->get_where('ref_locations', ['location_id' => $desa['parent_id']])->row_array();
        $kabupaten = $this->db->get_where('ref_locations', ['location_id' => $kecamatan['parent_id']])->row_array();
        $return['location_id'] = (!empty($kabupaten)) ? $kabupaten['location_id'] : "";
        $group = 'transportasi.vendor_id';
        $data = $this->model->getDropdownMycart($where, $group);
        if ($data) {
            $new_data = [];
            foreach ($data as $key) {

                $ret['status'] = TRUE;
                $ret['id'] = $key->id;
                $ret['vendor_id'] = $key->vendor_id;
                $ret['price'] = $key->price_fot_scf;
                $ret['vendor_name'] = $key->vendor_name;
                $ret['location_name'] = $key->location_name;
                $new_data[] = $ret;
            }
            $return['status'] = TRUE;
            $return['data'] = $new_data;
        } else {
            $return['status'] = FALSE;
            $return['data'] = array();
        }
        echo json_encode($return);
    }
    public function cekTransport()
    {
        $date = date("Y-m-d");
        $where = [
            'transportasi.vendor_id' => $this->input->post('id_vendor'),
            'transportasi.vendor_barang' => $this->input->post('data_vendor'),
            'transportasi.destination_location_id' => $this->input->post('project_id'),
            'transportasi.origin_location_id' => $this->input->post('origin_location_id'),
            'IFNULL(transport_amandemen.start_contract,kontrak_transportasi.start_date) <=' => $date,
            'IFNULL(transport_amandemen.end_contract,kontrak_transportasi.end_date) >=' => $date,
        ];
        $group = 'transportasi.id';
        $data = $this->model->getDropdownMycart($where, $group);
        if ($data) {
            $new_data = [];
            foreach ($data as $key) {
                $ret['status'] = TRUE;
                $ret['id'] = $key->id;
                $ret['sda_code'] = $key->sda_code;
                $ret['sda_name'] = $key->sda_name;
                $new_data[] = $ret;
            }
            $return['status'] = TRUE;
            $return['data'] = $new_data;
        } else {
            $return['status'] = FALSE;
            $return['data'] = array();
        }
        echo json_encode($return);
    }
    public function cekHarga()
    {
        $date = date("Y-m-d");
        $where = [
            'transportasi.vendor_id' => $this->input->post('id_vendor'),
            'transportasi.destination_location_id' => $this->input->post('project_id'),
            'transportasi.origin_location_id' => $this->input->post('origin_location_id'),
            'transportasi.id' => $this->input->post('transport_id'),
            'IFNULL(transport_amandemen.start_contract,kontrak_transportasi.start_date) <=' => $date,
            'IFNULL(transport_amandemen.end_contract,kontrak_transportasi.end_date) >=' => $date,
        ];
        $group = 'transportasi.id';
        $data = $this->model->getDropdownMycart($where, $group);
        if ($data) {
            $new_data = [];
            foreach ($data as $key) {
                for ($x = 1; $x <= 4; $x++) {
                    $ret['status'] = TRUE;
                    if ($x == 1) {
                        $ret['harga'] = $key->price_fot_scf_new;
                        $ret['keterangan'] = 'Price FOT SCF';
                    } elseif ($x == 2) {
                        $ret['harga'] = $key->price_fot_tt_new;
                        $ret['keterangan'] = 'Price FOT TT';
                    } elseif ($x == 3) {
                        $ret['harga'] = $key->price_fog_scf_new;
                        $ret['keterangan'] = 'Price FOG SCF';
                    } elseif ($x == 4) {
                        $ret['harga'] = $key->price_fog_tt_new;
                        $ret['keterangan'] = 'Price FOG TT';
                    }
                    $new_data[] = $ret;
                }
            }
            $return['status'] = TRUE;
            $return['data'] = $new_data;
        } else {
            $return['status'] = FALSE;
            $return['data'] = array();
        }
        echo json_encode($return);
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

    public function getTransportasiVendor($vendorId)
    {
        $ret = [];
        $this->load->model('Location_model');

        $data = $this->model->getVendorTransportasiHandson(['vendor.id' => $vendorId]);
        $ret = [
            'status' => empty($data) ? FALSE : TRUE,
            'data' => $data,
            'sdaArr' => $this->Resources_code_model->getAllSDAArrName(),
            'locationArr' => $this->Location_model->getAllLocationArrName(),
            'projectArr' => $this->Project_new_model->getAllprojectArrName(),
            'vendorArr' => $this->Vendor_model->getAllVendorArrName(),
        ];

        echo json_encode($ret);
    }

    public function actSimpanHarga()
    {
        $this->load->model('Location_model');
        $allLocation = $this->Location_model->getAllById2(['level in (2,3)' => null]);
        $locationByName = [];
        if ($allLocation) {
            foreach ($allLocation as $key => $value) {
                $locationByName[$value->full_name] = $value->location_id;
            }
        }
        $allProject = $this->Project_new_model->getAllById(['is_deleted' => 0]);
        $projectByName = [];
        if ($allProject) {
            foreach ($allProject as $key => $value) {
                $projectByName[$value->name] = $value->id;
            }
        }

        $allSDA = $this->Resources_code_model->getAllById(['code like "EB%"' => null]);
        $sdaByName = [];
        if ($allSDA) {
            foreach ($allSDA as $key => $value) {
                $sdaByName[$value->name] = $value->code;
            }
        }

        $allVendor = $this->Vendor_model->getAllById(['is_deleted' => 0]);
        $vendorByName = [];
        if ($allVendor) {
            foreach ($allVendor as $key => $value) {
                $vendorByName[$value->name] = $value->id;
            }
        }

        $transportVendor = $this->model->getAllById(['is_deleted' => 0, 'vendor_id' => $this->input->post('vendor_id')]);
        $cek = $this->db->last_query();
        $arrTransVendor = [];
        if ($transportVendor) {
            foreach ($transportVendor as $key => $value) {
                $index = $value->sda_code . '_' . $value->vendor_barang . '_' . $value->origin_location_id . '_' . $value->destination_location_id;
                $arrTransVendor[$index] = $value->id;
            }
        }

        /*
        $ret = [
            'status' => $cek,
            'data' => $arrTransVendor,
            'query' => $transportVendor,
        ];

        echo json_encode($ret);
        return;
        */

        $dataInsert = [];
        $idDeleted = [];
        $this->db->trans_start();
        if ($this->input->post('data')) {
            foreach ($this->input->post('data') as $key => $value) {
                // var_dump($value);
                if (!isset($sdaByName[$value[0]]) || !isset($vendorByName[$value[1]]) || !isset($locationByName[$value[2]]) || !isset($projectByName[$value[3]])) {
                    continue;
                }

                $indexnya = $sdaByName[$value[0]] . '_' . $vendorByName[$value[1]] . '_' . $locationByName[$value[2]] . '_' . $projectByName[$value[3]];
                $idnya = isset($arrTransVendor[$indexnya]) ? $arrTransVendor[$indexnya] : 0;

                $data = [
                    'sda_code' => $sdaByName[$value[0]],
                    'vendor_barang' => $vendorByName[$value[1]],
                    'origin_location_id' => $locationByName[$value[2]],
                    'destination_location_id' => $projectByName[$value[3]],
                    'weight_minimum' => $value[4],
                    'price_fot_scf' => $value[5],
                    'price_fot_tt' => $value[6],
                    'price_fog_scf' => $value[7],
                    'price_fog_tt' => $value[8],
                ];

                // klo 0 berarti Insert, sisanya update
                if ($idnya == '0') {
                    $data['vendor_id'] = $this->input->post('vendor_id');
                    $data['created_by'] = $this->data['users']->id;
                    $dataInsert[] = $data;
                } else {
                    $data['updated_by'] = $this->data['users']->id;
                    $this->db->where(['id' => $idnya])->update('transportasi', $data);
                }
            }
           
            if (!empty($dataInsert)) {
                $this->db->insert_batch('transportasi', $dataInsert);
            }
        }
        
        if ($this->input->post('data_yang_dihapus')) {
            foreach ($this->input->post('data_yang_dihapus') as $key => $value) {
                if (isset($arrTransVendor[$value])) {
                    $idDeleted[] = $arrTransVendor[$value];
                }
            }
            
            if (!empty($idDeleted)) {
                $this->db->where_in('id', $idDeleted)->update('transportasi', ['is_deleted' => 1]);
            }
        }

        $this->db->trans_complete();
        $ret = [
            'status' => $this->db->trans_status(),
        ];

        echo json_encode($ret);
        die;
    }

    public function downloadWilayah()
    {
        $this->load->model('Location_model');
        $allLocation = $this->Location_model->getAllById(['is_deleted' => 0]);
        $this->load->view('admin/transportasi/download_wilayah_v', ['data' => $allLocation]);
    }

    public function downloadTransportasi($vendorId = 234)
    {
        $data = $this->model->getDataDownload(['vendor_id' => $vendorId]);
        // var_dump($data);
        $this->load->view('admin/transportasi/download_transportasi_v', ['data' => $data]);
    }
}
