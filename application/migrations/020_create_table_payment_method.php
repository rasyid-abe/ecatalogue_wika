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
class Migration_create_table_payment_method extends CI_Migration {


	public function up()
	{ 
		$table = "enum_payment_method";
		$fields = array(
			'id'           => [
				'type'           => 'INT(11)',
				'auto_increment' => TRUE,
				'unsigned'       => TRUE,
			],
			'name'          => [
				'type' => 'VARCHAR(100)',
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
                'name'      =>"SKBDN",
            ),
            array(
                'id'        =>2,
                'name'      =>"SCF",
            )
        );
        $this->db->insert_batch('enum_payment_method', $data_menu); 

		$table = "payment_method";
		$fields = array(
			'id'           => [
				'type'           => 'INT(11)',
				'auto_increment' => TRUE,
				'unsigned'       => TRUE,
			],
			'enum_payment_method_id' => [
				'type' => 'INT(11)',
				'default' => 0,
			],
			'day'          => [
				'type' => 'VARCHAR(50)',
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
                'enum_payment_method_id' =>"1",
                'day'       =>90,
            ),
            array(
                'id'        =>2,
                'enum_payment_method_id' =>"1",
                'day'       =>120,
            ),
            array(
                'id'        =>3,
                'enum_payment_method_id' =>"2",
                'day'       =>30,
            ),
            array(
                'id'        =>4,
                'enum_payment_method_id' =>"2",
                'day'       =>60,
            ),
        );
        $this->db->insert_batch('payment_method', $data_menu); 
	 
	}


	public function down()
	{
		$table = "enum_payment_method";
		if ($this->db->table_exists($table))
		{
			$this->dbforge->drop_table($table);
		}

		$table = "payment_method";
		if ($this->db->table_exists($table))
		{
			$this->dbforge->drop_table($table);
		}
	}

}