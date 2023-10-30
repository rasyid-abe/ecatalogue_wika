<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_pdf_name_on_order_131 extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'pdf_name' => array(
                'type'  => 'VARCHAR',
                'constraint' => 255,
                'NULL' => TRUE
            ),            
        );

        $this->dbforge->add_column('order', $fields);
    }

    public function down()
    {

    }

}
