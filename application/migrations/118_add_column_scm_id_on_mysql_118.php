<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_scm_id_on_mysql_118 extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'scm_id' => array(
                'type'  => 'INT',
                'constraint' => 11,
                'NULL' => TRUE,
            ),
        );

        $mysql = ['groups','project','data_lelang','users','roles','amandemen'];

        foreach($mysql as $v)
        {
            $this->dbforge->add_column($v, $fields);
        }


        $this->db->where('id', 2);
        $this->db->update('sync_code',['sync_name' => 'Kontrak']);

    }

    public function down()
    {

    }

}
