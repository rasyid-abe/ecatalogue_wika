<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_change_password_superadmin extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $this->db->where(['id' => 1])->update('users',['password' => sha1('password')]);
    }

    public function down()
    {

    }

}
