<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_modify_columns_volume_sisa_and_terpakai extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'volume_sisa' => array(
                'type'  => 'DECIMAL(20,4)',
                'default' =>0,
            ),
            'volume_terpakai' => array(
                'type'  => 'DECIMAL(20,4)',
                'default' =>0,
            ),  
        );

        $this->dbforge->modify_column('project', $fields);
    }

    public function down()
    {

    }

}
