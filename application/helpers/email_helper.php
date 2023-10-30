<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('send_email_po'))
{
    function send_email_po($email, $filename, $order_no, $cc = [])
    {
        $CI = get_instance();

        // $CI->load->model('users_model');

        // $data['users'] = $CI->users_model->finddata(array("users.id"=>$user_id));
        // $email = $data['users']->email;
        $CI->load->config('email');
        $email_config = $CI->config->item('email_config');
        $email_sender = $CI->config->item('email_sender');
        $CI->load->library(array('email'));
        $CI->email->initialize($email_config);

        $message = "Berikut terlampir daftar barang yang dipesan";

        $CI->email->clear();
        $CI->email->from($email_sender, "E-Catalogue");
        $CI->email->to($email);

        if(!empty($cc))
        {
            $CI->email->cc(implode(',', $cc));
        }

        $CI->email->subject("WIKA - Confirm Order ".$order_no);
        $CI->email->message($message);
        $attched_file= $_SERVER["DOCUMENT_ROOT"]."/pdf/po/".$filename;
        // $attched_file= $_SERVER["DOCUMENT_ROOT"]."/assets/A.pdf";
        $CI->email->attach($attched_file);
        if ($CI->email->send())
        {
            return TRUE;
        }
        else
        {
             return FALSE;
        }
    }

    function cek_cc($email = 'agussobari.16@gmail.com', $cc = ['kreaseeme@gmail.com','agus.sobari@widyatama.ac.id'])
    {
        $CI = get_instance();

        // $CI->load->model('users_model');

        // $data['users'] = $CI->users_model->finddata(array("users.id"=>$user_id));
        // $email = $data['users']->email;
        $CI->load->config('email');
        $email_config = $CI->config->item('email_config');
        $email_sender = $CI->config->item('email_sender');
        $CI->load->library(array('email'));
        $CI->email->initialize($email_config);

        $message = "Berikut terlampir daftar barang yang dipesan";

        $CI->email->clear();
        $CI->email->from($email_sender, "E-Catalogue");
        $CI->email->to($email);

        if(!empty($cc))
        {
            $CI->email->cc(implode(',', $cc));
        }

        $CI->email->subject("WIKA - Confirm Order ");
        $CI->email->message($message);
        if ($CI->email->send())
        {
            //echo "Email Sent";
        }
        else
        {
             echo $CI->email->print_debugger();
        }
    }

}
