<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_is_editable_on_location extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'is_editable' => array(
                'type'  => 'INT(1)',
                'default' => 0
            ),
        );
        $this->dbforge->add_column('location', $fields);
    }

    public function down()
    {

    }

}
