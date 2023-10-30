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
class Migration_insert_side_menu_sinkronisasi extends CI_Migration {


	public function up()
    {

        $data_menu = array(
            array('id'=>33,'module_id'=>1, 'name'=>'Sinkronisasi', 'url'=>'sync', 'parent_id'=>1, 'icon'=>"fa fa-refresh", 'sequence'=>12),
       );
       $this->db->insert_batch('menu', $data_menu);

    }

	public function down()
	{

	}

}
