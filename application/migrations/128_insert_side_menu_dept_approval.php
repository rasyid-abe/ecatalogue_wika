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
class Migration_insert_side_menu_dept_approval extends CI_Migration {


	public function up()
    {

        $data_menu = array(
  			array('id'=>37,'module_id'=>1, 'name'=>'Departemen Approval', 'url'=>'departemen_approval', 'parent_id'=>3, 'icon'=>"fa fa-circle-o", 'sequence'=>4),
       );

       $this->db->insert_batch('menu', $data_menu);

    }

	public function down()
	{

	}

}
