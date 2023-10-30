<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Amandemen_model extends MY_Model
{
    protected $table = 'amandemen';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_scm_amandemen()
    {
        $ret = [];
        $query = $this->db->where('scm_id IS NOT NULL', NULL)->get('amandemen');

        foreach ($query->result() as $v) {
            $ret[$v->id] = $v->scm_id;
        }

        return $ret;
    }

    public function getMainQuery()
    {
        $this->db->select("a.id , a.start_contract , a.end_contract , b.no_contract , a.no_amandemen, a.volume, a.harga, c.name as vendor_name, d.name as departemen_name
        , a.created_at as tgl_amandemen")
            ->from('amandemen as a')
            ->join('project as b', 'a.id_project = b.id')
            ->join('vendor as c', 'c.id = b.vendor_id ', 'left')
            ->join('groups as d', 'd.id = b.departemen_pemantau_id');
    }

    public function get_no_amandemen_terakhir($id_project)
    {
        $query = $this->db->select('MAX(no_amandemen) as no_amandemen')
            ->where('id_project', $id_project)
            ->get('amandemen');

        return $query->row();
    }

    public function get_row_amandemen_terakhir($id_project)
    {
        $query = $this->db->select('*')
            ->where('id_project', $id_project)
            ->order_by('id', 'desc')
            ->get('amandemen');
        if ($query->num_rows() > 0) {
            return $query->row();
        }

        return FALSE;
    }


    public function get_detail_amandemen_list_by($where = [])
    {
        $this->db->select("CONCAT(i.name,' ',d.`day` ,' hari') as payment_method_full,
CONCAT(g.code) as code_full, CONCAT(e.name) as product_name, a.harga, b.id
, c.no_contract , b.no_amandemen , c.name as project_name")
            ->from('amandemen_products as a')
            ->join('amandemen as b', 'a.amandemen_id = b.id')
            ->join('project as c', 'b.id_project = c.id')
            ->join('payment_method as d', 'd.id = c.payment_method_id', 'left')
            ->join('product as e', 'a.product_id = e.id')
            ->join('resources_code as g', 'e.code_1 = g.code', 'left')
            ->join('enum_payment_method as i', 'i.id = d.enum_payment_method_id', 'left');
        $this->db->where($where);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
}
