<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_on_category_110 extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $fields = array(
            'category_new_id' => array(
                'type'  => 'INT',
                'NULL' => TRUE,
            ),
        );

        $this->dbforge->add_column('category', $fields);

        $this->db->query("UPDATE category a
                        INNER JOIN category_new b
                        ON b.code = SUBSTRING(a.code,1,1)
                        SET a.category_new_id = b.id ");

    }

    public function down()
    {

    }
}
