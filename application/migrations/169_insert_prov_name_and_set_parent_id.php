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
class Migration_insert_prov_name_and_set_parent_id extends CI_Migration {


	public function up()
    {
		$prov = [
            ['id' => 11, 'name' => 'ACEH'],
            ['id' => 12, 'name' => 'SUMATERA UTARA'],
            ['id' => 13, 'name' => 'SUMATERA BARAT'],
            ['id' => 14, 'name' => 'RIAU'],
            ['id' => 15, 'name' => 'JAMBI'],
            ['id' => 16, 'name' => 'SUMATERA SELATAN'],
            ['id' => 17, 'name' => 'BENGKULU'],
            ['id' => 18, 'name' => 'LAMPUNG'],
            ['id' => 19, 'name' => 'KEPULAUAN BANGKA BELITUNG'],
            ['id' => 21, 'name' => 'KEPULAUAN RIAU'],
            ['id' => 31, 'name' => 'DKI JAKARTA'],
            ['id' => 32, 'name' => 'JAWA BARAT'],
            ['id' => 33, 'name' => 'JAWA TENGAH'],
            ['id' => 34, 'name' => 'DI YOGYAKARTA'],
            ['id' => 35, 'name' => 'JAWA TIMUR'],
            ['id' => 36, 'name' => 'BANTEN'],
            ['id' => 51, 'name' => 'BALI'],
            ['id' => 52, 'name' => 'NUSA TENGGARA BARAT'],
            ['id' => 53, 'name' => 'NUSA TENGGARA TIMUR'],
            ['id' => 61, 'name' => 'KALIMANTAN BARAT'],
            ['id' => 62, 'name' => 'KALIMANTAN TENGAH'],
            ['id' => 63, 'name' => 'KALIMANTAN SELATAN'],
            ['id' => 64, 'name' => 'KALIMANTAN TIMUR'],
            ['id' => 65, 'name' => 'KALIMANTAN UTARA'],
            ['id' => 71, 'name' => 'SULAWESI UTARA'],
            ['id' => 72, 'name' => 'SULAWESI TENGAH'],
            ['id' => 73, 'name' => 'SULAWESI SELATAN'],
            ['id' => 74, 'name' => 'SULAWESI TENGGARA'],
            ['id' => 75, 'name' => 'GORONTALO'],
            ['id' => 76, 'name' => 'SULAWESI BARAT'],
            ['id' => 81, 'name' => 'MALUKU'],
            ['id' => 82, 'name' => 'MALUKU UTARA'],
            ['id' => 91, 'name' => 'PAPUA BARAT'],
            ['id' => 94, 'name' => 'PAPUA'],
            ['id' => 95, 'name' => 'PERCONTOHAN'],
        ];

		$dataProv = [];
		foreach ($prov as $key => $value)
		{
			$dataProv[] = [
				'id' => $value['id'],
				'name' => $value['name'],
				'created_by' => 1,
				'is_editable' => 0,
				'is_prov' => 1,
			];
		}

		$this->db->insert_batch('location', $dataProv);

		$this->db->query('UPDATE location SET parent_id = SUBSTRING(id, 1,2) WHERE is_prov = 0');
	}

	public function down()
	{

	}

}
