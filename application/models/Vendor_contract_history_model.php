<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Vendor_contract_history_model extends CI_Model
{
    protected $table = 'vendor_contract_history';
	public function __construct()
	{
		parent::__construct();
	}

	public function insert($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($data,$where){
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where){
		$this->db->where($where);
		$this->db->delete($this->table);
		if($this->db->affected_rows()){
			return TRUE;
		}
		return FALSE;
	}

}
