<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_weight_minimum extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'weight_minimum'      => [
               'type' => 'decimal(15,2)',
               'default' => 0,
           ],
        );

        $this->dbforge->add_column('order_transportasi', $fields);
        $this->dbforge->add_column('kontrak_transportasi', $fields);
    }

    public function down()
    {

    }

}
