<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_transport_amandemen extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $table = "transport_amandemen";
        $fields = array(
            'id' => array(
                'type'           => 'INT(11)',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'kontrak_transportasi_id' => array(
                'type'           => 'INT(11)',
                'NULL'          => TRUE,
            ),
            'no_amandemen' => array(
                'type'           => 'INT(11)',
                'NULL'          => TRUE,
            ),
            'start_contract' => [
                'type' => 'DATE',
                'NULL' => TRUE,
            ],
            'end_contract' => [
                'type' => 'DATE',
                'NULL' => TRUE,
            ],
            'created_at  timestamp DEFAULT CURRENT_TIMESTAMP',
            'created_by' => array(
                'type'           => 'INT(11)',
                'NULL'          => TRUE,
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
