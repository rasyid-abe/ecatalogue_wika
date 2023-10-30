<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_product_forecast_detail extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'industrial_plant'      => [
				'type' => 'BIGINT(20)',
				'default' => 0,
			],
            'plant_energy'      => [
                'type' => 'BIGINT(20)',
                'default' => 0,
            ],
            'luar_negeri'      => [
                'type' => 'BIGINT(20)',
                'default' => 0,
            ],
            'sipil1'      => [
                'type' => 'BIGINT(20)',
                'default' => 0,
            ],
            'sipil2'      => [
                'type' => 'BIGINT(20)',
                'default' => 0,
            ],
            'sipil3'      => [
                'type' => 'BIGINT(20)',
                'default' => 0,
            ],
        );
        $this->dbforge->add_column('product_forecast_detail', $fields);

    }

    public function down()
    {

    }
}
