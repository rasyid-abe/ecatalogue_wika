<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_dir_pos_on_vendor extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'dir_pos' => array(
                'type'  => 'VARCHAR(255)',
                'NULL' => TRUE,

            ),
        );

        $this->dbforge->add_column('vendor', $fields);
    }

    public function down()
    {

    }

}
