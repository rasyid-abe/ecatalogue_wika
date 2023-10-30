<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_dp_no_surat extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'no_surat' => array(
                'type' => 'VARCHAR(100)',
                'NULL' => TRUE
            ),
            'dp' => array(
                'type' => 'BIGINT(20)',
                'NULL' => TRUE
            ),
        );
        $this->dbforge->add_column('order', $fields);

    }

    public function down()
    {

    }
}
