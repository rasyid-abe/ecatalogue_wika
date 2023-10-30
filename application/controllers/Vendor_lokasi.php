<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Vendor_lokasi extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('vendor_lokasi_model');
        $this->load->model('Vendor_model');
        $this->load->model('specification_model');
        $this->load->model('Location_model');
    }

    public function index()
    {
        $this->load->helper('url');
        if ($this->data['is_can_read']) {
            $this->data['judul'] = 'Vendor Lokasi';
            $this->data['content']  = 'admin/vendor_lokasi/list_v';
        } else {
            redirect('restrict');
        }
        $this->load->view('admin/layouts/page', $this->data);
    }

    public function create()
    {
        $this->form_validation->set_rules('vendor_id', "Vendor Harus Diisi", 'trim|required');

        if ($this->form_validation->run() === TRUE) {
            echo "<pre>";
            if ($this->input->post('location_id')) {
                $this->db->trans_start();
                $dataVendorProv = [];
                $dataVendorKota = [];
                foreach ($this->input->post('location_id') as $key => $v) {
                    $lokasi = $this->input->post('location_id')[$key];
                    $getLokasi = $this->Location_model->getOneBy2(['location_id' => $lokasi]);
                    if ($getLokasi->level > 2) {
                        $dataVendorKota[] = [
                            'vendor_id'     => $this->input->post('vendor_id'),
                            'prov_id'       => $getLokasi->province_id,
                            'prov_name'     => $getLokasi->province_name,
                            'kota_id'       => $lokasi,
                            'kota_name'     => $getLokasi->full_name,
                            'wilayah_id'    => $lokasi,
                            'wilayah_name'  => $getLokasi->full_name,
                            'alamat'        => $this->input->post('alamat')[$key],
                            'latitude'      => $this->input->post('latitude')[$key],
                            'longitude'     => $this->input->post('longitude')[$key],
                        ];
                    } else {
                        $dataVendorProv[] = [
                            'vendor_id'     => $this->input->post('vendor_id'),
                            'prov_id'       => $lokasi,
                            'prov_name'     => $getLokasi->full_name,
                            'wilayah_id'    => $lokasi,
                            'wilayah_name'  => $getLokasi->full_name,
                            'alamat'        => $this->input->post('alamat')[$key],
                            'latitude'      => $this->input->post('latitude')[$key],
                            'longitude'     => $this->input->post('longitude')[$key],
                        ];
                    }
                }
                // print_r($dataVendorKota);
                // die;

                if ($dataVendorProv == NULL) {
                    $this->db->insert_batch('vendor_lokasi', $dataVendorKota);
                } elseif ($dataVendorKota == NULL) {
                    $this->db->insert_batch('vendor_lokasi', $dataVendorProv);
                } else {
                    $this->db->insert_batch('vendor_lokasi', $dataVendorProv);
                    $this->db->insert_batch('vendor_lokasi', $dataVendorKota);
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() === TRUE) {
                    $this->session->set_flashdata('message', "Vendor Lokasi Berhasil Disimpan");
                    redirect("vendor_lokasi");
                } else {
                    $this->session->set_flashdata('message_error', "Vendor Lokasi Gagal Disimpan");
                    redirect("vendor_lokasi");
                }
            }
        } else {
            $where_vendor = ['is_deleted' => 0];
            if (!$this->data['is_superadmin']) {
                $where_vendor['id'] = $this->data['users']->vendor_id;
            }

            $this->data['vendor'] = $this->Vendor_model->get_dropdown($where_vendor);
            $where['specification.is_deleted'] = 0;
            $this->data['specification'] = $this->specification_model->getSpecWithCat($where);
            // $this->data['location'] = $this->Location_model->getAllSort2();
            $this->data['content'] = 'admin/vendor_lokasi/new_create_v';
            $this->load->view('admin/layouts/page', $this->data);
        }
    }

    public function get_lokasi()
    {
        echo json_encode($this->Location_model->getAllSort2());
    }

    public function edit_data()
    {
        $id = $this->input->post('id', true);
        $data = $this->db->get_where('vendor_lokasi', ['vendor_id' => $id])->result_array();
        $result = [
            'data' => $data,
            'lokasi' => $this->Location_model->getAllSort2(),
        ];
        echo json_encode($result);
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('vendor_id', "Vendor Harus Diisi", 'trim|required');

        if ($this->form_validation->run() === TRUE) {
            if ($this->input->post('location_id')) {

                $this->db->where('vendor_id', $id)->delete('vendor_lokasi');
                $dataVendorProv = [];
                $dataVendorKota = [];
                foreach ($this->input->post('location_id') as $key => $v) {

                    $lokasi = $this->input->post('location_id')[$key];
                    $getLokasi = $this->Location_model->getOneBy2(['location_id' => $lokasi]);
                    if ($getLokasi->level > 2) {
                        $dataVendorKota[] = [
                            'vendor_id'     => $this->input->post('vendor_id'),
                            'prov_id'       => $getLokasi->province_id,
                            'prov_name'     => $getLokasi->province_name,
                            'kota_id'       => $lokasi,
                            'kota_name'     => $getLokasi->full_name,
                            'wilayah_id'    => $lokasi,
                            'wilayah_name'  => $getLokasi->full_name,
                            'alamat'        => $this->input->post('alamat')[$key],
                            'latitude'      => $this->input->post('latitude')[$key],
                            'longitude'     => $this->input->post('longitude')[$key],
                        ];
                    } else {
                        $dataVendorProv[] = [
                            'vendor_id'     => $this->input->post('vendor_id'),
                            'prov_id'       => $lokasi,
                            'prov_name'     => $getLokasi->full_name,
                            'wilayah_id'    => $lokasi,
                            'wilayah_name'  => $getLokasi->full_name,
                            'alamat'        => $this->input->post('alamat')[$key],
                            'latitude'      => $this->input->post('latitude')[$key],
                            'longitude'     => $this->input->post('longitude')[$key],
                        ];
                    }
                }

                if ($dataVendorProv == NULL) {
                    $this->db->insert_batch('vendor_lokasi', $dataVendorKota);
                } elseif ($dataVendorKota == NULL) {
                    $this->db->insert_batch('vendor_lokasi', $dataVendorProv);
                } else {
                    $this->db->insert_batch('vendor_lokasi', $dataVendorProv);
                    $this->db->insert_batch('vendor_lokasi', $dataVendorKota);
                }


                $this->session->set_flashdata('message', "Vendor Lokasi Berhasil Diedit");
                redirect("vendor_lokasi");
            }
        } else {
            if (!empty($_POST)) {
                $id = $this->input->post('id');
                $this->session->set_flashdata('message_error', validation_errors());
                return redirect("vendor_lokasi/edit/" . $id);
            } else {
                $where_vendor = ['is_deleted' => 0];
                if (!$this->data['is_superadmin']) {
                    $where_vendor['id'] = $this->data['users']->vendor_id;
                }
                $this->data['dataVendor'] = $this->Vendor_model->getvendor($where_vendor);
                $this->data['id'] = $this->uri->segment(3);
                $vendor_lokasi = $this->vendor_lokasi_model->getOneBy(array("vendor_lokasi.vendor_id
                " => $this->data['id']));
                $this->data['dataLokasi'] = $this->vendor_lokasi_model->getAllById(array("vendor_lokasi.vendor_id" => $this->data['id']));
                $this->data['vendor'] =   (!empty($vendor_lokasi)) ? $vendor_lokasi->vendor_id : "";
                $this->data['location'] = $this->Location_model->getAllSort2();
                $this->data['content'] = 'admin/vendor_lokasi/new_edit_v';
                $this->load->view('admin/layouts/page', $this->data);
            }
        }
    }

    public function dataList()
    {
        $columns = array(
            0 => 'vendor_lokasi.id',
            1 => 'vendor_lokasi.vendor',
            2 => 'specification.prov',
            3 => 'vendor_lokasi.kota',
        );


        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $where['vendor_lokasi.is_deleted !='] = 2;
        $limit = 0;
        $start = 0;
        $totalData = $this->vendor_lokasi_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);


        if (!empty($this->input->post('search')['value'])) {
            $search_value = $this->input->post('search')['value'];
            $name_vendor = $this->db->get_where('vendor', ['name' => $search_value])->row();
            $search = array(
                "vendor.name" => $search_value,
                "vendor_lokasi.prov_name" => $search_value,
                "vendor_lokasi.kota_name" => $search_value
            );

            $totalFiltered = $this->vendor_lokasi_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
        } else {
            $totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        if (!$this->data['is_superadmin']) {
            $where['vendor_id'] = $this->data['users']->vendor_id;
        }
        $datas = $this->vendor_lokasi_model->getAllBy($limit, $start, $search, $order, $dir, $where);

        $new_data = array();
        if (!empty($datas)) {
            foreach ($datas as $key => $data) {

                $edit_url = "";
                $delete_url = "";
                $delete_permanent = "";

                if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
                    $edit_url =  "<a href='" . base_url() . "vendor_lokasi/edit/" . $data->vendor_id . "' data-id='" . $data->vendor_id . "' style='color: white;'><div class='btn btn-sm btn-primary btn-blue btn-editview'>Ubah</div></a>";
                }
                if ($this->data['is_can_delete']) {
                    if ($data->is_deleted == 0) {
                        $delete_url = "<a href='#'
                            data-id='" . $data->vendor_id . "' data-isdeleted='" . $data->is_deleted . "' class='btn btn-sm btn-danger white delete' url='" . base_url() . "vendor_lokasi/destroy/" . $data->vendor_id . "/" . $data->is_deleted . "' >Non Aktifkan
                            </a>";
                    } else {
                        $delete_url = "<a href='#'
                            data-id='" . $data->vendor_id . "' data-isdeleted='" . $data->is_deleted . "' class='btn btn-sm btn-success white delete'
                             url='" . base_url() . "vendor_lokasi/destroy/" . $data->vendor_id . "/" . $data->is_deleted . "'>Aktifkan
                            </a>";
                        $delete_permanent = "<a  href='#' url='" . base_url() . "vendor_lokasi/destroy_permanent/" . $data->vendor_id . "' class='btn btn-sm btn-danger white delete'><i class='fa fa-trash-o'></i> Hapus</a>";
                    }
                }
                $nestedData['id'] = $start + $key + 1;
                $nestedData['vendor'] = $data->nama_vendor;
                if ($data->kota_name == NULL) {
                    $nestedData['lokasi']       =  $data->wilayah_name;
                } else {
                    $nestedData['lokasi']       = $data->wilayah_name . ', ' . $data->wilayah_name2;
                }
                $nestedData['lokasi']       =  $data->wilayah_name2;
                $nestedData['action']           = $edit_url . " " . $delete_url . " " . $delete_permanent;
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
            $data = array(
                'is_deleted' => ($is_deleted == 1) ? 0 : 1
            );
            $update = $this->vendor_lokasi_model->update($data, array("vendor_id" => $id));

            $response_data['data'] = $data;
            $response_data['status'] = true;
        } else {
            $response_data['msg'] = "ID Harus Diisi";
        }

        echo json_encode($response_data);
    }

    public function destroy_permanent()
    {
        $response_data = array();
        $response_data['status'] = false;
        $response_data['msg'] = "";
        $response_data['data'] = array();

        $id = $this->uri->segment(3);
        if (!empty($id)) {
            $data = array(
                'is_deleted'    => 2,
                'deleted_by'    => $this->data['users']->id,
                'deleted_time'  => $this->data['now_datetime']
            );
            $update = $this->vendor_lokasi_model->update($data, array("vendor_id" => $id));

            $response_data['data'] = $data;
            $response_data['status'] = true;
        } else {
            $response_data['msg'] = "ID Harus Diisi";
        }

        echo json_encode($response_data);
    }

    public function exportToExcel()
    {
        $this->load->model('Category_new_model');
        $this->load->model('Category_model');
        $this->load->model('Specification_model');
        $this->load->model('vendor_lokasi_model');
        $where = ['is_deleted' => 0];
        $categoryNew = $this->Category_new_model->getAllById($where);
        $category = [];
        $_catTemp = $this->Category_model->getAllById($where);
        if ($_catTemp !== FALSE) {
            foreach ($_catTemp as $key => $value) {
                $category[$value->category_new_id][] = $value;
            }
        }

        $specification = [];
        $_specTemp = $this->Specification_model->getAllById($where);
        if ($_specTemp !== FALSE) {
            foreach ($_specTemp as $key => $value) {
                $specification[$value->category_id][] = $value;
            }
        }

        $vendor_lokasi = [];
        $_vendor_lokasiTemp = $this->vendor_lokasi_model->getAllById();
        if ($_vendor_lokasiTemp !== FALSE) {
            foreach ($_vendor_lokasiTemp as $key => $value) {
                $vendor_lokasi[$value->specification_id][] = $value;
            }
        }

        $data = [
            'categoryNew' => $categoryNew,
            'category' => $category,
            'specification' => $specification,
            'vendor_lokasi' => $vendor_lokasi,
        ];

        $this->load->view('admin/vendor_lokasi/export_to_excel_v', $data);
    }

    public function getLocationVendor($vendorId)
    {
        $data = $this->vendor_lokasi_model->getAllById(['vendor_id' => $vendorId]);
        if ($data === FALSE) {
            $ret['status'] = FALSE;
        } else {
            $ret['status'] = TRUE;
            $ret['data'] = $data;
        }

        echo json_encode($ret);
    }
}
