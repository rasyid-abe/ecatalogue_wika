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
class Migration_insert_function_menu_transportasi extends CI_Migration {


	public function up()
	{ 
		// insert function value
		 $data_menu = array(
            array('id'=>241,'menu_id'=>49, 'function_id'=>1),
            array('id'=>242,'menu_id'=>49, 'function_id'=>2),
            array('id'=>243,'menu_id'=>49, 'function_id'=>3),
            array('id'=>244,'menu_id'=>49, 'function_id'=>4),
            array('id'=>245,'menu_id'=>49, 'function_id'=>5),
        );
        $this->db->insert_batch('menu_function', $data_menu); 
	} 

	public function down()
	{
		
	}

}