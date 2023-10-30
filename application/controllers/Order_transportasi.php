<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Order_transportasi extends Admin_Controller {

    protected $cont = 'order_transportasi';

 	public function __construct()
	{
		parent::__construct();
        $this->load->model('Order_transportasi_model', 'model');
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
      		1 =>'order_transportasi.order_no',
            2 =>'project_new.name',
            3 =>'vendor.name',
            4 =>'location.name',
            5 =>'location2.name',
            6 =>'total_weight',
            7 =>'order_transportasi.biaya_transport',
            8 =>'total_biaya_transport',
            9 =>'order_transportasi.created_at',
        );
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  		$search = array();
        $where = [];
        if ($this->ion_auth->in_group(3))
        {
            $where['order_transportasi.vendor_id'] = $this->data['users']->vendor_id;
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
                $valOrderNo = substr($filterjs[0]->order_no, 0, 1) == 'T' ? substr($filterjs[0]->order_no, 1) : $filterjs[0]->order_no;
                $search['order_transportasi.order_no'] = $valOrderNo;
            }

            if($filterjs[0]->nm_project){
                $search['project_new.name'] = $filterjs[0]->nm_project;
            }

            if($filterjs[0]->vendor_name){
                $search['vendor.name'] = $filterjs[0]->vendor_name;
            }

            if($filterjs[0]->location_origin_name){
                $search['location.name'] = $filterjs[0]->location_origin_name;
            }

            if($filterjs[0]->location_destination_name){
                $search['location2.name'] = $filterjs[0]->location_destination_name;
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
        // echo $this->db->last_query();
        // die();
        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {

            	$export_pdf = "";
     			$delete_url = "";
                $noPolButton = '';

                if ($this->data['is_can_edit'])
                {
                    $noPolButton = "<button class='btn btn-sm btn-danger set-nopol' type='button'
                    data-traller-inputed='" . $data->data_traller_inputed . "'
                    data-traller='" . $data->data_trailer . "'
                    data-orderid='" . $data->order_no . "'>Set No Polisi</button>";
                }

                if ($data->data_traller_inputed != '' || $data->order_status != '2')
                {
                    $noPolButton = '';
                }

                $generate_ulang_url = '';
                if ($data->order_status == '2' && $data->pdf_name != '' && $this->data['is_can_edit'])
                {
                    $export_pdf = "<a target='_blank' href='".base_url()."pdf/po/" . $data->pdf_name . "' class='btn btn-sm btn-success'><i class='fa fa-file-pdf-o'></i> Export Pdf</a>";
                    if ($this->data['is_can_edit'])
                    {
                    }
                    $generate_ulang_url = "<a href='javascript:;'
                    url='".base_url()."order/generatepdfTransport/".$data->order_no."/1'
                    class='btn btn-sm btn-info generate-ulang' title='Generate Ulang'><i class='fa fa-refresh'></i>
                    </a>";
                }

                $notMeetMinimum = $data->total_weight < $data->weight_minimum * 1000;

                $nestedData['id'] = $start+$key+1;
                $nestedData['order_no'] = 'T' . $data->order_no;
                $nestedData['project_name'] = $data->project_name;
                $nestedData['vendor_name'] = $data->vendor_name;
                $nestedData['origin_name'] = $data->origin_name;
                $nestedData['destination_name'] = $data->destination_name;
                $nestedData['total_weight'] = rupiah($data->total_weight, 0);
                $nestedData['biaya_transport'] = rupiah($data->biaya_transport);
                $nestedData['total_biaya_transport'] = rupiah($data->total_biaya_transport) . ' ' . ($notMeetMinimum ? '<a href="javascript:;" data-toogle="tooltip" title="tidak mencapai minimal berat"><i class="fa fa-question-circle"></i></a>' : '');
                $nestedData['created_at'] = tgl_indo($data->created_at, TRUE);


           		$nestedData['action'] = $export_pdf . ' ' .$noPolButton . ' ' . $generate_ulang_url;
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

    public function pdfTransportOld($order_no)
    {

        $dataOrder = $this->model->getDataPdfTransport(['order_transportasi.order_no'=>$order_no]);
        $this->data['dataPekerjaan'] = $this->model->getDataPekerjaan(['order_transportasi_d.order_no'=>$order_no]);
        $data = $this->db->get_where('order',['order_no' => $order_no])->row();


        $this->data['tgl_kontrak']          =   tgl_indo($dataOrder->tgl_kontrak);
        $this->data['no_kontrak_transport'] =   $dataOrder->no_kontrak_transport;
        $this->data['nama_project']         =   $dataOrder->nama_project;
        $this->data['nama_vendor']          =   $dataOrder->nama_vendor;
        $this->data['nama_direktur']        =   $dataOrder->nama_direktur;
        $this->data['jabatan']              =   $dataOrder->jabatan;
        $this->data['departemen']           =   $dataOrder->departemen;
        $this->data['gm']                   =   $dataOrder->gm;
        $this->data['dataOrder']            =   $dataOrder;
        $this->data['tgl_approve']          =   tgl_indo($data->update_at);
        $this->data['tgl_order']          =   tgl_indo($data->created_at);
        $this->data['order_no']             =   $order_no;

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
        $html = $this->load->view('admin/order/pdf_transport_v', $this->data,true);
        $mpdf->WriteHTML($html);
        $filename = "PO_TRANSPORTASI".$order_no.'_'.time();
        $mpdf->Output("pdf/po/".$filename.".pdf" ,"I");

    }


    public function pdfTransport($order_no)
    {
        $dataOrder = $this->model->getDataPdfTransport(['order_transportasi.order_no'=>$order_no]);
        $this->data['dataPekerjaan'] = $this->model->getDataPekerjaan(['order_transportasi_d.order_no'=>$order_no]);
        $data = $this->db->get_where('order',['order_no' => $order_no])->row();
        $this->data['dataOrder'] = $dataOrder;

        $this->data['tgl_kontrak']          =   tgl_indo($dataOrder->tgl_kontrak);
        $this->data['no_kontrak_transport'] =   $dataOrder->no_kontrak_transport . ($dataOrder->no_amandemen != '' ? '-Amd' . $dataOrder->no_amandemen : '');
        $this->data['nama_project']         =   $dataOrder->nama_project;
        $this->data['nama_vendor']          =   $dataOrder->nama_vendor;
        $this->data['nama_direktur']        =   $dataOrder->nama_direktur;
        $this->data['jabatan']              =   $dataOrder->jabatan;
        $this->data['departemen']           =   $dataOrder->departemen;
        $this->data['gm']                   =   $dataOrder->gm;
        $this->data['dataOrder']            =   $dataOrder;
        $this->data['tgl_approve']          =   tgl_indo($data->update_at);
        $this->data['tgl_order']          =   tgl_indo($data->created_at);
        $this->data['order_no']             =   $order_no;
        $this->load->model('Order_model');
        $this->data['detail_order'] = $this->Order_model->detail_order(['a.order_no' => $order_no]);

        //$html = $this->load->view('admin/order/pdf_transport_v2', $this->data);

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
        $html = $this->load->view('admin/order/pdf_transport_v2', $this->data,true);
        $mpdf->WriteHTML($html);
        $filename = "PO_TRANSPORTASI".$order_no.'_'.time();
        $mpdf->Output("pdf/po/".$filename.".pdf" ,"I");

    }

    public function setNopol()
    {
        $this->form_validation
        ->set_rules('order_no', 'Order No', 'trim|required')
        ->set_rules('data_traller[]', 'Data Traller', 'trim|required');

        if ($this->form_validation->run() === FALSE)
        {
            echo json_encode(['status' => FALSE, 'message' => validation_errors()]);
            return;
        }

        $isOrderAsuransiExist = $this->db->get_where('order_asuransi', ['order_no' => $this->input->post('order_no')])->num_rows() > 0;
        if ($isOrderAsuransiExist === TRUE)
        {
            $this->db->where('order_no', $this->input->post('order_no'))->update('order_asuransi', ['generatepdf_time' => $this->data['now_datetime']]);
            $this->sendPdfAsuransi($this->input->post('order_no'));
        }

        $update = $this->model->update(['data_traller' => implode(',', $this->input->post('data_traller'))], ['order_no' => $this->input->post('order_no')]);
        ob_end_clean();
        echo json_encode(['status' => $update === FALSE ? FALSE : TRUE, 'message' => $update === FALSE ? 'Set No Polisi gagal' : 'Sukses']);
    }

    public function sendPdfAsuransi($order_no, $generate_ulang = 0)
    {
        $this->load->model('Order_asuransi_model');
        $this->load->model('User_model');
        $dataOrder = $this->Order_asuransi_model->getDataPdfAsuransi(['order_asuransi.order_no'=>$order_no]);
        $this->data['dataOrder'] = $dataOrder;
        $this->data['order_menu'] = $this->Order_asuransi_model->getAllDataById(['order_asuransi_d.order_no'=>$order_no]);
        $this->data['department'] = $this->User_model->getDepartmentUser($dataOrder->created_by);
        $this->data['pake_ttd'] = FALSE;
        $asuransi = $this->db->get_where('asuransi',['id' => $dataOrder->asuransi_id])->row();
        $this->load->model('Order_transportasi_model');
        $this->data['orderTransport'] = $this->Order_transportasi_model->getDataPdfTransport(['order_transportasi.order_no'=>$order_no]);
        $this->load->model('Order_model');
        $this->data['orderProduct'] = $this->Order_model->getOneBy(['order.order_no'=>$order_no]);
        $this->load->model('Vendor_model');
        $this->data['vendorProduct'] = $this->Vendor_model->findvendor(['vendor.id' => $this->data['orderProduct']->vendor_id]);

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
        $mpdf->Output("pdf/po/".$filename.".pdf" ,"F");
        // kirim email
        $this->load->helper('email_helper');
        $this->load->model('User_model');
        $q_users = $this->User_model->getOneBy(['users.vendor_id' => $dataOrder->vendor_id]);
        if ($q_users !== FALSE)
        {
            if ($generate_ulang == 0)
            {
                send_email_po($q_users->email,$filename.".pdf",$order_no);
            }
        }

        $this->Order_asuransi_model->update(['pdf_name' => $filename . ".pdf"],['order_no' => $order_no]);
    }


}
