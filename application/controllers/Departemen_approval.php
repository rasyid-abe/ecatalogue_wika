<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Departemen_approval extends Admin_Controller {

    protected $cont = 'departemen_approval';

 	public function __construct()
	{
		parent::__construct();
        $this->load->model('Approve_po_rules_model', 'model');
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

    public function edit_approval($departemen_id)
    {
        $this->form_validation->set_rules('departemen_id',"Departemen", 'trim|required');

        if($this->form_validation->run() === TRUE)
        {
            $this->db->trans_begin();
            $this->db->where('departemen_id', $departemen_id)->delete('approve_po_rules');

            $sequence = 1;
            if($this->input->post('role_id'))
            {
                $data_insert = [];
                $for_duplicate = [];
                foreach ($this->input->post('role_id') as $v)
                {
                    if(in_array($v, $for_duplicate))
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message_error', 'Role Duplikat, proses dibatalkan');
                        redirect($this->cont . '/edit_approval/' . $departemen_id);
                    }

                    $data_insert[] = [
                        'role_id' => $v,
                        'sequence' => $sequence,
                        'departemen_id' => $departemen_id
                    ];

                    $sequence++;
                    $for_duplicate[] = $v;
                }

                $this->db->insert_batch('approve_po_rules', $data_insert);
            }

            if($this->db->trans_status() !== FALSE)
            {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', 'Approval Role berhasil !');
                redirect($this->cont);
            }
            else
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', 'Approval Role gagal !');
                redirect($this->cont);
            }

        }

        $this->load->model('Groups_model');
        $departemen = $this->Groups_model->findAllById(['id' => $departemen_id]);
        if($departemen === FALSE)
        {
            redirect($this->cont);
        }

        $this->load->model('Roles_model');
        $this->load->model('Approve_po_rules_model');

        $this->data['approve_po'] = $this->Approve_po_rules_model->get_all_approve_po_list(['departemen_id' => $departemen_id]);
        $this->data['roles'] = $this->Roles_model->get_dropdown();
        $this->data['departemen'] = $departemen;
        $this->data['content'] = 'admin/' . $this->cont . '/edit_approval_v';
        $this->load->view('admin/layouts/page',$this->data);


    }

    public function dataList()
    {
        $this->load->model('Groups_model');
        $columns = array(
            0 =>'id',
      		1 =>'name',
        );
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  		$search = array();

  		$limit = 0;
  		$start = 0;

        $totalData = $this->Groups_model->getCountAllBy($limit,$start,$search,$order,$dir);

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;

        if($this->input->post('search')['value'] != '')
        {
            $search['name'] = $this->input->post('search')['value'];
        }


    	if($isSearchColumn){
			$totalFiltered = $this->Groups_model->getCountAllBy($limit,$start,$search,$order,$dir);
        }else{
        	$totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
		$datas = $this->Groups_model->getAllBy($limit,$start,$search,$order,$dir);
        //die(print_r($datas));
        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {

            	$edit_url = "";
     			$delete_url = "";

            	if($this->data['is_can_edit'])
                {
            		$edit_url = "<a href='".base_url().$this->cont."/edit_approval/".$data->id."' class='btn btn-xs btn-info'><i class='fa fa-pencil'></i> Ubah</a>";
            	}

            	if($this->data['is_can_delete'])
                {

        		}


                $nestedData['id'] = $start+$key+1;
                $nestedData['departemen_name'] = $data->name;

           		$nestedData['action'] = $edit_url." ".$delete_url;
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
        $this->form_validation->set_rules('role_id',"Role", 'trim|required');
		$this->form_validation->set_rules('departemen_id',"Departemen", 'trim|required');
        $this->form_validation->set_rules('sequence',"Urutan", 'trim|required');

		if ($this->form_validation->run() === TRUE)
		{
            $data = array(
                'departemen_id'   => $this->input->post('departemen_id'),
                'sequence'   => $this->input->post('sequence'),
            );

            // cek klo sequence di departemen tersebut sudah ada atau belum;
            $is_sequence_exists = $this->model->getOneBy($data);
            if($is_sequence_exists !== FALSE)
            {
                $this->session->set_flashdata('message_error',"Urutan tersebut sudah ada. silahkan gunakan yang lain");
                redirect($this->cont . '/create');
            }

            $data['role_id'] = $this->input->post('role_id');
			$insert = $this->model->insert($data);

			if ($insert === FALSE)
			{
                $this->session->set_flashdata('message_error',"Departemen approval gagal disimpan");
                redirect($this->cont);
			}
			else
			{
                $this->session->set_flashdata('message', "Departemen approval berhasil disimpan");
                redirect($this->cont);
			}
		}


        $this->load->model('Roles_model');
        $this->load->model('Groups_model');

        $this->data['roles'] = $this->Roles_model->get_dropdown();
        $this->data['groups'] = $this->Groups_model->get_dropdown();
		$this->data['content'] = 'admin/'.$this->cont.'/create_v';
		$this->load->view('admin/layouts/page',$this->data);

    }

    public function edit($id)
    {
        $this->form_validation->set_rules('role_id',"Role", 'trim|required');
		$this->form_validation->set_rules('departemen_id',"Departemen", 'trim|required');
        $this->form_validation->set_rules('sequence',"Urutan", 'trim|required');

		if ($this->form_validation->run() === TRUE)
		{
            $data = array(
                'role_id'          => $this->input->post('role_id'),
                //'departemen_id'   => $this->input->post('departemen_id'),
                'sequence'   => $this->input->post('sequence'),
			);

			$id = $this->input->post('id');

            $data_lama = $this->model->getOneBy(['id' => $id]);
            if($data_lama->sequence != $this->input->post('sequence'))
            {

            }

			$update = $this->model->update($data, ['id' => $id]);


			if ($update === FALSE)
			{
                $this->session->set_flashdata('message_error', "Departemen approval gagal diubah");
                redirect($this->cont,"refresh");
			}else{
                $this->session->set_flashdata('message', "Departemen approval berhasil diubah");
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
                if($data === FALSE)
                {
                    redirect($this->cont);
                }

                $this->data['data'] = $data;

                $this->load->model('Roles_model');
                $this->load->model('Groups_model');

                $this->data['roles'] = $this->Roles_model->get_dropdown();
                $this->data['groups'] = $this->Groups_model->get_dropdown();

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
