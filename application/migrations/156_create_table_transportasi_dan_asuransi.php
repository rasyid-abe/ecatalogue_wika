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
class Migration_create_table_transportasi_dan_asuransi extends CI_Migration {


	public function up()
	{
		$this->db->trans_start();
		$table = "transportasi";
		$fields = array(
			'id'           => [
				'type'           => 'INT(11)',
				'auto_increment' => TRUE,
				'unsigned'       => TRUE,
			],
			'vendor_id'	=> [
				'type' => 'INT',
				'constraint' => 11,
				'NULL' => TRUE,
			],
			'origin_location_id'	=> [
				'type' => 'INT',
				'constraint' => 11,
				'NULL' => TRUE,
			],
			'destination_location_id'	=> [
				'type' => 'INT',
				'constraint' => 11,
				'NULL' => TRUE,
			],
			'price'	=> [
				'type' => 'DECIMAL(20,2)',
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

		$table = "asuransi";
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
			'nilai_asuransi'	=> [
				'type' => 'DECIMAL(20,2)',
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

		$this->db->trans_complete();
	}


	public function down()
	{

	}

}
