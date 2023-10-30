<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Data_lelang extends Admin_Controller {

    protected $cont = 'data_lelang';

 	public function __construct()
	{
		parent::__construct();
        $this->load->model('Data_lelang_model', 'model');
        $this->data['cont'] = $this->cont;
	}

    public function index()
    {
        if($this->data['is_can_read']){
            $this->data['keterangan'] = $this->model->get_combo_data_lelang('keterangan');
            $this->data['departemen'] = $this->model->get_combo_data_lelang('departemen');
            $this->data['vendor'] = $this->model->get_combo_data_lelang('vendor');
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
      		1 =>'departemen',
            2 =>'kategori',
            3 =>'nama',
            4 =>'spesifikasi',
            5 =>'currency',
            6 =>'harga',
            7 =>'vendor',
            8 =>'tgl_terkontrak',
            9 =>'tgl_akhir_kontrak',
            10 =>'volume',
            11 =>'satuan',
            12 =>'proyek_pengguna',
            13 =>'lokasi',
            14 =>'keterangan',
            15 =>'status',
            16 => 'action'
        );

        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  		$search = array();
        $where_and = array();
        $where['is_deleted'] = 0;

  		$limit = 0;
  		$start = 0;

        $totalData = $this->model->getCountAllBy($limit,$start,$search,$order,$dir, $where, $where_and);


        $isSearchColumn =  false;
        if(($value = $this->input->post('search')['value']) != '')
        {
            $isSearchColumn = true;
            $search['proyek_pengguna'] = $value;
            $search['vendor'] = $value;
            $search['keterangan'] = $value;
            $search['tgl_terkontrak'] = $value;
            $search['tgl_akhir_kontrak'] = $value;
        }

        $searchColumn = $this->input->post('columns');

        if(!empty($searchColumn[2]['search']['value'])){
        	$value = $searchColumn[2]['search']['value'];
        	$isSearchColumn = true;
         	$where['departemen'] = $value;
            //die('ada?');
        }

      	if(!empty($searchColumn[4]['search']['value'])){
        	$value = $searchColumn[4]['search']['value'];
        	$isSearchColumn = true;
         	$where_and['nama'] = $value;
		}

        if(!empty($searchColumn[5]['search']['value'])){
        	$value = $searchColumn[5]['search']['value'];
        	$isSearchColumn = true;
         	$where_and['spesifikasi'] = $value;
		}

        if(!empty($searchColumn[7]['search']['value'])){
        	$value = $searchColumn[7]['search']['value'];
        	$isSearchColumn = true;
         	$where['vendor'] = $value;
		}

        if(!empty($searchColumn[8]['search']['value'])){
        	$value = $searchColumn[8]['search']['value'];
        	$isSearchColumn = true;
            //$this->model->escape = FALSE;
         	$where["STR_TO_DATE(tgl_terkontrak, '%d/%m/%Y') >= '$value'"] = NULL;
		}

        if(!empty($searchColumn[9]['search']['value'])){
        	$value = $searchColumn[9]['search']['value'];
        	$isSearchColumn = true;
         	$where["STR_TO_DATE(tgl_akhir_kontrak, '%d/%m/%Y') <= '$value'"] = NULL;
		}

        if(!empty($searchColumn[13]['search']['value'])){
        	$value = $searchColumn[13]['search']['value'];
        	$isSearchColumn = true;
         	$where['lokasi'] = $value;
		}

        if(!empty($searchColumn[0]['search']['value'])){
        	$value = $searchColumn[0]['search']['value'];
        	$isSearchColumn = true;
         	$where['keterangan'] = $value;
		}

    	if($isSearchColumn){
			$totalFiltered = $this->model->getCountAllBy($limit,$start,$search,$order,$dir, $where, $where_and);
        }else{
        	$totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        //kondisi data hanya yg belum di hapus
        $where['is_deleted'] = 0;
		$datas = $this->model->getAllBy($limit,$start,$search,$order,$dir, $where, $where_and);
        //die(print_r($datas));
        //die($this->db->last_query());
        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {

            	
                $delete_url = "";
                if($this->data['is_can_delete']){
                    $delete_url = "<input type='checkbox' class='check-item' name='id[]' value='".$data->id."'>";
                }

                if ($data->status == 0) {
                    $status = "<div class='btn btn-sm btn-primary btn-warning'>Waiting approval</div></a>";
                }
                elseif ($data->status == 1) {
                    $status = "<div class='btn btn-sm btn-primary btn-success'>Approved</div></a>";
                }
                else{
                    $status = "<div class='btn btn-sm btn-primary btn-danger'>Reject</div></a>";
                }
                $approve_btn = "";
                if($this->data['is_can_approval'] && $data->status == 0){
                    $approve_btn = "<a href='javascript:;'
                        url='" . base_url() . "data_lelang/approve/" . $data->id . "'
                        class='btn btn-sm btn-success approve' >Approve
                        </a>";
                    $approve_btn .= " <a href='javascript:;'
                        url='" . base_url() . "data_lelang/reject/" . $data->id . "'
                        class='btn btn-sm btn-danger reject'>Reject
                        </a>";
                }
               

                $nestedData['delete_url'] = $delete_url;
                $nestedData['id'] = $start+$key+1;
                $nestedData['departemen'] = $data->departemen;
                $nestedData['kategori'] = $data->kategori;
                $nestedData['nama'] = $data->nama;
                $nestedData['spesifikasi'] = $data->spesifikasi;
                $nestedData['currency'] = $data->currency;
                $nestedData['harga'] = number_format($data->harga,2);
                $nestedData['proyek_pengguna'] = $data->proyek_pengguna;
                $nestedData['vendor'] = $data->vendor;
                $nestedData['keterangan'] = $data->keterangan;
                $nestedData['tgl_terkontrak'] = $data->tgl_terkontrak;
                $nestedData['tgl_akhir_kontrak'] = $data->tgl_akhir_kontrak;
                $nestedData['volume'] = $data->volume;
                $nestedData['satuan'] = $data->satuan;
                $nestedData['lokasi'] = $data->lokasi;
                $nestedData['keterangan'] = $data->keterangan;
                $nestedData['status'] = $status;



           	    $nestedData['action'] = $approve_btn;
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

    public function reject($id)
    {
        $data_update = [
            'status' => 2,
            'user_approve' => $this->data['users']->id,
        ];
        $this->db->trans_start();

        $this->db->where('id', $id)
            ->update('data_lelang', $data_update);

        $this->db->trans_complete();

        $ret['status'] = $this->db->trans_status();
        ob_end_clean();
        echo json_encode($ret);
    }
    
    public function approve($id)
    {
        $data_update = [
            'status' => 1,
            'user_approve' => $this->data['users']->id,
        ];
        $this->db->trans_start();

        $this->db->where('id', $id)
            ->update('data_lelang', $data_update);

        $this->db->trans_complete();

        $ret['status'] = $this->db->trans_status();
        ob_end_clean();
        echo json_encode($ret);
    }
    

    public function detail_data_lelang()
    {
        $data = $this->model->get_detail_data_lelang($this->input->post());
        $ret = [];
        $ret['data'] = $data;

        echo json_encode($ret);
    }

    public function import_csv()
    {
        
        if (empty($_FILES['data_lelang']['name']))
        {
            $this->session->set_flashdata('message_error', "File Harus Diisi");
            redirect($this->cont . '/create',"refresh");
        }
        
        $this->load->library('csvimport');
        $filename = pathinfo($_FILES["data_lelang"]["name"]);
        $extension = $filename['extension'];
        
        if($extension !='csv')
        {
            $this->session->set_flashdata('message_error', "File Yang Dimasukkan Harus Berekstensi CSV");
            redirect($this->cont . '/create',"refresh");
        }
        
        $file_data = $this->csvimport->get_array($_FILES["data_lelang"]["tmp_name"]);
        if (empty($file_data))
        {
            $this->session->set_flashdata('message_error', "Minimal harus ada 1 baris data Lelang");
            redirect($this->cont . '/create',"refresh");
        }
        
        if(count($file_data[0]) == 1)
        {
            $file_data = $this->csvimport->get_array($_FILES["data_lelang"]["tmp_name"],FALSE,FALSE,FALSE,';');
        }else
        {
            $file_data = $this->csvimport->get_array($_FILES["data_lelang"]["tmp_name"],FALSE,FALSE,FALSE,',');
        }
        
        $this->db->trans_start();
        $dataHistory = [
            'jml_row' => count($file_data),
            'created_by' => $this->data['users']->id,
        ];
        
        $this->db->insert('data_lelang_upload_history', $dataHistory );
        $upload_history_id = $this->db->insert_id();

        $data_insert = [];
        
        $header = ['NO','DEPARTEMEN','KATEGORI','NAMA','SPESIFIKASI','MATA_UANG','HARGA','VENDOR','TANGGAL_TERKONTRAK','TANGGAL_BERAKHIR_KONTRAK'
        ,'VOLUME','SATUAN','PROYEK_PENGGUNA','LOKASI','KETERANGAN'];
        $cek_header = [];
        $i = 0;
        foreach($file_data as $k => $v)
        {
            if($i == 0)
            {
                $header != array_keys($v);
                if(($header == array_keys($v)) === FALSE)
                {
                    $this->session->set_flashdata('message_error', "File Yang Dimasukkan Tidak Sesuai dengan Format");
                    redirect($this->cont . '/create',"refresh");
                }
            }
            $i++;

            $data_insert[] = [
                'no' => $v['NO'],
                'departemen' => $v['DEPARTEMEN'],
                'kategori' => $v['KATEGORI'],
                'nama' => $v['NAMA'],
                'spesifikasi' => $v['SPESIFIKASI'],
                'currency' => $v['MATA_UANG'],
                'harga' => $v['HARGA'],
                'vendor' => $v['VENDOR'],
                'tgl_terkontrak' => $v['TANGGAL_TERKONTRAK'],
                'tgl_akhir_kontrak' => $v['TANGGAL_BERAKHIR_KONTRAK'],
                'volume' => $v['VOLUME'],
                'satuan' => $v['SATUAN'],
                'proyek_pengguna' => $v['PROYEK_PENGGUNA'],
                'lokasi' => $v['LOKASI'],
                'keterangan' => $v['KETERANGAN'],
                'upload_history_id' => $upload_history_id,
            ];
        }

        if(!empty($data_insert))
        {
            $insert = $this->db->insert_batch('data_lelang', $data_insert);
            $this->db->trans_complete();
            if($insert !== FALSE)
            {
                $this->session->set_flashdata('message', "Data Berhasil Diupload");
                //die();
                redirect($this->cont,"refresh");
            }
            else
            {
                $this->session->set_flashdata('message_error', "Data Gagal diupload");
                redirect($this->cont . '/create',"refresh");
            }

        }
    }

    public function create()
    {
        //$this->form_validation->set_rules('data_lelang',"Data Lelang", 'trim|required');
        if (empty($_FILES['data_lelang']['name']))
        {
            $this->form_validation->set_rules('data_lelang', 'Document', 'required');
        }

		if ($this->form_validation->run() === TRUE)
		{

            $this->load->library('csvimport');
            $a = $_FILES["data_lelang"]['type'];
            $filename = pathinfo($_FILES["csv_file"]["name"]);
            $extension = $filename['extension'];

            if($extension !='csv')
            {
                $this->session->set_flashdata('message_error', "File Yang Dimasukkan Harus Berekstensi CSV");
                redirect($this->cont . '/create',"refresh");
            }



		}
        else
        {
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
        $idDataLelang = $_POST['id']; // Ambil data ID yang dikirim oleh view.php melalui form submit
        if ($idDataLelang == NULL) {
            $this->session->set_flashdata('message_error', "Tidak Ada Data yang Anda Pilih Untuk Dihapus");
            redirect("data_lelang");
        }else{
            $updateArray = array();

            for($x = 0; $x < sizeof($idDataLelang); $x++){
                $dataupdate[] = 1;
                $updateArray[] = array(
                    'id'=>$idDataLelang[$x],
                    'is_deleted' => $dataupdate[$x]
                );
            }
            $update = $this->db->update_batch('data_lelang',$updateArray, 'id');
            if ($update) {
                $this->session->set_flashdata('message', "Data Anda Berhasil Dihapus");
                redirect("data_lelang");
            }else{
                $this->session->set_flashdata('message_error', "Data Anda Tidak Berhasil Dihapus");
                redirect("data_lelang");
            }
        }

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

    public function download_format($format = 'comma')
    {

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename=data_lelang_'.time().'.csv');
        header('Pragma: no-cache');
        header("Expires: 0");

        $fp = fopen('php://memory', 'r+');;

        $header = ['NO','DEPARTEMEN','KATEGORI','NAMA','SPESIFIKASI','MATA_UANG','HARGA','VENDOR','TANGGAL_TERKONTRAK','TANGGAL_BERAKHIR_KONTRAK'
        ,'VOLUME','SATUAN','PROYEK_PENGGUNA','LOKASI','KETERANGAN'];

        $separator = $format == 'comma' ? ',' : ';';

        fputcsv($fp, $header, $separator);
        rewind($fp);
        $csv_line = stream_get_contents($fp);
        echo rtrim($csv_line);
    }

    public function exportToExcel()
    {
        $where = [];
        $search = [];
        $where_and = [];
        if($this->input->get('departemen'))
        {
         	$where['departemen'] = $this->input->get('departemen');
        }

        if($this->input->get('nama'))
        {
         	$where_and['nama'] = $this->input->get('nama');
        }

        if($this->input->get('spesifikasi'))
        {
         	$where_and['spesifikasi'] = $this->input->get('spesifikasi');
        }

        if($this->input->get('vendor'))
        {
         	$where['vendor'] = $this->input->get('vendor');
        }

        if($this->input->get('start_contract'))
        {
            $where["STR_TO_DATE(tgl_terkontrak, '%d/%m/%Y') >= '" . $this->input->get('start_contract') ."'"] = NULL;
        }

        if($this->input->get('end_contract'))
        {
            $where["STR_TO_DATE(tgl_akhir_kontrak, '%d/%m/%Y') <= '" . $this->input->get('end_contract') ."'"] = NULL;
        }

        if($this->input->get('lokasi'))
        {
         	$where['lokasi'] = $this->input->get('lokasi');
        }

        if($this->input->get('keterangan'))
        {
         	$where['keterangan'] = $this->input->get('keterangan');
        }

        $data['data'] = $this->model->getAllBy(0,0,$search,NULL,NULL, $where, $where_and);
        $this->load->view('admin/' . $this->cont . '/export_to_excel_v', $data);
    }

    public function history_upload_dataList()
    {
        $this->load->model('Data_lelang_upload_history_model');
        $columns = array(
            'data_lelang_upload_history.id',
            'users.first_name',
            'data_lelang_upload_history.jml_row',
            'data_lelang_upload_history.created_at',
        );

        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  		$search = array();
        $where = [];

  		$limit = 0;
  		$start = 0;

        $totalData = $this->Data_lelang_upload_history_model->getCountAllBy($limit,$start,$search,$order,$dir, $where);


        $isSearchColumn =  false;
        if(($value = $this->input->post('search')['value']) != '')
        {
            $isSearchColumn = true;
            $search['users.first_name'] = $value;
            $search['data_lelang_upload_history.jml_row'] = $value;
        }

    	if($isSearchColumn){
			$totalFiltered = $this->Data_lelang_upload_history_model->getCountAllBy($limit,$start,$search,$order,$dir, $where);
        }else{
        	$totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
		$datas = $this->Data_lelang_upload_history_model->getAllBy($limit,$start,$search,$order,$dir, $where);

        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {

                $nestedData['id'] = $start+$key+1;
                $nestedData['first_name'] = $data->first_name;
                $nestedData['jml_row'] = $data->jml_row;
                $nestedData['created_at'] = tgl_indo($data->created_at, TRUE);

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

}
