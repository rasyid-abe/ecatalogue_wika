<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_amandemen_products extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $table = "amandemen_products";
        $fields = array(
            'id' => array(
                'type'           => 'INT(11)',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'amandemen_id' => array(
                'type'           => 'INT(11)',
                'NULL'          => TRUE,
            ),
            'product_id' => array(
                'type'           => 'INT(11)',
                'NULL'          => TRUE,
            ),
            'harga'            => [
                'type'         => 'BIGINT(20)',
                'default' =>0,
            ],
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table($table);
    }

    public function down()
    {

    }

}
