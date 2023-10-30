<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Forecast extends Admin_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('forecast_model');
        $this->load->model('forecast_detail_model');
    }

    public function index()
    {
        $this->load->helper('url');
        if($this->data['is_can_read']){
            $this->data['content']  = 'admin/forecast/list_v';
        }else{
            redirect('restrict');
        }
        $this->load->view('admin/layouts/page',$this->data);
    }

    public function create()
    {
        $this->load->helper('url');
        if($this->data['is_can_read']){
            $this->data['content']  = 'admin/forecast/create_v';
        }else{
            redirect('restrict');
        }
        $this->load->view('admin/layouts/page',$this->data);
    }

    public function getdata(){
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $data_from = $this->input->post('data_from'); // 1 = forecast, 0 = riwayat;
        $separator = $this->input->post('separator'); // 1 = comma, 0 = semicolon;
        $this->data['data_from'] = $data_from;
        $this->data['start_date'] = $start_date;
        $this->data['end_date'] = $end_date;

        $where = [];
        $where_product = [];
        if(!$this->data['is_superadmin']){$where['product.vendor_id'] = $where_product['product.vendor_id'] = $this->data['users']->vendor_id;}

        if($data_from == 1)
        {
            $model = 'forecast_model';
            $table = 'product_forecast';
        }
        else
        {
            $model = 'product_price_history_model';
            $table = 'product_price_history';
        }


        $separator_ar[1] = ',';
        $separator_ar[0] = ';';
        $this->data['separator'] = $separator_ar[$separator];

        $where[$table.'.created_at >='] = $start_date;
        $where[$table.'.created_at <='] = $end_date;

        $this->load->model($model);
        $data = $this->$model->getForCSVForecast($where);
        if(!$data)
        {
            $this->load->model('product_model');
            $data = $this->product_model->getAllDataProduct($where_product);
        }
        $product = array();
        if($data){
            foreach ($data as $key => $value) {
                $product[$key]['volume'] = $value->full_name;
                $product[$key]['product_id'] = $value->product_id;
                $product[$key]['industrial_plant'] = 0;
                $product[$key]['luar_negeri'] = 0;
                $product[$key]['plant_energy'] = 0;
                $product[$key]['sipil1'] = 0;
                $product[$key]['sipil2'] = 0;
                $product[$key]['sipil3'] = 0;
                $product[$key]['total'] = 0;
                $product[$key]['satuan'] = $value->uom_name;
            }
        }
        $return['status'] = TRUE;
        $return['message'] = "Get Data Forecast Success";
        $return['data'] = $product;

        echo json_encode($return);
        //var_dump($data);
        // $this->data['csv'] = $data;
    }

    public function export_to_csv()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $data_from = $this->input->get('data_from'); // 1 = forecast, 0 = riwayat;
        $separator = $this->input->get('separator'); // 1 = comma, 0 = semicolon;
        $this->data['data_from'] = $data_from;
        $this->data['start_date'] = $start_date;
        $this->data['end_date'] = $end_date;

        $where = [];
        $where_product = [];
        if(!$this->data['is_superadmin']){$where['product.vendor_id'] = $where_product['product.vendor_id'] = $this->data['users']->vendor_id;}

        if($data_from == 1)
        {
            $model = 'forecast_model';
            $table = 'product_forecast';
        }
        else
        {
            $model = 'product_price_history_model';
            $table = 'product_price_history';
        }


        $separator_ar[1] = ',';
        $separator_ar[0] = ';';
        $this->data['separator'] = $separator_ar[$separator];

        $where[$table.'.created_at >='] = $start_date;
        $where[$table.'.created_at <='] = $end_date;

        $this->load->model($model);
        $data = $this->$model->getForCSVForecast($where);

        if(!$data)
        {
            $this->load->model('product_model');
            $data = $this->product_model->getAllDataProduct($where_product);
        }

        //var_dump($data);
        $this->data['csv'] = $data;

        $this->load->view('admin/forecast/forecast_list_export_to_csv', $this->data);
        //$this->load->view('')


    }

    public function dataList()
    {
        $this->load->model('forecast_model');
        $columns = array(
            0 =>'id',
      		1 =>'created_at',
            2 =>'tipe_forecast',
        );
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  		$search = array();
        $where= [];
        $limit = 0;
  		$start = 0;
        $totalData = $this->forecast_model->getCountAllBy($limit,$start,$search,$order,$dir,$where);

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;

        if($isSearchColumn){
			$totalFiltered = $this->forecast_model->getCountAllBy($limit,$start,$search,$order,$dir,$where);
        }else{
        	$totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
		$datas = $this->forecast_model->getAllBy($limit,$start,$search,$order,$dir,$where);

        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {
                $nestedData['id'] = $start+$key+1;
                $nestedData['created_at'] = $data->created_at;
                $nestedData['tipe_forecast'] = $data->tipe_forecast == 1 ? 'Forecast' : 'Riwayat';
                $nestedData['detail'] = "<a href='".base_url()."forecast/detail/".$data->id."' class='btn btn-sm white'><i class='fa fa-bars'></i> Detail</a>";
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

    public function import()
    {

        $this->data['content'] = 'admin/forecast/import_v';
        $this->load->view('admin/layouts/page', $this->data);
    }

    public function insert_handsone(){
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $data_from = $this->input->post('data_from'); // 1 = forecast, 0 = riwayat;
        $separator = $this->input->post('separator'); // 1 = comma, 0 = semicolon;
        $product_id = $this->input->post('product_id');
        $volume = $this->input->post('volume');
        $industrial_plant = $this->input->post('industrial_plant');
        $plant_energy = $this->input->post('plant_energy');
        $luar_negeri = $this->input->post('luar_negeri');
        $sipil1 = $this->input->post('sipil1');
        $sipil2 = $this->input->post('sipil2');
        $sipil3 = $this->input->post('sipil3');
        $total = $this->input->post('total');
        $satuan = $this->input->post('satuan');
        $this->load->model('forecast_model');
        $data_forecast = [
            'created_by'     =>$this->session->userdata('user_id'),
            'start_date'    => $start_date,
            'end_date'      => $end_date,
            'tipe_forecast' => $data_from
        ];
        $product_forecast_id = 1;
        $this->db->trans_begin();
        $product_forecast_id = $this->forecast_model->insert($data_forecast);
        if($this->input->post('product_id')){
            for($i=0; $i < count($this->input->post($product_id)); $i++){
                $data_forecast_detail[] = [
                    'product_forecast_id'   => $product_forecast_id,
                    'product_id'            => $product_id[$i],
                    'price'             => $total[$i],
                    'industrial_plant'            => $industrial_plant[$i],
                    'plant_energy'            => $plant_energy[$i],
                    'luar_negeri'            => $luar_negeri[$i],
                    'sipil1'            => $sipil1[$i],
                    'sipil2'            => $sipil2[$i],
                    'sipil3'            => $sipil3[$i],
                ];
            }
        }

        $this->db->insert_batch('product_forecast_detail', $data_forecast_detail);
        $error = 0;
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $error = 1;
        }
        else
        {
            $this->db->trans_commit();
        }

        if($error){
            $return['status'] = false;
            $return['message'] = "Forecast Gagal Disimpan";
            $return['data'] = '';
        }else{
            $return['status'] = true;
            $return['message'] = "Forecast berhasil ditambahkan";
            $return['data'] = '';
        }

        echo json_encode($return);

    }
    public function import_act()
    {
        $this->load->library('csvimport');
        //die(var_dump($_FILES));
        $a = $_FILES["csv_file"]['type'];
        $filename = pathinfo($_FILES["csv_file"]["name"]);
        $extension = $filename['extension'];

        if($extension !='csv')
        {
            $return['status']   = false;
            $return['data']     = array();
            $return['message']  = "File Yang Dimasukkan Harus Berekstensi CSV";
            echo json_encode($return);
            return;
        }

        //get data from csv
        //die($_FILES["csv_file"]["tmp_name"]);
        $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);

        if(count($file_data[0]) == 1)
        {
            $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"],FALSE,FALSE,FALSE,';');
        }else
        {
            $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"],FALSE,FALSE,FALSE,',');
        }

        //var_dump($file_data);
        $start_date = $file_data[0]['START_DATE'];
        $end_date = $file_data[0]['END_DATE'];
        $TIPE_FORECAST = $file_data[0]['TIPE_FORECAST'];


        $data_forecast = [
            'created_by'     =>$this->session->userdata('user_id'),
            'start_date'    => $start_date,
            'end_date'      => $end_date,
            'tipe_forecast' => $TIPE_FORECAST
        ];

        $this->load->model('forecast_model');
        $this->db->trans_begin();
        $product_forecast_id = $this->forecast_model->insert($data_forecast);
        $error = [];
        $baris = 1;
        $is_error = false;
        $array_product = []; //untuk mengecek array produk yang sudah diinsert;
        $data_forecast_detail = [];
        foreach($file_data as $key => $value)
        {
            $baris++;
            if(!is_numeric($value['ID_PRODUK']))
            {
                $error[] = "Error baris ke (".$baris.") ID PRODUK Harus Berbentuk Number";
                $is_error = true;
            }

            if(!is_numeric($value['FORECAST']))
            {
                $error[] = "Error baris ke (".$baris.") FORECAST Harus Berbentuk Number";
                $is_error = true;
            }

            if(array_key_exists($value['ID_PRODUK'], $array_product))
            {
                $error[] = "Error, ID PRODUK Pada Baris ($baris) Sudah ada sebelumnya pada baris (".implode(',', $array_product[$value['ID_PRODUK']]).")";
                $is_error = true;
            }

            $data_forecast_detail[] = [
                'product_forecast_id'   => $product_forecast_id,
                'product_id'            => $value['ID_PRODUK'],
                'price'                 => $value['FORECAST'],
            ];

            $array_product[$value['ID_PRODUK']][] = $baris;
        }

        $this->db->insert_batch('product_forecast_detail', $data_forecast_detail);

        if ($this->db->trans_status() === FALSE || $is_error)
        {
                $this->db->trans_rollback();
        }
        else
        {
                $this->db->trans_commit();
        }

        if( ! $is_error) // no Error, sukses
        {
            $return['status']   = true;
            $return['data']     = array();
            $return['message']  = "Forecast Berhasil diupload !";
        }
        else
        {
            $return['status']   = false;
            $return['data']     = $error;
            $return['message']  = "Forecast Gagal diupload !";
        }

        echo json_encode($return);


    }

    public function detail($id)
    {
        $this->load->helper('url');
        if($this->data['is_can_read']){
            $this->data['content']  = 'admin/forecast/detail_v';
        }else{
            redirect('restrict');
        }
        $this->data['product_forecast_id'] = $id;
        $this->data['chartdata'] = array();
        $forecast = $this->forecast_model->findforecast(['product_forecast.id'=>$id]);
        if($forecast){
            $forecast_detail = $this->forecast_detail_model->getAllById(['product_forecast_id'=>$forecast->id]);
            if($forecast_detail){
                $data['industrial_plant'] = array(
                        'name' => "Industrial Plant",
                        'data' =>[],
                    );
                $data['plant_energy'] = array(
                        'name' => "Plant Energy",
                        'data' =>[],
                    );
                $data['luar_negeri'] = array(
                        'name' => "Luar Negeri",
                        'data' =>[],
                    );
                $data['sipil1'] = array(
                        'name' => "Sipil Umum 1",
                        'data' =>[],
                    );
                $data['sipil2'] = array(
                        'name' => "Sipil Umum 2",
                        'data' =>[],
                    );
                $data['sipil3'] = array(
                        'name' => "Sipil Umum 3",
                        'data' =>[],
                    );
                foreach ($forecast_detail as $key => $value) {
                    $data['product'][$key]= $value->full_name;
                    $data['total'][$key] = $value->price;
                    array_push($data['industrial_plant']['data'], (int)$value->industrial_plant);
                    array_push($data['plant_energy']['data'], (int)$value->plant_energy);
                    array_push($data['luar_negeri']['data'], (int)$value->luar_negeri);
                    array_push($data['sipil1']['data'], (int)$value->sipil1);
                    array_push($data['sipil2']['data'], (int)$value->sipil2);
                    array_push($data['sipil3']['data'], (int)$value->sipil3);
                }

                $data['valuex'][] = $data['industrial_plant']; 
                $data['valuex'][] = $data['plant_energy']; 
                $data['valuex'][] = $data['luar_negeri']; 
                $data['valuex'][] = $data['sipil1']; 
                $data['valuex'][] = $data['sipil2']; 
                $data['valuex'][] = $data['sipil3']; 

            }
        }
        $this->data['chartdata'] = json_encode($data); 
        $this->load->view('admin/layouts/page',$this->data);
    }

    public function dataListDetail($id = 2)
    {
        $this->load->model('forecast_detail_model');
        $columns = array(
            0 =>'id',
      		1 =>'product.name',
            2 =>'vendor.name',
            3 =>'product_forecast_detail.price',
        );

        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  		$search = array();
        $where['product_forecast_id']= $id;
        $limit = 0;
  		$start = 0;
        $totalData = $this->forecast_detail_model->getCountAllBy($limit,$start,$search,$order,$dir,$where);

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;

        if($isSearchColumn){
			$totalFiltered = $this->forecast_detail_model->getCountAllBy($limit,$start,$search,$order,$dir,$where);
        }else{
        	$totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
		$datas = $this->forecast_detail_model->getAllBy($limit,$start,$search,$order,$dir,$where);

        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {

                $nestedData['id'] = $start+$key+1;
                $nestedData['full_name'] = $data->full_name;
                $nestedData['vendor_name'] = $data->vendor_name;
                $nestedData['price'] = "Rp. ".number_format($data->price,0,',','.');
                $new_data[] = $nestedData;
            }
        }

        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),
                    "recordsTotal"    => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data"            => $new_data,                    
                    );

        echo json_encode($json_data);

    }

    public function getgraphdata(){

        echo json_encode($data);
    }

}
