<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Project_model extends MY_Model
{
    protected $table = 'project';

    public function __construct()
    {
        parent::__construct();
    }

    function getAllBy($limit, $start, $search, $col, $dir, $where = [], $where_and = [])
    {
        if (!method_exists($this, 'getMainQuery')) {
            $this->db->select("*")
                ->from($this->table);
        } else {
            $this->getMainQuery();
        }

        if (!empty($search)) {
            foreach ($search as $key => $value) {
                $this->db->or_like($key, $value);
            }
        }

        if (!empty($where_and)) {
            foreach ($where_and as $key => $value) {
                $this->db->or_like($key, $value);
            }
        }

        $this->db->where($where);

        $this->db->limit($limit, $start);
        $this->db->order_by($col, $dir);

        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return null;
        }
    }

    function getCountAllBy($limit, $start, $search, $order, $dir, $where = [], $where_and = [])
    {
        if (!method_exists($this, 'getMainQuery')) {
            $this->db->select("*")
                ->from($this->table);
        } else {
            $this->getMainQuery();
        }

        if (!empty($search)) {
            foreach ($search as $key => $value) {
                $this->db->or_like($key, $value);
            }
        }

        if (!empty($where_and)) {
            foreach ($where_and as $key => $value) {
                $this->db->like($key, $value);
            }
        }

        $this->db->where($where);

        $result = $this->db->get();

        return $result->num_rows();
    }

    public function get_detail_kontrak($where = [])
    {
        $this->db->select("project.*, vendor.name as vendor_name, users.first_name as user_name, groups.name as dept_name")
            ->from('project')
            ->join('vendor', 'vendor.id = project.vendor_id', 'left')
            ->join('users', 'users.id = project.user_pemantau_id', 'left')
            ->join('groups', 'groups.id = project.departemen_pemantau_id', 'left')
            ->where($where);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        }

        return FALSE;
    }

    public function get_all_scm_kontrak()
    {
        $ret = [];
        $query = $this->db->where('scm_id IS NOT NULL', NULL)->get('project');

        foreach ($query->result() as $v) {
            $ret[$v->id] = $v->scm_id;
        }

        return $ret;
    }

    public function get_harga_for_generate_status_1($id, $arr_id_header, $arr_id_location)
    {
        $query = $this->db->select("a.*, b.name as nama_product")
            ->from('project_product_price as a')
            ->join('product as b', 'b.id = a.product_id')
            ->where('a.is_deleted', 0)
            ->where('a.amandemen_id IS NULL', NULL)
            ->where('a.project_id', $id)->get()->result();

        $list_barang = [];
        $last_product_id = "asdasdas"; // supaya tidak sama
        $i = 0;
        $payment_product = [];
        // maaf klo lieur. kwkwkw
        foreach ($query as $k => $v) {
            if ($last_product_id != $v->product_id) {
                if ($k != 0)
                    $i++;

                $list_barang[$i] = [
                    'nama_product' => $v->nama_product,
                    'product_id' => $v->product_id,
                ];

                $last_product_id = $v->product_id;
            }

            $payment_product[$v->product_id][$v->payment_id . '_' . str_replace(',', '_', $v->location_id)] = $v->price;
        }

        //die(var_dump($arr_id_header));
        $i = 0;
        $data = [];
        foreach ($list_barang as $v) {
            $data[$i]['product_id'] = $v['product_id'];
            $data[$i]['nama_product'] = $v['nama_product'];

            foreach ($arr_id_header as $keynya => $id) {
                $indexnya = str_replace(',', '_', $arr_id_location[$keynya]);
                $data[$i]['payment_' . $id . '_' . $indexnya] = '-';
                if (isset($payment_product[$v['product_id']])) {
                    foreach ($payment_product[$v['product_id']] as $k2 => $v2) {
                        if ($k2 == $id . '_' . $indexnya) {
                            $data[$i]['payment_' . $id . '_' . $indexnya] = $v2;
                            break;
                        }
                    }
                }
            }
            $i++;
        }

        return $data;
    }

    public function get_header_generate_harga_status_1($where)
    {
        $this->db->select("a.payment_id, CONCAT(c.name ,' ', b.`day` ,' hari') as full_payment
        , a.location_id")
            ->from('project_product_price as a')
            ->join('payment_method as b', 'a.payment_id = b.id')
            ->join('enum_payment_method c', 'b.enum_payment_method_id = c.id')
            // ->join('location', 'location.id = a.location_id')
            ->where($where)
            ->where('a.is_deleted', 0)
            ->group_by(['a.payment_id', 'a.location_id']);
        $query = $this->db->get()->result();
        //echo $this->db->last_query();
        //die();
        return $query;
    }

    public function get_header_generate_harga_status_2($amandemen_id)
    {
        $this->db->select("b.payment_id , a.product_id
	    , CONCAT(d.name ,' ', c.`day` ,' hari') as full_payment
        , b.location_id ")
            ->from('amandemen_products as a')
            ->join('payment_product as b', 'a.product_id = b.product_id')
            ->join('payment_method as c', 'b.payment_id  = c.id')
            ->join('enum_payment_method as d', 'd.id = c.enum_payment_method_id')
            //->join('location', 'location ON location.id = b.location_id')
            ->where('a.amandemen_id', $amandemen_id)
            ->group_by(['b.payment_id', 'b.location_id'])
            ->order_by('d.name', 'ASC')
            ->order_by('CAST(c.`day` AS SIGNED)', 'ASC');

        $query = $this->db->get()->result();
        // die($this->db->last_query());
        return $query;
    }

    public function get_list_barang_by_amandemen_id($amandemen_id)
    {
    }

    public function get_harga_for_generate_status_2($project_id, $amandemen_id, $arr_id_header, $arr_id_location)
    {
        $list_barang = $this->get_list_barang_by_project_id($amandemen_id, 'amandemen');
        if (!empty($list_barang)) {
            $arr_barang = [];
            foreach ($list_barang as $v) {
                $arr_barang[] = $v->product_id;
            }

            /*
            $this->db->select('payment_id, price , product_id')
            ->from('payment_product')
            ->where_in('product_id', $arr_barang)
            ->order_by('product_id','ASC');
            $q_payment_product = $this->db->get();
            */
            $in = implode(',', $arr_barang);

            $sql = "SELECT payment_id, product_id, location_id, price
                    FROM project_product_price
                    WHERE is_deleted = 0
                    AND project_id = '$project_id'
                    UNION ALL
                    SELECT payment_id, product_id , location_id, price
                    FROM payment_product
                    WHERE product_id IN ($in)";

            $q_payment_product = $this->db->query($sql);

            $arr_tampung = []; // buat menampung gabungan product_id dan payment_id biar gak adayang bentrok
            $payment_product = [];
            foreach ($q_payment_product->result() as $v) {
                $key  = $v->product_id . '_' . $v->payment_id . '_' . str_replace(',', '_', $v->location_id);
                if (!in_array($key, $arr_tampung)) {
                    $payment_product[$v->product_id][$v->payment_id . '_' . str_replace(',', '_', $v->location_id)] = $v->price;
                    $arr_tampung[] = $key;
                }
            }
        } else {
            $payment_product = [];
        }

        $i = 0;
        $data = [];
        foreach ($list_barang as $v) {
            $data[$i]['product_id'] = $v->product_id;
            $data[$i]['nama_product'] = $v->nama_product;

            foreach ($arr_id_header as $keynya => $id) {
                $indexnya = str_replace(',', '_', $arr_id_location[$keynya]);
                $data[$i]['payment_' . $id . '_' . $indexnya] = '-';
                if (isset($payment_product[$v->product_id])) {
                    foreach ($payment_product[$v->product_id] as $k2 => $v2) {
                        if ($k2 == $id . '_' . $indexnya) {
                            $data[$i]['payment_' . $id . '_' . $indexnya] = $v2;
                            break;
                        }
                    }
                }
            }
            $i++;
        }
        //var_dump($this->db->queries);
        return $data;
    }

    public function get_header_generate_harga($id)
    {
        $this->db->select("CONCAT(d.name ,' ', c.`day` ,' hari') as full_payment
	    , b.payment_id, b.location_id")
            ->from('project_products as a')
            ->join('payment_product as b', 'a.product_id = b.product_id')
            ->join('payment_method as c', 'c.id = b.payment_id')
            ->join('enum_payment_method as d', 'd.id = c.enum_payment_method_id')
            // ->join('location', 'location ON location.id = b.location_id')
            ->where('a.is_deleted', 0)
            ->where('a.project_id', $id)
            ->group_by(['b.payment_id', 'b.location_id']);
        $query = $this->db->get()->result();
        return $query;
    }

    function get_list_barang_by_project_id($project_id, $table = 'project')
    {
        $this->db->select("a.product_id, c.name as nama_product")
            ->from($table . '_products as a')
            ->join($table . ' as b', 'a.' . $table . '_id = b.id')
            ->join('product as c', 'c.id = a.product_id')
            ->where('b.id', $project_id);
        if ($table == 'project') {
            $this->db->where('a.is_deleted', 0);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_harga_for_generate_status_0($project_id, $arr_id_header, $arr_id_location)
    {
        $list_barang = $this->get_list_barang_by_project_id($project_id);
        if (!empty($list_barang)) {
            $arr_barang = [];
            foreach ($list_barang as $v) {
                $arr_barang[] = $v->product_id;
            }
            $this->db->select('payment_id, price , product_id, location_id')
                ->from('payment_product')
                ->where_in('product_id', $arr_barang)
                ->order_by('product_id', 'ASC');
            $q_payment_product = $this->db->get();

            $payment_product = [];
            foreach ($q_payment_product->result() as $v) {
                $payment_product[$v->product_id][$v->payment_id . '_' . str_replace(',', '_', $v->location_id)] = $v->price;
            }
        } else {
            $payment_product = [];
        }

        $i = 0;
        $data = [];
        foreach ($list_barang as $v) {
            $data[$i]['product_id'] = $v->product_id;
            $data[$i]['nama_product'] = $v->nama_product;

            foreach ($arr_id_header as $keynya => $id) {
                $indexnya = str_replace(',', '_', $arr_id_location[$keynya]);
                $data[$i]['payment_' . $id . '_' . $indexnya] = '-';
                if (isset($payment_product[$v->product_id])) {
                    foreach ($payment_product[$v->product_id] as $k2 => $v2) {
                        if ($k2 == $id . '_' . $indexnya) {
                            $data[$i]['payment_' . $id . '_' . $indexnya] = $v2;
                            break;
                        }
                    }
                }
            }
            $i++;
        }

        return $data;
        /*
        $this->db->select("b.id as product_id, a.project_id, c.payment_id, b.name as nama_product
    	, CONCAT(f.name , ' ', e.`day`, ' hari') as payment_full
    	,  c.price
    	, g.name as location_name ")
        ->from('project_products as a')
        ->join('product as b','a.product_id = b.id')
        ->join('payment_product as c','b.id = c.product_id')
        ->join('payment_method as e','e.id = c.payment_id')
        ->join('enum_payment_method as f', 'f.id = e.enum_payment_method_id')
        ->join('location as g','g.id = c.location_id','left')
        ->where('a.project_id', $project_id);
        $query = $this->db->get();
        return $query->result();
        */
    }

    public function get_project_contain_product_id($product_id)
    {
        $this->db->select('b.id, b.payment_method_id')
            ->from('project_products as a')
            ->join('project as b', 'a.project_id = b.id')
            ->where('a.is_deleted', 0)
            ->where('a.is_kontrak', 0)
            ->where('product_id', $product_id);
        $query = $this->db->get();
        $data_return = [];
        foreach ($query->result() as $v) {
            $data_return[$v->id] = $v->payment_method_id;
        }

        return $data_return;
    }

    public function get_smcb_data($project_id)
    {
        $sql = "
            SELECT sdp.* FROM sumber_data_pmcs sdp
            LEFT JOIN project_new pn ON sdp.spk_code = pn.no_spk
            WHERE pn.id = $project_id GROUP BY sdp.smbd_code
        ";

        return $this->db->query($sql)->result();
    }

    public function get_price_smcb($smcb)
    {
        $smbd_code = $this->db->get_where('sumber_data_pmcs', ['id' => $smcb])->row('smbd_code');

        $sql = "
            SELECT DATE_FORMAT(periode_pengadaan, '%d-%m-%Y') periode_pengadaan_format, DATE_FORMAT(updated_date, '%d-%m-%Y') updated_date, periode_pengadaan, price FROM sumber_data_pmcs WHERE periode_pengadaan <=  NOW() AND smbd_code = '$smbd_code' ORDER BY periode_pengadaan DESC LIMIT 1
        ";

        return $this->db->query($sql)->result();
    }

    public function getProjectByUserIdNew()
    {
        if ($this->ion_auth->in_group([3])) {
            return FALSE;
        }

        $where = ['is_deleted' => 0];
        if (!$this->ion_auth->in_group(3)) {
            $where['departemen_id'] = $this->data['users']->group_id;
        }

        $this->db->where($where);
        $query = $this->db->get('project_new');
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return FALSE;
    }

    public function getProjectByUserId()
    {

        if (!$this->data['users']->group_id) {
            return FALSE;
        }

        $query_groups = $this->db->get_where('users', array('group_id' => $this->data['users']->group_id))->result();

        if (empty($query_groups)) {
            return FALSE;
        }
        //var_dump($this->db->last_query());
        $anggota_groups = array();
        foreach ($query_groups as $v) {
            $anggota_groups[] = $v->id;
        }

        //var_dump($anggota_groups);

        $arr_ret = array();
        //$project_user = $this->db->get_where('project_users', array('user_id' => $this->data['users']->id));

        $this->db->select("a.project_id, b.start_contract, b.end_contract")
            ->from("project_users as a")
            ->join("project as b", "b.id = a.project_id")
            ->where(array('user_id' => $this->data['users']->id))
            ->where('b.start_contract <= CURRENT_DATE ()', NULL)
            ->where('b.end_contract >= CURRENT_DATE ()', NULL);

        $project_user = $this->db->get();

        foreach ($project_user->result() as $v) {
            $arr_ret[] = $v->project_id;
        }

        $project_departement = $this->db
            ->query("SELECT `project_departement`.`project_id` FROM `project_departement`
                INNER JOIN `project`
                ON `project`.`id` = `project_departement`.`project_id`
                WHERE `project_departement`.`group_id` = " . $this->data['users']->group_id . "
                AND `project`.`start_contract` <= CURRENT_DATE ()
                AND `project`.`end_contract` >= CURRENT_DATE ()
                AND `project_id` NOT IN (SELECT `a`.`project_id` FROM `project_users` a
                INNER JOIN `users` `b`
                ON `a`.`user_id` = `b`.`id`
                WHERE `user_id` IN (" . implode(',', $anggota_groups) . "))");

        foreach ($project_departement->result() as $v) {
            $arr_ret[] = $v->project_id;
        }

        if (empty($arr_ret)) {
            return array();
        }

        //$project_departement = $this->db->query("SELECT * FROM project_");
        $get = $this->db->where_in('id', $arr_ret)->get('project')->result();
        //my_print_r($this->db->queries);
        return $get;
    }

    public function get_data_monev_chart($tahun, $category_id)
    {
        $ret = [];
        $limit = 11;

        // $wika = $this->_get_result_monev($tahun, $category_id, TRUE);
        // foreach ($wika as $k => $v)
        // {
        //     $ret[] = [
        //         'vendor_id' => -1,
        //         'volume_terpakai'   => (float) $v->volume_terpakai,
        //         // 'volume_tersedia'   => $v->volume_tersedia,
        //         // tersedia     | Terpakai
        //         // 3000         | 2000
        //         'volume_sisa'       => $v->volume_terpakai > $v->volume_tersedia ? 0 : $v->volume_tersedia - $v->volume_terpakai,
        //         // 2000 < 1000
        //         'volume_over'       => $v->volume_terpakai < $v->volume_tersedia ? 0 : $v->volume_terpakai - $v->volume_tersedia,
        //         'vendor_name'       => 'Kebutuhan WIKA',
        //     ];
        // }
        $sql = "SELECT project.vendor_id, IFNULL(product.jml_weight, 0) as jml_weight
                , IFNULL(project.volume, 0) as volume_tersedia
                , IFNULL(order_last_years.jml_weight_last_year, 0) as jml_weight_last_year
                , vendor.name as vendor_name FROM (
                	SELECT SUM(volume) as volume , vendor_id FROM `project` WHERE is_deleted = 0
                	AND EXTRACT(YEAR FROM created_at) <= '$tahun'
                	AND category_id = '$category_id'
                	GROUP BY vendor_id
                ) project
                LEFT JOIN (
                	SELECT a.vendor_id, SUM(b.qty * b.weight) as jml_weight FROM `order` a
                	INNER JOIN order_product b
                	ON a.order_no = b.order_no
                	LEFT JOIN product c
                	ON c.id = b.product_id
                	WHERE a.order_status <> 3 AND EXTRACT(YEAR FROM `a`.created_at) = '$tahun'
                	AND c.category_id = '$category_id'
                	GROUP BY a.vendor_id
                ) product
                ON product.vendor_id = project.vendor_id
                LEFT JOIN (
                	SELECT a.vendor_id, SUM(b.qty * b.weight) as jml_weight_last_year FROM `order` a
                	INNER JOIN order_product b
                	ON a.order_no = b.order_no
                	LEFT JOIN product c
                	ON c.id = b.product_id
                	WHERE a.order_status <> 3 AND EXTRACT(YEAR FROM `a`.created_at) < '$tahun'
                	AND c.category_id = '$category_id'
                	GROUP BY a.vendor_id
                )order_last_years
                ON order_last_years.vendor_id = project.vendor_id
                JOIN vendor
                ON vendor.id = project.vendor_id
                ORDER BY volume_tersedia DESC, jml_weight DESC";
        // $vendors = $this->_get_result_monev($tahun, $category_id);
        $vendors = $this->db->query($sql)->result();
        $for_not_in = [];
        foreach ($vendors as $k => $v) {
            $volume_tersedia = $v->volume_tersedia - ($v->jml_weight + $v->jml_weight_last_year);
            // die($volume_tersedia);
            $for_not_in[] = $v->vendor_id;
            $ret[] = [
                'vendor_id' => $v->vendor_id,
                'volume_terpakai'   => (float) $v->jml_weight,
                // 'volume_tersedia'   => $v->volume_tersedia,
                // tersedia     | Terpakai
                // 3000         | 2000
                'volume_sisa'       => $volume_tersedia,
                // 2000 < 1000
                'volume_over'       => $volume_tersedia > 0 ? 0 : $v->jml_weight - $v->volume_tersedia,
                'vendor_name'       => $v->vendor_name,
            ];
        }

        if (count($ret) < $limit) {
            $sisa = $limit - count($ret);
            $this->db->select('vendor.id, vendor.name')
                ->from('vendor')
                ->join('project', 'project.vendor_id = vendor.id')
                ->where('vendor.is_deleted', 0)
                ->where('project.is_deleted', 0)
                ->where('project.category_id', $category_id)
                ->limit($sisa)
                ->order_by('rand()', 'ASC');
            if (!empty($for_not_in)) {
                $this->db->where_not_in('vendor.id', $for_not_in);
            }

            $q = $this->db->get()->result();
            foreach ($q as $k => $v) {
                $ret[] = [
                    'vendor_id' => $v->id,
                    'volume_terpakai'   => 0,
                    'volume_sisa'       => 0,
                    'volume_over'       => 0,
                    'vendor_name'       => $v->name,
                ];
            }
        }

        return $ret;
    }

    private function _get_result_monev($tahun, $category_id, $is_wika = FALSE)
    {
        $this->db->select('SUM(IFNULL(amandemen.volume,project.volume)) as volume_tersedia, SUM(project.volume_terpakai) as volume_terpakai')
            ->from('project')
            ->join('amandemen', 'amandemen.id = project.last_amandemen_id', 'left')
            ->where('project.is_deleted', 0)
            ->where('project.category_id', $category_id)
            ->where("EXTRACT(YEAR FROM project.tanggal) = '$tahun'", NULL, FALSE);
        if ($is_wika === FALSE) {
            $this->db->select('project.vendor_id, vendor.name as vendor_name')
                ->join('vendor', 'vendor.id = project.vendor_id')
                ->group_by('project.vendor_id')
                ->order_by('volume_tersedia', 'DESC')
                ->limit(10);
        }

        $q = $this->db->get();
        return $q->result();
    }
}
