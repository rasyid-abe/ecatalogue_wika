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
class Migration_insert_sidemenu_master extends CI_Migration {


	public function up()
	{ 
		// insert function value
		 $data_menu = array(
            array(
                'id'        =>9,
                'module_id' =>1,
                'name'      =>'Master Data',
                'url'       =>'#',
                'parent_id' =>1,
                'icon'      =>"fa fa-list",
                'sequence'  =>4,
            ),
            array(
                'id'        =>10,
                'module_id' =>1,
                'name'      =>'Vendor',
                'url'       =>'vendors',
                'parent_id' =>9,
                'icon'      =>"fa fa-circle-o",
                'sequence'  =>1,
            ),
            array(
                'id'        =>11,
                'module_id' =>1,
                'name'      =>'Produk',
                'url'       =>'product',
                'parent_id' =>9,
                'icon'      =>"fa fa-circle-o",
                'sequence'  =>2,
            ),
            array(
                'id'        =>13,
                'module_id' =>1,
                'name'      =>'Metode Pembayaran',
                'url'       =>'payment_method',
                'parent_id' =>9,
                'icon'      =>"fa fa-circle-o",
                'sequence'  =>5
            ),
            array(
                'id'        =>12,
                'module_id' =>1,
                'name'      =>'Kategori',
                'url'       =>'category',
                'parent_id' =>9,
                'icon'      =>"fa fa-circle-o",
                'sequence'  =>3,
            ),
            array(
                'id'        =>14,
                'module_id' =>1,
                'name'      =>'Pengiriman',
                'url'       =>'shipping',
                'parent_id' =>9,
                'icon'      =>"fa fa-circle-o",
                'sequence'  =>6,
            ),
            array(
                'id'        =>15,
                'module_id' =>1,
                'name'      =>'Spesifikasi',
                'url'       =>'specification',
                'parent_id' =>9,
                'icon'      =>"fa fa-circle-o",
                'sequence'  =>4,
            ),
            array(
                'id'        =>16,
                'module_id' =>1,
                'name'      =>'Lokasi',
                'url'       =>'location',
                'parent_id' =>9,
                'icon'      =>"fa fa-circle-o",
                'sequence'  =>7,
            ),
            array(
                'id'        =>17,
                'module_id' =>1,
                'name'      =>'Satuan',
                'url'       =>'uom',
                'parent_id' =>9,
                'icon'      =>"fa fa-circle-o",
                'sequence'  =>8,
            ),
            array(
                'id'        =>18,
                'module_id' =>1,
                'name'      =>'Ukuran',
                'url'       =>'size',
                'parent_id' =>9,
                'icon'      =>"fa fa-circle-o",
                'sequence'  =>9,
            ),
            array(
                'id'        =>19,
                'module_id' =>1,
                'name'      =>'Konversi Satuan',
                'url'       =>'uom_conversion',
                'parent_id' =>9,
                'icon'      =>"fa fa-circle-o",
                'sequence'  =>10,
            ),
            array(
                'id'        =>20,
                'module_id' =>1,
                'name'      =>'Order',
                'url'       =>'order',
                'parent_id' =>1,
                'icon'      =>"fa fa-list-ol",
                'sequence'  =>5,
            ),
            array(
                'id'        =>21,
                'module_id' =>1,
                'name'      =>'Term Of Delivery',
                'url'       =>'tod',
                'parent_id' =>9,
                'icon'      =>"fa fa-circle-o",
                'sequence'  =>11,
            ),
        );
        $this->db->insert_batch('menu', $data_menu); 
	} 

	public function down()
	{
		
	}

}