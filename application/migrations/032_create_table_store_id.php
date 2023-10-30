<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_create_table_store_id extends CI_Migration {
    public function up(){
        $table = 'stored_id';
        $fields = [
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE,
            ],
            'created_at  timestamp DEFAULT CURRENT_TIMESTAMP',
            'dummy_column' => [
                'type' => 'TINYINT(1)',
            ],
        ];
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table($table);
    }
    public function down(){

    }
}