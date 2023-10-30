<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pakta_integritas_model extends MY_Model
{
    protected $table = 'pakta_integritas';

    public function __construct()
    {
        parent::__construct();
    }

    public function getMainQuery()
    {
        $this->db->select("a.*, IF(a.role_id = 0, 'Semua Role', b.name) as role_name")
        ->from('pakta_integritas as a')
        ->join('roles as b', 'b.id = a.role_id','left');
    }

}
