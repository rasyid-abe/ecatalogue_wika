<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Feedback extends Admin_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('order_model');
        $this->load->model('vendor_model');
        // $this->load->library('encrypt');

    }

    public function index()
    {
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }else{
            $this->data['content']  = 'frontend/finish/main';
            $this->load->view('frontend/layouts/page',$this->data);
        }
    }

    public function newfeedback($array_vendor_id, $isEmailSend = NULL){
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }else{
            if(!empty($_POST)){
                $isi_feedback = $this->input->post('isi_feedback');
                $vendor_id = $this->input->post('vendor_id');
                $data_insert = array();
                for($i=0;$i<count($this->input->post('vendor_id')); $i++){
                    if($isi_feedback[$i]){
                        $data_insert[] = array(
                            "isi_feedback" =>$isi_feedback[$i],
                            "vendor_id" =>$vendor_id[$i],
                            "kategori_feedback_id" =>100,
                            "type_feedback" =>"user",
                            "created_by" =>$this->data['users']->id,
                        );
                    }

                }

                if($data_insert){
                    $this->db->insert_batch('list_feedback',$data_insert);
                }
                $this->session->set_flashdata('message', "Feedback Vendor Sudah Diisi");
                redirect('home');
            }else{
                $a = explode("-", $array_vendor_id);
                $this->data['vendor_po'] = $this->vendor_model->getVendorFromArray($a);
                $this->data['email_not_sent'] = $isEmailSend == 'email_not_sent' ? TRUE : FALSE;
                $this->data['content']  = 'frontend/feedback_po/main';
                $this->load->view('frontend/layouts/page',$this->data);
            }

        }
    }


}
