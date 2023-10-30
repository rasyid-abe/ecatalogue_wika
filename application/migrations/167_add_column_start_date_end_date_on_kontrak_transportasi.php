<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_start_date_end_date_on_kontrak_transportasi extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'start_date' => array(
                'type'  => 'DATE',
                'NULL' => TRUE,
            ),
            'end_date' => array(
                'type'  => 'DATE',
                'NULL' => TRUE,
            ),
        );

        $this->dbforge->add_column('kontrak_transportasi', $fields);
    }

    public function down()
    {

    }

}
