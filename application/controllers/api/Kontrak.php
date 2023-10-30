<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/Base_Api_Controller.php';
class Kontrak extends Base_Api_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('api/kontrak_model', 'kontrak');
	}

	public function vendor_get()
	{
		$token = $this->cektoken();
		$columns = array(
            'id' => 'project.id',
            'vendor' => 'vendor.name',
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

		$data = $this->kontrak->findAllDataKontrak($params);
		if ($data) {
			$this->response([
				'status' => true,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No contract were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}
	
	public function transportasi_get()
	{
		$token = $this->cektoken();
		$columns = array(
            'id' => 'kontrak_transportasi.id',
            'vendor' => 'vendor.name',
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

		$data = $this->kontrak->findAllDataTransportasi($params);
		if ($data) {
			$this->response([
				'status' => true,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No contract were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	
	public function asuransi_get()
	{
		$token = $this->cektoken();
		$columns = array(
            'id' => 'kontrak_transportasi.id',
            'vendor' => 'vendor.name',
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

		$data = $this->kontrak->findAllDataAsuransi($params);
		if ($data) {
			$this->response([
				'status' => true,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No contract were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

}
