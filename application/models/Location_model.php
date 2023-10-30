<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Location_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function getAllById($where = array())
	{
		$this->db->select("location.*")->from("location");
		$this->db->where($where);
		$this->db->where("location.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}

	public function getAllById2($where = array())
	{
		$this->db->select("ref_locations.*")->from("ref_locations");
		$this->db->where($where);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}
	public function getOneBy($where = array())
	{
		$this->db->select("location.*")->from("location");
		$this->db->where($where);
		$this->db->where("location.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return FALSE;
	}
	public function getOneBy2($where = array())
	{
		$this->db->select("ref_locations.*")->from("ref_locations");
		$this->db->where($where);
		$this->db->where("level in (2,3)", null);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return FALSE;
	}
	public function insert($data)
	{
		$this->db->insert('location', $data);
		return $this->db->insert_id();
	}

	public function update($data, $where)
	{
		$this->db->update('location', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where)
	{
		$this->db->where($where);
		$this->db->delete('location');
		if ($this->db->affected_rows()) {
			return TRUE;
		}
		return FALSE;
	}

	function getAllBy($limit = null, $start = null, $search = null, $col = null, $dir = null, $where = array())
	{
		$this->db->select("location.*")->from("location");
		$this->db->limit($limit, $start)->order_by($col, $dir);
		if (!empty($search)) {
			$this->db->group_start();
			foreach ($search as $key => $value) {
				$this->db->or_like($key, $value);
			}
			$this->db->group_end();
		}
		$this->db->where($where);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result();
		} else {
			return null;
		}
	}

	function getCountAllBy($limit = null, $start = null, $search = null, $col = null, $dir = null, $where = array())
	{

		$this->db->select("location.*")->from("location");
		if (!empty($search)) {
			$this->db->group_start();
			foreach ($search as $key => $value) {
				$this->db->or_like($key, $value);
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

		if ($drop_pertama !== NULL) {
			$data_dropdown[""] = $drop_pertama;
		}

		$query = $this->db->where($where)->get('location')->result();
		foreach ($query as $v) {
			$data_dropdown[$v->$value] = $v->$label;
		}

		return $data_dropdown;
	}

	public function get_dropdown2($where = [], $drop_pertama = NULL, $value = 'location_id', $label = 'full_name')
	{
		$data_dropdown = [];

		if ($drop_pertama !== NULL) {
			$data_dropdown[""] = $drop_pertama;
		}

		$query = $this->db->where($where)->get('ref_locations')->result();
		foreach ($query as $v) {
			$data_dropdown[$v->$value] = $v->$label;
		}

		return $data_dropdown;
	}

	public function getAllLocationArr()
	{
		$dataReturn = [];
		$q = $this->getAllById();
		if ($q !== FALSE) {
			foreach ($q as $key => $value) {
				$dataReturn[$value->id] = $value->name;
			}
		}

		return $dataReturn;
	}
	public function getAllLocationArr2()
	{
		$dataReturn = [];
		$whereLocation = ['level in (2,3)' => null];
		$q = $this->getAllById2($whereLocation);
		if ($q !== FALSE) {
			foreach ($q as $key => $value) {
				$dataReturn[$value->location_id] = $value->full_name;
			}
		}

		return $dataReturn;
	}

	public function getAllSort()
	{
		$this->db->select("location.*")->from("location");
		$this->db->order_by('CAST(id as CHAR)');
		$this->db->where("location.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}
	public function getAllSort2()
	{
		$this->db->select("ref_locations.*")->from("ref_locations");
		//$this->db->order_by('CAST(location_id as CHAR)');
		$this->db->where("level in (2,3)", null);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}

	public function getAllLocationArrName()
	{
		$dataReturn = [];
		$q = $this->getAllById2(['level in (2,3)' => null]);
		if ($q !== FALSE) {
			foreach ($q as $key => $value) {
				$dataReturn[$value->full_name] = $value->location_id;
			}
		}

		return $dataReturn;
	}
}
