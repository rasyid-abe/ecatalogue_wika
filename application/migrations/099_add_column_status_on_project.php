<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_status_on_project extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'status' => array(
                'type'  => 'TINYINT(1)',
                'default'  => 0,
            ),
        );

        $this->dbforge->add_column('project', $fields);

        $fields = array(
            'harga' => array(
                'type'  => 'BIGINT',
                'default'  => 0,
            ),
        );

        $this->dbforge->add_column('project_products', $fields);

    }

    public function down()
    {

    }
}
