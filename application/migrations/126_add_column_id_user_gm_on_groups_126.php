<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_id_user_gm_on_groups_126 extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'role_id_general_manager' => array(
                'type'  => 'INT',
                'constraint' => 11,
                'NULL' => TRUE
            ),
        );

        $this->dbforge->add_column('groups', $fields);
    }

    public function down()
    {

    }

}
