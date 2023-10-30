<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Iklan_model extends MY_Model
{
    protected $table = 'iklan';

    public function __construct()
    {
        parent::__construct();
    }

    public function getMainQuery()
    {
        $this->db->select("a.*, IF(a.role_id = 0, 'Semua Role', b.name) as role_name")
            ->from('iklan as a')
            ->join('roles as b', 'b.id = a.role_id', 'left');
    }
}
