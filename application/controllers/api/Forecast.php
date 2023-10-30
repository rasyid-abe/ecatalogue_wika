<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/Base_Api_Controller.php';
class Forecast extends Base_Api_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('api/product_model', 'product');
	}

	public function data_get()
	{
		$days = $this->uri->segment(4);
        $segment = $days > 0 ? $days : '';

        $api_uri = 'http://127.0.0.1:5000/data_besi/' . $segment;
		$besi = $this->api_data($api_uri);
		$this->response([
			'status' => true,
			'data' => $besi,
		], REST_Controller::HTTP_OK);
	}

	public function api_data($uri)
    {
        include('httpful.phar');
        $response = Httpful\Request::get($uri)
            ->sendsJson()
            ->addHeader('Accept', 'application/json')
            ->send();

        $data = $response->body;
        return $data;
	}
	

}
