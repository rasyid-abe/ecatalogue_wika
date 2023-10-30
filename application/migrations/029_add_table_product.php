<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_table_product extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
       
        $table = "product";
        $fields = array(
            'id'            => [
                'type'           => 'INT(11)',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ],
            'name'          => [    
                'type'  => 'VARCHAR(100)',
            ],
            'code'          => [    
                'type'  => 'VARCHAR(100)',
                'null'  => TRUE,
            ],
            'no_contract'          => [    
                'type'  => 'VARCHAR(100)',
                'null'  => TRUE,
            ],
            'specification_id'          => [    
                'type'  => 'INT(11)',
                'default' =>0,
            ],
            'size_id'          => [    
                'type'  => 'INT(11)',
                'default' =>0,
            ],
            'price'            => [
                'type'         => 'BIGINT(20)',
                'default' =>0,
            ],
            'reference'          => [    
                'type'  => 'VARCHAR(100)',
                'null'  => TRUE,
            ],
            'vendor_id'          => [    
                'type'  => 'INT(11)',
                'default' =>0,
            ],
            'location_id'          => [    
                'type'  => 'INT(11)',
                'default' =>0,
            ],
            'payment_method_id'          => [    
                'type'  => 'INT(11)',
                'default' =>0,
            ],
            'term_of_delivery_id'          => [    
                'type'  => 'INT(11)',
                'default' =>0,
            ],
            'volume'          => [    
                'type'  => 'FLOAT',
                'default' =>0,
            ],
            'uom_id'          => [    
                'type'  => 'INT(11)',
                'default' =>0,
            ],
            'note'          => [    
                'type'  => 'TEXT',
                'null'  => TRUE,
            ],
            'attachment'          => [    
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