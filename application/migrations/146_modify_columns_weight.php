<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_modify_columns_weight extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'default_weight' => array(
                'type'  => 'DECIMAL(20,4)',
                'default' => 0,
            ),
        );

        $this->dbforge->modify_column('size', $fields);
    }

    public function down()
    {

    }

}
