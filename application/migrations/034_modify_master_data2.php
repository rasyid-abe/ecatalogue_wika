<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_modify_master_data2 extends CI_Migration {
    public function up(){
        $this->dbforge->drop_column('product', 'payment_method_id');
        $fields = array(
            'category_id' => array(
                'type' => 'INT(11)',
                'default'  =>0,
            ),
            'created_at  timestamp DEFAULT CURRENT_TIMESTAMP',
            'created_by'      => [
                'type' => 'INT(11)',
            ],
            'updated_by'      => [
                'type' => 'INT(11)',
                'default' => 0,
            ],
            'update_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        );
        $this->dbforge->add_column('product', $fields);

        $fields = array(
            'icon' => array(
                'type' => 'vARCHAR(100)',
                'default'  =>0,
            ),
        );
         $this->dbforge->add_column('category', $fields);
    }
    public function down(){

    }
}