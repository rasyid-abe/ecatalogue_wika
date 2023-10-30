<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Forecast_3_bulan extends Admin_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('forecast_model');
        $this->load->model('forecast_detail_model');
    }

    public function index()
    {
        $this->load->helper('url');
        if($this->data['is_can_read']){
            $this->data['content']  = 'admin/forecast_3_bulan/list_v';
        }else{
            redirect('restrict');
        }
        $this->load->view('admin/layouts/page',$this->data);
    }

    public function create()
    {
        $this->load->helper('url');
        if($this->data['is_can_read']){
            $this->data['content']  = 'admin/forecast_3_bulan/create_v';
        }else{
            redirect('restrict');
        }
        $this->load->view('admin/layouts/page',$this->data);
    }
    

}
