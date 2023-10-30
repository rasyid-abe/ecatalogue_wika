<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_is_deleted_on_data_lelang extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'is_deleted'      => [
               'type' => 'TINYINT(1)',
               'default' => 0,
           ]
        );

        $table = 'data_lelang';
        $this->dbforge->add_column($table, $fields);

    }

    public function down()
    {

    }

}
