<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product_price_history_model extends CI_Model
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
		$this->db->from('product_price_history');
		$this->db->join('product','product.id = product_price_history.product_id');
		$this->db->join('uoms','uoms.id = product.uom_id');
		$this->db->join('vendor','vendor.id = product.vendor_id');
		$this->db->join('size','size.id = product.size_id');
		$this->db->join('specification','specification.id = product.specification_id');
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

	function getCountAllBy($limit,$start,$search,$order,$dir, $where = array())
    {

	  $this->db->select("product.name,
  	  vendor.name as name_vendor,
  	  DATE(product_price_history.created_at) AS tgl,
  	  product_price_history.old_price , product_price_history.new_price,
  	  CONCAT(product.name ,' ', specification.name ,' ', size.name) as fullname
  	  ");
  	  $this->db->from('product_price_history');
  	  $this->db->join('product','product.id = product_price_history.product_id');
  	  $this->db->join('vendor','vendor.id = product.vendor_id');
  	  $this->db->join('size','size.id = product.size_id');
  	  $this->db->join('specification','specification.id = product.specification_id');
  	  $this->db->limit($limit,$start)->order_by($order,$dir) ;
        if(!empty($search)){
            $this->db->group_start();
            foreach($search as $key => $value){
                $this->db->or_like($key,$value);
            }
            $this->db->group_end();
        }
        $this->db->where($where);
        $result = $this->db->get();
        $total_data = $result->row();
        return (isset($total_data->Total)) ? $total_data->Total : '0';
    }

	  function getAllBy($limit,$start,$search,$col,$dir, $where = array())
	  {
	    $this->db->select("product.name,
		vendor.name as name_vendor,
		DATE(product_price_history.created_at) AS tgl,
		product_price_history.old_price , product_price_history.new_price,
	  	CONCAT(product.name ,' ', specification.name ,' ', size.name) as fullname
	    ");
		$this->db->from('product_price_history');
	    $this->db->join('product','product.id = product_price_history.product_id');
		$this->db->join('vendor','vendor.id = product.vendor_id');
	    $this->db->join('size','size.id = product.size_id');
	    $this->db->join('specification','specification.id = product.specification_id');
	   	$this->db->limit($limit,$start)->order_by($col,$dir) ;
	  	if(!empty($search))
		{
	  		$this->db->group_start();
	  		foreach($search as $key => $value)
			{
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

	public function insert($data){
		$this->db->insert('product_price_history', $data);
		return $this->db->insert_id();
	}

	public function update($data,$where){
		$this->db->update('product_price_history', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where){
		$this->db->where($where);
		$this->db->delete('product_price_history');
		if($this->db->affected_rows()){
			return TRUE;
		}
		return FALSE;
	}

}
