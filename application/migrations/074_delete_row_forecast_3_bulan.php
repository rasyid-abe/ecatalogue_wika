<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_delete_row_forecast_3_bulan extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $this->db->where('id', 25);
        $this->db->delete('menu');

    }

    public function down()
    {

    }
}
