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
class Migration_insert_side_menu_forecast_3_bulan extends CI_Migration {


	public function up()
	{
		// insert function value
		 $data_menu = array(
            array(
                'id'        =>25,
                'module_id' =>1,
                'name'      =>'Forecast 3 Bulan',
                'url'       =>'forecast_3_bulan',
                'parent_id' =>22,
                'icon'      =>"fa fa-circle-o",
                'sequence'  =>3,
            ),
        );
        $this->db->insert_batch('menu', $data_menu);
	}

	public function down()
	{

	}

}
