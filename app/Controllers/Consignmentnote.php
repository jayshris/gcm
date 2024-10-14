<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\StateModel;
use App\Models\OfficeModel;
use App\Models\ProfileModel;
use App\Models\VehicleModel;
use App\Models\BookingsModel;
use App\Controllers\BaseController;
use App\Models\DriverModel;
use App\Models\LoadingReceiptModel;
use App\Models\PartytypeModel;
use CodeIgniter\HTTP\ResponseInterface;

class Consignmentnote extends BaseController
{
  public $OModel;
  public $BookingsModel;
  public $VModel;
  public $LoadingReceiptModel;
  public $session;
  public $profile;
  public $PTModel;
  public $DModel;
  public $email;
  public function __construct()
  {
    $u = new UserModel();
    $this->OModel = new OfficeModel();
    $this->BookingsModel = new BookingsModel();
    $this->VModel = new VehicleModel();
    $this->LoadingReceiptModel = new LoadingReceiptModel();
    $this->session = \Config\Services::session();
    $this->profile = new ProfileModel();
      $this->PTModel = new PartytypeModel();
    $this->DModel = new DriverModel();
    $this->email = \Config\Services::email();
  }

  public function index()
  {
    $this->view['bookings'] = $this->LoadingReceiptModel->select('b.id,b.booking_number')
      ->join('bookings b', 'loading_receipts.booking_id = b.id')
      ->where('loading_receipts.approved', 1)
      ->orderBy('loading_receipts.id', 'desc')->groupBy('loading_receipts.booking_id')->findAll();

    $this->view['rc_number'] =  $this->LoadingReceiptModel->select('v.id,v.rc_number')
      ->join('vehicle v', 'loading_receipts.vehicle_id = v.id')
      ->where('loading_receipts.approved', 1)
      ->orderBy('loading_receipts.id', 'desc')->groupBy('v.id')->findAll();
    // echo '<pre>';print_r( $this->view['rc_number']);exit;

    $this->LoadingReceiptModel->select('loading_receipts.*,b.booking_number,o.name branch_name')
      ->join('bookings b', 'loading_receipts.booking_id = b.id')
      ->join('office o', 'loading_receipts.office_id = o.id');

    if ($this->request->getPost('booking_id')) {
      $this->LoadingReceiptModel->where('b.id', $this->request->getPost('booking_id'));
    }
    if ($this->request->getPost('vehicle_id')) {
      $this->LoadingReceiptModel->where('b.vehicle_id', $this->request->getPost('vehicle_id'));
    }

    $this->view['loading_receipts'] = $this->LoadingReceiptModel->where('loading_receipts.approved', 1)->orderBy('id', 'desc')->findAll();
    $db = \Config\Database::connect();
    //     echo  $db->getLastQuery()->getQuery();  
    // echo 'sdf<pre>';print_r($this->request->getPost());
    // echo 'sdf<pre>';print_r($this->view['loading_receipts']);exit;
    return view('ConsignmentNote/index', $this->view);
  }

    function preview($id){ 
     $this->view['lr'] = $this->getLoadingReceiptDetails($id);  
        
    if ($this->request->getGet('print') > 0) {
      // ========= for pdf download ==================================================================== 
      set_time_limit(0);
      ini_set('memory_limit', '-1');
      ob_clean();

      $html = view('ConsignmentNote/preview_pdf', $this->view);

      $fileName = (isset($this->view['lr']['consignment_no']) && !empty($this->view['lr']['consignment_no'])) ? str_replace('/','_',$this->view['lr']['consignment_no']) : 'loading_receipt_'.$id;
      $filePath = 'public/uploads/loading_receipts/'.$fileName.'.pdf';
      if (!file_exists($filePath)) {
        $mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 'format' => 'A4']);
        $mpdf->WriteHTML($html); 
        
        // Output a PDF file directly to the browser
        // $this->response->setHeader('Content-Type', 'application/pdf');
        
        // $mpdf->Output('public\uploads\LR-mail.pdf', 'I');die;
        $mpdf->Output($filePath, 'F'); // for downloading in project folder
        // echo 'fileName '.$fileName.'<pre>';print_r($this->request->getGet());exit;
      }  
      echo $fileName.'.pdf';exit;
      
