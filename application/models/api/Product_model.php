<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_volume_products_on_amandemen_or_project($id_product)
	{

		$ret = [];
		// cek di amandemen dulu
		$sql = "SELECT `a`.`amandemen_id`, `b`.`id_project` FROM `amandemen_products` `a`
				INNER JOIN (
					SELECT max(`a`.`no_amandemen`) as no_amandemen, max(`a`.`id`) as id, `a`.`id_project`
					FROM `amandemen` `a`
					GROUP BY `a`.`id_project`
				) `b`
				ON `a`.`amandemen_id` = `b`.`id`
				WHERE `a`.`product_id` = '$id_product'";
		$query = $this->db->query($sql);
		$in = [];
		$not_in = [];
		foreach($query->result() as $v)
		{
			$in[] = $v->amandemen_id;
			$not_in = $v->id_project;
		}

		// cari di amandemen
		if(!empty($in))
		{
			$amandemen = $this->db->select("b.volume_sisa, a.no_amandemen, b.no_contract")
								  ->from("amandemen as a")
								  ->join('project as b', 'a.id_project = b.id')
								  ->where('a.start_contract <= CURRENT_DATE()', NULL, FALSE)
								  ->where('a.end_contract >= CURRENT_DATE()', NULL, FALSE)
								  ->where('b.is_deleted',0)
								  ->where_in('a.id', $in)
								  ->get()
								  ->result();
		}
		else
		{
			$amandemen = [];
		}

		foreach($amandemen as $v)
		{
			$ret[] = [
				'volume' => $v->volume_sisa,
				'no_contract' => $v->no_contract . '-Amd' . $v->no_amandemen,
			];
		}

		 $this->db->select("a.no_contract, a.volume_sisa, a.id")
							->from('project as a')
							->join('project_products as b','a.id = b.project_id')
							->where('a.start_contract <= CURRENT_DATE()', NULL, FALSE)
							->where('a.end_contract >= CURRENT_DATE()', NULL, FALSE)
							->where('b.is_deleted',0)
							->where('a.is_deleted',0)
							->where('b.product_id', $id_product);

		if(!empty($not_in))
		{
			$this->db->where_not_in('a.id', $not_in);
		}

		$project = $this->db->get()->result();

		foreach($project as $v)
		{
			$ret[] = [
				'volume' => $v->volume_sisa,
				'no_contract' => $v->no_contract,
			];
		}

		return $ret;
	}

	public function getArrProductNoKontrak($where_in)
	{
		$this->db->select("a.product_id , b.no_contract , IFNULL(c.no_amandemen, 0) as no_aman")
		->from('project_product_price as a')
		->join('project as b','a.project_id = b.id')
		->join('amandemen as c','c.id = b.last_amandemen_id','left')
		->where('IFNULL(c.start_contract, b.start_contract ) <= CURRENT_DATE ()', NULL, FALSE)
		->where('IFNULL(c.end_contract, b.end_contract ) >= CURRENT_DATE ()', NULL, FALSE)
		->where('a.is_deleted',0)
		->where('b.is_deleted',0)
		->where_in('a.product_id',$where_in)
		->group_by(['a.product_id', 'b.id']);

		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			return $query->result();
		}

		return FALSE;

	}

	public function getProductIDFilterTerkontrak($where_in)
	{
		$this->db->select("a.product_id, b.start_contract , b.end_contract
		, c.start_contract as start2, c.end_contract as end2
		, b.id, c.id")
		->from('project_product_price as a')
		->join('project as b', 'b.id = a.project_id','left')
		->join('amandemen as c', 'c.id = b.last_amandemen_id','left')
		->where('a.is_deleted',0)
		->where('b.is_deleted',0)
		->where('IFNULL(c.start_contract, b.start_contract ) <= CURRENT_DATE ()',NULL,FALSE)
		->where('IFNULL(c.end_contract, b.end_contract ) >= CURRENT_DATE ()',NULL,FALSE)
		->where_in('a.product_id', $where_in)
		->group_by('a.product_id');
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			return $query->result();
		}

		return FALSE;
	}

	public function get_tanggal_kontrak_by_product_id($product_id)
	{
		$this->db->select("MIN(c.start_contract) as start_contract, MAX(c.end_contract) as end_contract,a.product_id ")
				 ->from("project_products as a")
				 ->join("product as b","b.id = a.product_id")
				 ->join("project as c","c.id = a.project_id")
				 ->where('a.is_deleted',0)
				 ->where('c.is_deleted',0)
				 ->where('b.id',$product_id)
				 ->group_by("a.product_id");

		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			return $query->row();
		}

		return FALSE;
	}

	public function getproduct($where = array()){
		$this->db->select("product.*");
		$this->db->from('product');
		$this->db->like($where);
		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->result();
    	}
    	return FALSE;
	}

	public function get_product_with_code($where = array()){
		$this->db->select("a.*");
		$this->db->select("CONCAT(b.code,c.code,d.code,a.code) as full_code");
		$this->db->select("b.name as category");
		$this->db->select("c.name as specification");
		$this->db->select("d.name as size, d.default_weight");
		$this->db->from('product as a');
		$this->db->join('category as b', 'a.category_id = b.id');
		$this->db->join('specification as c', 'a.specification_id = c.id','left');
		$this->db->join('size as d', 'a.size_id = d.id','left');
		$this->db->like($where);
		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->result();
    	}
    	return FALSE;
	}

	public function getAllDataProduct($where = array()){
		$this->db->select("product.*,
			vendor.name as vendor_name,
			vendor.start_contract,
			vendor.end_contract,
			uoms.name as uom_name,
			location.name as location_name,
			specification.name as specification_name,
			tod.name as tod_name,
			size.name as size_name,
			size.default_weight,
			CONCAT(product.code_1,'',product.code,' ',product.name,' ',size.name) as full_name,
			vendor.address as vendor_address,
            product.id as product_id
			");
		$this->db->from('product');
		$this->db->join('vendor','vendor.id = product.vendor_id');
		$this->db->join('location','location.id = product.location_id','left');
		$this->db->join('size','size.id = product.size_id','left');
		$this->db->join('uoms','uoms.id = product.uom_id');
		$this->db->join('specification','specification.id = product.specification_id','left');
		$this->db->join('tod','tod.id = product.term_of_delivery_id','left');
		$this->db->like($where);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
    		return $query->result();
    	}
    	return FALSE;
	}

    public function getAllDataProductOnePicture($where = array(), $where_in = [], $order = [], $limit = 10, $offset= 0, $search = [], $kontrak=array(), $where_users = NULL)
	{

		$join_d = "";
		if ($this->data['is_superadmin'])
		{
			$join_d = "AND CASE WHEN d.amandemen_id IS NULL
			THEN (SELECT start_contract FROM project WHERE project.id = d.project_id) <= CURRENT_DATE ()
			ELSE (SELECT start_contract FROM amandemen WHERE amandemen.id = d.amandemen_id ) <= CURRENT_DATE () END
			AND CASE WHEN d.amandemen_id IS NULL THEN (SELECT end_contract FROM project WHERE project.id = d.project_id) >= CURRENT_DATE ()
			ELSE (SELECT end_contract FROM amandemen WHERE amandemen.id = d.amandemen_id ) >= CURRENT_DATE () END";
		}
		$this->db->select('product.name, product.id
		, vendor.name as vendor_name
		, uoms.name as uom_name
		, MIN(product_gallery.filename) as filename
		, IFNULL(MIN(d.price)
		, IFNULL(MIN(payment_product.price), 0)) as product_min_price')
		->from('product')
		->join('vendor', 'vendor.id = product.vendor_id')
		->join('uoms','uoms.id = product.uom_id')
		->join('product_gallery', 'product_gallery.product_id = product.id', 'left')
		->join('specification','specification.id = product.specification_id','left')
		->join('size','size.id = product.size_id','left')
		->join('category','category.id = product.category_id','left')
		->join('payment_product','product.id = payment_product.product_id','left')
		->join('project_product_price as d', 'd.product_id = product.id AND d.is_deleted = 0 ' . $join_d , 'left', FALSE)
		->where($where);

		if ($where_users != NULL)
		{
			$this->db->join('project', 'project.id = d.project_id','left');
			$this->db->join('amandemen', 'amandemen.id = project.last_amandemen_id','left');
			$this->db->where("CASE WHEN d.project_id IS NULL
			THEN 1 = 1
			ELSE
			$where_users IN (SELECT user_id FROM project_users WHERE project_users.project_id = d.project_id )
			AND CASE WHEN d.amandemen_id IS NULL
			THEN project.start_contract <= CURRENT_DATE ()
			ELSE amandemen.start_contract <= CURRENT_DATE () END
			AND CASE WHEN d.amandemen_id IS NULL
			THEN project.end_contract >= CURRENT_DATE ()
			ELSE amandemen.end_contract >= CURRENT_DATE () END
			END", NULL, FALSE);
		}

		if($kontrak['terkontrak'] != $kontrak['tidak_terkontrak'])
		{
			// maaf klo lieur. kwkwkw
            $in = $kontrak['terkontrak'] ? 'IN' : 'NOT IN';
			/*
			$sql = "SELECT product_id FROM
					(SELECT
					MIN(c.start_contract) as start_contract, MAX(c.end_contract) as end_contract,
					a.product_id
					FROM project_products a
					INNER JOIN product b
					ON b.id = a.product_id
					INNER JOIN project c
					ON c.id = a.project_id
					-- WHERE c.start_contract <= CURRENT_DATE ()
					GROUP BY a.product_id
					HAVING start_contract <= CURRENT_DATE ()
					AND end_contract >= CURRENT_DATE ()
					) A";
			*/
			$sql = "SELECT
						a.product_id
					FROM
						project_product_price a
					LEFT JOIN project b
					ON b.id = a.project_id
					LEFT JOIN
						amandemen c
						ON c.id = b.last_amandemen_id
					WHERE
						a.is_deleted = 0
						AND b.is_deleted = 0
					AND IFNULL(c.start_contract, b.start_contract ) <= CURRENT_DATE ()
					AND IFNULL(c.end_contract, b.end_contract ) >= CURRENT_DATE ()
					GROUP BY product_id ";
			$this->db->where("product.id $in ($sql)",NULL,FALSE);
		}
		// end filter terkontrak / tidak_terkontrak

		if(!empty($where_in))
		{
			foreach($where_in as $key => $val)
			{
				$this->db->where_in($key, $val);
			}
		}
        $this->db->group_by('product.id');
		if(!empty($order))
		{
			foreach($order as $key => $val)
			{
				$this->db->order_by($key, $val);
			}
		}
		if(!empty($search))
		{
	  		$this->db->group_start();
	  		foreach($search as $key => $value)
			{
	  			$this->db->or_like($key,$value);
	  		}
	  		$this->db->group_end();
	  	}
		$this->db->limit($limit,$offset);
        $query = $this->db->get();
		// echo $this->db->last_query();
        if ($query->num_rows() >0){
            return $query->result();
        }
        return FALSE;
    }

	public function findAllDataProduct($where = array()){
		$this->db->select("product.*,
			vendor.name as vendor_name,
			vendor.start_contract,
			vendor.end_contract,
			uoms.name as uom_name,
			location.name as location_name,
			specification.name as specification_name,
			tod.name as tod_name,
			size.name as size_name,
			size.default_weight,
			CONCAT(product.code_1,'',product.code,' ',product.name,' ',IFNULL(size.name,'')) as full_name,
			category.name as category_name,
			category.is_margis
			");
		$this->db->from('product');
		$this->db->join('vendor','vendor.id = product.vendor_id');
		$this->db->join('location','location.id = product.location_id','left');
		$this->db->join('size','size.id = product.size_id','left');
		$this->db->join('uoms','uoms.id = product.uom_id','left');
		$this->db->join('specification','specification.id = product.specification_id','left');
		$this->db->join('category','category.id = product.category_id','left');
		$this->db->join('tod','tod.id = product.term_of_delivery_id','left');
		$this->db->where($where);
		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->row();
    	}
    	return FALSE;
	}

	public function api_getproduct($limit, $start, $where = array()){
		$this->db->select("product.*");
		$this->db->from('product');
		$this->db->where($where);
		$this->db->limit($limit,$start);
		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->result();
    	}
    	return FALSE;
	}

	public function findproduct($where = array()){
		$this->db->select("product.*");
		$this->db->from('product');
		$this->db->where($where);
		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->row();
    	}
    	return FALSE;
	}
	public function insert($data){
		$this->db->insert('product', $data);
		return $this->db->insert_id();
	}

	public function update($data,$where){
		$this->db->update('product', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where){
		$this->db->where($where);
		$this->db->delete('product');
		if($this->db->affected_rows()){
			return TRUE;
		}
		return FALSE;
	}

	function getAllBy($limit,$start,$search,$col,$dir, $where = array())
	{
		$this->db->select("product.*,
		vendor.name as vendor_name,
		vendor.start_contract,
		vendor.end_contract,
		uoms.name as uom_name,
		location.name as location_name,
		specification.name as specification_name,
		tod.name as tod_name,
		size.name as size_name,
		size.default_weight,
		CONCAT(product.code_1,'',product.code,' ',product.name,' ',size.name) as full_name
		, category.name as category_name
		, CONCAT(category.code,'',specification.code,'',size.code) as size_code
		");
		$this->db->from('product');
		$this->db->join('vendor','vendor.id = product.vendor_id');
		$this->db->join('location','location.id = product.location_id','left');
		$this->db->join('size','size.id = product.size_id','left');
		$this->db->join('uoms','uoms.id = product.uom_id');
		$this->db->join('specification','specification.id = product.specification_id','left');
		$this->db->join('tod','tod.id = product.term_of_delivery_id','left');
		$this->db->join('category','category.id = product.category_id');
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

    function getCountAllBy($limit,$start,$search,$order,$dir, $where = array())
	{
		$this->db->select("COUNT(*) as Total")->from("product");
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

    public function getSimilarProduct($search = array(), $where = array(), $limit)
	{

		$this->db->select("product.*,
			vendor.name as vendor_name,
			vendor.start_contract,
			vendor.end_contract,
			uoms.name as uom_name,
			location.name as location_name,
			specification.name as specification_name,
			tod.name as tod_name,
			size.name as size_name,
			size.default_weight,
			CONCAT(product.code_1,'',product.code,' ',product.name,' ',size.name) as full_name
			");
		$this->db->from('product');
		$this->db->join('vendor','vendor.id = product.vendor_id');
		$this->db->join('location','location.id = product.location_id');
		$this->db->join('size','size.id = product.size_id','left');
		$this->db->join('uoms','uoms.id = product.uom_id');
		$this->db->join('specification','specification.id = product.specification_id','left');
		$this->db->join('tod','tod.id = product.term_of_delivery_id','left');
		if(!empty($search)){
    		$this->db->group_start();
    		foreach($search as $key => $value){
				$this->db->or_like($key,$value);
			}
			$this->db->group_end();
    	}
    	$this->db->where($where);
    	$this->db->limit($limit);
		$query = $this->db->get();
		if ($query->num_rows() >0){
    		return $query->result();
    	}
    	return FALSE;
	}

    public function getSimilarProductOnePicture($search = array(), $where = array(), $limit)
	{
        $this->db->select("product.*,
            vendor.name as vendor_name,
            vendor.start_contract,
            vendor.end_contract,
            uoms.name as uom_name,
            location.name as location_name,
            specification.name as specification_name,
            tod.name as tod_name,
            size.name as size_name,
            size.default_weight,
            CONCAT(product.code_1,'',product.code,' ',product.name,' ',size.name) as full_name,
            product_gallery.filename,
						CASE WHEN vendor.end_contract <= DATE(NOW()) THEN 1 ELSE 0 END AS is_end_contract
            ");
        $this->db->from('product');
        $this->db->join('vendor','vendor.id = product.vendor_id');
        $this->db->join('location','location.id = product.location_id');
        $this->db->join('size','size.id = product.size_id','left');
        $this->db->join('uoms','uoms.id = product.uom_id');
        $this->db->join('specification','specification.id = product.specification_id','left');
        $this->db->join('tod','tod.id = product.term_of_delivery_id','left');
        $this->db->join('product_gallery','product_gallery.product_id = product.id','left');
        $this->db->group_by('product.id');
        if(!empty($search)){
            $this->db->group_start();
            foreach($search as $key => $value){
                $this->db->or_like($key,$value);
            }
            $this->db->group_end();
        }
        $this->db->where($where);
        $this->db->limit($limit);
        $query = $this->db->get();
        if ($query->num_rows() >0){
            return $query->result();
        }
        return FALSE;
    }

	public function cek_is_terkontrak($id_product, $return_result = FALSE)
	{
		$where = "";
		if(is_array($id_product))
		{
			if(empty($id_product))
			{
				return FALSE;
			}
			$implode = implode(',', $id_product);
			$where = "AND a.product_id IN ($implode)";
		}
		else
		{
			$where = "AND a.product_id = '$id_product'";
		}

		$sql = "SELECT
					a.product_id, b.id as project_id, b.volume_sisa, c.no_amandemen, b.no_contract, b.tanggal as tgl_contract
				FROM
					project_product_price a
				LEFT JOIN project b
				ON b.id = a.project_id
				LEFT JOIN
					amandemen c
					ON c.id = b.last_amandemen_id
				WHERE
					a.is_deleted = 0
					AND b.is_deleted = 0
				AND IFNULL(c.start_contract, b.start_contract ) <= CURRENT_DATE ()
				AND IFNULL(c.end_contract, b.end_contract ) >= CURRENT_DATE ()
				$where
				GROUP BY product_id";
		$query = $this->db->query($sql);

		if($return_result === FALSE)
		{
			return $query->num_rows() > 0 ? TRUE : FALSE;
		}
		else if($return_result === TRUE)
		{
			return $query->num_rows() > 0 ? $query->result() : FALSE;
		}
		// yang diatas sql nya, fungsi belum berfungsi
	}

	public function get_project_id_pertama_assign_produk_id($product_id)
	{
		// fungsi untuk mencari project pertama yang ngambil product itu, jika ada 2
		$this->db->select("b.id, min(b.created_at) as created_at")
		->from('project_product_price as a')
		->join('project as b', 'b.id = a.project_id')
		->join('amandemen as c', 'c.id = b.last_amandemen_id','left')
		->where('a.is_deleted', 0)
		->where('IFNULL(c.start_contract, b.start_contract ) <= CURRENT_DATE ()', NULL,FALSE)
		->where('IFNULL(c.end_contract, b.end_contract ) >= CURRENT_DATE ()',NULL,FALSE)
		->where('a.product_id', $product_id)
		->group_by('b.id')
		->order_by('b.created_at', 'ASC')
		->limit(1);

		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			return $query->row();
		}

		return FALSE;
	}

	public function getProductByPaymentMethod($where=[])
	{

		$id = $where['product.id'];

		$sql = "SELECT
						a.product_id
					FROM
						project_product_price a
					LEFT JOIN project b
					ON b.id = a.project_id
					LEFT JOIN
						amandemen c
						ON c.id = b.last_amandemen_id
					WHERE
						a.is_deleted = 0
						AND b.is_deleted = 0
					AND IFNULL(c.start_contract, b.start_contract ) <= CURRENT_DATE ()
					AND IFNULL(c.end_contract, b.end_contract ) >= CURRENT_DATE ()
					GROUP BY product_id ";
			

		$this->db->select("CONCAT(IFNULL(product.code_1,''),'',product.code,' ',product.name,' ',IFNULL(size.name,'')) as full_name
							, CONCAT(enum_payment_method.name,' ', payment_method.`day`,' Hari') as payment_method_full
							, enum_payment_method.name
							, payment_method.`day`
							, payment_method.description as payment_description
							, project_product_price.price as product_price
							, uoms.name as uom_name
							, specification.name as specification_name
							, size.name as size_name
							, IFNULL(size.default_weight,1) as default_weight
							, payment_method.id as payment_method_id
							, vendor.name as vendor_name
							, vendor.id as vendor_id
							, CASE WHEN vendor.end_contract <= DATE(NOW()) THEN 1 ELSE 0 END AS is_end_contract
							, product.*
							, location.name as location_name
							, payment_product.location_id as location_id
							, payment_product.notes as notes_payment
							, category.is_margis as is_matgis
							")
				->select("(SELECT filename FROM product_gallery WHERE product_gallery.product_id = product.id ORDER BY id ASC LIMIT 1) as image", FALSE)
				->from('product')
				->join('payment_product','product.id = payment_product.product_id')
				->join('payment_method','payment_method.id = payment_product.payment_id')
				->join('enum_payment_method','enum_payment_method.id = payment_method.enum_payment_method_id','left')
				->join('specification','specification.id = product.specification_id','left')
				->join('size','size.id = product.size_id','left')
				->join('uoms','uoms.id = product.uom_id')
				->join('vendor','vendor.id = product.vendor_id')
				->join('location','location.id = payment_product.location_id','left')
				->join('category','category.id = product.category_id');
			$this->db->join('project_product_price', 'project_product_price.product_id = payment_product.product_id
			AND project_product_price.payment_id = payment_product.payment_id
			AND project_product_price.location_id = payment_product.location_id
			AND project_product_price.is_deleted = 0 ');
		$this->db->like($where);
		$this->db->where("product.id IN ($sql)",NULL,FALSE);
		$this->db->order_by('payment_product.price','ASC');
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}

		return FALSE;
	}

	public function getAllById($where = [])
	{
		$query = $this->db->where($where)
		->get('product');

		return $query->result();
	}

}
