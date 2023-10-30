<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_data_traller_on_order_transportasi extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'data_traller'      => [
               'type' => 'TEXT',
               'NULL' => TRUE,
           ],
        );

        $this->dbforge->add_column('order_transportasi', $fields);
    }

    public function down()
    {

    }

}
