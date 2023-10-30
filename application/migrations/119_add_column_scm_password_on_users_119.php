<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_scm_password_on_users_119 extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'scm_password' => array(
                'type'  => 'VARCHAR',
                'constraint' => 255,
                'NULL' => TRUE,
            ),
        );

        $this->dbforge->add_column('users', $fields);
    }

    public function down()
    {

    }

}
