<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_data_lelang_upload_history extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $table = "data_lelang_upload_history";
        $fields = array(
            'id' => array(
                'type'           => 'INT(11)',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'jml_row' => array(
                'type'           => 'INT(11)',
                'NULL'          => TRUE,
            ),
            'created_at  timestamp DEFAULT CURRENT_TIMESTAMP',
            'created_by' => array(
                'type'           => 'INT(11)',
                'NULL'          => TRUE,
            ),
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table($table);

        $fields = array(
            'upload_history_id'      => [
               'type' => 'INT(11)',
               'NULL' => TRUE,
           ]
        );

        $table = 'data_lelang';
        $this->dbforge->add_column($table, $fields);

    }

    public function down()
    {

    }

}
