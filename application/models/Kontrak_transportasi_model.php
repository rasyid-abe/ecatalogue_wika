<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Kontrak_transportasi_model extends MY_Model
{
    protected $table = 'kontrak_transportasi';

    public function __construct()
    {
        parent::__construct();
    }

    public function getMainQuery()
    {
        $this->db->select('kontrak_transportasi.*
        , vendor.name as vendor_name
        , IFNULL(transport_amandemen.start_contract, kontrak_transportasi.start_date) as start_contract
        , IFNULL(transport_amandemen.end_contract, kontrak_transportasi.end_date) as end_contract
        , transport_amandemen.no_amandemen')
            ->from('kontrak_transportasi')
            ->join('vendor', 'vendor.id = kontrak_transportasi.vendor_id')
            ->join('transport_amandemen', 'transport_amandemen.id = kontrak_transportasi.last_amandemen_id', 'left');
    }

    function getAllBy($limit, $start, $search, $col, $dir, $where = [], $where_and = [])
    {
        if (!method_exists($this, 'getMainQuery')) {
            $this->db->select("*")
                ->from($this->table);
        } else {
            $this->getMainQuery();
        }

        if (!empty($search)) {
            foreach ($search as $key => $value) {
                $this->db->or_like($key, $value);
            }
        }

        if (!empty($where_and)) {
            $this->db->group_start();
            foreach ($where_and as $key => $value) {
                $this->db->like($key, $value);
            }
            $this->db->group_end();
        }

        $this->db->where($where);

        $this->db->limit($limit, $start);
        $this->db->order_by($col, $dir);

        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return null;
        }
    }

    function getCountAllBy($limit, $start, $search, $order, $dir, $where = [], $where_and = [])
    {
        if (!method_exists($this, 'getMainQuery')) {
            $this->db->select("*")
                ->from($this->table);
        } else {
            $this->getMainQuery();
        }

        if (!empty($search)) {
            foreach ($search as $key => $value) {
                $this->db->or_like($key, $value);
            }
        }

        if (!empty($where_and)) {
            $this->db->group_start();
            foreach ($where_and as $key => $value) {
                $this->db->like($key, $value);
            }
            $this->db->group_end();
        }

        $this->db->where($where);

        $result = $this->db->get();

        return $result->num_rows();
    }

    public function getHargaTransportasi($where = [], $status)
    {
        if ($status == 0) {
            $weight_minimum = 'transportasi.weight_minimum';
            $price_fot_scf = 'transportasi.price_fot_scf';
            $price_fot_tt = 'transportasi.price_fot_tt';
            $price_fog_scf = 'transportasi.price_fog_scf';
            $price_fog_tt = 'transportasi.price_fog_tt';
        } else {
            $weight_minimum = 'generate_transport_price.weight_minimum';
            $price_fot_scf = 'generate_transport_price.price_fot_scf';
            $price_fot_tt = 'generate_transport_price.price_fot_tt';
            $price_fog_scf = 'generate_transport_price.price_fog_scf';
            $price_fog_tt = 'generate_transport_price.price_fog_tt';
        }
        $this->db->select('transportasi.id, resources_code.name as sda_name, vendor.name as vendor_name, ref_locations.full_name as origin_name, location2.name as destination_name, ' . $weight_minimum . ', ' . $price_fot_scf . ', ' . $price_fot_tt . ', ' . $price_fog_scf . ', ' . $price_fog_tt . '')
            ->from('transportasi')
            ->join('ref_locations', 'ref_locations.location_id = transportasi.origin_location_id')
            ->join('resources_code', 'resources_code.code = transportasi.sda_code')
            ->join('vendor', 'vendor.id = transportasi.vendor_barang')
            ->join('project_new as location2', 'location2.id = transportasi.destination_location_id')

            ->where($where)
            ->where('transportasi.is_deleted', 0);

        if ($status != 0) {
            $this->db->join('generate_transport_price', 'generate_transport_price.transport_id = transportasi.id')
                ->where('generate_transport_price.is_deleted', 0);
        }

        $query = $this->db->get();
        $data = [];
        $arrIdTransport = [];
        foreach ($query->result() as $key => $value) {
            $arrIdTransport[] = $value->id;
            $data[] = [
                'transportasi_id' => $value->id,
                'sda_name' => $value->sda_name,
                'vendor_name' => $value->vendor_name,
                'asal' => $value->origin_name,
                'tujuan' => $value->destination_name,
                'berat_minimum' => $value->weight_minimum,
                'harga_fot_scf' => $value->price_fot_scf,
                'harga_fot_tt' => $value->price_fot_tt,
                'harga_fog_scf' => $value->price_fog_scf,
                'harga_fog_tt' => $value->price_fog_tt
            ];
        }
        // klo status = 2, maka cari lagi barang jika ada yang udah di add lagi;
        if ($status == 2) {

            $this->db->select('transportasi.id, resources_code.name as sda_name, vendor.name as vendor_name, ref_locations.full_name as origin_name, location2.name as destination_name, transportasi.weight_minimum, transportasi.price_fot_scf, transportasi.price_fot_tt, transportasi.price_fog_scf, transportasi.price_fog_tt')
                ->from('transportasi')
                ->join('ref_locations', 'ref_locations.location_id = transportasi.origin_location_id')
                ->join('resources_code', 'resources_code.code = transportasi.sda_code')
                ->join('vendor', 'vendor.id = transportasi.vendor_barang')
                ->join('project_new as location2', 'location2.id = transportasi.destination_location_id')
                ->where('transportasi.is_deleted', 0)
                ->where($where);

            if (!empty($arrIdTransport)) {
                $this->db->where_not_in('transportasi.id', $arrIdTransport);
            }

            $qTambahan = $this->db->get();

            foreach ($qTambahan->result() as $key => $value) {
                $data[] = [
                    'transportasi_id' => $value->id,
                    'sda_name' => $value->sda_name,
                    'vendor_name' => $value->vendor_name,
                    'asal' => $value->origin_name,
                    'tujuan' => $value->destination_name,
                    'berat_minimum' => $value->weight_minimum,
                    'harga_fot_scf' => $value->price_fot_scf,
                    'harga_fot_tt' => $value->price_fot_tt,
                    'harga_fog_scf' => $value->price_fog_scf,
                    'harga_fog_tt' => $value->price_fog_tt
                ];
            }
        }

        return $data;
    }

    public function get_detail_kontrak($where = [])
    {
        $this->db->select("transport_amandemen.*
        , kontrak_transportasi.no_contract
        , kontrak_transportasi.tgl_kontrak
        , vendor.name as vendor_name")
            ->from('kontrak_transportasi')
            ->join('transport_amandemen', 'kontrak_transportasi.id = transport_amandemen.kontrak_transportasi_id')
            ->join('vendor', 'vendor.id = kontrak_transportasi.vendor_id', 'left')
            ->where($where);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }

        return FALSE;
    }
}
