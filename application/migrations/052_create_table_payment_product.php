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
class Migration_create_table_payment_product extends CI_Migration {


	public function up()
	{
		$table = "payment_product";
		$fields = array(
			'id'           => [
				'type'           => 'INT(11)',
				'auto_increment' => TRUE,
				'unsigned'       => TRUE,
			],
            'payment_id'           => [
				'type'           => 'INT(11)',
				'unsigned'       => TRUE,
			],
            'product_id'           => [
				'type'           => 'INT(11)',
				'unsigned'       => TRUE,
			],
            'price'           => [
				'type'           => 'BIGINT(20)',
				'default'       => 0
			],

		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table($table);

	}


	public function down()
	{

	}

}
