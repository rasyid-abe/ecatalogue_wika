<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Dashboard_matgis extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model');
        $this->load->model('Product_model');
        $this->load->model('Order_model');
        $this->load->model('Project_model');
    }

    public function index()
    {
        $this->data['content'] = 'admin/dashboard_matgis';
        $this->load->view('admin/layouts/page', $this->data);
    }

    public function get_detail_nilai()
    {
        $data = $this->Dashboard_model->get_detail_nilai($_POST['params']);
        echo json_encode($data);
    }

    public function get_lat_long()
    {
        print_r('lakjdflak');
    }

    public function get_data_dashboard()
    {
        $input = $this->input->get();
        $po_matgis = $this->Order_model->getAllById([
            'order_status' => 2,
            'is_matgis' => 1,
            'EXTRACT(YEAR FROM update_at) = ' => $input['filterTahun']
        ]);
        $kode_sda = $this->db->get_where('resources_code', ['status' => 1, 'code <>' =>  null])->num_rows();
        $nilai = $this->Dashboard_model->get_nilai($input['filterTahun']);
        $nilai_smcb = $this->Dashboard_model->get_nilai_nilai_smcb($input['filterTahun']);
        $selisih = $nilai_smcb - $nilai;
        $selisih_percent = $selisih / $nilai * 100;
 
        $data = [
            'po_matgis' => $po_matgis === FALSE ? 0 : count($po_matgis),
            'kode_sda' =>  $kode_sda,
            'nilai_transaksi' => $nilai,
            'efisiensi_po' => $selisih,
            'efisiensi_po_precent' => $selisih_percent,
            'get_monev_chart' => $this->get_monev_chart($input['filterTahun']),
            'get_total_penjualan_vendor' => $this->get_total_penjualan_vendor($input['filterTahun']),
            'get_total_penjualan_product' => $this->get_total_penjualan_product($input['filterTahun']),
            'get_data_chart_forecast' => $this->get_data_chart_forecast($input['optionChartBulan'], $input['filterTahun']),
            'get_total_penyerapan_dept' => $this->get_total_penyerapan_dept($input['filterTahun']),
            'pin_maps' => $this->get_pin_maps($input['filterTahun']),
        ];

        echo json_encode($data);
    }

    function rupiah($angka)
    {
        $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
        return $hasil_rupiah;
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

    public function get_pin_maps($tahun)
    {
        $data = $this->Dashboard_model->get_pin_maps($tahun);
        return $data;
    }

    public function get_detail_maps()
    {
        $data = $this->Dashboard_model->get_detail_maps($_POST['id'], $_POST['filterTahun']);
        echo json_encode($data);
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
        foreach ($arr_bulan as $k => $v) {
            foreach ($v as $k2 => $v2) {
                if ($k2 == 'warna') {
                    $bulan_index[$v2] = $k;
                }
            }
        }

        $series = [];
        // untuk menampung array vendor index;
        $vendor_index = [];
        for ($i = $bulan; $i >= 1; $i--) {
            $data = [];
            $inc = 0;
            foreach ($vendors as $k => $v) {
                $data[] = 0;
                if (!in_array($k, $vendor_index)) {
                    $vendor_index[] = $k;
                }
                $index = $k . "_" . $i;
                if (array_key_exists($index, $per_bulan)) {
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

        return $ret;
        //echo json_encode($ret);
        // header('Content-Type: application/json; charset=utf-8');
        // echo json_encode($ret, JSON_PRETTY_PRINT);
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
        foreach ($arr_bulan as $k => $v) {
            foreach ($v as $k2 => $v2) {
                if ($k2 == 'warna') {
                    $bulan_index[$v2] = $k;
                }
            }
        }

        $series = [];
        // untuk menampung array vendor index;
        $product_index = [];
        for ($i = $bulan; $i >= 1; $i--) {
            $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $inc = 0;
            foreach ($products as $k => $v) {
                if (!in_array($k, $product_index)) {
                    $product_index[] = $k;
                }
                $index = $k . "_" . $i;
                if (array_key_exists($index, $per_bulan)) {
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

        return $ret;

        //echo json_encode($ret);
        // header('Content-Type: application/json; charset=utf-8');
        // echo json_encode($ret, JSON_PRETTY_PRINT);
    }

    public function get_data_chart_forecast($month, $year)
    {
        $total_data = $k = '';
        $this->db->select('DATE_FORMAT(date, "%M %Y") AS date, value');
        $this->db->where('EXTRACT(YEAR FROM date) =', $year);
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

        return $result;
        // print_r($result);
        // echo json_encode($result);
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
        foreach ($arr_bulan as $k => $v) {
            foreach ($v as $k2 => $v2) {
                if ($k2 == 'warna') {
                    $bulan_index[$v2] = $k;
                }
            }
        }

        $series = [];
        // isi data default, sesuai dengan jumlah departemen yang ada;
        $data_default = [];
        foreach (range(1, count($dept)) as $v) {
            $data_default[] = 0;
        }
        // untuk menampung array vendor index;
        $dept_index = [];
        for ($i = $bulan; $i >= 1; $i--) {
            $data = $data_default;
            $inc = 0;
            foreach ($dept as $k => $v) {
                if (!in_array($k, $dept_index)) {
                    $dept_index[] = $k;
                }

                $index = $k . "_" . $i;
                if (array_key_exists($index, $per_bulan)) {
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

        return $ret;

        // //echo json_encode($ret);
        // header('Content-Type: application/json; charset=utf-8');
        // echo json_encode($ret, JSON_PRETTY_PRINT);
    }

    public function get_monev_chart($tahun = NULL)
    {
        $tahun || $tahun = date('Y');
        $ret = [];
        $monev = $this->Project_model->get_data_monev_chart($tahun, 72);
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
        foreach (range(0, 2) as $v) {
            // ngisi nilai default nya
            $data = [];
            foreach ($monev as $k2 => $v2) {
                if ($v == 0) {
                    $categories[] = $v2['vendor_name'];
                    $vendor_index[] = $v2['vendor_id'];
                }
                // 2 = jumlah terpakai
                if ($v == 2 && $v2['vendor_id'] != '-1') {
                    $jml_terpakai += $v2['volume_' . $ket[$v]];
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

        return $ret;

        // header('Content-Type: application/json; charset=utf-8');
        // echo json_encode($ret, JSON_PRETTY_PRINT);
    }

    public function detail_po_product($product_id, $bulan, $tahun)
    {
        $query = $this->Order_model->get_detail_order_product($product_id, $bulan, $tahun);
        //var_dump($data);
        $data_fix = [];
        foreach ($query as $k => $v) {
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
        foreach ($query as $k => $v) {
            $data_fix[$v->dept_id][] = $v;
        }
        $data['data'] = $data_fix;
        $this->load->view('admin/dashboard/detail_po_vendor_v', $data);
    }

    public function detail_po_vendor($vendor_id, $tahun, $bulan = NULL)
    {
        $query = $this->Order_model->get_detail_order_vendor($vendor_id, $bulan, $tahun);
        //var_dump($data);
        $data_fix = [];
        foreach ($query as $k => $v) {
            $data_fix[$v->dept_id][] = $v;
        }
        $data['data'] = $data_fix;
        $this->load->view('admin/dashboard/detail_po_vendor_v', $data);
    }

    public function get_detail_penyerapan_dept($dept_id, $bulan, $tahun)
    {
        $query = $this->Order_model->get_detail_penyerapan_dept_result($dept_id, $bulan, $tahun);
        $data['data'] = $query;
        $this->load->view('admin/dashboard/detail_po_dept_v', $data);
    }
}