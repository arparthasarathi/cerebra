<?php
if(!(defined('BASEPATH')))exit('No direct script access');
Class Testcont extends CI_Controller
{
	public function index()
	{
		echo "hi";
	}
	/*$config['smtp_host']='smtp.gmail.com';
	$config['user']='sureshprasanna70@gmail.com';
	$config['pass']='9443892889';
	$config['protocol']='smtp';
	$config['port']=465;
	$config['wordwrap']=TRUE;

	$this->load->library('email',$config);
	$this->email->from("sureshprasanna70@gmail.com");
	$this->email->to("sureshprasanna70@gmail.com");
	$this->email->subject('Hey buddy');
	$this->email->message('Hey buddy');
	$this->email->send();*/
	/*$config = Array('smtp_user' => 'sureshprasanna70',
                'smtp_pass' => '9443892889',
                'protocol'=> 'smtp',
                'smtp_host'=> 'smtp.googlemail.com',
                'smtp_port'=> '465',
                'smtp_timeout'=>'30',
                'charset'=> 'utf-8',
                'newline'=>"\r\n");
$CI = &get_instance();
$CI->load->library('email', $config);
$CI->email->from('yourmail@gmail.com', "yourname");
$CI->email->to($emailData['to']);
$CI->email->subject($emailData['subject']);
$CI->email->message($emailData['message']);
try{
    $CI->email->send();
}catch(Exception $e){
    echo $e->getMessage();
}*/
public function sendemail()
{
/*$config = Array(
  'protocol' => 'smtp',
  'smtp_host' => 'smtp.googlemail.com',
  'smtp_port' => 465,
  'smtp_timeout'=>'30',
  'smtp_user' => 'sureshprasanna70@yahoo.com',
  'smtp_pass' => '243363',
  'mailtype'  => 'html',
  'charset'   => 'iso-8859-1'
);
$this->load->helper('email');
$this->load->library('email', $config);
$this->email->set_newline("\r\n");

$this->email->from('admin@lalala.com','Title');
$this->email->to($this->input->post('email'));

$this->email->subject('Subject here');
$this->email->message('Your login username is ');

if (!$this->email->send()){
  show_error($this->email->print_debugger());
}
else
	{ 
		echo 'YEAH!!!';
	}*/
$ci = get_instance();
$ci->load->library('email');
$config['protocol'] = "smtp";
$config['smtp_host'] = "ssl://smtp.gmail.com";
$config['smtp_port'] = "465";
$config['smtp_user'] = "sureshprasanna70@gmail.com"; 
$config['smtp_pass'] = "9443892889";
$config['charset'] = "utf-8";
$config['mailtype'] = "html";
$config['newline'] = "\r\n";

$ci->email->initialize($config);

$ci->email->from('blablabla@gmail.com', 'Blabla');
$list = array('sureshprasanna70@gmail.com');
$ci->email->to($list);
$this->email->reply_to('my-email@gmail.com', 'Explendid Videos');
$ci->email->subject('This is an email test');
$ci->email->message('It is working. Great!');
$ci->email->send();
}
}