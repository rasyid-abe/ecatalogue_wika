<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_generate_transport_price extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $table = "generate_transport_price";
        $fields = array(
            'id' => array(
                'type'           => 'INT(11)',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'kontrak_transportasi_id' => array(
                'type'           => 'INT(11)',
                'NULL'          => TRUE,
            ),
            'transport_id' => array(
                'type'           => 'INT(11)',
                'NULL'          => TRUE,
            ),
            'amandemen_id' => array(
                'type'           => 'INT(4)',
                'NULL'          => TRUE,
            ),
            'price'          => [
                'type'  => 'DECIMAL(20,2)',
                'default' =>0,
            ],
            'created_at  timestamp DEFAULT CURRENT_TIMESTAMP',
            'created_by' => array(
                'type'           => 'INT(11)',
                'NULL'          => TRUE,
            ),
            'is_deleted' => [
                'type'      => 'TINYINT',
                'default'   =>0,
            ],
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table($table);


        $data = [
            'id' => 5,
            'name' => 'Kontrak Transportasi',
            'ref_table' => 'kontrak_transportasi',
        ];

        $this->db->insert('enum_aktifitas_category', $data);
    }

    public function down()
    {

    }

}
