<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_notification extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $table = "notification";
        $fields = array(
            'id' => array(
                'type'           => 'INT(11)',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'id_pengirim' => array(
                'type'           => 'INT(11)',
                'NULL'          => TRUE,
            ),
            'id_penerima' => array(
                'type'           => 'INT(11)',
                'NULL'          => TRUE,
            ),
            'deskripsi' => array(
                'type'           => 'TEXT',
                'NULL'          => TRUE,
            ),
            'is_read' => array(
                    'type'  => 'TINYINT(1)',
                    'default'  => 0,
            ),
            'created_at  timestamp DEFAULT CURRENT_TIMESTAMP',
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table($table);
    }

    public function down()
    {

    }

}
