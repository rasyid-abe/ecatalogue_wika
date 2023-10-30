<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_project_product_price extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $table = "project_product_price";
        $fields = array(
            'id' => array(
                'type'           => 'INT',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'project_id' => array(
                'type'           => 'INT',
                'NULL'          => TRUE,
            ),
            'amandemen_id' => array(
                'type'           => 'INT',
                'NULL'          => TRUE,
            ),
            'product_id' => array(
                'type'           => 'INT',
                'NULL'          => TRUE,
            ),
            'payment_id' => array(
                'type'           => 'INT',
                'NULL'          => TRUE,
            ),
            'price' => array(
                'type'           => 'BIGINT',
                'DEFAULT'          => 0,
            ),
            'created_at  timestamp DEFAULT CURRENT_TIMESTAMP',
            'is_deleted' => array(
                'type' => 'TINYINT',
                'default'  =>0,
            ),
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table($table);
    }

    public function down()
    {

    }

}
