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
class Migration_insert_side_menu_chat_vendor extends CI_Migration {


	public function up()
    {

		$data_menu = array(
			array('id'=>38,'module_id'=>1, 'name'=>'Chat', 'url'=>'chat_vendor', 'parent_id'=>1, 'icon'=>"fa fa-comment", 'sequence'=>14),  		  		
       );

       $this->db->insert_batch('menu', $data_menu);

    }

	public function down()
	{

	}

}
