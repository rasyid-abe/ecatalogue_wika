<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_no_contract_vendor extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
       
        $fields = array(
            'no_contract' => array(
                'type' => 'VARCHAR(100)',
                'null' => TRUE,
            ),
        );
        $this->dbforge->add_column('vendor', $fields);

    }

    public function down()
    {
        
    }
}