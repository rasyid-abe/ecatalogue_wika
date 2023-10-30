<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_modify_column_payment_method_id_on_order extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'payment_method_id' => array(
                'type' => 'text',
                'null' => TRUE,
            ),
        );
        $this->dbforge->modify_column('order', $fields);

    }

    public function down()
    {

    }
}
