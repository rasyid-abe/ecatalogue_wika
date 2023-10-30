<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Notification_model extends MY_Model
{
    protected $table = 'notification';

    public function __construct()
    {
        parent::__construct();
    }

    public function getNotitForTopBar($where=[])
    {
        $this->db->select('*');
        $this->db->where($where);
        $this->db->order_by('id','desc');
        $query = $this->db->get('notification');

        if($query->num_rows() > 0)
        {
            return $query->result();
        }

        return FALSE;
    }

    public function send_notif_by_role($role , $message)
    {

    }


    public function get_last_notif($where, $limit = 5)
    {
        $query = $this->db->limit($limit)->order_by('created_at','DESC')
        ->where($where)->get('notification');

        return $query->result();


    }

}
