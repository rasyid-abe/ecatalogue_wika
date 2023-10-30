<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Forecast_detail_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function insert($data){
		$this->db->insert('product_forecast_detail', $data);
		return $this->db->insert_id();
	}

	public function update($data,$where){
		$this->db->update('product_forecast_detail', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where){
		$this->db->where($where);
		$this->db->delete('product_forecast_detail');
		if($this->db->affected_rows()){
			return TRUE;
		}
		return FALSE;
	}

	public function getCountAllBy($limit,$start,$search,$order,$dir,$where = [])
	{
		$this->db->select("product.id,
		CONCAT(product.name,' ',specification.name,' ',size.name) as full_name,
		vendor.name as vendor_name,
		vendor.address as vendor_address, product_forecast_detail.price ")->from("product_forecast")
        ->join('product_forecast_detail','product_forecast.id = product_forecast_detail.product_forecast_id')
        ->join('product','product.id = product_forecast_detail.product_id')
        ->join('vendor','vendor.id = product.vendor_id')
		->join('size','size.id = product.size_id')
		->join('specification','specification.id = product.specification_id');
	   	if(!empty($search)){
    		foreach($search as $key => $value){
				$this->db->or_like($key,$value);
			}
    	}
		$this->db->where($where);
        $this->db->limit($limit,$start);
        $result = $this->db->get();
        return $result->num_rows();
	}

	public function getAllBy($limit,$start,$search,$col,$dir,$where = [])
	{
		$this->db->select("product.id,
		CONCAT(product.name,' ',specification.name,' ',size.name) as full_name,
		vendor.name as vendor_name,
		vendor.address as vendor_address, product_forecast_detail.price")->from("product_forecast")
        ->join('product_forecast_detail','product_forecast.id = product_forecast_detail.product_forecast_id')
        ->join('product','product.id = product_forecast_detail.product_id')
        ->join('vendor','vendor.id = product.vendor_id')
		->join('size','size.id = product.size_id')
		->join('specification','specification.id = product.specification_id');
	   	if(!empty($search)){
    		foreach($search as $key => $value){
				$this->db->or_like($key,$value);
			}
    	}
		$this->db->where($where);
        $this->db->order_by($col,$dir);
        $this->db->limit($limit,$start);
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

	public function getOneBy($where = array()){
		$this->db->select("product_forecast_detail.*");
		$this->db->from('product_forecast_detail');
		$this->db->where($where);
		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->row();
    	}
    	return FALSE;
	}

	public function getAllById($where = array()){
		$this->db->select("product_forecast_detail.*, CONCAT(product.name,' ',specification.name,' ',size.name) as full_name,");
		$this->db->from('product_forecast_detail');
		$this->db->join('product','product_forecast_detail.product_id = product.id');
		$this->db->join('size','size.id = product.size_id');
		$this->db->join('specification','specification.id = product.specification_id');
		$this->db->where($where);
		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->result();
    	}
    	return FALSE;
	}

    public function getAllByIdWithOrder($where = array(), $col_order,$sort,$having = array()){
        $this->db->select("forecast_detail.*, forecast.category_id
		, STR_TO_DATE(CONCAT(`forecast_detail`.`year`,'-',`month`,'-01'),'%Y-%m-%d') as custom_date
		");
        $this->db->from('forecast_detail');
        $this->db->join('forecast','forecast_detail.forecast_id = forecast.id');
        $this->db->where($where);
        $this->db->order_by($col_order,$sort);
		if($having)
		{
			foreach($having as $v)
			{
				$this->db->having($v);
			}
		}
        $query = $this->db->get();
		//echo $this->db->last_query();
        if ($query->num_rows() >0){
            return $query->result();
        }
        return FALSE;
    }

    public function getforecast_detail($where = array()){
        $this->db->select("forecast_detail.*, category.name as category_name");
        $this->db->from('forecast_detail');
        $this->db->join('forecast','forecast.id = forecast_detail.forecast_id','left');
		$this->db->join('category','forecast.category_id = category.id','left');
        $this->db->where($where);
        $query = $this->db->get();
        if ($query->num_rows() >0){
            return $query->result();
        }
        return FALSE;
    }

}
