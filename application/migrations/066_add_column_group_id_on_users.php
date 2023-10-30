<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_group_id_on_users extends CI_Migration {

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
        );
        $this->dbforge->add_column('users', $fields);

    }

    public function down()
    {

    }
}
