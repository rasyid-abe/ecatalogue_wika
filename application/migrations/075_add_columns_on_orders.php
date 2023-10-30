<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_on_orders extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'location_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'NULL' => TRUE,
            ),
            'location_name' => array(
                'type' => 'varchar',
                'constraint' => 100,
                'NULL' => TRUE,
            ),
        );

        $this->dbforge->add_column('order', $fields);

    }

    public function down()
    {

    }
}
