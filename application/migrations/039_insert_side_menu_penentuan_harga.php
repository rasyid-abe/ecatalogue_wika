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
class Migration_insert_side_menu_penentuan_harga extends CI_Migration {


	public function up()
	{
		// insert function value
		 $data_menu = array(
            array(
                'id'        =>22,
                'module_id' =>1,
                'name'      =>'Penentuan Harga',
                'url'       =>'#',
                'parent_id' =>1,
                'icon'      =>"fa fa-list",
                'sequence'  =>6,
            ),
            array(
                'id'        =>23,
                'module_id' =>1,
                'name'      =>'Riwayat Harga Produk',
                'url'       =>'riwayat',
                'parent_id' =>22,
                'icon'      =>"fa fa-circle-o",
                'sequence'  =>1,
            ),
            array(
                'id'        =>24,
                'module_id' =>1,
                'name'      =>'Forecast',
                'url'       =>'forecast',
                'parent_id' =>22,
                'icon'      =>"fa fa-circle-o",
                'sequence'  =>2,
            ),
        );
        $this->db->insert_batch('menu', $data_menu);
	}

	public function down()
	{

	}

}
