<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/Base_Api_Controller.php';
class Uoms extends Base_Api_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('api/uoms_model', 'uoms');
	}

	public function index_get()
	{
		$token = $this->cektoken();
		$columns = array(
            'id' => 'uoms.id',
            'name' => 'uoms.name',
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

		$data = $this->uoms->getAllById($params);
		if ($data) {
			$this->response([
				'status' => true,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No uoms were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

}
