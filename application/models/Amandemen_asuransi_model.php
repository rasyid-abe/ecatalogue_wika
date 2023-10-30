<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Amandemen_asuransi_model extends MY_Model
{
    protected $table = 'amandemen_asuransi';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_scm_amandemen()
    {
		$ret = [];
		$query = $this->db->where('scm_id IS NOT NULL', NULL)->get('amandemen_asuransi');

		foreach ($query->result() as $v)
		{
			$ret[$v->id] = $v->scm_id;
		}

		return $ret;
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
            $this->db->group_start();
            foreach($search as $key => $value){
                $this->db->like($key,$value);
            }
            $this->db->group_end();
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
            $this->db->group_start();
            foreach($search as $key => $value){
                $this->db->or_like($key,$value);
            }
            $this->db->group_end();
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

    public function getMainQuery()
    {
        $this->db->select("amandemen_asuransi.*, 
            asuransi.no_contract as no_contract,
            asuransi.tgl_kontrak as tgl_kontrak,
            asuransi.start_date as start_date,
            asuransi.end_date as end_date,
            vendor.name as vendor_name
            ")
        ->from('amandemen_asuransi')
        ->join('asuransi', 'asuransi.id = amandemen_asuransi.id_asuransi','left')
        ->join('vendor', 'vendor.id = asuransi.vendor_id','left');

    }

    public function get_no_amandemen_terakhir($id_asuransi)
    {
        $query = $this->db->select('MAX(no_amandemen) as no_amandemen')
                          ->where('id_asuransi', $id_asuransi)
                          ->get('amandemen_asuransi');

        return $query->row();
    }

    public function get_detail($where = [])
    {
        $this->db->select("amandemen_asuransi.*, 
            asuransi.no_contract as no_contract,
            asuransi.tgl_kontrak as tgl_kontrak,
            asuransi.start_date as start_date,
            asuransi.end_date as end_date,
            vendor.name as vendor_name
            ")
        ->from('amandemen_asuransi')
        ->join('asuransi', 'asuransi.id = amandemen_asuransi.id_asuransi','left')
        ->join('vendor', 'vendor.id = asuransi.vendor_id','left')
        // ->join('users', 'users.id = amandemen_asuransi.user_pemantau_id','left')
        // ->join('groups', 'groups.id = amandemen_asuransi.departemen_pemantau_id','left')
        ->where($where);

        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            return $query->row();
        }

        return FALSE;

    }

    
}
