<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_uuid_fcmtoken extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
       
        $fields = array(
            'uuid' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
            'fcm_token' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
        );
        $this->dbforge->add_column('users', $fields);

    }

    public function down()
    {
        
    }
}