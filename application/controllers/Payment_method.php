<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Payment_method extends Admin_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('payment_method_model');
        $this->load->model('enum_payment_method_model');
    }

    public function index()
    {
        $this->load->helper('url');
        if($this->data['is_can_read']){
            $this->data['content']  = 'admin/payment_method/list_v';
        }else{
            redirect('restrict');
        }
        $this->load->view('admin/layouts/page',$this->data);
    }

  public function create()
  {
    $this->form_validation->set_rules('day',"Jumlah Hari Harus Diisi", 'trim|required');

        if ($this->form_validation->run() === TRUE)
        {
            $data = array(
                'day' => $this->input->post('day'),
                'description' => $this->input->post('description'),
                'enum_payment_method_id' => $this->input->post('enum_payment_method_id'),
                'created_by' => $this->data['users']->id,

            );
            if ($this->payment_method_model->insert($data))
            {
                $this->session->set_flashdata('message', "Metode Pembayaran Baru Berhasil Disimpan");
                redirect("payment_method");
            }
            else
            {
                $this->session->set_flashdata('message_error',"Metode Pembayaran Baru Gagal Disimpan");
                redirect("payment_method");
            }
        }else{
            $this->data['enum_payment'] = $this->enum_payment_method_model->getAllById();
            $this->data['content'] = 'admin/payment_method/create_v';
            $this->load->view('admin/layouts/page',$this->data);
        }
  }

  public function edit($id)
  {
    $this->form_validation->set_rules('day', "Jumlah Hari Harus Diisi", 'trim|required');

    if ($this->form_validation->run() === TRUE)
    {
        $data = array(
            'day' => $this->input->post('day'),
            'description' => $this->input->post('description'),
            'enum_payment_method_id' => $this->input->post('enum_payment_method_id'),
            'updated_by' => $this->data['users']->id,
        );
        $update = $this->payment_method_model->update($data,array("payment_method.id"=>$id));
        if ($update)
        {
            $this->session->set_flashdata('message', "Metode Pembayaran Berhasil Diubah");
            redirect("payment_method","refresh");
        }else{
            $this->session->set_flashdata('message_error', "Metode Pembayaran Gagal Diubah");
            redirect("payment_method","refresh");
        }
    }
    else
    {
        if(!empty($_POST)){
            $id = $this->input->post('id');
            $this->session->set_flashdata('message_error',validation_errors());
            return redirect("payment_method/edit/".$id);
        }else{
            $this->data['enum_payment'] = $this->enum_payment_method_model->getAllById();
            $this->data['id']= $this->uri->segment(3);
            $payment_method = $this->payment_method_model->getOneBy(array("payment_method.id"=>$this->data['id']));
            $this->data['day'] =   (!empty($payment_method))?$payment_method->day:"";
            $this->data['description'] =   (!empty($payment_method))?$payment_method->description:"";
            $this->data['enum_payment_id'] =   (!empty($payment_method))?$payment_method->enum_payment_method_id:"";

            $this->data['content'] = 'admin/payment_method/edit_v';
            $this->load->view('admin/layouts/page',$this->data);
        }
    }
  }

    public function dataList()
    {
        $columns = array(
            0 =>'payment_method.id',
            1 =>'payment_method.day',
            2=> 'payment_method.description',
            3=> '',
        );


        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $where['payment_method.is_deleted !='] = 2;
        $limit = 0;
        $start = 0;
        $totalData = $this->payment_method_model->getCountAllBy($limit,$start,$search,$order,$dir,$where);


        if(!empty($this->input->post('search')['value'])){
            $search_value = $this->input->post('search')['value'];
            $search = array(
                "payment_method.day"=>$search_value,
                "payment_method.description"=>$search_value,
            );
            $totalFiltered = $this->payment_method_model->getCountAllBy($limit,$start,$search,$order,$dir,$where);
        }else{
            $totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $datas = $this->payment_method_model->getAllBy($limit,$start,$search,$order,$dir,$where);

        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {

                $edit_url = "";
                $delete_url = "";
                $delete_permanent ="";

                if($this->data['is_can_edit'] && $data->is_deleted == 0){
                    $edit_url =  "<a href='".base_url()."payment_method/edit/".$data->id."' data-id='".$data->id."' style='color: white;'><div class='btn btn-sm btn-primary btn-blue btn-editview '>Ubah</div></a>";
                }
                if($this->data['is_can_delete']){
                    if($data->is_deleted == 0){
                        $delete_url = "<a href='#'
                            data-id='".$data->id."' data-isdeleted='".$data->is_deleted."' class='btn btn-sm btn-danger white delete' url='".base_url()."payment_method/destroy/".$data->id."/".$data->is_deleted."' >Non Aktifkan
                            </a>";
                    }else{
                        $delete_url = "<a href='#'
                            data-id='".$data->id."' data-isdeleted='".$data->is_deleted."' class='btn btn-sm btn-success white delete'
                             url='".base_url()."payment_method/destroy/".$data->id."/".$data->is_deleted."'>Aktifkan
                            </a>";
                        $delete_permanent = "<a  href='#' url='".base_url()."payment_method/destroy_permanent/".$data->id."' class='btn btn-sm btn-danger white delete'><i class='fa fa-trash-o'></i> Hapus</a>";
                    }
                }
                $nestedData['id'] = $start+$key+1;
                $nestedData['day'] = $data->full_name;
                $nestedData['description'] = substr(strip_tags($data->description),0,50);
                if($data->is_deleted==0){
                    $nestedData['status']       = "Active";
                }else{
                    $nestedData['status']       = "Inactive";
                }
                $nestedData['action']           = $edit_url." ".$delete_url." ".$delete_permanent;
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
    public function destroy(){
        $response_data = array();
        $response_data['status'] = false;
        $response_data['msg'] = "";
        $response_data['data'] = array();

        $id =$this->uri->segment(3);
        $is_deleted = $this->uri->segment(4);
        if(!empty($id)){
            $data = array(
                'is_deleted' => ($is_deleted == 1)?0:1,
                'updated_by' => $this->data['users']->id,
            );
            $update = $this->payment_method_model->update($data,array("id"=>$id));

            $response_data['data'] = $data;
            $response_data['status'] = true;
        }else{
            $response_data['msg'] = "ID Harus Diisi";
        }

        echo json_encode($response_data);
    }

    public function destroy_permanent(){
        $response_data = array();
        $response_data['status'] = false;
        $response_data['msg'] = "";
        $response_data['data'] = array();

        $id =$this->uri->segment(3);
        $is_deleted = $this->uri->segment(4);
        if(!empty($id)){
            $data = array(
                'is_deleted'    => 2,
                'deleted_by'    => $this->data['users']->id,
                'deleted_time'  => $this->data['now_datetime']
            );
            $update = $this->payment_method_model->update($data,array("id"=>$id));

            $response_data['data'] = $data;
            $response_data['status'] = true;
        }else{
            $response_data['msg'] = "ID Harus Diisi";
        }

        echo json_encode($response_data);
    }
}
