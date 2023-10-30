<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_on_project extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'group_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'NULL' => TRUE
            ),
            'user_ids' => array(
                'type' => 'TEXT',
                'NULL' => TRUE
            ),
        );
        $this->dbforge->add_column('project', $fields);

    }

    public function down()
    {

    }
}
