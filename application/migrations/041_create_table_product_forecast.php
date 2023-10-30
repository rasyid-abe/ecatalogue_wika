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
class Migration_create_table_product_forecast extends CI_Migration {


   public function up()
   {
       $table = "product_forecast";
       $fields = array(
           'id'           => [
               'type'           => 'INT(11)',
               'auto_increment' => TRUE,
               'unsigned'       => TRUE,
           ],
           'created_at  timestamp DEFAULT CURRENT_TIMESTAMP',
           'created_by'      => [
               'type' => 'INT(11)',
           ],
           'start_date'           => [
               'type'           => 'DATE',
           ],
           'end_date'           => [
               'type'           => 'DATE',
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
