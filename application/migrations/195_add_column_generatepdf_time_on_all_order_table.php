<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_generatepdf_time_on_all_order_table extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'generatepdf_time'      => [
               'type' => 'TIMESTAMP',
               'NULL' => TRUE,
           ],
        );

        $this->dbforge->add_column('order_transportasi', $fields);
        $this->dbforge->add_column('order_asuransi', $fields);
        $this->dbforge->add_column('order', $fields);
    }

    public function down()
    {

    }

}
