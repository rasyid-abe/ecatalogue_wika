<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_jenis_asuransi_on_asuransi extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'jenis_asuransi' => array(
                'type'  => 'VARCHAR(100)',
                'NULL' => TRUE,
                'default' => 'percent',
            ),
        );

        $this->dbforge->add_column('asuransi', $fields);
    }

    public function down()
    {

    }

}
