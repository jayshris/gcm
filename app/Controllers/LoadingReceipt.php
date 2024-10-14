<?php
namespace App\Controllers;

use App\Libraries\Common;
use App\Models\CityModel;
use App\Models\UserModel;
use App\Models\PartytypeModel;
use App\Models\PartyModel;
use App\Models\PartyDocumentsModel;
use App\Models\StateModel;
use App\Models\OfficeModel;
use App\Models\CountryModel;
use App\Models\ProfileModel;
use App\Models\VehicleModel;
use App\Models\BookingsModel; 
use App\Models\CustomersModel;
use App\Controllers\BaseController;
use App\Models\CustomerBranchModel;
use App\Models\LoadingReceiptModel;
use App\Models\ProformaInvoiceModel;
use App\Models\BookingVehicleLogModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\Perfios;

class LoadingReceipt extends BaseController
{ 
  public $OModel;
  public $BookingsModel;
  public $VModel;
  public $LoadingReceiptModel;
  public $session;
  public $profile;
  public $PModel;
  public $CustomersModel;
  public $PTModel;
  public $CustomerBranchModel;
  public $BVLModel;
  public $CountryModel;
  public $common;
  public $CityModel;
  public $ProformaInvoiceModel;
  public $email;
  public $StateModel;
  public function __construct()
  {
    $this->email = \Config\Services::email();

    $u = new UserModel(); 
    $this->OModel = new OfficeModel();
    $this->BookingsModel = new BookingsModel();
    $this->VModel = new VehicleModel();
    $this->LoadingReceiptModel = new LoadingReceiptModel();
    $this->session = \Config\Services::session();
    $this->profile = new ProfileModel();
    $this->PModel = new PartyModel();
    $this->CustomersModel = new CustomersModel();
    $this->PTModel = new PartytypeModel();
    $this->CustomerBranchModel = new CustomerBranchModel();
    $this->BVLModel = new BookingVehicleLogModel(); 
    
    $this->CountryModel = new CountryModel();
    $this->StateModel = new StateModel();
    $this->common = new Common();
    $this->CityModel = new CityModel();
    $this->ProformaInvoiceModel= new ProformaInvoiceModel();
  } 

  public function sendEmail(){
    $id = ($this->request->getPost('id')) && !empty($this->request->getPost('id')) ? $this->request->getPost('id') : '0';
    $fromName = 'GAE CARGO MOVERS PVT LTD';//($this->request->getPost('email_from')) && !empty($this->request->getPost('email_from')) ? $this->request->getPost('email_from') : 'GAE Group';
    $toEmail = ($this->request->getPost('email_to')) && !empty($this->request->getPost('email_to')) ? $this->request->getPost('email_to') : 'kishorejha.php@gmail.com';
    $subject = ($this->request->getPost('email_subject')) && !empty($this->request->getPost('email_subject')) ? $this->request->getPost('email_subject') : 'Loading Receipt of Consignment';
    $message = ($this->request->getPost('email_body')) && !empty($this->request->getPost('email_body')) ? $this->request->getPost('email_body') : 'PFA';

    $config['protocol']   = 'smtp';
    $config['SMTPHost']   = 'mail.aubade-tech.com';
    $config['SMTPPort']   = 465;
    $config['SMTPUser']   = 'booking@gaegroup.in';
    $config['SMTPPass']   = 'August@110321';
    $config['SMTPCrypto'] = 'ssl';
    $config['charset']    = 'utf-8';
    $config['mailType']   = 'html';
    $config['newline']    = "\r\n";

    $this->email->initialize($config);
    $this->email->setFrom('booking@gaegroup.in', $fromName);
    $this->email->setTo($toEmail);
    /*$this->email->setTo('kishorejha.php@gmail.com');
    $this->email->setCC('mehta00999@gmail.com');
    $this->email->setCC('sumeet@aubade-tech.com');
    $this->email->setCC('kishore@aubade-tech.com');*/
    // $this->email->setBCC('bcc@example.com');

    $this->email->setSubject($subject);
    $this->email->setMessage($message);
    $this->view['loading_receipts'] = $this->LoadingReceiptModel->where('id',$id)->first();
    $fileName = (isset($this->view['loading_receipts']['consignment_no']) && !empty($this->view['loading_receipts']['consignment_no'])) ? str_replace('/','_',$this->view['loading_receipts']['consignment_no']) : 'loading_receipt_'.$id;
    $filePath = 'public/uploads/loading_receipts/'.$fileName.'.pdf';
    $this->email->attach(FCPATH.$filePath, $fileName);
    //$pdf_path = FCPATH . 'public\uploads\LR-mail.pdf';
    //$this->email->attach($pdf_path, 'pdf_file.pdf', 'application/pdf');

    if ($this->email->send()) {
      //echo 'Email sent successfully';die;
      $session = \Config\Services::session();
      $session->setFlashdata('success', 'Email sent successfully!');
      return redirect()->to('/loadingreceipt/preview/'.$id);
    } else {
      //echo 'Error occured in sending email: ' . $this->email->printDebugger();die;
      $session = \Config\Services::session();
      $session->setFlashdata('error', 'Error occured in sending email: ' . $this->email->printDebugger());
      return redirect()->to('/loadingreceipt/preview/'.$id);
    }
  }

  public function index()
  {  
    $this->view['bookings'] = $this->BookingsModel->select('id,booking_number')     
                              ->where(['approved'=> '1','is_vehicle_assigned' => 1]) 
                              ->findAll(); 
                                      
    $this->view['vehicles'] =  $this->BookingsModel->select('v.id,v.rc_number') 
    ->join('vehicle v','bookings.vehicle_id = v.id')->orderBy('v.id', 'desc')
    ->where(['bookings.approved'=> '1','bookings.is_vehicle_assigned' => 1]) 
    ->groupBy('bookings.vehicle_id')
    ->findAll(); 

    $this->LoadingReceiptModel->select('loading_receipts.*,v.rc_number,b.booking_number,o.name branch_name')
    ->join('bookings b','loading_receipts.booking_id = b.id')
    ->join('vehicle v','v.id = loading_receipts.vehicle_id','left')
    ->join('office o','loading_receipts.office_id = o.id');

    if ($this->request->getPost('booking_id') > 0) {
        $this->LoadingReceiptModel->where('b.id', $this->request->getPost('booking_id'));
    }

    if ($this->request->getPost('vehicle_id') > 0) {
        $this->LoadingReceiptModel->where('v.id', $this->request->getPost('vehicle_id'));
    }

    $this->view['loading_receipts'] = $this->LoadingReceiptModel->orderBy('id', 'desc')->findAll();
    return view('LoadingReceipt/index', $this->view); 
  } 

