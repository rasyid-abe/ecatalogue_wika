<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_product_include_price extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $table = "product_include_price";
        $fields = array(
            'id' => array(
                'type'           => 'INT(11)',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'product_id' => array(
                'type'           => 'INT(11)',
            ),
            'price' => array(
                'type'          => 'BIGINT',
                'NULL'          => TRUE,
            ),
            'description' => array(
                'type'          => 'VARCHAR(255)',
                'NULL'          => TRUE,
            ),
            'id_deleted' => array(
                'type'  => 'TINYINT(1)',
                'default'  => 0,
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
