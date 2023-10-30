<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_modify_columns_volume_on_amandemen extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'volume' => array(
                'type'  => 'DECIMAL(20,4)',
                'default' =>0,
            ),            
        );

        $this->dbforge->modify_column('amandemen', $fields);
    }

    public function down()
    {

    }

}
