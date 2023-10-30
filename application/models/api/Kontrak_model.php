<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kontrak_model extends MY_Model
{
    protected $table = 'project';
    public function __construct()
    {
        parent::__construct();
    }

    public function findAllDataKontrak($where = array()){
		$this->db->select("project.*,
			vendor.name as vendor_name
			");
		$this->db->from('project');
		$this->db->join('vendor','vendor.id = project.vendor_id');
        $this->db->like($where);
        $this->db->where('project.is_deleted', 0);
		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->result_array();
    	}
    	return FALSE;
    }

    
    public function findAllDataTransportasi($where = array()){
		$this->db->select("kontrak_transportasi.*,
			vendor.name as vendor_name
			");
		$this->db->from('kontrak_transportasi');
		$this->db->join('vendor','vendor.id = kontrak_transportasi.vendor_id');
        $this->db->like($where);
        $this->db->where('kontrak_transportasi.is_deleted', 0);
		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->result_array();
    	}
    	return FALSE;
    }

    
    public function findAllDataAsuransi($where = array()){
		$this->db->select("asuransi.*,
			vendor.name as vendor_name
			");
		$this->db->from('asuransi');
		$this->db->join('vendor','vendor.id = asuransi.vendor_id');
        $this->db->like($where);
        $this->db->where('asuransi.is_deleted', 0);
		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->result_array();
    	}
    	return FALSE;
    }
    
    public function getMainQuery()
    {
        $this->db->select('vendor.name as vendor_name, asuransi.*, amandemen_asuransi.no_amandemen as no_amandemen
        , IFNULL(amandemen_asuransi.start_contract, asuransi.start_date) as start_contract2
        , IFNULL(amandemen_asuransi.end_contract, asuransi.end_date) as end_date2
        , IFNULL(amandemen_asuransi.nilai_asuransi, asuransi.nilai_asuransi) as nilai_asuransi2
        , IFNULL(amandemen_asuransi.jenis_asuransi, asuransi.jenis_asuransi) as jenis_asuransi2')
        ->from('asuransi')
        ->join('vendor', 'vendor.id = asuransi.vendor_id')
        ->join('amandemen_asuransi', 'amandemen_asuransi.id = asuransi.last_amandemen_id', 'left');
    }
    

}
