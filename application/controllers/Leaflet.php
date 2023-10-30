<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Leaflet extends Admin_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->load->helper('url');
        if($this->data['is_can_read']){
            $this->data['title'] = 'MAPS';
            $this->data['content']  = 'admin/leaflet/view';
        
        }else{
            redirect('restrict');
        }
        $this->load->view('admin/layouts/page',$this->data);
    }


}
