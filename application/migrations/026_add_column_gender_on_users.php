<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_gender_on_users extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
       
        $fields = array(
            'gender' => array(
                'type' => 'TINYINT',
                'constraint' => 2,
                'null' => TRUE,
                'default'  =>0,
            ),
        );
        $this->dbforge->add_column('users', $fields);

    }

    public function down()
    {
        
    }
}