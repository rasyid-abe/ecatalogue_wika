<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_truncate_tables_and_edit_url_uoms extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $tables = ['category','groups','location','payment_method','shipping','size','specification','tod','uoms'];
        foreach($tables as $table)
        {
            $this->db->truncate($table);
        }

        $this->db->where(['id' => 17]);
        $this->db->update('menu',['url' => 'uoms']);

        $this->db->where(['id' => 12]);
        $this->db->update('menu',['name' => 'Jenis']);

        $this->db->where(['id' => 15]);
        $this->db->update('menu',['name' => 'Sumber Daya']);

        $this->db->where(['id' => 18]);
        $this->db->update('menu',['name' => 'Spesifikasi']);

        
    }

    public function down()
    {

    }

}
