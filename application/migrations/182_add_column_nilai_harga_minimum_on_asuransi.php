<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_nilai_harga_minimum_on_asuransi extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'nilai_harga_minimum' => array(
                'type'  => 'DECIMAL(20,2)',
                'default' => 0
            )
        );

        foreach(['order_asuransi', 'asuransi'] as $table)
        {
            $this->dbforge->add_column($table, $fields);
        }

    }

    public function down()
    {

    }

}
