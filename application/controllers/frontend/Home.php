<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/Front_Controller.php';
class Home extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->helper('url');
        if ($this->data['is_can_read']) {
            $this->data['content']  = 'frontend/home';
        } else {
            redirect('restrict');
        }
        $this->load->view('frontend/layouts/page', $this->data);
    }
}
