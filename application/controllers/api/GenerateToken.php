<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/Base_Api_Controller.php';
class GenerateToken extends Base_Api_Controller
{
	public function __construct()
	{
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
	}

    public function index_post()
    {
        try {
            $this->load->library('encryption');
            $errors = array();
            $result = '';
            $data = $this->input->post();
            $username = $data['username'];
            $password = $data['password'];

            if (!isset($username) || !strlen($username))
				$errors['username'] =  'Username tidak boleh kosong';

			if (!isset($password) || !strlen($password))
				$errors['password'] =  'Password tidak boleh kosong';

            if (empty($errors)) {
                $check_account = $this->db->get_where('users', ['username' => $username]);

                if ($check_account->num_rows() > 0) {
                    $res = $check_account->row_array();

                    if (!$res['password']) {
                        $errors['password'] =  'Password salah, silahkan periksa kembali ';
                    } else {
                        if ($res['active'] > 0) {

                            $token_start = time();
                            $token_expired = strtotime(TOKEN_TIMEOUT, $token_start);

                            $payload = (object) array(
                                'username' => $username,
                                'password' => $res['password'],
                                'user_id' => $res['id'],
                                'token_start' => $token_start,
                                'token_expired' => $token_expired,
                            );

                            $token = $this->jwt->encode($payload, config_item('jwt_key'));

                            $upd = [
                                'f_api_token' => $token,
                            ];

                            $this->db->where('username', $username);
                            $update = $this->db->update('users', $upd);

                            if ($update) {
                                $result = [
                                    'username' => $username,
                                    'token' => $token,
                                ];
                            } else {
                                $errors['generate'] = 'Gagal generate token. ';
                            }

                        } else {
                            $errors['aktif'] =  'Akun anda tidak aktif, silahkan hubungi admin. ';
                        }
                    }
                } else {
                    $errors['username'] =  'Username tidak terdaftar, silahkan periksa kembali';
                }
            }

            if (!empty($errors)) {
                $this->app_error(
    				REST_Controller::HTTP_BAD_REQUEST,
    				array(
                        'status' => false,
                        'errors' => $errors,
    					'type' => 'invalidParameter',
    				)
    			);
            } else {
                $this->response([
    				'status' => true,
    				'data' => $result,
    			], REST_Controller::HTTP_OK);
            }
        } catch (Exception $e) {
            $this->app_error(
				REST_Controller::HTTP_BAD_REQUEST,
				array(
                    'status' => false,
					'type' => 'invalidParameter',
				)
			);
        }

    }
}
