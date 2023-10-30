<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_on_kontrak_transportasi_asuransi_dan_project extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        
        $fields = array(
            'tahun'      => [
               'type' => 'INT',
               'NULL' => TRUE,
           ],
           'no_cargo_insurance'      => [
              'type' => 'VARCHAR(100)',
              'NULL' => TRUE,
          ],
        );
        $this->dbforge->add_column('asuransi', $fields);

        $fields = array(
            'data_trailer'      => [
               'type' => 'TEXT',
               'NULL' => TRUE,
           ],
        );
        $this->dbforge->add_column('kontrak_transportasi', $fields);

        $fields = array(
            'alamat'      => [
               'type' => 'VARCHAR(255)',
               'NULL' => TRUE,
           ],

           'contact_person'      => [
              'type' => 'VARCHAR(100)',
              'NULL' => TRUE,
          ],
          'no_hp'      => [
             'type' => 'VARCHAR(100)',
             'NULL' => TRUE,
         ],
        );
        $this->dbforge->add_column('project_new', $fields);

    }

    public function down()
    {

    }

}
