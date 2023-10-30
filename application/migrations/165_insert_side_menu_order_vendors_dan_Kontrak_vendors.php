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
class Migration_insert_side_menu_order_vendors_dan_Kontrak_vendors extends CI_Migration {


	public function up()
    {
		$this->db->trans_start();
		$data_menu = array(
			array('id'=>43,'module_id'=>1, 'name'=>'Order', 'url'=>'#', 'parent_id'=>1, 'icon'=>"fa fa-list-ol", 'sequence'=>6),
			array('id'=>44,'module_id'=>1, 'name'=>'Order Transportasi', 'url'=>'order_transportasi', 'parent_id'=>43, 'icon'=>"fa fa-circle-o", 'sequence'=>2),
			array('id'=>45,'module_id'=>1, 'name'=>'Order Asuransi', 'url'=>'order_asuransi', 'parent_id'=>43, 'icon'=>"fa fa-circle-o", 'sequence'=>3),
			array('id'=>46,'module_id'=>1, 'name'=>'Kontrak', 'url'=>'#', 'parent_id'=>1, 'icon'=>"fa fa-book", 'sequence'=>7),
			array('id'=>47,'module_id'=>1, 'name'=>'Kontrak Transportasi', 'url'=>'kontrak_transportasi', 'parent_id'=>46, 'icon'=>"fa fa-circle-o", 'sequence'=>2),
			array('id'=>48,'module_id'=>1, 'name'=>'Kontrak Asuransi', 'url'=>'asuransi', 'parent_id'=>46, 'icon'=>"fa fa-circle-o", 'sequence'=>3),
       );

       $this->db->insert_batch('menu', $data_menu);

	   $dataUpdateOrder = [
		   'name'=>'Order Vendor', 'url'=>'order', 'parent_id'=>43, 'icon'=>"fa fa-circle-o", 'sequence'=>1
	   ];
	   $this->db->where('id', 20)->update('menu', $dataUpdateOrder);

	   $dataUpdateKontrak = [
		   'name'=>'Kontrak Vendor', 'url'=>'kontrak', 'parent_id'=>46, 'icon'=>"fa fa-circle-o", 'sequence'=>1
	   ];
	   $this->db->where('id', 26)->update('menu', $dataUpdateKontrak);

	   $dataMenuFunction = [];
	   foreach (range(43,48) as $menu_id)
	   {
		   foreach(range(1,5) as $function_id)
		   {
			   $dataMenuFunction []= [
				   'menu_id' => $menu_id,
				   'function_id' => $function_id,
			   ];
		   }
	   }
	   $this->db->insert_batch('menu_function', $dataMenuFunction);

	   $this->db->where('id', 42)->delete('menu');

	   $this->db->trans_complete();

    }

	public function down()
	{

	}

}
