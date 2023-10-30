<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_on_order_product extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'price' => array(
                'type' => 'BIGINT(11)',
                'default' => 0,
                'NULL' => TRUE,
            ),
            'include_price' => array(
                'type' => 'BIGINT(11)',
                'default' => 0,
                'NULL' => TRUE,
            ),
            'weight' => array(
                'type' => 'float',
                'NULL' => TRUE,
            ),
            'full_name_product' => array(
                'type' => 'text',
                'NULL' => TRUE,
            ),
            'payment_mehod_name' => array(
                'type' => 'text',
                'NULL' => TRUE,
            ),
            'uom_name' => array(
                'type' => 'text',
                'NULL' => TRUE,
            ),
            'vendor_id' => array(
                'type' => 'INT(11)',
                'NULL' => TRUE,
            ),
            'vendor_name' => array(
                'type' => 'text',
                'NULL' => TRUE,
            ),

        );
        $this->dbforge->add_column('order_product', $fields);

    }

    public function down()
    {

    }
}
