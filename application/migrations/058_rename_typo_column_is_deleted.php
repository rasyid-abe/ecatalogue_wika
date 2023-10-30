<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_rename_typo_column_is_deleted extends CI_Migration {
	public function __construct() {
		parent::__construct();
		$this->load->dbforge();
	}

    public function up()
    {
        $fields = array(
        'id_deleted' => array(
                'name' => 'is_deleted',
                'type'  => 'TINYINT(1)',
                'default'  => 0,
            ),
        );

        $this->dbforge->modify_column('product_include_price', $fields);
    }

    public function down()
    {

    }

}
