<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_on_forecast_detail extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'is_deleted' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0
            ),
        );
        $this->dbforge->add_column('forecast_detail', $fields);

    }

    public function down()
    {

    }
}
