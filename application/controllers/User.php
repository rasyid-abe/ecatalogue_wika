<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class User extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('ion_auth_model');
	}
	public function index()
	{
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->load->model('Roles_model');
			$this->load->model('Groups_model');
			$this->data['roles'] = $this->Roles_model->get_dropdown(['is_deleted' => 0, 'id <>' => 1], NULL);
			$this->data['groups'] = $this->Groups_model->get_dropdown();
			$this->data['content'] = 'admin/user/list_v';
		} else {
			redirect('restrict');
		}

		$this->load->view('admin/layouts/page', $this->data);
	}


	public function create()
	{
		//	redirect('user');
		$this->form_validation->set_rules('email', "Email", 'trim|required');
		$this->form_validation->set_rules('name', "Nama", 'trim|required');
		$this->form_validation->set_rules('username', "Username", 'trim|required');
		$this->form_validation->set_rules('password', "Password", 'trim|required');
		$this->form_validation->set_rules('role_id', "Role", 'trim|required');
		// $this->form_validation->set_rules('departemen',"Departemen", 'trim|required');

		if ($this->form_validation->run() === TRUE) {

			$photo         = $this->input->post('photo');
			$location_path = "./assets/images/profile/";
			if (!is_dir($location_path)) {
				mkdir($location_path);
			}
			$uploaded      = uploadFile("photo" . $photo, $location_path, $this->input->post('name'));
			if ($uploaded['status'] == 1) {
				$data['photo'] = str_replace(' ', '_', $uploaded['message']);
			}
			$data = array(
				'first_name' => $this->input->post('name'),
				'address' => $this->input->post('address'),
				'active' => 1,
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'is_deleted' => 0,
				'group_id' => $this->input->post('departemen'),
			);
			$role = array($this->input->post('role_id'));
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$email = $this->input->post('email');
			$insert = $this->ion_auth->register($username, $password, $email, $data, $role);
			if ($insert) {
				$this->session->set_flashdata('message', "Pengurus Baru Berhasil Disimpan");
				redirect("user");
			} else {
				$this->session->set_flashdata('message_error', $this->ion_auth->errors());
				redirect("user");
			}
		} else {
			$this->load->model("roles_model");
			$this->data['roles'] = $this->roles_model->getAllById();

			$this->load->model('Groups_model');
			$this->data['groups'] = $this->Groups_model->getAllById();

			$this->data['content'] = 'admin/user/create_v';
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit($id)
	{
		redirect('user');
		$this->form_validation->set_rules('email', "Email", 'trim|required');
		$this->form_validation->set_rules('name', "Nama", 'trim|required');
		$this->form_validation->set_rules('role_id', "Role", 'trim|required');
		// $this->form_validation->set_rules('departemen',"Departemen", 'trim|required');
		$this->form_validation->set_rules('username', "Username", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'first_name' => $this->input->post('name'),
				'address' => $this->input->post('address'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'group_id' => $this->input->post('departemen'),
				'username' => $this->input->post('username'),
			);
			$photo         = $this->input->post('photo');
			$location_path = "./assets/images/profile/";
			if (!is_dir($location_path)) {
				mkdir($location_path);
			}
			$uploaded      = uploadFile("photo" . $photo, $location_path, $this->input->post('name'));
			if ($uploaded['status'] == 1) {
				$data['photo'] = str_replace(' ', '_', $uploaded['message']);
			}
			$user_id = $this->input->post('id');
			$update = $this->ion_auth->update($user_id, $data);
			if ($update) {
				$this->session->set_flashdata('message', "User Berhasil Diubah");
				redirect("user", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "User Gagal Diubah");
				redirect("user", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("user/edit/" . $id);
			} else {
				$this->data['id'] = $id;
				$data = $this->user_model->getOneBy(array("users.id" => $this->data['id']));

				$this->load->model('Groups_model');
				$this->data['groups'] = $this->Groups_model->getAllById();

				$this->load->model("roles_model");
				$this->data['roles'] = $this->roles_model->getAllBy(null, null, null, null, null);
				$this->data['first_name'] =   (!empty($data)) ? $data->first_name : "";
				$this->data['last_name'] =   (!empty($data)) ? $data->last_name : "";
				$this->data['username'] =   (!empty($data)) ? $data->username : "";
				$this->data['address'] =   (!empty($data)) ? $data->address : "";
				$this->data['email'] =   (!empty($data)) ? $data->email : "";
				$this->data['phone'] =   (!empty($data)) ? $data->phone : "";
				$this->data['role_id'] =   (!empty($data)) ? $data->role_id : "";
				$this->data['photo'] =   (!empty($data)) ? $data->photo : "";
				$this->data['group_id'] =   (!empty($data)) ? $data->group_id : "";
				$this->data['content'] = 'admin/user/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}
	}

	public function dataList()
	{
		$columns = array(
			0 => 'id',
			1 => 'role_name',
			2 => 'users.first_name',
			3 => 'users.phone',
			4 => 'users.email',
			5 => 'users.username',
			6 => 'action'
		);
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$where = array("roles.id >" => "1");
		$limit = 0;
		$start = 0;
		$totalData = $this->user_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);

		$searchColumn = $this->input->post('columns');
		$isSearchColumn = false;

		if (!empty($searchColumn[1]['search']['value'])) {
			$value = $searchColumn[1]['search']['value'];
			$isSearchColumn = true;
			$where['roles.id'] = $value;
		}

		if (!empty($searchColumn[2]['search']['value'])) {
			$value = $searchColumn[2]['search']['value'];
			$isSearchColumn = true;
			$where['users.group_id'] = $value;
		}

		if (!empty($searchColumn[3]['search']['value'])) {
			$value = $searchColumn[3]['search']['value'];
			$isSearchColumn = true;
			$search['users.first_name'] = $value;
		}

		if (!empty($searchColumn[4]['search']['value'])) {
			$value = $searchColumn[4]['search']['value'];
			$isSearchColumn = true;
			$search['users.phone'] = $value;
		}

		if (!empty($searchColumn[5]['search']['value'])) {
			$search_value = $searchColumn[5]['search']['value'];
			$isSearchColumn = true;
			$search = array(
				"users.email" => $search_value
			);
		}

		if ($isSearchColumn) {
			$totalFiltered = $this->user_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->user_model->getAllBy($limit, $start, $search, $order, $dir, $where);
		//die($this->db->last_query());
		$new_data = array();
		if (!empty($datas)) {
			foreach ($datas as $key => $data) {

				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "user/edit/" . $data->id . "' class='btn btn-sm btn-info'><i class='fa fa-pencil'></i> Ubah</a>";
				}
				if ($this->data['is_can_delete']) {
					if ($data->is_deleted == 0) {
						$delete_url = "<a href='#'
	        				url='" . base_url() . "user/destroy/" . $data->id . "/" . $data->is_deleted . "'
	        				class='btn btn-sm btn-danger delete' >NonAktifkan
	        				</a>";
					} else {
						$delete_url = "<a href='#'
	        				url='" . base_url() . "user/destroy/" . $data->id . "/" . $data->is_deleted . "'
	        				class='btn btn-sm btn-success delete'
	        				 >Aktifkan
	        				</a>";
					}
				}


				$nestedData['id'] = $start + $key + 1;
				$nestedData['role_name'] = $data->role_name;
				$nestedData['name'] = $data->first_name . ' ' . $data->last_name;
				$nestedData['phone'] = $data->phone;
				$nestedData['email'] = $data->email;
				$nestedData['username'] = $data->username;
				if (empty($data->photo)) {
					$nestedData['photo'] = '';
				} else {
					$photo = explode(".", $data->photo);
					$nestedData['photo'] = "<img width='40px' src=" . base_url() . "assets/images/profile/" . $data->photo . ">";
				}
				$nestedData['action'] = $delete_url;
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

	public function destroy()
	{
		$response_data = array();
		$response_data['status'] = false;
		$response_data['msg'] = "";
		$response_data['data'] = array();

		$id = $this->uri->segment(3);
		$is_deleted = $this->uri->segment(4);
		if (!empty($id)) {
			$this->load->model("user_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1
			);
			$update = $this->user_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}


	public function getUsersByGroupId()
	{
		$group_id = $this->input->post('group_id');

		$this->load->model('user_model');
		$users = $this->user_model->getAllById(['users.group_id' => $group_id]);

		if ($users) {
			$ret = array(
				'status' => true,
				'data'   => $users,
			);
		} else {
			$ret = array(
				'status' => false,
				'data'   => array(),
			);
		}

		echo json_encode($ret);
	}
}
