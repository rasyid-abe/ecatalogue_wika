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
class Migration_insert_category_feedback_po extends CI_Migration {


	public function up()
    {

        $data_menu = array(
  			array('id'=>100, 'name'=>'Pre Order', 'is_deleted'=>'0', 'created_by'=>1, 'updated_by'=>1),
       );

       $this->db->insert_batch('kategori_feedback', $data_menu);

    }

	public function down()
	{

	}

}
