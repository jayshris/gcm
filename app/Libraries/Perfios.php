<?php
namespace App\Libraries;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Perfios
{
	public $mode    = "1"; //0=>Test, 1=>Live
	public $apiUrl	= '';
	public $apiKey	= '';
	protected $db;
	protected $router;
	public $session;
	public $loggedIn;
	
	public function __construct(){
		$this->router = \Config\Services::router();
		$session = \Config\Services::session();
		$this->loggedIn   = ($session->get('ACCESS')) ? $session->get('ACCESS') : 0;
		
		$this->db = \Config\Database::connect();
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'NO_ZERO_DATE', ''));");		

		$this->apiUrl  	= ($this->mode==1) ? 'https://hub.perfios.com/api' : 'https://uat-hub.perfios.com/api';
		$this->apiKey  	= ($this->mode==1) ? 'S2DCQOcE7QfAHOI' : 'il4IVPYp6kb90bgI';
	}

	public function verifyGST($gstno='19AAFCT0170J2Z8'){
		$sql = "SELECT *  FROM ".GST_DETAIL." WHERE gst_no='".$gstno."' ORDER BY id DESC LIMIT 1";
      	$qry = $this->db->query($sql);
      	$row = $qry->getRow();
		if(!empty($row)){
			return isset($row->gst_detail) ? $row->gst_detail : '';
		}
		else{
			$post = '{
			    "id": "'.$gstno.'",
			    "name": "",
			    "email": "",
			    "domain": "",
			    "address": "",
			    "contact": "",
			    "showAddressBucket": true
			}';
			
			$resp = $this->callAPI('/kscan/v3/gst-profile',$post);
			$sql = "INSERT INTO ".GST_DETAIL." SET gst_no='".$gstno."', gst_detail='".$resp."', added_by='".$this->loggedIn."', added_ip='".$_SERVER['REMOTE_ADDR']."'";
      		$this->db->query($sql);
			return $resp;
		}
	}

	public function ewayBill($data=[]){
		$billNo = isset($data['bill_no']) ? $data['bill_no'] : '761467011409';
		$billDate = (isset($data['bill_date']) && !empty($data['bill_date'])) ? date('d/m/Y',strtotime($data['bill_date'])) : '09/10/2024';
		$billGenerator = isset($data['bill_generator']) ? $data['bill_generator'] : '07AAGCG7930A1ZV';
		$documentNo = isset($data['doc_no']) ? $data['doc_no'] : 'GAE-0983/24-25';//echo __LINE__.'<pre>';print_r($data);die;
		
		$sql = "SELECT *  FROM ".EWAY_BILL." WHERE bill_no='".$billNo."' AND bill_date='".$billDate."' AND bill_generator='".$billGenerator."' AND doc_no='".$documentNo."' ORDER BY id DESC LIMIT 1";
      	$qry = $this->db->query($sql);
      	$row = $qry->getRow();
		if(!empty($row)){
			return isset($row->api_resp) ? $row->api_resp : '';
		}
		else{
			$post = '{
			    "consent": "Y",
			    "ewaybillNo": "'.$billNo.'",
			    "ewaybillDate": "'.$billDate.'",
			    "ewaybillGenerator": "'.$billGenerator.'",
			    "documentNo": "'.$documentNo.'",
			    "clientData":
			    {
			    	"caseId":"'.time().'"
			    }
			}';//echo __LINE__.'<pre>';print_r($post);print_r($data);die;
			
			$resp = $this->callAPI('/gst/v2/gst-ewaybill-slip',$post);
			$sql = "INSERT INTO ".EWAY_BILL." SET bill_no='".$billNo."', bill_date='".$billDate."', bill_generator='".$billGenerator."', doc_no='".$documentNo."', api_request='".$post."', api_resp='".$resp."', added_by='".$this->loggedIn."', added_ip='".$_SERVER['REMOTE_ADDR']."'";
      		$this->db->query($sql);
			return $resp;
		}
	}

	public function callAPI($endpoint, $post=''){
		$apiEndpoint = $this->apiUrl.$endpoint;
		$ch = curl_init();				
		curl_setopt($ch, CURLOPT_URL, $apiEndpoint);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, (!empty($post) ? 'POST' : 'GET'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		if(!empty($post)){
			$post = is_array($post) ? json_encode($post) : $post;
			curl_setopt($ch, CURLOPT_POST, 1 );
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}
		$header = [
            'Content-Type: application/json',
            'x-auth-key: '.$this->apiKey
        ];
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		
		$response = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$curlError= curl_error($ch);
		if(curl_errno($ch)){
			echo "HTTP Error: " . $httpcode.'<br>';
			echo 'Request Error: ' . curl_error($ch); die;
		}
		curl_close($ch);
		//if(!$response)	die('Error: "'. curl_error($ch). '" - Code: '. curl_errno($ch));//,'code'=>$httpcode
		return $response;
		return ['code'=>$httpcode,'response'=>json_decode($response),'API-ENDPOINT'=>$apiEndpoint,'POSTDATA'=>$post,'HEADER'=>$header,'ERROR'=>$curlError];
	}
}
