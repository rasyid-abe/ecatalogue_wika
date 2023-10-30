<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Data_lelang_upload_history_model extends MY_Model
{
    protected $table = 'data_lelang_upload_history';

    public function __construct()
    {
        parent::__construct();
    }

    public function getMainQuery()
    {
        $this->db->select('data_lelang_upload_history.*, users.first_name, groups.name')
            ->from('data_lelang_upload_history')
            ->join('users', 'users.id = data_lelang_upload_history.created_by')
            ->join('groups', 'groups.id = users.group_id');
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
            $this->db->group_start();
            foreach ($where_and as $key => $value) {
                $this->db->like($key, $value);
            }
            $this->db->group_end();
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
}
