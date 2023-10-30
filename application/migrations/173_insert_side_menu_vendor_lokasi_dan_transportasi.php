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
class Migration_insert_side_menu_vendor_lokasi_dan_transportasi extends CI_Migration {


	public function up()
    {
		$data_menu = array(
			array('id'=>49,'module_id'=>1, 'name'=>'Transportasi', 'url'=>'transportasi', 'parent_id'=>1, 'icon'=>"fa fa-bus", 'sequence'=>15),
       );

       $this->db->insert_batch('menu', $data_menu);

	   $dataTransportasi = [
		   'name'=>'Vendor Lokasi', 'url'=>'vendor_lokasi', 'parent_id'=>29, 'icon'=>"fa fa-circle-o", 'sequence'=>1
	   ];
	   $this->db->where('id', 41)->update('menu', $dataTransportasi);
    }

	public function down()
	{

	}

}
