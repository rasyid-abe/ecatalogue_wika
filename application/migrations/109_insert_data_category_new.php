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
class Migration_insert_data_category_new extends CI_Migration {


	public function up()
    {

	   $data = [
		   ['id' => 1, 'code' => 'A', 'name' => 'Material'],
		   ['id' => 2, 'code' => 'C', 'name' => 'Upah'],
		   ['id' => 3, 'code' => 'D', 'name' => 'Alat'],
		   ['id' => 4, 'code' => 'E', 'name' => 'Subkontraktor'],
		   ['id' => 5, 'code' => 'F', 'name' => 'Aset'],
	   ];
       $this->db->insert_batch('category_new', $data);

    }

	public function down()
	{

	}

}
