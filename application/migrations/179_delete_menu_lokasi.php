<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_delete_menu_lokasi extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $this->db->where('id', 16);
        $this->db->delete('menu');

    }

    public function down()
    {

    }
}
