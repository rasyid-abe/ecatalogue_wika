<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_payment_method_id_on_project extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'payment_method_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'NULL' => TRUE,
            ),
        );

        $this->dbforge->add_column('project', $fields);



    }

    public function down()
    {

    }
}
