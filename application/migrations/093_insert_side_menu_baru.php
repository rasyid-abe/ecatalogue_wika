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
class Migration_insert_side_menu_baru extends CI_Migration {


	public function up()
	{
		// insert function value
		$this->db->truncate('menu');

		$data_menu = array(
		   array('id'=>1,'module_id'=>1, 'name'=>'root', 'url'=>'#', 'parent_id'=>0, 'icon'=>" ", 'sequence'	=>0),
		   		array('id'=>2,'module_id'=>1, 'name'=>'Dashboard', 'url'=>'dashboard', 'parent_id'=>1, 'icon'=>"fa fa-dashboard", 'sequence'=>1),
		   array('id'=>3,'module_id'=>1, 'name'=>'System Access', 'url'=>'#', 'parent_id'=>1, 'icon'=>"fa fa-gear", 'sequence'=>2),
			   	array('id'=>4,'module_id'=>1, 'name'=>'Departmen', 'url'=>'group', 'parent_id'=>3, 'icon'=>"fa fa-circle-o", 'sequence'=>1),
			   	array('id'=>5,'module_id'=>1, 'name'=>'Role', 'url'=>'role', 'parent_id'=>3, 'icon'=>"fa fa-circle-o", 'sequence'=>2),
			   	array('id'=>6,'module_id'=>1, 'name'=>'Privileges', 'url'=>'privileges', 'parent_id'=>3, 'icon'=>"fa fa-circle-o", 'sequence'=>3),
		   array('id'=>7,'module_id'=>1, 'name'=>'Manage Account', 'url'=>'#', 'parent_id'=>1, 'icon'=>"fa fa-users", 'sequence'	=>3),
		   	   	array('id'=>8,'module_id'=>1, 'name'=>'User', 'url'=>'user', 'parent_id'=>7, 'icon'=>"fa fa-circle-o", 'sequence'=>1),
		   array('id'=>29,'module_id'=>1, 'name'=>'Data Penunjang', 'url'=>'#', 'parent_id'=>1, 'icon'=>"fa fa-briefcase", 'sequence'	=>4),
		   		array('id'=>12,'module_id'=>1, 'name'=>'Jenis', 'url'=>'category', 'parent_id'=>29, 'icon'=>"fa fa-circle-o", 'sequence'=>1),
				array('id'=>15,'module_id'=>1, 'name'=>'Sumber Daya', 'url'=>'specification', 'parent_id'=>29, 'icon'=>"fa fa-circle-o", 'sequence'=>2),
				array('id'=>18,'module_id'=>1, 'name'=>'Spesifikasi', 'url'=>'size', 'parent_id'=>29, 'icon'=>"fa fa-circle-o", 'sequence'=>3),
				array('id'=>17,'module_id'=>1, 'name'=>'Satuan', 'url'=>'uoms', 'parent_id'=>29, 'icon'=>"fa fa-circle-o", 'sequence'=>4),
				array('id'=>16,'module_id'=>1, 'name'=>'Lokasi', 'url'=>'location', 'parent_id'=>29, 'icon'=>"fa fa-circle-o", 'sequence'=>5),
				array('id'=>21,'module_id'=>1, 'name'=>'Term Of Delivery', 'url'=>'tod', 'parent_id'=>29, 'icon'=>"fa fa-circle-o", 'sequence'=>6),
				array('id'=>14,'module_id'=>1, 'name'=>'Pengiriman', 'url'=>'shipping', 'parent_id'=>29, 'icon'=>"fa fa-circle-o", 'sequence'=>7),
		  array('id'=>10,'module_id'=>1, 'name'=>'Vendor', 'url'=>'vendors', 'parent_id'=>1, 'icon'=>"fa fa-building", 'sequence'	=>5),
		  array('id'=>11,'module_id'=>1, 'name'=>'Produk', 'url'=>'product', 'parent_id'=>1, 'icon'=>"fa fa-cube", 'sequence'	=>6),
		  array('id'=>26,'module_id'=>1, 'name'=>'Project', 'url'=>'project', 'parent_id'=>1, 'icon'=>"fa fa-book", 'sequence'	=>7),
		  array('id'=>28,'module_id'=>1, 'name'=>'Data Lelang', 'url'=>'data_lelang', 'parent_id'=>1, 'icon'=>"fa fa-history", 'sequence'=>8),
		  array('id'=>22,'module_id'=>1, 'name'=>'Penentuan Harga', 'url'=>'#', 'parent_id'=>1, 'icon'=>"fa fa-list", 'sequence'=>9),
		  		array('id'=>23,'module_id'=>1, 'name'=>'Riwayat Harga Produk', 'url'=>'riwayat', 'parent_id'=>22, 'icon'=>"fa fa-circle-o", 'sequence'=>1),
				array('id'=>24,'module_id'=>1, 'name'=>'Forecast', 'url'=>'forecast', 'parent_id'=>22, 'icon'=>"fa fa-circle-o", 'sequence'=>2),
		  array('id'=>27,'module_id'=>1, 'name'=>'Notifikasi', 'url'=>'notifikasi', 'parent_id'=>1, 'icon'=>"fa fa-bell", 'sequence'=>10),
	   );
	   $this->db->insert_batch('menu', $data_menu);
	}

	public function down()
	{

	}

}
