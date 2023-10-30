<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_category_id_on_specification extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'category_id' => array(
                'type' => 'INT(11)',
                'null' => TRUE,
                'default'  =>0,
            ),
        );
        $this->dbforge->add_column('specification', $fields);

    }

    public function down()
    {

    }
}
