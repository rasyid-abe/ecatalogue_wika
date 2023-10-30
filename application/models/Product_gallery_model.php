<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Product_gallery_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct(); 
	}  
	public function getAllById($where = array()){
		$this->db->select("product_gallery.*")->from("product_gallery");
		$this->db->where($where); 

		$query = $this->db->get();
		if ($query->num_rows() >0){  
    		return $query->result(); 
    	} 
    	return FALSE;
	}
	public function getOneBy($where = array()){
		$this->db->select("product_gallery.*")->from("product_gallery");
		$this->db->where($where); 

		$query = $this->db->get();
		if ($query->num_rows() >0){  
    		return $query->row(); 
    	} 
    	return FALSE;
	}
	public function insert($data){
		$this->db->insert('product_gallery', $data);
		return $this->db->insert_id();
	}

	public function update($data,$where){
		$this->db->update('product_gallery', $data, $where);
		return $this->db->affected_rows();
	}
	
	public function delete($where){
		$this->db->where($where);
		$this->db->delete('product_gallery'); 
		if($this->db->affected_rows()){
			return TRUE;
		}
		return FALSE;
	}

	function getAllBy($limit = null,$start= null,$search= null,$col= null,$dir= null,$where=array())
    {
    	$this->db->select("product_gallery.*")->from("product_gallery"); 
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

    	$this->db->select("product_gallery.*")->from("product_gallery");
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
}
