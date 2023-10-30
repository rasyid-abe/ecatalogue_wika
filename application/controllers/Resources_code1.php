<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Resources_code1 extends Admin_Controller {
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
            $this->data['title'] = 'Kategori';
            $this->data['content']  = 'admin/resources_code/list_code1';
            $this->data['data'] = $this->db->get_where('resources_code', ['level' => 1])->result_array();
        } else {
            redirect('restrict');
        }
        $this->load->view('admin/layouts/page',$this->data);
    }

    public function create()
    {
        if ($this->data['is_can_create']) {
            if (!empty($_POST)) {
                $code = strtoupper($this->input->post('code', true)) . '00000';
                $name = strtoupper($this->input->post('name', true));

                $exist_code = $this->db->get_where('resources_code', ['code' => $code])->num_rows();
                if ($exist_code > 0) {
                    $this->session->set_flashdata('message_error',"Kode sumber daya sudah ada.");
                    redirect("resources_code1");
                } else {
                    $arr_data = [
                        'code' => $code,
                        'name' => $name,
                        'level' => 1,
                    ];
                    $insert = $this->db->insert('resources_code', $arr_data);

                    $log = [
                        'code' => $code,
                        'activity' => 'Insert kode level 1 ('.$code.'-'.$name.')',
                        'created_by' => $this->data['users']->id
                    ];
                    $this->db->insert('resources_code_logs', $log);

                    $this->session->set_flashdata('message',"Kode sumber daya Berhasil disimpan");
                    redirect("resources_code1");
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
                $code = strtoupper($this->input->post('code', true)) . '00000';
                $name = $this->input->post('name', true);
                $id = $this->input->post('id', true);

                $old = $this->db->get_where('resources_code', ['resources_code_id' => $id])->row('code');
                if ($old != $code) {
                    $exist_code = $this->db->get_where('resources_code', ['code' => $code])->num_rows();
                    if ($exist_code > 0) {
                        $this->session->set_flashdata('message_error',"Kode sumber daya sudah ada.");
                        redirect("resources_code1");
                    } else {
                        $this->act_update($_POST);
                    }
                } else {
                    $this->act_update($_POST);
                }
            }
        } else {
            redirect('restrict');
        }
    }

    private function act_update($data){
        if ($this->data['is_can_edit']) {
            $code = strtoupper($this->input->post('code', true)) . '00000';
            $name = strtoupper($this->input->post('name', true));
            $id = $this->input->post('id', true);

            $arr_data = [
                'code' => $code,
                'name' => $name,
                'status' => 0,
            ];

            $this->db->where('resources_code_id', $id);
            $insert = $this->db->update('resources_code', $arr_data);

            $log = [
                'code' => $code,
                'activity' => 'Update kode level 1 ('.$code.'-'.$name.')',
                'created_by' => $this->data['users']->id
            ];
            $this->db->insert('resources_code_logs', $log);

            $this->session->set_flashdata('message',"Kode sumber daya Berhasil disimpan");
            redirect("resources_code1");
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

                $child = $this->db->get_where('resources_code', ['parent_code' => $data['code']])->num_rows();
                if ($child > 0) {
                    $this->session->set_flashdata('message_error', "Tidak dapat dihapus karena masih memiliki data Child");
                    redirect("resources_code1");
                    exit;
                } else {
                    $log = [
                        'code' => $data['code'],
                        'activity' => 'Delete kode level 1 ('.$data['code'].'-'.$data['name'].')',
                        'created_by' => $this->data['users']->id
                    ];
                    $this->db->insert('resources_code_logs', $log);

                    $this->db->where('resources_code_id', $value);
                    $hasil = $this->db->delete('resources_code');
                    if ($hasil) {
                        $sukses++;
                    } else {
                        $gagal++;
                    }
                }
            }

            $this->session->set_flashdata('message', $sukses . " Kode sumber daya Berhasil dihapus. " . $gagal . " Kode sumber daya Gagal dihapus.");
            redirect("resources_code1");
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
                $data = $this->db->get_where('resources_code', ['resources_code_id' => $value])->row_array();
                if ($data['status'] != $sts) {
                    $log = [
                        'code' => $data['code'],
                        'activity' => $log_desc.' kode level 1 ('.$data['code'].'-'.$data['name'].')',
                        'created_by' => $this->data['users']->id
                    ];
                    $this->db->insert('resources_code_logs', $log);

                    $this->db->where('resources_code_id', $value);
                    $hasil = $this->db->update('resources_code', ['status' => $sts]);
                }
                if ($hasil) {
                    $sukses++;
                } else {
                    $gagal++;
                }
            }

            $msg = $sts < 2 ? 'di-approve' : 'di-reject';

            $this->session->set_flashdata('message', $sukses . " Kode sumber daya Berhasil ".$msg.". " . $gagal . " Kode sumber daya Gagal ".$msg.".");
            redirect("resources_code1");
        } else {
            redirect('restrict');
        }
    }
}
