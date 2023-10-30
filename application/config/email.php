<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$config['email_config'] = array(
			'mail_protocol' => 'smtp',
			'mail_host' => 'mail.scmwika.com',
			'mail_port' => '26',
			'mail_user' => 'ecatalogue@scmwika.com',
			'mail_pass' => 'wika123',
			'mailtype' => 'html',
			'mail_charset' => 'iso-8859-1',
			'newline' => "\r\n",
			'mail_timeout' => '4',
			'wordwrap' => TRUE,
			'dsn' => TRUE,
			'validate' => FALSE,
			'priority' => '5'
		);
$config['email_sender']	= 'ecatalogue@scmwika.com';


//'smtp_host' => '192.168.75.252',
