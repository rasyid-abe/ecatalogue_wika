<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_sync_code extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $table = "sync_code";
        $fields = array(
            'id' => array(
                'type'           => 'INT',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'sync_name' => array(
                'type'  => 'VARCHAR(255)',
                'NULL'  => TRUE,
            ),
            'created_at  timestamp DEFAULT CURRENT_TIMESTAMP'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table($table);

        $data_sync_code = [
            ['id' => 1, 'sync_name' => 'Vendor'],
            ['id' => 2, 'sync_name' => 'Project'],
            ['id' => 3, 'sync_name' => 'Departemen'],
            ['id' => 4, 'sync_name' => 'Data Lelang'],
            ['id' => 5, 'sync_name' => 'Role'],
            ['id' => 6, 'sync_name' => 'User'],
            ['id' => 7, 'sync_name' => 'Amandemen'],
        ];

        $this->db->insert_batch('sync_code', $data_sync_code);

        $fields = [
            'sync_code_id' => array(
                'type'  => 'INT',
                'constraint' => 11,
                'NULL' => TRUE,
            ),
        ];

        $this->dbforge->add_column('sync_history', $fields);
    }

    public function down()
    {

    }

}
