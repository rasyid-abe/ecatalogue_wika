<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_departemen_code_on_groups extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'departemen_code' => array(
                'type'  => 'VARCHAR',
                'constraint' => 100,
                'NULL' => TRUE
            ),
        );

        $this->dbforge->add_column('groups', $fields);
    }

    public function down()
    {

    }

}
