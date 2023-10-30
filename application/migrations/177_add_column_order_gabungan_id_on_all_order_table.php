<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_order_gabungan_id_on_all_order_table extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'order_gabungan_id' => array(
                'type'  => 'INT(11)',
                'NULL' => TRUE,
            )
        );
        foreach (['order','order_transportasi','order_asuransi'] as $table)
        {
            $this->dbforge->add_column($table, $fields);
        }
    }

    public function down()
    {

    }

}
