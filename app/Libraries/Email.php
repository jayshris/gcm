<?php
namespace App\Libraries;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Email
{
	protected $db;
	
	public function __construct() {
		$this->db = \Config\Database::connect();
	}

	public function sendEmail($data=array()){
		$this->load->library('email');
		$this->load->helper('email');
		$this->load->helper('path');
					
		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'gator3099.hostgator.com',
			'smtp_port' => 25,
			'smtp_user' => 'admin@aubrill.com',
			'smtp_pass' => '#9Ci@send$Email0',
			'mailtype' => 'html',
			'charset'  => 'utf-8',
			'wordwrap'=> TRUE,
			'priority' => '1',
			'protocol' => 'sendmail',
			'crlf' => "\r\n",
			'newline' => "\r\n"
		);
			
		$subject  = isset($data['subject']) ? $data['subject'] : 'Email from Aubade Tech';
		$message  = isset($data['message']) ? $data['message'] : 'Email from Aubade Tech';
		$receiver = isset($data['receiver']) ? $data['receiver'] : 'sumeet@aubade-tech.com';
		$filePath = isset($data['file_path']) ? $data['file_path'] : '';
		$fileName = isset($data['file_name']) ? $data['file_name'] : '';
		
		$this->email->initialize($config);
		$this->email->set_newline("\r\n");
		$this->email->from('contactus@aubade-tech.com','Aubade Tech');
		$this->email->to($receiver);
		//$this->email->cc('smehta1969@gmail.com'); 
		//$this->email->cc('sumeet@aubade-tech.com');  
		//$this->email->cc('kdjjps1@gmail.com');
		//$this->email->cc('sonal.sachdev@hcl.com'); 
		
		$this->email->subject($subject);
		$this->email->message($message);
		
		// This function will return a server path without symbolic links or relative directory structures.
		if(!empty($filePath) && !empty($fileName)) {
			$realPath = set_realpath($filePath);
			$this->email->attach($realPath.$fileName);
			//$attched_file= $_SERVER["DOCUMENT_ROOT"].$filePath.$fileName;
			//$this->email->attach($attched_file);
		}
		
		return ($this->email->send()) ? 1 : $this->email->print_debugger();
	}

	/*public function getParentControler(){
		$sql = "SELECT t2.module_controller FROM ".MODULE." t1 INNER JOIN ".MODULE." t2 ON t2.id=t1.parent_id WHERE t1.module_controller='".$this->viewData['currentController']."'";
		$query = $this->db->query($sql);
		$row = $query->getRow();//echo __LINE__.'<br>'.$sql.'<br><pre>';print_r($row);die;
		return !empty($row) ? $row->module_controller : '';
    }*/
}
