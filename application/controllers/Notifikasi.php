<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Notifikasi extends Admin_Controller {

    protected $cont = 'Notifikasi';

 	public function __construct()
	{
		parent::__construct();
        $this->load->model('Notification_model', 'model');
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
      		1 =>'deskripsi',
        );
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  		$search = array();        
        $where = ['id_penerima' => $this->data['users']->id];
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
        //die(print_r($datas));
        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {


                $nestedData['id'] = $start+$key+1;
                $nestedData['deskripsi'] = $data->deskripsi;
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
		$this->form_validation->set_rules('deskripsi',"Deskripsi", 'trim|required');
        $this->form_validation->set_rules('tgl',"Tanggal", 'trim|required');
        $this->form_validation->set_rules('no_surat',"No Surat", 'trim|required');
        $this->form_validation->set_rules('departemen_pemantau',"Departemen Pemantau", 'trim|required');
        $this->form_validation->set_rules('user_pemantau',"User Pemantau", 'trim|required');
        $this->form_validation->set_rules('harga',"Harga", 'trim|required');
        $this->form_validation->set_rules('volume',"Volume", 'trim|required');
        //$this->form_validation->set_rules('departemen',"Departemen", 'trim|required');

		if ($this->form_validation->run() === TRUE)
		{

            //die(var_dump($this->input->post()));
			$data = array(
                'name'          => $this->input->post('name'),
                'tanggal'       => $this->input->post('tgl'),
                'description'   => $this->input->post('deskripsi'),
                'no_surat'      => $this->input->post('no_surat'),
                'start_contract' => $this->input->post('start_contract'),
                'end_contract' => $this->input->post('end_contract'),
                'no_contract' => $this->input->post('no_contract'),
                'vendor_id' => $this->input->post('vendor_id'),
                'departemen_pemantau_id' => $this->input->post('departemen_pemantau'),
                'user_pemantau_id' => $this->input->post('user_pemantau'),
                'harga' => $this->input->post('harga'),
                'volume' => $this->input->post('volume'),
                'created_by' => $this->data['users']->id,

                //'group_id'      => $this->input->post('departemen'),
                //'user_ids'      => $this->input->post('users') ? json_encode($this->input->post('users')) : NULL,
			);

            $upload = 1;
            if($_FILES['file_contract']['name']){
                $config['upload_path']          = './file_contract/';
                $config['allowed_types']        = '*';
                $config['max_size']             = 20000;
                $random = rand(1000,9999);
                $do_upload = 'file_contract';
                $filename = pathinfo($_FILES['file_contract']["name"]);
                $extension = $filename['extension'];
                $config['file_name'] = $random."_".time().".".$extension;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload($do_upload)){
                    $data['file_contract'] = $config['file_name'];
                    $upload = 1;
                }else{
                    $upload = 0;
                }
            }


            $this->db->trans_begin();
			$insert = $this->model->insert($data);

            $data_group = array();
            foreach($this->input->post('departemen') as $v)
            {
                $data_group[] = array(
                    'project_id' => $insert,
                    'group_id' => $v,
                );
            }

            $this->db->insert_batch('project_departement', $data_group);

            if($this->input->post('users'))
            {
                $data_user = array();
                foreach($this->input->post('users') as $v)
                {
                    $data_user[] = array(
                        'project_id' => $insert,
                        'user_id' => $v,
                    );
                }

                $this->db->insert_batch('project_users', $data_user);
            }

            if($this->input->post('product_id'))
            {
                $data_product = array();
                foreach($this->input->post('product_id') as $v)
                {
                    $data_product[] = array(
                        'project_id' => $insert,
                        'product_id' => $v,
                    );
                }

                $this->db->insert_batch('project_products', $data_product);
                $this->send_notif_product_to_vendor($this->input->post('vendor_id'), $this->input->post('product_id'));
            }


			if ($this->db->trans_status() === FALSE)
			{
                $this->db->trans_rollback();
                $this->session->set_flashdata('message_error',"Project Baru Gagal Disimpan");
                redirect($this->cont);
			}
			else
			{
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Project Baru Berhasil Disimpan");
                redirect($this->cont);
			}
		}else{
            //die(var_dump($this->input->post()));

            $this->load->model('Groups_model');
            $this->data['groups'] = $this->Groups_model->getAllById();

            $this->load->model('vendor_model');
            $where_vendor = array();
            if(!$this->data['is_superadmin']){$where_vendor['vendor.id'] = $this->data['users']->vendor_id;}
            $this->data['vendor'] = $this->vendor_model->getvendor($where_vendor);

            //$this->load->model('user_model');
            //$this->user_model->getAllById(['users.group_id' => $]);

			$this->data['content'] = 'admin/'.$this->cont.'/create_v';
			$this->load->view('admin/layouts/page',$this->data);
		}
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('name',"name", 'trim|required');
		$this->form_validation->set_rules('deskripsi',"Deskripsi", 'trim|required');
        $this->form_validation->set_rules('tgl',"Tanggal", 'trim|required');
        $this->form_validation->set_rules('no_surat',"No Surat", 'trim|required');
        $this->form_validation->set_rules('departemen_pemantau',"Departemen Pemantau", 'trim|required');
        $this->form_validation->set_rules('user_pemantau',"User Pemantau", 'trim|required');
        $this->form_validation->set_rules('harga',"Harga", 'trim|required');
        $this->form_validation->set_rules('volume',"Volume", 'trim|required');
        //$this->form_validation->set_rules('departemen',"Departemen", 'trim|required');

		if ($this->form_validation->run() === TRUE)
		{
            $data = array(
                'name'          => $this->input->post('name'),
                'tanggal'       => $this->input->post('tgl'),
                'description'   => $this->input->post('deskripsi'),
                'no_surat'      => $this->input->post('no_surat'),
                'start_contract' => $this->input->post('start_contract'),
                'end_contract' => $this->input->post('end_contract'),
                'no_contract' => $this->input->post('no_contract'),
                'vendor_id' => $this->input->post('vendor_id'),
                'departemen_pemantau_id' => $this->input->post('departemen_pemantau'),
                'user_pemantau_id' => $this->input->post('user_pemantau'),
                'harga' => $this->input->post('harga'),
                'volume' => $this->input->post('volume'),
                'updated_by' => $this->data['users']->id,
                //'group_id'      => $this->input->post('departemen'),
                //'user_ids'      => $this->input->post('users') ? json_encode($this->input->post('users')) : NULL,
			);

            $upload = 1;
            if($_FILES['file_contract']['name']){
                $config['upload_path']          = './file_contract/';
                $config['allowed_types']        = '*';
                $config['max_size']             = 20000;
                $random = rand(1000,9999);
                $do_upload = 'file_contract';
                $filename = pathinfo($_FILES['file_contract']["name"]);
                $extension = $filename['extension'];
                $config['file_name'] = $random."_".time().".".$extension;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload($do_upload)){
                    $data['file_contract'] = $config['file_name'];
                    $upload = 1;
                }else{
                    $upload = 0;
                }
            }

			$id = $this->input->post('id');
            $this->db->trans_begin();
			$update = $this->model->update($data, ['id' => $id]);

            $this->load->model('Project_departement_model');
            $this->Project_departement_model->delete(['project_id' => $id]);
            $data_group = array();
            foreach($this->input->post('departemen') as $v)
            {
                $data_group[] = array(
                    'project_id' => $id,
                    'group_id' => $v,
                );
            }

            $this->db->insert_batch('project_departement', $data_group);

            $this->load->model('Project_users_model');
            $this->Project_users_model->delete(['project_id' => $id]);
            if($this->input->post('users'))
            {
                $data_user = array();
                foreach($this->input->post('users') as $v)
                {
                    $data_user[] = array(
                        'project_id' => $id,
                        'user_id' => $v,
                    );
                }

                $this->db->insert_batch('project_users', $data_user);
            }

            $this->load->model('Project_products_model');
            $list_product = $this->Project_products_model->getAllById(['project_id' => $id,'is_deleted' => 0]);

            $arr_list_product = [];
            if($list_product)
            {
                foreach($list_product as $v)
                {
                    $arr_list_product[] = $v->product_id;
                }
            }

            if($this->input->post('product_id'))
            {
                $data_product = array();
                foreach($this->input->post('product_id') as $v)
                {
                    if( ! in_array($v, $arr_list_product) )
                    {
                        $data_product[] = array(
                            'project_id' => $id,
                            'product_id' => $v,
                        );
                    }
                }
                if($data_product)
                $this->db->insert_batch('project_products', $data_product);

                // set is delete data yang tidak ada
                foreach($arr_list_product as $v)
                {
                    if( ! in_array($v, $this->input->post('product_id') ) )
                    {
                        $where_product = [
                            'project_id' => $id,
                            'product_id' => $v,
                        ];

                        $this->Project_products_model->update(['is_deleted' => 1], $where_product);
                    }
                }
            }

			if ($this->db->trans_status() === FALSE)
			{
                $this->db->trans_rollback();
                $this->session->set_flashdata('message_error', "Berkas Kategori  Gagal Diubah");
                redirect($this->cont,"refresh");
			}else{
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Berkas Kategori  Berhasil Diubah");
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
                $this->data['description'] = (!empty($data))?$data->description:"";
                $this->data['tanggal'] = (!empty($data))?$data->tanggal:"";
                $this->data['no_surat'] = (!empty($data))?$data->no_surat:"";
                $this->data['no_contract'] = (!empty($data))?$data->no_contract:"";
                $this->data['start_contract'] = (!empty($data))?$data->start_contract:"";
                $this->data['end_contract'] = (!empty($data))?$data->end_contract:"";
                $this->data['vendor_id'] = (!empty($data))?$data->vendor_id:"";
                $this->data['departemen_pemantau_id'] = (!empty($data))?$data->departemen_pemantau_id:"";
                $this->data['user_pemantau_id'] = (!empty($data))?$data->user_pemantau_id:"";
                $this->data['volume'] = (!empty($data))?$data->volume:"";
                $this->data['harga'] = (!empty($data))?$data->harga:"";
                //var_dump($this->data['end_contract']);
                $this->load->model('Project_departement_model');
                $groups = $this->Project_departement_model->getAllById(['project_id' => $id]);
                $arr_group = array();
                if($groups)
                {
                    foreach($groups as $v)
                    {
                        $arr_group[] = $v->group_id;
                    }
                }
                $this->data['group_id'] = $arr_group;

                $this->load->model('Project_users_model');
                $users = $this->Project_users_model->getAllById(['project_id' => $id]);
                $arr_user = array();
                if($users)
                {
                    foreach($users as $v)
                    {
                        $arr_user[] = $v->user_id;
                    }
                }
                $this->data['user_ids'] = $arr_user;

                $this->load->model('Groups_model');
                $this->data['groups'] = $this->Groups_model->getAllById();

                $this->load->model('user_model');

                $this->data['user_id'] = array();
                if(!empty($arr_group))
                {
                    $this->data['user_id'] = $this->user_model->getAllById(['users.group_id IN ('.implode(',',$arr_group).')' => NULL ]);
                }

                $this->data['user_pemantau_list'] =  $this->user_model->getAllById(['users.group_id' => $this->data['departemen_pemantau_id'] ]);


                $this->load->model('vendor_model');
                $where_vendor = array();
                if(!$this->data['is_superadmin']){$where_vendor['vendor.id'] = $this->data['users']->vendor_id;}
                $this->data['vendor'] = $this->vendor_model->getvendor($where_vendor);

                $this->load->model('Product_model');
                $this->data['products'] = $this->Product_model->getAllDataProduct(array('product.vendor_id' => $this->data['vendor_id']));

                $this->load->model('Project_products_model');
                $arr_products = array();
                $products = $this->Project_products_model->getAllById(array('project_id' => $id,'is_deleted' => 0));
                if($products)
                {
                    foreach($products as $v)
                    {
                        $arr_products[] = $v->product_id;
                    }
                }
                $this->data['arr_products'] = $arr_products;



                //var_dump($this->data['arr_products']);

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

}
