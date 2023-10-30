<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Approve_po_rules_model extends MY_Model
{
    protected $table = 'approve_po_rules';

    public function __construct()
    {
        parent::__construct();
    }


    public function getMainQuery()
    {
        $this->db->select("a.*, b.name as departemen_name, c.name as role_name")
        ->from('approve_po_rules as a')
        ->join('groups as b', 'a.departemen_id = b.id')
        ->join('roles as c','c.id = a.role_id');
    }


    public function get_all_approve_po_list($where = [], $order = 'sequence')
    {
        $query = $this->db->order_by($order, 'ASC')->get_where('approve_po_rules',$where);

        return $query->result();
    }
}
