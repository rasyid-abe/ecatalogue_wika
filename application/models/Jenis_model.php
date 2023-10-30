<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Jenis_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function getAllById(){
		$this->db->select("jenis.*")->from("jenis");
		//$this->db->where($where);
		$this->db->where("is_deleted",0);

		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->result();
    	}
    	return FALSE;
	}
	public function getOneBy($where = array()){
		$this->db->select("jenis.*")->from("jenis");
		$this->db->where($where);
		// $this->db->where("is_deleted",0);

		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->row();
    	}
    	return FALSE;
	}
	public function insert($data){
		$this->db->insert('jenis', $data);
		return $this->db->insert_id();
	}

	public function update($data,$where){
		$this->db->update('jenis', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where){
		$this->db->where($where);
		$this->db->delete('jenis');
		if($this->db->affected_rows()){
			return TRUE;
		}
		return FALSE;
	}

	function getAllBy($limit = null,$start= null,$search= null,$col= null,$dir= null,$where=array())
    {
    	$this->db->select("jenis.*")->from("jenis");
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
	
	function getAllBy2($limit = null,$start= null,$search= null,$col= null,$dir= null,$where=array())
    {
		$this->db->select("jenis.*, j2.name as jenis_name2");
		$this->db->from("jenis");
		$this->db->join('jenis j2', 'j2.id = jenis.parent_id', 'left');
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

    	$this->db->select("jenis.*")->from("jenis");
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
	function getCountAllBy2($limit = null,$start= null,$search= null,$col= null,$dir= null,$where=array())
    {

		$this->db->select("jenis.*, j2.name as jenis_name2")->from("jenis");
		$this->db->join('jenis j2', 'j2.id = jenis.parent_id', 'left');
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

	public function get_dropdown($where = [])
    {
        $data_dropdown = [];

        $query = $this->db->select('name, id')->where($where)->get('jenis')->result();
        foreach($query as $v)
        {
            $data_dropdown[$v->id] = $v->name;
        }

        return $data_dropdown;
    }
}
