<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Area_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct(); 
	}  
	public function getAllById($where = array()){
		$this->db->select("area.*")->from("area");
		$this->db->where($where); 
		// $this->db->where("is_deleted",0); 

		$query = $this->db->get();
		if ($query->num_rows() >0){  
    		return $query->result(); 
    	} 
    	return FALSE;
	}
	public function getOneBy($where = array()){
		$this->db->select("area.*")->from("area");
		$this->db->where($where); 
		// $this->db->where("is_deleted",0); 

		$query = $this->db->get();
		if ($query->num_rows() >0){  
    		return $query->row(); 
    	} 
    	return FALSE;
	}
	public function insert($data){
		$this->db->insert('area', $data);
		return $this->db->insert_id();
	}

	public function update($data,$where){
		$this->db->update('area', $data, $where);
		return $this->db->affected_rows();
	}
	
	public function delete($where){
		$this->db->where($where);
		$this->db->delete('area'); 
		if($this->db->affected_rows()){
			return TRUE;
		}
		return FALSE;
	}

	function getAllBy($limit = null,$start= null,$search= null,$col= null,$dir= null,$where=array())
    {
    	$this->db->select("area.*")->from("area"); 
       	$this->db->limit($limit,$start)->order_by($col,$dir) ;
    	if(!empty($search)){
    		foreach($search as $key => $value){
				$this->db->or_like($key,$value);	
			} 	
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

    	$this->db->select("area.*")->from("area");
	   	if(!empty($search)){
    		foreach($search as $key => $value){
				$this->db->or_like($key,$value);	
			} 	
    	} 
		$this->db->where($where); 
        $result = $this->db->get();
    
        return $result->num_rows();
    } 
}
