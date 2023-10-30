<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_on_project_084 extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'departemen_pemantau_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'NULL' => TRUE,
            ),
            'user_pemantau_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'NULL' => TRUE,
            ),
            'volume'          => [
                'type'  => 'FLOAT',
                'default' =>0,
            ],
            'harga'            => [
                'type'         => 'BIGINT(20)',
                'default' =>0,
            ],
        );

        $this->dbforge->add_column('project', $fields);



    }

    public function down()
    {

    }
}
