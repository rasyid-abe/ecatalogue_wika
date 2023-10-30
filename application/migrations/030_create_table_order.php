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
class Migration_create_table_order extends CI_Migration {


	public function up()
	{ 
		$table = "order";
		$fields = array(
			'id'           => [
				'type'           => 'INT(11)',
				'auto_increment' => TRUE,
				'unsigned'       => TRUE,
			],
			'order_no'          => [
				'type' => 'VARCHAR(100)',
			],
			'total_price'      => [
                'type' => 'BIGINT(20)',
                'default' => 0
            ],
            'order_status'      => [
                'type' => 'TINYINT(2)',
                'default' => 0
            ],
            'payment_method_id'      => [
                'type' => 'INT(11)',
                'default' => 0
            ],
            'shipping_id'      => [
                'type' => 'INT(11)',
                'default' => 0
            ],
            'perihal'      => [
                'type' => 'TEXT',
                'NULL' => TRUE
            ],
			'created_at  timestamp DEFAULT CURRENT_TIMESTAMP',
            'created_by'      => [
                'type' => 'INT(11)',
            ],
            'updated_by'      => [
                'type' => 'INT(11)',
                'default' => 0,
            ],
            'update_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
			'is_deleted'      => [
				'type' => 'TINYINT(1)',
				'default' => 0,
			],

		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table($table);

		$table = "order_product";
		$fields = array(
			'id'           => [
				'type'           => 'INT(11)',
				'auto_increment' => TRUE,
				'unsigned'       => TRUE,
			],
			'order_no'          => [
				'type' => 'VARCHAR(100)',
			],
			'product_id'      => [
                'type' => 'INT(11)',
                'default' => 0
            ],
            'qty'      => [
                'type' => 'INT(11)',
                'default' => 0
            ],
            'product_uom_id'      => [
                'type' => 'INT(11)',
                'default' => 0
            ],
            'order_product_status'      => [
                'type' => 'TINYINT(2)',
                'default' => 0
            ],
			'created_at  timestamp DEFAULT CURRENT_TIMESTAMP',
            'created_by'      => [
                'type' => 'INT(11)',
            ],
            'updated_by'      => [
                'type' => 'INT(11)',
                'default' => 0,
            ],
            'update_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
			'is_deleted'      => [
				'type' => 'TINYINT(1)',
				'default' => 0,
			],

		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table($table);

	}


	public function down()
	{
		$table = "order";
		if ($this->db->table_exists($table))
		{
			$this->dbforge->drop_table($table);
		}

		$table = "order_product";
		if ($this->db->table_exists($table))
		{
			$this->dbforge->drop_table($table);
		}
	}

}