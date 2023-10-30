<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Forecast_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

    function getForCSVForecast($where = [])
    {
		$this->db->select("product.id as product_id,
		CONCAT(product.name,' ',specification.name,' ',size.name) as full_name,
		vendor.name as vendor_name,
		product.name as name,
		uoms.name as uom_name,
		vendor.address as vendor_address");
		$this->db->from('product_forecast');
		$this->db->join('product_forecast_detail', 'product_forecast.id = product_forecast_detail.product_forecast_id');
		$this->db->join('product','product.id = product_forecast_detail.product_id');
		$this->db->join('uoms','uoms.id = product.uom_id');
		$this->db->join('vendor','vendor.id = product.vendor_id');
		$this->db->join('size','size.id = product.size_id');
		$this->db->join('specification','specification.id = product.specification_id');
		$this->db->where($where);
	   	$result = $this->db->get();
		//die($this->db->last_query());
	    if($result->num_rows()>0)
	    {
	        return $result->result();
	    }
	    else
	    {
	        return null;
	    }
    }

	public function insert($data){
		$this->db->insert('product_forecast', $data);
		return $this->db->insert_id();
	}

	public function update($data,$where){
		$this->db->update('product_forecast', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where){
		$this->db->where($where);
		$this->db->delete('product_forecast');
		if($this->db->affected_rows()){
			return TRUE;
		}
		return FALSE;
	}

	public function getCountAllBy($limit,$start,$search,$order,$dir,$where = [])
	{
		// $this->db->select("*")->from("product_forecast");
        $this->db->select("*")->from("forecast");
	   	if(!empty($search)){
    		foreach($search as $key => $value){
				$this->db->or_like($key,$value);
			}
    	}
		$this->db->where($where);
        $result = $this->db->get();
        return $result->num_rows();
	}

	public function getAllBy($limit,$start,$search,$col,$dir,$where = [])
	{
		// $this->db->select("*")->from("product_forecast");
        $this->db->select("forecast.*, category.name as category_name")->from("forecast");
        $this->db->join('category','category.id = forecast.category_id','left');
	   	if(!empty($search)){
    		foreach($search as $key => $value){
				$this->db->or_like($key,$value);
			}
    	}
		$this->db->order_by($col,$dir);
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

	public function findforecast($where = array()){
		$this->db->select("product_forecast.*");
		$this->db->from('product_forecast');
		$this->db->where($where);
		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->row();
    	}
    	return FALSE;
	}


    public function findforecast_new($where = array()){
        $this->db->select("forecast.*");
        $this->db->from('forecast');
        $this->db->where($where);
        $query = $this->db->get();
        if ($query->num_rows() >0){
            return $query->row();
        }
        return FALSE;
    }

    public function insert_new($data){
        $this->db->insert('forecast', $data);
        return $this->db->insert_id();
    }

    public function insert_new_detail($data){
        $this->db->insert('forecast_detail', $data);
        return $this->db->insert_id();
    }

    public function findforecast_detail($where = array()){
        $this->db->select("forecast_detail.*");
        $this->db->from('forecast_detail');
        $this->db->join('forecast','forecast.id = forecast_detail.forecast_id','left');
        $this->db->where($where);
		$this->db->order_by('forecast_detail.forecast_id','desc');
        $query = $this->db->get();
        if ($query->num_rows() >0){
            return $query->row();
        }
        return FALSE;
    }

    public function update_detail($data,$where){
        $this->db->update('forecast_detail', $data, $where);
        return $this->db->affected_rows();
    }

}
