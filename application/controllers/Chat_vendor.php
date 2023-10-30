<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Chat_vendor extends Admin_Controller {

    protected $cont = 'chat_vendor';

 	public function __construct()
	{
		parent::__construct();
        $this->load->model('Room_chat_model', 'model');
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

    public function chat($room_chat_id)
    {
        $this->load->model('Room_chat_model');
        $cek_user_room = $this->Room_chat_model->getOneBy(['vendor_id' => $this->data['users']->vendor_id, 'id' => $room_chat_id]);
        if ($cek_user_room === FALSE)
        {
            $this->session->set_flashdata('message_error','Anda tidak punya akses ke chat tersebut');
            redirect($this->cont);
        }

        $this->load->model('User_model');
        $users = $this->User_model->getDepartmentUser($cek_user_room->user_id);
        $this->data['nama_user'] = $users !== FALSE ? ($users->user_name . "(" . $users->department_name . ")") : '' ;
        $this->data['history_chat'] = $this->Room_chat_model->get_last_chat($room_chat_id);
        $this->data['room_chat_id'] = $room_chat_id;
        $this->data['content'] = 'admin/'.$this->cont.'/chat_v';
        $this->load->view('admin/layouts/page',$this->data);
    }

    public function dataList()
    {
        $columns = array(
            0 =>'a.id',
      		1 =>'b.first_name',
        );
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  		$search = array();
        $where = [];
        $where['a.vendor_id'] = $this->data['users']->vendor_id;
  		$limit = 0;
  		$start = 0;

        $totalData = $this->model->getCountAllBy($limit,$start,$search,$order,$dir,$where);

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;


    	if($isSearchColumn){
			$totalFiltered = $this->model->getCountAllBy($limit,$start,$search,$order,$dir,$where);
        }else{
        	$totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
		$datas = $this->model->getAllBy($limit,$start,$search,$order,$dir,$where);
        //die($this->db->last_query());
        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {

                $nestedData['id'] = $start+$key+1;
                $nestedData['user_name'] = $data->user_name;

                if($data->dept_id != '')
                {
                    $nestedData['user_name'] .= " (".$data->dept_name.")";
                }

                $nestedData['action'] = '<a href="' . base_url() . $this->cont . '/find_room/' . $data->user_id . '" class="btn btn-info btn-xs">
                    <i class="fa fa-comments"></i> Chat
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

    public function find_room($user_id)
    {
        $data = [
            'user_id' => $user_id,
            'vendor_id' => $this->data['users']->vendor_id
        ];

        $this->load->model('Room_chat_model');
        $room_chat_id = NULL;
        $is_room_exists = $this->Room_chat_model->getOneBy($data);

        // room ada
        if ($is_room_exists !== FALSE)
        {
            $room_chat_id = $is_room_exists->id;
            redirect($this->cont . '/chat/' . $room_chat_id);
        }
        else
        {
            $this->session->set_flashdata('message_error','Anda tidak punya akses ke chat tersebut');
            redirect($this->cont);
        }

    }

    public function insert_chat()
    {
        $data = $this->input->post();
        $insert = $this->db->insert('room_chat_detail', $data);
        $ret['status'] = $insert;

        echo json_encode($ret);
    }

    public function import_file()
    {
        $room_chat = $this->input->post('room_chat_id2');
        $config['upload_path']          = './pdf/chat';
		$config['allowed_types']        = 'pdf';
		$config['max_size']             = 5000;
		$config['encrypt_name']			= false;
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('import_file'))
		{
		        redirect('chat_vendor/chat/'.$room_chat);
				echo "<script>alert('gagal mengupload file');</script>";
        }
		else
		{
			$data['chat_contenct'] = $this->upload->data("file_name");
			$data['room_chat_id'] = $this->input->post('room_chat_id2');
			$data['sender'] = 'vendor';
			$data['tipe'] = 1;
			$this->db->insert('room_chat_detail',$data);
			redirect('chat_vendor/chat/'.$room_chat);
		}
        
    }



}
