<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Specification_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function getAllById($where = array()){
		$this->db->select("specification.*")->from("specification");
		$this->db->where($where);
		$this->db->where("specification.is_deleted",0);

		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->result();
    	}
    	return FALSE;
	}
	public function getOneBy($where = array()){
		$this->db->select("specification.*")->from("specification");
		$this->db->where($where);
		$this->db->where("specification.is_deleted",0);

		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->row();
    	}
    	return FALSE;
	}
	public function insert($data){
		$this->db->insert('specification', $data);
		return $this->db->insert_id();
	}

	public function update($data,$where){
		$this->db->update('specification', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where){
		$this->db->where($where);
		$this->db->delete('specification');
		if($this->db->affected_rows()){
			return TRUE;
		}
		return FALSE;
	}

	function getAllBy($limit = null,$start= null,$search= null,$col= null,$dir= null,$where=array())
    {
    	$this->db->select("specification.*, category.name as category_name")->from("specification")
		->join('category','category.id = specification.category_id','left');
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

    	$this->db->select("specification.*, category.name as category_name")->from("specification")
		->join('category','category.id = specification.category_id','left');;
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

	function getSpecWithCat($where=[])
	{
		$this->db->select("specification.*, category.name as category_name, category.id as category_id, category.code as category_code ")
				 ->from('specification')
				 ->join('category','category.id = specification.category_id');

        if($where)
		{
			$this->db->where($where);
		}

		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}

		return FALSE;
	}
}
