<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Order_transportasi_model extends MY_Model
{
    protected $table = 'order_transportasi';

    public function __construct()
    {
        parent::__construct();
    }


    public function getMainQuery()
    {
        $this->db->select('order_transportasi.order_no, order_transportasi.created_at, vendor.name as vendor_name, order_transportasi.biaya_transport
        , order_transportasi.data_traller as data_traller_inputed
        , location.name as origin_name
        , location2.name as destination_name
        , project_new.name as project_name
        , SUM(order_transportasi_d.qty * ROUND(order_transportasi_d.weight,4)) as total_weight
        , kontrak_transportasi.data_trailer
        , order.order_status
        , order_transportasi.pdf_name
        , order_transportasi.weight_minimum')
            // , SUM(order_transportasi_d.qty * ROUND(order_transportasi_d.weight,4) * order_transportasi.biaya_transport) as total_biaya_transport
            ->select('CASE WHEN SUM(order_transportasi_d.qty * ROUND(order_transportasi_d.weight,4)) < order_transportasi.weight_minimum * 1000
                       THEN order_transportasi.weight_minimum * 1000 * order_transportasi.biaya_transport
                       ELSE SUM(order_transportasi_d.qty * ROUND(order_transportasi_d.weight,4) * order_transportasi.biaya_transport)
                       END AS total_biaya_transport', FALSE)
            ->from('order_transportasi')
            ->join('order_transportasi_d', 'order_transportasi.order_no = order_transportasi_d.order_no')
            ->join('location', 'location.id = order_transportasi.location_origin_id')
            ->join('location as location2', 'location2.id = order_transportasi.location_destination_id')
            ->join('project_new', 'project_new.id = order_transportasi.project_id')
            ->join('vendor', 'vendor.id = order_transportasi.vendor_id')
            ->join('order', 'order.order_no = order_transportasi.order_no')
            ->join('kontrak_transportasi', 'kontrak_transportasi.vendor_id = order_transportasi.vendor_id AND kontrak_transportasi.is_deleted <> 2', 'left', FALSE)
            ->group_by(['order_transportasi.order_no']);
    }

    public function getDataPdfTransport($where = array())
    {
        $this->db->select('order_transportasi.*
        ,IFNULL(transport_amandemen.created_at, kontrak_transportasi.tgl_kontrak) as tgl_kontrak,
        ,IFNULL(transport_amandemen.end_contract, kontrak_transportasi.end_date) as tgl_akhir_kontrak,
        transport_amandemen.no_amandemen
        , kontrak_transportasi.no_contract as no_kontrak_transport,
        project_new.name as nama_project,
        vendor.name as nama_vendor,
        vendor.ttd_name as nama_direktur,
        vendor.address as alamat_vendor,
        vendor.ttd_pos as jabatan,
        kontrak_transportasi.data_trailer,
        groups.name as departemen,
        groups.general_manager as gm
        , ref_locations.full_name as origin_name
        , location2.full_name as destination_name
        , project_new.alamat
        , project_new.no_hp
        , project_new.contact_person
        , transportasi.sda_code as kode_sda
        , resources_code.name as sda_name
        , SUM(order_transportasi_d.qty * ROUND(order_transportasi_d.weight,4)) as total_weight
        , SUM(order_transportasi_d.qty) as total_qty')
            // , SUM(order_transportasi_d.qty * ROUND(order_transportasi_d.weight,4) * order_transportasi.biaya_transport) as total_biaya_transport
            ->select('CASE WHEN SUM(order_transportasi_d.qty * ROUND(order_transportasi_d.weight,4)) < order_transportasi.weight_minimum * 1000
                       THEN order_transportasi.weight_minimum * 1000 * order_transportasi.biaya_transport
                       ELSE SUM(order_transportasi_d.qty * ROUND(order_transportasi_d.weight,4) * order_transportasi.biaya_transport)
                       END AS total_biaya_transport', FALSE)
            ->from('order_transportasi')
            ->join('order_transportasi_d', 'order_transportasi.order_no = order_transportasi_d.order_no')
            ->join('project_new', 'project_new.id = order_transportasi.project_id')
            ->join('groups', 'groups.id = project_new.departemen_id')
            ->join('transportasi', 'transportasi.id = order_transportasi.transportasi_id')
            ->join('resources_code', 'resources_code.code = transportasi.sda_code','left')
            ->join('kontrak_transportasi', 'kontrak_transportasi.vendor_id = transportasi.vendor_id')
            ->join('vendor', 'vendor.id = order_transportasi.vendor_id')
            ->join('ref_locations', 'ref_locations.location_id = transportasi.origin_location_id')
            ->join('ref_locations as location2', 'location2.location_id = project_new.location_id')
            ->join('transport_amandemen', 'transport_amandemen.id = kontrak_transportasi.last_amandemen_id', 'left')
            ->where($where)
            ->group_by('order_transportasi.order_no');
        $query = $this->db->get();
        // die($this->db->last_query());
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }

    public function getDataPekerjaan($where = array())
    {
        $this->db->select("*")
            ->from('order_transportasi_d')
            ->where($where);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    public function getBiayaTransport($where = array())
    {
        $this->db->select("*")
            ->from('order_transportasi')
            ->join('order_transportasi_d', 'order_transportasi.order_no = order_transportasi_d.order_no')
            ->where($where);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $jmlVolume = 0;
            $harga = 0;
            $weight_minimum = 0;
            $totaltransport = 0;
            foreach ($query->result() as $t) {
                $jmlVolume += $t->qty * $t->weight;
                $harga = $t->biaya_transport;
                $weight_minimum = $t->weight_minimum;
            }
            if ($jmlVolume < ($_beratMin = $weight_minimum * 1000)) {
                $totaltransport = $_beratMin * $harga;
            } else {
                $totaltransport = $jmlVolume * $harga;
            }
            return $totaltransport;
        }
        return 0;
    }
}
