<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_forecast_detail extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $table = "forecast_detail";
        $fields = array(
            'id' => array(
                'type'           => 'INT(11)',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'forecast_id' => array(
                'type'          => 'INT(11)',
                'NULL'          => TRUE,
            ),
            'price' => array(
                'type'          => 'BIGINT(20)',
                'NULL'          => TRUE,
            ),
            'month' => array(
                'type'          => 'TINYINT(2)',
                'NULL'          => TRUE,
            ),
            'year' => array(
                'type'          => 'SMALLINT(4)',
                'NULL'          => TRUE,
            ),
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table($table);
    }

    public function down()
    {

    }

}
