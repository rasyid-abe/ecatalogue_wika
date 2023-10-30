<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_amandemen_asuransi_ver_1 extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $this->dbforge->drop_table('amandemen_asuransi');
        $table = "amandemen_asuransi";
        $fields = array(
            'id' => array(
                'type'           => 'INT(11)',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'id_asuransi' => array(
                'type'           => 'INT(11)',
                'NULL'          => TRUE,
            ),
            'no_amandemen' => array(
                'type'           => 'INT(4)',
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
            'volume'          => [
                'type'  => 'DECIMAL(20,4)',
                'default' =>0,
            ],
            'harga'            => [
                'type'         => 'BIGINT(20)',
                'default' =>0,
            ],
            'created_at  timestamp DEFAULT CURRENT_TIMESTAMP',
            'created_by' => array(
                'type'           => 'INT(11)',
                'NULL'          => TRUE,
            ),
            'scm_id' => array(
                'type'           => 'INT(11)',
                'NULL'          => TRUE,
            )
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table($table);
    }

    public function down()
    {

    }

}
