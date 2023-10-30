<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Resources_code5 extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Resources_code_model');
    }

    public function index()
    {
        $this->load->helper('url');
        if ($this->data['is_can_read']) {
            $this->data['title'] = 'Level 5';
            $this->data['content']  = 'admin/resources_code/list_code5';
            $this->data['data'] = $this->db->get_where('resources_code', ['level' => 5])->result_array();
        } else {
            redirect('restrict');
        }
        $this->load->view('admin/layouts/page', $this->data);
    }

    public function get_kategori()
    {
        $data = $this->db->get_where('resources_code', ['parent_code' => null])->result_array();
        echo json_encode($data);
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

    public function get_level1_edit()
    {
        $id = $this->input->post('id', true);
        $parent = $this->db->get_where('resources_code', ['resources_code_id' => $id])->row_array();
        $parent1 = $this->db->get_where('resources_code', ['code' => $parent['parent_code']])->row_array();
        $parent2 = $this->db->get_where('resources_code', ['code' => $parent1['parent_code']])->row_array();
        $parent3 = $this->db->get_where('resources_code', ['code' => $parent2['parent_code']])->row_array();
        $result = [
            'code' => $parent3['parent_code'],
            'name' => $this->db->get_where('resources_code', ['code' => $parent3['parent_code']])->row('name'),
            'data' => $this->db->get_where('resources_code', ['level' => 1])->result_array(),
        ];
        echo json_encode($result);
    }

    public function get_level4_edit()
    {
        $id = $this->input->post('id', true);
        $parent = $this->db->get_where('resources_code', ['resources_code_id' => $id])->row_array();
        $parent1 = $this->db->get_where('resources_code', ['code' => $parent['parent_code']])->row_array();
        $data = $this->db->get_where('resources_code', ['parent_code' => $parent1['parent_code']])->result_array();
        $result = [
            'code' => $parent['parent_code'],
            'name' => $this->db->get_where('resources_code', ['code' => $parent['parent_code']])->row('name'),
            'data' => $data,
        ];
        echo json_encode($result);
    }

    public function get_level3_edit()
    {
        $id = $this->input->post('id', true);
        $parent = $this->db->get_where('resources_code', ['resources_code_id' => $id])->row_array();
        $parent1 = $this->db->get_where('resources_code', ['code' => $parent['parent_code']])->row_array();
        $parent2 = $this->db->get_where('resources_code', ['code' => $parent1['parent_code']])->row_array();
        $data = $this->db->get_where('resources_code', ['parent_code' => $parent2['parent_code']])->result_array();
        $result = [
            'code' => $parent1['parent_code'],
            'name' => $this->db->get_where('resources_code', ['code' => $parent1['parent_code']])->row('name'),
            'data' => $data,
        ];
        echo json_encode($result);
    }

    public function get_jenis_edit()
    {
        $id = $this->input->post('id', true);
        $parent = $this->db->get_where('resources_code', ['resources_code_id' => $id])->row_array();
        $parent1 = $this->db->get_where('resources_code', ['code' => $parent['parent_code']])->row_array();
        $parent2 = $this->db->get_where('resources_code', ['code' => $parent1['parent_code']])->row_array();
        $parent3 = $this->db->get_where('resources_code', ['code' => $parent2['parent_code']])->row_array();
        $data = $this->db->get_where('resources_code', ['parent_code' => $parent3['parent_code']])->result_array();
        $result = [
            'code' => $parent2['parent_code'],
            'name' => $this->db->get_where('resources_code', ['code' => $parent2['parent_code']])->row('name'),
            'data' => $data,
        ];
        echo json_encode($result);
    }

    public function create()
    {
        if ($this->data['is_can_create']) {
            if (!empty($_POST)) {
                $level4 = $this->input->post('level4', true);
                $inc = $this->Resources_code_model->increment($level4, 5);
                $code = substr($level4, 0, 4) . $inc['data'] . '0';
                $name = strtoupper($this->input->post('name', true));
                $description = $this->input->post('desc', true);

                if ($inc['data'] == 'err') {
                    $this->session->set_flashdata('message_error', $inc['msg']);
                    redirect("resources_code5");
                } else {
                    $arr_data = [
                        // 'code' => $code,
                        'parent_code' => $level4,
                        'name' => $name,
                        'description' => $description,
                        'level' => 5,
                        'sts_matgis' => $this->db->get_where('resources_code', ['code' => $level4])->row('sts_matgis'),
                    ];

                    $insert = $this->db->insert('resources_code', $arr_data);

                    $log = [
                        'code' => $code,
                        'activity' => 'Insert kode level 5 (kode perkiraan = ' . $code . '-' . $name . ')',
                        'created_by' => $this->data['users']->id
                    ];
                    $this->db->insert('resources_code_logs', $log);

                    $this->session->set_flashdata('message', "Kode sumber daya Berhasil disimpan");
                    redirect("resources_code5");
                }
            }
        } else {
            redirect('restrict');
        }
    }

    public function edit()
    {
        if ($this->data['is_can_edit']) {
            $id = $this->input->post('id', TRUE);
            $data = $this->db->get_where('resources_code', ['resources_code_id' => $id])->row_array();

            echo json_encode($data);
        } else {
            redirect('restrict');
        }
    }

    public function update()
    {
        if ($this->data['is_can_edit']) {
            if (!empty($_POST)) {
                // $level4 = $this->input->post('level4', true);
                // $inc = $this->Resources_code_model->increment($level4, 5);
                // $code = substr($level4, 0, 4) . $inc['data'];
                $name = strtoupper($this->input->post('name', true));
                $description = $this->input->post('desc', true);
                $id = $this->input->post('id', true);
                $code_log = $this->input->post('code_log', true);

                // if ($inc['data'] == 'err') {
                //     $this->session->set_flashdata('message_error',$inc['msg']);
                //     redirect("resources_code5");
                // } else {
                //     $old = $this->db->get_where('resources_code', ['resources_code_id' => $id])->row('parent_code');
                //     $arr_data = [];
                //     if ($old != $level4) {
                //         $arr_data = [
                //             'code' => $code,
                //             'parent_code' => $level4,
                //             'name' => $name,
                //             'description' => $description,
                //             'status' => 0,
                //         ];
                //     } else {
                $arr_data = [
                    'name' => $name,
                    'description' => $description,
                    'status' => 0,
                ];
                // }

                $this->db->where('resources_code_id', $id);
                $insert = $this->db->update('resources_code', $arr_data);

                $log = [
                    'code' => $code_log,
                    'activity' => 'Update kode level 5 (kode perkiraan = ' . $code_log . '-' . $name . ')',
                    'created_by' => $this->data['users']->id
                ];
                $this->db->insert('resources_code_logs', $log);

                $this->session->set_flashdata('message', "Kode sumber daya Berhasil disimpan");
                redirect("resources_code5");
                // }
            }
        } else {
            redirect('restrict');
        }
    }

    public function status_ids()
    {
        $act = $this->input->post('ids', true);
        if ($act == 11) {
            $this->delete_data($this->input->post('idsData', true));
        } elseif ($act == 22) {
            $this->approve_data($this->input->post('idsData', true), 2);
        } else {
            $this->approve_data($this->input->post('idsData', true), 1);
        }
    }

    private function delete_data($ids)
    {
        if ($this->data['is_can_delete']) {
            $sukses = 0;
            $gagal = 0;

            foreach ($ids as $key => $value) {
                $data = $this->db->get_where('resources_code', ['resources_code_id' => $value])->row_array();

                if ($data['code'] == '') {
                    $parent = $this->db->get_where('resources_code', ['resources_code_id' => $value])->row('parent_code');
                    $inc = $this->Resources_code_model->increment($parent, 5);
                    $code = substr($parent, 0, 4) . $inc['data'] . '0';

                    $this->db->where('resources_code_id', $value);
                    $hasil = $this->db->delete('resources_code');

                    $log = [
                        'code' => $code,
                        'activity' => 'Delete kode level 5 (kode perkiraan = ' . $code . '-' . $data['name'] . ')',
                        'created_by' => $this->data['users']->id
                    ];
                    $this->db->insert('resources_code_logs', $log);
                } else {
                    $child = $this->db->get_where('resources_code', ['parent_code' => $data['code']])->num_rows();

                    if ($child > 0) {
                        $this->session->set_flashdata('message_error', "Tidak dapat dihapus karena masih memiliki data Child");
                        redirect("resources_code5");
                        exit;
                    } else {
                        $log = [
                            'code' => $data['code'],
                            'activity' => 'Delete kode level 5 (' . $data['code'] . '-' . $data['name'] . ')',
                            'created_by' => $this->data['users']->id
                        ];
                        $this->db->insert('resources_code_logs', $log);

                        $this->db->where('resources_code_id', $value);
                        $hasil = $this->db->delete('resources_code');
                    }
                }
                // $log = [
                //     'code' => $data['code'],
                //     'activity' => 'Delete kode level 5 (' . $data['code'] . '-' . $data['name'] . ')',
                //     'created_by' => $this->data['users']->id
                // ];
                // $this->db->insert('resources_code_logs', $log);

                // $this->db->where('resources_code_id', $value);
                // $hasil = $this->db->delete('resources_code');
                // if ($hasil) {
                //     $sukses++;
                // } else {
                //     $gagal++;
                // }
            }

            if ($hasil) {
                $sukses++;
            } else {
                $gagal++;
            }

            $this->session->set_flashdata('message', $sukses . " Kode sumber daya Berhasil dihapus. " . $gagal . " Kode sumber daya Gagal dihapus.");
            redirect("resources_code5");
        } else {
            redirect('restrict');
        }
    }

    private function approve_data($ids, $sts)
    {
        if ($this->data['is_can_approval']) {
            $sukses = 0;
            $gagal = 0;

            $log_desc = $sts < 2 ? 'Approve' : 'Reject';

            foreach ($ids as $key => $value) {

                $d = $this->db->get_where('resources_code', ['resources_code_id' => $value])->row_array();
                if ($d['status'] != $sts) {
                    $inc = $this->Resources_code_model->increment($d['parent_code'], 5);
                    $code = substr($d['parent_code'], 0, 4) . $inc['data'] . '0';

                    $data_appr = [];
                    if ($sts < 2) {
                        $data_appr['code'] = $code;
                        $data_appr['status'] = $sts;
                        $log_d = '';
                    } else {
                        $data_appr['code'] = null;
                        $data_appr['status'] = $sts;
                        $log_d = 'kode perkiraan = ';
                    }

                    $this->db->where('resources_code_id', $value);
                    $hasil = $this->db->update('resources_code', $data_appr);

                    $data = $this->db->get_where('resources_code', ['resources_code_id' => $value])->row_array();
                    $log = [
                        'code' => $code,
                        'activity' => $log_desc . ' kode level 5 (' . $log_d . $code . '-' . $data['name'] . ')',
                        'created_by' => $this->data['users']->id
                    ];
                    $this->db->insert('resources_code_logs', $log);
                }
                if ($hasil) {
                    $sukses++;
                } else {
                    $gagal++;
                }
            }

            $msg = $sts < 2 ? 'di-approve' : 'di-reject';

            // foreach ($ids as $key => $value) {
            //     $data = $this->db->get_where('resources_code', ['resources_code_id' => $value])->row_array();
            //     $log = [
            //         'code' => $data['code'],
            //         'activity' => $log_desc . ' kode level 5 (' . $data['code'] . '-' . $data['name'] . ')',
            //         'created_by' => $this->data['users']->id
            //     ];
            //     $this->db->insert('resources_code_logs', $log);

            //     $this->db->where('resources_code_id', $value);
            //     $hasil = $this->db->update('resources_code', ['status' => $sts]);
            //     if ($hasil) {
            //         $sukses++;
            //     } else {
            //         $gagal++;
            //     }
            // }

            // $msg = $sts < 2 ? 'di-approve' : 'di-reject';

            $this->session->set_flashdata('message', $sukses . " Kode sumber daya Berhasil " . $msg . ". " . $gagal . " Kode sumber daya Gagal " . $msg . ".");
            redirect("resources_code5");
        } else {
            redirect('restrict');
        }
    }
}
