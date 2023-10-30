<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/Base_Api_Controller.php';
class Product extends Base_Api_Controller
{
	public function __construct()
	{
		parent::__construct();
        $this->load->model('api/product_model', 'product');
        
	}

	public function index_get()
	{
		$token = $this->cektoken();
		$columns = array(
            'id' => 'product.id',
            'vendor' => 'vendor.name',
            'product' => 'product.name',
            'code' => 'product.code_1',
            'spesification' => 'specification.name',
            'size' => 'size.name',
            'caterogiy' => 'category.name',
            'location_name' => 'location.name',
            'uom_name' => 'uoms.name',
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

		$data = $this->product->getProductByPaymentMethod($params);
		if ($data) {
			$this->response([
				'status' => true,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No products were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
    }

    public function list_product_get()
	{
        $token = $this->cektoken();
		$columns = array(
            'product' => 'a.name',
            'category' => 'b.name',
            'specification' => 'c.name',
            'size' => 'd.name',
            'code' => 'a.code_1'
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

		$data = $this->product->get_product_with_code($params);
		if ($data) {
			$this->response([
				'status' => true,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No products were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}


}
