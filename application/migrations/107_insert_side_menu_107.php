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
class Migration_insert_side_menu_107 extends CI_Migration {


	public function up()
    {

        $data_menu = array(
            array('id'=>31,'module_id'=>1, 'name'=>'Kategori', 'url'=>'category_new', 'parent_id'=>29, 'icon'=>"fa fa-circle-o", 'sequence'=>0),
       );
       $this->db->insert_batch('menu', $data_menu);

    }

	public function down()
	{

	}

}
