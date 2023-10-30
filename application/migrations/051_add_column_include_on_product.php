<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_include_on_product extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'is_include' => array(
                'type' => 'TINYINT',
                'constraint' => 2,
                'null' => TRUE,
                'default'  =>0,
            ),
            'include_price'            => [
                'type'         => 'BIGINT(20)',
                'default' =>0,
            ],
        );
        $this->dbforge->add_column('product', $fields);

    }

    public function down()
    {

    }
}
