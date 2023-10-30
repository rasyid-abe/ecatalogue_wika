<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_modify_size_and_shipping_data_dummy extends CI_Migration {
    public function up(){
        $this->db->query('truncate table size');

        $fields = array(
            'specification_id' => array(
                'type' => 'INT(11)',
                'default'  =>0,
            ),
            'default_weight' => array(
                'type' => 'FLOAT',
                'default'  =>0,
            ),
        );
        $this->dbforge->add_column('size', $fields);

        $data_menu = array(
            array(
                'id'        =>1,
                'name'      =>"Dia. 8 mm x 12 m",
                'specification_id' =>1,
                'default_weight' =>4.74,
            ),
             array(
                'id'        =>2,
                'name'      =>"Dia. 10 mm x 12 m",
                'specification_id' =>1,
                'default_weight' =>7.40,
            ),
              array(
                'id'        =>3,
                'name'      =>"Dia. 12 mm x 12 m",
                'specification_id' =>1,
                'default_weight' =>10.66,
            ),
            array(
                'id'        =>4,
                'name'      =>"Dia. 10 mm x 12 m",
                'specification_id' =>2,
                'default_weight' =>7.40,
            ),
            array(
                'id'        =>5,
                'name'      =>"Dia. 13 mm x 12 m",
                'specification_id' =>2,
                'default_weight' =>12.48,
            ),
            array(
                'id'        =>6,
                'name'      =>"Dia. 16 mm x 12 m",
                'specification_id' =>2,
                'default_weight' =>18.96,
            ),
            array(
                'id'        =>7,
                'name'      =>"Dia. 19 mm x 12 m",
                'specification_id' =>2,
                'default_weight' =>26.76,
            ),
            array(
                'id'        =>8,
                'name'      =>"Dia. 22 mm x 12 m",
                'specification_id' =>2,
                'default_weight' =>35.76,
            ),
            array(
                'id'        =>9,
                'name'      =>"Dia. 25 mm x 12 m",
                'specification_id' =>2,
                'default_weight' =>46.20,
            ),
            array(
                'id'        =>10,
                'name'      =>"Dia. 29 mm x 12 m",
                'specification_id' =>2,
                'default_weight' =>62.28,
            ),
            array(
                'id'        =>11,
                'name'      =>"Dia. 32 mm x 12 m",
                'specification_id' =>2,
                'default_weight' =>75.72,
            ),
            array(
                'id'        =>12,
                'name'      =>"Dia. 36 mm x 12 m",
                'specification_id' =>2,
                'default_weight' =>95.88,
            ),
            array(
                'id'        =>13,
                'name'      =>"Dia. 40 mm x 12 m",
                'specification_id' =>2,
                'default_weight' =>118.44,
            ),

        );
        $this->db->insert_batch('size', $data_menu); 
    }
    public function down(){

    }
}