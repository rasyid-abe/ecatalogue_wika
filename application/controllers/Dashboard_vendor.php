<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Dashboard_vendor extends Admin_Controller {
 	public function __construct()
	{
		parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('Order_model');
        $this->load->model('Project_model');
        $this->load->model('Notification_model');
        $this->load->model('Aktifitas_user_model');
        $this->load->model('List_feedback_model');
	}
	public function index()
	{

        if($this->data['is_can_read']){
            $query = $this->Order_model->get_total_dana_order(['vendor_id' => $this->data['users']->vendor_id]);

            $feedback = $this->List_feedback_model->getAllById(['vendor_id' => $this->data['users']->vendor_id]);

            $this->data['feedback_vendor'] = $feedback === FALSE ? 0 : count($feedback);
            $this->data['activity_vendor'] = $this->Aktifitas_user_model->get_last_activity(['user_id' => $this->data['users']->id]);
            $this->data['notif_vendor'] = $this->Notification_model->get_last_notif(['id_penerima' => $this->data['users']->id]);
            $this->data['dana'] = $query->totalnya;
            $this->data['jml_order'] = $query->banyaknya;
            $this->data['content'] = 'admin/dashboard_vendor';
		}else{
			redirect('restrict');
		}

		$this->load->view('admin/layouts/page',$this->data);
	}    

}
