<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Resources_treeview extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->load->helper('url');
        if ($this->data['is_can_read']) {
            $this->data['title'] = 'List Kode Sumber Daya';
            $this->data['content']  = 'admin/resources_code/treeview_code';
            $this->data['data'] = $this->generate_data();
            $this->data['log_data'] = $this->query_log();
            $this->data['lastupdate'] = $this->query_lastupdate();
        } else {
            redirect('restrict');
        }
        $this->load->view('admin/layouts/page', $this->data);
    }

    private function query_log()
    {
        $sql = "
            SELECT l.*, u.first_name FROM resources_code_logs l
            LEFT JOIN users u ON l.created_by = u.id
        ";
        $data = $this->db->query($sql)->result_array();
        return $data;
    }

    private function query_lastupdate()
    {
        $sql = "
            SELECT l.*, u.first_name FROM resources_code_logs l
            LEFT JOIN users u ON l.created_by = u.id ORDER BY id_logs DESC LIMIT 1
        ";
        $data = $this->db->query($sql)->row_array();
        // print_r($data); die;
        return $data;
    }

    private function get_child($parent)
    {
        $this->db->order_by('code', 'ASC');
        $data = $this->db->get_where('resources_code', [
            'parent_code' => $parent,
            'status' => 1
        ])->result_array();

        return $data;
    }

    private function generate_data()
    {
        $data1 = [];
        $this->db->order_by('code', 'ASC');
        $level1 = $this->db->get_where('resources_code', [
            'parent_code' => null,
            'status' => 1
        ])->result_array();

        for ($i = 0; $i < count($level1); $i++) {
            $level2 = $this->get_child($level1[$i]['code']);
            if ($level2 != '') {
                $data2 = [];
                for ($j = 0; $j < count($level2); $j++) {
                    $level3 = $this->get_child($level2[$j]['code']);
                    if ($level3 != '') {
                        $data3 = [];
                        for ($k = 0; $k < count($level3); $k++) {
                            $level4 = $this->get_child($level3[$k]['code']);
                            if ($level4 != '') {
                                $data4 = [];
                                for ($l = 0; $l < count($level4); $l++) {
                                    $level5 = $this->get_child($level4[$l]['code']);
                                    if ($level5 != '') {
                                        $data5 = [];
                                        for ($m = 0; $m < count($level5); $m++) {
                                            $level6 = $this->get_child($level5[$m]['code']);
                                            if ($level6 != '') {
                                                $data6 = [];
                                                for ($n = 0; $n < count($level6); $n++) {
                                                    $data6[] = [
                                                        '_id' => $level6[$n]['resources_code_id'],
                                                        'parent_code' => $level6[$n]['parent_code'],
                                                        'code' => $level6[$n]['code'],
                                                        'name' => $level6[$n]['name'],
                                                    ];
                                                }
                                            }
                                            $data5[] = [
                                                '_id' => $level5[$m]['resources_code_id'],
                                                'parent_code' => $level5[$m]['parent_code'],
                                                'code' => $level5[$m]['code'],
                                                'name' => $level5[$m]['name'],
                                                'child' => $data6,
                                            ];
                                        }
                                    }
                                    $data4[] = [
                                        '_id' => $level4[$l]['resources_code_id'],
                                        'parent_code' => $level4[$l]['parent_code'],
                                        'code' => $level4[$l]['code'],
                                        'name' => $level4[$l]['name'],
                                        'child' => $data5,
                                    ];
                                }
                            }
                            $data3[] = [
                                '_id' => $level3[$k]['resources_code_id'],
                                'parent_code' => $level3[$k]['parent_code'],
                                'code' => $level3[$k]['code'],
                                'name' => $level3[$k]['name'],
                                'child' => $data4,
                            ];
                        }
                    }
                    $data2[] = [
                        '_id' => $level2[$j]['resources_code_id'],
                        'parent_code' => $level2[$j]['parent_code'],
                        'code' => $level2[$j]['code'],
                        'name' => $level2[$j]['name'],
                        'child' => $data3,
                    ];
                }
            }
            $data1[] = [
                '_id' => $level1[$i]['resources_code_id'],
                'parent_code' => $level1[$i]['parent_code'],
                'code' => $level1[$i]['code'],
                'name' => $level1[$i]['name'],
                'child' => $data2,
            ];
        }
        // echo "<pre>";
        // print_r($data1); die;

        return $data1;
    }

    public function status_ids()
    {
        $codes = $this->input->post('idsData', true);

        $arr_tbl = [];
        for ($i = 0; $i < count($codes); $i++) {
            $arr_tbl[] = $this->db->get_where('resources_code', ['code' => $codes[$i]])->row_array();
        }

        $arr_in = [];
        foreach ($arr_tbl as $v) {
            $arr_in['code'][] = $v['code'];
            $arr_in['scode'][] = substr($v['code'], 0, 1);
            $arr_in['scode'][] = substr($v['code'], 0, 2);
            $arr_in['scode'][] = substr($v['code'], 0, 3);
            $arr_in['scode'][] = substr($v['code'], 0, 4);
            $arr_in['scode'][] = substr($v['code'], 0, 5);
            $arr_in['scode'][] = substr($v['code'], 0, 6);
        }

        $this->session->set_userdata('arr_tbl', $arr_tbl);
        $this->session->set_userdata('arr_in', $arr_in);
        redirect("resources_treeview");
    }

    public function query($kode)
    {
        $sql = "SELECT * FROM resources_code WHERE code LIKE '$kode%'";
        $data = $this->db->query($sql)->result_array();

        return $data;
    }

    public function ids_remove()
    {
        $ids = $this->input->post('ids', true);
        $data = $this->session->userdata('arr_in');
        $kode = $data['code'];

        $arr_remove = [];
        foreach ($kode as $key => $value) {
            if (in_array($value, $ids)) {
                $arr_remove[] = $key;
            }
        }

        for ($i = 0; $i < count($arr_remove); $i++) {
            unset($kode[$arr_remove[$i]]);
        }

        $arr_tbl = [];
        foreach ($kode as $key => $value) {
            $arr_tbl[] = $this->db->get_where('resources_code', ['code' => $value])->row_array();
        }

        $arr_in = [];
        foreach ($arr_tbl as $v) {
            $arr_in['code'][] = $v['code'];
            $arr_in['scode'][] = substr($v['code'], 0, 1);
            $arr_in['scode'][] = substr($v['code'], 0, 2);
            $arr_in['scode'][] = substr($v['code'], 0, 3);
            $arr_in['scode'][] = substr($v['code'], 0, 4);
            $arr_in['scode'][] = substr($v['code'], 0, 5);
            $arr_in['scode'][] = substr($v['code'], 0, 6);
        }

        $this->session->set_userdata('arr_tbl', $arr_tbl);
        $this->session->set_userdata('arr_in', $arr_in);
        redirect("resources_treeview");
    }

    public function generate_pdf()
    {
        if ($this->data['is_can_download']) {
            $this->data['data'] = $this->session->userdata('arr_tbl');
            $this->data['user'] = $this->db->get_where('users', ['id' => $this->data['users']->id])->row('first_name');
            $this->data['tgl_export'] = tgl_indo(date('Y-m-d'));
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
            $html = $this->load->view('admin/resources_code/pdf_nomenklatur', $this->data, true);
            $mpdf->WriteHTML($html);
            $mpdf->SetMargins(0, 0, 0);
            $filename = "Nomenklatur_SDA" . time();
            $mpdf->Output($filename . ".pdf", "I");
        } else {
            redirect('restrict');
        }
    }
}
