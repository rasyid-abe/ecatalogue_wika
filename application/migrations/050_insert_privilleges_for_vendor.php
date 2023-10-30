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
class Migration_insert_privilleges_for_vendor extends CI_Migration {


	public function up()
	{
		// insert function value
        $data_menu = [];
        $role_id = 3; // role_id vendor
        // parent menu
        foreach([1,9] as $v)
        {
            $data_menu[] = ['role_id' => $role_id, 'menu_id' => $v, 'function_id' => 1];
        }

        foreach([10,11,20] as $v)
        {
            foreach([1,2,3,4,5] as $v2)
            {
                $data_menu[] = ['role_id' => $role_id, 'menu_id' => $v, 'function_id' => $v2];
            }
        }
        $this->db->insert_batch('privilleges', $data_menu);
	}

	public function down()
	{

	}

}
