<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
// require_once BASEPATH. 'vendor/autoload.php';
use Mpdf\Mpdf;

class Resources_all extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('excel');
    }

    public function index()
    {
        $this->load->helper('url');
        if ($this->data['is_can_read']) {
            $this->data['title'] = 'List Kode Sumber Daya';
            $this->data['content']  = 'admin/resources_code/list_code_all';
            $this->data['level1'] = $this->db->get_where('resources_code', ['level' => 1])->result_array();
        } else {
            redirect('restrict');
        }
        $this->load->view('admin/layouts/page', $this->data);
    }

    public function show_data()
    {
        $sql = $this->db->get_where('resources_code', ['status' => 1])->result_array();
        echo json_encode($sql);
    }

    public function level_change()
    {
        $data = $this->input->post('data', true);
        $sql = $this->db->get_where('resources_code', ['parent_code' => $data])->result_array();

        echo json_encode($sql);
    }

    public function show_data_param()
    {
        $data = $this->input->post('data', true);
        $lvl = $this->input->post('lvl', true);

        if ($lvl == 1) {
            $kode = substr($data, 0, 1);
            $lev = 1;
        } elseif ($lvl == 2) {
            $kode = substr($data, 0, 2);
            $lev = 2;
        } elseif ($lvl == 3) {
            $kode = substr($data, 0, 3);
            $lev = 3;
        } elseif ($lvl == 4) {
            $kode = substr($data, 0, 4);
            $lev = 4;
        } elseif ($lvl == 5) {
            $kode = substr($data, 0, 5);
            $lev = 5;
        }

        $sql = "
        SELECT * FROM resources_code WHERE code LIKE '$kode%' AND code <> '$data' AND level > $lev
        ";

        $query = $this->db->query($sql)->result_array();
        echo json_encode($query);
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
                    $excel_row = [
                        'code' => $w->getCellByColumnAndRow(0, $row)->getValue(),
                        'parent_code' => $w->getCellByColumnAndRow(1, $row)->getValue(),
                        'name' => $w->getCellByColumnAndRow(2, $row)->getValue(),
                        'unspsc' => $w->getCellByColumnAndRow(3, $row)->getValue(),
                        'unspsc_name' => $w->getCellByColumnAndRow(4, $row)->getValue(),
                        'status' => 1,
                        'sts_matgis' => $w->getCellByColumnAndRow(5, $row)->getValue(),
                        'level' => $w->getCellByColumnAndRow(6, $row)->getValue(),
                    ];
                    // print_r($excel_row); die; exit;
                    $insert = $this->db->insert('resources_code', $excel_row);
                    if ($insert) {
                        $success++;
                    } else {
                        $failed++;
                    }
                }
            }
        }
        $this->session->set_flashdata('message', $success . " Forecast Baru Berhasil Disimpan, " . $failed . " Forecast Baru Gagal Disimpan");
        redirect("resources_all");
    }

    public function generate_pdf()
    {
        if ($this->data['is_can_download']) {
            if ($_POST['all_level1'] == '') {
                $data = $this->db->get('resources_code')->result_array();
                $level = "ALL";
            } elseif ($_POST['all_level1'] != '' && $_POST['all_level2'] == '') {
                $data = $this->print_data_param($_POST['all_level1'], 1);
                $level = "Level 1";
            } elseif ($_POST['all_level1'] != '' && $_POST['all_level2'] != '' && $_POST['all_level3'] == '') {
                $data = $this->print_data_param($_POST['all_level2'], 2);
                $level = "Level 2";
            } elseif ($_POST['all_level1'] != '' && $_POST['all_level2'] != '' && $_POST['all_level3'] != '' && $_POST['all_level4'] == '') {
                $data = $this->print_data_param($_POST['all_level3'], 3);
                $level = "Level 3";
            } elseif ($_POST['all_level1'] != '' && $_POST['all_level2'] != '' && $_POST['all_level3'] != '' && $_POST['all_level4'] != ''  && $_POST['all_level5'] == '') {
                $data = $this->print_data_param($_POST['all_level4'], 4);
                $level = "Level 4";
            } elseif ($_POST['all_level1'] != '' && $_POST['all_level2'] != '' && $_POST['all_level3'] != '' && $_POST['all_level4'] != ''  && $_POST['all_level5'] != '' && $_POST['all_level6'] == '') {
                $data = $this->print_data_param($_POST['all_level5'], 5);
                $level = "Level 5";
            }
            $this->data['data'] = $data;
            $this->data['level'] = $level;
            $this->data['user'] = $this->db->get_where('users', ['id' => $this->data['users']->id])->row('first_name');
            $this->data['tgl_export'] = tgl_indo(date('Y-m-d'));

            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
            $html = $this->load->view('admin/resources_code/pdf_all', $this->data, true);
            $mpdf->WriteHTML($html);
            $mpdf->SetMargins(0, 0, 0);
            $filename = "SDA_ALL_" . time();
            $mpdf->Output($filename . ".pdf", "I");
            // $mpdf->Output("pdf/sda/".$filename.".pdf" ,"F");
        } else {
            redirect('restrict');
        }
    }

    public function print_data_param($export, $level)
    {
        $data = $export;
        $lvl = $level;

        if ($lvl == 1) {
            $kode = substr($data, 0, 1);
            $lev = 1;
        } elseif ($lvl == 2) {
            $kode = substr($data, 0, 2);
            $lev = 2;
        } elseif ($lvl == 3) {
            $kode = substr($data, 0, 3);
            $lev = 3;
        } elseif ($lvl == 4) {
            $kode = substr($data, 0, 4);
            $lev = 4;
        } elseif ($lvl == 5) {
            $kode = substr($data, 0, 5);
            $lev = 5;
        }

        $sql = "
        SELECT * FROM resources_code WHERE code LIKE '$kode%' AND code <> '$data' AND level > $lev
        ";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }
}
