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
class Migration_create_table_order_transportasi_dan_order_asuransi extends CI_Migration {


	public function up()
	{
		$table = "order_gabungan";
		$fields = array(
			'id'           => [
				'type'           => 'INT(11)',
				'auto_increment' => TRUE,
				'unsigned'       => TRUE,
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
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('uri');
		$this->dbforge->create_table($table);

		$table = "order_transportasi";
		$fields = array(
			'id'           => [
				'type'           => 'INT(11)',
				'auto_increment' => TRUE,
				'unsigned'       => TRUE,
			],
			'order_no'          => [
				'type' => 'VARCHAR(100)',
			],
			'perihal'      => [
                'type' => 'TEXT',
                'NULL' => TRUE
            ],
			'catatan'      => [
                'type' => 'TEXT',
                'NULL' => TRUE
            ],
			'biaya_transport'      => [
                'type' => 'DECIMAL(20,2)',
                'default' => 0,
            ],
			'transportasi_id' => array(
		        'type' => 'INT',
		        'constraint' => 11,
		        'NULL' => TRUE,
		    ),
			'vendor_id' => array(
		        'type' => 'INT',
		        'constraint' => 11,
		        'NULL' => TRUE,
		    ),
			'location_origin_id' => array(
		        'type' => 'INT',
		        'constraint' => 11,
		        'NULL' => TRUE,
		    ),
			'location_destination_id' => array(
		        'type' => 'INT',
		        'constraint' => 11,
		        'NULL' => TRUE,
			),
			'project_id' => array(
		        'type' => 'INT',
		        'constraint' => 11,
		        'NULL' => TRUE,
			),
			'category_id' => array(
		        'type' => 'INT',
		        'constraint' => 11,
		        'NULL' => TRUE,
			),
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
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('uri');
		$this->dbforge->create_table($table);


		$table = "order_transportasi_d";
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
			'price'      => [
                'type' => 'BIGINT(11)',
                'default' => 0
            ],
			'weight'      => [
                'type' => 'DECIMAL(20,4)',
                'default' => 0
            ],
			'full_name_product'      => [
                'type' => 'TEXT',
				'NULL' => TRUE,
            ],
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('uri');
		$this->dbforge->create_table($table);


		$table = "order_asuransi";
		$fields = array(
			'id'           => [
				'type'           => 'INT(11)',
				'auto_increment' => TRUE,
				'unsigned'       => TRUE,
			],
			'order_no'          => [
				'type' => 'VARCHAR(100)',
			],
			'perihal'      => [
                'type' => 'TEXT',
                'NULL' => TRUE
            ],
			'catatan'      => [
                'type' => 'TEXT',
                'NULL' => TRUE
            ],
			'nilai_asuransi'      => [
                'type' => 'DECIMAL(20,2)',
                'default' => 0,
            ],
			'asuransi_id' => array(
		        'type' => 'INT',
		        'constraint' => 11,
		        'NULL' => TRUE,
		    ),
			'jenis_asuransi'      => [
                'type' => 'VARCHAR(255)',
                'NULL' => TRUE,
            ],
			'vendor_id' => array(
		        'type' => 'INT',
		        'constraint' => 11,
		        'NULL' => TRUE,
		    ),
			'project_id' => array(
		        'type' => 'INT',
		        'constraint' => 11,
		        'NULL' => TRUE,
			),			
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
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('uri');
		$this->dbforge->create_table($table);


		$table = "order_asuransi_d";
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
			'price'      => [
                'type' => 'BIGINT(11)',
                'default' => 0
            ],
			'weight'      => [
                'type' => 'DECIMAL(20,4)',
                'default' => 0
            ],
			'full_name_product'      => [
                'type' => 'TEXT',
				'NULL' => TRUE,
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
