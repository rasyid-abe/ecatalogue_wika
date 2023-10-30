<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_location_id_on_payment_product extends CI_Migration {

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
                'NULL' => TRUE
            ),
        );

        $this->dbforge->add_column('payment_product', $fields);

    }

    public function down()
    {

    }
}
