<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Detailproduct extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
        $this->load->model('product_gallery_model');
        $this->load->model('Location_model');
    }

    public function index()
    {
        $id = $this->uri->segment(2);
        $this->load->helper('url');

        $this->save_view_product($id);
        // if($this->data['is_can_read']){
        //     $this->data['content']  = 'frontend/product/detail';
        // }else{
        //     redirect('restrict');
        // }

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        } else {
            $this->data['detail'] = $this->product_model->findAllDataProduct(['product.id' => $id]);
            //echo $this->db->last_query();
            if ($this->data['detail']) {
                $this->data['json_detail'] = json_encode($this->data['detail']);
                $this->data['content']  = 'frontend/product/detail';
                $search = array(
                    "product.code_1" => $this->data['detail']->code_1,
                );
                $limit = 0;
                $where['product.id != '] = $this->data['detail']->id;
                $today = date('Y-m-d');
                $this->data['is_end_contract'] = ($this->data['detail']->end_contract <= $today) ? '1' : '0';
                //die($this->data['is_end_contract']);
                $this->data['similar']  = $this->product_model->getSimilarProductOnePicture($search, $where, $limit);
                $this->data['product_gallery'] = $this->product_gallery_model->getAllById(['product_gallery.product_id' => $id]);

                $this->data['product_payment'] = $this->product_model->getProductByPaymentMethod(['product.id' => $id]);
                //die($this->db->last_query());
                $this->load->model('Product_include_price_model');
                $this->data['price_include'] = $this->Product_include_price_model->getAllById(array('product_id' => $id));

                $contract = $this->product_model->get_tanggal_kontrak_by_product_id($id);
                //var_dump($contract);
                if ($contract === FALSE) {
                    $this->data['contract'] = '';
                } else {
                    $ket_contract = date("j F Y", strtotime($contract->start_contract)) . ' - ' . date("j F Y", strtotime($contract->end_contract));
                    $this->data['contract'] = $ket_contract;
                }

                $volume = $this->product_model->get_volume_products_on_amandemen_or_project($id);
                $this->data['volumes'] = $volume;

                // jika terkontrak atau is_margis maka can_order = true;
                $this->data['can_order'] = FALSE;
                if ($this->product_model->cek_is_terkontrak($id) === TRUE) {
                    $this->data['can_order'] = TRUE;
                }

                $this->data['locationArr'] = $this->Location_model->getAllLocationArr2();
                $this->load->view('frontend/layouts/page', $this->data);
            } else {
                $this->load->view('errors/html/error_404');
            }
        }
    }

    function save_view_product($id)
    {
        $data = [
            'id_product' => $id,
            'viewed_by' => $this->data['users']->id,
            'date' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('view_products', $data);
    }
}
