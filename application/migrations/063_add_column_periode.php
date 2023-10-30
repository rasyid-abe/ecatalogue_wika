<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_periode extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'periode' => array(
                'type' => 'TINYINT(2)',
                'default'=>0
            ),
        );
        $this->dbforge->add_column('forecast', $fields);

    }

    public function down()
    {

    }
}
