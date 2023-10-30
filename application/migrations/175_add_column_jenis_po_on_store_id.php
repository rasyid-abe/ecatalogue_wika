<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_jenis_po_on_store_id extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'jenis_po' => array(
                'type'  => 'INT',
                'NULL' => TRUE,
                'default' => 1,
            )
        );

        $this->dbforge->add_column('stored_id', $fields);
    }

    public function down()
    {

    }

}
