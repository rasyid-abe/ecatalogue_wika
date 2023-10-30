<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Home extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('category_model');
        $this->load->model('product_model');
        $this->load->model('vendor_model');
        $this->load->model('location_model');
        $this->load->model('project_products_model');
        if ($this->data['users_groups']->id == 3) {
            redirect('dashboard');
        }
    }

    public function index()
    {
        $this->load->helper('url');
        $this->data['content']  = 'frontend/home';

        $where = $this->getFilterAndOrderBy();
        //var_dump($where);
        $where_product = $where['where_product'];
        $where_users = NULL;
        if (!$this->data['is_superadmin']) {
            $where_users = $this->data['users']->id;
        }
        $where_in = $where['where_in'];
        $order = $where['order'];
        $this->data['vendor_ar'] = $where['vendor_ar'];
        $this->data['order_check'] = $where['order_check'];
        $this->data['location_ar'] = $where['location_ar'];
        $search = $where['search'];
        $limit = 20;
        $offset = $this->uri->segment(3);
        // $offset = 0;

        // untk checkbox kontrak / tidak kontrak
        $this->data['terkontrak'] = $where['kontrak']['terkontrak'];
        $this->data['tidak_terkontrak'] = $where['kontrak']['tidak_terkontrak'];

        $this->load->model('Category_new_model');
        $this->data['category']     = $this->Category_new_model->getAllById(['is_deleted' => 0]);
        $get_view_product = $this->product_model->getAllDataProductOnePicture($where_product, $where_in, $order, $limit, $offset, $search, $where['kontrak'], $where_users);
        $this->data['product']      = $get_view_product;

        $total_product = $this->product_model->getTotalAllProduct($where_product, $where_in, $order, $search, $where['kontrak'], $where_users);

        $config['base_url'] = base_url() . 'home/index/';
        $config['total_rows'] = $total_product;
        $config['per_page'] = $limit;
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center" id="inner"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
        $this->pagination->initialize($config);

        $arr_product_id = $this->getProductIdFromProduct($this->data['product']);
        $this->data['payment_method_by_product_id'] = $this->getPaymentMethodByProductId($arr_product_id);
        $this->data['location_payment_method_by_product_id'] = $this->getPaymentMethodByProductId($arr_product_id, 'location_name');
        $this->data['arr_terkontrak'] = $this->getProductFilterTerkontrak($arr_product_id);
        $this->data['arr_no_kontrak'] = $this->getNoKontrakByArrProduct($arr_product_id);

        /*
        komment dulu ya?
        $arr_user_product = $this->getProductFilterUser();

         //jika user ditemukan di list kontrak
        if($arr_user_product){
            if($this->data['product']){
                foreach ($this->data['product'] as $key => $value) {
                    //cek di kontrak
                    if(in_array($value->id, $this->data['arr_terkontrak'])){
                        //jika tidak ditemukan di hapus
                        if(!in_array($value->id, $arr_user_product)){
                            unset($this->data['product'][$key]);
                        }
                    }
                }
            }
        }else{
            if($this->data['product']){
                foreach ($this->data['product'] as $key => $value) {
                    //semua yang terkontrak dihapus
                    if(in_array($value->id, $this->data['arr_terkontrak'])){
                        unset($this->data['product'][$key]);
                    }
                }
            }
        }
        */
        // echo "-----------------------------------------";
        // echo "<pre>";
        // print_r($this->data['product'] );
        // die();
        $this->data['vendor']       = $this->vendor_model->getvendor(['is_deleted' => 0]);
        $this->data['location']     = $this->location_model->getAllById(['is_deleted' => 0]);

        $this->load->model('User_model');
        $this->data['mandor'] = $this->User_model->getAllById(['roles.id' => 6]);
        //die($this->db->last_query());
        $this->load->view('frontend/layouts/page', $this->data);
    }

    public function getNoKontrakByArrProduct($arr)
    {
        if (!$arr) return FALSE;

        $query = $this->product_model->getArrProductNoKontrak($arr);

        $data_return = [];
        if ($query) {
            foreach ($query as $key => $val) {
                $no_contract = $val->no_contract;

                if ($val->no_aman != 0) {
                    $no_contract .= '-Amd' . $val->no_aman;
                }

                $data_return[$val->product_id][] = $no_contract;
            }
        }

        return $data_return;
    }

    public function getProductFilterTerkontrak($arr)
    {
        if (!$arr) return FALSE;

        //$where_in['product.id'] = $arr;
        $query = $this->product_model->getProductIDFilterTerkontrak($arr);

        $data_return = [];
        if ($query) {
            foreach ($query as $key => $val) {
                $data_return[] = $val->product_id;
            }
        }

        return $data_return;
    }

    public function getProductFilterUser()
    {
        $where_user_kontrak['project_users.user_id'] = $this->data['users']->id;
        $query = $this->project_products_model->getAll($where_user_kontrak);

        $data_return = [];
        if ($query) {
            foreach ($query as $key => $val) {
                $data_return[] = $val->product_id;
            }
        }

        return $data_return;
    }

    protected function getPaymentMethodByProductId($arr, $column = 'full_name')
    {
        if (!$arr) return FALSE;

        $this->load->model('payment_product_model');
        $where_in['payment_product.product_id'] = $arr;
        $query = $this->payment_product_model->getAllById([], $where_in);
        //die(var_dump($where_in));
        //die($this->db->last_query());
        $data_return = [];
        if ($query) {
            foreach ($query as $key => $val) {
                if ($val->$column == '') {
                    continue;
                }
                $data_return[$val->product_id][] = $val->$column;
            }
        }

        return $data_return;
    }

    protected function getProductIdFromProduct($arr)
    {
        if (!$arr) return FALSE;

        $data_return = [];
        foreach ($arr as $key => $val) {
            $data_return[] = $val->id;
        }

        return $data_return;
    }
    // untuk filter dan order by dari query_string;
    protected function getFilterAndOrderBy()
    {
        $return = [];
        $return['where_product']['product.is_deleted'] = 0;

        if ($this->input->get('category') && $this->input->get('category') != 'all') {
            //$return['where_product']['product.category_id'] = $this->input->get('category');
            $return['where_product']['category.category_new_id'] = $this->input->get('category');
        }

        $return['where_in'] = [];
        $return['vendor_ar'] = [];
        if ($this->input->get('vendor') && $this->input->get('vendor') != '') {
            $return['vendor_ar'] = explode(',', $this->input->get('vendor'));
            $return['where_in']['vendor.id'] = explode(',', $this->input->get('vendor'));
        }

        $return['location_ar'] = [];
        if ($this->input->get('location') && $this->input->get('location') != '') {
            $return['location_ar'] = explode(',', $this->input->get('location'));
            $return['where_in']['payment_product.location_id'] = explode(',', $this->input->get('location'));
        }

        $return['order'] = [];
        $return['order_check'] = '';
        if ($this->input->get('order') && $this->input->get('order') != '' && in_array($this->input->get('order'), ['desc', 'asc'])) {
            $return['order_check'] = $this->input->get('order');
            $return['order'] = ['product_min_price' => $this->input->get('order')];
        }

        $return['search'] = [];
        if ($this->input->get('search') && $this->input->get('search') != '') {
            $return['search']['product.name'] = $this->input->get('search');
            $return['search']['CONCAT(category.code,specification.code,`size`.code,product.code)'] = $this->input->get('search');
            $return['search']['category.name'] = $this->input->get('search');
            $return['search']['specification.name'] = $this->input->get('search');
            $return['search']['vendor.name'] = $this->input->get('search');
        }

        // untuk filter terkontrak / tidak
        $return['kontrak']['terkontrak'] = false;
        $return['terkontrak'] = false;
        if ($this->input->get('terkontrak') == 1) {
            $return['kontrak']['terkontrak'] = true;
            $return['terkontrak'] = true;
        }

        $return['kontrak']['tidak_terkontrak'] = false;
        $return['tidak_terkontrak'] = false;
        if ($this->input->get('tidak_terkontrak') == 1) {
            $return['kontrak']['tidak_terkontrak'] = true;
            $return['tidak_terkontrak'] = true;
        }
        // end untuk filter terkontrak / tidak

        return $return;
    }

    public function getNextProduct()
    {
        $page = $this->input->get('page');
        $limit = 20;
        $offset = $page * $limit;
        $where = $this->getFilterAndOrderBy();
        //var_dump($where);
        //$where_product['product.is_deleted'] = 0;
        $where_product = $where['where_product'];
        $where_in = $where['where_in'];
        $where_users = NULL;
        if (!$this->data['is_superadmin']) {
            $where_users = $this->data['users']->id;
        }
        $order = $where['order'];
        $this->data['vendor_ar'] = $where['vendor_ar'];
        $this->data['order_check'] = $where['order_check'];
        $this->data['location_ar'] = $where['location_ar'];
        $search = $where['search'];

        $this->data['product']      = $this->product_model->getAllDataProductOnePicture($where_product, $where_in, $order, $limit, $offset, $search, $where['kontrak'], $where_users);
        $q = $this->db->last_query();
        //$ret['q'] = $this->db->last_query();
        $arr_product_id = $this->getProductIdFromProduct($this->data['product']);
        $this->data['payment_method_by_product_id'] = $this->getPaymentMethodByProductId($arr_product_id);
        $this->data['location_payment_method_by_product_id'] = $this->getPaymentMethodByProductId($arr_product_id, 'location_name');
        $this->data['arr_terkontrak'] = $this->getProductFilterTerkontrak($arr_product_id);
        $this->data['arr_no_kontrak'] = $this->getNoKontrakByArrProduct($arr_product_id);

        /*
        $arr_user_product = $this->getProductFilterUser();
        //jika user ditemukan di list kontrak
        if($arr_user_product){
            if($this->data['product']){
                foreach ($this->data['product'] as $key => $value) {
                    //cek di kontrak
                    if(in_array($value->id, $this->data['arr_terkontrak'])){
                        //jika tidak ditemukan di hapus
                        if(!in_array($value->id, $arr_user_product)){
                            unset($this->data['product'][$key]);
                        }
                    }
                }
            }
        }else{
            if($this->data['product']){
                foreach ($this->data['product'] as $key => $value) {
                    //semua yang terkontrak dihapus
                    if(in_array($value->id, $this->data['arr_terkontrak'])){
                        unset($this->data['product'][$key]);
                    }
                }
            }
        }
        */

        $habis = 'tidak';

        if ((!$this->data['product']) || (count($this->data['product']) < $limit)) $habis = 'ya';
        //$habis = ! $this->data['product'] ? 'ya' : 'tidak';

        $ret = ['q' => $q, 'habis' => $habis, 'product' => $this->load->view('frontend/product/product_scroll', $this->data, TRUE)];
        echo json_encode($ret);
    }
}
