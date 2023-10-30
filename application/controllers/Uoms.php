<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Uoms extends Admin_Controller {public function __construct()
    {
        parent::__construct(); 
        $this->load->model('uoms_model');
    }

    public function index()
    {
        $this->load->helper('url');
        if($this->data['is_can_read']){
            $this->data['content']  = 'admin/uoms/list_v';
        }else{
            redirect('restrict'); 
        }
        $this->load->view('admin/layouts/page',$this->data);
    }

  public function create()
  {
    $this->form_validation->set_rules('name',"Nama Harus Diisi", 'trim|required'); 
         
        if ($this->form_validation->run() === TRUE)
        { 
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description')
            ); 
            if ($this->uoms_model->insert($data))
            { 
                $this->session->set_flashdata('message', "Satuan Baru Berhasil Disimpan");
                redirect("uoms");
            }
            else
            {
                $this->session->set_flashdata('message_error',"Satuan Baru Gagal Disimpan");
                redirect("uoms");
            }
        }else{    
            $this->data['content'] = 'admin/uoms/create_v'; 
            $this->load->view('admin/layouts/page',$this->data); 
        }
  }

  public function edit($id)
  {
    $this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');

    if ($this->form_validation->run() === TRUE)
    {
        $data = array(
            'name' => $this->input->post('name'), 
            'description' => $this->input->post('description'),
        );
        $update = $this->uoms_model->update($data,array("uoms.id"=>$id));
        if ($update)
        { 
            $this->session->set_flashdata('message', "Satuan Berhasil Diubah");
            redirect("uoms","refresh");
        }else{
            $this->session->set_flashdata('message_error', "Satuan Gagal Diubah");
            redirect("uoms","refresh");
        }
    } 
    else
    {
        if(!empty($_POST)){ 
            $id = $this->input->post('id'); 
            $this->session->set_flashdata('message_error',validation_errors());
            return redirect("uoms/edit/".$id);  
        }else{
            $this->data['id']= $this->uri->segment(3);
            $uoms = $this->uoms_model->getOneBy(array("uoms.id"=>$this->data['id']));  
            $this->data['name'] =   (!empty($uoms))?$uoms->name:"";
            $this->data['description'] =   (!empty($uoms))?$uoms->description:"";
            
            $this->data['content'] = 'admin/uoms/edit_v'; 
            $this->load->view('admin/layouts/page',$this->data); 
        }  
    }  
  }

    public function dataList()
    {
        $columns = array( 
            0 =>'uoms.id', 
            1 =>'uoms.name', 
            2=> 'uoms.description',
            3=> '',
        );

        
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $where['is_deleted !='] = 2;
        $limit = 0;
        $start = 0;
        $totalData = $this->uoms_model->getCountAllBy($limit,$start,$search,$order,$dir,$where); 
        

        if(!empty($this->input->post('search')['value'])){
            $search_value = $this->input->post('search')['value'];
            $search = array(
                "uoms.name"=>$search_value,
                "uoms.description"=>$search_value,
            ); 
            $totalFiltered = $this->uoms_model->getCountAllBy($limit,$start,$search,$order,$dir,$where); 
        }else{
            $totalFiltered = $totalData;
        } 
       
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $datas = $this->uoms_model->getAllBy($limit,$start,$search,$order,$dir,$where);
        
        $new_data = array();
        if(!empty($datas))
        { 
            foreach ($datas as $key=>$data)
            {  

                $edit_url = "";
                $delete_url = "";
                $delete_permanent ="";
            
                if($this->data['is_can_edit'] && $data->is_deleted == 0){
                    $edit_url =  "<a href='".base_url()."uoms/edit/".$data->id."' data-id='".$data->id."' style='color: white;'><div class='btn btn-sm btn-primary btn-blue btn-editview '>Ubah</div></a>";
                }  
                if($this->data['is_can_delete']){
                    if($data->is_deleted == 0){
                        $delete_url = "<a href='#' 
                            data-id='".$data->id."' data-isdeleted='".$data->is_deleted."' class='btn btn-sm btn-danger white delete' url='".base_url()."uoms/destroy/".$data->id."/".$data->is_deleted."' >Non Aktifkan
                            </a>";
                    }else{
                        $delete_url = "<a href='#'
                            data-id='".$data->id."' data-isdeleted='".$data->is_deleted."' class='btn btn-sm btn-success white delete' 
                             url='".base_url()."uoms/destroy/".$data->id."/".$data->is_deleted."'>Aktifkan
                            </a>";
                        $delete_permanent = "<a  href='#' url='".base_url()."uoms/destroy_permanent/".$data->id."' class='btn btn-sm btn-danger white delete'><i class='fa fa-trash-o'></i> Hapus</a>";
                    }  
                }
                $nestedData['id'] = $start+$key+1; 
                $nestedData['name'] = $data->name;
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
                'is_deleted' => ($is_deleted == 1)?0:1
            ); 
            $update = $this->uoms_model->update($data,array("id"=>$id));

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
            $update = $this->uoms_model->update($data,array("id"=>$id));

            $response_data['data'] = $data;
            $response_data['status'] = true;
        }else{
            $response_data['msg'] = "ID Harus Diisi";
        }

        echo json_encode($response_data);
    }
}
