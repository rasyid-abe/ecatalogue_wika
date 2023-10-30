<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require_once BASEPATH . 'vendor2/autoload.php';
class Email_po {
    protected $CI;

    protected $mail;

    public function __construct()
    {
        $this->CI = get_instance();
    }

    public function sendEmailPOToVendor($vendor_id, $order_no)
    {
        if ($vendor_id == '' || $order_no == '')
        {
            return FALSE;
        }

        $this->CI->load->model('User_model');
        $vendor = $this->CI->User_model->getOneBy(['users.vendor_id' => $vendor_id]);
        if ($vendor === FALSE)
        {
            return FALSE;
        }

        $ret = TRUE;
        $subject = 'PO di aplikasi eCatalogue WIKA';

        $content = $this->getHtmlPO($order_no);
        // nama_penerima_approva_wika_ecatalogue
        // untuk ganti nama penerima nya dengan nama user
        $content = str_replace('nama_penerima_approva_wika_ecatalogue', $vendor->first_name, $content);
        // klo localhost pake function yang bawah
        // $this->sendPhpMailer($value->email, $value->first_name, $subject, $content);
        // klo di hosting pake nya function yang bawah
        $ret = $this->sendEmailCI($vendor->email, $vendor->first_name, $subject, $content);

        return $ret;
    }

    public function sendDetailPOByRoleId($role_id = '', $order_no = '')
    {
        if ($role_id == '' || $order_no == '')
        {
            return FALSE;
        }

        $this->CI->load->model('User_model');
        $list_users = $this->CI->User_model->getAllById(['roles.id' => $role_id]);
        if ($list_users === FALSE)
        {
            return FALSE;
        }

        $ret = TRUE;
        $subject = 'Approval PO di aplikasi eCatalogue WIKA';
        foreach ($list_users as $key => $value)
        {
            $content = $this->getHtmlPO($order_no);
            // nama_penerima_approva_wika_ecatalogue
            // untuk ganti nama penerima nya dengan nama user
            $content = str_replace('nama_penerima_approva_wika_ecatalogue', $value->first_name, $content);
            // klo localhost pake function yang bawah
            // $this->sendPhpMailer($value->email, $value->first_name, $subject, $content);
            // klo di hosting pake nya function yang bawah
            $ret = $this->sendEmailCI($value->email, $value->first_name, $subject, $content);
        }
        return $ret;
    }

    private function getHtmlPO($order_no)
    {
        $this->CI->load->model('order_product_model');
        $this->CI->load->model('order_model');

        $data['order_product'] = $this->CI->order_product_model->getAllDataById(['order_product.order_no'=>$order_no]);
        $getapprovename = $this->CI->order_model->getapprovename(['order_no'=>$order_no]);
        $array_approval = [];
        if($getapprovename)
        {
            $index =0;
            foreach ($getapprovename as $key => $value) {
                $array_approval[$value->role_id]['approve_name'][$index] = $value->approval_name;
                if($value->updated_by){
                    $array_approval[$value->role_id]['approve_acc'][$index] = $value->approval_name;
                }
                $array_approval[$value->role_id]['user_approve_name'] = $value->user_approve_name;
                $array_approval[$value->role_id]['status_approve'] = $value->status_approve;
                $index++;
            }
        }

        if($data['order_product']){
            $data['order_no'] = $order_no;
            $data['detail_order'] = $this->CI->order_model->detail_order(['a.order_no' => $order_no]);
            $data['list_approval_name'] = $array_approval;
        }

        return $this->CI->load->view('admin/order/email_po', $data, TRUE);
    }

    public function sendEmailCI($email, $name, $subject, $content)
    {
        $this->CI->load->config('email');
        $email_config = $this->CI->config->item('email_config');
        $email_sender = $this->CI->config->item('email_sender');
        $this->CI->load->library(array('email'));
        $this->CI->email->initialize($email_config);

        $this->CI->email->clear();
        $this->CI->email->from($email_sender, "E-Catalogue");
        $this->CI->email->to($email);

        $this->CI->email->subject($subject);
        $this->CI->email->message($content);
        if ($this->CI->email->send())
        {
            //echo "Email Sent";
            // echo $CI->email->print_debugger();
            return TRUE;
        }
        else
        {
             //echo $CI->email->print_debugger();
             return FALSE;
        }
    }

    /*
    // uncomment jika dipake di localhost
    public function sendPhpMailer($email, $name, $subject, $content)
    {
        $this->settingPhpMailer();
        $this->mail->Subject = $subject;
        $this->mail->addAddress($email, $name);

        $this->mail->msgHTML($content);
        if (!$this->mail->send()) {
            return false;
        } else {
            return true;
        }
    }

    public function settingPhpMailer()
    {
        $this->CI->load->config('phpmailer_config');
        date_default_timezone_set('Asia/Jakarta');
        $this->mail = new PHPMailer\PHPMailer\PHPMailer();
        $this->mail->isSMTP();
        $this->mail->SMTPDebug = 0;
        $this->mail->Debugoutput = 'html';
        $this->mail->Host = $this->CI->config->item('smtp_server');
        $this->mail->Port = $this->CI->config->item('smtp_port');
        $this->mail->SMTPSecure = 'ssl';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $this->CI->config->item('smtp_username');
        $this->mail->Password = $this->CI->config->item('smtp_password');
        $this->mail->setFrom($this->CI->config->item('mail_noreply'), $this->CI->config->item('mail_signature'));

    }

    */
}
