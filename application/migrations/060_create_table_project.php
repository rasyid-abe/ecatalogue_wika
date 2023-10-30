<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_project extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $table = "project";
        $fields = array(
            'id' => array(
                'type'           => 'INT(11)',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'name' => array(
                'type'          => 'varchar(100)',
                'NULL'          => TRUE,
            ),
            'description' => array(
                'type'          => 'text',
                'NULL'          => TRUE,
            ),
            'no_surat' => array(
                'type'          => 'varchar(100)',
                'NULL'          => TRUE,
            ),
            'tanggal' => array(
                'type'          => 'DATE',
                'NULL'          => TRUE,
            ),
            'is_deleted' => array(
                'type'  => 'TINYINT(1)',
                'default'  => 0,
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
