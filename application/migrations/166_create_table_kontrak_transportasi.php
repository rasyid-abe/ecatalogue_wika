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
class Migration_create_table_kontrak_transportasi extends CI_Migration {


	public function up()
	{
		$table = "kontrak_transportasi";
		$fields = array(
			'id'           => [
				'type'           => 'INT(11)',
				'auto_increment' => TRUE,
				'unsigned'       => TRUE,
			],
			'no_contract'	=> [
				'type' => 'VARCHAR',
				'constraint' => 255,
				'NULL' => TRUE,
				],
			'vendor_id'	=> [
				'type' => 'INT',
				'constraint' => 11,
				'NULL' => TRUE,
			],
			'created_by' => array(
		        'type' => 'INT',
		        'constraint' => 11,
		        'NULL' => TRUE,
		    ),
		    'updated_by' => array(
		        'type' => 'INT',
		        'constraint' => 11,
		        'NULL' => TRUE,
		    ),
		    'created_at  timestamp DEFAULT CURRENT_TIMESTAMP',
		    'updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
			'is_deleted' => [
				'type' => 'TINYINT',
				'constraint' => 1,
				'default' => 0,
			],
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('uri');
		$this->dbforge->create_table($table);

	}


	public function down()
	{

	}

}
