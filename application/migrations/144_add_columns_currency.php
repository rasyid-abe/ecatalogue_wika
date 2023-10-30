<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_currency extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'currency' => array(
                'type'  => 'VARCHAR(20)',
                'default' => 'Rp',
            ),
        );

        $this->dbforge->add_column('data_lelang', $fields);
    }

    public function down()
    {

    }

}
