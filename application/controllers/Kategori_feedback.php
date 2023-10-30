<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Kategori_feedback extends Admin_Controller {

    protected $cont = 'kategori_feedback';

 	public function __construct()
	{
		parent::__construct();
        $this->load->model('Kategori_feedback_model', 'model');
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
            0 =>'id',
      		1 =>'name',
        );
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  		$search = array();
        $where = array();

  		$limit = 0;
  		$start = 0;

        $totalData = $this->model->getCountAllBy($limit,$start,$search,$order,$dir);

        $searchColumn = $this->input->post('columns');
    $isSearchColumn = false;

    	if(!empty($this->input->post('search')['value'])){
            $search_value = $this->input->post('search')['value'];
            $search = array(
                "kategori_feedback.name"=>$search_value,
            );
            $totalFiltered = $this->model->getCountAllBy($limit,$start,$search,$order,$dir,$where);
        }else{
            $totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
		$datas = $this->model->getAllBy($limit,$start,$search,$order,$dir);
        //die(print_r($datas));
        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {
                $edit_url = "";
     			$delete_url = "";

            	if($this->data['is_can_edit'] && $data->is_deleted == 0)
                {
            		$edit_url = "<a href='".base_url().$this->cont."/edit/".$data->id."' class='btn btn-xs btn-info'><i class='fa fa-pencil'></i> Ubah</a>";
            	}

            	if($this->data['is_can_delete'])
                {
	            	if($data->is_deleted == 0)
                    {
	        			$delete_url = "<a href='javascript:;'
	        				url='".base_url().$this->cont."/destroy/".$data->id."/".$data->is_deleted."'
	        				class='btn btn-xs btn-danger delete' >NonAktifkan
	        				</a>";
	        		}
                    else
                    {
	        			$delete_url = "<a href='javascript:;'
	        				url='".base_url().$this->cont."/destroy/".$data->id."/".$data->is_deleted."'
	        				class='btn btn-xs btn-danger delete'
	        				 >Aktifkan
	        				</a>";
	        		}
        		}

                $nestedData['id'] = $start+$key+1;
                $nestedData['name'] = $data->name;
                $nestedData['action'] = $edit_url . " ". $delete_url;
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

    public function create()
    {
        $this->form_validation->set_rules('name',"Kategori feedback", 'trim|required');

		if ($this->form_validation->run() === TRUE)
		{
			$data = array(
                'name'          => $this->input->post('name'),
                'created_by' => $this->data['users']->id,
			);

			$insert = $this->model->insert($data);

			if ($insert === FALSE)
			{
                $this->session->set_flashdata('message_error',"Kategori feedback gagal disimpan");
                redirect($this->cont);
			}
			else
			{
                $this->session->set_flashdata('message', "Kategori feedback  berhasil disimpan");
                redirect($this->cont);
			}
		}

		$this->data['content'] = 'admin/'.$this->cont.'/create_v';
		$this->load->view('admin/layouts/page',$this->data);
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('name',"Kategori feedback", 'trim|required');

		if ($this->form_validation->run() === TRUE)
		{
            $data = array(
                'name'          => $this->input->post('name'),
                'updated_by' => $this->data['users']->id,
			);

			$id = $this->input->post('id');

			$update = $this->model->update($data, ['id' => $id]);


			if ($update === FALSE)
			{
                $this->session->set_flashdata('message_error', "Kategori feedback gagal diubah");
                redirect($this->cont,"refresh");
			}else{
                $this->session->set_flashdata('message', "Kategori feedback berhasil diubah");
                redirect($this->cont,"refresh");
			}
		}


        $this->data['id']= $id;
        $data = $this->model->getOneBy(array("id"=>$this->data['id']));
        if($data === FALSE)
        {
            redirect($this->cont);
        }

        $this->data['data'] = $data;

        $this->data['content'] = 'admin/'.$this->cont.'/edit_v';
        $this->load->view('admin/layouts/page',$this->data);

    }

    public function destroy()
    {
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
			$update = $this->model->update($data,array("id"=>$id));

        	$response_data['data'] = $data;
         	$response_data['status'] = true;
 		}else{
 		 	$response_data['msg'] = "ID Harus Diisi";
 		}

        echo json_encode($response_data);
    }

    public function get_list_kategori_feedback()
    {
        $ret = [];
        $ret['data'] = $this->model->getAllById(['is_deleted' => 0]);
        echo json_encode($ret);
    }

    

}
