<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Transport_amandemen_model extends MY_Model
{
    protected $table = 'transport_amandemen';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_no_amandemen_terakhir($id_asuransi)
    {
        $query = $this->db->select('MAX(no_amandemen) as no_amandemen')
                          ->where('kontrak_transportasi_id', $id_asuransi)
                          ->get('transport_amandemen');

        return $query->row();
    }

    public function getMainQuery()
    {
        $this->db->select('kontrak_transportasi.no_contract, transport_amandemen.*
        , vendor.name as vendor_name')
        ->from('kontrak_transportasi')
        ->join('transport_amandemen', 'kontrak_transportasi.id = transport_amandemen.kontrak_transportasi_id')
        ->join('vendor', 'vendor.id = kontrak_transportasi.vendor_id');
    }


}
