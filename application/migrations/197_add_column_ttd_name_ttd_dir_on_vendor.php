<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_ttd_name_ttd_dir_on_vendor extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'ttd_name'      => [
               'type' => 'VARCHAR(255)',
               'NULL' => TRUE,
           ],
           'ttd_pos'      => [
              'type' => 'VARCHAR(255)',
              'NULL' => TRUE,
          ],
        );

        $this->dbforge->add_column('vendor', $fields);
    }

    public function down()
    {

    }

}
