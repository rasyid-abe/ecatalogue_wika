<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Projectold extends Admin_Controller {

    protected $cont = 'project';

 	public function __construct()
	{
		parent::__construct();
        $this->load->model('Project_model', 'model');
        $this->load->model('Groups_model');
        $this->load->model('Payment_method_model');
        $this->load->model('Product_model');
        $this->load->model('Payment_product_model');
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
      		1 =>'project.name',
            2 =>'project.no_surat',
            3 =>'project.tanggal',
        );
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  		$search = array();

  		$limit = 0;
  		$start = 0;

        $totalData = $this->model->getCountAllBy($limit,$start,$search,$order,$dir);

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;


    	if($isSearchColumn){
			$totalFiltered = $this->model->getCountAllBy($limit,$start,$search,$order,$dir);
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
                $detail_url = '';
                $amandemen_url = '';

                if($data->is_deleted == 0)
                {
                    $amandemen_url = "<a href='".base_url().$this->cont."/amandemen/".$data->id."' class='btn btn-sm white'><i class='fa fa-bookmark'></i> Amandemen </a>";
                    $detail_url = "<a href='".base_url().$this->cont."/detail/".$data->id."' class='btn btn-sm white'><i class='fa fa-bars'></i> Detail</a>";
                }

            	if($this->data['is_can_edit'] && $data->is_deleted == 0)
                {
            		$edit_url = "<a href='".base_url().$this->cont."/edit/".$data->id."' class='btn btn-sm white'><i class='fa fa-pencil'></i> Ubah</a>";
            	}

            	if($this->data['is_can_delete'])
                {
	            	if($data->is_deleted == 0)
                    {
	        			$delete_url = "<a href='javascript:;'
	        				url='".base_url().$this->cont."/destroy/".$data->id."/".$data->is_deleted."'
	        				class='btn btn-sm white delete' >NonAktifkan
	        				</a>";
	        		}
                    else
                    {
	        			$delete_url = "<a href='javascript:;'
	        				url='".base_url().$this->cont."/destroy/".$data->id."/".$data->is_deleted."'
	        				class='btn btn-sm white delete'
	        				 >Aktifkan
	        				</a>";
	        		}
        		}


                $nestedData['id'] = $start+$key+1;
                $nestedData['name'] = $data->name;
                $nestedData['no_surat'] = $data->no_surat;
                $nestedData['tanggal'] = $data->tanggal;



           		$nestedData['action'] = $edit_url." ".$delete_url . " " . $amandemen_url . " " .$detail_url ;
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
        // $this->form_validation->set_rules('no_surat',"No Surat", 'trim|required');
        $this->form_validation->set_rules('departemen_pemantau',"Departemen Pemantau", 'trim|required');
        $this->form_validation->set_rules('user_pemantau',"User Pemantau", 'trim|required');
        $this->form_validation->set_rules('harga',"Harga", 'trim|required');
        $this->form_validation->set_rules('volume',"Volume", 'trim|required');
        $this->form_validation->set_rules('payment_method',"Methode Pembayaran", 'trim|required');

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
                'payment_method_id' => $this->input->post('payment_method'),
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

                //find department
                $find_department_pemantau = $this->Groups_model->findAllById(['groups.id'=>$this->input->post('departemen_pemantau')]);
                $nama_department_pemantau = '';
                if($find_department_pemantau){
                    $nama_department_pemantau = $find_department_pemantau->name;
                }

                //find payment_method
                $find_payment = $this->Payment_method_model->getOneBy(['payment_method.id'=>$this->input->post('payment_method')]);
                $nama_metode_pembayaran = '';
                if($find_payment){
                    $nama_metode_pembayaran = $find_payment->full_name;
                }

                foreach($this->input->post('product_id') as $v)
                {
                    $data_product[] = array(
                        'project_id' => $insert,
                        'product_id' => $v,
                    );
                    $find_product = $this->Product_model->findAllDataProduct(['product.id'=>$v]);
                    if($find_product){
                        $find_price = $this->Payment_product_model->getOneBy(['payment_product.product_id'=>$v,'payment_product.payment_id'=>$this->input->post('payment_method')]);
                        $price = 0;
                        if($find_price){
                            if($find_price->price){
                                $price = $find_price->price;
                            }
                        }
                        //insert to data lelang
                        $data_lelang[] = array(
                            'departemen'=>$nama_department_pemantau,
                            'kategori'=>"BARANG",
                            'nama'=>$find_product->name,
                            'spesifikasi'=>$find_product->size_name,
                            'harga'=>$price,
                            'vendor'=>$find_product->vendor_name,
                            'tgl_terkontrak'=>$this->input->post('start_contract'),
                            'tgl_akhir_kontrak'=>$this->input->post('end_contract'),
                            'volume'=>$find_product->default_weight,
                            'satuan'=>$find_product->uom_name,
                            'proyek_pengguna'=>$this->input->post('name'),
                            'lokasi'=>$find_product->location_name,
                            'keterangan'=>$nama_metode_pembayaran,
                        );
                    }
                }

                $this->db->insert_batch('project_products', $data_product);
                $this->db->insert_batch('data_lelang', $data_lelang);
                $this->send_notif_product_to_vendor($this->input->post('vendor_id'), $this->input->post('product_id'), $this->input->post('no_contract'), $this->input->post('payment_method'));
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
            $this->load->model('payment_method_model');
            $this->data['payment_method'] = $this->payment_method_model->getAllById();

			$this->data['content'] = 'admin/'.$this->cont.'/create_v';
			$this->load->view('admin/layouts/page',$this->data);
		}
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('name',"name", 'trim|required');
		$this->form_validation->set_rules('deskripsi',"Deskripsi", 'trim|required');
        $this->form_validation->set_rules('tgl',"Tanggal", 'trim|required');
        // $this->form_validation->set_rules('no_surat',"No Surat", 'trim|required');
        $this->form_validation->set_rules('departemen_pemantau',"Departemen Pemantau", 'trim|required');
        $this->form_validation->set_rules('user_pemantau',"User Pemantau", 'trim|required');
        $this->form_validation->set_rules('harga',"Harga", 'trim|required');
        $this->form_validation->set_rules('volume',"Volume", 'trim|required');
        $this->form_validation->set_rules('payment_method',"Methode Pembayaran", 'trim|required');
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
                'payment_method_id' => $this->input->post('payment_method'),
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
                $this->session->set_flashdata('message_error', "Projek  Gagal Diubah");
                redirect($this->cont,"refresh");
			}else{
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Projek  Berhasil Diubah");
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
                $this->data['payment_method_id'] = (!empty($data))?$data->payment_method_id:"";
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

                $this->load->model('payment_method_model');
                $this->data['payment_method'] = $this->payment_method_model->getAllById();


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

    private function send_notif_product_to_vendor($vendor_id, $arr_products, $no_kontrak, $payment_method_id)
    {
        $this->load->model('User_model');
        $user_vendor = $this->User_model->getOneUserByVendor_id(['vendor_id' => $vendor_id])->id;
        //die($this->db->last_query());
        $this->load->model('Payment_method_model');
        $q_payment_method = $this->Payment_method_model->getOneBy(['payment_method.id' => $payment_method_id]);
        $payment_method_name = $q_payment_method ? $q_payment_method->full_name : '';

        $this->load->model('Product_model');
        $list_product = $this->Product_model->get_product_with_code(['a.id IN ('.implode(',', $arr_products).')' => NULL]);

        $data_notif = [];
        foreach($list_product as $product)
        {
            $deskripsi = "Produk ".$product->full_code." ".$product->name;
            $deskripsi .= " dengan metode pembayaran ".$payment_method_name." perlu diganti harga sesuai kontrak ".$no_kontrak;

            $data_notif[] = [
                'id_pengirim' => $this->data['users']->id,
                'id_penerima' => $user_vendor,
                'deskripsi' => $deskripsi,
            ];
        }

        $this->db->insert_batch('notification', $data_notif);
    }

    public function amandemen($id)
    {
        $this->form_validation->set_rules('harga',"Harga", 'trim|required');
        $this->form_validation->set_rules('volume',"Volume", 'trim|required');

		if ($this->form_validation->run() === TRUE)
		{
            $this->load->model('Amandemen_model');
            $id = $this->input->post('id');

            $no_amandemen = $this->Amandemen_model->get_no_amandemen_terakhir($id);

            $no_amandemen = $no_amandemen->no_amandemen ? $no_amandemen->no_amandemen + 1 : 1;

            $data = array(
                'no_amandemen' => $no_amandemen,
                'id_project' => $id,
                'start_contract' => $this->input->post('start_contract'),
                'end_contract' => $this->input->post('end_contract'),
                'harga' => $this->input->post('harga'),
                'volume' => $this->input->post('volume'),
                'created_by' => $this->data['users']->id,
			);

            $this->db->trans_begin();
			$insert = $this->Amandemen_model->insert($data);
            //die(my_print_r($this->input->post('harga_product')));
            if($this->input->post('product_id'))
            {
                $data_aman_product = [];
                foreach($this->input->post('product_id') as $k => $v)
                {
                    $data_aman_product[] = [
                        'amandemen_id' => $insert,
                        'product_id' => $v,
                        //'harga' => $v
                    ];
                }

                $this->db->insert_batch('amandemen_products', $data_aman_product);
            }

			if ($this->db->trans_status() === FALSE)
			{
                $this->db->trans_rollback();
                $this->session->set_flashdata('message_error', "Amandemen Gagal Diubah");
                redirect($this->cont,"refresh");
			}else{
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Amandemen Berhasil Dibuat");
                redirect($this->cont,"refresh");
			}
		}
		else
		{
			if(!empty($_POST)){
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error',validation_errors());
				return redirect($this->cont."/amandemen/".$id);
			}else{
				$this->data['id']= $id;
				$data = $this->model->getOneBy(array("id"=>$this->data['id']));
                $this->data['name'] = (!empty($data))?$data->name:"";
                $this->data['description'] = (!empty($data))?$data->description:"";
                $this->data['tanggal'] = (!empty($data))?$data->tanggal:"";
                $this->data['no_surat'] = (!empty($data))?$data->no_surat:"";
                $this->data['no_contract'] = (!empty($data))?$data->no_contract:"";
                $this->data['vendor_id'] = (!empty($data))?$data->vendor_id:"";
                $this->data['departemen_pemantau_id'] = (!empty($data))?$data->departemen_pemantau_id:"";
                $this->data['user_pemantau_id'] = (!empty($data))?$data->user_pemantau_id:"";
                $this->data['payment_method_id'] = (!empty($data))?$data->payment_method_id:"";

                $this->load->model('Amandemen_model');
                $amandemen_terakhir = $this->Amandemen_model->get_row_amandemen_terakhir($id);

                if($amandemen_terakhir)
                {
                    $this->data['start_contract'] = $amandemen_terakhir->start_contract;
                    $this->data['end_contract'] = $amandemen_terakhir->end_contract;
                    $this->data['harga'] = $amandemen_terakhir->harga;
                    $this->data['volume'] = $amandemen_terakhir->volume;

                    $this->load->model('Amandemen_products_model');
                    $arr_products = array();
                    $products = $this->Amandemen_products_model->getAllById(array('amandemen_id' => $amandemen_terakhir->id));
                    if($products)
                    {
                        foreach($products as $v)
                        {
                            $arr_products[] = $v->product_id;
                        }
                    }
                    $this->data['arr_products'] = $arr_products;
                }
                else
                {
                    $this->data['start_contract'] = (!empty($data))?$data->start_contract:"";
                    $this->data['end_contract'] = (!empty($data))?$data->end_contract:"";
                    $this->data['harga'] = (!empty($data))?$data->harga:"";
                    $this->data['volume'] = (!empty($data))?$data->volume:"";

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
                }


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


                $this->load->model('payment_method_model');
                $this->data['payment_method'] = $this->payment_method_model->getAllById();


				$this->data['content'] = 'admin/'.$this->cont.'/amandemen_v';
				$this->load->view('admin/layouts/page',$this->data);
			}
		}
    }

    public function detail($id)
    {
        $this->data['id_project'] = $id;
        $this->data['content'] = 'admin/'.$this->cont.'/detail_v';
		$this->load->view('admin/layouts/page',$this->data);
    }

    public function detail_dataList($id_project)
    {
        //$id_project = $this->uri->segment(4);
        //die($id_project);
        $columns = array(
            0 =>'a.no_amandemen',
      		1 =>'d.name',
            2 =>'c.name',
            3 =>'a.start_contract',
            4 =>'a.end_contract',
            5 =>'a.volume',
            6 =>'a.harga',
        );
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  		$search = array();
        $where['b.id'] = $id_project;
  		$limit = 0;
  		$start = 0;
        $this->load->model('Amandemen_model');
        $totalData = $this->Amandemen_model->getCountAllBy($limit,$start,$search,$order,$dir, $where);

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;


    	if($isSearchColumn){
			$totalFiltered = $this->Amandemen_model->getCountAllBy($limit,$start,$search,$order,$dir, $where);
        }else{
        	$totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
		$datas = $this->Amandemen_model->getAllBy($limit,$start,$search,$order,$dir, $where);
        //die(print_r($datas));
        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {

            	$edit_url = "";
     			$delete_url = "";
                $detail_url = "<a href='javascript:;' class='btn btn-sm white detail' data-id='" . $data->id . "'><i class='fa fa-bars'></i> Detail</a>";
                $amandemen_url = '';


                $nestedData['id'] = $start+$key+1;
                $nestedData['no_kontrak'] = $data->no_contract .'-Amd' . $data->no_amandemen;
                $nestedData['departemen_name'] = $data->departemen_name;
                $nestedData['vendor_name'] = $data->vendor_name;
                $nestedData['start_contract'] = tgl_indo($data->start_contract);
                $nestedData['end_contract'] = tgl_indo($data->end_contract);
                $nestedData['volume'] = $data->volume;
                $nestedData['harga'] = rupiah($data->harga);



           		$nestedData['action'] = $edit_url." ".$delete_url . " " . $amandemen_url . " " .$detail_url ;
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

    function get_detail_amandemen($id_amandemen)
    {
        $this->load->model('Amandemen_model');
        $query = $this->Amandemen_model->get_detail_amandemen_list_by(['b.id' => $id_amandemen]);

        $ret = [];
        $ret['data'] = $query;
        echo json_encode($ret);
    }

}
