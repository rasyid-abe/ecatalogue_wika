<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
// require_once BASEPATH. 'vendor/autoload.php';
use Mpdf\Mpdf;
class Resources_berat extends Admin_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('excel');
    }

    public function index()
    {
        $this->load->helper('url');
        if($this->data['is_can_read']){
            $this->data['title'] = 'Berat Sumber Daya';
            $this->data['content']  = 'admin/resources_code/list_berat';
            $this->data['level1'] = $this->db->get_where('resources_code', ['level' => 1, 'status' => 1])->result_array();

        }else{
            redirect('restrict');
        }
        $this->load->view('admin/layouts/page',$this->data);
    }

    public function show_data()
    {
        $sql = $this->db->get('resources_berat')->result_array();
        $data = [];
        foreach ($sql as $key => $v) {
            $data[] = [
                'code' => $v['code'],
                'name' => $v['name'],
                'berat1' => $v['berat1'],
                'berat2' => $v['berat2'],
                'berat3' => $v['berat3'],
                'satuan1' => $this->db->get_where('uoms', ['id' => $v['satuan1']])->row('name'),
                'satuan2' => $this->db->get_where('uoms', ['id' => $v['satuan2']])->row('name'),
                'satuan3' => $this->db->get_where('uoms', ['id' => $v['satuan3']])->row('name'),
            ];
        }
        $result = [
            'data' => $data,
            'can_edit' => $this->data['is_can_edit'],
        ];
        echo json_encode($result);
    }

    public function level_change()
    {
        $data = $this->input->post('data', true);
        $sql = $this->db->get_where('resources_code', ['parent_code' => $data, 'status' => 1])->result_array();

        echo json_encode($sql);
    }

    public function show_data_param()
    {
        $data = $this->input->post('data', true);
        $lvl = $this->input->post('lvl', true);

        if ($lvl == 1) {
            $kode = substr($data, 0, 1);
            $lev = 1;
        } elseif ($lvl == 2) {
            $kode = substr($data, 0, 2);
            $lev = 2;
        } elseif ($lvl == 3) {
            $kode = substr($data, 0, 3);
            $lev = 3;
        } elseif ($lvl == 4) {
            $kode = substr($data, 0, 4);
            $lev = 4;
        } elseif ($lvl == 5) {
            $kode = substr($data, 0, 5);
            $lev = 5;
        }

        $sql = "
        SELECT rc.resources_code_id, rc.code, rc.name, rb.id_berat, rb.code code_berat, rb.berat1, rb.satuan1, rb.berat2, rb.satuan2, rb.berat3, rb.satuan3 FROM resources_code rc LEFT JOIN resources_berat rb ON rc.code = rb.code WHERE rc.code LIKE '$kode%' AND rc.level > $lev
        ";

        $query = $this->db->query($sql)->result_array();

        $result = [
            'uoms' => $this->db->get('uoms')->result_array(),
            'data' => $query,
            'can_edit' => $this->data['is_can_edit'],
        ];
        echo json_encode($result);
    }

    public function get_data()
    {
        $code = $this->input->post('code', true);
        $data = $this->db->get_where('resources_berat', ['code' => $code])->row_array();
        $uoms = $this->db->get('uoms')->result_array();

        $result = [
            'data' => $data,
            'uoms' => $uoms,
        ];

        echo json_encode($result);
    }

    public function store()
    {
        $code = $this->input->post('code', true);

        $data = [
            'code' => $code,
            'name' => $this->input->post('name', true),
            'berat1' => $this->input->post('berat1', true),
            'satuan1' => $this->input->post('satuan1', true),
            'berat2' => $this->input->post('berat2', true),
            'satuan2' => $this->input->post('satuan2', true),
            'berat3' => $this->input->post('berat3', true),
            'satuan3' => $this->input->post('satuan3', true),
        ];

        $check = $this->db->get_where('resources_berat', ['code' => $code])->num_rows();
        if ($check > 0) {
            if ($this->data['is_can_edit']) {
                $this->db->where('code', $code);
                $insert = $this->db->update('resources_berat', $data);
                if ($insert) {
                    if ($this->input->post('status') != '') {
                        $r = [
                            'status' => true,
                            'pesan' => 'Berat sumber daya Berhasil diubah',
                        ];

                        echo json_encode($r);
                    } else {
                        $this->session->set_flashdata('message',"Berat sumber daya Berhasil diubah");
                        redirect("resources_berat");
                    }
                }

            } else {
                redirect('restrict');
            }
        } else {
            if ($this->data['is_can_create']) {
                $insert = $this->db->insert('resources_berat', $data);
                if ($insert) {
                    if ($this->input->post('status') != '') {
                        $r = [
                            'status' => true,
                            'pesan' => 'Berat sumber daya Berhasil disimpan',
                        ];

                        echo json_encode($r);
                    } else {
                        $this->session->set_flashdata('message',"Berat sumber daya Berhasil disimpan");
                        redirect("resources_berat");
                    }
                }

            } else {
                redirect('restrict');
            }
        }


    }

}
