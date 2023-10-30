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
class Migration_insert_side_menu_dashboard_vendor_dan_user extends CI_Migration {


	public function up()
    {

		$data_menu = array(
			array('id'=> 39 ,'module_id'=> 1, 'name'=>'Dashboard Vendor', 'url'=>'dashboard_vendor', 'parent_id'=>1, 'icon'=>"fa fa-dashboard", 'sequence'=>1),
			array('id'=> 40 ,'module_id'=> 1, 'name'=>'Dashboard User', 'url'=>'dashboard_user', 'parent_id'=>1, 'icon'=>"fa fa-dashboard", 'sequence'=>1),
       );

       $this->db->insert_batch('menu', $data_menu);

    }

	public function down()
	{

	}

}
