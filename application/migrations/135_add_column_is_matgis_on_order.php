<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_is_matgis_on_order extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'is_matgis' => array(
                'type'  => 'TINYINT',
                'default' => 0,
            ),
        );

        $this->dbforge->add_column('order', $fields);
    }

    public function down()
    {

    }

}
