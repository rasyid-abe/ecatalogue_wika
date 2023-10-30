<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_data_lelang extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $table = "data_lelang";
        $fields = array(
            'id' => array(
                'type'           => 'INT(11)',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'no' => array(
                'type'           => 'INT(11)',
                'NULL'          => TRUE,
            ),
            'departemen' => array(
                'type'           => 'VARCHAR',
                'constraint' => 100,
                'NULL'          => TRUE,
            ),
            'kategori' => array(
                'type'           => 'VARCHAR',
                'constraint' => 100,
                'NULL'          => TRUE,
            ),
            'nama' => array(
                'type'           => 'VARCHAR',
                'constraint' => 255,
                'NULL'          => TRUE,
            ),
            'spesifikasi' => array(
                'type'           => 'VARCHAR',
                'constraint' => 255,
                'NULL'          => TRUE,
            ),
            'harga' => array(
                'type'           => 'VARCHAR',
                'constraint' => 255,
                'NULL'          => TRUE,
            ),
            'vendor' => array(
                'type'           => 'VARCHAR',
                'constraint' => 255,
                'NULL'          => TRUE,
            ),
            'tgl_terkontrak' => array(
                'type'           => 'VARCHAR',
                'constraint' => 255,
                'NULL'          => TRUE,
            ),
            'tgl_akhir_kontrak' => array(
                'type'           => 'VARCHAR',
                'constraint' => 255,
                'NULL'          => TRUE,
            ),
            'volume' => array(
                'type'           => 'VARCHAR',
                'constraint' => 255,
                'NULL'          => TRUE,
            ),
            'satuan' => array(
                'type'           => 'VARCHAR',
                'constraint' => 255,
                'NULL'          => TRUE,
            ),
            'proyek_pengguna' => array(
                'type'           => 'VARCHAR',
                'constraint' => 255,
                'NULL'          => TRUE,
            ),
            'lokasi' => array(
                'type'           => 'VARCHAR',
                'constraint' => 255,
                'NULL'          => TRUE,
            ),
            'keterangan' => array(
                'type'           => 'VARCHAR',
                'constraint' => 255,
                'NULL'          => TRUE,
            ),
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table($table);
    }

    public function down()
    {

    }

}
