<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_log_on_master_data_menu extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'created_by' => array(
                'type' => 'INT',
                'constraint' => 11,
                'NULL' => TRUE,
            ),
            'updated_by' => array(
                'type' => 'INT',
                'constraint' => 11,
                'NULL' => TRUE,
            ),
            'created_at  timestamp DEFAULT CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        );

        $arr_table = array('vendor', 'category', 'specification', 'payment_method','shipping','location','size','tod','project');
        foreach($arr_table as $v)
        {
            $this->dbforge->add_column($v, $fields);
        }

    }

    public function down()
    {

    }
}
