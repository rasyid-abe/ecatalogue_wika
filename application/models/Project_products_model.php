<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Project_products_model extends MY_Model
{
    protected $table = 'project_products';

    public function __construct()
    {
        parent::__construct();
    }

    public function getOneBy($where = array()){
        $this->db->select("project_users.user_id, project_products.product_id")->from($this->table);
        $this->db->join('project_users','project_users.project_id = project_products.project_id');
        $this->db->where($where);
        $this->db->where("project_products.is_deleted",0);

        $query = $this->db->get();
        if ($query->num_rows() >0){
            return $query->row();
        }
        return FALSE;
    }

    public function getall($where = array()){
        $this->db->select("project_users.user_id, project_products.product_id")->from($this->table);
        $this->db->join('project_users','project_users.project_id = project_products.project_id');
        $this->db->where($where);
        $this->db->where("project_products.is_deleted",0);

        $query = $this->db->get();
        if ($query->num_rows() >0){
            return $query->result();
        }
        return FALSE;
    }
}
