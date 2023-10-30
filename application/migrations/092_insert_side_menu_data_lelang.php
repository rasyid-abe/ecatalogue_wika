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
class Migration_insert_side_menu_data_lelang extends CI_Migration {


	public function up()
	{
		// insert function value
		 $data_menu = array(
            array(
                'id'        =>28,
                'module_id' =>1,
                'name'      =>'Data Lelang',
                'url'       =>'data_lelang',
                'parent_id' =>1,
                'icon'      =>"fa fa-bell",
                'sequence'  =>7,
            ),
        );
        $this->db->insert_batch('menu', $data_menu);
	}

	public function down()
	{

	}

}
