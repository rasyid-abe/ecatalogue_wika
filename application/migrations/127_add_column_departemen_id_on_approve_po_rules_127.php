<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_departemen_id_on_approve_po_rules_127 extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'departemen_id' => array(
                'type'  => 'INT',
                'constraint' => 11,
                'NULL' => TRUE
            ),
        );

        $this->dbforge->add_column('approve_po_rules', $fields);
    }

    public function down()
    {

    }

}
