<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_department_on_vendor extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'department'      => [
				'type' => 'varchar(100)',
			],
        );
        
        $this->dbforge->add_column('vendor', $fields);

    }

    public function down()
    {

    }
}
