<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Riwayat extends Admin_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_price_history_model');
    }

    public function index()
    {
        $this->load->helper('url');
        if($this->data['is_can_read']){
            $this->data['content']  = 'admin/riwayat/list_v';
        }else{
            redirect('restrict');
        }
        $this->load->view('admin/layouts/page',$this->data);
    }

    public function dataList()
    {
        $columns = array(
            0 =>'product_price_history.id',
            1 =>'product.name',
            2=> 'vendor.name',
            3=> 'product_price_history.old_price',
            4=> 'product_price_history.new_price',
            5=> 'product_price_history.created_at',
        );


        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $where = array();
        if(!$this->data['is_superadmin']){$where['product.vendor_id'] = $this->data['users']->vendor_id;}
        $limit = 0;
        $start = 0;
        $totalData = $this->product_price_history_model->getCountAllBy($limit,$start,$search,$order,$dir,$where);
        // print_r($totalData);

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;

        if(!empty($searchColumn[1]['search']['value'])){
        	$value = $searchColumn[1]['search']['value'];
        	$isSearchColumn = true;
         	$search['vendor.name'] = $value;
        }

      	if(!empty($searchColumn[2]['search']['value'])){
        	$value = $searchColumn[2]['search']['value'];
        	$isSearchColumn = true;
         	$search['specification.name'] = $value;
		}

		if(!empty($searchColumn[3]['search']['value'])){
			$search_value = $searchColumn[3]['search']['value'];
			$isSearchColumn = true;
			$where["product_price_history.created_at >="] = $search_value;
		}
        if(!empty($searchColumn[4]['search']['value'])){
			$search_value = $searchColumn[4]['search']['value'];
			$isSearchColumn = true;
			$where["product_price_history.created_at <="] = $search_value;
		}

        if(!empty($this->input->post('search')['value']))
        {
            $search_value = $this->input->post('search')['value'];
            $isSearchColumn = true;
            $search = array(
                "product.name"=>$search_value,
            );
        }

        if($isSearchColumn){
			$totalFiltered = $this->product_price_history_model->getCountAllBy($limit,$start,$search,$order,$dir,$where);
        }else{
        	$totalFiltered = $totalData;
        }
       // print_r($totalFiltered);
        $limit = $this->input->post('length');
        $start = $this->input->post('start');

        $datas = $this->product_price_history_model->getAllBy($limit,$start,$search,$order,$dir,$where);
        //echo $this->db->last_query();
        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {

                $nestedData['id']             = $start+$key+1;;
                $nestedData['fullname']       = $data->fullname;
                $nestedData['name_vendor']    = $data->name_vendor;
                $nestedData['old_price']      = "Rp. ".number_format($data->old_price,'0',',','.');
                $nestedData['new_price']      = "Rp. ".number_format($data->new_price,'0',',','.');
                $nestedData['tgl']            = $data->tgl;
                $new_data[] = $nestedData;
            }
        }

        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),
                    "recordsTotal"    => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data"            => $new_data
                    );

        echo json_encode($json_data);
    }

    public function export_to_excel()
    {
        $search = [];
        $where = [];

        if(!$this->data['is_superadmin']){$where['product.vendor_id'] = $this->data['users']->vendor_id;}

        if($this->input->get('start_date') && $this->input->get('start_date') != '')
        {
            $where["product_price_history.created_at >="] = $this->input->get('start_date');
        }

        if($this->input->get('end_date') && $this->input->get('end_date') != '')
        {
            $where["product_price_history.created_at >="] = $this->input->get('end_date');
        }

        if($this->input->get('nama_vendor') && $this->input->get('nama_vendor') != '')
        {
            $search['vendor.name'] = $this->input->get('nama_vendor');
        }

        if($this->input->get('spesifikasi') && $this->input->get('spesifikasi') != '')
        {
            $search['specification.name'] = $this->input->get('spesifikasi');
        }

        $this->data['riwayat'] = $datas = $this->product_price_history_model->getAllBy(NULL,NULL,$search,NULL,NULL,$where);
        //$this->load->view('admin/riwayat/export_to_excel',$this->data);
        $this->load->view('admin/riwayat/export_to_csv',$this->data);
    }

}
