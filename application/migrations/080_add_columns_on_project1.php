<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_on_project1 extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'vendor_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'NULL' => TRUE,
            ),
            'no_contract' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'NULL' => TRUE,
            ),
            'file_contract' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'NULL' => TRUE,
            ),
            'start_contract' => array(
                'type' => 'DATE',
                'NULL' => TRUE,
            ),
            'end_contract' => array(
                'type' => 'DATE',
                'NULL' => TRUE,
            ),
        );

        $this->dbforge->add_column('project', $fields);



    }

    public function down()
    {

    }
}
