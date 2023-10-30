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
class Migration_insert_master_data_system_static extends CI_Migration {


    public function up()
    {
         $this->db->query('truncate table area');
         $data =
            array(
                'id'          => 1,
                'code'        => "AR",
                'name'        => 'Default-Area',
                'description' => 'Default Area',
            );
            $this->db->insert('area',$data);


        $this->db->query('truncate table groups');
         $data = array(
            array(
                'id'          => 1,
                'name'        => 'Default-Groups',
                'description' => 'Default-Groups',
                'area_id'     => 1,
            ),
        );
        $this->db->insert_batch('groups', $data);

        $this->db->query('truncate table module');
        $data = array(
            array(
                'id'          => 1,
                'name'        => 'Operation Backend',
                'description' => 'Operation Backend'
            ),
            array(
                'id'          => 2,
                'name'        => 'Operation Frontend',
                'description' => 'Operation Frontend'
            ),
        );
        $this->db->insert_batch('module', $data);

        $this->db->query('truncate table roles');
        $data = array(
            array(
                'id'          => 1,
                'name'        => 'Superadmin',
                'description' => 'Superadmin',
                'is_deleted'  => 0
            ),
            array(
                'id'          => 2,
                'name'        => 'Admin',
                'description' => 'Admin Web',
                'is_deleted'  => 0
            ),
            array(
                'id'          => 3,
                'name'        => 'Vendor',
                'description' => 'Vendor',
                'is_deleted'  => 0
            ),
            array(
                'id'          => 4,
                'name'        => 'Internal',
                'description' => 'User untuk order',
                'is_deleted'  => 0
            ),
        );
        $this->db->insert_batch('roles', $data);
    }


    public function down()
    {

    }

}
