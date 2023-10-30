<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Vendor_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_vendor_chat_not_from_PO($not_in, $user_id)
	{
		$where_not_in = "";
		if (!empty($not_in)) {
			$where_not_in = "AND vendor_id NOT IN (" . implode(',', $not_in) . ")";
		}

		$sql = "SELECT a.vendor_id, v.name FROM room_chat a
		INNER JOIN
		(
		SELECT COUNT(*) as count, room_chat_id FROM room_chat_detail a
		GROUP BY room_chat_id
		) detail
		ON a.id = detail.room_chat_id
		INNER JOIN vendor v
		ON v.id = a.vendor_id
		WHERE a.user_id = '$user_id'
		$where_not_in";

		$query = $this->db->query($sql);
		return $query->result();
	}

	public function get_all_scm_vendor()
	{
		$ret = [];
		$query = $this->db->where('scm_id IS NOT NULL', NULL)->get('vendor');

		foreach ($query->result() as $v) {
			$ret[$v->id] = $v->scm_id;
		}

		return $ret;
	}

	public function getvendor($where = array())
	{
		$this->db->select("vendor.*");
		$this->db->from('vendor');
		$this->db->where($where);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}

	public function api_getvendor($limit, $start, $where = array())
	{
		$this->db->select("vendor.*");
		$this->db->from('vendor');
		$this->db->where($where);
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}

	public function findvendor($where = array())
	{
		$this->db->select("vendor.*");
		$this->db->from('vendor');
		$this->db->where($where);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return FALSE;
	}
	public function insert($data)
	{
		$this->db->insert('vendor', $data);
		return $this->db->insert_id();
	}

	public function update($data, $where)
	{
		$this->db->update('vendor', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where)
	{
		$this->db->where($where);
		$this->db->delete('vendor');
		if ($this->db->affected_rows()) {
			return TRUE;
		}
		return FALSE;
	}

	function getAllBy($limit, $start, $search, $col, $dir, $where = array())
	{
		$this->db->select("vendor.*, users.email as users_vendor_email");
		$this->db->from('vendor');
		$this->db->join('users', 'users.vendor_id = vendor.id', 'left');
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

	function getCountAllBy($limit, $start, $search, $order, $dir, $where = array())
	{

		$this->db->select("COUNT(*) as Total")->from("vendor");
		$this->db->join('users', 'users.vendor_id = vendor.id', 'left');
		if (!empty($search)) {
			$this->db->group_start();
			foreach ($search as $key => $value) {
				$this->db->or_like($key, $value);
			}
			$this->db->group_end();
		}
		$this->db->where($where);
		$result = $this->db->get();
		$total_data = $result->row();
		return (isset($total_data->Total)) ? $total_data->Total : '0';
	}

	function getVendorFromArray($array_id = [], $where = [])
	{
		$this->db->select("vendor.*");
		$this->db->from('vendor');
		if ($array_id) {
			$this->db->where_in('vendor.id', $array_id);
		}
		$this->db->where($where);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}

	public function get_dropdown($where = [], $drop_pertama = NULL, $value = 'id', $label = 'name')
	{
		$data_dropdown = [];

		if ($drop_pertama !== NULL) {
			$data_dropdown[""] = $drop_pertama;
		}

		$query = $this->db->where($where)->get('vendor')->result();
		foreach ($query as $v) {
			$data_dropdown[$v->$value] = $v->$label;
		}

		return $data_dropdown;
	}
	public function getAllById($where = array())
	{
		$this->db->select("vendor.*")->from("vendor");
		$this->db->where($where);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}
	public function getAllVendorArrName()
	{
		$dataReturn = [];
		$q = $this->getAllById(['is_deleted' => 0]);
		if ($q !== FALSE) {
			foreach ($q as $key => $value) {
				$dataReturn[$value->name] = $value->id;
			}
		}

		return $dataReturn;
	}
}
