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
class Migration_create_table_specification extends CI_Migration {


	public function up()
	{ 
		$table = "specification";
		$fields = array(
			'id'           => [
				'type'           => 'INT(11)',
				'auto_increment' => TRUE,
				'unsigned'       => TRUE,
			],
			'name'          => [
				'type' => 'VARCHAR(100)',
			],
			'description'      => [
				'type' => 'TEXT',
				'null' => TRUE,
			],
			'is_deleted'      => [
				'type' => 'TINYINT(1)',
				'default' => 0,
			],

		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table($table);

		$data_menu = array(
            array(
                'id'        =>1,
                'name'      =>"BJTP 24",
            ),
            array(
                'id'        =>2,
                'name'      =>"BJTS 40",
            ),
        );
        $this->db->insert_batch('specification', $data_menu); 
	 
	}


	public function down()
	{
		$table = "specification";
		if ($this->db->table_exists($table))
		{
			$this->dbforge->drop_table($table);
		}
	}

}