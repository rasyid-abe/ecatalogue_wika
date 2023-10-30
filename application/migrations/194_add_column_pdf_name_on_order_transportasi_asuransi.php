<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_pdf_name_on_order_transportasi_asuransi extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'pdf_name'      => [
               'type' => 'VARCHAR(255)',
               'NULL' => TRUE,
           ],
        );

        $this->dbforge->add_column('order_transportasi', $fields);
        $this->dbforge->add_column('order_asuransi', $fields);
    }

    public function down()
    {

    }

}
