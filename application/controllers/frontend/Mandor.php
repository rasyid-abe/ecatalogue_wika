<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mandor extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
    }

    public function index()
    {
        $this->form_validation->set_rules('nama_lengkap','Nama Lengkap','trim|required', ['required' => 'Nama lengkap harus diisi']);
        $this->form_validation->set_rules('no_identitas','No Identitas','trim|required',['required' => 'No Identitas harus diisi']);
        $this->form_validation->set_rules('alamat','Alamat','trim|required',['required' => 'Alamat harus diisi']);
        $this->form_validation->set_rules('lokasi','Lokasi','trim|required',['required' => 'Lokasi harus diisi']);
        $this->form_validation->set_rules('username','Username','trim|required|is_unique[users.username]',['required' => 'Username harus diisi', 'is_unique' => 'Username sudah digunakan']);
        $this->form_validation->set_rules('password','Password','trim|required|min_length[8]',['required' => 'Password harus diisi', 'min_length' => 'Minimal 8']);
        $this->form_validation->set_rules('password_confirm','Password Konfirmasi','trim|required|min_length[8]|matches[password]',['required' => 'Password harus diisi', 'min_length' => 'Minimal 8', 'matches' => 'password yang dimasukan tidak sama']);
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]',['required' => 'Email Harus diisi', 'valid_email' => 'Email harus valid', 'is_unique' => 'Email sudah digunakan']);


        if($this->form_validation->run() === TRUE)
        {

            if($this->input->post('pengalaman') == NULL)
            {
                $this->session->set_flashdata('message_error', 'Pengalaman harus diisi minimal 1');
                redirect('register/mandor');
            }

            $data_users = [
                'first_name' => $this->input->post('nama_lengkap'),
                'no_identity' => $this->input->post('no_identitas'),
                'address' => $this->input->post('alamat'),
                'city' => $this->input->post('lokasi'),
                'job' => $this->input->post('pekerjaan'),
                'harga' => $this->input->post('harga'),
                'ket_harga' => $this->input->post('ket_harga'),
                'is_deleted' => 0
            ];

            $insert = $this->ion_auth->register($this->input->post('username'),$this->input->post('password'),$this->input->post('email'),$data_users,[5]);


            if($insert === FALSE)
            {
                $this->session->set_flashdata('message_error', $this->ion_auth->errors());
                redirect('register/mandor');
            }
            else
            {
                $pengalaman = $this->input->post('pengalaman');
                $data = [];
                foreach($pengalaman as $v)
                {
                    $data[] = [
                        'users_id' => $insert,
                        'pengalaman' => $v,
                        'created_by' => $insert,
                    ];
                }
                $this->db->insert_batch('pengalaman_mandor', $data);

                $this->session->set_flashdata('message', 'Registrasi mandor berhasil');
                redirect('register/mandor');
            }
        }
        //$this->session->set_flashdata('message', 'OK cuy');
        $this->load->view('auth/register_mandor');
    }
}
