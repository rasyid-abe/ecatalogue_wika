<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_volume_sisa_on_project extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'volume_sisa' => array(
                'type'  => 'FLOAT',
                'default' => 0,
            ),
            'volume_terpakai' => array(
                'type'  => 'FLOAT',
                'default' => 0,
            ),
        );

        $this->dbforge->add_column('project', $fields);
    }

    public function down()
    {

    }

}
