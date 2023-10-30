<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Specification extends Admin_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('specification_model');
    }

    public function index()
    {
        $this->load->helper('url');
        if($this->data['is_can_read']){
            $this->data['judul']  = 'Sumber Daya';
            $this->data['content']  = 'admin/specification/list_v';
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
                'description' => $this->input->post('description'),
                'category_id' => $this->input->post('category_id'),
                'code' => $this->input->post('code'),
                'created_by' => $this->data['users']->id,
            );
            if ($this->specification_model->insert($data))
            {
                $this->session->set_flashdata('message', "Spesifikasi Baru Berhasil Disimpan");
                redirect("specification");
            }
            else
            {
                $this->session->set_flashdata('message_error',"Spesifikasi Baru Gagal Disimpan");
                redirect("specification");
            }
        }else{
            $this->load->model('category_model');
            $this->data['category'] = $this->category_model->getAllById();
            $this->data['content'] = 'admin/specification/create_v';
            $this->load->view('admin/layouts/page',$this->data);
        }
  }

  public function edit($id)
  {
    $this->form_validation->set_rules('name', "Name Harus Diisi", 'trim|required');

    if ($this->form_validation->run() === TRUE)
    {
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'category_id' => $this->input->post('category_id'),
            'code' => $this->input->post('code'),
            'updated_by' => $this->data['users']->id,
        );
        $update = $this->specification_model->update($data,array("specification.id"=>$id));
        if ($update)
        {
            $this->session->set_flashdata('message', "Spesifikasi Berhasil Diubah");
            redirect("specification","refresh");
        }else{
            $this->session->set_flashdata('message_error', "Spesifikasi Gagal Diubah");
            redirect("specification","refresh");
        }
    }
    else
    {
        if(!empty($_POST)){
            $id = $this->input->post('id');
            $this->session->set_flashdata('message_error',validation_errors());
            return redirect("specification/edit/".$id);
        }else{
            $this->data['id']= $this->uri->segment(3);
            $specification = $this->specification_model->getOneBy(array("specification.id"=>$this->data['id']));
            $this->data['name'] =   (!empty($specification))?$specification->name:"";
            $this->data['description'] =   (!empty($specification))?$specification->description:"";
            $this->data['category_id'] =   (!empty($specification))?$specification->category_id:"";
            $this->data['code'] =   (!empty($specification))?$specification->code:"";

            $this->load->model('category_model');
            $this->data['category'] = $this->category_model->getAllById();
            $this->data['category_code'] = $this->category_model->getOneBy(['id' => $this->data['category_id']])->code;

            $this->data['content'] = 'admin/specification/edit_v';
            $this->load->view('admin/layouts/page',$this->data);
        }
    }
  }

    public function dataList()
    {
        $columns = array(
            0 =>'specification.id',
            1 =>'specification.name',
            2=> 'specification.description',
            3=> 'category.name',
        );


        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $where['specification.is_deleted !='] = 2;
        $limit = 0;
        $start = 0;
        $totalData = $this->specification_model->getCountAllBy($limit,$start,$search,$order,$dir,$where);


        if(!empty($this->input->post('search')['value'])){
            $search_value = $this->input->post('search')['value'];
            $search = array(
                "specification.name"=>$search_value,
                "specification.description"=>$search_value,
            );
            $totalFiltered = $this->specification_model->getCountAllBy($limit,$start,$search,$order,$dir,$where);
        }else{
            $totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $datas = $this->specification_model->getAllBy($limit,$start,$search,$order,$dir,$where);

        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {

                $edit_url = "";
                $delete_url = "";
                $delete_permanent = "";

                if($this->data['is_can_edit'] && $data->is_deleted == 0){
                    $edit_url =  "<a href='".base_url()."specification/edit/".$data->id."' data-id='".$data->id."' style='color: white;'><div class='btn btn-sm btn-primary btn-blue btn-editview '>Ubah</div></a>";
                }
                if($this->data['is_can_delete']){
                    if($data->is_deleted == 0){
                        $delete_url = "<a href='#'
                            data-id='".$data->id."' data-isdeleted='".$data->is_deleted."' class='btn btn-sm btn-danger white delete' url='".base_url()."specification/destroy/".$data->id."/".$data->is_deleted."' >Non Aktifkan
                            </a>";
                    }else{
                        $delete_url = "<a href='#'
                            data-id='".$data->id."' data-isdeleted='".$data->is_deleted."' class='btn btn-sm btn-success white delete'
                             url='".base_url()."specification/destroy/".$data->id."/".$data->is_deleted."'>Aktifkan
                            </a>";
                        $delete_permanent = "<a  href='#' url='".base_url()."specification/destroy_permanent/".$data->id."' class='btn btn-sm btn-danger white delete'><i class='fa fa-trash-o'></i> Hapus</a>";
                    }
                }
                $nestedData['id'] = $start+$key+1;
                $nestedData['name'] = $data->name;
                $nestedData['description'] = substr(strip_tags($data->description),0,50);
                $nestedData['category'] = $data->category_name;
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
            $update = $this->specification_model->update($data,array("id"=>$id));

            $response_data['data'] = $data;
            $response_data['status'] = true;
        }else{
            $response_data['msg'] = "ID Harus Diisi";
        }

        echo json_encode($response_data);
    }

    function getSpecificationByCatId()
    {
        $return = [];
        $category_id = $this->input->post('category_id');
        $where['category_id'] = $category_id;
        $return['data'] = $this->specification_model->getAllById($where);
        // /$return ['cek'] = $this->db->last_query();

        echo json_encode($return);
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
            $update = $this->specification_model->update($data,array("id"=>$id));

            $response_data['data'] = $data;
            $response_data['status'] = true;
        }else{
            $response_data['msg'] = "ID Harus Diisi";
        }

        echo json_encode($response_data);
    }
}
