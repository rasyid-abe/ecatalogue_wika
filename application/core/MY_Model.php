<?php
defined('BASEPATH') OR exit('No direct script access allowed');
abstract class MY_Model extends CI_Model
{
    protected $table = '';

    function __construct()
    {
        parent::__construct();
        if($this->table == '') exit('Table '.get_class($this).' Belum diset');
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

    public function getAllById($where = array()){
		$this->db->select("*")->from($this->table);
		$this->db->where($where);
		// $this->db->where("is_deleted",0);

		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->result();
    	}
    	return FALSE;
	}

	public function getOneBy($where = array()){
		$this->db->select("*")->from($this->table);
		$this->db->where($where);
		// $this->db->where("is_deleted",0);

		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->row();
    	}
    	return FALSE;
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

    public function get_dropdown($where = [], $drop_pertama = NULL, $value = 'id', $label = 'name')
    {
        $data_dropdown = [];

        if($drop_pertama !== NULL)
        {
            $data_dropdown[""] = $drop_pertama;
        }

        $query = $this->db->where($where)->get($this->table)->result();
        foreach($query as $v)
        {
            $data_dropdown[$v->$value] = $v->$label;
        }

        return $data_dropdown;
    }

}
