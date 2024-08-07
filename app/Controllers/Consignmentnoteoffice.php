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

class Consignmentnoteoffice extends BaseController
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
    $this->view['bookings'] = $this->LoadingReceiptModel->select('loading_receipts.id,b.booking_number')
    ->join('bookings b','loading_receipts.booking_id = b.id')->orderBy('loading_receipts.id', 'desc')->findAll();  

    $this->view['rc_number'] =  $this->LoadingReceiptModel->select('v.id,v.rc_number') 
    ->join('vehicle v','loading_receipts.vehicle_id = v.id')->orderBy('loading_receipts.id', 'desc')->findAll();
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

    $this->view['loading_receipts'] = $this->LoadingReceiptModel->orderBy('id', 'desc')->findAll();

    return view('ConsignmentNoteOfficialUse/index', $this->view); 
  } 

  function preview($id){  
    $this->view['lr'] = $this->LoadingReceiptModel
    ->select('loading_receipts.*,b.booking_number,o.name branch_name,v.rc_number,s.state_name consignor_state,s2.state_name consignee_state,s3.state_name place_of_delivery_state,s4.state_name place_of_dispatch_state  ,party.party_name as customer,b.booking_date,bd.city bd_city,bp.city bp_city')
    ->join('bookings b','loading_receipts.booking_id = b.id')
    ->join('vehicle v','loading_receipts.vehicle_id = v.id')
    ->join('office o','loading_receipts.office_id = o.id')
    ->join('states s','loading_receipts.consignor_state = s.state_id')
    ->join('states s2','loading_receipts.consignee_state = s2.state_id')
    ->join('states s3','loading_receipts.place_of_delivery_state = s3.state_id')
    ->join('states s4','loading_receipts.place_of_dispatch_state = s4.state_id')
    ->join('customer cust', 'cust.id = b.customer_id','left')
    ->join('party', 'party.id = cust.party_id','left')
    ->join('booking_drops bd','bd.booking_id = b.id')
    ->join('booking_pickups bp','bp.booking_id = b.id')
    ->where(['loading_receipts.id' => $id])->first();

      
    echo '<pre>';print_r($this->view['lr']);exit;
    return view('ConsignmentNoteOfficialUse/preview', $this->view); 
  }
}
