<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Chat extends Admin_Controller{

    public function __construct()
    {
        parent::__construct();
        if($this->data['users_groups']->id == 3)
        {
            redirect('dashboard');
        }
    }

    public function index()
    {
        redirect('chat/vendor_list');
    }

    public function find_room($vendor_id)
    {

        $data = [
            'user_id' => $this->data['users']->id,
            'vendor_id' => $vendor_id
        ];

        $this->load->model('Room_chat_model');
        $room_chat_id = NULL;
        $is_room_exists = $this->Room_chat_model->getOneBy($data);

        // room ada
        if ($is_room_exists !== FALSE)
        {
            $room_chat_id = $is_room_exists->id;
        }
        else
        {
            $room_chat_id = $this->Room_chat_model->insert($data);
        }

        redirect('chat/chat_room/' . $room_chat_id);
    }

    public function vendor_list()
    {
        $this->load->model('Order_model');

        $this->data['list_vendor'] = $this->Order_model->get_all_vendor_for_chat($this->data['users']->id);
        $not_in = [];

        foreach($this->data['list_vendor'] as $k => $v)
        {
            $not_in[] = $v->vendor_id;
        }
        $this->load->model('Vendor_model');
        $this->data['list_vendor_tambahan'] = $this->Vendor_model->get_vendor_chat_not_from_PO($not_in, $this->data['users']->id);
        //die(var_dump($this->db->last_query()));

        $this->data['content'] = 'frontend/chat/vendor_list';
        $this->load->view('frontend/layouts/page',$this->data);
    }

    public function get_chat_history()
    {
        $this->load->model('Room_chat_model');
        $room_chat_id = $this->input->post('room_chat_id');
        $last_id = $this->input->post('last_id');

        $history_chat = $this->Room_chat_model->get_last_chat($room_chat_id, $last_id);
        $ret = [];
        foreach ($history_chat as $k => $v)
        {
            $history_chat[$k]->created_at = tgl_indo($v->created_at,TRUE);
        }
        $ret['data'] = $history_chat;

        echo json_encode($ret);

    }

    public function chat_room($room_chat_id)
    {
        // validasi room_chat untuk user_tersebut
        $this->load->model('Room_chat_model');
        $cek_user_room = $this->Room_chat_model->getOneBy(['user_id' => $this->data['users']->id, 'id' => $room_chat_id]);
        if ($cek_user_room === FALSE)
        {
            redirect('chat/vendor_list');
        }

        $this->load->model('Vendor_model');
        $nama_vendor = $this->Vendor_model->findvendor(['id' => $cek_user_room->vendor_id]);
        $this->data['nama_vendor'] = $nama_vendor !== FALSE ? $nama_vendor->name : '';
        $this->data['history_chat'] = $this->Room_chat_model->get_last_chat($room_chat_id);
        $this->data['room_chat_id'] = $room_chat_id;
        $this->data['content'] = 'frontend/chat/chat_room_v';
        $this->load->view('frontend/layouts/page',$this->data);
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
		        redirect('chat/chat_room/'.$room_chat);
				echo "<script>alert('gagal mengupload file');</script>";
        }
		else
		{
			$data['chat_contenct'] = $this->upload->data("file_name");
			$data['room_chat_id'] = $this->input->post('room_chat_id2');
			$data['sender'] = 'user';
			$data['tipe'] = 1;
			$this->db->insert('room_chat_detail',$data);
			redirect('chat/chat_room/'.$room_chat);
		}
        
    }
    
}
