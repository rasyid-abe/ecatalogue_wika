<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_change_column_tod extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'term_of_delivery_id' => array(
                'TYPE' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
            ),
        );

        $this->dbforge->modify_column('product', $fields);

        // hapus menu tod
        $this->db->where('id', 21);
        $this->db->delete('menu');
    }

    public function down()
    {

    }

}
