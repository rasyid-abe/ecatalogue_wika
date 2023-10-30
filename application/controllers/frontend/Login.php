<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Front_Controller.php';
class Login extends Front_Controller {
    public function __construct()
    {
        parent::__construct(); 
    }

    public function index()
    {
        $this->load->helper('url');
        if($this->data['is_can_read']){
            $this->data['is_login_page'] = true;
            $this->data['content']  = 'frontend/login';  
        }else{
            redirect('restrict'); 
        }
        $this->load->view('frontend/layouts/page',$this->data);  
    }

}
