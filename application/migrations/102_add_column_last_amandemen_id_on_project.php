<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_last_amandemen_id_on_project extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'last_amandemen_id' => array(
                'type'  => 'INT',
                'NULL' => TRUE,
            ),
        );

        $this->dbforge->add_column('project', $fields);

    }

    public function down()
    {

    }
}