      // ========= for mail ==================================================================== 
      $fromName = (isset($this->view['lr']['consignor_name']) && !empty($this->view['lr']['consignor_name'])) ? $this->view['lr']['consignor_name'] : 'GAE Group';
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
      $this->email->setTo('kishorejha.php@gmail.com');
      /*$this->email->setCC('mehta00999@gmail.com');
      $this->email->setCC('sumeet@aubade-tech.com');
      $this->email->setCC('kishore@aubade-tech.com');*/
      // $this->email->setBCC('bcc@example.com');

      $this->email->setSubject('Loading Receipt of Consignment '.$this->view['lr']['consignment_no']);
      $this->email->setMessage('PFA');

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
    else {
      return view('ConsignmentNote/preview', $this->view);
    }
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

  function getLoadingReceiptDetails($id){
    $loading_receipts= $this->LoadingReceiptModel
    ->select('loading_receipts.*,b.booking_number,o.name branch_name,v.rc_number,s.state_name consignor_state,s2.state_name consignee_state,
    s3.state_name place_of_delivery_state,s4.state_name place_of_dispatch_state  ,party.party_name as customer,b.booking_date,bd.city bd_city,
    bp.city bp_city,p.party_name as bill_to_party_nm,c.address as bill_to_address,c.phone bill_to_phone,
    CONCAT_WS(",", consignee_address,consignee_city,s2.state_name,consignee_pincode) consignee_address_f,
    CONCAT_WS(",", consignor_address,consignor_city,s.state_name,consignor_pincode) consignor_address_f,
    CONCAT_WS(",", place_of_delivery_address,place_of_delivery_city,s3.state_name,place_of_delivery_pincode) place_of_delivery_pincode_f ,
    CONCAT_WS(",", place_of_dispatch_address,place_of_dispatch_city,s4.state_name,place_of_dispatch_pincode) place_of_dispatch_address_f,
    cust.party_type_id,
    v.id v_id
    ')
    ->join('bookings b', 'loading_receipts.booking_id = b.id')
    ->join('vehicle v', 'loading_receipts.vehicle_id = v.id', 'left')
    ->join('office o', 'loading_receipts.office_id = o.id', 'left')
    ->join('states s', 'loading_receipts.consignor_state = s.state_id', 'left')
    ->join('states s2', 'loading_receipts.consignee_state = s2.state_id', 'left')
    ->join('states s3', 'loading_receipts.place_of_delivery_state = s3.state_id', 'left')
    ->join('states s4', 'loading_receipts.place_of_dispatch_state = s4.state_id', 'left')
    ->join('customer cust', 'cust.id = b.customer_id', 'left')
    ->join('party', 'party.id = cust.party_id', 'left')
    ->join('customer c', 'c.id = b.bill_to_party', 'left')
    ->join('party p', 'p.id = c.party_id', 'left')
    ->join('booking_drops bd', 'bd.booking_id = b.id', 'left')
    ->join('booking_pickups bp', 'bp.booking_id = b.id', 'left')
    ->where(['loading_receipts.id' => $id])->first();

    //Check LR first or first party 
    $party_type_id = isset($loading_receipts['party_type_id']) ? $loading_receipts['party_type_id'] : '';
    $loading_receipts['lr_party_type'] = $this->checkLRParty($party_type_id);
    // echo  $party_type_id.'<pre>';print_r($this->view['lr_party_type']);exit;
      
    ///Get driver details
    $vehicle_id = isset($loading_receipts['v_id']) && ($loading_receipts['v_id'] > 0) ?$loading_receipts['v_id'] : 0;
    if ($vehicle_id > 0) { 
      $loading_receipts['driver'] = $this->DModel->select('driver.id, party.party_name as driver_name,party.primary_phone')
              ->join('driver_vehicle_map dvp', 'driver.id = dvp.driver_id')
              ->join('party', 'party.id = driver.party_id')
              // ->where('(dvp.unassign_date = "" or dvp.unassign_date IS NULL or (UNIX_TIMESTAMP(dvp.unassign_date) = 0))')
              ->orderBy('dvp.id','DESC')
              ->first();  
    }

    return $loading_receipts;
  }
}
