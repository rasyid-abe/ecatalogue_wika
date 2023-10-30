<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_category_new extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $table = "category_new";
        $fields = array(
            'id' => array(
                'type'           => 'INT',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'code' => array(
                'type'           => 'varchar(100)',
                'NULL'          => TRUE,
            ),
            'name' => array(
                'type'           => 'varchar(100)',
                'NULL'          => TRUE,
            ),
            'icon' => array(
                'type'           => 'varchar(100)',
                'default' => 0,
            ),
            'is_deleted' => array(
                'type'  => 'TINYINT(1)',
                'default'  => 0,
            ),
            'created_by' => array(
                'type' => 'INT',
                'constraint' => 11,
                'NULL' => TRUE,
            ),
            'updated_by' => array(
                'type' => 'INT',
                'constraint' => 11,
                'NULL' => TRUE,
            ),
            'created_at  timestamp DEFAULT CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table($table);
    }

    public function down()
    {

    }

}
