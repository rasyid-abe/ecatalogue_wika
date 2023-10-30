<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_project_users extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $table = "project_users";
        $fields = array(
            'id' => array(
                'type'           => 'INT(11)',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'project_id' => array(
                'type'          => 'INT(11)',
                'NULL'          => TRUE,
            ),
            'user_id' => array(
                'type'          => 'INT(11)',
                'NULL'          => TRUE,
            ),
        );


        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table($table);
    }

    public function down()
    {

    }

}
