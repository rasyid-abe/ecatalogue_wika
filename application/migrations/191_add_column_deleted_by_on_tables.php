<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_deleted_by_on_tables extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'deleted_by'      => [
               'type' => 'INT(11)',
               'NULL' => TRUE,
           ],
           'deleted_time'      => [
              'type' => 'TIMESTAMP',
              'NULL' => TRUE,
          ],
        );

        $tables = [
            'product'
            , 'project'
            , 'project_new'
            , 'transportasi'
            , 'category_new'
            , 'category'
            , 'vendor_lokasi'
            , 'specification',
            'payment_method',
            'size',
            'uoms',
            'shipping',
            'pakta_integritas',
            'kontrak_transportasi',
            'asuransi'
        ];

        foreach ($tables as $table)
        {
            $this->dbforge->add_column($table, $fields);
        }

    }

    public function down()
    {

    }

}
