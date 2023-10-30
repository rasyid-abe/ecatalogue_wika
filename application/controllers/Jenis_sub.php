<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Jenis_sub extends Admin_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('jenis_model');
    }

    public function index()
    {
        $this->load->helper('url');
        if($this->data['is_can_read']){
            $this->data['judul'] = 'Sub Kategori';
            $this->data['content']  = 'admin/jenis/list2_v';
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
            'parent_id' => $this->input->post('parent'),
            'level' => 2,
            'created_by' => $this->data['users']->id,
        );
        if ($this->jenis_model->insert($data))
        {
            $this->session->set_flashdata('message', "Sub Kategori Baru Berhasil Disimpan");
            redirect("jenis_sub");
        }
        else
        {
            $this->session->set_flashdata('message_error',"Sub Kategori  Baru Gagal Disimpan");
            redirect("jenis_sub");
        }
    }else{
        $this->data['content'] = 'admin/jenis/create2_v';
        $this->data['jenis'] = $this->jenis_model->get_dropdown(['is_deleted' => 0, 'level' => 1]);
        $this->load->view('admin/layouts/page',$this->data);
    }
  }
  public function get_kategori()
    {
        $data = $this->db->get_where('jenis', ['level' => 1, 'is_deleted' => 0])->result_array();
        echo json_encode($data);
    }

  public function edit($id)
  {
    $this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');
 
    if ($this->form_validation->run() === TRUE)
    {
        $data = array(
            'name' => $this->input->post('name'),
            'parent_id' => $this->input->post('parent'),
            'updated_by' => $this->data['users']->id,
        );

        $update = $this->jenis_model->update($data,array("jenis.id"=>$id));
        if ($update)
        {
            $this->session->set_flashdata('message', "Sub Kategori Berhasil Diubah");
            redirect("jenis_sub","refresh");
        }else{
            $this->session->set_flashdata('message_error', "Sub Kategori Gagal Diubah");
            redirect("jenis_sub","refresh");
        }
    }
    else
    {
        if(!empty($_POST)){
            $id = $this->input->post('id');
            $this->session->set_flashdata('message_error',validation_errors());
            return redirect("jenis_sub/edit/".$id);
        }else{
            $this->data['id']= $this->uri->segment(3);
            $jenis = $this->jenis_model->getOneBy(array("jenis.id"=>$this->data['id']));
            $this->data['jenis'] = $this->jenis_model->get_dropdown(['is_deleted' => 0, 'level' => 1]);
            $this->data['name'] =   (!empty($jenis))?$jenis->name:"";
            $this->data['parent'] =   (!empty($jenis))?$jenis->parent_id:"";
          
            $this->data['content'] = 'admin/jenis/edit2_v';
            $this->load->view('admin/layouts/page',$this->data);
        }
    }
  }

    public function dataList()
    {
        $columns = array(
            0 =>'jenis.id',
            1 =>'j2.name',
            2 =>'jenis.name',
            3=> '',
        );


        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $where['jenis.is_deleted !='] = 2;
        $where['jenis.level'] = 2;
        $limit = 0;
        $start = 0;
        $totalData = $this->jenis_model->getCountAllBy2($limit,$start,$search,$order,$dir,$where);


        if(!empty($this->input->post('search')['value'])){
            $search_value = $this->input->post('search')['value'];
            $search = array(
                "jenis.name"=>$search_value,
                "j2.name"=>$search_value,
            );
            $totalFiltered = $this->jenis_model->getCountAllBy2($limit,$start,$search,$order,$dir,$where);
        }else{
            $totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $datas = $this->jenis_model->getAllBy2($limit,$start,$search,$order,$dir,$where);

        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {

                $edit_url = "";
                $delete_url = "";
                $delete_permanent = "";

                if($this->data['is_can_edit'] && $data->is_deleted == 0){
                    $edit_url =  "<a href='".base_url()."jenis_sub/edit/".$data->id."' data-id='".$data->id."' style='color: white;'><div class='btn btn-sm btn-primary btn-blue btn-editview'>Ubah</div></a>";
                }
                if($this->data['is_can_delete']){
                    if($data->is_deleted == 0){
                        $delete_url = "<a href='#'
                            data-id='".$data->id."' data-isdeleted='".$data->is_deleted."' class='btn btn-sm btn-danger white delete' url='".base_url()."jenis_sub/destroy/".$data->id."/".$data->is_deleted."' >Non Aktifkan
                            </a>";
                    }else{
                        $delete_url = "<a href='#'
                            data-id='".$data->id."' data-isdeleted='".$data->is_deleted."' class='btn btn-sm btn-success white delete'
                             url='".base_url()."jenis_sub/destroy/".$data->id."/".$data->is_deleted."'>Aktifkan
                            </a>";
                        $delete_permanent = "<a  href='#' url='".base_url()."jenis_sub/destroy_permanent/".$data->id."' class='btn btn-sm btn-danger white delete'><i class='fa fa-trash-o'></i> Hapus</a>";
                    }
                }

                $ketMargis = [];

                if($data->is_margis == 1) $ketMargis[] = 'Matgis';
                if($data->is_non_margis == 1) $ketMargis[] = 'Non Matgis';

                $nestedData['id'] = $start+$key+1;
                $nestedData['katagori'] = $data->jenis_name2;
                $nestedData['name'] = $data->name;
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
            $update = $this->jenis_model->update($data,array("id"=>$id));

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
            $update = $this->jenis_model->update($data,array("id"=>$id));

            $response_data['data'] = $data;
            $response_data['status'] = true;
        }else{
            $response_data['msg'] = "ID Harus Diisi";
        }

        echo json_encode($response_data);
    }
}
