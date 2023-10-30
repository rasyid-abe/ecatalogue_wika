<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
require_once BASEPATH. 'vendor/autoload.php';
use Mpdf\Mpdf;
class Finishorder extends Admin_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('order_model');
        $this->load->model('order_product_model');

    }

    public function index()
    {
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }else{
            $this->data['content']  = 'frontend/finish/main';
            $this->load->view('frontend/layouts/page',$this->data);
        }
    }

    public function generatepdf($order_no){
        $order_no = $this->uri->segment(3);
        $order = $this->order_model->getDataOneBy(['order.order_no'=>$order_no]);
        $order_menu = $this->order_product_model->getAllDataById(['order_product.order_no'=>$order_no]);
        //$data['cek'] = $this->db->last_query();

        $data['hari'] = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu'
        ];

        $data['order'] = $order;
        $data['order_menu'] = $order_menu;
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
        $html = $this->load->view('frontend/email/order_po',$data,true);
        $mpdf->WriteHTML($html);
        $mpdf->SetMargins(0,0,0);
        $filename = "_cek_".time();
        $mpdf->Output("pdf/po/".$filename.".pdf" ,"I");
        exit();

        //var_dump($data);
        if($list_product){
            $this->load->helper('email_helper');
            foreach ($list_product as $key => $value) {
                $data['order_product'] = $value;
                $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
                $html = $this->load->view('frontend/email/order_po',$data,true);
                $mpdf->WriteHTML($html);
                //exit('a');
                $filename = $value['order_no']."_".$value['vendor_id']."_".time();
                $mpdf->Output("pdf/po/".$filename.".pdf" ,"I");
                //send_email_po($value['vendor_email'],$filename.".pdf",$order_no);
            }
        }

        redirect('finishorder');
    }

    public function generatepdf_lama($order_no){
        $order_no = $this->uri->segment(3);
        $order = $this->order_model->getDataOneBy(['order.order_no'=>$order_no]);
        $order_menu = $this->order_product_model->getAllDataById(['order_product.order_no'=>$order_no]);
        //$data['cek'] = $this->db->last_query();

        $list_product = array();
        if($order_menu){
            foreach ($order_menu as $key => $value) {
                $list_product[$value->vendor_id]['products'][] = $value;
                $list_product[$value->vendor_id]['vendor_email'] = $value->vendor_email;
                $list_product[$value->vendor_id]['vendor_name'] = $value->vendor_name;
                $list_product[$value->vendor_id]['vendor_no_contract'] = $value->vendor_no_contract;
                $list_product[$value->vendor_id]['vendor_id'] = $value->vendor_id;
                $list_product[$value->vendor_id]['order_no'] = $value->order_no;
            }
        }

        $data['order'] = $order;
        //var_dump($data);
        if($list_product){
            $this->load->helper('email_helper');
            foreach ($list_product as $key => $value) {
                $data['order_product'] = $value;
                $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
                $html = $this->load->view('frontend/email/order_po',$data,true);
                $mpdf->WriteHTML($html);
                //exit('a');
                $filename = $value['order_no']."_".$value['vendor_id']."_".time();
                $mpdf->Output("pdf/po/".$filename.".pdf" ,"F");
                //send_email_po($value['vendor_email'],$filename.".pdf",$order_no);
            }
        }

        redirect('finishorder');
    }
}
