<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_biaya_transport_asuransi_on_order_and_order_product extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        // $this->db->trans_start();
        $fields = array(
            'biaya_transport' => array(
                'type'  => 'DECIMAL(20,2)',
                'default' => 0
            ),
            'transportasi_id' => array(
                'type'  => 'INT(11)',
                'NULL' => TRUE,
            ),
        );

        $this->dbforge->add_column('order', $fields);


        $field2 = array(
            'nilai_asuransi' => array(
                'type'  => 'DECIMAL(20,2)',
                'default' => 0
            ),
            'asuransi_id' => array(
                'type'  => 'INT(11)',
                'NULL' => TRUE,
            ),
        );

        $this->dbforge->add_column('order_product', $field2);

        // $this->db->trans_compete();
    }

    public function down()
    {

    }

}
