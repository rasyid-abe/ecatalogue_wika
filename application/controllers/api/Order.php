<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/Base_Api_Controller.php';
class Order extends Base_Api_Controller
{
	public function __construct()
	{
        parent::__construct();
        $this->load->model('auth_model');
	}

	public function inject_wo_post()
	{
		$token = $this->cektoken();
		$json = file_get_contents("php://input");
		$data = json_decode($json);
        $dl['order_no'] = $data->order_no;
        $dl['total_price'] = $data->total_price;
        $dl['order_status'] = $data->order_status;
        $dl['payment_method_id'] = $data->payment_method_id;
        $dl['shipping_id'] = $data->shipping_id;
        $dl['perihal'] = $data->perihal;
        $dl['created_by'] = $data->created_by;
        $dl['updated_by'] = $data->updated_by;
        $dl['project_id'] = $data->project_id;
        $dl['catatan'] = $data->catatan;
        $dl['tgl_diambil'] = $data->tgl_diambil;
        $dl['no_surat'] = $data->no_surat;
        $dl['dp'] = $data->dp;
        $dl['location_id'] = $data->location_id;
        $dl['location_name'] = $data->location_name;
        $dl['vendor_id'] = $data->vendor_id;
        $dl['vendor_name'] = $data->vendor_name;
        $dl['pdf_name'] = $data->pdf_name;
        $dl['kontrak_id'] = $data->kontrak_id;
        //$dl['biaya_transport'] = $data->biaya_transport;
        //$dl['transportasi_id'] = $data->transportasi_id;
        //$dl['nilai_asuransi'] = $data->nilai_asuransi;
        //$dl['asuransi_id'] = $data->asuransi_id;
        //$dl['jenis_asuransi'] = $data->jenis_asuransi;
        $dl['order_gabungan_id'] = $data->order_gabungan_id;
        $res = $this->auth_model->insertData("order_api", $dl);

        $vendor_asuransi=$data->vendor_id_asuransi;
        if(!empty($vendor_asuransi))
        {
            $aa['order_no'] = $data->order_no;
            $aa['perihal'] = $data->perihal;
            $aa['catatan'] = $data->catatan;
            $aa['nilai_asuransi'] = $data->nilai_asuransi;
            $aa['asuransi_id'] = $data->asuransi_id;
            $aa['jenis_asuransi'] = $data->jenis_asuransi;
            $aa['vendor_id'] = $data->vendor_id_asuransi;
            $aa['project_id'] = $data->project_id;
            $aa['created_by'] = $data->created_by;
            $aa['updated_by'] = $data->updated_by;
            $aa['order_gabungan_id'] = $data->order_gabungan_id;
            $aa['nilai_harga_minimum'] = $data->nilai_harga_minimum;
            //$aa['pdf_name'] = $data->pdf_name;
            $res2 = $this->auth_model->insertData("order_asuransi_api", $aa);
        }

        $vendor_transportasi=$data->vendor_id_transportasi;
        if(!empty($vendor_transportasi))
        {
            $ta['order_no'] = $data->order_no;
            $ta['perihal'] = $data->perihal;
            $ta['catatan'] = $data->catatan;
            $ta['biaya_transport'] = $data->biaya_transport;
            $ta['transportasi_id'] = $data->transportasi_id;
            $ta['vendor_id'] = $data->vendor_id_transportasi;
            $ta['location_origin_id'] = $data->location_origin_id;
            $ta['location_destination_id'] = $data->location_destination_id;
            $ta['project_id'] = $data->project_id;
            $ta['category_id'] = $data->category_id;
            $ta['created_by'] = $data->created_by;
            $ta['updated_by'] = $data->updated_by;
            $ta['order_gabungan_id'] = $data->order_gabungan_id;
            $ta['data_traller'] = $data->data_traller;
            $ta['pdf_name'] = $data->pdf_name_transportasi;
            $ta['weight_minimum'] = $data->weight_minimum;
            $res3 = $this->auth_model->insertData("order_transportasi_api", $ta);
        }
        $product = $data->product;
        if (!empty($product)) {
			foreach ($product as $key => $pro) {
				$p['order_no'] = $data->order_no;
				$p['product_id'] = $pro->product_id;
				$p['qty'] = $pro->qty;
				$p['product_uom_id'] = $pro->product_uom_id;
				$p['order_product_status'] = $pro->order_product_status;
				$p['created_by'] = $data->created_by;
				$p['updated_by'] = $data->updated_by;
				$p['payment_method_id'] = $pro->payment_method_id;
				$p['price'] = $pro->price;
				$p['include_price'] = $pro->include_price;
				$p['weight'] = $pro->weight;
				$p['full_name_product'] = $pro->full_name_product;
				$p['payment_mehod_name'] = $pro->payment_mehod_name;
				$p['uom_name'] = $pro->uom_name;
				$p['vendor_id'] = $pro->vendor_id;
				$p['vendor_name'] = $pro->vendor_name;
				$p['json_include_price'] = $pro->json_include_price;
				$p['nilai_asuransi'] = $pro->nilai_asuransi;
				$p['asuransi_id'] = $pro->asuransi_id;
				$p['biaya_transport'] = $pro->biaya_transport;
				$p['transportasi_id'] = $pro->transportasi_id;
                $this->auth_model->insertData("order_product_api", $p);

                $ada['order_no'] = $data->order_no;
				$ada['product_id'] = $pro->product_id;
				$ada['qty'] = $pro->qty;
				$ada['price'] = $pro->price;
				$ada['weight'] = $pro->weight;
                $ada['full_name_product'] = $pro->full_name_product;
                if(!empty($vendor_asuransi))
                {
                    $this->auth_model->insertData("order_asuransi_d_api", $ada);
                }
                if(!empty($vendor_transportasi))
                {
              	    $this->auth_model->insertData("order_transportasi_d_api", $ada);
                }
            }
		}
		if ($res) {
			$this->response([
				'status' => true,
				'message' => 'insert succes'
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No transportation were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
    }


}
