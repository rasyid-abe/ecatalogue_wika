<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order_product_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function getAllById($where = array()){
		$this->db->select("order_product.*")->from("order_product");
		$this->db->where($where);
		$this->db->where("order_product.is_deleted",0);

		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->result();
    	}
    	return FALSE;
	}
	public function getAllDataById($where = array()){
		/*
		$this->db->select("order_product.*,
			vendor.name as vendor_name,
			vendor.start_contract,
			vendor.end_contract,
			vendor.id as vendor_id,
			vendor.email as vendor_email,
			uoms.name as uom_name,
			location.name as location_name,
			specification.name as specification_name,
			tod.name as tod_name,
			size.name as size_name,
			size.default_weight,
			product.volume as product_volume,
			vendor.no_contract as vendor_no_contract,
			CONCAT(product.name,' ',specification.name,' ',size.name) as full_name
			, CONCAT(enum_payment_method.name,' ', payment_method.`day`,' Hari') as payment_method_full
			, payment_product.price as product_price
			");
		$this->db->from('order_product');
		$this->db->join('product','product.id = order_product.product_id');
		$this->db->join('vendor','vendor.id = product.vendor_id');
		$this->db->join('location','location.id = product.location_id');
		$this->db->join('size','size.id = product.size_id');
		$this->db->join('uoms','uoms.id = product.uom_id');
		$this->db->join('specification','specification.id = product.specification_id');
		$this->db->join('tod','tod.id = product.term_of_delivery_id');
		$this->db->join('payment_product','payment_product.product_id = order_product.product_id AND payment_product.payment_id = order_product.payment_method_id');
		$this->db->join('payment_method','payment_product.payment_id = payment_method.id');
		$this->db->join('enum_payment_method','enum_payment_method.id = payment_method.enum_payment_method_id');
		*/

		$this->db->select('order_product.*,
							vendor.name as vendor_name,
							vendor.start_contract,
							vendor.end_contract,
							vendor.id as vendor_id,
							vendor.email as vendor_email,
							vendor.no_contract as vendor_no_contract,
							vendor.address as vendor_address,
							location.name as location_name,
							vendor.ttd_name as vendor_nama_direktur,
							vendor.no_telp as vendor_no_telp,
							vendor.no_fax as vendor_no_fax,
							vendor.ttd_pos as vendor_dir_pos,
							product.code_1,
							sumber_data_pmcs.smbd_code
							')
				 ->from('order_product')
				 ->join('vendor','vendor.id = order_product.vendor_id','left')
				 ->join('product', 'product.id = order_product.product_id')
				 ->join('location', 'product.location_id = location.id', 'left')
				 ->join('sumber_data_pmcs', 'order_product.id_smcb = sumber_data_pmcs.id', 'left');
		$this->db->where($where);
		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->result();
    	}
    	return FALSE;
	}
	public function getBiayaProduct($where = array()){
		$this->db->select("*")
        ->from('order_product')
        ->where($where);
        $query = $this->db->get();
		if ($query->num_rows() >0){
            $total =0;
    		foreach ($query->result() as $t) {
				$price = $t->price * $t->qty * $t->weight;
				$total += $price;

            }
            return $total;
            
    	}
    	return FALSE;
	}
	public function getOneDataById($where = array()){
		$this->db->select("order_product.*,
			vendor.name as vendor_name,
			vendor.id as vendor_id,
			vendor.email as vendor_email,
			vendor.start_contract,
			vendor.end_contract,
			uoms.name as uom_name,
			location.name as location_name,
			specification.name as specification_name,
			tod.name as tod_name,
			size.name as size_name,
			size.default_weight,
			product.volume as product_volume,
			product.price as product_price,
			CONCAT(product.name,' ',specification.name,' ',size.name) as full_name
			");
		$this->db->from('order_product');
		$this->db->join('product','product.id = order_product.product_id');
		$this->db->join('vendor','vendor.id = product.vendor_id');
		$this->db->join('location','location.id = product.location_id');
		$this->db->join('size','size.id = product.size_id');
		$this->db->join('uoms','uoms.id = product.uom_id');
		$this->db->join('specification','specification.id = product.specification_id');
		$this->db->join('tod','tod.id = product.term_of_delivery_id');

		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->row();
    	}
    	return FALSE;
	}
	public function getOneBy($where = array()){
		$this->db->select("order_product.*")->from("order_product");
		$this->db->where($where);
		$this->db->where("order_product.is_deleted",0);

		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->row();
    	}
    	return FALSE;
	}
	public function insert($data){
		$this->db->insert('order_product', $data);
		return $this->db->insert_id();
	}

	public function update($data,$where){
		$this->db->update('order_product', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where){
		$this->db->where($where);
		$this->db->delete('order_product');
		if($this->db->affected_rows()){
			return TRUE;
		}
		return FALSE;
	}

	function getAllBy($limit = null,$start= null,$search= null,$col= null,$dir= null,$where=array())
    {
    	$this->db->select("order_product.*")->from("order_product");
       	$this->db->limit($limit,$start)->order_product_by($col,$dir) ;
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

    	$this->db->select("order_product.*")->from("order_product");
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

    function getmaxcounttoday($where){
    	$this->db->select('count(id) as total');
    	$this->db->from('stored_id');
    	$this->db->where($where);
    	$result = $this->db->get();

        return $result->row();
    }
}
