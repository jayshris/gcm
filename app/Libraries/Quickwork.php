<?php
namespace App\Libraries;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Quickwork
{
	public $mode    = "0"; //0=>Test, 1=>Live
	public $apiUrl	= '';
	public $apiKey	= '';
	
	public function __construct() {
		$this->apiUrl  	= ($this->mode==1) ? 'https://apim.quickwork.co/ayyub/truckerp/v1' : 'https://apim.quickwork.co/ayyub/truckerp/v1';
		$this->apiKey  	= ($this->mode==1) ? 'O7luZdWhBckG3vU3cSXbSL1BqFnl4isf' : 'O7luZdWhBckG3vU3cSXbSL1BqFnl4isf';
	}
	
	public function verifyGST($gstno='19AAFCT0170J2Z8'){
		$post = '{
		    "kycIdentifierInput": "'.$gstno.'",
		    "kycType": "GSTIN"
		}';
		
		$resp = $this->callAPI('/verifykyc',$post);//echo 'GST Number: '.$gstno.'<br><pre>';print_r($resp);die;
		return $resp;
		if(!empty($resp) && $resp['code']==200){
			$gst  = isset($resp['resp']) ? $resp['resp'] : (object)[];
			$code = isset($resp['code']) ? ['code'=>$resp['code']] : ['code'=>'301'];//print_r($code);print_r((array)$gst);die;
			//$rows = (object) array_merge($code, (array) $gst);
			return $rows;
		}
		return (object)['code'=>'301', 'msg'=>'Invalid'];
	}

	public function sendNotificationOnWhatsapp($data=[]){
		$countryCode 	= '91';
		$recipientNumber= (isset($data['recipientNumber']) && !empty($data['recipientNumber'])) ? $data['recipientNumber'] : '7678569100';
		$template 		= (isset($data['template']) && !empty($data['template'])) ? $data['template'] : '1';
		$recipientName 	= (isset($data['recipientName']) && !empty($data['recipientName'])) ? $data['recipientName'] : 'Kishore';
		
		$post = '{
		    "recipientNumber": "'.$recipientNumber.'",
		    "countryCode": "'.$countryCode.'",
		    "template": "'.$template.'",
		    "recipientName": "'.$recipientName.'"
		}';
		
		$resp = $this->callAPI('/sendnotification',$post);//echo '<pre>';print_r($resp);die;
		return $resp;
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
		$header = array(
            'Content-Type: application/json; charset=utf-8',
            'apikey: '.$this->apiKey
        );
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		
		$response = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$curlError= curl_error($ch);
		if(curl_errno($ch)){
			echo "HTTP Error: " . $httpcode.'<br>';
			echo 'Request Error: ' . curl_error($ch); die;
		}
		curl_close($ch);
		return json_decode($response);//['code'=>$httpcode,'resp'=>json_decode($response)];		
		//return ['code'=>$httpcode,'resp'=>json_decode($response),'API-ENDPOINT'=>$apiEndpoint,'POSTDATA'=>$post,'HEADER'=>$header,'ERROR'=>$curlError];
	}
}
