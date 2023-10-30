<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_price_upper extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'price_upper' => array(
                'type'  => 'BIGINT(20)',
                'NULL' => TRUE,
            ),
        );

        $this->dbforge->add_column('forecast_detail', $fields);
    }

    public function down()
    {

    }

}
