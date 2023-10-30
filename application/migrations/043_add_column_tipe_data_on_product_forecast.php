<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_tipe_data_on_product_forecast extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'tipe_forecast'      => [
				'type' => 'TINYINT(1)',
				'default' => 0,
			],
        );
        $this->dbforge->add_column('product_forecast', $fields);

    }

    public function down()
    {

    }
}
