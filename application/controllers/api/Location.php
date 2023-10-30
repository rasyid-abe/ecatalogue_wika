<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/Base_Api_Controller.php';
class Location extends Base_Api_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('api/location_model', 'location');
	}

	public function index_get()
	{
		$token = $this->cektoken();
		$columns = array(
            'id' => 'location.id',
            'name' => 'location.name',
        );

		$where = $this->get();
		$params = [];
		foreach ($where as $key => $value) {
			foreach ($columns as $col => $column) {
				if ($key == $col) {
					$params[$column] = $value;
				}
			}
		}

		$data = $this->location->getAllById($params);
		if ($data) {
			$this->response([
				'status' => true,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No location were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

}
