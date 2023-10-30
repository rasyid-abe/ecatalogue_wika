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
class Migration_insert_side_menu_096 extends CI_Migration {


	public function up()
    {
        $this->db->delete('menu', array('id' => 26));

        $data_menu = array(
            array('id'=>26,'module_id'=>1, 'name'=>'Kontrak', 'url'=>'kontrak', 'parent_id'=>1, 'icon'=>"fa fa-book", 'sequence'=>7),
			array('id'=>30,'module_id'=>1, 'name'=>'Projek', 'url'=>'project', 'parent_id'=>1, 'icon'=>"fa fa-map", 'sequence'=>8),
       );
       $this->db->insert_batch('menu', $data_menu);

	   // update sequence
	   $data_update = [
		   [
			   'id' => 28,
			   'sequence' => 9
		   ],
		   [
			   'id' => 22,
			   'sequence' => 10
		   ],
		   [
			   'id' => 27,
			   'sequence' => 11
		   ],
	   ];

	   foreach($data_update as $v)
	   {
		   $this->db->where('id',$v['id']);
		   $this->db->update('menu', $v);
	   }
    }

	public function down()
	{

	}

}
