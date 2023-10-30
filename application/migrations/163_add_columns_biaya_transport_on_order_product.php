<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_biaya_transport_on_order_product extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'biaya_transport' => array(
                'type'  => 'DECIMAL(20,2)',
                'default' => 0
            ),
            'transportasi_id' => array(
                'type'  => 'INT(11)',
                'NULL' => TRUE,
            ),
        );
        $this->dbforge->add_column('order_product', $fields);
    }

    public function down()
    {

    }

}
