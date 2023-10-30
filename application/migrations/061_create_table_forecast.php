<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_forecast extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $table = "forecast";
        $fields = array(
            'id' => array(
                'type'           => 'INT(11)',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'category_id' => array(
                'type'          => 'INT(11)',
                'NULL'          => TRUE,
            ),
            'start_month' => array(
                'type'          => 'TINYINT(2)',
                'NULL'          => TRUE,
            ),
            'year' => array(
                'type'          => 'SMALLINT(4)',
                'NULL'          => TRUE,
            ),
            'created_at  timestamp DEFAULT CURRENT_TIMESTAMP',
               'created_by'      => [
                   'type' => 'INT(11)',
               ],
               'is_deleted'      => [
                   'type' => 'TINYINT(1)',
                   'default' => 0,
               ],
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table($table);
    }

    public function down()
    {

    }

}
