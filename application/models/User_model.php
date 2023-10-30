<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function is_user_check_pakta($user_id)
	{
		$this->db->limit('1')
		->select("a.id, b.role_id, c.description, c.updated_at , d.created_at , d.id")
		->select("CASE WHEN d.created_at IS NULL THEN 0
		else
		CASE WHEN d.created_at > c.updated_at THEN 1 ELSE 0 END
		 END AS is_check_pakta", FALSE)
 		->from('users as a')
		->join('users_roles as b','b.user_id = a.id')
		->join('pakta_integritas as c','c.role_id =
CASE WHEN (SELECT COUNT(*) FROM pakta_integritas WHERE pakta_integritas.role_id = b.role_id) = 0 THEN 0
ELSE b.role_id END ', 'inner', FALSE)
		->join('log_pakta_integritas as d','d.user_id = a.id')
		->where('a.id', $user_id)
		->order_by('d.id','DESC');

		$query = $this->db->get();
		//die($this->db->last_query());
		if($query->num_rows() == 0)
		{
			return FALSE;
		}
		else
		{
			$row = $query->row();
			return $row->is_check_pakta == 1 ? TRUE : FALSE;
		}
	}

	public function get_all_scm_users()
    {
		$ret = [];
		$query = $this->db->where('scm_id IS NOT NULL', NULL)->get('users');

		foreach ($query->result() as $v)
		{
			$ret[$v->id] = $v->scm_id;
		}

		return $ret;
    }

	public function getDepartmentUser($user_id)
	{
		$this->db->select('groups.id as group_id, groups.name as department_name, groups.general_manager, users.first_name as user_name, groups.ttd')
				 ->from('users')
				 ->join('groups', 'users.group_id = groups.id','left');

		$this->db->where('users.id', $user_id);
		$get = $this->db->get();
		if($get->num_rows() > 0)
		{
			return $get->row();
		}

		return FALSE;
	}

	public function getAllById($where = array()){
		$this->db->select("users.*, roles.id as role_id, roles.name as role_name")->from("users");
    	$this->db->join("users_roles","users.id = users_roles.user_id");
    	$this->db->join("roles","roles.id = users_roles.role_id");
		$this->db->where("users.is_deleted",0);
		$this->db->where("roles.is_deleted",0);

 		$roles_default = array('1');
        // $this->db->where_not_in('roles.id', $roles_default);
		$this->db->where($where);

		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->result();
    	}
    	return FALSE;
	}
	public function insert($data){
		$this->db->insert('users', $data);
		return $this->db->insert_id();
	}

	public function update($data,$where){
		$this->db->update('users', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where){
		$this->db->where($where);
		$this->db->delete('users');
		if($this->db->affected_rows()){
			return TRUE;
		}
		return FALSE;
	}

	function getOneBy($where = array()){
		$this->db->select("users.*, roles.id as role_id, roles.name as role_name")->from("users");
    	$this->db->join("users_roles","users.id = users_roles.user_id");
    	$this->db->join("roles","roles.id = users_roles.role_id");

  		$roles_default = array('1','2');
        // $this->db->where_not_in('roles.id', $roles_default);

		$this->db->where("users.is_deleted",0);
		$this->db->where("roles.is_deleted",0);
		$this->db->where($where);

		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->row();
    	}
    	return FALSE;
	}

	function getOneUserBy($where = array()){
		$this->db->select("users.*, roles.id as role_id, roles.name as role_name")->from("users");
    	$this->db->join("users_roles","users.id = users_roles.user_id");
    	$this->db->join("roles","roles.id = users_roles.role_id");
        $this->db->where('roles.id', 2);

		// $this->db->where("users.is_deleted",0);
		// $this->db->where("roles.is_deleted",0);
		$this->db->where($where);

		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->row();
    	}
    	return FALSE;
	}

	function getOneUserByVendor_id($where = array()){
		$this->db->select("users.*, roles.id as role_id, roles.name as role_name")->from("users");
    	$this->db->join("users_roles","users.id = users_roles.user_id");
    	$this->db->join("roles","roles.id = users_roles.role_id");

		// $this->db->where("users.is_deleted",0);
		// $this->db->where("roles.is_deleted",0);
		$this->db->where($where);

		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->row();
    	}
    	return FALSE;
	}

	function getAllBy($limit,$start,$search,$col,$dir,$where = [])
    {
    	$this->db->select("users.*, roles.name as role_name")->from("users");
    	$this->db->join("users_roles","users.id = users_roles.user_id");
    	$this->db->join("roles","roles.id = users_roles.role_id");
       	$this->db->limit($limit,$start)->order_by($col,$dir) ;
    	if(!empty($search)){
    		foreach($search as $key => $value){
				$this->db->or_like($key,$value);
			}
		}
		$roles_default = array('1');
        //$this->db->where_not_in('roles.id', $roles_default);
		$this->db->where($where);
		$this->db->where("roles.is_deleted",0);
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

    function getCountAllBy($limit,$start,$search,$order,$dir)
    {

    	$this->db->select("users.*, roles.name as role_name")->from("users");
    	$this->db->join("users_roles","users.id = users_roles.user_id");
    	$this->db->join("roles","roles.id = users_roles.role_id");
	   	if(!empty($search)){
    		foreach($search as $key => $value){
				$this->db->or_like($key,$value);
			}
    	}
		$roles_default = array('1');
        $this->db->where_not_in('roles.id', $roles_default);
		$this->db->where("roles.is_deleted",0);
        $result = $this->db->get();

        return $result->num_rows();
    }

    function finddata($where = array()){
		$this->db->select("users.*")->from("users");
		$this->db->where($where);

		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->row();
    	}
    	return FALSE;
	}
}
