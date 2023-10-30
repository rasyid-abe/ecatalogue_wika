<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_is_use_tranport_is_use_asuransi_on_order extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'nilai_asuransi' => array(
                'type'  => 'DECIMAL(20,2)',
                'default' => 0
            ),
            'asuransi_id' => array(
                'type'  => 'INT(11)',
                'NULL' => TRUE,
            ),
            'jenis_asuransi' => array(
                'type'  => 'VARCHAR(255)',
                'NULL' => TRUE,
            ),
        );
        $this->dbforge->add_column('order', $fields);

    }

    public function down()
    {

    }

}
