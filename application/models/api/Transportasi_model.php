<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Transportasi_model extends MY_Model
{
    protected $table = 'transportasi';

    public function __construct()
    {
        parent::__construct();
    }

    public function getMainQuery($where = array())
    {
        $this->db->select('
            vendor.name as vendor_name,
            location.name as origin_name,
            location2.name as destination_name,
            transportasi.id,
            transportasi.price,
            transportasi.is_deleted,
            IFNULL(generate_transport_price.price, transportasi.price) as price,
            IFNULL(kontrak_transportasi.weight_minimum, 0) as weight_minimum
        ')
        ->from('transportasi')
        ->join('location','location.id = transportasi.origin_location_id')
        ->join('location as location2','location2.id = transportasi.destination_location_id')
        ->join('vendor', 'vendor.id = transportasi.vendor_id')
        ->join('generate_transport_price', 'generate_transport_price.transport_id = transportasi.id AND generate_transport_price.is_deleted = 0', 'left')
        ->join('kontrak_transportasi', 'kontrak_transportasi.vendor_id = transportasi.vendor_id AND kontrak_transportasi.is_deleted = 0', 'left');
        $this->db->like($where);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
    		return $query->result();
    	}
    	return FALSE;
    }

    public function getDropdownMycart($where)
    {
        $this->db->select('vendor.name as vendor_name , location.name as location_name,  transportasi.*
        , IFNULL(generate_transport_price.price, transportasi.price) as price_new')
        ->from('kontrak_transportasi')
        ->join('transportasi','transportasi.vendor_id = kontrak_transportasi.vendor_id')
        ->join('vendor', 'vendor.id = transportasi.vendor_id')
        ->join('location','location.id = transportasi.origin_location_id')
        ->join('generate_transport_price', 'generate_transport_price.transport_id = transportasi.id AND generate_transport_price.is_deleted = 0', '')
        ->join('transport_amandemen', 'transport_amandemen.id = kontrak_transportasi.last_amandemen_id', 'left')
        ->where('kontrak_transportasi.status <>', 0);
        $this->db->where($where);
        $q = $this->db->get();
        if ($q->num_rows() > 0)
        {
            return $q->result();
        }

        return FALSE;
    }

    public function get_dropdown_transportasi()
    {
        $where = ['transportasi.is_deleted' => 0];
        $this->getMainQuery();
        $this->db->where($where);
        $q = $this->db->get();

        $dataDropdown = [];
        foreach ($q->result() as $key => $value)
        {
            $dataDropdown[$value->id] = $value->vendor_name . ' (' . $value->origin_name . ' - ' . $value->destination_name . ')';
        }

        return $dataDropdown;
    }

    public function getVendorTransportasi()
    {
        $this->db->select('transportasi.vendor_id , vendor.name as vendor_name')
        ->from('transportasi')
        ->join('vendor', 'transportasi.vendor_id = vendor.id', 'left')
        ->group_by('transportasi.vendor_id')
        ->order_by('vendor_name', 'ASC');

        $q = $this->db->get();
        return $q->result();
    }


    public function getHargaByLastAmandemen($where)
    {
        $this->db->select('transportasi.id
        , transportasi.vendor_id
        , transportasi.origin_location_id
        , transportasi.destination_location_id
        , IFNULL(generate_transport_price.price, transportasi.price) as price
        , IFNULL(kontrak_transportasi.weight_minimum, 0) as weight_minimum'
        )
        ->from('transportasi')
        ->join('generate_transport_price', 'generate_transport_price.transport_id = transportasi.id AND generate_transport_price.is_deleted = 0', 'left')
        ->join('kontrak_transportasi', 'kontrak_transportasi.vendor_id = transportasi.vendor_id AND kontrak_transportasi.is_deleted = 0', 'left')
        ->where($where);
        $query = $this->db->get();

        return $query->num_rows() > 0 ? $query->row() : FALSE;
    }

    public function getVendorTransportasiHandson($where = [])
    {
        $this->getMainQuery();
        $where['transportasi.is_deleted']  = 0;
        $q = $this->db->where($where)->order_by('location.name', 'ASC')->order_by('location2.name', 'ASC')->get();
        $ret = [];
        foreach ($q->result() as $value)
        {
            $ret[] = [
                // $value->id,
                $value->origin_name,
                $value->destination_name,
                $value->price
            ];
        }

        return $ret;
    }

    public function getDataDownload($where)
    {
        $this->getMainQuery();
        $this->db->where($where)->order_by('location.name', 'ASC')->order_by('location2.name', 'ASC');
        return $this->db->get()->result();
    }
}
