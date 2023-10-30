<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_notes_on_payment_product extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'notes' => array(
                'type' => 'TEXT',
                'NULL' => TRUE
            ),
        );

        $this->dbforge->add_column('payment_product', $fields);

        
        $fields = array(
            'location_id' => array(
                'type' => 'INT(11)',
                'null' => TRUE,
            ),
        );

        $this->dbforge->modify_column('product', $fields);


    }

    public function down()
    {

    }
}
