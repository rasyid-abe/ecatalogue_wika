<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Data_lelang_model_new extends MY_Model
{
    protected $table = 'data_lelang_new';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_scm_data_lelang()
    {
        $ret = [];
        $query = $this->db->where('scm_id IS NOT NULL', NULL)->get('data_lelang_new');

        foreach ($query->result() as $v) {
            $ret[$v->id] = $v->scm_id;
        }

        return $ret;
    }

    public function getMainQuery()
    {
        $query = $this->db->select("*")
            ->from('data_lelang_new');
        //->where('proyek_pengguna <>', '');
        //->group_by(['proyek_pengguna' ,'vendor' , 'tgl_terkontrak' , 'tgl_akhir_kontrak']);
    }


    public function get_detail_data_lelang($where)
    {
        $query = $this->db->get_where('data_lelang_new', $where);
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return FALSE;
    }

    public function get_combo_data_lelang($column)
    {
        $this->db->select($column)
            ->from($this->table)
            ->where($column . " <> ''", NULL)
            ->group_by($column);

        $query = $this->db->get();
        return $query->result();
    }

    public function get_combo_departemen()
    {
        $this->db->select("groups.name, data_lelang_new.departemen")
            ->from('data_lelang_new')
            ->join('groups', 'groups.id = data_lelang_new.departemen')
            ->where("data_lelang_new.departemen <> ''", NULL)
            ->group_by("data_lelang_new.departemen");

        $query = $this->db->get();
        return $query->result();
    }

    public function get_combo_vendor()
    {
        $this->db->select("vendor.name, data_lelang_new.vendor")
            ->from('data_lelang_new')
            ->join('vendor', 'vendor.id = data_lelang_new.vendor')
            ->where("data_lelang_new.vendor <> ''", NULL)
            ->group_by("data_lelang_new.vendor");

        $query = $this->db->get();
        return $query->result();
    }

    public function get_combo_kategori()
    {
        $this->db->select("resources_code.name, data_lelang_new.kategori")
            ->from('data_lelang_new')
            ->join('resources_code', 'resources_code.code = data_lelang_new.kategori')
            ->where("data_lelang_new.kategori <> ''", NULL)
            ->group_by("data_lelang_new.kategori");

        $query = $this->db->get();
        return $query->result();
    }
}
