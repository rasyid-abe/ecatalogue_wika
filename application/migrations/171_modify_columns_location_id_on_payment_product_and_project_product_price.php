<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_modify_columns_location_id_on_payment_product_and_project_product_price extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'location_id' => array(
                'type'  => 'TEXT',
                'NULL' => TRUE,
            ),
        );
        
        foreach (['payment_product', 'project_product_price'] as $table)
        {
            $this->dbforge->modify_column($table, $fields);
        }
    }

    public function down()
    {

    }

}
