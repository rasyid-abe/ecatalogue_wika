<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_location_id_on_project_new extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'location_id' => array(
                'type'  => 'INT(11)',
                'NULL' => TRUE,
            ),
        );

        $this->dbforge->add_column('project_new', $fields);
    }

    public function down()
    {

    }

}
