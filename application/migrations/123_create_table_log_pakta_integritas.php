<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_log_pakta_integritas extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $table = "log_pakta_integritas";
        $fields = array(
            'id' => array(
                'type'           => 'INT',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'user_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'NULL' => TRUE,
            ),
            'created_at timestamp DEFAULT CURRENT_TIMESTAMP',
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table($table);
    }

    public function down()
    {

    }

}
