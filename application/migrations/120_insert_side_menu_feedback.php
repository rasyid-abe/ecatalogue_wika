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
class Migration_insert_side_menu_feedback extends CI_Migration {


	public function up()
    {

        $data_menu = array(
			array('id'=>34,'module_id'=>1, 'name'=>'Feedback', 'url'=>'#', 'parent_id'=>1, 'icon'=>"fa fa-comments-o", 'sequence'=>13),
  		  		array('id'=>35,'module_id'=>1, 'name'=>'Kategori Feedack', 'url'=>'kategori_feedback', 'parent_id'=>34, 'icon'=>"fa fa-circle-o", 'sequence'=>1),
  				array('id'=>36,'module_id'=>1, 'name'=>'Daftar Feedback', 'url'=>'list_feedback', 'parent_id'=>34, 'icon'=>"fa fa-circle-o", 'sequence'=>2),
       );

       $this->db->insert_batch('menu', $data_menu);

    }

	public function down()
	{

	}

}
