<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Cart extends Admin_Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
    }

    public function update_cart()
    {
        $id_session = $this->input->post('id_session');
        $quantity = $this->input->post('quantity');

        if($product_cart = $this->session->userdata('cart_session'))
        {
            foreach($product_cart as $k => $v)
            {
                if($v['id_session'] == $id_session)
                {
                    $total_include = 0;
                    if($v['includes'])
                    {
                        foreach($v['includes'] as $v2)
                        {
                            $total_include += $v2->price;
                        }
                    }
                    $product_cart[$k]['quantity'] = $quantity;
                    $product_cart[$k]["product_total_price"] = ($v['product_price'] * $quantity * $v['product_weight']) + ($quantity * $total_include);
                }
            }

            $this->session->set_userdata('cart_session', $product_cart);
        }

        echo json_encode($product_cart);
    }

    public function add() {
        $product_cart = array();
        $quantity = $this->input->post('quantity');
        $product_id = $this->input->post('product_id');
        $product_contract = $this->input->post('product_contract');
        $product_detail = json_decode($this->input->post('product_detail'));

        $product_name = $product_detail->name;
        $product_price = $product_detail->product_price;
        $product_uom_name = $product_detail->uom_name;
        $product_vendor_name = $product_detail->vendor_name;
        $product_uom_id = $product_detail->uom_id;
        $product_weight = $product_detail->default_weight;
        $image = $product_detail->image;

        $product = array(
            "is_rev"=>0,
            "order_no"=>'',
            "no_surat"=>'',
            "quantity"=>$quantity,
            "product_id"=>$product_id,
            "product_contract"=>$product_contract,
            "product_name"=>$product_name,
            "product_uom_name"=>$product_uom_name,
            "product_price"=>$product_price,
            "product_weight"=>$product_weight,
            "product_total_price"=> ($product_price * $quantity * $product_weight) ,
            "product_vendor_name"=>$product_vendor_name,
            "product_uom_id"=>$product_uom_id,
            "payment_method_full" => $product_detail->payment_method_full,
            "payment_method_id" => $product_detail->payment_method_id,
            "include_price" => $product_detail->include_price,
            "vendor_id" => $product_detail->vendor_id,
            "vendor_name" => $product_detail->vendor_name,
            "full_product_name" => $product_detail->full_name,
            "id_session"=>$product_id."_".time().rand(10000,99999),
            'includes' => 0,
            'location_id' => $this->input->post('location_id'),
            'location_name' => $this->input->post('location_name'),
            'image' => $image,
            'is_matgis' => $product_detail->is_matgis,
            'category_id' => $product_detail->category_id,
            'for_order' => $product_detail->vendor_id . '_' . $this->input->post('location_id') . '_' . $product_detail->category_id,
        );

        if($this->session->userdata('cart_session')){
            $product_cart = $this->session->userdata('cart_session');
            array_push($product_cart, $product);
            $this->session->set_userdata('cart_session',$product_cart);

        }else{
            array_push($product_cart, $product);
            $this->session->set_userdata('cart_session',$product_cart);
            $product_cart = $this->session->userdata('cart_session');
        }

        $return = array(
            "data"=>$product_cart,
            "messages"=>"Item Berhasil Ditambahkan",
            "status"=>TRUE,
        );

        echo json_encode($return);

    }


    public function update() {


        $product_id = $this->input->post('product_id');
        $qty = $this->input->post('qty');

        $count_arr = count($product_id);


        for($i=0;$i<$count_arr;$i++){

            $product_cart = array();

            if($this->session->userdata('cart_session')){

                $cart_session = $this->session->userdata('cart_session');

                    foreach($cart_session as $id=>$val){
                        $product_cart[$id] = $val;
                    }

            }

            if($qty[$i] == 0){
                $qty_add = 1;
            } else {
                $qty_add = $qty[$i];
            }


            $product_cart[$product_id[$i]] = $qty_add;


            $this->session->set_userdata('cart_session',$product_cart);




        }

        $cart_session = $this->session->userdata('cart_session');

        $arr = array();
        $arr['update_cart'] = array_sum($cart_session);
        echo json_encode($arr);


    }

    public function delete() {

        $return = array(
            "data"=>array(),
            "messages"=>"",
            "status"=>TRUE,
        );
        $product_cart = array();
        $id_session = $this->input->post('id_session');
        $return['data'] = $id_session;
        $product_total_price = 0;
        if($this->session->userdata('cart_session')){

            $product_cart = $this->session->userdata('cart_session');

            foreach($product_cart as $id=>$val){
                if($val['id_session'] == $id_session){
                    unset($product_cart[$id]);
                }else{
                    $product_total_price += $val['product_total_price'];
                }
            }

            $this->session->set_userdata('cart_session',$product_cart);
            $return["messages"] = "Delete Item Success";
            $data =array(
                'total_price' =>$product_total_price
            );
            $return["data"] = $data;

        }else{
            $data =array(
                'total_price' =>$product_total_price
            );
            $return["messages"] = "Keranjang Kosong";
            $return["status"] = FALSE;
            $return["data"] = $data;
        }
        // print_r($product_cart);
        echo json_encode($return);

    }

    public function empty_cart() {

        $this->session->unset_userdata('cart_session');

        $return = array(
            "data"=>array(),
            "messages"=>"Keranjang Kosong",
            "status"=>TRUE,
        );
        echo json_encode($return);


    }
}
