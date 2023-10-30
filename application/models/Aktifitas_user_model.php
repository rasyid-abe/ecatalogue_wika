<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Aktifitas_user_model extends MY_Model
{
    protected $table = 'aktifitas_user';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_last_activity($where, $limit = 5)
    {
        $query = $this->db->limit($limit)->order_by('created_at', 'DESC')
            ->where($where)->get('aktifitas_user');

        return $query->result();
    }
}
