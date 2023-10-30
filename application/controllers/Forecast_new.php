<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Forecast_new extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'download'));
        $this->load->library('form_validation');
        $this->load->library('excel');
    }

    public function index()
    {
        $this->load->helper('url');
        if ($this->data['is_can_read']) {
            $this->data['forecast_data_new'] = $this->db->get('forecast_new')->result_array();
            $this->data['content']  = 'admin/forecast/list_new_v';
            $tahun = $this->data['year_now'];
            $this->data['year'] = array();
            for ($i = $tahun - 3; $i < $tahun + 3; $i++) {
                array_push($this->data['year'], $i);
            }
        } else {
            redirect('restrict');
        }
        $this->load->view('admin/layouts/page', $this->data);
    }

    private function api_data($uri)
    {
        include('httpful.phar');
        $response = Httpful\Request::get($uri)
            ->sendsJson()
            ->addHeader('Accept', 'application/json')
            ->send();

        $data = $response->body;
        return $data;
    }

    public function get_chart_data()
    {
        $days = $this->input->post('days', true);
        $segment = $days > 0 ? $days : '';

        $api_uri = 'https://dev-ecatalog.scmwika.com/api/forecast/data/' . $segment;
        $besi2 = $this->api_data($api_uri);
        $besi = $besi2->data;
        // print_r($besi);
        // die;
        $tgl_forecast = $tgl_chart_cis = $forecast_chart_tang = $forecast_chart_cis = $besi_tang = $besi_cis = [];
        foreach (json_decode($besi->data_tangsan) as $val) {
            $tgl_forecast[] = date('m/d/Y', substr($val->tgl_harga, 0, -3));
            $forecast_chart_tang[] = $val->forecast_tangsan;
        }
        foreach (json_decode($besi->data_cis) as $val) {
            $forecast_chart_cis[] = $val->forecast_cis;
        }
        foreach (json_decode($besi->forecast) as $val) {
            $tgl_forecast[] = date('m/d/Y', substr($val->tgl_forecast, 0, -3));
            $forecast_chart_tang[] = ($val->forecast_tangsan+$val->forecast_tangsan2)/2;
            $forecast_chart_cis[] = ($val->forecast_cis+$val->forecast_cis2)/2;
        }

        $besi_db = $this->db->get('forecast_new')->result_array();
        foreach ($besi_db as $row) {
            $besi_tang[] = (int) $row['harga_besi_tangshan'];
            $besi_cis[] = (int) $row['harga_besi_cis'];
            $tgl_harga[] = $row['tgl_harga'];
            $price_billet_tangshan[] = (int) $row['price_billet_tangshan'];
            $price_billet_cis[] = (int) $row['price_billet_cis'];
            $kurs_bi[] = (int) $row['kurs_bi'];
        }

        $result = [
            'tgl_forecast' => $tgl_forecast,
            'fore_tang' => $forecast_chart_tang,
            'besi_tang' => $besi_tang,
            'fore_cis' => $forecast_chart_cis,
            'besi_cis' => $besi_cis,
            'tgl_harga' => $tgl_harga,
            'price_billet_tangshan' => $price_billet_tangshan,
            'price_billet_cis' => $price_billet_cis,
            'kurs_bi' => $kurs_bi,
        ];

        echo json_encode($result);
    }

    public function get_table_data()
    {
        $days = $this->input->post('days', true);
        $segment = $days > 0 ? $days : '';

        $api_uri = 'https://dev-ecatalog.scmwika.com/api/forecast/data/' . $segment;
        $besi2 = $this->api_data($api_uri);
        $besi = $besi2->data;
        //$besi = $this->api_data($api_uri);

        $result = $data = [];
        unset($result);
        unset($data);
        foreach (json_decode($besi->forecast) as $val) {
            $data['tgl_forecast'] = date('m/d/Y', substr($val->tgl_forecast, 0, -3));
            $data['forecast_tang'] = ($val->forecast_tangsan+$val->forecast_tangsan2)/2;
            $data['forecast_cis'] = ($val->forecast_cis+$val->forecast_cis2)/2;
            $result[] = $data;
        }

        echo json_encode($result);
    }

    public function get_table_rata()
    {
        $days = $this->input->post('days', true);
        $segment = $days > 0 ? $days : '';

        $api_uri = 'https://dev-ecatalog.scmwika.com/api/forecast/data/' . $segment;
        $besi2 = $this->api_data($api_uri);
        $besi = $besi2->data;
        //$besi = $this->api_data($api_uri);

        $result = $data = [];
        unset($result);
        unset($data);
        $cek_bulan = '';
        foreach (json_decode($besi->forecast) as $val) {
            $bulan = date('F - Y', substr($val->tgl_forecast, 0, -3));
            if ($cek_bulan == $bulan) {
                $data['tgl_forecast'] = $bulan;
                $data['forecast_tang'] += ($val->forecast_tangsan+$val->forecast_tangsan2)/2;
                $data['forecast_cis'] += ($val->forecast_cis+$val->forecast_cis2)/2;
                $data['jumlah'] += 1;
            } else {
                $data['tgl_forecast'] = $bulan;
                $data['forecast_tang'] = ($val->forecast_tangsan+$val->forecast_tangsan2)/2;
                $data['forecast_cis'] = ($val->forecast_cis+$val->forecast_cis2)/2;
                $data['jumlah'] = 1;
                $cek_bulan = $bulan;
            }
            $result[$bulan] = $data;
        }

        echo json_encode($result);
    }

    public function create()
    {
        if (!empty($_POST)) {
            $tgl = $this->input->post('tglHarga', true);
            $arr_forecast = [
                'tgl_harga' => $tgl,
                'price_billet_tangshan' => $this->input->post('priceBilletTangshan', true),
                'price_billet_cis' => $this->input->post('priceBilletCis', true),
                'kurs_bi' => $this->input->post('kursBi', true),
                'harga_besi_tangshan' => $this->input->post('hargaBesiTangshan', true),
                'harga_besi_cis' => $this->input->post('hargaBesiCis', true),
            ];

            $exist_tgl = $this->db->get_where('forecast_new', ['tgl_harga' => $tgl])->num_rows();
            if ($exist_tgl > 0) {
                $this->db->where('tgl_harga', $tgl);
                $insert = $this->db->update('forecast_new', $arr_forecast);
            } else {
                $insert = $this->db->insert('forecast_new', $arr_forecast);
            }
            $this->session->set_flashdata('message', "Data Forecast Berhasil Disimpan");
            redirect("forecast_new");
        }
    }

    public function importExcel()
    {
        $result = $baris_err = [];
        $success = $failed = $baris = 0;
        if (isset($_FILES["ImportExcel"]["tmp_name"])) {
            $path = $_FILES["ImportExcel"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);

            foreach ($object->getWorksheetIterator() as $w) {
                $highestRow = $w->getHighestRow();
                $highestColumn = $w->getHighestColumn();
                $result['total_data'] = $highestRow - 1;

                for ($row = 2; $row <= $highestRow; $row++) {
                    $excel_date = $w->getCellByColumnAndRow(0, $row)->getValue();

                    if (is_numeric($excel_date)) {
                        $unix_date = ($excel_date - 25569) * 86400;
                        $excel_date = 25569 + ($unix_date / 86400);
                        $unix_date = ($excel_date - 25569) * 86400;
                        $tgl = gmdate("Y-m-d", $unix_date);

                        $exist_tgl = $this->db->get_where('forecast_new', ['tgl_harga' => $tgl])->num_rows();
                        $excel_row = [
                            'tgl_harga' => $tgl,
                            'price_billet_tangshan' => $w->getCellByColumnAndRow(1, $row)->getValue(),
                            'price_billet_cis' => $w->getCellByColumnAndRow(2, $row)->getValue(),
                            'kurs_bi' => $w->getCellByColumnAndRow(3, $row)->getValue(),
                            'harga_besi_tangshan' => $w->getCellByColumnAndRow(4, $row)->getValue(),
                            'harga_besi_cis' => $w->getCellByColumnAndRow(5, $row)->getValue(),
                        ];
                        if ($exist_tgl > 0) {
                            $this->db->where('tgl_harga', $tgl);
                            $insert = $this->db->update('forecast_new', $excel_row);
                        } else {
                            $insert = $this->db->insert('forecast_new', $excel_row);
                        }

                        if ($insert) {
                            $success++;
                        } else {
                            $failed++;
                        }

                        $baris++;
                    } else {
                        $failed++;
                        $baris_err[] = $baris + 2;
                        $baris++;
                    }
                }
            }
        }
        $this->session->set_flashdata('message', $success . " Forecast Baru Berhasil Disimpan, " . $failed . " Forecast Baru Gagal Disimpan pada baris ke (" . implode(" ", $baris_err) . ")");
        redirect("forecast_new");
    }

    public function download_format()
    {
        $file = './assets/Format_Import_Data_Forecast.xlsx';
        force_download($file, NULL);
    }

    public function edit()
    {
        $id = $this->input->post('id', TRUE);
        $data = $this->db->get_where('forecast_new', ['forecast_id' => $id])->row_array();

        echo json_encode($data);
    }

    public function delete()
    {
        $ids = $this->input->post('idsData', true);

        $sukses = 0;
        $gagal = 0;

        foreach ($ids as $key => $value) {

            $this->db->where('forecast_id', $value);
            $hasil = $this->db->delete('forecast_new');

            if ($hasil) {
                $sukses++;
            } else {
                $gagal++;
            }
        }

        $this->session->set_flashdata('message', $sukses . " Data Forecast Berhasil Dihapus. " . $gagal . " Data Forecast Gagal Dihapus.");
        redirect("forecast_new");
    }
}
