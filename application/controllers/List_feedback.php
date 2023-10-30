<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class List_feedback extends Admin_Controller {

    protected $cont = 'list_feedback';

 	public function __construct()
	{
		parent::__construct();
        $this->load->model('List_feedback_model', 'model');
        $this->data['cont'] = $this->cont;
	}

    public function index()
    {
        if($this->data['is_can_read']){
            if($this->ion_auth->in_group(3))
            {
                redirect($this->cont . "/create");
            }
			$this->data['content'] = 'admin/'.$this->cont.'/list_v';
		}else{
			redirect('restrict');
		}

		$this->load->view('admin/layouts/page',$this->data);
    }

    public function dataList()
    {
        $columns = array(
            0 =>'a.id',
      		1 =>'e.name',
            2 =>'c.first_name',
            3 =>'b.name',
            4 =>'a.created_at',
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
                // "a.name"=>$search_value,
                "b.name"=>$search_value,
                "c.first_name"=>$search_value,
                "e.name"=>$search_value,
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

                $nestedData['id'] = $start+$key+1;
                $nestedData['kategori_name'] = $data->kategori_name;
                $nestedData['type_feedback'] = $data->type_feedback;
                $nestedData['isi_feedback'] = $data->isi_feedback;
                $nestedData['nama_user'] = $data->nama_user;
                $nestedData['role_name'] = $data->role_name;
                $nestedData['created_at'] = tgl_indo($data->created_at, TRUE);
                $nestedData['action'] = '<a href="javascript:;" class="btn btn-info btn-xs detail-feedback" data-isi-feedback="' . $data->isi_feedback . '">
                    <i class="fa fa-bars"></i> Detail Feedback
                </a>';

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
        $this->form_validation->set_rules('kategori_feedback_id',"Kategori feedback", 'trim|required');

		if ($this->form_validation->run() === TRUE)
		{
			$data = array(
                'kategori_feedback_id'          => $this->input->post('kategori_feedback_id'),
                'isi_feedback'          => $this->input->post('isi_feedback'),
                'type_feedback'          => $this->input->post('type_feedback'),
                'created_by' => $this->data['users']->id,
			);

			$insert = $this->model->insert($data);

			if ($insert === FALSE)
			{
                $this->session->set_flashdata('message_error',"Feedback gagal disimpan");
                redirect($this->cont);
			}
			else
			{
                $this->session->set_flashdata('message', "Feedback  berhasil disimpan");
                redirect($this->cont);
			}
		}

        $this->data['type_feedback'] = $this->ion_auth->in_group(3) ? 'vendor' : 'user';
        $this->load->model('Kategori_feedback_model');
        $this->data['kategori_feedback'] = $this->Kategori_feedback_model->get_dropdown(['is_deleted' => 0]);
		$this->data['content'] = 'admin/'.$this->cont.'/create_v';
		$this->load->view('admin/layouts/page',$this->data);
    }

    public function edit($id)
    {

        redirect($this->cont);

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
                $this->session->set_flashdata('message_error', "Feedback gagal diubah");
                redirect($this->cont,"refresh");
			}else{
                $this->session->set_flashdata('message', "Feedback berhasil diubah");
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

    public function create_feedback()
    {
        $ret = [];

        $data = array(
            'kategori_feedback_id'          => $this->input->post('kategori_feedback_id'),
            'isi_feedback'          => $this->input->post('isi_feedback'),
            'type_feedback'          => $this->input->post('type_feedback'),
            'created_by' => $this->data['users']->id,
        );

        $insert = $this->model->insert($data);

        if ($insert === FALSE)
        {
            $ret['status'] = FALSE;
        }
        else
        {
            $ret['status'] = TRUE;
        }

        echo json_encode($ret);
    }

}
