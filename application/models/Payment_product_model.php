<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Payment_product_model extends CI_Model
{
	protected $table = "payment_product";
	public function __construct()
	{
		parent::__construct();
	}

	protected function getTable()
	{
		return $this->table;
	}

	public function getAllById($where = array(), $where_in = [])
	{
		$this->db->select($this->getTable() . ".*, CONCAT(enum_payment_method.name,' ',payment_method.day,' hari') as full_name, ref_locations.full_name as location_name")->from($this->getTable());
		$this->db->join('payment_method', 'payment_method.id = ' . $this->getTable() . '.payment_id', 'left');
		$this->db->join('enum_payment_method', 'enum_payment_method.id = payment_method.enum_payment_method_id', 'left');
		$this->db->join('ref_locations', 'ref_locations.location_id = payment_product.location_id', 'left');
		$this->db->where($where);

		if ($where_in) {
			foreach ($where_in as $k => $v)
				$this->db->where_in($k, $v);
		}


		$query = $this->db->get();
		//die($this->db->last_query());
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}
	public function getOneBy($where = array(), $where_in = [])
	{

		$this->db->select($this->getTable() . ".*, CONCAT(enum_payment_method.name,' ',payment_method.day,' hari') as full_name ")->from($this->getTable());
		$this->db->join('payment_method', 'payment_method.id = ' . $this->getTable() . '.payment_id', 'left');
		$this->db->join('enum_payment_method', 'enum_payment_method.id = payment_method.enum_payment_method_id', 'left');
		$this->db->where($where);

		if ($where_in) {
			foreach ($where_in as $k => $v)
				$this->db->where_in($k, $v);
		}


		$query = $this->db->get();
		//die($this->db->last_query());
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return FALSE;
	}
	public function insert($data)
	{
		$this->db->insert($this->getTable(), $data);
		return $this->db->insert_id();
	}

	public function update($data, $where)
	{
		$this->db->update($this->getTable(), $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where)
	{
		$this->db->where($where);
		$this->db->delete($this->getTable());
		if ($this->db->affected_rows()) {
			return TRUE;
		}
		return FALSE;
	}

	function getAllBy($limit = null, $start = null, $search = null, $col = null, $dir = null, $where = array())
	{
		return FALSE;
	}

	function getCountAllBy($limit = null, $start = null, $search = null, $col = null, $dir = null, $where = array())
	{

		return FALSE;
	}
}
