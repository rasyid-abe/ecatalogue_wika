<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_pakta_integritas extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $table = "pakta_integritas";
        $fields = array(
            'id' => array(
                'type'           => 'INT',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ),
            'role_id' => array(
                'type'           => 'INT',
                'constraint'    => 11,
                'NULL'          => TRUE,
            ),
            'description' => array(
                'type'           => 'TEXT',
                'NULL'          => TRUE,
            ),
            'is_deleted' => array(
                'type'  => 'TINYINT(1)',
                'default'  => 0,
            ),
            'created_by' => array(
                'type' => 'INT',
                'constraint' => 11,
                'NULL' => TRUE,
            ),
            'updated_by' => array(
                'type' => 'INT',
                'constraint' => 11,
                'NULL' => TRUE,
            ),
            'created_at  timestamp DEFAULT CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table($table);

        $data_menu = array(
            array('id'=>32,'module_id'=>1, 'name'=>'Pakta Integritas', 'url'=>'pakta_integritas', 'parent_id'=>29, 'icon'=>"fa fa-circle-o", 'sequence'=>8),
       );
       $this->db->insert_batch('menu', $data_menu);

       $data_menu_function = [];
       foreach(range(30,40) as $menu_id)
       {
           foreach(range(1,5) as $function_id)
           {
               $data_menu_function[] = [
                   'menu_id' => $menu_id,
                   'function_id' => $function_id,
               ];
           }
       }
       $this->db->insert_batch('menu_function', $data_menu_function);

       $data_role = [
           'id' => '5',
           'name' => 'Mandor',
           'description' => 'Mandor'
       ];
       $this->db->insert('roles', $data_role);

    }

    public function down()
    {

    }

}
