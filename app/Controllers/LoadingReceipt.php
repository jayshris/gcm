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

class LoadingReceipt extends BaseController
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
    $this->view['loading_receipts'] = $this->LoadingReceiptModel->select('loading_receipts.*,b.booking_number,o.name branch_name')
    ->join('bookings b','loading_receipts.booking_id = b.id')
    ->join('office o','loading_receipts.office_id = o.id')
    ->orderBy('id', 'desc')->findAll();
    return view('LoadingReceipt/index', $this->view); 
  } 

  function create(){  
    $stateModel = new StateModel();
    $this->view['states'] = $stateModel->where(['isStatus' => '1'])->orderBy('state_name', 'ASC')->findAll();
    $this->view['offices'] = $this->OModel->where('status', '1')->findAll();
    $this->view['bookings'] = $this->BookingsModel->where('status', '1')->findAll();
    $this->view['vehicles'] = $this->VModel->where('status', 1)->findAll();
    if($this->request->getPost()){
      $error = $this->validate([
        'booking_id'   =>  'required',  
        'loading_station'   =>  'required', 
        'delivery_station'   =>  'required', 
        'consignment_date'   =>  'required', 
        'consignor_name'   =>  'required', 
        'consignor_address'   =>  'required', 
        'consignor_city'   =>  'required', 
        'consignor_state'   =>  'required', 
        'consignor_pincode'   =>  'required', 
        'consignor_GSTIN'   =>  'required',  
        'consignee_name'   =>  'required', 
        'consignee_address'   =>  'required',  
        'consignee_city'   =>  'required', 
        'consignee_state'   =>  'required', 
        'consignee_pincode'   =>  'required', 
        'consignee_GSTIN'   =>  'required',  
        'place_of_delivery_address'   =>  'required',  
        'place_of_delivery_city'   =>  'required', 
        'place_of_delivery_state'   =>  'required', 
        'place_of_delivery_pincode'   =>  'required', 
        'place_of_dispatch_address'   =>  'required',  
        'place_of_dispatch_city'   =>  'required', 
        'place_of_dispatch_state'   =>  'required', 
        'place_of_dispatch_pincode'   =>  'required', 
        'particulars'   =>  'required',  
        'hsn_code'   =>  'required', 
        'no_of_packages'   =>  'required', 
        'actual_weight'   =>  'required', 
        'charge_weight'   =>  'required',  
        'payment_terms'   =>  'required', 
        'e_way_bill_number'   =>  'required', 
        'e_way_expiry_date'   =>  'required', 
        'freight_charges_amount'   =>  'required', 
        'invoice_boe_no'   =>  'required',  
        'invoice_boe_date'   =>  'required', 
        'invoice_value'   =>  'required', 
        'reporting_datetime'   =>  'required', 
        'releasing_datetime'   =>  'required',
        'policy_date'   =>  'required', 
        'policy_no'   =>  'required',
      ]); 
      $validation = \Config\Services::validation();
      // echo 'POst dt<pre>';print_r($this->request->getPost());
      // echo 'getErrors<pre>';print_r($validation->getErrors());//exit;

      if (!$error) {
        $this->view['error']   = $this->validator;
      } else {
        $booking = $this->BookingsModel->where('id', $this->request->getVar('booking_id'))->first();
       
        //create consignment_no
        $profile =  $this->profile->select('loading_receipt_prefix')->where('logged_in_userid',  session()->get('id'))->first();//echo __LINE__.'<pre>';print_r($profile);//die;
        $last_lr = $this->LoadingReceiptModel->orderBy('id', 'desc')->first();
        $lastlr = isset($last_lr['id']) ? ((int)$last_lr['id']+1) : 1;
        $consignment_no = isset($profile['loading_receipt_prefix']) ? $profile['loading_receipt_prefix'].'/'.$lastlr : 'LR/'.$lastlr;
        // echo $consignment_no.'<pre>';print_r($last_lr);die;

        $data = [
          'consignment_no' => $consignment_no,
          'booking_id'   =>  $this->request->getVar('booking_id'), 
          'office_id'   =>  $booking['office_id'],
          'booking_date'   => $booking['booking_date'],
          'vehicle_id'   =>  $booking['vehicle_id'],
          'loading_station'   =>  $this->request->getVar('loading_station'),
          'delivery_station'   =>  $this->request->getVar('delivery_station'),
          'consignment_date'   =>  $this->request->getVar('consignment_date'),
          'consignor_name'   =>  $this->request->getVar('consignor_name'),
          'consignor_address'   =>  $this->request->getVar('consignor_address'),
          'consignor_city'   =>  $this->request->getVar('consignor_city'),
          'consignor_state'   =>  $this->request->getVar('consignor_state'),
          'consignor_pincode'   =>  $this->request->getVar('consignor_pincode'),
          'consignor_GSTIN'   =>  $this->request->getVar('consignor_GSTIN'),
          'consignee_name'   =>  $this->request->getVar('consignee_name'),
          'consignee_address'   =>  $this->request->getVar('consignee_address'), 
          'consignee_city'   =>  $this->request->getVar('consignee_city'),
          'consignee_state'   =>  $this->request->getVar('consignee_state'),
          'consignee_pincode'   =>  $this->request->getVar('consignee_pincode'),
          'consignee_GSTIN'   =>  $this->request->getVar('consignee_GSTIN'),
          'place_of_delivery_address'   =>  $this->request->getVar('place_of_delivery_address'),
          'place_of_delivery_city'   =>  $this->request->getVar('place_of_delivery_city'),
          'place_of_delivery_state'   =>  $this->request->getVar('place_of_delivery_state'),
          'place_of_delivery_pincode'   =>  $this->request->getVar('place_of_delivery_pincode'),
          'place_of_dispatch_address'   =>  $this->request->getVar('place_of_dispatch_address'), 
          'place_of_dispatch_city'   =>  $this->request->getVar('place_of_dispatch_city'),
          'place_of_dispatch_state'   =>  $this->request->getVar('place_of_dispatch_state'),
          'place_of_dispatch_pincode'   =>  $this->request->getVar('place_of_dispatch_pincode'),
          'particulars'   =>  $this->request->getVar('particulars'), 
          'hsn_code'   =>  $this->request->getVar('hsn_code'),
          'no_of_packages'   =>  $this->request->getVar('no_of_packages'),
          'actual_weight'   =>  $this->request->getVar('actual_weight'),
          'charge_weight'   =>  $this->request->getVar('charge_weight'), 
          'payment_terms'   =>  $this->request->getVar('payment_terms'),
          'e_way_bill_number'   =>  $this->request->getVar('e_way_bill_number'),
          'e_way_expiry_date'   =>  $this->request->getVar('e_way_expiry_date'),
          'freight_charges_amount'   =>  $this->request->getVar('freight_charges_amount'),
          'invoice_boe_no'   =>  $this->request->getVar('invoice_boe_no'), 
          'invoice_boe_date'   =>  $this->request->getVar('invoice_boe_date'),
          'invoice_value'   =>  $this->request->getVar('invoice_value'),
          'reporting_datetime'   =>  $this->request->getVar('reporting_datetime'),
          'releasing_datetime'   =>  $this->request->getVar('releasing_datetime'),
          'policy_date'   =>  $this->request->getVar('policy_date'),
          'policy_no'   =>  $this->request->getVar('policy_no'),
        ];

        $this->LoadingReceiptModel->save($data); 
        // echo 'data<pre>';print_r($data);exit;
        $this->session->setFlashdata('success', 'Loading Receipt Added Successfully');

        return $this->response->redirect(base_url('/loadingreceipt'));
      }
    }
    return view('LoadingReceipt/create', $this->view); 
  }

  function edit($id){  
    $stateModel = new StateModel();
    $this->view['loading_receipts'] = $this->LoadingReceiptModel->where(['id' => $id])->first();
    $this->view['states'] = $stateModel->where(['isStatus' => '1'])->orderBy('state_name', 'ASC')->findAll();
    $this->view['offices'] = $this->OModel->where('status', '1')->findAll();
    $this->view['bookings'] = $this->BookingsModel->where('status', '1')->findAll();
    $this->view['vehicles'] = $this->VModel->where('status', 1)->findAll();
    // echo '<pre>';print_r($this->view['loading_receipts']);exit;
    if($this->request->getPost()){
      $error = $this->validate([
        'booking_id'   =>  'required',  
        'loading_station'   =>  'required', 
        'delivery_station'   =>  'required', 
        'consignment_date'   =>  'required', 
        'consignor_name'   =>  'required', 
        'consignor_address'   =>  'required', 
        'consignor_city'   =>  'required', 
        'consignor_state'   =>  'required', 
        'consignor_pincode'   =>  'required', 
        'consignor_GSTIN'   =>  'required',  
        'consignee_name'   =>  'required', 
        'consignee_address'   =>  'required',  
        'consignee_city'   =>  'required', 
        'consignee_state'   =>  'required', 
        'consignee_pincode'   =>  'required', 
        'consignee_GSTIN'   =>  'required',  
        'place_of_delivery_address'   =>  'required',  
        'place_of_delivery_city'   =>  'required', 
        'place_of_delivery_state'   =>  'required', 
        'place_of_delivery_pincode'   =>  'required', 
        'place_of_dispatch_address'   =>  'required',  
        'place_of_dispatch_city'   =>  'required', 
        'place_of_dispatch_state'   =>  'required', 
        'place_of_dispatch_pincode'   =>  'required', 
        'particulars'   =>  'required',  
        'hsn_code'   =>  'required', 
        'no_of_packages'   =>  'required', 
        'actual_weight'   =>  'required', 
        'charge_weight'   =>  'required',  
        'payment_terms'   =>  'required', 
        'e_way_bill_number'   =>  'required', 
        'e_way_expiry_date'   =>  'required', 
        'freight_charges_amount'   =>  'required', 
        'invoice_boe_no'   =>  'required',  
        'invoice_boe_date'   =>  'required', 
        'invoice_value'   =>  'required', 
        'reporting_datetime'   =>  'required', 
        'releasing_datetime'   =>  'required',
        'policy_date'   =>  'required', 
        'policy_no'   =>  'required',
      ]); 
      $validation = \Config\Services::validation();
      // echo 'POst dt<pre>';print_r($this->request->getPost());
      // echo 'getErrors<pre>';print_r($validation->getErrors());//exit;

      if (!$error) {
        $this->view['error']   = $this->validator;
      } else {
        $booking = $this->BookingsModel->where('id', $this->request->getVar('booking_id'))->first();
        $data = [ 
          'booking_id'   =>  $this->request->getVar('booking_id'), 
          'office_id'   =>  $booking['office_id'],
          'booking_date'   => $booking['booking_date'],
          'vehicle_id'   =>  $booking['vehicle_id'],
          'loading_station'   =>  $this->request->getVar('loading_station'),
          'delivery_station'   =>  $this->request->getVar('delivery_station'),
          'consignment_date'   =>  $this->request->getVar('consignment_date'),
          'consignor_name'   =>  $this->request->getVar('consignor_name'),
          'consignor_address'   =>  $this->request->getVar('consignor_address'),
          'consignor_city'   =>  $this->request->getVar('consignor_city'),
          'consignor_state'   =>  $this->request->getVar('consignor_state'),
          'consignor_pincode'   =>  $this->request->getVar('consignor_pincode'),
          'consignor_GSTIN'   =>  $this->request->getVar('consignor_GSTIN'),
          'consignee_name'   =>  $this->request->getVar('consignee_name'),
          'consignee_address'   =>  $this->request->getVar('consignee_address'), 
          'consignee_city'   =>  $this->request->getVar('consignee_city'),
          'consignee_state'   =>  $this->request->getVar('consignee_state'),
          'consignee_pincode'   =>  $this->request->getVar('consignee_pincode'),
          'consignee_GSTIN'   =>  $this->request->getVar('consignee_GSTIN'),
          'place_of_delivery_address'   =>  $this->request->getVar('place_of_delivery_address'),
          'place_of_delivery_city'   =>  $this->request->getVar('place_of_delivery_city'),
          'place_of_delivery_state'   =>  $this->request->getVar('place_of_delivery_state'),
          'place_of_delivery_pincode'   =>  $this->request->getVar('place_of_delivery_pincode'),
          'place_of_dispatch_address'   =>  $this->request->getVar('place_of_dispatch_address'), 
          'place_of_dispatch_city'   =>  $this->request->getVar('place_of_dispatch_city'),
          'place_of_dispatch_state'   =>  $this->request->getVar('place_of_dispatch_state'),
          'place_of_dispatch_pincode'   =>  $this->request->getVar('place_of_dispatch_pincode'),
          'particulars'   =>  $this->request->getVar('particulars'), 
          'hsn_code'   =>  $this->request->getVar('hsn_code'),
          'no_of_packages'   =>  $this->request->getVar('no_of_packages'),
          'actual_weight'   =>  $this->request->getVar('actual_weight'),
          'charge_weight'   =>  $this->request->getVar('charge_weight'), 
          'payment_terms'   =>  $this->request->getVar('payment_terms'),
          'e_way_bill_number'   =>  $this->request->getVar('e_way_bill_number'),
          'e_way_expiry_date'   =>  $this->request->getVar('e_way_expiry_date'),
          'freight_charges_amount'   =>  $this->request->getVar('freight_charges_amount'),
          'invoice_boe_no'   =>  $this->request->getVar('invoice_boe_no'), 
          'invoice_boe_date'   =>  $this->request->getVar('invoice_boe_date'),
          'invoice_value'   =>  $this->request->getVar('invoice_value'),
          'reporting_datetime'   =>  $this->request->getVar('reporting_datetime'),
          'releasing_datetime'   =>  $this->request->getVar('releasing_datetime'),
          'policy_date'   =>  $this->request->getVar('policy_date'),
          'policy_no'   =>  $this->request->getVar('policy_no'),
        ];

        $this->LoadingReceiptModel->update($id,$data); 
        // echo 'data<pre>';print_r($data);exit;
        $this->session->setFlashdata('success', 'Loading Receipt Updated Successfully');

        return $this->response->redirect(base_url('/loadingreceipt'));
      }
    }
    return view('LoadingReceipt/edit', $this->view); 
  }

  function getBookingDetails(){
    $rows =  $this->BookingsModel->where('id', $this->request->getPost('booking_id'))->first();
    echo json_encode($rows);exit;
  }

  public function delete($id = null)
  {  
    $this->LoadingReceiptModel->where('id', $id)->delete($id); 
    $this->session->setFlashdata('success', 'Loading receipt has been deleted successfully');
    return $this->response->redirect(base_url('/loadingreceipt')); 
  }

  function preview($id){
    $stateModel = new StateModel();
    $this->view['loading_receipts'] = $this->LoadingReceiptModel
    ->select('loading_receipts.*,b.booking_number,o.name branch_name,v.rc_number,s.state_name consignor_state,s2.state_name consignee_state,s3.state_name place_of_delivery_state,s4.state_name place_of_dispatch_state')
    ->join('bookings b','loading_receipts.booking_id = b.id')
    ->join('vehicle v','loading_receipts.vehicle_id = v.id')
    ->join('office o','loading_receipts.office_id = o.id')
    ->join('states s','loading_receipts.consignor_state = s.state_id')
    ->join('states s2','loading_receipts.consignee_state = s2.state_id')
    ->join('states s3','loading_receipts.place_of_delivery_state = s3.state_id')
    ->join('states s4','loading_receipts.place_of_dispatch_state = s4.state_id')
    ->where(['loading_receipts.id' => $id])->first();

    $this->view['states'] = $stateModel->where(['isStatus' => '1'])->orderBy('state_name', 'ASC')->findAll(); 
    // echo '<pre>';print_r($this->view['loading_receipts']);exit;
    return view('LoadingReceipt/preview', $this->view); 
  }
}
