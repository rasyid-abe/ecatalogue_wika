<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/Base_Api_Controller.php';
class Transportasi extends Base_Api_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('api/transportasi_model', 'transportasi');
	}

	public function index_get()
	{
		$token = $this->cektoken();
		$columns = array(
            'id' => 'transportasi.id',
            'vendor' => 'vendor.name',
            'origin' => 'location.name',
            'destination' => 'location2.name',
            'weight_minimum' => 'kontrak_transportasi.weight_minimum',
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

		$data = $this->transportasi->getMainQuery($params);
		if ($data) {
			$this->response([
				'status' => true,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No transportation were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

}
