<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_master_enum_aktifitas_category_151 extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $data = [
            ['id' => 2, 'name' => 'Order', 'ref_table' => 'order'],
            ['id' => 3, 'name' => 'Kontrak', 'ref_table' => 'project'],
            ['id' => 4, 'name' => 'Amandemen', 'ref_table' => 'amandemen'],
        ];

        $this->db->insert_batch('enum_aktifitas_category', $data);
    }

    public function down()
    {

    }

}
