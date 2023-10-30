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
class Migration_insert_menu_function_2 extends CI_Migration {


	public function up()
	{
		$data = [];

	   foreach(range(22,29) as $v)
	   {
		   foreach(range(1,5) as $v2)
		   {
			   $data[] = [
				   'menu_id' =>$v,
				   'function_id' =>$v2
			   ];
		   }
	   }

	   $this->db->insert_batch('menu_function', $data);
	}

	public function down()
	{

	}

}
