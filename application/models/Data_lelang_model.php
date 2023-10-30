<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Data_lelang_model extends MY_Model
{
    protected $table = 'data_lelang';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_scm_data_lelang()
	{
		$ret = [];
		$query = $this->db->where('scm_id IS NOT NULL', NULL)->get('data_lelang');

		foreach ($query->result() as $v)
		{
			$ret[$v->id] = $v->scm_id;
		}

		return $ret;
	}

    public function getMainQuery()
    {
        $query = $this->db->select("*")
                         ->from('data_lelang')
                         ->group_by(['departemen' ,'kategori' , 'nama' , 'spesifikasi', 'harga' , 'vendor', 'tgl_terkontrak' , 'tgl_akhir_kontrak', 'volume' , 'proyek_pengguna', 'lokasi' , 'keterangan']);
                         //->where('proyek_pengguna <>', '');
                         //->group_by(['proyek_pengguna' ,'vendor' , 'tgl_terkontrak' , 'tgl_akhir_kontrak']);
    }


    public function get_detail_data_lelang($where)
    {
        $query = $this->db->get_where('data_lelang', $where);
        if($query->num_rows() > 0)
        {
            return $query->result();
        }

        return FALSE;
    }

    public function get_combo_data_lelang($column)
    {
        $this->db->select($column)
        ->from($this->table)
        ->where($column." <> ''", NULL)
        ->group_by($column);

        $query = $this->db->get();
        return $query->result();
    }

}
