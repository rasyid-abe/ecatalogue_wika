<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_approve_po_rules extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        
        $table = "approve_po_rules";
        $fields = array(
            'id' => array(
                'type'           => 'INT',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'role_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'NULL' => TRUE,
            ),
            'sequence' => array(
                'type' => 'INT',
                'constraint' => 11,
                'NULL' => TRUE,
            ),
            'created_at timestamp DEFAULT CURRENT_TIMESTAMP',
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table($table);


        $table = "approve_po_list";
        $fields = array(
            'id' => array(
                'type'           => 'INT',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'order_no' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'NULL' => TRUE,
            ),
            'role_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'NULL' => TRUE,
            ),
            'status_approve'      => [
				'type' => 'TINYINT(1)',
				'default' => 0,
			],
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
            'created_at timestamp DEFAULT CURRENT_TIMESTAMP',
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
