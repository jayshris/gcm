<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\StateModel;
use App\Models\OfficeModel;
use App\Models\ProfileModel;
use App\Models\VehicleModel;
use App\Models\BookingsModel; 
use App\Controllers\BaseController;
use App\Models\LoadingReceiptModel;
use CodeIgniter\HTTP\ResponseInterface;

class Consignmentnote extends BaseController
{ 
    public $OModel;
    public $BookingsModel;
    public $VModel;
    public $LoadingReceiptModel;
    public $session;
    public $profile;
  
    public function __construct()
    {
      $u = new UserModel(); 
      $this->OModel = new OfficeModel();
      $this->BookingsModel = new BookingsModel();
      $this->VModel = new VehicleModel();
      $this->LoadingReceiptModel = new LoadingReceiptModel();
      $this->session = \Config\Services::session();
      $this->profile = new ProfileModel();
    }
  
    public function index()
    {        
      $this->view['bookings'] = $this->LoadingReceiptModel->select('b.id,b.booking_number')
      ->join('bookings b','loading_receipts.booking_id = b.id')
      ->where('loading_receipts.approved',1)
      ->orderBy('loading_receipts.id', 'desc')->groupBy('loading_receipts.booking_id')->findAll();  
  
      $this->view['rc_number'] =  $this->LoadingReceiptModel->select('v.id,v.rc_number') 
      ->join('vehicle v','loading_receipts.vehicle_id = v.id')
      ->where('loading_receipts.approved',1)
      ->orderBy('loading_receipts.id', 'desc')->groupBy('v.id')->findAll();
      // echo '<pre>';print_r( $this->view['rc_number']);exit;
  
     $this->LoadingReceiptModel->select('loading_receipts.*,b.booking_number,o.name branch_name')
      ->join('bookings b','loading_receipts.booking_id = b.id')
      ->join('office o','loading_receipts.office_id = o.id');
  
      if($this->request->getPost('booking_id')){
        $this->LoadingReceiptModel->where('b.id',$this->request->getPost('booking_id'));
      }  
      if($this->request->getPost('vehicle_id')){
        $this->LoadingReceiptModel->where('b.vehicle_id',$this->request->getPost('vehicle_id'));
      } 
  
      $this->view['loading_receipts'] = $this->LoadingReceiptModel->where('loading_receipts.approved',1)->orderBy('id', 'desc')->findAll();
      $db = \Config\Database::connect();  
      //     echo  $db->getLastQuery()->getQuery();  
      // echo 'sdf<pre>';print_r($this->request->getPost());
      // echo 'sdf<pre>';print_r($this->view['loading_receipts']);exit;
      return view('ConsignmentNote/index', $this->view); 
    } 
  
    function preview($id){  
      $this->view['lr'] = $this->LoadingReceiptModel
      ->select('loading_receipts.*,b.booking_number,o.name branch_name,v.rc_number,s.state_name consignor_state,s2.state_name consignee_state,
      s3.state_name place_of_delivery_state,s4.state_name place_of_dispatch_state  ,party.party_name as customer,b.booking_date,bd.city bd_city,
      bp.city bp_city,p.party_name as bill_to_party_nm,c.address as bill_to_address,c.phone bill_to_phone,
      CONCAT_WS(",", consignee_address,consignee_city,s2.state_name,consignee_pincode) consignee_address_f,
      CONCAT_WS(",", consignor_address,consignor_city,s.state_name,consignor_pincode) consignor_address_f,
      CONCAT_WS(",", place_of_delivery_address,place_of_delivery_city,s3.state_name,place_of_delivery_pincode) place_of_delivery_pincode_f ,
      CONCAT_WS(",", place_of_dispatch_address,place_of_dispatch_city,s4.state_name,place_of_dispatch_pincode) place_of_dispatch_address_f,
      ')
      ->join('bookings b','loading_receipts.booking_id = b.id')
      ->join('vehicle v','loading_receipts.vehicle_id = v.id','left')
      ->join('office o','loading_receipts.office_id = o.id','left')
      ->join('states s','loading_receipts.consignor_state = s.state_id','left')
      ->join('states s2','loading_receipts.consignee_state = s2.state_id','left')
      ->join('states s3','loading_receipts.place_of_delivery_state = s3.state_id','left')
      ->join('states s4','loading_receipts.place_of_dispatch_state = s4.state_id','left')
      ->join('customer cust', 'cust.id = b.customer_id','left')
      ->join('party', 'party.id = cust.party_id','left')
      ->join('customer c', 'c.id = b.bill_to_party','left')
      ->join('party p', 'p.id = c.party_id','left')
      ->join('booking_drops bd','bd.booking_id = b.id','left')
      ->join('booking_pickups bp','bp.booking_id = b.id','left')
      ->where(['loading_receipts.id' => $id])->first();
  
        
      // echo 'sdf<pre>';print_r($this->view['lr']);exit;
      return view('ConsignmentNote/preview', $this->view); 
    }
  }
