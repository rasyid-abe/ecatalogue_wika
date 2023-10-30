<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Restrict extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct(); 
    } 
    public function index()
    {
        $this->load->helper('url');
        $this->data['is_login_page'] = false;
        // $this->data['content'] = 'errors/html/error_404'; 
        // $this->load->view('admin/layouts/page',$this->data); 
        $this->load->view('errors/html/restrict');
    }
}
