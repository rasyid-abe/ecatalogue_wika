<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_on_project_products extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'is_kontrak' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'  =>0,
            ),
            'is_deleted' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'  =>0,
            ),
        );
        $this->dbforge->add_column('project_products', $fields);



    }

    public function down()
    {

    }
}
