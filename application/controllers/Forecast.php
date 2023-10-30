<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Forecast extends Admin_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('forecast_model');
        $this->load->model('forecast_detail_model');
        $this->load->model('category_model');
    }

    public function index()
    {
        $this->load->helper('url');
        if($this->data['is_can_read']){
            $this->data['content']  = 'admin/forecast/list_v';
            $tahun = $this->data['year_now'];
            $this->data['year'] = array();
            for($i=$tahun-3; $i<$tahun+3;$i++){
                array_push($this->data['year'] , $i);
            }
        }else{
            redirect('restrict');
        }
        $this->load->view('admin/layouts/page',$this->data);
    }

    public function create()
    {
        if(!empty($_POST)){
            $month_forecast = $this->input->post('month_forecast');
            $year_forecast = $this->input->post('year_forecast');
            $duration = $this->input->post('periode');
            $price = $this->input->post('price');
            $price_upper = $this->input->post('price_upper');
            $category_id = $this->input->post('category_id');
            $input_all = $this->input->post('is_input_all') ? TRUE : FALSE;
            $harga_periode = $this->input->post('harga_periode');
            $harga_periode_upper = $this->input->post('harga_periode_upper');

            $date = new DateTime(null, new DateTimeZone('Asia/Jakarta'));
            $now = $date->format('Y-m-d H:i:s');
            $year = $date->format('Y');
            $month = $date->format('m');
            $day = $date->format('d');
            $insert_id = $this->forecast_model->insert_new(
                [
                    'category_id'=>$category_id,
                    'periode'=>$duration,
                    'start_month'=>$month_forecast,
                    'year'=>$year_forecast,
                    'created_by'=>$this->data['users']->id,
                ]
            );
            $counter = 0;
            $counter_new_month = 1;
            $year_plus = 0;
            $this->db->trans_start();
            while ($counter < $duration){
                $curr_index = $month_forecast+$counter;

                if($curr_index > 12){
                    $new_index = $counter_new_month;
                    $year_plus = (int)(($curr_index - 1) / 12);

                    if($curr_index % 12 == 0)
                    {
                        $counter_new_month = 0;
                    }

                    $counter_new_month++;


                }else{
                    $new_index = $curr_index;
                }
                $new_year = $year_forecast+$year_plus;
                $find = $this->forecast_model->findforecast_detail(['month'=>$new_index,'forecast_detail.year'=>$new_year,"forecast.category_id"=>$category_id,'forecast_detail.is_deleted' => 0]);
                if($find){
                    // echo $month."-".$find->month."-".$year."-".$find->year;
                    if(($find->month > $month && $find->year == $year) || $year_plus > 0){
                        $data = array(
                            'is_deleted' => 1,
                        );
                        $update = $this->forecast_model->update_detail($data,['id'=>$find->id]);
                        if($insert_id){
                            // echo "string";
                            $data = array(
                                'month' => $new_index,
                                'year' => $new_year,
                                'forecast_id' => $insert_id,
                                'price' => $input_all ? $price : (isset($harga_periode[$counter]) ? $harga_periode[$counter] : 0),
                                'price_upper' => $input_all ? $price_upper : (isset($harga_periode_upper[$counter]) ? $harga_periode_upper[$counter] : 0),
                            );
                            $this->forecast_model->insert_new_detail($data);
                        }
                    }
                }else{
                    $data = array(
                        'month' => $new_index,
                        'year' => $new_year,
                        'forecast_id' => $insert_id,
                        'price' => $input_all ? $price : (isset($harga_periode[$counter]) ? $harga_periode[$counter] : 0),
                        'price_upper' => $input_all ? $price_upper : (isset($harga_periode_upper[$counter]) ? $harga_periode_upper[$counter] : 0),
                    );
                    $this->forecast_model->insert_new_detail($data);
                }

                $counter++;
            }
            $this->db->trans_complete();
            //$cek = $input_all ? 'as' : (isset($harga_periode[$counter]) ? 'sa' : 0);
            //var_dump($cek);
            //my_print_r($this->db->queries);
            //die();
            $this->session->set_flashdata('message',"Forecast Baru Berhasil Disimpan");
            redirect("forecast");
        }else{

            $this->load->helper('url');
            if($this->data['is_can_read']){
                $this->data['content']  = 'admin/forecast/create_v';
            }else{
                redirect('restrict');
            }
            $this->data['category'] = $this->category_model->getAllById(['category.is_deleted'=>0,'category.is_margis'=>1]);
            $tahun = $this->data['year_now'];
            $this->data['year'] = array();
            for($i=$tahun-3; $i<$tahun+3;$i++){
                array_push($this->data['year'] , $i);
            }
            $this->load->view('admin/layouts/page',$this->data);
        }
    }

    public function dataList()
    {
        $this->load->model('forecast_model');
        $columns = array(
            0 =>'forecast.id',
            0 =>'forecast.category_id',
            1 =>'forecast.created_at',
            2 =>'forecast.start_month',
            3 =>'forecast.year',
            4 =>'forecast.periode',
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
                $nestedData['category_name'] = $data->category_name;
                $nestedData['year'] = $data->year;
                $nestedData['periode'] = $data->periode." Bulan";
                $monthNum  = $data->start_month;
                $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                $monthName = $dateObj->format('F'); // March
                $nestedData['start_month'] = $monthName;
                // $nestedData['tipe_forecast'] = $data->tipe_forecast == 1 ? 'Forecast' : 'Riwayat';
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

    public function cek()
    {
        $date1 = '2019-09-01';
        $date2 = '2019-09-01';

        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
        echo $diff;
    }

    function getDiffMonth($year1, $month1, $year2, $month2)
    {
        //$date1 = '2019-09-01';
        //$date2 = '2020-09-01';
        $date1 = "$year1-$month1-01";
        $date2 = "$year2-$month2-01";

        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
        return $diff;
    }


    public function getGraphCategory(){
        $bulan_filter = $this->input->get('bulan_filter');
        $bulan = str_pad($bulan_filter, 2, '0', STR_PAD_LEFT);
        $year_filter = $this->input->get('year_filter');
        if(empty($year_filter)){
            $year_filter =2020;
        }
        $reindexed_array = null;
        $default_value = [];
        $default_value2 = [];
        $array_month   = [];
        $array_time   = [];

        //echo $bulan_mulai;
        for($i=0;$i<12;$i++)
        {
            $array_month[]  = date('F Y', strtotime("$year_filter-$bulan-01 + $i months"));
            $array_time[]   = strtotime("$year_filter-$bulan-01: 00:00:00 + $i months");
            $array_month2[] = date('Y-m-d', $array_time[$i]);

        }
        for($i=1;$i<=12;$i++){
            // array_push($default_value,0);
            array_push($default_value, [$array_time[$i-1],0,0]);
        }

        $getcategory = $this->category_model->getAllById(['category.is_deleted'=>0,'category.is_margis'=>1]);
        $category = array();
        $tanggal = 1;
        $date = new DateTime($year_filter.'-'.$bulan_filter.'-'.$tanggal, new DateTimeZone('Asia/Jakarta'));

        if($getcategory){

            foreach ($getcategory as $key => $value) {
                $category[$value->id]['id'] = $value->id;
                $category[$value->id]['name'] = $value->name;
                $category[$value->id]['data'] = $default_value;
                // $category[$value->id]['bulan2'] = strtotime($date);

                // $category[$value->id]['zoneAxis'] = "x";
                // $category[$value->id]['zones'][]['value'] = "5";
                // // $category[$value->id]['zones'][]['dashStyle'] = "dot";
                // $category[$value->id]['zones'][]['color'] = "#FF0000";
            }
            $where_detail['forecast_detail.is_deleted'] = 0;
            //$where_detail['forecast_detail.year'] = $year_filter;
            $having = array(
                "custom_date >= '$year_filter-$bulan-01'",
                "custom_date < '$year_filter-$bulan-01' + INTERVAL 12 MONTH"
            );
            $order = "forecast.category_id,month,forecast_detail.year,forecast_detail.id";
            $forecast_detail = $this->forecast_detail_model->getAllByIdWithOrder($where_detail ,$order,"asc", $having);
            //my_print_r($forecast_detail);
            //die();
            if($forecast_detail){
                $last_value =0;
                $last_value_upper =0;
                $last_month =0;
                $last_year =0;
                $last_category =0;

                foreach ($forecast_detail as $key => $value) {
                    $index = $this->getDiffMonth($year_filter, $bulan_filter, $value->year, $value->month);
                    //echo $last_value_upper . "<br>";
                    $category[$value->category_id]['data'][$index] = [$array_time[$index], (int) $value->price, (int) $value->price_upper];
                    //my_print_r($category[$value->category_id]['data'][$index]);

                    if($value->category_id != $last_category && $last_category !=0){
                        //$c = count($category[$last_category]['data']);
                        $category[$last_category]['zoneAxis'] = "x";
                        $category[$last_category]['zones'][]['value'] = $last_month;
                        $category[$last_category]['zones'][]['color'] = "#FF0000";
                        // $category[$value->id]['zones'][]['dashStyle'] = "dot";
                        for ($j=$last_month - 1; $j < 12; $j++) {
                            $category[$last_category]['data'][$j] = [$array_time[$j], (int)$last_value,(int)$last_value_upper];
                            //echo count($category[$last_category]['data']);
                        }
                    }
                    //generate last element
                    $last_value = (int) $value->price;
                    $last_value_upper = (int) $value->price_upper;
                    $last_month = (int) $index+1;
                    $last_year  = (int) $value->year;
                    $last_category = $value->category_id;

                    end($forecast_detail);
                    //echo key($forecast_detail);
                    if ($key === key($forecast_detail)){

                        $category[$value->category_id]['zoneAxis'] = "x";
                        $category[$value->category_id]['zones'][]['value'] = $index+1;
                        $category[$value->category_id]['zones'][]['color'] = "#FF0000";
                        // $category[$value->id]['zones'][]['dashStyle'] = "dot";
                        for ($j=$index; $j < 12; $j++) {
                            $category[$value->category_id]['data'][$j] = [$array_time[$j], (int)$last_value, (int)$last_value_upper];
                            //echo $last_category;
                        }
                    }

                    // $last_value
                }
            }

            $reindexed_array = array_values($category);
        }

        //print_r($this->db->queries);

        $return = array('category'=>$reindexed_array, 'month' => $array_month, 'time'=>$array_month2);
        echo json_encode($return);

    }

    public function getGraphCategory_old_nanti_dihapus_klo_itu_udah_beres(){
        $year_filter = $this->input->get('year_filter');
        if(empty($year_filter)){
            $year_filter =2020;
        }
        $reindexed_array = null;
        $default_value = [];
        $array_month   = [];
        for($i=1;$i<=12;$i++){
            array_push($default_value, 0);
        }
            array_push($array_month, "Januari");
            array_push($array_month, "Februari");
            array_push($array_month, "Maret");
            array_push($array_month, "April");
            array_push($array_month, "Mei");
            array_push($array_month, "Juni");
            array_push($array_month, "Juli");
            array_push($array_month, "Agustus");
            array_push($array_month, "September");
            array_push($array_month, "Oktober");
            array_push($array_month, "November");
            array_push($array_month, "Desember");

        $getcategory = $this->category_model->getAllById(['category.is_deleted'=>0,'category.is_margis'=>1]);
        $category = array();
        if($getcategory){

            foreach ($getcategory as $key => $value) {
                $category[$value->id]['id'] = $value->id;
                $category[$value->id]['asdasd'] = $value->id;
                $category[$value->id]['name'] = $value->name;
                $category[$value->id]['data'] = $default_value;
                // $category[$value->id]['zoneAxis'] = "x";
                // $category[$value->id]['zones'][]['value'] = "5";
                // // $category[$value->id]['zones'][]['dashStyle'] = "dot";
                // $category[$value->id]['zones'][]['color'] = "#FF0000";
            }
            $where_detail['forecast_detail.is_deleted'] = 0;
            $where_detail['forecast_detail.year'] = $year_filter;
            $order = "forecast.category_id,month,forecast_detail.year,forecast_detail.id";
            $forecast_detail = $this->forecast_detail_model->getAllByIdWithOrder($where_detail ,$order,"asc");
            if($forecast_detail){
                $last_value =0;
                $last_month =0;
                $last_year =0;
                $last_category =0;
                foreach ($forecast_detail as $key => $value) {
                    $category[$value->category_id]['data'][$value->month-1] = (int)$value->price;
                    if($value->month <12){
                        //generate next value
                        if($value->category_id != $last_category && $last_category !=0){
                            $category[$last_category]['zoneAxis'] = "x";
                            $category[$last_category]['zones'][]['value'] = $last_month;
                            $category[$last_category]['zones'][]['color'] = "#FF0000";
                            // $category[$value->id]['zones'][]['dashStyle'] = "dot";
                            for ($j=$last_month-1; $j <12 ; $j++) {
                                $category[$last_category]['data'][$j] = (int)$last_value;
                            }
                        }
                        //generate last element
                        end($forecast_detail);
                        //echo key($forecast_detail);
                        if ($key === key($forecast_detail)){
                            $category[$last_category]['zoneAxis'] = "x";
                            $category[$last_category]['zones'][]['value'] = $last_month;
                            $category[$last_category]['zones'][]['color'] = "#FF0000";
                            // $category[$value->id]['zones'][]['dashStyle'] = "dot";
                            for ($j=$last_month-1; $j <12 ; $j++) {
                                $category[$last_category]['data'][$j] = (int)$last_value;
                            }
                        }
                    }
                    $last_value =(int)$value->price;
                    $last_month =(int)$value->month+1;
                    $last_year  =(int)$value->year;
                    $last_category = $value->category_id;
                    // $last_value
                }
            }

            $reindexed_array = array_values($category);
        }

        //print_r($this->db->queries);

        $return = array('category'=>$reindexed_array, 'month' => $array_month);;
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
        //$this->data['product_forecast_id'] = $id;
        //$this->data['chartdata'] = array();
        $this->load->model('forecast_detail_model');
        $forecast = $this->forecast_detail_model->getforecast_detail(['forecast.id'=>$id]);
        if($forecast){

        }
        $this->data['detail'] = $forecast;
        //$this->data['chartdata'] = json_encode($data);
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
}
