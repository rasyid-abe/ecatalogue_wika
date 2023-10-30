<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Category_new extends Admin_Controller {

    protected $cont = 'category_new';

 	public function __construct()
	{
		parent::__construct();
        $this->load->model('Category_new_model', 'model');
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
      		1 =>'category_new.code',
            2 =>'category_new.name',
            3 =>'',
        );
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  		$search = array();
        $where['is_deleted !='] = 2;

  		$limit = 0;
  		$start = 0;

        $totalData = $this->model->getCountAllBy($limit,$start,$search,$order,$dir, $where);

        $searchColumn = $this->input->post('columns');
        // $isSearchColumn = false;


    	 if(!empty($this->input->post('search')['value'])){
            $search_value = $this->input->post('search')['value'];
            $search = array(
                "category_new.code"=>$search_value,
                "category_new.name"=>$search_value,
            );
            $totalFiltered = $this->model->getCountAllBy($limit,$start,$search,$order,$dir,$where);
        }else{
            $totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
		$datas = $this->model->getAllBy($limit,$start,$search,$order,$dir, $where);
        //die(print_r($datas));
        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {

            	$edit_url = "";
     			$delete_url = "";
                $delete_permanen = "";

            	if($this->data['is_can_edit'] && $data->is_deleted == 0)
                {
            		$edit_url = "<a href='".base_url().$this->cont."/edit/".$data->id."' class='btn btn-sm btn-info'><i class='fa fa-pencil'></i> Ubah</a>";
            	}

            	if($this->data['is_can_delete'])
                {
	            	if($data->is_deleted == 0)
                    {
	        			$delete_url = "<a href='javascript:;'
	        				url='".base_url().$this->cont."/destroy/".$data->id."/".$data->is_deleted."'
	        				class='btn btn-sm btn-danger delete' >NonAktifkan
	        				</a>";
	        		}
                    else
                    {
	        			$delete_url = "<a href='javascript:;'
	        				url='".base_url().$this->cont."/destroy/".$data->id."/".$data->is_deleted."'
	        				class='btn btn-sm btn-success delete'
	        				 >Aktifkan
	        				</a>";
                        $delete_permanen = "<a  href='#' url='".base_url().$this->cont."/destroy_permanent/".$data->id."' class='btn btn-sm btn-danger white delete'><i class='fa fa-trash-o'></i> Hapus</a>";
	        		}
        		}


                $nestedData['id'] = $start+$key+1;
                $nestedData['code'] = $data->code;
                $nestedData['name'] = $data->name;
                $nestedData['icon'] = $data->icon;



           		$nestedData['action'] = $edit_url." ".$delete_url." ".$delete_permanen;
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
        $this->form_validation->set_rules('name',"name", 'trim|required');

		if ($this->form_validation->run() === TRUE)
		{

            //die(var_dump($this->input->post()));
			$data = array(
                'name'          => $this->input->post('name'),
                'code'          => $this->input->post('code'),
                'created_by' => $this->data['users']->id,

			);

            $upload = 1;
            if($_FILES['icon_file']['name']){
                $config['upload_path']          = './image_upload/category/';
                $config['allowed_types']        = '*';
                $config['max_size']             = 20000;
                $random = rand(1000,9999);
                $do_upload = 'icon_file';
                $filename = pathinfo($_FILES['icon_file']["name"]);
                $extension = $filename['extension'];
                $config['file_name'] = $random."_".time().".".$extension;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload($do_upload)){
                    $data['icon'] = $config['file_name'];
                    $upload = 1;
                }else{
                    $upload = 0;
                }
            }


            $this->db->trans_begin();
			$insert = $this->model->insert($data);


			if ($this->db->trans_status() === FALSE)
			{
                $this->db->trans_rollback();
                $this->session->set_flashdata('message_error',"Kategori Gagal Disimpan");
                redirect($this->cont);
			}
			else
			{
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Kategori Berhasil Disimpan");
                redirect($this->cont);
			}
		}else{

			$this->data['content'] = 'admin/'.$this->cont.'/create_v';
			$this->load->view('admin/layouts/page',$this->data);
		}
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('name',"name", 'trim|required');

		if ($this->form_validation->run() === TRUE)
		{
            $data = array(
                'name'          => $this->input->post('name'),
                'code'          => $this->input->post('code'),
                'updated_by' => $this->data['users']->id,
                //'group_id'      => $this->input->post('departemen'),
                //'user_ids'      => $this->input->post('users') ? json_encode($this->input->post('users')) : NULL,
			);

            $upload = 1;
            if($_FILES['icon_file']['name']){
                $config['upload_path']          = './image_upload/category/';
                $config['allowed_types']        = '*';
                $config['max_size']             = 20000;
                $random = rand(1000,9999);
                $do_upload = 'file_contract';
                $filename = pathinfo($_FILES['icon_file']["name"]);
                $extension = $filename['extension'];
                $config['file_name'] = $random."_".time().".".$extension;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload($do_upload)){
                    $data['icon'] = $config['file_name'];
                    $upload = 1;
                }else{
                    $upload = 0;
                }
            }

			$id = $this->input->post('id');
            $this->db->trans_begin();
			$update = $this->model->update($data, ['id' => $id]);

			if ($this->db->trans_status() === FALSE)
			{
                $this->db->trans_rollback();
                $this->session->set_flashdata('message_error', "Kategori gagal Diubah");
                redirect($this->cont,"refresh");
			}else{
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Kategori berhasil Diubah");
                redirect($this->cont,"refresh");
			}
		}
		else
		{
			if(!empty($_POST)){
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error',validation_errors());
				return redirect($this->cont."/edit/".$id);
			}else{
				$this->data['id']= $id;
				$data = $this->model->getOneBy(array("id"=>$this->data['id']));
                $this->data['name'] = (!empty($data))?$data->name:"";
                $this->data['code'] = (!empty($data))?$data->code:"";

				$this->data['content'] = 'admin/'.$this->cont.'/edit_v';
				$this->load->view('admin/layouts/page',$this->data);
			}
		}
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

    private function send_notif_product_to_vendor($vendor_id, $arr_products)
    {
        $this->load->model('User_model');
        $user_vendor = $this->User_model->getOneUserByVendor_id(['vendor_id' => $vendor_id])->id;
        //die($this->db->last_query());

        $this->load->model('Product_model');
        $list_product = $this->Product_model->get_product_with_code(['a.id IN ('.implode(',', $arr_products).')' => NULL]);

        $data_notif = [];
        foreach($list_product as $product)
        {
            $deskripsi = "Produk ".$product->full_code." ".$product->name;
            $deskripsi .= " perlu diganti harga sesuai kontrak, agar kontrak menjadi aktif";

            $data_notif[] = [
                'id_pengirim' => $this->data['users']->id,
                'id_penerima' => $user_vendor,
                'deskripsi' => $deskripsi,
            ];
        }

        $this->db->insert_batch('notification', $data_notif);
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
            $update = $this->model->update($data,array("id"=>$id));

            $response_data['data'] = $data;
            $response_data['status'] = true;
        }else{
            $response_data['msg'] = "ID Harus Diisi";
        }

        echo json_encode($response_data);
    }

}
