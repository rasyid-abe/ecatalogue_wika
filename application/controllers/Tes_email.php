<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tes_email extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('email');
	}
	
	public function index()
	{

		$config = array(
                        'protocol' => 'smtp',
                        'smtp_host' => 'mail.wika.co.id',
                        'smtp_port' => '25',
                        'smtp_user' => '',
                        'smtp_pass' => '',
                        'mailtype' => 'html',
                        'mail_charset' => 'iso-8859-1',
                        'newline' => "\r\n",
                        'mail_timeout' => '4',
                        'wordwrap' => TRUE,
                        'dsn' => TRUE,
                        'validate' => FALSE,
                        'priority' => '5'
                );
				$this->load->library('email');
				$this->email->initialize($config);
				$this->email->set_newline("\r\n");

				// Set to, from, message, etc.
				$this->email->from('ecatalogue@wika.co.id', 'SCM');
		        
$this->email->to('latief.setiawan@wika.co.id,genta.yudaswara@gmail.com,tituswahyu@gmail.com'); 
		        $this->email->subject('TEST EMAIL');
		        $this->email->message("
protocol => smtp,
                        smtp_host => mail.wika.co.id,
                        smtp_port => 25,
                        smtp_user => ,
                        smtp_pass => ,
                        mailtype => html,
                        mail_charset => iso-8859-1,
                        newline => \r\n,
                        mail_timeout => 4,
                        wordwrap => TRUE,
                        dsn => TRUE,
                        validate => FALSE,
                        priority => 5



"); 
				if ($this->email->send())
				{
					echo "Success";
					echo "

                        protocol => smtp,
                        smtp_host => mail.wika.co.id,
                        smtp_port => 25,
                        smtp_user => ,
                        smtp_pass => ,
                        mailtype => html,
                        mail_charset => iso-8859-1,
                        newline => \r\n,
                        mail_timeout => 4,
                        wordwrap => TRUE,
                        dsn => TRUE,
                        validate => FALSE,
                        priority => 5
       

";
					echo $this->email->print_debugger();
				}
				else
				{
					 echo $this->email->print_debugger();
				}

		
	}
}
