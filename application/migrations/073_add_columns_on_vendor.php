<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_on_vendor extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'no_fax' => array(
                'type' => 'varchar',
                'constraint' => 100,
                'NULL' => TRUE,
            ),
            'no_telp' => array(
                'type' => 'varchar',
                'constraint' => 100,
                'NULL' => TRUE,
            ),
            'nama_direktur' => array(
                'type' => 'varchar',
                'constraint' => 255,
                'NULL' => TRUE,
            ),
        );

        $this->dbforge->add_column('vendor', $fields);

    }

    public function down()
    {

    }
}
