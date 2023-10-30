<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_sequence_on_approve_po_list extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'sequence' => array(
                'type'  => 'INT(11)',
                'default' => 0,
            ),
            'departemen_id' => array(
                'type'  => 'INT(11)',
                'NULL' => TRUE,
            ),
        );

        $this->dbforge->add_column('approve_po_list', $fields);
    }

    public function down()
    {

    }

}
