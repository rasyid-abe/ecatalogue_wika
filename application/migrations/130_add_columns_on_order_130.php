<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_on_order_130 extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'vendor_id' => array(
                'type'  => 'INT',
                'constraint' => 11,
                'NULL' => TRUE
            ),
            'vendor_name' => array(
                'type'  => 'VARCHAR',
                'constraint' => 255,
                'NULL' => TRUE
            ),
        );

        $this->dbforge->add_column('order', $fields);
    }

    public function down()
    {

    }

}
