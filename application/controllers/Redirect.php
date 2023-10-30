<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Redirect extends Admin_Controller {
 	public function __construct()
	{
		parent::__construct();
		$this->load->model("menu_model");

	}
	public function index()
	{
		// echo "Please Wait, Redirecting To Menu";
		if($this->data['is_superadmin']){
			$menus = $this->menu_model->getMenuSuperadmin();
		}else{
			$menus = $this->menu_model->getMenuPrivilleges(array("role_id"=>$this->data['users_groups']->id));
		}

		$this->data['array_module'] = array();
		if($this->data['users_groups']->id == 3 || $this->data['users_groups']->id == 1 ){
            redirect('redirect/dashboard_target');
		}else{
            redirect('home');
		}
		// if($menus){
		// 	$url = "";
		// 	$find_dashboard =0;
		// 	foreach ($menus as $key => $value) {
		// 		if(!in_array($value->module_id, $this->data['array_module'] )){
		// 			array_push($this->data['array_module'] ,$value->module_id);
		// 		}
		// 		if( strtolower($value->url) == "dashboard"){
		// 			$find_dashboard = 1;
		// 			$url = $value->url;
		// 		}

		// 		if($value->url !="#" && $find_dashboard == 0){
		// 			$url = $value->url;
		// 		}
		// 	}
		// 	if($url =="#" || $url=="" || $url==" "){
		// 		$this->data['content'] = 'errors/html/error_404';
		// 		$this->load->view('admin/layouts/page',$this->data);
		// 	}else{
		// 		if(in_array(2, $this->data['array_module'])){
		// 			redirect('home');
		// 		}
		// 		redirect($url);
		// 	}
		// }else{
		// 	$this->load->view('errors/html/error_404');
		// 	// $this->load->view('admin/layouts/page',$this->data);
		// }
	}

    public function dashboard_target()
    {
        if($this->data['is_superadmin']){
			$menus = $this->menu_model->getMenuSuperadmin();
		}else{
			$menus = $this->menu_model->getMenuPrivilleges(array("role_id"=>$this->data['users_groups']->id));
		}

        // die(var_dump($menus));

		if($menus){
			$url = "";
			$find_dashboard =0;
			foreach ($menus as $key => $value) {
                if( strtolower($value->url) == "dashboard"){
					$find_dashboard = 1;
					$url = $value->url;
				}

                if( strtolower($value->url) == "dashboard_vendor"){
					$find_dashboard = 1;
					$url = $value->url;
				}

                if( strtolower($value->url) == "dashboard_user"){
					$find_dashboard = 1;
					$url = $value->url;
				}

                if ($find_dashboard == 1)
                {
                    break;
                }

				if($value->url !="#" && $find_dashboard == 0){
					$url = $value->url;
				}
			}
			if($url =="#" || $url=="" || $url==" "){
				 $this->load->view('errors/html/error_404');
			}else{
				redirect($url);
			}
		}else{
			 $this->load->view('errors/html/error_404');
		}
    }

    public function check_pakta_integritas()
    {
        $this->session->set_userdata('is_check_pakta', TRUE);
        $ret['status'] = TRUE;
        //$ret['status'] = $this->db->insert('log_pakta_integritas',['user_id' => $this->data['users']->id]);
        echo json_encode($ret);
    }



}
