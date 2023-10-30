<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/Base_Api_Controller.php';
class Auth extends Base_Api_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('auth_model');
		$this->load->model('asuransi_model');
	}

	public function inject_wo_post()
	{
		$json = file_get_contents("php://input");
		$data = json_decode($json);
		///////ctr_wo_header
		$dl['wo_number'] = $this->auth_model->MaxWoNo();
		$dl['creator_employee'] = $data->creator_employee;
		$dl['creator_pos'] = $data->creator_pos;
		$dl['contract_id'] = $data->contract_id;
		$dl['vendor_id'] = $data->vendor_id;
		$dl['vendor_name'] = $data->vendor_name;
		$dl['created_date'] = $data->created_date;
		$dl['currency'] = 'RP';
		$dl['status'] = '2033';
		$dl['start_date'] = $data->start_contract;
		$dl['end_date'] = $data->end_contract;
		$dl['ctr_doc'] = $data->file_contract;
		$dl['ctr_amount'] = $data->nilai_kontrak;
		$dl['approved_date'] = $data->approved_date;
		$dl['current_approver_pos'] = $data->current_approver_pos;
		$dl['current_approver_level'] = '2';
		$dl['current_approver_id'] = $data->current_approver_id;
		$dl['dept_code'] = $data->departemen_code;
		$dl['dept_id'] = $data->departemen_id;
		//$dl['si_total'] = $data->si_total;
		//$dl['sj_total'] = $data->sj_total;
		//$dl['invoice_total'] = $data->invoice_total;
		$dl['sppm_total'] = $data->sppm_total;
		$dl['spk_number'] = $data->no_spk;
		$dl['spk_name'] = $data->project_name;
		$res = $this->auth_model->insertData("ctr_wo_header", $dl);
		/////ctr_wo_item
		$product = $data->product;
		if (!empty($product)) {
			foreach ($product as $key => $pro) {
				$p['wo_id'] = $res;
				$p['contract_item_id'] = $pro->vendor_id;
				$p['item_code'] = $pro->code_1;
				$p['short_description'] = $pro->full_name_product;
				$p['long_description'] = $pro->full_name_product;
				$p['price'] = $pro->price;
				$p['qty'] = $pro->qty;
				$p['uom'] = $pro->uom_name;
				$p['sub_total'] = $pro->price*$pro->qty*$pro->weight;
				$p['ppn'] = 0;
				$p['pph'] = 0;
				$this->auth_model->insertData("ctr_wo_item", $p);	
			}
		}

		///////ctr_sppm_header
		$sp['sppm_number'] = $data->no_surat;
		$sp['creator_employee'] = $data->creator_employee;
		$sp['creator_pos'] = $data->creator_pos;
		$sp['contract_id'] = $data->contract_id;
		$sp['vendor_id'] = $data->vendor_id;
		$sp['sppm_date'] = date("Y-m-d h:i:sa");
		$sp['created_date'] = date("Y-m-d h:i:sa");
		$sp['tgl_expected_delivery'] = $data->tgl_diambil;
		$sp['sppm_total'] = $data->sppm_total;
		$sp['sppm_notes'] = $data->catatan;
		$sp['current_approver_pos'] = $data->current_approver_pos;
		$sp['current_approver_level'] = '2';
		$sp['current_approver_id'] = $data->current_approver_id;
		$sp['approved_date'] = $data->approved_date;
		
		$res2 = $this->auth_model->insertData("ctr_sppm_header", $sp);
		/////ctr_sppm_item
		if (!empty($product)) {
			foreach ($product as $key => $pro) {
				$spi['sppm_id'] = $res2;
				$spi['contract_item_id'] = $pro->vendor_id;
				$spi['item_code'] = $pro->code_1;
				$spi['short_description'] = $pro->full_name_product;
				$spi['long_description'] = $pro->full_name_product;
				$spi['price'] = $pro->price;
				$spi['qty'] = $pro->qty;
				$spi['uom'] = $pro->uom_name;
				$spi['sub_total'] = $pro->price*$pro->qty*$pro->weight;
				$spi['ppn'] = 0;
				$spi['pph'] = 0;
				$this->auth_model->insertData("ctr_sppm_item", $spi);	
			}
		}
	
		
	}
	public function test2_get()
	{
		$sp['vendor_name'] = $_GET('vendor');
		
		$res2 = $this->asuransi_model->findAllDataAsuransi($sp);
		//echo json_encode($res2);
		$this->set_response($res2, REST_Controller::HTTP_OK);
	}
	
	public function users_get()
    {
        // Users from a data store e.g. database
        $users = [
            ['id' => 1, 'name' => 'John', 'email' => 'john@example.com', 'fact' => 'Loves coding'],
            ['id' => 2, 'name' => 'Jim', 'email' => 'jim@example.com', 'fact' => 'Developed on CodeIgniter'],
            ['id' => 3, 'name' => 'Jane', 'email' => 'jane@example.com', 'fact' => 'Lives in the USA', ['hobbies' => ['guitar', 'cycling']]],
        ];

        $id = $this->get('id');

        // If the id parameter doesn't exist return all the users

        if ($id === NULL)
        {
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($users)
            {
                // Set the response and exit
                $this->response($users, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No users were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }

        // Find and return a single record for a particular user.
        else {
            $id = (int) $id;

            // Validate the id.
            if ($id <= 0)
            {
                // Invalid id, set the response and exit.
                $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            // Get the user from the array, using the id as key for retrieval.
            // Usually a model is to be used for this.

            $user = NULL;

            if (!empty($users))
            {
                foreach ($users as $key => $value)
                {
                    if (isset($value['id']) && $value['id'] === $id)
                    {
                        $user = $value;
                    }
                }
            }

            if (!empty($user))
            {
                $this->set_response($user, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'User could not be found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

}
