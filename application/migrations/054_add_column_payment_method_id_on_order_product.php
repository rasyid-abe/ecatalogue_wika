<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_payment_method_id_on_order_product extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'payment_method_id' => array(
                'type' => 'INT(11)',
            ),
        );
        $this->dbforge->add_column('order_product', $fields);

    }

    public function down()
    {

    }
}
