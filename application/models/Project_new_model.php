<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Project_new_model extends MY_Model
{
    protected $table = 'project_new';

    public function __construct()
    {
        parent::__construct();
    }

    public function getMainQuery()
    {
        $this->db->select("project_new.*, groups.name as departemen_name, location.name as location_name")
            ->from('project_new')
            ->join('groups', 'groups.id = project_new.departemen_id')
            ->join('location', 'location.id = project_new.location_id', 'left');
    }
    public function getAllById($where = array())
    {
        $this->db->select("project_new.*")->from("project_new");
        $this->db->where($where);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    function getAllBy($limit, $start, $search, $col, $dir, $where = [], $where_and = [])
    {
        if (!method_exists($this, 'getMainQuery')) {
            $this->db->select("*")
                ->from($this->table);
        } else {
            $this->getMainQuery();
        }

        if (!empty($search)) {
            foreach ($search as $key => $value) {
                $this->db->or_like($key, $value);
            }
        }

        if (!empty($where_and)) {
            foreach ($where_and as $key => $value) {
                $this->db->or_like($key, $value);
            }
        }

        $this->db->where($where);

        $this->db->limit($limit, $start);
        $this->db->order_by($col, $dir);

        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return null;
        }
    }

    function getCountAllBy($limit, $start, $search, $order, $dir, $where = [], $where_and = [])
    {
        if (!method_exists($this, 'getMainQuery')) {
            $this->db->select("*")
                ->from($this->table);
        } else {
            $this->getMainQuery();
        }

        if (!empty($search)) {
            foreach ($search as $key => $value) {
                $this->db->or_like($key, $value);
            }
        }

        if (!empty($where_and)) {
            $this->db->group_start();
            foreach ($where_and as $key => $value) {
                $this->db->like($key, $value);
            }
            $this->db->group_end();
        }

        $this->db->where($where);

        $result = $this->db->get();

        return $result->num_rows();
    }

    public function get_dropdown($where = [], $drop_pertama = NULL, $value = 'id', $label = 'name')
    {
        $data_dropdown = [];

        if ($drop_pertama !== NULL) {
            $data_dropdown[""] = $drop_pertama;
        }

        $query = $this->db->where($where)->get('project_new')->result();
        foreach ($query as $v) {
            $data_dropdown[$v->$value] = $v->$label;
        }

        return $data_dropdown;
    }
    public function getAllProjectArrName()
    {
        $dataReturn = [];
        $q = $this->getAllById(['is_deleted' => 0]);
        if ($q !== FALSE) {
            foreach ($q as $key => $value) {
                $dataReturn[$value->name] = $value->id;
            }
        }

        return $dataReturn;
    }
}
