<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Location_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function getAllById($where = array()){
		$this->db->select("location.*")->from("location");
		$this->db->like($where);
		$this->db->where("location.is_deleted",0);

		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->result();
    	}
    	return FALSE;
	}
	public function getOneBy($where = array()){
		$this->db->select("location.*")->from("location");
		$this->db->where($where);
		$this->db->where("location.is_deleted",0);

		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->row();
    	}
    	return FALSE;
	}
	public function insert($data){
		$this->db->insert('location', $data);
		return $this->db->insert_id();
	}

	public function update($data,$where){
		$this->db->update('location', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where){
		$this->db->where($where);
		$this->db->delete('location');
		if($this->db->affected_rows()){
			return TRUE;
		}
		return FALSE;
	}

	function getAllBy($limit = null,$start= null,$search= null,$col= null,$dir= null,$where=array())
    {
    	$this->db->select("location.*")->from("location");
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

    	$this->db->select("location.*")->from("location");
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

	public function get_dropdown($where = [], $drop_pertama = NULL, $value = 'id', $label = 'name')
    {
        $data_dropdown = [];

        if($drop_pertama !== NULL)
        {
            $data_dropdown[""] = $drop_pertama;
        }

        $query = $this->db->where($where)->get('location')->result();
        foreach($query as $v)
        {
            $data_dropdown[$v->$value] = $v->$label;
        }

        return $data_dropdown;
    }

	public function getAllLocationArr()
    {
		$dataReturn = [];
		$q = $this->getAllById();
		if ($q !== FALSE)
		{
			foreach ($q as $key => $value)
			{
				$dataReturn[$value->id] = $value->name;
			}
		}

		return $dataReturn;
    }

    public function getAllSort(){
		$this->db->select("location.*")->from("location");
		$this->db->order_by('CAST(id as CHAR)');
		$this->db->where("location.is_deleted",0);

		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->result();
    	}
    	return FALSE;
	}

	public function getAllLocationArrName()
	{
		$dataReturn = [];
		$q = $this->getAllById(['is_deleted' => 0]);
		if ($q !== FALSE)
		{
			foreach ($q as $key => $value)
			{
				$dataReturn[$value->name] = $value->id;
			}
		}

		return $dataReturn;
	}
}
