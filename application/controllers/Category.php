<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Category extends Admin_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('category_model');
    }

    public function index()
    {
        $this->load->helper('url');
        if($this->data['is_can_read']){
            $this->data['judul'] = 'Jenis';
            $this->data['content']  = 'admin/category/list_v';
        }else{
            redirect('restrict');
        }
        $this->load->view('admin/layouts/page',$this->data);
    }

  public function create()
  {
    $this->form_validation->set_rules('name',"Nama Harus Diisi", 'trim|required');
    $this->form_validation->set_rules('category_new_id',"Kategori", 'trim|required');

        if ($this->form_validation->run() === TRUE)
        {
            $data = array(
                'name' => $this->input->post('name'),
                'category_new_id' => $this->input->post('category_new_id'),
                'description' => $this->input->post('description'),
                'is_margis' => $this->input->post('is_margis') == 'matgis' ? 1 : 0,
                'is_non_margis' => $this->input->post('is_margis') == 'non_matgis' ? 1 : 0,
                'code' => $this->input->post('code'),
                'created_by' => $this->data['users']->id,
            );

            //die(var_dump($_FILES));
            $config['upload_path']          = './image_upload/category/';
            $config['allowed_types']        = '*';
            $random = rand(1000,9999);
            if (is_uploaded_file($_FILES['icon_file']['tmp_name'])) {
                // echo "string";
                $filename = pathinfo($_FILES['icon_file']["name"]);
                $extension = $filename['extension'];
                $config['file_name'] = $random.time().".".$extension;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('icon_file')){
                    $data['icon'] = $config['file_name'];
                    $upload = 1;
                }else{
                    echo "string";
                    die($this->upload->display_errors());
                    $upload = 0;
                }

            }
            if ($this->category_model->insert($data))
            {
                $this->session->set_flashdata('message', "Kategori Baru Berhasil Disimpan");
                redirect("category");
            }
            else
            {
                $this->session->set_flashdata('message_error',"Kategori Baru Gagal Disimpan");
                redirect("category");
            }
        }else{
            $this->load->model('Category_new_model');
            $this->data['category_new'] = $this->Category_new_model->getAllById(['is_deleted' => 0]);
            $this->data['content'] = 'admin/category/create_v';
            $this->load->view('admin/layouts/page',$this->data);
        }
  }

  public function edit($id)
  {
    $this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');
    $this->form_validation->set_rules('category_new_id',"Kategori", 'trim|required');

    if ($this->form_validation->run() === TRUE)
    {
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'category_new_id' => $this->input->post('category_new_id'),
            'is_margis' => $this->input->post('is_margis') == 'matgis' ? 1 : 0,
            'is_non_margis' => $this->input->post('is_margis') == 'non_matgis' ? 1 : 0,
            'code' => $this->input->post('code'),
            'updated_by' => $this->data['users']->id,
        );

        if($_FILES['icon_file']["name"])
        {
            $gambar_lama = $this->category_model->getOneBy(['id'=>$id])->icon;
            $config['upload_path']          = './image_upload/category/';
            $config['allowed_types']        = '*';
            $random = rand(1000,9999);
            $filename = pathinfo($_FILES['icon_file']["name"]);
            $extension = $filename['extension'];
            $config['file_name'] = $random.time().".".$extension;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if($this->upload->do_upload('icon_file')){
                $data['icon'] = $config['file_name'];
                if(file_exists($config['upload_path'].$gambar_lama)) unlink($config['upload_path'].$gambar_lama);
                $upload = 1;
            }else{
                die($this->upload->display_errors());
                $upload = 0;
            }
        }


        $update = $this->category_model->update($data,array("category.id"=>$id));
        if ($update)
        {
            $this->session->set_flashdata('message', "Kategori Berhasil Diubah");
            redirect("category","refresh");
        }else{
            $this->session->set_flashdata('message_error', "Kategori Gagal Diubah");
            redirect("category","refresh");
        }
    }
    else
    {
        if(!empty($_POST)){
            $id = $this->input->post('id');
            $this->session->set_flashdata('message_error',validation_errors());
            return redirect("category/edit/".$id);
        }else{
            $this->data['id']= $this->uri->segment(3);
            $category = $this->category_model->getOneBy(array("category.id"=>$this->data['id']));
            $this->data['name'] =   (!empty($category))?$category->name:"";
            $this->data['description'] =   (!empty($category))?$category->description:"";
            $this->data['icon'] =   (!empty($category))?$category->icon:"";
            $this->data['is_margis'] =   (!empty($category))?$category->is_margis:"";
            $this->data['is_non_margis'] =   (!empty($category))?$category->is_non_margis:"";
            $this->data['code'] =   (!empty($category))?$category->code:"";
            $this->data['category_new_id'] =   (!empty($category))?$category->category_new_id:"";

            $this->load->model('Category_new_model');
            $this->data['category_new'] = $this->Category_new_model->getAllById(['is_deleted' => 0]);

            $this->data['content'] = 'admin/category/edit_v';
            $this->load->view('admin/layouts/page',$this->data);
        }
    }
  }

    public function dataList()
    {
        $columns = array(
            0 =>'category.id',
            1 =>'category.name',
            2=> 'category.description',
            3=> '',
        );


        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $where['is_deleted !='] = 2;
        $limit = 0;
        $start = 0;
        $totalData = $this->category_model->getCountAllBy($limit,$start,$search,$order,$dir,$where);


        if(!empty($this->input->post('search')['value'])){
            $search_value = $this->input->post('search')['value'];
            $search = array(
                "category.name"=>$search_value,
                "category.description"=>$search_value,
                "category.icon"=>$search_value,
            );
            $totalFiltered = $this->category_model->getCountAllBy($limit,$start,$search,$order,$dir,$where);
        }else{
            $totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $datas = $this->category_model->getAllBy($limit,$start,$search,$order,$dir,$where);

        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {

                $edit_url = "";
                $delete_url = "";
                $delete_permanent = "";

                if($this->data['is_can_edit'] && $data->is_deleted == 0){
                    $edit_url =  "<a href='".base_url()."category/edit/".$data->id."' data-id='".$data->id."' style='color: white;'><div class='btn btn-sm btn-primary btn-blue btn-editview'>Ubah</div></a>";
                }
                if($this->data['is_can_delete']){
                    if($data->is_deleted == 0){
                        $delete_url = "<a href='#'
                            data-id='".$data->id."' data-isdeleted='".$data->is_deleted."' class='btn btn-sm btn-danger white delete' url='".base_url()."category/destroy/".$data->id."/".$data->is_deleted."' >Non Aktifkan
                            </a>";
                    }else{
                        $delete_url = "<a href='#'
                            data-id='".$data->id."' data-isdeleted='".$data->is_deleted."' class='btn btn-sm btn-success white delete'
                             url='".base_url()."category/destroy/".$data->id."/".$data->is_deleted."'>Aktifkan
                            </a>";
                        $delete_permanent = "<a  href='#' url='".base_url()."category/destroy_permanent/".$data->id."' class='btn btn-sm btn-danger white delete'><i class='fa fa-trash-o'></i> Hapus</a>";
                    }
                }

                $ketMargis = [];

                if($data->is_margis == 1) $ketMargis[] = 'Matgis';
                if($data->is_non_margis == 1) $ketMargis[] = 'Non Matgis';

                $nestedData['id'] = $start+$key+1;
                $nestedData['name'] = $data->name;
                $nestedData['icon'] = $data->icon;
                $nestedData['margis'] = implode(' & ', $ketMargis);
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
            $update = $this->category_model->update($data,array("id"=>$id));

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
            $update = $this->category_model->update($data,array("id"=>$id));

            $response_data['data'] = $data;
            $response_data['status'] = true;
        }else{
            $response_data['msg'] = "ID Harus Diisi";
        }

        echo json_encode($response_data);
    }
}
