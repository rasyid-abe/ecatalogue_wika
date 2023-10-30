<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_modify_columns_on_vendor extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'start_contract' => array(
                'type' => 'date',
                'null' => TRUE,
            ),
            'end_contract' => array(
                'type' => 'date',
                'null' => TRUE,
            ),
        );

        $this->dbforge->modify_column('vendor', $fields);

    }

    public function down()
    {

    }
}
