<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Vendor_lokasi_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function getAllById($where = array()){
		$this->db->select("*")->from("vendor_lokasi");
		$this->db->where($where);
		$this->db->where("vendor_lokasi.is_deleted",0);

		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->result();
    	}
    	return FALSE;
	}
	public function getOneBy($where = array()){
		$this->db->select("*")->from("vendor_lokasi");
		$this->db->where($where);
		$this->db->where("vendor_lokasi.is_deleted",0);

		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->row();
    	}
    	return FALSE;
	}
	public function insert($data){
		$this->db->insert_batch('vendor_lokasi', $data);
		return $this->db->insert_id();
	}

	public function update($data,$where){
		$this->db->update('vendor_lokasi', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where){
		$this->db->where($where);
		$this->db->delete('vendor_lokasi');
		if($this->db->affected_rows()){
			return TRUE;
		}
		return FALSE;
	}

	function getAllBy($limit = null,$start= null,$search= null,$col= null,$dir= null,$where=array())
    {
    	$this->db->select("
    		vendor_lokasi.is_deleted as is_deleted,
    		vendor_lokasi.vendor_id as vendor_id,
    		vendor_lokasi.kota_name as kota_name,
    		vendor_lokasi.wilayah_name as wilayah_name,
    		vendor.name as nama_vendor,
    		 GROUP_CONCAT(wilayah_name) as wilayah_name2")->from("vendor_lokasi");
    	$this->db->group_by("vendor_id","is_deleted");
    	$this->db->join('vendor','vendor.id = vendor_lokasi.vendor_id');
    	$this->db->limit($limit,$start)->order_by($col,$dir) ;
    	if(!empty($search)){
    		$this->db->group_start();
    		foreach($search as $key => $value){
				$this->db->or_like($key,$value);
			}
    		$this->db->group_end();
    	}
    	$this->db->where($where);
       	$result = $this->db->get();
        if($result->num_rows()>0)
        {
            return $result->result();
        }
        else
        {
            return null;
        }
    }

    function getCountAllBy($limit = null,$start= null,$search= null,$col= null,$dir= null,$where=array())
    {

    	$this->db->select("vendor_lokasi.is_deleted as is_deleted, vendor_lokasi.vendor_id as vendor_id,  vendor.name as nama_vendor")->from("vendor_lokasi");
    	$this->db->group_by("vendor_id");
    	$this->db->join('vendor','vendor.id = vendor_lokasi.vendor_id');
	   	if(!empty($search)){
    		$this->db->group_start();
    		foreach($search as $key => $value){
				$this->db->or_like($key,$value);
			}
    		$this->db->group_end();
    	}
		$this->db->where($where);
        $result = $this->db->get();

        return $result->num_rows();
    }

	function getArrLocationVendor($whereIn = [])
	{
		$ret = [];
		$this->db->where_in('vendor_id', $whereIn)->from('vendor_lokasi');
		$query = $this->db->get();
		foreach ($query->result() as $key => $value)
		{
			$ret[$value->vendor_id][] = $value->wilayah_id;
		}

		return $ret;
	}
}
