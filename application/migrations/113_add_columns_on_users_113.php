<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_on_users_113 extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'city' => array(
                'type'  => 'varchar',
                'constraint' => 255,
                'NULL' => TRUE,
            ),
            'no_identity' => array(
                'type'  => 'varchar',
                'constraint' => 255,
                'NULL' => TRUE,
            ),
            'job' => array(
                'type'  => 'varchar',
                'constraint' => 255,
                'NULL' => TRUE,
            ),
            'harga' => array(
                'type'  => 'BIGINT',
                'NULL' => TRUE,
            ),
            'ket_harga' => array(
                'type'  => 'varchar',
                'constraint' => 100,
                'NULL' => TRUE,
            ),
        );

        $this->dbforge->add_column('users', $fields);

        $table = "pengalaman_mandor";
        $fields = array(
            'id' => array(
                'type'           => 'INT',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'users_id' => array(
                'type'           => 'INT',
                'constraint'    => 11,
                'NULL'          => TRUE,
            ),
            'pengalaman' => array(
                'type'           => 'TEXT',
                'NULL'          => TRUE,
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
