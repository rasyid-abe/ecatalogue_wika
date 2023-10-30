<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Order_asuransi extends Admin_Controller {

    protected $cont = 'order_asuransi';

 	public function __construct()
	{
		parent::__construct();
        $this->load->model('Order_asuransi_model', 'model');
        $this->load->model('order_model');
        $this->load->model('order_product_model');
        $this->load->model('User_model');
        $this->data['cont'] = $this->cont;
	}

    public function index()
    {
        if($this->data['is_can_read']){
			$this->data['content'] = 'admin/'.$this->cont.'/list_v';
		}else{
			redirect('restrict');
		}

		$this->load->view('admin/layouts/page',$this->data);
    }

    public function dataList()
    {
        $columns = array(
            // 0 =>'order_product',
      		1 =>'order_asuransi.order_no',
            2 =>'project_new.name',
            3 =>'vendor.name',
            4 =>'order_asuransi.nilai_asuransi',
            5 =>'total_nilai_asuransi',
            6 =>'order_asuransi.created_at',
        );
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  		$search = array();
        $where = [];

        if ($this->ion_auth->in_group(3))
        {
            $where['order_asuransi.vendor_id'] = $this->data['users']->vendor_id;
            $where['order.order_status'] = 2;
        }
        
  		$limit = 0;
  		$start = 0;

        $totalData = $this->model->getCountAllBy($limit,$start,$search,$order,$dir,$where);

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;

        if(!empty($searchColumn[1]['search']['value'])){
        	$value = $searchColumn[1]['search']['value'];
        	$isSearchColumn = true;
         	// $search['project_new.name'] = $value;
            $filterjs = json_decode($value);

            if($filterjs[0]->order_no){
                $valOrderNo = substr($filterjs[0]->order_no, 0, 1) == 'A' ? substr($filterjs[0]->order_no, 1) : $filterjs[0]->order_no;
                $search['order.order_no'] = $valOrderNo;
            }

            if($filterjs[0]->nm_project){
                $search['project_new.name'] = $filterjs[0]->nm_project;
            }

            if($filterjs[0]->vendor_name){
                $search['vendor.name'] = $filterjs[0]->vendor_name;
            }
		}

    	if($isSearchColumn){
			$totalFiltered = $this->model->getCountAllBy($limit,$start,$search,$order,$dir,$where);
        }else{
        	$totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
		$datas = $this->model->getAllBy($limit,$start,$search,$order,$dir,$where);
        //die(print_r($datas));
        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {

            	$edit_url = "";
     			$delete_url = "";
                $pdf="";

                $nestedData['id'] = $start+$key+1;
                $nestedData['order_no'] = 'A' . $data->order_no;
                $nestedData['project_name'] = $data->project_name;
                $nestedData['vendor_name'] = $data->vendor_name;
                $nestedData['nilai_asuransi'] = rupiah($data->nilai_asuransi, 2) . ($data->jenis_asuransi == 'percent' ? ' %' : '/Kg');
                $nestedData['total_nilai_asuransi'] = $data->nilai_harga_minimum < $data->total_nilai_asuransi ? rupiah($data->total_nilai_asuransi) : rupiah($data->nilai_harga_minimum);
                $nestedData['nilai_po'] = rupiah($data->nilai_po);
                $nestedData['created_at'] = tgl_indo($data->created_at, TRUE);

                if ($data->order_status == '2' && $data->pdf_name != '')
                {
                    $pdf = "<a target='_blank' href='".base_url()."pdf/po/".$data->pdf_name."' class='btn btn-sm btn-success'><i class='fa fa-file-pdf-o'></i> Export Pdf</a>";
                }



           		$nestedData['action'] = $pdf;
                $new_data[] = $nestedData;
            }
        }

        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),
                    "recordsTotal"    => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data"            => $new_data
                    );

        echo json_encode($json_data);
    }

    public function pdfAsuransiOld($order_no)
    {

        $dataOrder = $this->model->getDataPdfAsuransi(['order_asuransi.order_no'=>$order_no]);
        $this->data['order_menu'] = $this->model->getAllDataById(['order_asuransi_d.order_no'=>$order_no]);
        $this->data['department'] = $this->User_model->getDepartmentUser($dataOrder->created_by);
        $this->data['pake_ttd'] = FALSE;
        $asuransi = $this->db->get_where('asuransi',['id' => $dataOrder->asuransi_id])->row();

        $this->data['nama_project']         =   $dataOrder->nama_project;
        $this->data['order_no']             =   $dataOrder->order_no;
        $this->data['vendor_name']          =   $dataOrder->vendor_name;
        $this->data['alamat_vendor']        =   $dataOrder->alamat_vendor;
        $this->data['no_fax']               =   $dataOrder->no_fax;
        $this->data['vendor_nama_direktur'] =   $dataOrder->vendor_nama_direktur;
        $this->data['perihal']              =   $dataOrder->perihal;
        $this->data['departemen']           =   $dataOrder->departemen;
        $this->data['no_contract']           =   $dataOrder->no_contract;
        $this->data['tgl_kontrak']           =   $dataOrder->tgl_kontrak;
        $this->data['start_date']           =   tgl_indo($asuransi->start_date);
        $this->data['end_date']           =   tgl_indo($asuransi->end_date);
        $this->data['nilai_harga_minimum']           =   $dataOrder->nilai_harga_minimum;

        $this->data['jenis_asuransi']           =   $dataOrder->jenis_asuransi;
        $this->data['nilai_asuransi']           =   $dataOrder->nilai_asuransi;

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
        $html = $this->load->view('admin/order_asuransi/pdf_asuransi_v', $this->data,true);
        $mpdf->WriteHTML($html);
        $filename = "PO_ASURANSI_".$order_no.'_'.time();
        $mpdf->Output("pdf/po/".$filename.".pdf" ,"I");

    }

    public function pdfAsuransi($order_no)
    {
        $dataOrder = $this->model->getDataPdfAsuransi(['order_asuransi.order_no'=>$order_no]);
        $this->data['dataOrder'] = $dataOrder;
        $this->data['order_menu'] = $this->model->getAllDataById(['order_asuransi_d.order_no'=>$order_no]);
        $this->data['department'] = $this->User_model->getDepartmentUser($dataOrder->created_by);
        $this->data['pake_ttd'] = FALSE;
        $asuransi = $this->db->get_where('asuransi',['id' => $dataOrder->asuransi_id])->row();
        $this->load->model('Order_transportasi_model');
        $this->data['orderTransport'] = $this->Order_transportasi_model->getDataPdfTransport(['order_transportasi.order_no'=>$order_no]);
        $this->load->model('Order_model');
        $this->data['orderProduct'] = $this->Order_model->getOneBy(['order.order_no'=>$order_no]);
        $this->load->model('Vendor_model');
        $this->data['vendorProduct'] = $this->Vendor_model->findvendor(['vendor.id' => $this->data['orderProduct']->vendor_id]);
        //var_dump($this->data['orderProduct']);
        //die();

        $this->data['nama_project']         =   $dataOrder->nama_project;
        $this->data['order_no']             =   $dataOrder->order_no;
        $this->data['vendor_name']          =   $dataOrder->vendor_name;
        $this->data['alamat_vendor']        =   $dataOrder->alamat_vendor;
        $this->data['no_fax']               =   $dataOrder->no_fax;
        $this->data['vendor_nama_direktur'] =   $dataOrder->vendor_nama_direktur;
        $this->data['perihal']              =   $dataOrder->perihal;
        $this->data['departemen']           =   $dataOrder->departemen;
        $this->data['no_contract']           =   $dataOrder->no_contract;
        $this->data['tgl_kontrak']           =   $dataOrder->tgl_kontrak;
        $this->data['start_date']           =   tgl_indo($asuransi->start_date);
        $this->data['end_date']           =   tgl_indo($asuransi->end_date);
        $this->data['nilai_harga_minimum']           =   $dataOrder->nilai_harga_minimum;

        $this->data['jenis_asuransi']           =   $dataOrder->jenis_asuransi;
        $this->data['nilai_asuransi']           =   $dataOrder->nilai_asuransi;

        // $this->load->view('admin/order_asuransi/pdf_asuransi_v2', $this->data);

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
        $html = $this->load->view('admin/order_asuransi/pdf_asuransi_v2', $this->data,true);
        $mpdf->WriteHTML($html);
        $filename = "PO_ASURANSI_".$order_no.'_'.time();
        $mpdf->Output("pdf/po/".$filename.".pdf" ,"I");

    }

}
