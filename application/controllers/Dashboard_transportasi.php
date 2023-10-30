<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Dashboard_transportasi extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model');
    }

    public function index()
    {
        $namaBulan = [
            '01' => "Januari",
            '02' => "Februari",
            '03' => "Maret",
            '04' => "April",
            '05' => "Mei",
            '06' => "Juni",
            '07' => "Juli",
            '08' => "Agustus",
            '09' => "September",
            '10' => "Oktober",
            '11' => "November",
            '12' => "Desember"
        ];
        $this->data['bulan'] = $namaBulan;
        $this->data['content'] = 'admin/dashboard_transportasi';

        $this->load->view('admin/layouts/page', $this->data);
    }

    public function get_data_dashboard()
    {
        $input = $this->input->post();
        $data = [
            'penyerapan_per_vendor' => $this->penyerapan_per_vendor($input['defaultBulan'], $input['filterBulan'], $input['filterTahun']),
            'total_nilai_transportasi' => $this->total_nilai_transportasi($input['defaultBulan'], $input['filterBulan'], $input['filterTahun']),
            'total_volume_diangkut' => $this->total_volume_diangkut($input['defaultBulan'], $input['filterBulan'], $input['filterTahun']),
            'po_per_bulan_berjalan' => $this->po_per_bulan_berjalan($input['defaultBulan'], $input['filterBulan'], $input['filterTahun']),
            'po_per_tahun_berjalan' => $this->po_per_tahun_berjalan($input['filterTahun']),
            'po_per_divisi_per_volume_bar' => $this->po_per_divisi_per_volume_bar($input['defaultBulan'], $input['filterBulan'], $input['filterTahun']),
            'po_per_divisi_per_volume_pie' => $this->po_per_divisi_per_volume_pie($input['defaultBulan'], $input['filterBulan'], $input['filterTahun']),
            'po_per_project' => $this->po_per_project($input['defaultBulan'], $input['filterBulan'], $input['filterTahun']),
            'all_volume_per_bulan_berjalan' => $this->all_volume_per_bulan_berjalan($input['defaultBulan'], $input['filterBulan'], $input['filterTahun']),
            'vehicle_terbanyak_by_volume' => $this->vehicle_terbanyak_by_volume($input['defaultBulan'], $input['filterBulan'], $input['filterTahun']),
        ];

        echo json_encode($data);
    }

    public function get_detail_po()
    {
        $data = $this->Dashboard_model->get_detail_po($_POST['params']);
        echo json_encode($data);
    }

    public function penyerapan_per_vendor($default, $bulan, $tahun)
    {
        $data = $this->Dashboard_model->get_penyerapan_per_vendor($default, $bulan, $tahun);
        return $data;
    }

    public function total_nilai_transportasi($default, $bulan, $tahun)
    {
        $data = $this->Dashboard_model->get_total_nilai_transportasi($default, $bulan, $tahun);
        return $data;
    }

    public function total_volume_diangkut($default, $bulan, $tahun)
    {
        $data = $this->Dashboard_model->get_total_volume_diangkut($default, $bulan, $tahun);
        return $data;
    }

    public function po_per_bulan_berjalan($default, $bulan, $tahun)
    {
        $data = $this->Dashboard_model->get_po_per_bulan_berjalan($default, $bulan, $tahun);
        return $data;
    }

    public function po_per_tahun_berjalan($tahun)
    {
        $data = $this->Dashboard_model->get_po_per_tahun_berjalan($tahun);
        return $data;
    }

    public function po_per_divisi_per_volume_bar($default, $bulan, $tahun)
    {
        $data = $this->Dashboard_model->get_po_per_divisi_per_volume_bar($default, $bulan, $tahun);
        return $data;
    }

    public function po_per_divisi_per_volume_pie($default, $bulan, $tahun)
    {
        $data = $this->Dashboard_model->get_po_per_divisi_per_volume_pie($default, $bulan, $tahun);
        return $data;
    }

    public function po_per_project($default, $bulan, $tahun)
    {
        $data = $this->Dashboard_model->get_po_per_project($default, $bulan, $tahun);
        return $data;
    }

    public function all_volume_per_bulan_berjalan($default, $bulan, $tahun)
    {
        $data = $this->Dashboard_model->get_all_volume_per_bulan_berjalan($default, $bulan, $tahun);
        if (!empty($data)) {
            foreach ($data as $i) {
                $m[] = (int) $i->date;
            }

            $max = max($m);
            $val = $tgl = [];
            $a = 0;
            for ($i = 0; $i < $max; $i++) {
                $tgl[] = $i + 1;
                if (in_array($i + 1, $m)) {
                    $val[] = (float) $data[$a]->volume;
                    $a++;
                } else {
                    $val[] = 0;
                }
            }

            $res = [
                'tgl' => $tgl,
                'vol' => $val,
            ];
        } else {
            $res = [
                'tgl' => [],
                'vol' => [],
            ];
        }
        return $res;
    }

    public function vehicle_terbanyak_by_volume($default, $bulan, $tahun)
    {
        $data = $this->Dashboard_model->get_vehicle_terbanyak_by_volume($default, $bulan, $tahun);
        return $data;
    }
}
