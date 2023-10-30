<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class List_feedback_model extends MY_Model
{
    protected $table = 'list_feedback';

    public function __construct()
    {
        parent::__construct();
    }


    public function getMainQuery()
    {
        $this->db->select("a.*, b.name as kategori_name, c.first_name as nama_user, e.name as role_name")
        ->from('list_feedback as a')
        ->join('kategori_feedback as b','b.id = a.kategori_feedback_id')
        ->join('users as c','c.id = a.created_by')
        ->join('users_roles as d','d.user_id = c.id')
        ->join('roles as e','e.id = d.role_id');
    }


}
