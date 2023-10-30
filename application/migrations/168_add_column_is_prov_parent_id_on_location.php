<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_is_prov_parent_id_on_location extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'is_prov' => array(
                'type'  => 'INT(1)',
                'default' => 0
            ),
            'parent_id' => array(
                'type'  => 'INT(11)',
                'NULL'  => TRUE,
            ),
        );
        $this->dbforge->add_column('location', $fields);
    }

    public function down()
    {

    }

}
