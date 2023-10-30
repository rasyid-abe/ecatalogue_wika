<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_margis_on_category extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'is_margis' => array(
                'type' => 'TINYINT',
                'constraint' => 2,
                'null' => TRUE,
                'default'  =>0,
            ),
            'is_non_margis' => array(
                'type' => 'TINYINT',
                'constraint' => 2,
                'null' => TRUE,
                'default'  =>0,
            ),
        );
        $this->dbforge->add_column('category', $fields);

    }

    public function down()
    {

    }
}
