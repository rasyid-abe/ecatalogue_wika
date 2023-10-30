<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_status_and_last_amandemen_id_on_kontrak_asuransi extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'status' => array(
                'type'  => 'TINYINT',
                'default' => 0,
            ),
            'last_amandemen_id' => array(
                'type'  => 'INT(11)',
                'NULL'  => TRUE,
            ),
        );

        $table = 'kontrak_transportasi';
        $this->dbforge->add_column($table, $fields);

    }

    public function down()
    {

    }

}
