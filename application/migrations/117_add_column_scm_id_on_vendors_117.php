<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_scm_id_on_vendors_117 extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'scm_id' => array(
                'type'  => 'INT',
                'constraint' => 11,
                'NULL' => TRUE,
            ),
        );

        $this->dbforge->add_column('vendor', $fields);

    }

    public function down()
    {

    }

}
