<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_location_id_on_project_product_price extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'location_id' => array(
                'type'  => 'INT(11)',
                'NULL'  => TRUE,
            ),
        );
        $this->dbforge->add_column('project_product_price', $fields);
        // Set Location_id untuk product yang sudah digenerate
        $this->db->query('UPDATE project_product_price a
        INNER JOIN 
        payment_product b
        ON a.payment_id = b.payment_id AND a.product_id = b.product_id
        SET a.location_id = b.location_id
        WHERE a.is_deleted = 0');
    }

    public function down()
    {

    }

}
