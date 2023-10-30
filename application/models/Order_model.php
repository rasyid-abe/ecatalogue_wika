<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Order_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	function get_revisi_data($order_no)
	{
		$this->db->select("
		od.perihal,
		od.catatan,
		od.shipping_id,
		od.tgl_diambil,
		od.project_id,
		oa.asuransi_id,
		rl.location_id,
		rl.regency_name,
		ai.vendor_id,
		vr.name
			");
		$this->db->from("order od");
		$this->db->join('order_asuransi oa', 'od.order_no = oa.order_no', 'left');
		$this->db->join('asuransi ai', 'oa.asuransi_id = ai.id', 'left');
		$this->db->join('vendor vr', 'ai.vendor_id = vr.id', 'left');
		$this->db->join('project_new pn', 'od.project_id = pn.id', 'left');
		$this->db->join('ref_locations rl', 'pn.location_id = rl.location_id', 'left');
		$this->db->where('od.order_no', $order_no);
		$result = $this->db->get();
		return $result->row_array();
	}

	function getCountAllBy($limit = null, $start = null, $search = null, $col = null, $dir = null, $where = array())
	{
		$role_id = $this->ion_auth->get_users_groups()->row()->id;
		$is_role_approve = $this->_is_role_approve($role_id);

		if ($is_role_approve === FALSE) {
			return $this->getCountAllBy2($limit, $start, $search, $col, $dir, $where);
		}

		$row = $this->getAllBy($limit, $start, $search, $col, $dir, $where);

		return $row === FALSE ? 0 : count($row);
	}

	private function _is_role_approve($role_id)
	{
		$query = $this->db->get_where('approve_po_rules', ['role_id' => $role_id]);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}

	public function getAllBy($limit = null, $start = null, $search = null, $col = null, $dir = null, $where = array())
	{
		$role_id = $this->ion_auth->get_users_groups()->row()->id;
		$is_role_approve = $this->_is_role_approve($role_id);

		if ($is_role_approve === FALSE) {
			return $this->getAllBy2($limit, $start, $search, $col, $dir, $where);
		}

		unset($where['order.created_by']);

		$this->db->select("order.*,
			CONCAT(enum_payment_method.name,' ',payment_method.day,' hari') as full_name,
			shipping.name as shipping_name,
			users.first_name as users_name,
			users.address as users_address,
            order_product.payment_mehod_name,
			project_new.name as project_name
			")
			->select('approve_po_list.role_id AS role_id_approver', FALSE);
		$this->db->from("order");
		$this->db->join('payment_method', 'payment_method.id = order.payment_method_id', 'left');
		$this->db->join('enum_payment_method', 'enum_payment_method.id = payment_method.enum_payment_method_id', 'left');
		$this->db->join('shipping', 'shipping.id = order.shipping_id', 'left');
		$this->db->join('users', 'users.id = order.created_by', 'left');
		$this->db->join('order_product', 'order_product.order_no = order.order_no', 'left');
		$this->db->join('project_new', 'project_new.id = order.project_id', 'left');
		$this->db->join('groups', 'users.group_id = groups.id', 'left')
			->join('approve_po_list', 'order.is_approve_complete = 0
		AND order.approve_sequence + 1 = approve_po_list.sequence
		AND order.order_status = 1 AND order.order_no = approve_po_list.order_no', 'left', FALSE);
		if (count($is_role_approve) == 1) {
			$this->db->where('groups.id', $is_role_approve[0]->departemen_id);
		} else {
			$arr_dept_id = [];
			foreach ($is_role_approve as $v) {
				$arr_dept_id[] = $v->departemen_id;
			}

			$this->db->where_in('groups.id', $arr_dept_id);
		}

		$this->db->limit($limit, $start)->order_by($col, $dir);
		if (!empty($search)) {
			$this->db->group_start();
			foreach ($search as $key => $value) {
				$this->db->or_like($key, $value);
			}
			$this->db->group_end();
		}
		$this->db->where($where);
		$this->db->group_by('order.order_no');
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result();
		} else {
			return null;
		}
	}

	public function detail_order($where = [])
	{
		$this->db->select("b.name as project_name , b.no_spk
		, c.name  as shipping_name
		, e.name  as dept_name
        , d.first_name  as created_name
		, a.*
		, f.start_contract , f.end_contract , f.file_contract , f.harga as  nilai_kontrak
		, g.name as sumber_daya_name
		, h.scm_id, h.address as alamat_vendor")
			->from('order as a')
			->join('project_new as b', 'a.project_id = b.id')
			->join('shipping as c', 'c.id = a.shipping_id')
			->join('users as d', 'd.id = a.created_by')
			->join('groups as e', 'e.id = d.group_id', 'left')
			->join('project as f', 'f.id = a.kontrak_id', 'left')
			->join('category as g', 'g.id = f.category_id', 'left')
			->join('vendor as h', 'h.id = a.vendor_id', 'left')
			->where($where);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		}

		return FALSE;
	}

	public function detail_user($where = [])
	{
		$this->db->select("b.name as role_name
		, a.*
		, d.departemen_code
		, c.group_id as departemen_id")
			->from('approve_po_list as a')
			->join('roles as b', 'a.role_id = b.id')
			->join('users as c', 'a.updated_by = c.id')
			->join('groups as d', 'c.group_id = d.id')
			->where($where);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		}

		return FALSE;
	}

	public function detail_user_role($where = [])
	{
		$this->db->select("b.name as role_name
		, a.*
		")
			->from('users as a')
			->join('users_roles as c', 'a.id = c.user_id')
			->join('roles as b', 'b.id = c.role_id')
			->where($where);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		}

		return FALSE;
	}
	public function getapprovename($where = [])
	{
		$this->db->select("approve_po_list.order_no, approve_po_list.role_id, users.first_name as approval_name, approve_po_list.updated_by, users2.first_name as user_approve_name, approve_po_list.status_approve")
			->from('approve_po_list')
			->join('users_roles', 'users_roles.role_id = approve_po_list.role_id', 'left')
			->join('users', 'users_roles.user_id = users.id', 'left')
			->join('users as users2', 'approve_po_list.updated_by = users2.id', 'left')
			->order_by('approve_po_list.sequence', 'ASC')
			->where($where);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}

		return FALSE;
	}


	public function get_all_vendor_for_chat($user_id, $vendor_id = NULL)
	{
		$this->db->select("a.vendor_id, b.name")
			->from('order as a')
			->join('vendor as b', 'a.vendor_id = b.id')
			->where('a.order_status', 2)
			->where('a.created_by', $user_id)
			->group_by('a.vendor_id')
			->group_by('b.name');

		if ($vendor_id) {
			$this->db->where('a.vendor_id', $vendor_id);
		}

		$query = $this->db->get();
		return $query->result();
	}

	public function getAllById($where = array())
	{
		$this->db->select("order.*")->from("order");
		$this->db->where($where);
		$this->db->where("order.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}
	public function getOneBy($where = array())
	{
		$this->db->select("order.*")->from("order");
		$this->db->where($where);
		$this->db->where("order.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return FALSE;
	}
	public function getDataOneBy($where = array())
	{
		$this->db->select("order.*,
			CONCAT(enum_payment_method.name,' ',payment_method.day,' hari') as full_name,
			shipping.name as shipping_name,
			users.first_name as users_name,
			users.address as users_address,
			payment_method.day as payment_method_day,
			project_new.name as project_name,
			project_new.id as project_id
			")
			->select("project.no_contract , amandemen.no_amandemen, IFNULL(amandemen.created_at,project.tanggal) as tgl_contract, IFNULL(amandemen.end_contract,project.end_contract) as end_contract");
		$this->db->from("order");
		$this->db->join('payment_method', 'payment_method.id = order.payment_method_id', 'left');
		$this->db->join('enum_payment_method', 'enum_payment_method.id = payment_method.enum_payment_method_id', 'left');
		$this->db->join('shipping', 'shipping.id = order.shipping_id');
		$this->db->join('users', 'users.id = order.created_by');
		$this->db->join('project_new', 'project_new.id = order.project_id', 'left');
		$this->db->join('project', 'project.id = order.kontrak_id', 'left');
		$this->db->join('amandemen', 'amandemen.id = project.last_amandemen_id', 'left');
		$this->db->where($where);
		$this->db->where("order.is_deleted", 0);

		$query = $this->db->get();
		//die($this->db->last_query());
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return FALSE;
	}

	public function getAllDataBy($where = array())
	{
		$this->db->select("order.*,
			CONCAT(enum_payment_method.name,' ',payment_method.day,' hari') as full_name,
			shipping.name as shipping_name,
			users.first_name as users_name,
			users.address as users_address,
			");
		$this->db->from("order");
		$this->db->join('payment_method', 'payment_method.id = order.payment_method_id');
		$this->db->join('enum_payment_method', 'enum_payment_method.id = payment_method.enum_payment_method_id');
		$this->db->join('shipping', 'shipping.id = order.shipping_id');
		$this->db->join('users', 'users.id = order.created_by');
		$this->db->where($where);
		$this->db->where("order.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}
	public function insert($data)
	{
		$this->db->insert('order', $data);
		return $this->db->insert_id();
	}

	public function update($data, $where)
	{
		$this->db->update('order', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where)
	{
		$this->db->where($where);
		$this->db->delete('order');
		if ($this->db->affected_rows()) {
			return TRUE;
		}
		return FALSE;
	}

	function getAllBy2($limit = null, $start = null, $search = null, $col = null, $dir = null, $where = array())
	{
		$this->db->select("order.*,
			CONCAT(enum_payment_method.name,' ',payment_method.day,' hari') as full_name,
			shipping.name as shipping_name,
			users.first_name as users_name,
			users.address as users_address,
            order_product.payment_mehod_name,
			project_new.name as project_name
			")
			->select('NULL AS role_id_approver', FALSE);
		$this->db->from("order");
		$this->db->join('payment_method', 'payment_method.id = order.payment_method_id', 'left');
		$this->db->join('enum_payment_method', 'enum_payment_method.id = payment_method.enum_payment_method_id', 'left');
		$this->db->join('shipping', 'shipping.id = order.shipping_id', 'left');
		$this->db->join('users', 'users.id = order.created_by', 'left');
		$this->db->join('order_product', 'order_product.order_no = order.order_no', 'left');
		$this->db->join('project_new', 'project_new.id = order.project_id', 'left');
		$this->db->limit($limit, $start)->order_by($col, $dir);
		if (!empty($search)) {
			$this->db->group_start();
			foreach ($search as $key => $value) {
				$this->db->or_like($key, $value);
			}
			$this->db->group_end();
		}
		$this->db->where($where);
		$this->db->group_by('order.order_no');
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result();
		} else {
			return null;
		}
	}

	function getCountAllBy2($limit = null, $start = null, $search = null, $col = null, $dir = null, $where = array())
	{

		$this->db->select("order.*,
			CONCAT(enum_payment_method.name,' ',payment_method.day,' hari') as full_name,
			shipping.name as shipping_name,
			users.first_name as users_name,
			users.address as users_address,
            order_product.payment_mehod_name
			");
		$this->db->from("order");
		$this->db->join('payment_method', 'payment_method.id = order.payment_method_id', 'left');
		$this->db->join('enum_payment_method', 'enum_payment_method.id = payment_method.enum_payment_method_id', 'left');
		$this->db->join('shipping', 'shipping.id = order.shipping_id', 'left');
		$this->db->join('users', 'users.id = order.created_by', 'left');
		$this->db->join('order_product', 'order_product.order_no = order.order_no', 'left');
		$this->db->join('project_new', 'project_new.id = order.project_id', 'left');
		if (!empty($search)) {
			$this->db->group_start();
			foreach ($search as $key => $value) {
				$this->db->or_like($key, $value);
			}
			$this->db->group_end();
		}
		$this->db->group_by('order.order_no');
		$this->db->where($where);
		$result = $this->db->get();

		return $result->num_rows();
	}

	function getmaxcounttoday($where)
	{
		$this->db->select('count(id) as total');
		$this->db->from('stored_id');
		$this->db->where($where);
		$result = $this->db->get();

		return $result->row();
	}

	public function get_top_5_vendor($tahun)
	{
		$limit = 10;
		$this->db->select("COUNT(*) as banyaknya, COUNT(*) as totalnya,
		a.vendor_id
		, b.name as vendor_name")
			->from('order as a')
			->join('vendor as b', 'b.id = a.vendor_id', 'left')
			->join('project as c', 'b.id = c.vendor_id', 'left')
			->where('a.order_status', 2)
			->where('b.is_deleted', 0)
			->where('c.is_deleted', 0)
			->where('EXTRACT(YEAR FROM a.created_at) = "' . $tahun . '" ', NULL)
			->group_by('a.vendor_id')
			->order_by('totalnya', 'desc')
			->limit($limit);

		$query = $this->db->get();
		//echo $this->db->last_query();
		$ret = [];
		$for_not_in = [];
		foreach ($query->result() as $k => $v) {
			$ret[$v->vendor_id] = $v->vendor_name;
			$for_not_in[] = $v->vendor_id;
		}

		// jika lebih kecil dari 10, cari sisanya random;
		if (count($ret) < $limit) {
			$sisa = $limit - count($ret);
			$this->db->select('vendor.name, vendor.id')
				->from('vendor')
				->join('order', 'order.vendor_id = vendor.id')
				->where('vendor.is_deleted', 0)
				->limit($sisa)
				->order_by('rand()', 'ASC');
			if (!empty($for_not_in)) {
				$this->db->where_not_in('vendor.id', $for_not_in);
			}
			// q = query
			$q_vendor = $this->db->get()->result();
			foreach ($q_vendor as $k => $v) {
				$ret[$v->id] = $v->name;
			}
		}
		return $ret;
	}

	public function get_top_5_vendor_per_bulan($tahun, $arr_vendor)
	{
		if (empty($arr_vendor)) {
			return [];
		}

		$vendor_in = [];
		foreach ($arr_vendor as $k => $v) {
			$vendor_in[] = $k;
		}

		$this->db->select("COUNT(*) as banyaknya
		, COUNT(*) as totalnya
		, a.vendor_id
		, EXTRACT(MONTH FROM a.created_at) as bulannya
		, b.name as vendor_name")
			->from('order as a')
			->join('vendor as b', 'b.id = a.vendor_id', 'left')
			->where('a.order_status', 2)
			->where_in('a.vendor_id', $vendor_in)
			->where('EXTRACT(YEAR FROM a.created_at) = "' . $tahun . '"', NULL)
			->group_by('a.vendor_id')
			->group_by('EXTRACT(MONTH FROM a.created_at)', FALSE)
			->order_by('bulannya', 'DESC');

		$query = $this->db->get();

		$ret = [];
		foreach ($query->result() as $k => $v) {
			$index = $v->vendor_id . "_" . $v->bulannya;
			$ret[$index] = $v->totalnya;
		}

		return $ret;
	}

	public function get_total_dana_order($where)
	{
		$this->db->select("COUNT(*) as banyaknya")
			->select("IFNULL(SUM(total_price),0) as totalnya", FALSE)
			->from('order')
			->where('order_status', 2)
			->where($where);

		$query = $this->db->get();
		return $query->row();
	}

	public function get_penyerapan_volume_vendor($vendor_id, $tahun, $is_dashboard_user = FALSE)
	{
		$this->db->select("COUNT(*) as banyaknya")
			->select("IFNULL(ROUND(SUM(order_product.qty * ROUND(order_product.weight,4)),4),0) as totalnya", FALSE)
			->select('EXTRACT(MONTH FROM order.created_at) as bulannya', FALSE)
			->from('order')
			->join('order_product', 'order_product.order_no = order.order_no')
			->where('order.order_status', 2)
			->where("EXTRACT(YEAR FROM order.created_at) = '$tahun'", NULL)
			->group_by('EXTRACT(MONTH FROM order.created_at)', FALSE);
		if ($is_dashboard_user == FALSE) {
			$this->db->where('order.vendor_id', $vendor_id);
		} else if ($is_dashboard_user == 'user') {
			$this->db->where('order.created_by', $vendor_id);
		}

		$query = $this->db->get();
		//echo $this->db->last_query();
		$ret = [];
		foreach ($query->result() as $k => $v) {
			$ret[$v->bulannya] = $v->totalnya;
		}

		return $ret;
	}

	public function get_penyerapan_vendor($vendor_id, $tahun, $is_dashboard_user = FALSE)
	{
		$this->db->select("COUNT(*) as banyaknya")
			->select("IFNULL(SUM(total_price),0) as totalnya", FALSE)
			->select('EXTRACT(MONTH FROM created_at) as bulannya', FALSE)
			->from('order')
			->where('order_status', 2)
			// ->where('vendor_id', $vendor_id)
			->where("EXTRACT(YEAR FROM created_at) = '$tahun'", NULL)
			->group_by('EXTRACT(MONTH FROM created_at)', FALSE);
		if ($is_dashboard_user == FALSE) {
			$this->db->where('order.vendor_id', $vendor_id);
		} else if ($is_dashboard_user == 'user') {
			$this->db->where('order.created_by', $vendor_id);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		$ret = [];
		foreach ($query->result() as $k => $v) {
			$ret[$v->bulannya] = $v->totalnya;
		}

		return $ret;
	}

	public function get_detail_order_vendor($vendor_id, $bulan, $tahun)
	{
		$where = [
			'order.order_status ' => 2,
		];
		// -1 artinya wika
		if ($vendor_id != '-1') {
			$where['order.vendor_id'] =  $vendor_id;
		}

		$where_false = [
			"EXTRACT(YEAR FROM order.created_at) = '$tahun'"
		];

		if ($bulan) {
			$where_false[] = "EXTRACT(MONTH FROM order.created_at) = '$bulan'";
		}

		return $this->_get_detail_order($where, $where_false);

		$this->db->select("groups.name as dept_name, order.location_id , order.location_name, order.order_no
		, CONCAT(enum_payment_method.name, ' ' ,payment_method.day,' hari' ) as name_payment_method
		, ROUND(SUM(order_product.qty * ROUND(order_product.weight,4)),4) as total_volume
		, project_new.departemen_id")
			->from('order')
			->join('order_product', 'order.order_no = order_product.order_no')
			->join('project_new', 'project_new.id = order.project_id', 'left')
			->join('groups', 'groups.id = project_new.departemen_id ', 'left')
			->join('payment_method', 'payment_method.id = order.payment_method_id ', 'left')
			->join('enum_payment_method', 'enum_payment_method.id = payment_method.enum_payment_method_id ', 'left')
			->where($where)
			->where("EXTRACT(YEAR FROM order.created_at) = '$tahun'", NULL, FALSE)
			->group_by(['project_new.departemen_id', 'order.location_id', 'order.payment_method_id'])
			->order_by('groups.name', 'asc');
		if ($bulan) {
			$this->db->where("EXTRACT(MONTH FROM order.created_at) = '$bulan'", NULL, FALSE);
		}

		$q = $this->db->get();
		return $q->result();
	}

	public function get_detail_penyerapan_vendor($vendor_id, $tahun, $category_id)
	{
		$where = [
			'order.order_status <>' => 3,
			'product.category_id' => $category_id,
		];
		// -1 artinya wika
		if ($vendor_id != '-1') {
			$where['order.vendor_id'] =  $vendor_id;
		}

		$where_false = [
			"EXTRACT(YEAR FROM order.created_at) = '$tahun'"
		];

		return $this->_get_detail_order($where, $where_false, TRUE);

		$this->db->select("groups.name as dept_name, order.location_id , order.location_name, order.order_no
		, CONCAT(enum_payment_method.name, ' ' ,payment_method.day,' hari' ) as name_payment_method
		, ROUND(SUM(order_product.qty * ROUND(order_product.weight,4)),4) as total_volume
		, project_new.departemen_id")
			->from('order')
			->join('order_product', 'order.order_no = order_product.order_no')
			->join('project_new', 'project_new.id = order.project_id', 'left')
			->join('groups', 'groups.id = project_new.departemen_id ', 'left')
			->join('payment_method', 'payment_method.id = order.payment_method_id ', 'left')
			->join('enum_payment_method', 'enum_payment_method.id = payment_method.enum_payment_method_id ', 'left')
			->join('product', 'product.id = order_product.product_id', 'left')
			->where($where)
			->where("EXTRACT(YEAR FROM order.created_at) = '$tahun'", NULL, FALSE)
			->group_by(['project_new.departemen_id', 'order.location_id', 'order.payment_method_id'])
			->order_by('groups.name', 'asc');

		$q = $this->db->get();
		return $q->result();
	}

	public function get_penyerapan_dept($tahun)
	{
		$this->db->select('groups.id , groups.name , SUM(order_product.weight * order_product.qty) as total_volume')
			->from('order')
			->join('order_product', 'order.order_no = order_product.order_no AND order.order_status = 2 AND EXTRACT(YEAR FROM order.created_at) = "' . $tahun . '" ', 'inner', FALSE)
			->join('project_new', 'project_new.id = order.project_id')
			->join('groups', 'groups.id = project_new.departemen_id', 'right')
			->where('groups.is_deleted', 0)
			->group_by('groups.id')
			->order_by('total_volume', 'DESC');

		$query = $this->db->get();
		$ret = [];
		foreach ($query->result() as $k => $v) {
			$ret[$v->id] = $v->name;
		}

		return $ret;
	}

	public function get_detail_penyerapan_dept_result($dept_id, $bulan, $tahun)
	{
		$this->db->select('order.order_no, SUM(order_product.weight * order_product.qty ) as volume
		, order.total_price , vendor.name as vendor_name')
			->from('order')
			->join('order_product', 'order.order_no = order_product.order_no')
			->join('project_new', 'project_new.id = order.project_id')
			->join('vendor', 'vendor.id = order.vendor_id')
			->where('project_new.departemen_id', $dept_id)
			->where('order.order_status', 2)
			->where("EXTRACT(MONTH FROM order.created_at) = '$bulan'", NULL, FALSE)
			->where("EXTRACT(YEAR FROM order.created_at) = '$tahun'", NULL, FALSE)
			->order_by('order.order_no', 'ASC')
			->group_by('order.order_no');
		$q = $this->db->get();
		//echo $this->db->last_query();
		return $q->result();
	}

	public function get_penyerapan_dept_per_bulan($tahun, $arr_dept)
	{
		if (empty($arr_dept)) {
			return [];
		}

		$dept_in = [];
		foreach ($arr_dept as $k => $v) {
			$dept_in[] = $k;
		}

		$this->db->select('ROUND(SUM(order_product.qty * ROUND(order_product.weight,4)),4) as totalnya , groups.id as departemen_id
		, EXTRACT(MONTH FROM order.created_at) as bulannya')
			->from('order')
			->join('order_product', 'order.order_no = order_product.order_no')
			->join('project_new', 'project_new.id = order.project_id')
			->join('groups', 'groups.id = project_new.departemen_id')
			->where('groups.is_deleted', 0)
			->where('order.order_status', 2)
			->where_in('groups.id', $dept_in)
			->where('EXTRACT(YEAR FROM order.created_at) = "' . $tahun . '"', NULL)
			->group_by('groups.id')
			->group_by('EXTRACT(MONTH FROM order.created_at)', FALSE)
			->order_by('bulannya', 'DESC');

		$query = $this->db->get();
		$ret = [];
		foreach ($query->result() as $k => $v) {
			$index = $v->departemen_id . "_" . $v->bulannya;
			$ret[$index] = $v->totalnya;
		}

		return $ret;
	}

	public function get_top_10_product($tahun)
	{
		$limit = 10;
		$this->db->select('ROUND(SUM(order_product.qty * ROUND(order_product.weight,4)),4) as total_volume ,order_product.product_id , product.name as product_name')
			->from('order')
			->join('order_product', 'order_product.order_no = order.order_no')
			->join('product', 'product.id = order_product.product_id')
			->where('order.order_status', 2)
			->where('product.is_deleted', 0)
			->where('EXTRACT(YEAR FROM order.created_at) = "' . $tahun . '" ', NULL)
			->group_by('order_product.product_id')
			->order_by('total_volume', 'DESC')
			->limit($limit);

		$query = $this->db->get();
		//echo $this->db->last_query();
		$ret = [];
		$for_not_in = [];
		foreach ($query->result() as $k => $v) {
			$ret[$v->product_id] = $v->product_name;
			$for_not_in[] = $v->product_id;
		}

		// jika lebih kecil dari 10, cari sisanya random;
		if (count($ret) < 10) {
			$sisa = $limit - count($ret);
			$this->db->select('name, id')
				->from('product')
				->where('product.is_deleted', 0)
				->limit($sisa)
				->order_by('rand()', 'ASC');
			if (!empty($for_not_in)) {
				$this->db->where_not_in('id', $for_not_in);
			}
			// q = query
			$q_product = $this->db->get()->result();
			foreach ($q_product as $k => $v) {
				$ret[$v->id] = $v->name;
			}
		}
		return $ret;
	}

	public function get_top_10_product_per_bulan($tahun, $arr_product)
	{
		if (empty($arr_product)) {
			return [];
		}

		$product_in = [];
		foreach ($arr_product as $k => $v) {
			$product_in[] = $k;
		}

		$this->db->select('ROUND(SUM(order_product.qty * ROUND(order_product.weight,4)),4) as totalnya , order_product.product_id
		, EXTRACT(MONTH FROM order.created_at) as bulannya')
			->from('order')
			->join('order_product', 'order.order_no = order_product.order_no')
			->where('order.order_status', 2)
			->where_in('order_product.product_id', $product_in)
			->where('EXTRACT(YEAR FROM order.created_at) = "' . $tahun . '"', NULL)
			->group_by('order_product.product_id')
			->group_by('EXTRACT(MONTH FROM order.created_at)', FALSE)
			->order_by('bulannya', 'DESC');

		$query = $this->db->get();

		$ret = [];
		foreach ($query->result() as $k => $v) {
			$index = $v->product_id . "_" . $v->bulannya;
			$ret[$index] = $v->totalnya;
		}

		return $ret;
	}
	// where_false = where yang gak di escape,
	private function _get_detail_order($where = [], $where_false = [], $is_penyerapan = FALSE)
	{
		$this->db->select('order.order_no
		, SUM(order_product.qty * order_product.weight) as total_volume
		, order.total_price
		, groups.name as dept_name
		, vendor.name as vendor_name
		, project_new.name as project_name
		, ref_locations.full_name as location_name
		, groups.id as dept_id')
			->select("CONCAT(enum_payment_method.name , ' ', payment_method.`day` , ' Hari') as name_payment_method", FALSE)
			->from('order')
			->join('order_product', 'order.order_no = order_product.order_no')
			->join('project_new', 'project_new.id = order.project_id')
			->join('groups', 'groups.id = project_new.departemen_id')
			->join('vendor', 'vendor.id = order.vendor_id')
			->join('ref_locations', 'ref_locations.location_id = order.location_id')
			->join('payment_method', 'payment_method.id = order.payment_method_id')
			->join('enum_payment_method', 'enum_payment_method.id = payment_method.enum_payment_method_id')
			->where($where)
			->group_by([
				'order.order_no', 'groups.name', 'project_new.name', 'vendor.name', "CONCAT(enum_payment_method.name , ' ', payment_method.`day` , ' Hari')", 'groups.id', 'order.total_price'
			]);

		if ($is_penyerapan === TRUE) {
			$this->db->join('product', 'product.id = order_product.product_id');
		}

		if (!empty($where_false)) {
			foreach ($where_false as $v) {
				$this->db->where($v, NULL, FALSE);
			}
		}
		$q = $this->db->get();
		return $q->result();
	}

	public function get_detail_order_product($product_id, $bulan, $tahun)
	{
		$where = [
			'order.order_status' => 2,
			'order_product.product_id' => $product_id
		];
		$where_false = [
			"EXTRACT(MONTH FROM order.created_at) = '$bulan'",
			"EXTRACT(YEAR FROM order.created_at) = '$tahun'"
		];

		return $this->_get_detail_order($where, $where_false);
		// yang bawah gak di eksekusi, karena ada return diatas
		$this->db->select("groups.name as dept_name, order.location_id , order.location_name
		, CONCAT(enum_payment_method.name, ' ' ,payment_method.day,' hari' ) as name_payment_method
		, ROUND(SUM(order_product.qty * ROUND(order_product.weight,4)),4) as total_volume
		, project_new.departemen_id")
			->from('order')
			->join('order_product', 'order.order_no = order_product.order_no')
			->join('project_new', 'project_new.id = order.project_id', 'left')
			->join('groups', 'groups.id = project_new.departemen_id ', 'left')
			->join('payment_method', 'payment_method.id = order.payment_method_id ', 'left')
			->join('enum_payment_method', 'enum_payment_method.id = payment_method.enum_payment_method_id ', 'left')
			->where($where)
			->where("EXTRACT(MONTH FROM order.created_at) = '$bulan'", NULL, FALSE)
			->where("EXTRACT(YEAR FROM order.created_at) = '$tahun'", NULL, FALSE)
			->group_by(['project_new.departemen_id', 'order.location_id', 'order.payment_method_id'])
			->order_by('groups.name', 'asc');

		$q = $this->db->get();
		return $q->result();
	}

	public function getDataPekerjaan($where = array())
	{
		$this->db->select("*");
		// ->select("project.no_contract, project.tanggal as tgl_contract");
		$this->db->from("order_product");
		$this->db->join('order', 'order.order_no = order_product.order_no');
		$this->db->join('transportasi', 'transportasi.id = order_product.transportasi_id');
		// $this->db->join('project_new','project_new.id = order.project_id', 'left');
		// $this->db->join('project','project.id = order.kontrak_id', 'left');
		// $this->db->join('amandemen','amandemen.id = project.last_amandemen_id', 'left');
		// $this->db->join('kontrak_transportasi','kontrak_transportasi.id = order_product.transportasi_id');
		$this->db->where($where);
		// $this->db->where("order.is_deleted",0);

		$query = $this->db->get();
		//die($this->db->last_query());
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}
}