  function create(){
    $this->view['countries'] = $this->CountryModel->where(['name'=>'India'])->findAll();
    $this->view['states'] = $this->StateModel->where(['isStatus' => '1'])->orderBy('state_name', 'ASC')->findAll();
    $this->view['offices'] = $this->OModel->where('status', '1')->findAll();
    $this->view['transport_offices'] = []; 
    $this->view['bookings'] = $this->BookingsModel    
                              ->where(['approved'=> '1','is_vehicle_assigned' => 1])
                              ->where('NOT EXISTS (SELECT 1 
                                            FROM   loading_receipts
                                            WHERE  loading_receipts.booking_id = bookings.id)')
                              ->findAll(); 
                                      
    $this->view['vehicles'] =  $this->BookingsModel->select('v.id,v.rc_number') 
    ->join('vehicle v','bookings.vehicle_id = v.id')->orderBy('v.id', 'desc')
    ->where(['bookings.approved'=> '1','bookings.is_vehicle_assigned' => 1])
    ->where('NOT EXISTS (SELECT 1  FROM   loading_receipts
                                            WHERE  loading_receipts.booking_id = bookings.id)')
    ->groupBy('bookings.vehicle_id')
    ->findAll(); 
    // $db = \Config\Database::connect();  
    //     echo  $db->getLastQuery()->getQuery(); 
            //  echo '  <pre>';print_r($this->view['bookings']);exit; 

    $this->view['consignors'] = $this->CustomersModel->select('party.party_name,customer.id,customer.party_type_id ')
    ->join('party', 'customer.party_id = party.id')
    ->where("FIND_IN_SET (8,customer.party_type_id)")
    ->orderBy('party.party_name')->findAll();

    $this->view['consignors']  = array_column($this->view['consignors'],'party_name','id');      
    
    $this->view['consignees'] = $this->CustomersModel->select('party.party_name,customer.id ')
    ->join('party', 'customer.party_id = party.id')
    ->where("FIND_IN_SET (9,customer.party_type_id)")
    ->orderBy('party.party_name')->findAll();  
    $this->view['consignees']  = array_column($this->view['consignees'],'party_name','id');
    // echo '<pre>';print_r( $this->view['consignees'] );exit;
    $party_type_ids = $this->PTModel->select("(GROUP_CONCAT(id)) party_type_ids") 
    ->where('lr_third_party', '1') 
    ->first(); 
     $party_type_ids = str_replace([',',', '],'|', $party_type_ids );
   
    $this->view['transporters'] = $this->CustomersModel->select('customer.id,party.party_name')
        ->join('party', 'party.id = customer.party_id')
        ->where('customer.status', '1')
        ->where('CONCAT(",", party_type_id, ",") REGEXP ",('.$party_type_ids['party_type_ids'].'),"')
        ->findAll();    

    $search = ($this->request->getVar('search')) ? $this->request->getVar('search') : false;
    if (($search)) {
      $this->view['loading_receipts']['bill_no'] = ($this->request->getVar('bill_no')) ? $this->request->getVar('bill_no') : '';
      $this->view['loading_receipts']['bill_date'] = ($this->request->getVar('bill_date')) ? $this->request->getVar('bill_date') : '';
      $this->view['loading_receipts']['bill_generator'] = ($this->request->getVar('bill_generator')) ? $this->request->getVar('bill_generator') : '';
      $this->view['loading_receipts']['doc_no'] = ($this->request->getVar('doc_no')) ? $this->request->getVar('doc_no') : '';
      
      if (!empty($this->view['loading_receipts']['bill_no']) && !empty($this->view['loading_receipts']['bill_date']) && !empty($this->view['loading_receipts']['bill_generator']) && !empty($this->view['loading_receipts']['doc_no'])) {
        $this->getEWayBill_Perfios($this->view['loading_receipts']);
      }
    }

    if($this->request->getPost()){
      $error = $this->validate([
        'booking_id'   =>  'required',  
        'loading_station'   =>  'required', 
        'delivery_station'   =>  'required', 
        'consignment_date'   =>  'required', 
        'consignor_name'   =>  'required', 
        'consignor_address'   =>  'required', 
        // 'consignor_city'   =>  'required', 
        // 'consignor_state'   =>  'required',  
        'consignee_name'   =>  'required', 
        'consignee_address'   =>  'required',  
        // 'consignee_city'   =>  'required', 
        // 'consignee_state'   =>  'required', 
        'place_of_delivery_address'   =>  'required',  
        'place_of_delivery_city'   =>  'required', 
        'place_of_delivery_state'   =>  'required', 
        'place_of_dispatch_address'   =>  'required',  
        'place_of_dispatch_city'   =>  'required', 
        'place_of_dispatch_state'   =>  'required', 
        'place_of_delivery_name'   =>   'required', 
        'place_of_dispatch_name'   =>   'required',  
      ]); 
      $validation = \Config\Services::validation(); 
      // echo 'POst dt<pre>';print_r($this->request->getPost());
      // echo 'getErrors<pre>';print_r($validation->getErrors());exit;

      if (!$error) {
        $this->view['error']   = $this->validator;
      } else {
        $booking = $this->BookingsModel->where('id', $this->request->getVar('booking_id'))->first();
       
        //create consignment_no
        $logId = '1';//session()->get('id');
        $profile =  $this->profile->select('loading_receipt_prefix')->where('logged_in_userid',  $logId)->first();
        $last_lr = $this->LoadingReceiptModel->orderBy('id', 'desc')->first();
        // $lastlr = isset($last_lr['id']) ? ((int)$last_lr['id']+1) : 1;

        //change: consignment_no start from 1014 , 1015...        
        $lastlrId = isset($last_lr['id']) && ($last_lr['id'] >0) ? $last_lr['id'] : 0;
        $lastconsignment_no = isset($last_lr['consignment_no']) && ($last_lr['consignment_no'] != '') ? substr($last_lr['consignment_no'] , -4) : 0; 
        $newConsignmentNo = ($lastlrId > 0) ?  ((int)$lastconsignment_no +1) : 1014;
         
        $consignment_no = isset($profile['loading_receipt_prefix'])  && !empty($profile['loading_receipt_prefix']) ? $profile['loading_receipt_prefix'].'/'.$newConsignmentNo : 'LR/'.$newConsignmentNo;
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
          'place_of_delivery_name'   =>  $this->request->getVar('place_of_delivery_name'),
          'place_of_delivery_pincode'   =>  $this->request->getVar('place_of_delivery_pincode'),
          'place_of_dispatch_address'   =>  $this->request->getVar('place_of_dispatch_address'), 
          'place_of_dispatch_city'   =>  $this->request->getVar('place_of_dispatch_city'),
          'place_of_dispatch_state'   =>  $this->request->getVar('place_of_dispatch_state'),
          'place_of_dispatch_pincode'   =>  $this->request->getVar('place_of_dispatch_pincode'),
          'place_of_dispatch_name'   =>  $this->request->getVar('place_of_dispatch_name'),
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
          'added_by' => isset($_SESSION['id']) ? $_SESSION['id'] : '0',
          'consignor_id'   =>  $this->request->getVar('consignor_id'),
          'consignor_office'   =>  $this->request->getVar('consignor_office_id') ? $this->request->getVar('consignor_office_id') : '',
          'consignee_id'   =>  $this->request->getVar('consignee_id'),
          'consignee_office'   =>  $this->request->getVar('consignee_office_id') ? $this->request->getVar('consignee_office_id') : '',
          'customer_name'   =>  $this->request->getVar('customer_name'),
          'transporter_bilti_no'   =>  $this->request->getVar('transporter_bilti_no'),
          'transporter_id' =>  $this->request->getVar('transporter_id'),
          'transporter_office_id' =>  $this->request->getVar('transporter_office_id') ?  $this->request->getVar('transporter_office_id') : '',
          'transporter_address' =>  $this->request->getVar('transporter_address'),
          'transporter_city' =>  $this->request->getVar('transporter_city'),
          'transporter_state' =>  $this->request->getVar('transporter_state'),
          'transporter_pincode' =>  $this->request->getVar('transporter_pincode'),
          'transporter_GSTIN' =>  $this->request->getVar('transporter_GSTIN'),
          'seal_no' =>  $this->request->getVar('seal_no'),
          'supplier_office_id' => ( $this->request->getVar('supplier_office_id')) ? $this->request->getVar('supplier_office_id') : 0,
          'recipient_office_id' =>  ($this->request->getVar('recipient_office_id')) ? $this->request->getVar('recipient_office_id') : 0,
          'consignor_country_id'   =>  $this->request->getVar('consignor_country_id'),
          'consignee_country_id'   =>  $this->request->getVar('consignee_country_id'),
          'consignor_city_id'   =>  $this->request->getVar('consignor_city_id'),
          'consignee_city_id'   =>  $this->request->getVar('consignee_city_id'),
        ];

        // $this->LoadingReceiptModel->save($data); 
        $lastInsertID = $this->LoadingReceiptModel->insert($data) ? $this->LoadingReceiptModel->getInsertID() : '0';
        // echo 'data<pre>';print_r($data);exit;

        //Create pdf 
        $this->makePDF($lastInsertID);

        $this->session->setFlashdata('success', 'Loading Receipt Added Successfully');

        return $this->response->redirect(base_url('/loadingreceipt'));
      }
    }
    return view('LoadingReceipt/create', $this->view); 
  }

  public function getEWayBill_Perfios($data=[]){
    $perfios = new Perfios();
    $apiResp = $perfios->ewayBill($data);
    $info = json_decode($apiResp);//echo __LINE__.'<pre>';print_r($info);die;
    if(!empty($info) && isset($info->statusCode) && $info->statusCode=='101'){
      $r = (isset($info->result) && !empty($info->result)) ? $info->result : (object)[];
      if(!empty($r)){
        $this->view['loading_receipts']['ewaybillNo']           = isset($r->ewaybillNo) ? $r->ewaybillNo : '';
        $this->view['loading_receipts']['ewaybillDate']         = isset($r->ewaybillDate) ? $r->ewaybillDate : '';
        $this->view['loading_receipts']['ewaybillGenerator']    = isset($r->ewaybillGenerator) ? $r->ewaybillGenerator : '';
        $this->view['loading_receipts']['ewaybillGeneratorName']= isset($r->ewaybillGeneratorName) ? $r->ewaybillGeneratorName : '';
        $this->view['loading_receipts']['reporting_datetime']   = (isset($r->validFrom) && !empty($r->validFrom)) ? $r->validFrom.', 12:00 am' : '';
        $this->view['loading_receipts']['releasing_datetime']   = isset($r->validTo) ? $r->validTo : '';

        $this->view['loading_receipts']['pdfLink']              = isset($r->pdfLink) ? $r->pdfLink : '';

        $placeOfDispatch = isset($r->placeOfDispatch) ? $r->placeOfDispatch : (object)[];
        if(!empty($placeOfDispatch)){
          $this->view['loading_receipts']['place_of_dispatch_city']   = isset($placeOfDispatch->city) ? $placeOfDispatch->city : '';
          $this->view['loading_receipts']['place_of_dispatch_state']  = (isset($placeOfDispatch->state) && !empty($placeOfDispatch->state)) ? $this->getStateIdByName($placeOfDispatch->state) : '';
          $this->view['loading_receipts']['place_of_dispatch_pincode']= isset($placeOfDispatch->pincode) ? $placeOfDispatch->pincode : '';
        }

        $placeOfDelivery = isset($r->placeOfDelivery) ? $r->placeOfDelivery : (object)[];
        if(!empty($placeOfDelivery)){
          $this->view['loading_receipts']['place_of_delivery_city']   = isset($placeOfDelivery->city) ? $placeOfDelivery->city : '';
          $this->view['loading_receipts']['place_of_delivery_state']  = (isset($placeOfDelivery->state) && !empty($placeOfDelivery->state)) ? $this->getStateIdByName($placeOfDelivery->state) : '';
          $this->view['loading_receipts']['place_of_delivery_pincode']= isset($placeOfDelivery->pincode) ? $placeOfDelivery->pincode : '';
        }

        $recipient = isset($r->recipient) ? $r->recipient : (object)[];
        if(!empty($recipient)){
          $this->view['loading_receipts']['name']   = isset($recipient->name) ? $recipient->name : '';
          $this->view['loading_receipts']['gstin']  = isset($recipient->gstin) ? $recipient->gstin : '';
        }

        $transaction = isset($r->transaction) ? $r->transaction : (object)[];
        if(!empty($transaction)){
          $this->view['loading_receipts']['invoice_boe_no']   = isset($transaction->documentNo) ? $transaction->documentNo : '';
          $this->view['loading_receipts']['invoice_boe_date'] =  isset($transaction->documentDate) ? $transaction->documentDate : '';
          $this->view['loading_receipts']['transactionType']  = isset($transaction->transactionType) ? $transaction->transactionType : '';
          $this->view['loading_receipts']['invoice_value']    = isset($transaction->valueOfGoods) ? $transaction->valueOfGoods : '';
          $this->view['loading_receipts']['hsn_code']         = isset($transaction->hsnCode) ? $transaction->hsnCode : '';
          $this->view['loading_receipts']['particulars']      = isset($transaction->hsnDesc) ? $transaction->hsnDesc : '';
          $this->view['loading_receipts']['reasonForTransportation']  = isset($transaction->reasonForTransportation) ? $transaction->reasonForTransportation : '';
        }

        $transporter = isset($r->transporter) ? $r->transporter : (object)[];
        if(!empty($transporter)){
          $this->view['loading_receipts']['transporter_id']   = isset($transporter->name) ? $transporter->name : '';
          $this->view['loading_receipts']['transporter_GSTIN']= isset($transporter->gstin) ? $transporter->gstin : '';
        }

        $transportation = isset($r->transportation) ? $r->transportation : (object)[];
        if(!empty($transportation)){
          $this->view['loading_receipts']['mode']         = isset($transportation->mode) ? $transportation->mode : '';
          $this->view['loading_receipts']['vehicleNo']    = isset($transportation->vehicleNo) ? $transportation->vehicleNo : '';
          $this->view['loading_receipts']['from']         = isset($transportation->from) ? $transportation->from : '';
          $this->view['loading_receipts']['enteredDate']  = isset($transportation->enteredDate) ? $transportation->enteredDate : '';
          $this->view['loading_receipts']['enteredBy']    = isset($transportation->enteredBy) ? $transportation->enteredBy : '';
        }
      }
    }
    else{
      $this->view['api_error'] = (!empty($gstInfo) && isset($gstInfo->statusMessage)) ? $gstInfo->statusMessage : '';
    }
  }

  public function getStateIdByName($name=''){
    $row = $this->StateModel->where(['state_name' => $name])->first();
    if(!empty($row))
      return $row['state_id'];
    return 0;
  }

  function getCustomerBranches(){
    $rows =  $this->CustomerBranchModel->where([
      'customer_id'=> $this->request->getPost('customer_id')
      ])->findAll();
    echo json_encode($rows);exit;
  }

  function getPartyDetails(){ 
    $countries = $this->CountryModel->where(['name'=>'India'])->first();
    // echo '<pre>';print_r($countries);exit;
    $rows =  $this->CustomerBranchModel->where([
      'customer_id'=>$this->request->getPost('party_id'),
      'office_name'=>$this->request->getPost('branch_id')
      ])->first();  
    $city = isset( $rows['city']) ? $this->CityModel->where(['city'=>trim($rows['city'])])->first() : [];
    $rows['country_id'] =  isset($countries['country_id']) ? $countries['country_id'] : 0;
    $rows['city_id'] =  isset($city['id']) ? $city['id'] : 0;
    echo json_encode($rows);exit;
  }

  function getPartyInfo(){
    $partyDocModel = new PartyDocumentsModel(); 
    $party =  $this->PModel->select('party.*')
    ->join('customer c','c.party_id = party.id')
    ->where(['c.id'=>$this->request->getPost('party_id')])->first();
    $gstn =  $partyDocModel->select('number as gst')->where(['party_id'=>$party['id'], 'flag_id'=>'3'])->first();
    // echo $partyDocModel->getLastQuery().'<pre>';print_r($gstn);exit;
    $rows = (object) array_merge((array) $party, (array) $gstn);
    echo json_encode($rows);exit;
  }

  function getTransporterBranches($id){
    return $this->CustomerBranchModel->where([
      'customer_id'=> $id
      ])->findAll();
  }

  function getTransporterBranchesById(){
    $rows =  $this->getTransporterBranches($this->request->getPost('customer_id'));
    echo json_encode($rows);exit;
  }

  function edit($id){
    //Check if ProformaInvoiceModel is generated then don't allow to delete LR
    $this->view['proformaInvoice'] =  $this->checkProformaInvoiceForLR($id); 
    // echo 'proformaInvoice<pre>';print_r($this->view['proformaInvoice']);exit;

    $this->view['countries'] = $this->CountryModel->where(['name'=>'India'])->findAll();
    $this->view['loading_receipts'] = $this->LoadingReceiptModel
    ->select('loading_receipts.*,c.party_type_id')
    ->join('bookings b', 'loading_receipts.booking_id = b.id','left')
    ->join('customer c', 'c.id = b.customer_id','left')
    ->where(['loading_receipts.id' => $id])->first();
    // echo $this->LoadingReceiptModel->getLastQuery().'<pre>';print_r($this->view['loading_receipts']);exit;

    //Check LR first or first party 
    $party_type_id = isset($this->view['loading_receipts']['party_type_id']) ? $this->view['loading_receipts']['party_type_id'] : '';
    $this->view['lr_party_type'] = $this->checkLRParty($party_type_id);
    // echo  $party_type_id.'<pre>';print_r($this->view['lr_party_type']);exit;

    //Edit allow only 3 times
    if($this->view['loading_receipts']['edit_count'] >= 3){
      $this->session->setFlashdata('danger', 'Loading Receipt can be edited only 3 times'); 
      return $this->response->redirect(base_url('/loadingreceipt'));
    } 
    $this->view['states'] = $this->StateModel->where(['isStatus' => '1'])->orderBy('state_name', 'ASC')->findAll();
    $this->view['offices'] = $this->OModel->where('status', '1')->findAll();
    $this->view['transport_offices'] = $this->getTransporterBranches($this->view['loading_receipts']['transporter_id']); 
    
    $this->view['bookings'] = $this->BookingsModel    
    ->where(['approved'=> '1','is_vehicle_assigned' => 1]) 
    ->where('NOT EXISTS (SELECT 1 
                  FROM   loading_receipts
                  WHERE  loading_receipts.booking_id = bookings.id and id != '.$id.')')
    ->findAll(); 

    // $this->view['vehicles'] = $this->VModel->where('status', 1)->findAll();
    $this->view['vehicles'] =  $this->BookingsModel->select('v.id,v.rc_number') 
    ->join('vehicle v','bookings.vehicle_id = v.id')->orderBy('v.id', 'desc')
    ->where(['bookings.approved'=> '1','bookings.is_vehicle_assigned' => 1])
    ->groupBy('bookings.vehicle_id')
    ->findAll();
   
    //consignor, consignees changes
      
    $this->view['consignors_list'] = $this->CustomersModel->select('party.party_name,customer.id,customer.party_type_id')
    ->join('party', 'customer.party_id = party.id')
    ->where("FIND_IN_SET (8,customer.party_type_id)")
    ->orderBy('party.party_name')->findAll();          

    $this->view['consignees_list'] = $this->CustomersModel->select('party.party_name,customer.id,customer.party_type_id')
    ->join('party', 'customer.party_id = party.id')
    ->where("FIND_IN_SET (9,customer.party_type_id)")
    ->orderBy('party.party_name')->findAll();   

    $this->view['selected_consignor_name'] = isset($this->view['loading_receipts']) ? $this->view['loading_receipts']['consignor_name'] : 0;
    $this->view['selected_consignee_name'] = isset($this->view['loading_receipts']) ? $this->view['loading_receipts']['consignee_name'] : 0;

    $this->view['consignors']  = array_column($this->view['consignors_list'],'party_name','id');
    $this->view['consignees']  = array_column($this->view['consignees_list'],'party_name','id');

  
    if(isset($this->view['loading_receipts']) && !empty($this->view['loading_receipts']['consignor_name'])){
        if(!in_array($this->view['loading_receipts']['consignor_name'],$this->view['consignors'])){
            array_push($this->view['consignors'],$this->view['loading_receipts']['consignor_name']);
        }
    } 

    if(isset($this->view['loading_receipts']) && !empty($this->view['loading_receipts']['consignee_name'])){
        if(!in_array($this->view['loading_receipts']['consignee_name'],$this->view['consignees'])){
            array_push($this->view['consignees'],$this->view['loading_receipts']['consignee_name']);
        }
    } 

    $party_type_ids = $this->PTModel->select("(GROUP_CONCAT(id)) party_type_ids") 
    ->where('lr_third_party', '1') 
    ->first(); 
     $party_type_ids = str_replace([',',', '],'|', $party_type_ids );
   
    $this->view['transporters'] = $this->CustomersModel->select('customer.id,party.party_name')
        ->join('party', 'party.id = customer.party_id')
        ->where('customer.status', '1')
        ->where('CONCAT(",", party_type_id, ",") REGEXP ",('.$party_type_ids['party_type_ids'].'),"')
        ->findAll();
        
    $this->view['consignor_branches'] = [];
    if($this->view['loading_receipts']['consignor_id'] > 0 ){
      $this->view['consignor_branches']=  $this->CustomerBranchModel->where([
        'customer_id'=> $this->view['loading_receipts']['consignor_id']
        ])->findAll(); 
    }
    $this->view['consignee_branches'] = [];
    if($this->view['loading_receipts']['consignee_id'] > 0 ){
      $this->view['consignee_branches']=  $this->CustomerBranchModel->where([
        'customer_id'=> $this->view['loading_receipts']['consignee_id']
        ])->findAll(); 
    }
    
    if($this->request->getPost()){
      $error = $this->validate([
        'booking_id'   =>  'required',  
        'loading_station'   =>  'required', 
        'delivery_station'   =>  'required', 
        'consignment_date'   =>  'required', 
        'consignor_name'   =>  'required', 
        'consignor_address'   =>  'required', 
        // 'consignor_city'   =>  'required', 
        // 'consignor_state'   =>  'required', 
        'consignee_name'   =>  'required', 
        'consignee_address'   =>  'required',  
        // 'consignee_city'   =>  'required', 
        // 'consignee_state'   =>  'required', 
        'place_of_delivery_address'   =>  'required',  
        'place_of_delivery_city'   =>  'required', 
        'place_of_delivery_state'   =>  'required',  
        'place_of_dispatch_address'   =>  'required',  
        'place_of_dispatch_city'   =>  'required', 
        'place_of_dispatch_state'   =>  'required',  
        'place_of_delivery_name'   =>   'required', 
        'place_of_dispatch_name'   =>   'required', 
      ]); 
      $validation = \Config\Services::validation();
      // echo 'POst dt<pre>';print_r($this->request->getPost());
      // echo 'getErrors<pre>';print_r($validation->getErrors());exit;

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
          'place_of_delivery_name'   =>  $this->request->getVar('place_of_delivery_name'),
          'place_of_dispatch_name'   =>  $this->request->getVar('place_of_dispatch_name'),
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
          'consignor_id'   =>  $this->request->getVar('consignor_id'),
          'consignor_office'   =>  $this->request->getVar('consignor_office_id') ? $this->request->getVar('consignor_office_id') : 0,
          'consignee_id'   =>  $this->request->getVar('consignee_id'),
          'consignee_office'   =>  $this->request->getVar('consignee_office_id') ? $this->request->getVar('consignee_office_id') : 0,
          'customer_name'   =>  $this->request->getVar('customer_name'),
          'transporter_bilti_no'   =>  $this->request->getVar('transporter_bilti_no'),
          'transporter_id' =>  $this->request->getVar('transporter_id'),
          'transporter_office_id' =>  $this->request->getVar('transporter_office_id') ?  $this->request->getVar('transporter_office_id') : '',
          'transporter_address' =>  $this->request->getVar('transporter_address'),
          'transporter_city' =>  $this->request->getVar('transporter_city'),
          'transporter_state' =>  $this->request->getVar('transporter_state'),
          'transporter_pincode' =>  $this->request->getVar('transporter_pincode'),
          'transporter_GSTIN' =>  $this->request->getVar('transporter_GSTIN'),
          'edit_count' => ($this->view['loading_receipts']['edit_count']+1),
          'approved' => 0,
          'seal_no' =>  $this->request->getVar('seal_no'),
          'supplier_office_id' => ( $this->request->getVar('supplier_office_id')) ? $this->request->getVar('supplier_office_id') : 0,
          'recipient_office_id' =>  ($this->request->getVar('recipient_office_id')) ? $this->request->getVar('recipient_office_id') : 0,
          'consignor_country_id'   =>  $this->request->getVar('consignor_country_id'),
          'consignee_country_id'   =>  $this->request->getVar('consignee_country_id'),
          'consignor_city_id'   =>  $this->request->getVar('consignor_city_id'),
          'consignee_city_id'   =>  $this->request->getVar('consignee_city_id'),
        ];

        // echo 'data<pre>';print_r($data);exit;
        $this->LoadingReceiptModel->update($id,$data); 
        

        //Update pdf 
        $this->makePDF($id);

        $this->session->setFlashdata('success', 'Loading Receipt Updated Successfully');

        return $this->response->redirect(base_url('/loadingreceipt'));
      }
    }
    return view('LoadingReceipt/edit', $this->view); 
  }

  function checkLRParty($party_type_id){
    $party_type_ids = isset($party_type_id) ? explode(',',$party_type_id) : [];
    $data = [];
    if($party_type_ids){
      $data['lr_third_party'] =  $this->PTModel->select('count(id) as cnt')
                                ->where('lr_third_party',1)
                                ->whereIn('id',$party_type_ids)->first(); 
      $data['lr_first_party'] =  $this->PTModel->select('count(id) as cnt')
                                ->where('lr_first_party',1)
                                ->whereIn('id',$party_type_ids)->first(); 
    }
    return $data;
  }

  function getBookingDetails(){
    $rows =  $this->BookingsModel->select('bookings.*,concat(bp.city,", ",bps.state_name,IF(bp.pincode != "" , ", ", ""),bp.pincode) bp_city,concat(bd.city,", ",bds.state_name,IF(bd.pincode != "" , ", ", ""),bd.pincode) bd_city,party.party_name,c.party_type_id,bookings.customer_id')
    ->join('booking_drops bd', 'bd.booking_id = bookings.id','left')
    ->join('states bds', 'bds.state_id = bd.state','left')
    ->join('booking_pickups bp', 'bp.booking_id  = bookings.id','left')
    ->join('states bps', 'bps.state_id = bp.state','left')
    ->join('customer c', 'c.id = bookings.customer_id','left')
    ->join('party', 'party.id = c.party_id','left')
    ->where('bookings.id', $this->request->getPost('booking_id'))
    ->first(); 
    $party_type_ids = isset($rows['party_type_id']) ? explode(',',$rows['party_type_id']) : [];
    if($party_type_ids){
      $lr_third_party =  $this->PTModel->select('count(id) as lr_third_party_cnt')
                        ->where('lr_third_party',1)
                        ->whereIn('id',$party_type_ids)->first(); 
      $lr_first_party =  $this->PTModel->select('count(id) as lr_first_party_cnt')
      ->where('lr_first_party',1)
      ->whereIn('id',$party_type_ids)->first(); 
    }
    
    $rows['is_lr_third_party'] = (isset($lr_third_party['lr_third_party_cnt']) && ($lr_third_party['lr_third_party_cnt'] >0)) ? 1 : 0;
    $rows['is_lr_first_party'] = (isset($lr_first_party['lr_first_party_cnt']) && ($lr_first_party['lr_first_party_cnt'] >0)) ? 1 : 0;
    // echo '<pre>';print_r($lr_third_party );exit;
    
    echo json_encode($rows);exit;
  }

  public function delete($id = null)
  {  
    //Check if ProformaInvoiceModel is generated then don't allow to delete LR
    $proformaInvoice = $this->checkProformaInvoiceForLR($id);  

    if(empty($proformaInvoice)){
    $this->LoadingReceiptModel->where('id', $id)->delete($id); 
    $this->session->setFlashdata('success', 'Loading receipt has been deleted successfully');
    }else{ 
      $this->session->setFlashdata('danger', 'Loading receipt can not be delete because of proforma invoice is generated.');
    }
    
    return $this->response->redirect(base_url('/loadingreceipt')); 
  } 

  function preview($id){
    $this->view['loading_receipts'] = $this->LoadingReceiptModel
    ->select('loading_receipts.*,b.booking_number,o.name branch_name,v.rc_number,s.state_name consignor_state,s2.state_name consignee_state,s3.state_name place_of_delivery_state,s4.state_name place_of_dispatch_state
     , IF(UNIX_TIMESTAMP(loading_receipts.reporting_datetime) > 0, loading_receipts.reporting_datetime, "") reporting_datetime
     , IF(UNIX_TIMESTAMP(loading_receipts.invoice_boe_date) > 0, loading_receipts.invoice_boe_date, "") invoice_boe_date
     , IF(UNIX_TIMESTAMP(loading_receipts.releasing_datetime) > 0, loading_receipts.releasing_datetime, "") releasing_datetime
     , IF(UNIX_TIMESTAMP(loading_receipts.policy_date) > 0, loading_receipts.policy_date, "") policy_date
     , IF(UNIX_TIMESTAMP(loading_receipts.booking_date) > 0, loading_receipts.booking_date, "") booking_date
     , IF(UNIX_TIMESTAMP(loading_receipts.e_way_expiry_date) > 0, loading_receipts.e_way_expiry_date, "") e_way_expiry_date
     , IF(UNIX_TIMESTAMP(loading_receipts.consignment_date) > 0, loading_receipts.consignment_date, "") consignment_date
     , party.party_name transporter_name
     , cb.office_name transporter_branch_name
     , s5.state_name transporter_state_name
    ')
    ->join('customer', 'customer.id = loading_receipts.transporter_id','left')
    ->join('party', 'party.id = customer.party_id','left')
    ->join('bookings b','loading_receipts.booking_id = b.id','left')
    ->join('customer_branches cb', 'cb.id = loading_receipts.transporter_office_id','left')
    ->join('vehicle v','b.vehicle_id = v.id','left')
    ->join('office o','loading_receipts.office_id = o.id','left')
    ->join('states s','loading_receipts.consignor_state = s.state_id','left')
    ->join('states s2','loading_receipts.consignee_state = s2.state_id','left')
    ->join('states s3','loading_receipts.place_of_delivery_state = s3.state_id','left')
    ->join('states s4','loading_receipts.place_of_dispatch_state = s4.state_id','left')
    ->join('states s5','loading_receipts.transporter_state = s5.state_id','left')
    ->where(['loading_receipts.id' => $id])->first(); 

    $this->view['states'] = $this->StateModel->where(['isStatus' => '1'])->orderBy('state_name', 'ASC')->findAll(); 
    

    //Check pdf is exist or not
    $fileName = (isset($this->view['loading_receipts']['consignment_no']) && !empty($this->view['loading_receipts']['consignment_no'])) ? str_replace('/','_',$this->view['loading_receipts']['consignment_no']) : 'loading_receipt_'.$id;
    $this->view['lr_file_path'] =  'public/uploads/loading_receipts/'.$fileName.'.pdf';
    // echo  $this->view['lr_file_path'];

    //Make pdf
    $this->makePDF($id);  
    
    //Temparary user id get static as per profile code
    $user_id = 1;//(session()->get('id')) ? session()->get('id') : 0;
    $profiledata = new ProfileModel(); 
    $this->view['profile_data'] = $profiledata
    ->select('profile.*,s.state_name')
    ->join('states s','profile.state = s.state_id','left')
    ->where('logged_in_userid', $user_id)->first();
    // echo $user_id.'<pre>';print_r($this->view['profile_data']);exit;
    //Send Email
    if($this->request->getPost()){
      $id = ($this->request->getPost('id')) && !empty($this->request->getPost('id')) ? $this->request->getPost('id') : '0';
      $fromName = ($this->request->getPost('email_from')) && !empty($this->request->getPost('email_from')) ? $this->request->getPost('email_from') : 'GAE Group';
      $toEmail = ($this->request->getPost('email_to')) && !empty($this->request->getPost('email_to')) ? $this->request->getPost('email_to') : 'kishorejha.php@gmail.com';
      $subject = ($this->request->getPost('email_subject')) && !empty($this->request->getPost('email_subject')) ? $this->request->getPost('email_subject') : 'Loading Receipt of Consignment';
      $message = ($this->request->getPost('email_body')) && !empty($this->request->getPost('email_body')) ? $this->request->getPost('email_body') : 'PFA';

      $config['protocol']   = 'smtp';
      $config['SMTPHost']   = 'mail.aubade-tech.com';
      $config['SMTPPort']   = 465;
      $config['SMTPUser']   = 'booking@gaegroup.in';
      $config['SMTPPass']   = 'August@110321';
      $config['SMTPCrypto'] = 'ssl';
      $config['charset']    = 'utf-8';
      $config['mailType']   = 'html';
      $config['newline']    = "\r\n";

      $this->email->initialize($config);
      $this->email->setFrom('booking@gaegroup.in', $fromName);
      $this->email->setTo($toEmail);
      /*$this->email->setTo('kishorejha.php@gmail.com');
      $this->email->setCC('mehta00999@gmail.com');
      $this->email->setCC('sumeet@aubade-tech.com');
      $this->email->setCC('kishore@aubade-tech.com');*/
      // $this->email->setBCC('bcc@example.com');

      $this->email->setSubject($subject);
      $this->email->setMessage($message);

      $fileName = (isset($this->view['loading_receipts']['consignment_no']) && !empty($this->view['loading_receipts']['consignment_no'])) ? str_replace('/','_',$this->view['loading_receipts']['consignment_no']) : 'loading_receipt_'.$id;
      $filePath = 'public/uploads/loading_receipts/'.$fileName.'.pdf';
      $this->email->attach(FCPATH.$filePath, $fileName);
      //$pdf_path = FCPATH . 'public\uploads\LR-mail.pdf';
      //$this->email->attach($pdf_path, 'pdf_file.pdf', 'application/pdf');

      if ($this->email->send()) {
        //echo 'Email sent successfully';die;
        $session = \Config\Services::session();
        $session->setFlashdata('success', 'Email sent successfully!');
        return redirect()->to('/loadingreceipt/preview/'.$id);
      } else {
        //echo 'Error occured in sending email: ' . $this->email->printDebugger();die;
        $session = \Config\Services::session();
        $session->setFlashdata('error', 'Error occured in sending email: ' . $this->email->printDebugger());
        return redirect()->to('/loadingreceipt/preview/'.$id);
      }
    }

    return view('LoadingReceipt/preview', $this->view); 
  }

  function getVehicleBookings(){
    if($this->request->getPost('vehicle_id') > 0){
      $bookings = $this->BookingsModel
                  ->where('vehicle_id', $this->request->getPost('vehicle_id'))
                  ->where(['approved'=> '1','is_vehicle_assigned' => 1])
                  ->where('NOT EXISTS (SELECT 1 
                          FROM   loading_receipts
                          WHERE  loading_receipts.booking_id = bookings.id)')
                  ->findAll();       
    }else{
      $bookings = $this->BookingsModel
      ->where(['approved'=> '1','is_vehicle_assigned' => 1])
      ->where('NOT EXISTS (SELECT 1 
              FROM   loading_receipts
              WHERE  loading_receipts.booking_id = bookings.id)')
      ->findAll(); 
    }
    echo json_encode($bookings);exit;
  }

  function approve($id){
    $this->view['countries'] = $this->CountryModel->where(['name'=>'India'])->findAll();

    $this->view['loading_receipts'] = $this->LoadingReceiptModel
    ->select('loading_receipts.*,c.party_type_id')
    ->join('bookings b', 'loading_receipts.booking_id = b.id','left')
    ->join('customer c', 'c.id = b.customer_id','left')
    ->where(['loading_receipts.id' => $id])->first();
    // echo $this->LoadingReceiptModel->getLastQuery().'<pre>';print_r($this->view['loading_receipts']);exit;

    //Check LR first or third party 
    $party_type_id = isset($this->view['loading_receipts']['party_type_id']) ? $this->view['loading_receipts']['party_type_id'] : '';
    $this->view['lr_party_type'] = $this->checkLRParty($party_type_id);
    // echo  $party_type_id.'<pre>';print_r($this->view['lr_party_type']);exit;
    
    $this->view['states'] = $this->StateModel->where(['isStatus' => '1'])->orderBy('state_name', 'ASC')->findAll();
    $this->view['offices'] = $this->OModel->where('status', '1')->findAll();
    $this->view['transport_offices'] = $this->getTransporterBranches($this->view['loading_receipts']['transporter_id']); 
    $this->view['bookings'] = $this->BookingsModel    
    ->where(['approved'=> '1','is_vehicle_assigned' => 1]) 
    ->where('NOT EXISTS (SELECT 1 
                  FROM   loading_receipts
                  WHERE  loading_receipts.booking_id = bookings.id and id != '.$id.')')
    ->findAll(); 

    $this->view['vehicles'] =  $this->BookingsModel->select('v.id,v.rc_number') 
    ->join('vehicle v','bookings.vehicle_id = v.id')->orderBy('v.id', 'desc')
    ->where(['bookings.approved'=> '1','bookings.is_vehicle_assigned' => 1])
    ->groupBy('bookings.vehicle_id')
    ->findAll();
   
    //consignor, consignees changes
      
    $this->view['consignors_list'] = $this->CustomersModel->select('party.*,customer.id,customer.party_type_id')
    ->join('party', 'customer.party_id = party.id')
    ->where("FIND_IN_SET (8,customer.party_type_id)")
    ->orderBy('party.party_name')->findAll();          

    $this->view['consignees_list'] = $this->CustomersModel->select('party.*,customer.id,customer.party_type_id')
    ->join('party', 'customer.party_id = party.id')
    ->where("FIND_IN_SET (9,customer.party_type_id)")
    ->orderBy('party.party_name')->findAll();   

    $this->view['selected_consignor_name'] = isset($this->view['loading_receipts']) ? $this->view['loading_receipts']['consignor_name'] : 0;
    $this->view['selected_consignee_name'] = isset($this->view['loading_receipts']) ? $this->view['loading_receipts']['consignee_name'] : 0;

    $this->view['consignors']  = array_column($this->view['consignors_list'],'party_name','id');
    $this->view['consignees']  = array_column($this->view['consignees_list'],'party_name','id');
  
    if(isset($this->view['loading_receipts']) && !empty($this->view['loading_receipts']['consignor_name'])){
        if(!in_array($this->view['loading_receipts']['consignor_name'],$this->view['consignors'])){
            array_push($this->view['consignors'],$this->view['loading_receipts']['consignor_name']);
        }
    } 

    if(isset($this->view['loading_receipts']) && !empty($this->view['loading_receipts']['consignee_name'])){
        if(!in_array($this->view['loading_receipts']['consignee_name'],$this->view['consignees'])){
            array_push($this->view['consignees'],$this->view['loading_receipts']['consignee_name']);
        }
    } 

    $party_type_ids = $this->PTModel->select("(GROUP_CONCAT(id)) party_type_ids") 
    ->where('lr_third_party', '1') 
    ->first(); 
     $party_type_ids = str_replace([',',', '],'|', $party_type_ids );
   
    $this->view['transporters'] = $this->CustomersModel->select('customer.id,party.party_name')
        ->join('party', 'party.id = customer.party_id')
        ->where('customer.status', '1')
        ->where('CONCAT(",", party_type_id, ",") REGEXP ",('.$party_type_ids['party_type_ids'].'),"')
        ->findAll(); 
        // echo $this->CustomersModel->getLastQuery().'<pre>';print_r($this->view['transporters']); exit;
    $this->view['consignor_branches'] = [];
    if($this->view['loading_receipts']['consignor_id'] > 0 ){
      $this->view['consignor_branches']=  $this->CustomerBranchModel->where([
        'customer_id'=> $this->view['loading_receipts']['consignor_id']
        ])->findAll(); 
    }
    $this->view['consignee_branches'] = [];
    if($this->view['loading_receipts']['consignee_id'] > 0 ){
      $this->view['consignee_branches']=  $this->CustomerBranchModel->where([
        'customer_id'=> $this->view['loading_receipts']['consignee_id']
        ])->findAll(); 
    }
    
    if($this->request->getPost()){
      $error = $this->validate([
        'booking_id'   =>  'required',  
        'loading_station'   =>  'required', 
        'delivery_station'   =>  'required', 
        'consignment_date'   =>  'required', 
        'consignor_name'   =>  'required', 
        'consignor_address'   =>  'required', 
        // 'consignor_city'   =>  'required', 
        // 'consignor_state'   =>  'required', 
        'consignee_name'   =>  'required', 
        'consignee_address'   =>  'required',  
        // 'consignee_city'   =>  'required', 
        // 'consignee_state'   =>  'required', 
        'place_of_delivery_address'   =>  'required',  
        'place_of_delivery_city'   =>  'required', 
        'place_of_delivery_state'   =>  'required',  
        'place_of_dispatch_address'   =>  'required',  
        'place_of_dispatch_city'   =>  'required', 
        'place_of_dispatch_state'   =>  'required', 
        'place_of_delivery_name'   =>  'required', 
        'place_of_dispatch_name'   =>  'required', 
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
          'place_of_delivery_name'   =>  $this->request->getVar('place_of_delivery_name'),
          'place_of_dispatch_name'   =>  $this->request->getVar('place_of_dispatch_name'),
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
          'consignor_id'   =>  $this->request->getVar('consignor_id'),
          'consignor_office'   =>  $this->request->getVar('consignor_office_id') ? $this->request->getVar('consignor_office_id') : 0,
          'consignee_id'   =>  $this->request->getVar('consignee_id'),
          'consignee_office'   =>  $this->request->getVar('consignee_office_id') ? $this->request->getVar('consignee_office_id') : 0,
          'customer_name'   =>  $this->request->getVar('customer_name'),
          'transporter_bilti_no'   =>  $this->request->getVar('transporter_bilti_no'),
          'transporter_id' =>  $this->request->getVar('transporter_id'),
          'transporter_office_id' =>  $this->request->getVar('transporter_office_id') ?  $this->request->getVar('transporter_office_id') : '',
          'transporter_address' =>  $this->request->getVar('transporter_address'),
          'transporter_city' =>  $this->request->getVar('transporter_city'),
          'transporter_state' =>  $this->request->getVar('transporter_state'),
          'transporter_pincode' =>  $this->request->getVar('transporter_pincode'),
          'transporter_GSTIN' =>  $this->request->getVar('transporter_GSTIN'),
          'approved' => ($this->request->getVar('approved')) ? $this->request->getVar('approved') : 0,
          'is_approved' => ($this->request->getVar('approved')) ? $this->request->getVar('approved') : 0,
          'seal_no' =>  $this->request->getVar('seal_no'),
          'supplier_office_id' => ( $this->request->getVar('supplier_office_id')) ? $this->request->getVar('supplier_office_id') : 0,
          'recipient_office_id' =>  ($this->request->getVar('recipient_office_id')) ? $this->request->getVar('recipient_office_id') : 0,
          'consignor_country_id'   =>  $this->request->getVar('consignor_country_id'),
          'consignee_country_id'   =>  $this->request->getVar('consignee_country_id'),
          'consignor_city_id'   =>  $this->request->getVar('consignor_city_id'),
          'consignee_city_id'   =>  $this->request->getVar('consignee_city_id'),
        ];

        // echo 'data<pre>';print_r($data);exit;
        $this->LoadingReceiptModel->update($id,$data);
         
        $msg = 'Loading Receipt Updated Successfully';
        if($this->request->getVar('approved')){
          $msg = 'Loading Receipt Approved Successfully';
        }
        $this->session->setFlashdata('success', $msg);

        return $this->response->redirect(base_url('/loadingreceipt'));
      }
    }
    return view('LoadingReceipt/approve', $this->view); 
  }

  function validateBookingLr($customer_id){  
      //get customer party type: LR details 
      $bookingPartyLR = $this->CustomersModel->where('customer.id',$customer_id)->first();
      // echo   $customer_id.' $bookingPartyLR <pre>';print_r($bookingPartyLR); 
      $party_types= isset($bookingPartyLR['party_type_id']) && (!empty($bookingPartyLR['party_type_id'])) ? explode(',',$bookingPartyLR['party_type_id']) : [];
      //get only those customers whose sale = 1
      if(!empty($party_types)){
          $party_type_ids = $this->PTModel
          ->whereIn('id',$party_types)
          ->where('(lr_first_party = 1 or lr_third_party =1)') 
          ->findAll();  
      }   
      // echo  ' $party_type_ids <pre>';print_r($party_type_ids);exit;
      
      if(!empty($party_type_ids)){
          return 1;
      }else{
          return 0;
      }   
  }

  function update_vehicle($id){
      $this->view['loading_receipts'] = $this->LoadingReceiptModel->where(['id' => $id])->first();
      $this->view['vehicles'] =  $this->BookingsModel->select('v.id,v.rc_number') 
      ->join('vehicle v','bookings.vehicle_id = v.id')->orderBy('v.id', 'desc')
      ->where(['bookings.approved'=> '1','bookings.is_vehicle_assigned' => 1])
      ->groupBy('bookings.vehicle_id')
      ->findAll();
      $this->view['token'] = $id;  
      if ($this->request->getPost()) {          
        $error = $this->validate([
            'vehicle_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'The vehicle field is required'
                ],
            ],
            'vehicle_location' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'The vehicle location field is required'
                ],
            ], 
            'lr_update_vehicle_date' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'The date field is required'
                ],
            ],
            'reason_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'The date field is required'
                ],
            ] 
        ]);

        if (!$error) { 
            $this->view['error'] = $this->validator; 
        } else {   
            // echo 'data <pre>';print_r($this->request->getPost()); 
        
            $booking_vehicle = $this->BVLModel
            ->where('booking_id', $this->view['loading_receipts']['booking_id'])
            ->where('vehicle_id', $this->request->getPost('vehicle_id'))
            ->where('(unassign_date IS NULL or UNIX_TIMESTAMP(unassign_date = 0))')
            ->first();
            // echo 'booking_vehicle <pre>';print_r($booking_vehicle); 
            //update booking trip update info 
            if(isset($booking_vehicle['id']) && ($booking_vehicle['id']>0)){ 
              $data['vehicle_location'] = $this->request->getPost('vehicle_location');
              $data['lr_update_vehicle_date'] = $this->request->getPost('lr_update_vehicle_date');
              $data['reason_id'] = $this->request->getPost('reason_id');
              $data['remarks'] = $this->request->getPost('remarks'); 
              // echo 'BVLModel <pre>';print_r($data); exit;
              $this->BVLModel->update($booking_vehicle['id'],$data); 
            }
            // exit;
            $this->LoadingReceiptModel->update($id,[
              'vehicle_id' => $this->request->getPost('vehicle_id'),
              'is_update_vehicle' => 0
            ]); 
           
            $this->session->setFlashdata('success',"Update vehicle successfully");
            return $this->response->redirect(base_url('loadingreceipt'));  
        }           
    }

    return view('LoadingReceipt/update_vehicle', $this->view); 
  }

  function checkProformaInvoiceForLR($lrId){
    //Check if ProformaInvoiceModel is generated then don't allow to delete LR
    return $this->LoadingReceiptModel
    ->select('pr.id')
    ->join('bookings b','b.id = loading_receipts.booking_id')
    ->join('proforma_invoices pr','b.id = pr.booking_id')
    ->where('loading_receipts.id', $lrId)
    ->first(); 
  }

  function makePDF($id){

    $loading_receipt = $this->LoadingReceiptModel->where(['id' => $id])->first();
    $fileName = (isset($loading_receipt['consignment_no']) && !empty($loading_receipt['consignment_no'])) ? str_replace('/','_',$loading_receipt['consignment_no']) : 'loading_receipt_'.$id;
    $filePath = 'public/uploads/loading_receipts/'.$fileName.'.pdf';
 
     //Regenerate file
     if (file_exists($filePath)) {
       unlink($filePath);
     } 

    set_time_limit(0);
    ini_set('memory_limit', '-1');
    ob_clean();

    $consignmentNoteObj = new Consignmentnote();
    $this->view['lr'] = $consignmentNoteObj->getLoadingReceiptDetails($id);
    //Check LR first or first party   

    $html = view('ConsignmentNote/preview_pdf', $this->view); 
    
    $mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 'format' => 'A4']);
    $mpdf->WriteHTML($html); 

    // Output a PDF file directly to the browser
    // $this->response->setHeader('Content-Type', 'application/pdf');
   
    $mpdf->Output($filePath, 'F'); // for downloading in project folder  

    return $fileName;
  }
}
