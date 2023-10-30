<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_on_orders_125 extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'approve_sequence' => array(
                'type'  => 'INT',
                'constraint' => 11,
                'default' => 0,
            ),
            'is_approve_complete' => array(
                'type'  => 'TINYINT',
                'default' => 0,
            ),
        );

        $this->dbforge->add_column('order', $fields);
    }

    public function down()
    {

    }

}
