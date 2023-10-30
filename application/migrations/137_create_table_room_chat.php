<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_room_chat extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $table = "room_chat";
        $fields = array(
            'id' => array(
                'type'           => 'INT',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'vendor_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'NULL' => TRUE,
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

        $table = "room_chat_detail";
        $fields = array(
            'id' => array(
                'type'           => 'INT',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'room_chat_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'NULL' => TRUE,
            ),
            'sender' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'NULL' => TRUE,
            ),
            'chat_contenct' => array(
                'type' => 'TEXT',
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
