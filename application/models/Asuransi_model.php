<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Asuransi_model extends MY_Model
{
    protected $table = 'asuransi';

    public function __construct()
    {
        parent::__construct();
    }

    public function getMainQuery()
    {
        $this->db->select('vendor.name as vendor_name, asuransi.*, amandemen_asuransi.no_amandemen as no_amandemen
        , IFNULL(amandemen_asuransi.start_contract, asuransi.start_date) as start_contract2
        , IFNULL(amandemen_asuransi.end_contract, asuransi.end_date) as end_date2
        , IFNULL(amandemen_asuransi.nilai_asuransi, asuransi.nilai_asuransi) as nilai_asuransi2
        , IFNULL(amandemen_asuransi.jenis_asuransi, asuransi.jenis_asuransi) as jenis_asuransi2')
        ->from('asuransi')
        ->join('vendor', 'vendor.id = asuransi.vendor_id')
        ->join('amandemen_asuransi', 'amandemen_asuransi.id = asuransi.last_amandemen_id', 'left');
    }

    function getAllBy($limit,$start,$search,$col,$dir,$where=[], $where_and = [])
    {
        if( ! method_exists($this, 'getMainQuery') )
        {
            $this->db->select("*")
                     ->from($this->table);
        }
        else
        {
            $this->getMainQuery();
        }

        if(!empty($search))
        {
            foreach($search as $key => $value){
                $this->db->or_like($key,$value);
            }
        }

        if(!empty($where_and))
        {
            $this->db->group_start();
            foreach($where_and as $key => $value){
                $this->db->like($key,$value);
            }
            $this->db->group_end();
        }

        $this->db->where($where);

        $this->db->limit($limit, $start);
        $this->db->order_by($col, $dir);

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

    function getCountAllBy($limit,$start,$search,$order,$dir,$where=[], $where_and = [])
    {
        if( ! method_exists($this, 'getMainQuery') )
        {
            $this->db->select("*")
                     ->from($this->table);
        }
        else
        {
            $this->getMainQuery();
        }

        if(!empty($search))
        {
            foreach($search as $key => $value){
                $this->db->or_like($key,$value);
            }
        }

        if(!empty($where_and))
        {
            $this->db->group_start();
            foreach($where_and as $key => $value){
                $this->db->like($key,$value);
            }
            $this->db->group_end();
        }

        $this->db->where($where);

        $result = $this->db->get();

        return $result->num_rows();
    }

    public function getAllById($where = array(), $where_in = []){
		$this->db->select("*")->from($this->table);
		$this->db->where($where);
        if (!empty($where_in))
        {
            foreach ($where_in as $k => $v)
            {
                $this->db->where_in($k, $v);
            }
        }

		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->result();
    	}
    	return FALSE;
	}

    public function get_dropdown_asuransi()
    {
        $where = [
            'asuransi.is_deleted'                                               => 0,
            'IFNULL(amandemen_asuransi.start_contract, asuransi.start_date) <=' => date('Y-m-d'),
            'IFNULL(amandemen_asuransi.end_contract, asuransi.end_date) >='     => date('Y-m-d'),
        ];
        $this->db->select('asuransi.id , vendor.name as vendor_name, asuransi.no_contract, amandemen_asuransi.no_amandemen as no_amandemen
        , IFNULL(amandemen_asuransi.start_contract, asuransi.start_date) as start_contract
        , IFNULL(amandemen_asuransi.end_contract, asuransi.end_date) as end_date
        , IFNULL(amandemen_asuransi.nilai_asuransi, asuransi.nilai_asuransi) as nilai_asuransi
        , IFNULL(amandemen_asuransi.jenis_asuransi, asuransi.jenis_asuransi) as jenis_asuransi')
        ->from('asuransi')
        ->join('vendor', 'vendor.id = asuransi.vendor_id')
        ->join('amandemen_asuransi', 'amandemen_asuransi.id = asuransi.last_amandemen_id', 'left');

        $this->db->where($where);
        $q = $this->db->get();
        return $q->result();
        // echo $this->db->last_query();
        $dataDropdown = [];
        foreach ($q->result() as $key => $value)
        {
            $dataDropdown[$value->id] = $value->vendor_name . ' (' . $value->no_contract . ')';
        }

        return $dataDropdown;
    }

    public function getHargaByLastAmandemen($where)
    {
        $this->db->select('asuransi.id, asuransi.vendor_id
        , IFNULL(amandemen_asuransi.start_contract, asuransi.start_date) as start_contract
        , IFNULL(amandemen_asuransi.end_contract, asuransi.end_date) as end_date
        , IFNULL(amandemen_asuransi.nilai_asuransi, asuransi.nilai_asuransi) as nilai_asuransi
        , IFNULL(amandemen_asuransi.jenis_asuransi, asuransi.jenis_asuransi) as jenis_asuransi
        , IFNULL(amandemen_asuransi.nilai_harga_minimum, asuransi.nilai_harga_minimum) as nilai_harga_minimum')
        ->from('asuransi')
        ->join('amandemen_asuransi', 'asuransi.last_amandemen_id = amandemen_asuransi.id', 'left')
        ->where($where);
        $query = $this->db->get();
        
        return $query->num_rows() > 0 ? $query->row() : FALSE;
    }

}
