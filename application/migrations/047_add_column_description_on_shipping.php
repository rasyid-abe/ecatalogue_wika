<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_description_on_shipping extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'description' => array(
                'type' => 'text',
                'null' => TRUE,
            ),
        );
        $this->dbforge->add_column('shipping', $fields);

    }

    public function down()
    {

    }
}
