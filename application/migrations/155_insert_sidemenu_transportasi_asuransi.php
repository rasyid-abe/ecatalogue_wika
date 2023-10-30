<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_insert_sidemenu_transportasi_asuransi extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $this->db->trans_start();
        $data_menu = array(
            array('id'=>41,'module_id'=>1, 'name'=>'Transportasi', 'url'=>'transportasi', 'parent_id'=>29, 'icon'=>"fa fa-circle-o", 'sequence'=>9),
            array('id'=>42,'module_id'=>1, 'name'=>'Asuransi', 'url'=>'asuransi', 'parent_id'=>29, 'icon'=>"fa fa-circle-o", 'sequence'=>10),
        );

        $this->db->insert_batch('menu', $data_menu);

        $data_menu_function = [];
        foreach ([41,42] as $menu_id)
        {
            foreach (range(1,5) as $function_id)
            {
                $data_menu_function[] = [
                    'menu_id' => $menu_id,
                    'function_id' => $function_id,
                ];
            }
        }

        $this->db->insert_batch('menu_function', $data_menu_function);

        $this->db->trans_complete();
    }

    public function down()
    {

    }

}
