<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_tgl_kontrak_on_asuransi extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'tgl_kontrak' => array(
                'type'  => 'DATE',
                'NULL' => TRUE,
            )
        );

        $this->dbforge->add_column('asuransi', $fields);
    }

    public function down()
    {

    }

}
