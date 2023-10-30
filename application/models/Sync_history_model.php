<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sync_history_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function getAllById($where = array()){
		$this->db->select("sync_history.*")->from("sync_history");
		$this->db->where($where);
		// $this->db->where("is_deleted",0);

		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->result();
    	}
    	return FALSE;
	}
	public function getOneBy($where = array()){
		$this->db->select("sync_history.*")->from("sync_history");
		$this->db->where($where);
		// $this->db->where("is_deleted",0);

		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->row();
    	}
    	return FALSE;
	}
	public function insert($data){
		$this->db->insert('sync_history', $data);
		return $this->db->insert_id();
	}

	public function update($data,$where){
		$this->db->update('sync_history', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where){
		$this->db->where($where);
		$this->db->delete('sync_history');
		if($this->db->affected_rows()){
			return TRUE;
		}
		return FALSE;
	}

	function getAllBy($limit = null,$start= null,$search= null,$col= null,$dir= null,$where=array())
    {
    	$this->db->select("sync_history.*, sync_code.sync_name as sync_name")
		->from("sync_history")
		->join("sync_code", 'sync_code.id = sync_history.sync_code_id');
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

		$this->db->select("sync_history.*, sync_code.sync_name as sync_name")
		->from("sync_history")
		->join("sync_code", 'sync_code.id = sync_history.sync_code_id');
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

	function get_last_sync($sync)
	{
		date_default_timezone_set('Asia/Jakarta');

		$sql = "
			SELECT * FROM sync_history WHERE sync_code_id = $sync
			ORDER BY created_at DESC LIMIT 1
		";

		$history = $this->db->query($sql)->row();
		$sync_name = $this->db->get_where('sync_code', ['id' => $sync])->row('sync_name');
		$minutes = (time() - strtotime($history->created_at)) / 60;

		if ($minutes < 15) {
			if ($history->sync_all > 0) {
				$result = [
					'status' => 1,
					'msg' => $sync_name.' sudah disinkronisasi.',
				];
			} else {
				$result = [
					'status' => 0,
					'msg' => 'Harus sinkronisasi semua data '.$sync_name.' terlebih dahulu.',
				];
			}
		} else {
			$result = [
				'status' => 0,
				'msg' => 'Harus sinkronisasi '.$sync_name.' terlebih dahulu.',
			];
		}

		return $result;
	}
}
