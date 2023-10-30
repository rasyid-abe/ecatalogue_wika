<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	// Dashboard Transportasi
	public function get_penyerapan_per_vendor($default, $bulan, $tahun)
	{
		$filter = $bulan != 111 ? "WHERE EXTRACT(YEAR_MONTH FROM ot.updated_at) = '$tahun$bulan'" : "WHERE EXTRACT(YEAR FROM ot.updated_at) = '$tahun'";
		$sql = "
		SELECT DISTINCT(ot.vendor_id), v.name,
		sum(ot.biaya_transport*otd.weight*otd.qty) as harga,
	  	sum(otd.weight*otd.qty/1000) as berat
		FROM order_transportasi ot
		LEFT JOIN `order` od ON od.order_no = ot.order_no
		JOIN vendor v ON ot.vendor_id = v.id
		JOIN order_transportasi_d otd on ot.order_no = otd.order_no
		$filter
		and od.order_status = 1 
		GROUP BY ot.vendor_id ORDER BY harga DESC LIMIT 5
		";
		
		$data = $this->db->query($sql)->result_array();
		return $data;
	}

	public function get_total_nilai_transportasi($default, $bulan, $tahun)
	{
		$filter = $bulan != 111 ? "WHERE EXTRACT(YEAR_MONTH FROM ot.updated_at) = '$tahun$bulan'" : "WHERE EXTRACT(YEAR FROM ot.updated_at) = '$tahun'";

		$sql = "
			SELECT sum(ot.biaya_transport*otd.weight*otd.qty) as nilai
			FROM order_transportasi ot
			LEFT JOIN `order` od ON od.order_no = ot.order_no
			JOIN order_transportasi_d otd on ot.order_no = otd.order_no
			$filter
			and od.order_status = 1 
		";

		$data = $this->db->query($sql)->row('nilai');
		return $data;
	}

	public function get_total_volume_diangkut($default, $bulan, $tahun)
	{
		$filter = $bulan != 111 ? "WHERE EXTRACT(YEAR_MONTH FROM ot.updated_at) = '$tahun$bulan'" : "WHERE EXTRACT(YEAR FROM ot.updated_at) = '$tahun'";

		$sql = "
			SELECT sum(otd.weight*otd.qty/1000) as volume
			FROM order_transportasi ot
			LEFT JOIN `order` od ON od.order_no = ot.order_no
			JOIN order_transportasi_d otd on ot.order_no = otd.order_no
			$filter
			and od.order_status = 1 
		";

		$data = $this->db->query($sql)->row('volume');
		return $data;
	}

	public function get_po_per_bulan_berjalan($default, $bulan, $tahun)
	{
		$filter = $bulan != 111 ? "WHERE EXTRACT(YEAR_MONTH FROM ot.updated_at) = '$tahun$bulan'" : "WHERE EXTRACT(YEAR_MONTH FROM ot.updated_at) = '$tahun$default'";

		$sql = "
			SELECT COUNT(ot.order_no) total FROM order_transportasi ot
			LEFT JOIN `order` od ON od.order_no = ot.order_no
			$filter
			and od.order_status = 1 
		";

		$data = $this->db->query($sql)->row('total');
		return $data;
	}

	public function get_po_per_tahun_berjalan($tahun)
	{
		$sql = "
			SELECT COUNT(ot.order_no) total FROM order_transportasi ot
			LEFT JOIN `order` od ON od.order_no = ot.order_no
			WHERE EXTRACT(YEAR FROM ot.updated_at) = '$tahun'
			and od.order_status = 1 
		";

		$data = $this->db->query($sql)->row('total');
		return $data;
	}

	public function get_po_per_divisi_per_volume_bar($default, $bulan, $tahun)
	{

		$this->db->select("od.created_by customer, u.group_id grup, g.name, op.weight, op.qty, sum(op.weight*op.qty/1000) as volume ");
		$this->db->from("order_transportasi od");
		$this->db->join('order o', 'o.order_no = od.order_no', 'left');
		$this->db->join('users u', 'od.created_by = u.id', 'left');
		$this->db->join('groups g', 'u.group_id = g.id', 'left');
		$this->db->join('order_transportasi_d op', 'od.order_no = op.order_no', 'left');
		if ($bulan != 111) {
			$this->db->where('EXTRACT(YEAR_MONTH FROM od.updated_at) =', $tahun . $bulan);
		} else {
			$this->db->where('EXTRACT(YEAR FROM od.updated_at) =', $tahun);
		}
		$this->db->where('o.order_status = ', 1);
		$this->db->group_by('g.id');
		$this->db->order_by('volume', 'DESC');
		$this->db->limit(5);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function get_po_per_divisi_per_volume_pie($default, $bulan, $tahun)
	{

		$this->db->select("od.created_by customer, u.group_id grup, g.name, op.weight, op.qty, sum(op.weight*op.qty/1000) as volume ");
		$this->db->from("order_transportasi od");
		$this->db->join('order o', 'o.order_no = od.order_no', 'left');
		$this->db->join('users u', 'od.created_by = u.id', 'left');
		$this->db->join('groups g', 'u.group_id = g.id', 'left');
		$this->db->join('order_transportasi_d op', 'od.order_no = op.order_no', 'left');
		if ($bulan != 111) {
			$this->db->where('EXTRACT(YEAR_MONTH FROM od.updated_at) =', $tahun . $bulan);
		} else {
			$this->db->where('EXTRACT(YEAR FROM od.updated_at) =', $tahun);
		}
		$this->db->where('o.order_status = ', 1);
		$this->db->group_by('g.id');
		$this->db->order_by('volume', 'DESC');
		$this->db->limit(5);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function get_po_per_project($default, $bulan, $tahun)
	{
		$filter = $bulan != 111 ? "WHERE EXTRACT(YEAR_MONTH FROM ot.updated_at) = '$tahun$bulan'" : "WHERE EXTRACT(YEAR FROM ot.updated_at) = '$tahun'";

		$sql = "
			SELECT pn.name name, COUNT(order_no) total FROM order_transportasi ot
			JOIN project_new pn ON ot.project_id = pn.id
			$filter
			GROUP BY ot.project_id ORDER BY total DESC LIMIT 5
		";

		$data = $this->db->query($sql)->result_array();
		return $data;
	}

	public function get_all_volume_per_bulan_berjalan($default, $bulan, $tahun)
	{
		$filter = $bulan != 111 ? "WHERE EXTRACT(YEAR_MONTH FROM ot.updated_at) = '$tahun$bulan'" : "WHERE EXTRACT(YEAR_MONTH FROM ot.updated_at) = '$tahun$default'";

		$sql = "
			SELECT sum(otd.weight*otd.qty/1000) as volume, EXTRACT(DAY FROM ot.updated_at) date, DATE_FORMAT(ot.updated_at, '%Y-%m-%d') tgl
			FROM order_transportasi ot
			JOIN order_transportasi_d otd on otd.order_no = ot.order_no
			LEFT JOIN `order` od ON od.order_no = ot.order_no
			$filter
			and od.order_status = 1 
			GROUP BY EXTRACT(DAY FROM ot.updated_at)
		";

		$data = $this->db->query($sql)->result();
		return $data;
	}

	public function get_vehicle_terbanyak_by_volume($default, $bulan, $tahun)
	{
		$filter = $bulan != 111 ? "EXTRACT(YEAR_MONTH FROM ot.updated_at) = '$tahun$bulan'" : "EXTRACT(YEAR FROM ot.updated_at) = '$tahun'";

		$sql = "
			SELECT rc.code, rc.name, sum(otd.weight*otd.qty/1000) as volume FROM order_transportasi_d otd
			JOIN order_transportasi ot ON ot.order_no = otd.order_no
			JOIN transportasi t ON ot.transportasi_id = t.id
			LEFT JOIN `order` od ON od.order_no = ot.order_no
			JOIN resources_code rc ON t.sda_code = rc.code
			WHERE rc.code <> '' AND $filter
			and od.order_status = 1 
			GROUP BY rc.code
			order by volume desc
		";

		$data = $this->db->query($sql)->result_array();
		return $data;
	}

	public function get_detail_po($params)
	{
		$where = strlen($params) > 4 ? "EXTRACT(YEAR_MONTH FROM ot.updated_at) = '$params'" : "EXTRACT(YEAR FROM ot.updated_at) = '$params'";

		$sql = "
			SELECT
				COUNT(*) total,
				pn.name project,
				rl.name lokasi
			FROM
				order_transportasi ot
				LEFT JOIN `order` od ON od.order_no = ot.order_no
				JOIN project_new pn ON ot.project_id = pn.id
				JOIN ref_locations rl ON pn.location_id = rl.location_id
				
			WHERE
				$where and od.order_status = 1 
			GROUP BY
				ot.project_id
		";

		$result = $this->db->query($sql)->result_array();
		return $result;
	}

	// Dashboard Matgis

	public function get_nilai($tahun)
	{
		$this->db->select("(SUM(op.price * op.qty)) nilai");
		$this->db->from("order od");
		$this->db->join('order_product op', 'od.order_no = op.order_no', 'left');
		$this->db->join('product p', 'op.product_id = p.id', 'left');
		$this->db->join('resources_code rc', 'p.code_1 = rc.code', 'left');
		$this->db->join('users u', 'op.created_by = u.id', 'left');
		$this->db->join('groups g', 'u.group_id = g.id', 'left');
		$this->db->where('EXTRACT(YEAR FROM od.update_at) =', $tahun);
		$this->db->where('sts_matgis = ', 1);
		$this->db->where('od.order_status  = ', 2);
		
		$result = $this->db->get();
		return $result->row('nilai');
	}

	public function get_nilai_nilai_smcb($tahun)
	{
		$this->db->select("(SUM(op.price_smcb*op.qty)) nilai");
		$this->db->from("order od");
		$this->db->join('order_product op', 'od.order_no = op.order_no', 'left');
		$this->db->join('product p', 'op.product_id = p.id', 'left');
		$this->db->join('resources_code rc', 'p.code_1 = rc.code', 'left');
		$this->db->where('EXTRACT(YEAR FROM od.update_at) =', $tahun);
		$this->db->where('sts_matgis = ', 1);
		$this->db->where('od.order_status  = ', 2);
		$result = $this->db->get();
		return $result->row('nilai');
	}

	public function get_detail_nilai($params)
	{
		$this->db->select("g.name divisi, (SUM(op.price * op.qty)) nilai");
		$this->db->from("order od");
		$this->db->join('order_product op', 'od.order_no = op.order_no', 'left');
		$this->db->join('product p', 'op.product_id = p.id', 'left');
		$this->db->join('resources_code rc', 'p.code_1 = rc.code', 'left');
		$this->db->join('users u', 'op.created_by = u.id', 'left');
		$this->db->join('groups g', 'u.group_id = g.id', 'left');
		$this->db->where('EXTRACT(YEAR FROM od.update_at) =', $params);
		$this->db->where('rc.sts_matgis = ', 1);
		$this->db->where('od.order_status  = ', 2);
		$this->db->group_by('u.group_id');

		return $this->db->get()->result_array();
	}

	public function get_pin_maps($tahun)
	{
		$this->db->select("od.order_no, op.full_name_product, pn.id, pn.name, LEFT(pn.lat, 8) lat, LEFT(pn.long, 8) ln ");
		$this->db->from("order od");
		$this->db->join('project_new pn', 'od.project_id = pn.id', 'left');
		$this->db->join('order_product op', 'od.order_no = op.order_no', 'left');
		$this->db->where('pn.lat <>', '');
		$this->db->where('EXTRACT(YEAR FROM od.update_at) =', $tahun);
		$this->db->where('od.order_status  = ', 2);
		$this->db->group_by('pn.name');
		return $this->db->get()->result_array();
	}

	public function get_detail_maps($id, $tahun)
	{
		$this->db->select("DATE_FORMAT(od.update_at, '%d/%m/%Y') tanggal, od.order_no, (SUM(op.price*op.qty)) total_price, od.vendor_name, od.no_surat, epm.name, pm.day");
		$this->db->from("project_new pn");
		$this->db->join('order od', 'pn.id = od.project_id', 'left');
		$this->db->join('order_product op', 'od.order_no = op.order_no', 'left');
		$this->db->join('payment_method pm', 'od.payment_method_id = pm.id', 'left');
		$this->db->join('enum_payment_method epm', 'pm.enum_payment_method_id = epm.id', 'left');
		$this->db->where('pn.id =', $id);
		$this->db->where('EXTRACT(YEAR FROM od.update_at) =', $tahun);
		$this->db->where('od.order_status  = ', 2);
		$this->db->group_by('od.order_no');
		return $this->db->get()->result_array();
	}
}
