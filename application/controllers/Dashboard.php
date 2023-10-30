<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Dashboard extends Admin_Controller {
 	public function __construct()
	{
		parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('Order_model');
        $this->load->model('Project_model');
	}
	public function index()
	{
		$this->load->helper('url');
        // dashboard admin
        if($this->ion_auth->in_group(1))
        {
            $this->load->model('User_model');

            $total_user = $this->User_model->getAllById(['users.id <>' => 0]);
            $po_matgis = $this->Order_model->getAllById(['order_status' => 2, 'is_matgis' => 1]);
            $po_non_matgis = $this->Order_model->getAllById(['order_status' => 2, 'is_matgis' => 0]);
            $this->data['po_matgis'] = $po_matgis === FALSE ? 0 : count($po_matgis);
            $this->data['po_non_matgis'] = $po_non_matgis === FALSE ? 0 : count($po_non_matgis);
            $total_produk = $this->Product_model->getAllById(['is_deleted' => 0]);
            $this->data['total_produk'] = count($total_produk);
            $this->data['total_user'] = $total_user === FALSE ? 0 : count($total_user);
            $this->data['total_sda_app'] = $this->count_app_sda();
            $this->data['content'] = 'admin/dashboard';
        }
        // dashboard vendor
        else if($this->ion_auth->in_group(3))
        {
            $this->load->model('Notification_model');
            $this->load->model('Aktifitas_user_model');
            $this->load->model('List_feedback_model');
            $query = $this->Order_model->get_total_dana_order(['vendor_id' => $this->data['users']->vendor_id]);

            $feedback = $this->List_feedback_model->getAllById(['vendor_id' => $this->data['users']->vendor_id]);

            $this->data['feedback_vendor'] = $feedback === FALSE ? 0 : count($feedback);
            $this->data['activity_vendor'] = $this->Aktifitas_user_model->get_last_activity(['user_id' => $this->data['users']->id]);
            $this->data['notif_vendor'] = $this->Notification_model->get_last_notif(['id_penerima' => $this->data['users']->id]);
            $this->data['dana'] = $query->totalnya;
            $this->data['jml_order'] = $query->banyaknya;
            $this->data['content'] = 'admin/dashboard_vendor';
        }
        else
        {
            $this->load->model('User_model');

            $total_user = $this->User_model->getAllById(['users.id <>' => 0]);
            $po_matgis = $this->Order_model->getAllById(['order_status' => 2, 'is_matgis' => 1]);
            $po_non_matgis = $this->Order_model->getAllById(['order_status' => 2, 'is_matgis' => 0]);
            $this->data['po_matgis'] = $po_matgis === FALSE ? 0 : count($po_matgis);
            $this->data['po_non_matgis'] = $po_non_matgis === FALSE ? 0 : count($po_non_matgis);
            $total_produk = $this->Product_model->getAllById(['is_deleted' => 0]);
            $this->data['total_produk'] = count($total_produk);
            $this->data['total_user'] = $total_user === FALSE ? 0 : count($total_user);
            $this->data['total_sda_app'] = $this->count_app_sda();
            $this->data['content'] = 'admin/dashboard';
        }



		$this->load->view('admin/layouts/page',$this->data);
	}

    public function count_app_sda()
    {
        return $this->db->get_where('resources_code', ['status' => 1])->num_rows();
    }

    public function get_data_chart_forecast()
    {
        $total_data = $k = '';
        $month = $this->input->post('month', true);
        $this->db->select('DATE_FORMAT(date, "%M %Y") AS date, value');
        $data = $this->db->get('forecast_dashboard')->result_array();
        if ($month == 1) {
            array_pop($data);
            array_pop($data);
            $total_data = count($data);
            $k = 1;
        } elseif ($month == 2) {
            $total_data = count($data);
            array_pop($data);
            $k = 3;
            // print_r(count($data));
            // echo "<br>";
            // print_r($k);
            // die;
        } else {
            $total_data = count($data);
            $k = 3;
        }

        $result = $bulan = $value = $tigaatas = $tigabawah = [];
        $i = 1;
        foreach ($data as $val) {
            $bulan[] = $val['date'];
            $value[] = (int)$val['value'];

            if ($i > $total_data - $k) {
                $tigaatas[] = (int)$val['value'] + ($val['value'] * 3 / 100);
                $tigabawah[] = (int)$val['value'] - ($val['value'] * 3 / 100);
            } else {
                $tigaatas[] = '';
                $tigabawah[] = '';
            }
            $i++;
        }

        $result = [
            'bulan' => $bulan,
            'harga' => $value,
            'hargaatas' => $tigaatas,
            'hargabawah' => $tigabawah,
        ];
        // print_r($result);
        echo json_encode($result);
    }

    public function get_penyerapan_vendor($tahun = NULL, $is_dashboard_user = FALSE)
    {
        $tahun || $tahun = date('Y');
        $bulan = $tahun == date('Y') ? date('n') : 12;
        $vendor_id = $this->data['users']->vendor_id;
        // jika $is_dashboard_user == 'user,' maka $vendorId = user_id;
        if ($is_dashboard_user == 'user')
        {
            $vendor_id = $this->data['users']->id;
        }
        $arr_bulan = $this->_get_array_bulan_dan_warnanya();
        $penyarapan_vendor = $this->Order_model->get_penyerapan_vendor($vendor_id, $tahun, $is_dashboard_user);

        $inc = 0;
        $data = [];
        $categories = [];
        for($i = 1; $i <= $bulan; $i++)
        {
            $categories[$inc] = $arr_bulan[$i]['nama'];
            $data[$inc] = isset($penyarapan_vendor[$i]) ? (int) $penyarapan_vendor[$i] : 0;
            $inc++;
        }

        $ret = [
            'categories' => array_values($categories),
            'data' => array_values($data)
        ];

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($ret, JSON_PRETTY_PRINT);

    }

    public function get_penyerapan_volume_vendor($tahun = NULL, $is_dashboard_user = FALSE)
    {

        $tahun || $tahun = date('Y');
        $bulan = $tahun == date('Y') ? date('n') : 12;
        $vendor_id = $this->data['users']->vendor_id;
        if ($is_dashboard_user == 'user')
        {
            $vendor_id = $this->data['users']->id;
        }
        $arr_bulan = $this->_get_array_bulan_dan_warnanya();
        $penyarapan_vendor = $this->Order_model->get_penyerapan_volume_vendor($vendor_id, $tahun, $is_dashboard_user);

        $inc = 0;
        $data = [];
        $categories = [];
        for($i = 1; $i <= $bulan; $i++)
        {
            $categories[$inc] = $arr_bulan[$i]['nama'];
            $data[$inc] = isset($penyarapan_vendor[$i]) ? (int) $penyarapan_vendor[$i] : 0;
            $inc++;
        }

        $ret = [
            'categories' => array_values($categories),
            'data' => array_values($data)
        ];

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($ret, JSON_PRETTY_PRINT);

    }

    public function get_total_penjualan_vendor($tahun = NULL)
    {
        $tahun || $tahun = date('Y');
        $bulan =  12;

        $vendors = $this->Order_model->get_top_5_vendor($tahun);
        $per_bulan = $this->Order_model->get_top_5_vendor_per_bulan($tahun, $vendors);
        //echo $this->db->last_query();
        $arr_bulan = $this->_get_array_bulan_dan_warnanya();
        // index bulan key = warnanya, value = bulannya;
        $bulan_index = [];
        foreach ($arr_bulan as $k => $v)
        {
            foreach ($v as $k2 => $v2)
            {
                if ($k2 == 'warna')
                {
                    $bulan_index[$v2] = $k;
                }
            }
        }

        $series = [];
        // untuk menampung array vendor index;
        $vendor_index = [];
        for ($i = $bulan; $i >= 1; $i--)
        {
            $data = [];
            $inc = 0;
            foreach ($vendors as $k => $v)
            {
                $data[]=0;
                if (! in_array($k, $vendor_index))
                {
                    $vendor_index[] = $k;
                }
                $index = $k . "_" . $i;
                if (array_key_exists($index, $per_bulan))
                {
                    $data[$inc] = (int)$per_bulan[$index];
                }

                $inc++;

            }
            $series[] = [
                'name' => $arr_bulan[$i]['nama'],
                'data' => $data,
                'color' => $arr_bulan[$i]['warna'],
            ];
        }

        $ret = [
            'category' => array_values($vendors),
            'series' => $series,
            'vendor_index' => $vendor_index,
            'bulan_index'  => $bulan_index,
        ];

        //echo json_encode($ret);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($ret, JSON_PRETTY_PRINT);

    }

    public function get_total_penjualan_product($tahun = NULL)
    {
        $tahun || $tahun = date('Y');
        $bulan =  12;

        $products = $this->Order_model->get_top_10_product($tahun);
        $per_bulan = $this->Order_model->get_top_10_product_per_bulan($tahun, $products);
        //echo $this->db->last_query();
        $arr_bulan = $this->_get_array_bulan_dan_warnanya();
        // index bulan key = warnanya, value = bulannya;
        $bulan_index = [];
        foreach ($arr_bulan as $k => $v)
        {
            foreach ($v as $k2 => $v2)
            {
                if ($k2 == 'warna')
                {
                    $bulan_index[$v2] = $k;
                }
            }
        }

        $series = [];
        // untuk menampung array vendor index;
        $product_index = [];
        for ($i = $bulan; $i >= 1; $i--)
        {
            $data = [0,0,0,0,0,0,0,0,0,0];
            $inc = 0;
            foreach ($products as $k => $v)
            {
                if (! in_array($k, $product_index))
                {
                    $product_index[] = $k;
                }
                $index = $k . "_" . $i;
                if (array_key_exists($index, $per_bulan))
                {
                    $data[$inc] = (int)$per_bulan[$index];
                }

                $inc++;
            }
            $series[] = [
                'name' => $arr_bulan[$i]['nama'],
                'data' => $data,
                'color' => $arr_bulan[$i]['warna'],
            ];
        }

        $ret = [
            'category' => array_values($products),
            'series' => $series,
            'vendor_index' => $product_index,
            'bulan_index'  => $bulan_index,
        ];

        //echo json_encode($ret);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($ret, JSON_PRETTY_PRINT);

    }

    public function get_total_penyerapan_dept($tahun = NULL)
    {
        $tahun || $tahun = date('Y');
        $bulan =  12;

        $dept = $this->Order_model->get_penyerapan_dept($tahun);
        //echo $this->db->last_query();
        $per_bulan = $this->Order_model->get_penyerapan_dept_per_bulan($tahun, $dept);
        $arr_bulan = $this->_get_array_bulan_dan_warnanya();
        // index bulan key = warnanya, value = bulannya;
        $bulan_index = [];
        foreach ($arr_bulan as $k => $v)
        {
            foreach ($v as $k2 => $v2)
            {
                if ($k2 == 'warna')
                {
                    $bulan_index[$v2] = $k;
                }
            }
        }

        $series = [];
        // isi data default, sesuai dengan jumlah departemen yang ada;
        $data_default = [];
        foreach(range(1, count($dept)) as $v)
        {
            $data_default[] = 0;
        }
        // untuk menampung array vendor index;
        $dept_index = [];
        for ($i = $bulan; $i >= 1; $i--)
        {
            $data = $data_default;
            $inc = 0;
            foreach ($dept as $k => $v)
            {
                if (! in_array($k, $dept_index))
                {
                    $dept_index[] = $k;
                }

                $index = $k . "_" . $i;
                if (array_key_exists($index, $per_bulan))
                {
                    $data[$inc] = (int)$per_bulan[$index];
                }

                $inc++;
            }
            $series[] = [
                'name' => $arr_bulan[$i]['nama'],
                'data' => $data,
                'color' => $arr_bulan[$i]['warna'],
            ];
        }

        $ret = [
            'category' => array_values($dept),
            'series' => $series,
            'dept_index' => $dept_index,
            'bulan_index'  => $bulan_index,
        ];

        //echo json_encode($ret);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($ret, JSON_PRETTY_PRINT);

    }

    public function get_detail_penyerapan_dept($dept_id, $bulan, $tahun)
    {
        $query = $this->Order_model->get_detail_penyerapan_dept_result($dept_id, $bulan, $tahun);
        $data['data'] = $query;
        $this->load->view('admin/dashboard/detail_po_dept_v', $data);
    }

    private function _get_array_bulan_dan_warnanya()
    {
        return [
            '1' => [
                'nama' => 'Jan',
                'warna' => '#fe7a03',
            ],
            '2' => [
                'nama' => 'Feb',
                'warna' => '#2b3537',
            ],
            '3' => [
                'nama' => 'Mar',
                'warna' => '#0594fc',
            ],
            '4' => [
                'nama' => 'Apr',
                'warna' => '#f3ca0c',
            ],
            '5' => [
                'nama' => 'Mei',
                'warna' => '#2fc621',
            ],
            '6' => [
                'nama' => 'Jun',
                'warna' => '#3f01cd',
            ],
            '7' => [
                'nama' => 'Jul',
                'warna' => '#3c5f70',
            ],
            '8' => [
                'nama' => 'Aug',
                'warna' => '#1c03fg',
            ],
            '9' => [
                'nama' => 'Sep',
                'warna' => '#34ff78',
            ],
            '10' => [
                'nama' => 'Okt',
                'warna' => '#12cd88',
            ],
            '11' => [
                'nama' => 'Nov',
                'warna' => '#cabede',
            ],
            '12' => [
                'nama' => 'Des',
                'warna' => '#e0069f',
            ],
        ];
    }

    // return tr nya langsung, logic di js agak susah ada colspan2nya
    public function detail_po_vendor($vendor_id, $tahun, $bulan = NULL)
    {
        $query = $this->Order_model->get_detail_order_vendor($vendor_id, $bulan, $tahun);
        //var_dump($data);
        $data_fix = [];
        foreach ($query as $k => $v)
        {
            $data_fix[$v->dept_id][] = $v;
        }
        $data['data'] = $data_fix;
        $this->load->view('admin/dashboard/detail_po_vendor_v', $data);
    }

    public function detail_penyerapan_vendor($vendor_id, $tahun, $category_id)
    {
        $query = $this->Order_model->get_detail_penyerapan_vendor($vendor_id, $tahun, $category_id);
        //echo $this->db->last_query();
        $data_fix = [];
        foreach ($query as $k => $v)
        {
            $data_fix[$v->dept_id][] = $v;
        }
        $data['data'] = $data_fix;
        $this->load->view('admin/dashboard/detail_po_vendor_v', $data);
    }

    public function detail_po_product($product_id, $bulan, $tahun)
    {
        $query = $this->Order_model->get_detail_order_product($product_id, $bulan, $tahun);
        //var_dump($data);
        $data_fix = [];
        foreach ($query as $k => $v)
        {
            $data_fix[$v->dept_id][] = $v;
        }
        $data['data'] = $data_fix;
        $this->load->view('admin/dashboard/detail_po_vendor_v', $data);
    }

    public function cek_sms()
    {
        sendsms(['081312312','','191891811',''], 'OK');
        //
        //send_sms_by_role_id(3);
    }

    public function cek_email()
    {
        $this->load->helper('email_helper');
        cek_cc();
    }

  public function dataList()
  {
      $columns = array(
          0 =>'vendor.id',
          1 =>'vendor.name',
          2=> 'vendor.no_contract',
          3=> 'vendor.address',
          4=> 'vendor.email',
      );


      $order = $columns[$this->input->post('order')[0]['column']];
      $dir = $this->input->post('order')[0]['dir'];
      $search = array();
      $where = ['end_contract <= NOW() + INTERVAL 60 DAY' => NULL, 'end_contract >= NOW()' => NULL];
      $limit = 0;
      $start = 0;
      $this->load->model('vendor_model');
      $totalData = $this->vendor_model->getCountAllBy($limit,$start,$search,$order,$dir,$where);

      if(!empty($this->input->post('search')['value'])){
          $search_value = $this->input->post('search')['value'];
          $search = array(
              "vendor.name"=>$search_value,
              "vendor.no_contract"=>$search_value,
              "vendor.address"=>$search_value,
              "vendor.email"=>$search_value,
          );
          $totalFiltered = $this->vendor_model->getCountAllBy($limit,$start,$search,$order,$dir,$where);
      }else{
          $totalFiltered = $totalData;
      }

      $limit = $this->input->post('length');
      $start = $this->input->post('start');
      $datas = $this->vendor_model->getAllBy($limit,$start,$search,$order,$dir,$where);

      $new_data = array();
      if(!empty($datas))
      {
          foreach ($datas as $key=>$data)
          {
              $nestedData['id']               = $start+$key+1;;
              $nestedData['name']             = $data->name;
              $nestedData['address']          = $data->address;
              $nestedData['email']            = $data->email;
              $nestedData['no_contract']      = $data->no_contract;
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

  public function read_notif()
  {
      $user_id = $this->data['users']->id;

      $this->load->model('Notification_model');
      $update = $this->Notification_model->update(['is_read' => 1],['id_penerima' => $user_id]);

      if($update !== FALSE)
      {
          $ret['status'] = TRUE;
          echo json_encode($ret);
      }
  }

  public function get_monev_chart($tahun, $category_id)
  {
      $tahun || $tahun = date('Y');
      $ret = [];
      $monev = $this->Project_model->get_data_monev_chart($tahun, $category_id);
      //var_dump($monev);
      $series = [];
      $categories = [];
      $ket = [
          'over',
          'sisa',
          'terpakai',
      ];

      $color_wika = [
          '#ff1a1a',
          '#66b3ff',
          '#0039e6',
      ];

      $color_vendor = [
          '#2ED1A2',
          '#6A8EF9',
          '#00ff00',
      ];

      $vendor_index = [];
      $jml_terpakai = 0;
      foreach (range(0,2) as $v)
      {
          // ngisi nilai default nya
          $data = [];
          foreach ($monev as $k2 => $v2)
          {
              if ($v == 0)
              {
                  $categories[] = $v2['vendor_name'];
                  $vendor_index[] = $v2['vendor_id'];
              }
              // 2 = jumlah terpakai
              if ($v == 2 && $v2['vendor_id'] != '-1')
              {
                  $jml_terpakai += $v2['volume_' . $ket[$v]] ;
              }

              $data[] = [
                  'y' => $v2['volume_' . $ket[$v]],
                  'name' => 'volume ' . $ket[$v] . ' ' . $v2['vendor_name'],
                  'color' => $v2['vendor_id'] == '-1' ? $color_wika[$v] : $color_vendor[$v],
              ];
          }
          $_temp_series = [
              'data' => $data,
              'showInLegend' => false,
          ];

          $series[] = $_temp_series;
      }

      $ret['series'] = $series;
      $ret['categories'] = $categories;
      $ret['vendor_index'] = $vendor_index;
      $ret['total_penyerapan'] = $jml_terpakai;

      header('Content-Type: application/json; charset=utf-8');
      echo json_encode($ret, JSON_PRETTY_PRINT);
  }

}
