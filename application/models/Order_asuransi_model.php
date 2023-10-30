<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order_asuransi_model extends MY_Model
{
    protected $table = 'order_asuransi';

    public function __construct()
    {
        parent::__construct();
    }


    public function getMainQuery()
    {
        $this->db->select('order_asuransi.order_no
        , vendor.name as vendor_name
        , order_asuransi.nilai_asuransi
        , order_asuransi.created_at
        , project_new.name as project_name
        , order_asuransi.jenis_asuransi
        , order_asuransi.nilai_harga_minimum
        , case WHEN order_asuransi.jenis_asuransi = "percent"
        THEN SUM(order_asuransi_d.qty * order_asuransi_d.weight * order_asuransi_d.price * order_asuransi.nilai_asuransi / 100)
        ELSE SUM(order_asuransi_d.qty * order_asuransi_d.weight * order_asuransi.nilai_asuransi )
        END as total_nilai_asuransi
        , SUM(order_asuransi_d.qty * order_asuransi_d.weight * order_asuransi_d.price ) as nilai_po
        , order.order_status
        , order_asuransi.pdf_name ')
        ->from('order_asuransi')
        ->join('order_asuransi_d', 'order_asuransi.order_no = order_asuransi_d.order_no')
        ->join('vendor', 'vendor.id = order_asuransi.vendor_id')
        ->join('project_new', 'project_new.id = order_asuransi.project_id')
        ->join('order', 'order.order_no = order_asuransi.order_no')
        ->group_by(['order_asuransi.order_no']);
    }
	
	public function getBiayaAsuransi($where = array()){
		$this->db->select("*")
        ->from('order_asuransi')
        ->join('order_asuransi_d', 'order_asuransi.order_no = order_asuransi_d.order_no','left')
        ->where($where);
        $query = $this->db->get();
		if ($query->num_rows() >0){
            $jmlHarga = 0;
            $jmlVolume = 0;
            $weight_minimum = 0;
            $totaltransport = 0;
    		foreach ($query->result() as $t) {
                $jmlHarga += (int) ($t->qty * $t->weight * $t->price);
                $jmlVolume += $t->qty * $t->weight;
                $jenis_asuransi = $t->jenis_asuransi;
                $nilai_asuransi = $t->nilai_asuransi;
                $nilai_harga_minimum = $t->nilai_harga_minimum;
            }
            if ($jenis_asuransi=='percent') {
                $total_asuransi = $nilai_asuransi / 100 * $jmlHarga;
            } else {
                $total_asuransi = $nilai_asuransi * $jmlVolume;
            }
            $total_asuransi = $nilai_harga_minimum < $total_asuransi ? $total_asuransi : $nilai_harga_minimum;
            
            return $total_asuransi;
            
    	}
    	return 0;
    }
	
    public function getDataPdfAsuransi($where = array()){
        $this->db->select("order_asuransi.*,
                groups.name as departemen,
                project_new.name as nama_project,
                order_asuransi.order_no as no_order,
                order_asuransi.vendor_id as vendor,
                vendor.address as alamat_vendor,
                vendor.name as vendor_name,
                asuransi.no_contract as no_contract,
                asuransi.tgl_kontrak as tgl_kontrak,
                asuransi.tahun,
                asuransi.no_cargo_insurance,
                vendor.no_fax as no_fax,
                vendor.ttd_name as vendor_nama_direktur,
                order_asuransi.perihal as perihal,
                vendor.no_telp,
            ");
        $this->db->from("order_asuransi");
        // $this->db->join('payment_method','payment_method.id = order_asuransi.payment_method_id','left');
        // $this->db->join('enum_payment_method','enum_payment_method.id = payment_method.enum_payment_method_id','left');
        $this->db->join('project_new','project_new.id = order_asuransi.project_id', 'left');
        $this->db->join('groups','groups.id = project_new.departemen_id');
        $this->db->join('vendor','vendor.id = order_asuransi.vendor_id');
        // $this->db->join('shipping','shipping.id = order_asuransi.shipping_id');
        $this->db->join('asuransi','asuransi.id = order_asuransi.asuransi_id');
        $this->db->where($where);

        $query = $this->db->get();
        if ($query->num_rows() >0){
            return $query->row();
        }
        return FALSE;
    }

    public function getAllDataById($where = array()){
        $this->db->select('order_asuransi_d.*,
                            vendor.name as vendor_name,
                            vendor.start_contract,
                            vendor.end_contract,
                            vendor.id as vendor_id,
                            vendor.email as vendor_email,
                            vendor.no_contract as vendor_no_contract,
                            vendor.address as vendor_address,
                            location.name as location_name,
                            vendor.ttd_name as vendor_nama_direktur,
                            vendor.no_telp as vendor_no_telp,
                            vendor.no_fax as vendor_no_fax,
                            vendor.ttd_pos as vendor_dir_pos
                            ')
                 ->from('order_asuransi_d')
                 ->join('order_asuransi','order_asuransi.order_no = order_asuransi_d.order_no','left')
                 ->join('vendor','vendor.id = order_asuransi.vendor_id','left')
                 ->join('product', 'product.id = order_asuransi_d.product_id')
                 ->join('location', 'product.location_id = location.id', 'left');
        $this->db->where($where);
        $query = $this->db->get();
        if ($query->num_rows() >0){
            return $query->result();
        }
        return FALSE;
    }

}
