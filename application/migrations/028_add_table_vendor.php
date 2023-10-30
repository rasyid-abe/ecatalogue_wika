<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_table_vendor extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
       
        $table = "vendor";
        $fields = array(
            'id'            => [
                'type'           => 'INT(11)',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ],
            'name'          => [    
                'type'  => 'VARCHAR(100)',
            ],
            'address'          => [    
                'type'  => 'TEXT',
            ],
            'email'          => [    
                'type'  => 'VARCHAR(100)',
            ],
            'description'          => [    
                'type'  => 'TEXT',
                'null'  => TRUE,
            ],
            'start_contract'          => [    
                'type'  => 'DATE',
            ],
            'end_contract'          => [    
                'type'  => 'DATE',
            ],
            'file_contract'          => [    
                'type'  => 'VARCHAR(100)',
                'null'  => TRUE,
            ],
            'is_deleted'          => [    
                'type'  => 'TINYINT(1)',
                'default'  => 0,
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