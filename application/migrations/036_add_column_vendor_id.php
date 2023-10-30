<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_vendor_id extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
       
        $fields = array(
            'vendor_id' => array(
                'type' => 'INT(11)',
                'default' => 0,
            ),
        );
        $this->dbforge->add_column('users', $fields);

    }

    public function down()
    {
        
    }
}