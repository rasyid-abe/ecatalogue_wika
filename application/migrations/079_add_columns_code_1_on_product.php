<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_code_1_on_product extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'code_1' => array(
                'after' => 'code',
                'type' => 'VARCHAR',
                'constraint' => 100,
                'NULL' => TRUE,
            ),
        );

        $this->dbforge->add_column('product', $fields);



    }

    public function down()
    {

    }
}
