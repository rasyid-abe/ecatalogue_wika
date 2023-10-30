<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_project_new extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $table = "project_new";
        $fields = array(
            'id' => array(
                'type'           => 'INT',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'name' => array(
                'type'           => 'VARCHAR(255)',
                'NULL'          => TRUE,
            ),
            'departemen_id' => array(
                'type'           => 'INT',
                'NULL'          => TRUE,
            ),
            'created_at  timestamp DEFAULT CURRENT_TIMESTAMP',
            'is_deleted' => array(
                'type' => 'TINYINT',
                'default'  =>0,
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
