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
class Migration_create_table_vendor_contract_history extends CI_Migration {


   public function up()
   {
       $table = "vendor_contract_history";
       $fields = array(
           'id'           => [
               'type'           => 'INT(11)',
               'auto_increment' => TRUE,
               'unsigned'       => TRUE,
           ],
           'vendor_id'           => [
               'type'           => 'INT(11)',
           ],
           'old_contract'            => [
               'type'         => 'varchar(100)',
               'default' =>0,
           ],
           'new_contract'            => [
               'type'         => 'varchar(100)',
               'default' =>0,
           ],
           'created_at  timestamp DEFAULT CURRENT_TIMESTAMP',
           'created_by'      => [
               'type' => 'INT(11)',
           ],
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

   }

}
