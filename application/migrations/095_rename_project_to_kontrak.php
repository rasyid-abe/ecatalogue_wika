<?php
/**
 * @author   Natan Felles <natanfelles@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_create_table_api_limits
 *
 * @property CI_DB_forge         $dbforge
 * @property CI_DB_query_builder $db
 */
class Migration_rename_project_to_kontrak extends CI_Migration {


	public function up()
    {
        $this->db->delete('menu', array('id' => 13)); 
        $this->db->delete('menu', array('id' => 20)); 
        $this->db->delete('menu', array('id' => 26)); 

        $data_menu = array(
            array('id'=>13,'module_id'=>1, 'name'=>'Metode Pembayaran', 'url'=>'payment_method', 'parent_id'=>29, 'icon'=>"fa fa-circle-o", 'sequence'    =>3),
            array('id'=>20,'module_id'=>1, 'name'=>'Order', 'url'=>'order', 'parent_id'=>1, 'icon'=>"fa fa-list-ol", 'sequence'=>6),
            array('id'=>26,'module_id'=>1, 'name'=>'Kontrak', 'url'=>'project', 'parent_id'=>1, 'icon'=>"fa fa-book", 'sequence'=>7),
       );
       $this->db->insert_batch('menu', $data_menu);
    }

	public function down()
	{

	}

}
