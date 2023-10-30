<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_json_include_on_product extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'json_include_price' => array(
                'type' => 'text',
                'NULL' => TRUE
            ),
        );
        $this->dbforge->add_column('order_product', $fields);

    }

    public function down()
    {

    }
}
