<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_ttd_on_groups extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'ttd' => array(
                'type'  => 'VARCHAR(255)',
                'NULL' => TRUE,
            ),
        );

        $this->dbforge->add_column('groups', $fields);
    }

    public function down()
    {

    }

}
