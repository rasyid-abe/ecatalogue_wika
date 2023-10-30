<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_modify_columns_harga_on_data_lelang extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'harga' => array(
                'type'  => 'DECIMAL(20,2)',
                'default' =>0,
            ),
        );

        $this->dbforge->modify_column('data_lelang', $fields);
    }

    public function down()
    {

    }

}
