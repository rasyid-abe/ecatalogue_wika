<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_code_on_category_and_specification extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'code' => array(
                'after' => 'id',
                'type' => 'VARCHAR',
                'constraint' => 100,
                'NULL' => TRUE,
            ),
        );

        foreach(['category','specification'] as $v)
        {
            $this->dbforge->add_column($v, $fields);
        }



    }

    public function down()
    {

    }
}
