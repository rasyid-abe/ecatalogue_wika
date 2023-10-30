<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Resources_code_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function increment($parent, $level)
	{
		$integer = $select = '';
		if ($level == 2) {
			$select = "MID(CODE, 2, 1)";
			$integer = "AND concat('',MID(CODE, 2, 1) * 1) = MID(CODE, 2, 1)";
		} elseif ($level == 3) {
			$select = "MID(CODE, 3, 1)";
			$integer = "AND concat('',MID(CODE, 3, 1) * 1) = MID(CODE, 3, 1)";
		} elseif ($level == 4) {
			$select = "MID(CODE, 4, 1)";
			$integer = "AND concat('',MID(CODE, 4, 1) * 1) = MID(CODE, 4, 1)";
		} elseif ($level == 5) {
			$select = "MID(CODE, 5, 1)";
			$integer = "AND concat('',MID(CODE, 5, 1) * 1) = MID(CODE, 5, 1)";
		} elseif ($level == 6) {
			$select = "MID(CODE, 6, 1)";
			$integer = "AND concat('',MID(CODE, 6, 1) * 1) = MID(CODE, 6, 1)";
		}

		$ck_int = "SELECT $select mc FROM resources_code WHERE parent_code = '$parent' AND code IS NOT NULL $integer ORDER BY $select DESC LIMIT 1";
		$q_ck = $this->db->query($ck_int)->row('mc');
	
		if ($q_ck > 0 && $q_ck < 9) {
			$sql = "SELECT * FROM resources_code WHERE parent_code = '$parent' AND code IS NOT NULL $integer ORDER BY $select DESC LIMIT 1";
		} else {
			$sql = "SELECT * FROM resources_code WHERE parent_code = '$parent' AND code IS NOT NULL ORDER BY $select DESC LIMIT 1";
		}

		$code = $this->db->query($sql)->row('code');

		$new_code = '';
		if (empty($code)) {
			$new_code = 1;
		} else {
			if ($level == 2) {
				$last_code = substr($code, 1, 1);
			} elseif ($level == 3) {
				$last_code = substr($code, 2, 1);
			} elseif ($level == 4) {
				$last_code = substr($code, 3, 1);
			} elseif ($level == 5) {
				$last_code = substr($code, 4, 1);
			} elseif ($level == 6) {
				$last_code = substr($code, 5, 1);
			}

			if ((int) $last_code > 0 && (int) $last_code < 9) {
				$new_code = $last_code + 1;
			} else {
				if ((int) $last_code == 9) {
					$new_code = 'A';
				} else {
					if ($last_code == 'Z') {
						$result = [
							'data' => 'err',
							'msg' => 'Increment melebihi kapasitas.'
						];
						return $result;
						exit;
					} else {
						$arr_alpha = [
							'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
							'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
						];

						$i = 0;
						foreach ($arr_alpha as $val) {
							if ($val == $last_code) {
								$new_code = $arr_alpha[$i + 1];
							}
							$i++;
						}
					}
				}
			}
		}

		$result = [
			'data' => $new_code,
			'msg' => 'Increment succes'
		];

		return $result;
	}

	public function getAllById($where = array())
	{
		$this->db->select("resources_code.*")->from("resources_code");
		$this->db->where($where);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}
	public function getAllById2($where = array())
	{
		$this->db->select("resources_code.*")->from("resources_code");
		$this->db->where($where);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}
	public function getAllSDAArrName()
	{
		$dataReturn = [];
		$q = $this->getAllById2(['code like "EB%"' => null]);
		if ($q !== FALSE) {
			foreach ($q as $key => $value) {
				$dataReturn[$value->name] = $value->code;
			}
		}

		return $dataReturn;
	}
	public function get_dropdown2($where = [], $drop_pertama = NULL, $value = 'code', $label = 'name')
	{
		$data_dropdown = [];

		if ($drop_pertama !== NULL) {
			$data_dropdown[""] = $drop_pertama;
		}

		$query = $this->db->where($where)->get('resources_code')->result();
		foreach ($query as $v) {
			$data_dropdown[$v->$value] = $v->$label;
		}

		return $data_dropdown;
	}
	public function get_dropdown3($where = [], $drop_pertama = NULL, $value = 'code', $label = 'name')
	{
		$data_dropdown = [];

		if ($drop_pertama !== NULL) {
			$data_dropdown[""] = $drop_pertama;
		}

		$query = $this->db->where($where)->get('resources_code')->result();
		foreach ($query as $v) {
			$data_dropdown[$v->$value] = $v->$value . ' - ' . $v->$label;
		}

		return $data_dropdown;
	}
	public function getAllByBerat($where = array())
	{
		$this->db->select("resources_berat.*")->from("resources_berat");
		$this->db->where($where);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}
	public function getResourcesCodeArrName()
	{
		// $data = $this->db->get_where('resources_code', ['parent_code' => null])->result_array();
		// echo json_encode($data);


		$dataReturns = [];
		$q = $this->db->get_where('resources_code', ['level in (2,3,4,5,6)' => null, 'status' => 1])->result();
		if ($q !== FALSE) {
			foreach ($q as $key => $value) {
				$dataReturns[$value->code] = $value->name;
			}
		}

		return $dataReturns;
	}
}
