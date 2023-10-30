<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Room_chat_model extends MY_Model
{
    protected $table = 'room_chat';

    public function __construct()
    {
        parent::__construct();
    }

    public function getMainQuery()
    {
        $this->db->select("a.*, b.first_name as user_name, b.id as user_id ,c.id as dept_id, c.name as dept_name")
        ->from('room_chat as a')
        ->join('users as b','b.id = a.user_id')
        ->join('groups as c', 'c.id = b.group_id', 'left')
        ->where('(SELECT COUNT(*) FROM room_chat_detail z WHERE z.room_chat_id = a.id) > 0',NULL,FALSE);
    }

    public function get_last_chat($room_chat_id, $id = NULL)
    {
        $sql_inner = "SELECT * FROM room_chat_detail WHERE room_chat_id = '$room_chat_id'";
        if($id)
        {
            $sql_inner .= " AND id < '$id' ";
        }
        $sql_inner .= " ORDER BY created_at DESC LIMIT 10";

        if($id)
        {
            $query = $this->db->query($sql_inner);
        }
        else
        {
            $sql = "SELECT * FROM
            ($sql_inner) chat
            ORDER BY created_at ASC";

            $query = $this->db->query($sql);
        }


        return $query->result();
    }

}
