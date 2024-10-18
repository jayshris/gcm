<?php

namespace App\Controllers;
   
use App\Models\ProfileModel;
use App\Models\VehicleModel;
use App\Models\BookingsModel;
use App\Models\CustomersModel;
use App\Models\PartytypeModel;
use App\Models\ExpenseHeadModel;
use App\Controllers\BaseController;
use App\Models\CustomerBranchModel;
use App\Models\PartyDocumentsModel;
use App\Models\BookingExpensesModel;
use App\Models\ProformaInvoiceModel; 
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProformaInvoiceBookingModel;
use App\Models\ProformaInvoiceExpenseModel;

class Proformainvoices extends BaseController
{ 
    public $session; 
    public $BookingsModel;
    public $ProformaInvoiceModel;
    public $BEModel;
    public $ExpenseHeadModel;
    public $CModel;
    public $added_by;
    public $profile;
    public $PTModel;
    public $ProformaInvoiceExpenseModel;
    public $partyDocModel;
    public $CBModel;
    public $VModel;
    public $ProformaInvoiceBookingModel;
    public function __construct()
    { 
      $this->session = \Config\Services::session(); 
      $this->BookingsModel = new BookingsModel();
      $this->ProformaInvoiceModel= new ProformaInvoiceModel();
      $this->BEModel = new BookingExpensesModel();
      $this->ExpenseHeadModel = new ExpenseHeadModel();    
      $this->CModel = new CustomersModel();
      $this->added_by = isset($_SESSION['id']) ? $_SESSION['id'] : '0';
      $this->profile = new ProfileModel();
      $this->PTModel = new PartytypeModel();
      $this->ProformaInvoiceExpenseModel = new ProformaInvoiceExpenseModel();
      $this->partyDocModel = new PartyDocumentsModel();
      $this->CBModel = new CustomerBranchModel();
      $this->VModel = new VehicleModel();
      $this->ProformaInvoiceBookingModel= new ProformaInvoiceBookingModel();
    }
  
    public function index()
    {    
        $this->view['proforma_invoice_nos']  = $this->ProformaInvoiceModel->select('id,proforma_invoices_no')->orderBy('proforma_invoices.id','DESC')->findAll();
        $query = "(SELECT vehicle.rc_number FROM booking_transactions bt join vehicle on vehicle.id = bt.vehicle_id  WHERE booking_status_id = 11 and booking_id = b.id group by bt.booking_id)";
        // $this->ProformaInvoiceModel->select('proforma_invoices.*,b.booking_number, 
        // IF(b.status = 11,'.$query .', v.rc_number) as rc_number,
        // p.party_name,p.primary_phone,b.status')
        $this->ProformaInvoiceModel->select('proforma_invoices.*, p.party_name, p.primary_phone,group_concat(b.booking_number) booking_number,v.rc_number')
        ->join('proforma_invoice_bookings pib','proforma_invoices.id=pib.proforma_invoice_id','left')
        ->join('bookings b','b.id=pib.booking_id','left')
        ->join('vehicle v','v.id = proforma_invoices.vehicle_id','left')
        ->join('customer c', 'c.id = proforma_invoices.bill_to_party_id','left') 
        ->join('party p', 'p.id = c.party_id','left');  
        if ($this->request->getPost('customer_id') != '') {
            $this->ProformaInvoiceModel->where('proforma_invoices.bill_to_party_id', $this->request->getPost('customer_id'));
        }  

        if ($this->request->getPost('booking_id') != '') {
          $this->ProformaInvoiceModel->where('b.id', $this->request->getPost('booking_id'));
        }

        if ($this->request->getPost('start_date') != '') {
            $this->ProformaInvoiceModel->where('DATE(proforma_invoices.created_at) >= ', $this->request->getPost('start_date'));
        } 

        if ($this->request->getPost('end_date') != '') {
            $this->ProformaInvoiceModel->where('DATE(proforma_invoices.created_at) <= ', $this->request->getPost('end_date'));
        }

        if ($this->request->getPost('proforma_invoices_no') > 0 ) { 
            $this->ProformaInvoiceModel->where('proforma_invoices.id ', $this->request->getPost('proforma_invoices_no'));
        }

        $this->view['proforma_invoices']  = $this->ProformaInvoiceModel->orderBy('proforma_invoices.id','DESC')->groupBy('proforma_invoices.id')->findAll();
       
        // echo '<pre>'.$this->ProformaInvoiceModel->getLastQuery().'<pre>';print_r( $this->view['proforma_invoices']);exit;

        $this->view['customers'] = $this->getCustomers();
        $this->view['bookings'] = $this->BookingsModel
        ->select('bookings.id,bookings.booking_number')
        // ->where(['status >'=> 3])   
        // ->where(['status != '=> 11])   
        ->findAll();  
        return view('ProformaInvoice/index', $this->view); 
    } 

    function getCustomers(){
      $party_type_ids = $this->PTModel->select("(GROUP_CONCAT(id)) party_type_ids") 
      ->where('sale', '1') 
      ->first(); 
       $party_type_ids = str_replace([',',', '],'|', $party_type_ids );
     
     return $this->CModel->select('customer.*, party.party_name')
          ->join('party', 'party.id = customer.party_id')
          ->where('customer.status', '1')
          ->where('CONCAT(",", party_type_id, ",") REGEXP ",('.$party_type_ids['party_type_ids'].'),"')
          ->findAll();
    }

    function getvehicles($id = 0){ 
        $condition = $id> 0 ? ' and pib.proforma_invoice_id != '.$id: ''; 
        return $this->BookingsModel->select('v.id,v.rc_number') 
        ->join('vehicle v','bookings.vehicle_id = v.id') 
        ->where('EXISTS (SELECT 1 
                    FROM   loading_receipts
                    WHERE  loading_receipts.booking_id = bookings.id and loading_receipts.approved = 1)')
        ->where('NOT EXISTS (SELECT 1 
                FROM   proforma_invoice_bookings pib
                WHERE  pib.booking_id = bookings.id '.$condition.')')
        ->where(['bookings.status >'=> '3']) 
        // ->where(['bookings.status != '=> 11]) 
        ->orderBy('v.id', 'desc')
        ->groupBy('bookings.vehicle_id')
        ->findAll(); 
    }

    function getBooking($id = 0){
      $condition = $id> 0 ? ' and proforma_invoices.id != '.$id: '';  
      return $this->BookingsModel->where(['status >'=> '3'])  
      // ->where(['status != '=> 11]) 
      ->where('EXISTS (SELECT 1 
                    FROM   loading_receipts
                    WHERE  loading_receipts.booking_id = bookings.id and loading_receipts.approved = 1)')
      ->where('NOT EXISTS (SELECT 1 
                FROM   proforma_invoices
                WHERE  proforma_invoices.booking_id = bookings.id '.$condition.')')
      ->findAll();   
      // echo '<pre>'.$this->ProformaInvoiceModel->getLastQuery().'<pre>';print_r($d);exit;
    } 
    
    function create(){     
      $this->view['bookings'] = $this->getBooking();  
      $this->view['vehicles'] =  $this->getvehicles();

      if($this->request->getPost()){
        $error = $this->validate([
          'vehicle_id' => 'required',
          'booking_id'   =>  'required',
          'bill_to_party_id'   =>  'required',
          'total_freight'   =>  'required'
        ]);   
        if (!$error) {
          $this->view['error']   = $this->validator;
        } else {  
          $this->update_proforma_transaction($this->request->getVar());
           
          $this->session->setFlashdata('success', 'Proforma Invoice Added Successfully');
          return $this->response->redirect(base_url('/proformainvoices'));
        }
      }
      return view('ProformaInvoice/form', $this->view); 
    }
  
    function getVehicleBookings(){ 
      if($this->request->getPost('vehicle_id')){
        $this->BookingsModel->where('vehicle_id', $this->request->getPost('vehicle_id'));
      }
      $bookings = $this->BookingsModel->where(['status >'=> '3'])
      ->where(['status != '=> 11]) 
      ->where('NOT EXISTS (SELECT 1 
      FROM   proforma_invoices
      WHERE  proforma_invoices.booking_id = bookings.id)')
      ->findAll();       
      echo json_encode($bookings);exit;
    }

    function getVehicleBookingDetails($id= 0){   
      $selectedBookings   =  $this->ProformaInvoiceBookingModel->where(['proforma_invoice_id' =>$id])->findAll(); 
      $this->view['selectedBookings'] = ($selectedBookings) ? array_column($selectedBookings,'booking_id') : [];
      // echo  '<pre>';print_r($this->view['selectedBookings']);exit;

      $this->view['bookings'] =  $this->BookingsModel->select('bookings.*, c.id c_id,p.party_name,lr.particulars,lr.hsn_code') 
      ->join('customer c','bookings.customer_id = c.id') 
      ->join('party p', 'c.party_id = p.id')
      ->join('loading_receipts lr','bookings.id = lr.booking_id')
      ->where(['bookings.status >'=> '3','bookings.status != '=> 11]) 
      ->where('NOT EXISTS (SELECT 1 
      FROM   proforma_invoices
      WHERE  proforma_invoices.booking_id = bookings.id)')
      ->where('bookings.vehicle_id', $this->request->getPost('vehicle_id'))
      ->findAll();    

      // echo $this->BookingsModel->getLastQuery().'<pre>';print_r($this->view['bookings']);exit;
      
      echo view('ProformaInvoice/booking_details_block', $this->view);
    }

    function update_proforma_transaction($post,$id =0){  
      if($id>0){
        $data['id'] = $id;
        $data['updated_by'] = $this->added_by;
      }else{
        $profile =  $this->profile->where('logged_in_userid',  '1')->first();//echo __LINE__.'<pre>';print_r($profile);die;
        $lastr = $this->ProformaInvoiceModel->orderBy('id', 'desc')->first();
        $lastr = isset($lastr['id']) ? ((int)$lastr['id']+1) : 1; 
        $data['proforma_invoices_no'] = isset($profile['proforma_invoice_prefix']) && !empty($profile['proforma_invoice_prefix']) ? $profile['proforma_invoice_prefix'].'/'.date('m').'/000'.$lastr : 'PR/'.date('m').'/000'.$lastr;
        $data['created_by'] =$this->added_by;
      }
      $data['vehicle_id'] = $post['vehicle_id'];
      $data['bill_to_party_id'] = $post['bill_to_party_id'];
      $data['total_freight'] = $post['total_freight']; 
      $data['sgst_percent'] = $post['sgst_percent']; 
      $data['sgst_total'] = $post['sgst_total']; 
      $data['cgst_percent'] = $post['cgst_percent']; 
      $data['cgst_total'] = $post['cgst_total']; 
      $data['igst_percent'] = $post['igst_percent']; 
      $data['igst_total'] = $post['igst_total']; 
      $data['discount'] = $post['discount'];
      $data['balance'] = $post['balance'];
      $data['guranteed_wt'] = $post['guranteed_wt']; 
      $data['advance'] = $post['advance']; 
      $data['rate'] = $post['rate'];
      $data['rate_type'] = $post['rate_type'];
      $data['invoice_total_amount'] = $post['invoice_total_amount'];
      $data['customer_branch_id'] = $post['customer_branch_id'];
      $data['other_expenses'] = $post['other_expenses'];
      $data['commission_amount'] = $post['commission_amount'];

      // echo  'ProformaInvoice <pre>';print_r($data); 
      // echo  'post <pre>';print_r($post);exit;
      
      if($id > 0){
        $proforma_invoice_id = $id;
        $this->ProformaInvoiceModel->save($data);   
      }else{
        $proforma_invoice_id = $this->ProformaInvoiceModel->insert($data) ? $this->ProformaInvoiceModel->getInsertID() : 0;   
      }
      
      if($proforma_invoice_id > 0){
        // update Expences 
        if($id > 0){
          $this->ProformaInvoiceExpenseModel->where('proforma_invoice_id', $id)->delete();
          $this->ProformaInvoiceBookingModel->where('proforma_invoice_id', $id)->delete();
        }
        
        // save expenses 
        foreach ($post['expense'] as $key => $val) {
          if(($post['expense'][$key]) || $post['expense_value'][$key] || isset($post['expense_flag_' . $key +1])){
            $expense_data = [
                'proforma_invoice_id' => $proforma_invoice_id,
                'expense' => $post['expense'][$key],
                'value' => $post['expense_value'][$key],
                'bill_to_party' =>isset($post['expense_flag_' . $key +1]) && ($post['expense_flag_' . $key +1] == 'on') ? '1' : '0'
            ]; 
            // echo  'expense_data <pre>';print_r($expense_data);
            $this->ProformaInvoiceExpenseModel->insert($expense_data);
          }  
        }

        //save invoice bookings
        foreach ($post['booking_id'] as $key => $val) {
          $booking_data['booking_id'] = $val;
          $booking_data['proforma_invoice_id'] = $proforma_invoice_id;
          // echo  'booking_data <pre>';print_r($booking_data);
          $this->ProformaInvoiceBookingModel->insert($booking_data);     
        } 
      }
        
    } 

    function edit($id){       
      $this->view['token'] = $id; 
      $this->view['proforma_invoice'] = $this->ProformaInvoiceModel
      ->select('proforma_invoices.*')  
      ->where(['proforma_invoices.id' => $id])->first(); 
      // echo 'post <pre>';print_r($this->view['proforma_invoice']);exit;

      // $this->view['bookings'] = $this->getBooking($id);  
      $this->view['vehicles'] =  $this->getvehicles($id); 
      
      if($this->request->getPost()){
        $error = $this->validate([ 
          'vehicle_id' => 'required',
          'booking_id'   =>  'required',
          'bill_to_party_id'   =>  'required',
          'total_freight'   =>  'required'
        ]);   
        if (!$error) {
          $this->view['error']   = $this->validator;
        } else {        
          // echo 'post <pre>';print_r($this->request->getVar());exit;
    
          $this->update_proforma_transaction($this->request->getVar(),$id);           
          $this->session->setFlashdata('success', 'Proforma Invoice Updated Successfully');
          return $this->response->redirect(base_url('/proformainvoices'));
        }
      }
      return view('ProformaInvoice/form', $this->view); 
    } 
  
    public function delete($id = null)
    {   
        $this->ProformaInvoiceModel->where('id', $id)->delete($id); 
        $this->ProformaInvoiceExpenseModel->where('proforma_invoice_id', $id)->delete($id); 
        $this->ProformaInvoiceBookingModel->where('proforma_invoice_id', $id)->delete($id); 
        $this->session->setFlashdata('success', 'Proforma Invoice has been deleted successfully');
        return $this->response->redirect(base_url('/proformainvoices')); 
    }
   
    function preview_bk($id){   
      $this->view['proforma_invoice'] = $this->ProformaInvoiceModel
      ->select('proforma_invoices.*,b.id bid,b.booking_number,b.booking_date,b.status booking_status,p.party_name,p.business_address,p.email,p.primary_phone,p.city,p.postcode,p.contact_person,p.id pid,v.rc_number,s.state_name
      ,concat(bp.city,", ",bps.state_name,IF(bp.pincode != "" , ", ", ""),bp.pincode) pickup_state
      ,concat(bd.city,", ",bds.state_name,IF(bd.pincode != "" , ", ", ""),bd.pincode) drop_state 
      ,c.party_type_id,c.party_id,bc.party_name customer_party_name,bc.id bc_id
      ,lr.consignment_no,lr.consignment_date,lr.particulars,lr.hsn_code,lr.no_of_packages,lr.charge_weight,lr.actual_weight')
      ->join('bookings b','b.id=proforma_invoices.booking_id')
      // ->join('party p','p.id = proforma_invoices.bill_to_party_id')
      ->join('customer c', 'c.id = proforma_invoices.bill_to_party_id','left') 
      ->join('party p', 'p.id = c.party_id','left') 
      ->join('customer c2', 'c2.id = b.customer_id','left') 
      ->join('party bc', 'bc.id = c2.party_id','left') 
      ->join('booking_pickups bp','b.id=bp.booking_id','left')
      ->join('booking_drops bd','b.id=bd.booking_id','left')
      ->join('states bps', 'bp.state = bps.state_id','left')
      ->join('states bds', 'bd.state = bds.state_id','left')
      ->join('vehicle v', 'v.id = b.vehicle_id','left')
      ->join('states s', 'p.state_id = s.state_id','left') 
      ->join('loading_receipts lr','b.id=lr.booking_id')
      ->where(['proforma_invoices.id' => $id])->first();
      // echo '<pre>'.$this->ProformaInvoiceModel->getLastQuery().'<pre>';print_r($this->view['proforma_invoice']);die; 
      
      if(isset($this->view['proforma_invoice']['party_type_id']) && !empty($this->view['proforma_invoice']['party_type_id'])){
        $this->view['is_tax_applicable'] = $this->PTModel->select('count(id) cnt')->whereIn('id', explode(',',$this->view['proforma_invoice']['party_type_id']))
                                            ->where('tax_applicable',1)
                                            ->first(); 
      }
      // echo '<pre>'.$this->ProformaInvoiceModel->getLastQuery().'<pre>';print_r($this->view['is_tax_applicable']);die; 
      $this->view['booking_expences'] = $this->ProformaInvoiceExpenseModel->select('proforma_invoice_expenses.*,eh.*')
      ->join('expense_heads eh','eh.id = proforma_invoice_expenses.expense')
      ->where('proforma_invoice_expenses.proforma_invoice_id', $id)
      ->where('proforma_invoice_expenses.bill_to_party',1)
      ->findAll();
      // echo '<pre>'.$this->ProformaInvoiceExpenseModel->getLastQuery().'<pre>';print_r($this->view['booking_expences']);exit;
 
      if($this->view['proforma_invoice']['booking_status'] == 11){
        $lastBookingVehicle = $this->BookingsModel->select('btrs.*,v.rc_number')
        ->join('booking_transactions btrs', 'btrs.booking_id = bookings.id')
        ->join('vehicle v', 'btrs.vehicle_id = v.id')
        ->where(['booking_status_id'=> 11,'bookings.id' =>$this->view['proforma_invoice']['booking_id']])
        ->orderBy('btrs.id','desc')
        ->first();
        $this->view['proforma_invoice']['rc_number'] = isset($lastBookingVehicle['rc_number']) ? $lastBookingVehicle['rc_number'] : '';
      }
      // echo '<pre>';print_r($this->view['proforma_invoice']);exit;

      $this->view['party_doc'] =  $this->partyDocModel->select('number as gst')->where(['party_id'=>$this->view['proforma_invoice']['party_id'], 'flag_id'=>'3'])->first();
      // echo $this->partyDocModel->getLastQuery().'<pre>';print_r($this->view['gstn']);exit;
      return view('ProformaInvoice/preview', $this->view); 
    } 

    function preview($id){   
      $this->view['proforma_invoice'] = $this->ProformaInvoiceModel
      ->select('proforma_invoices.*
      ,p.party_name,p.business_address,p.email,p.primary_phone,p.city,p.postcode,p.contact_person,p.id pid,v.rc_number,s.state_name
      ,c.party_type_id,c.party_id
      ,v.charge_wt
      ,sum(lr.charge_weight) lr_charge_weight
      ')
      ->join('customer c', 'c.id = proforma_invoices.bill_to_party_id','left') 
      ->join('party p', 'p.id = c.party_id','left')  
      ->join('states s', 'p.state_id = s.state_id','left') 
      ->join('vehicle v', 'v.id = proforma_invoices.vehicle_id','left')
      ->join('proforma_invoice_bookings pib','proforma_invoices.id=pib.proforma_invoice_id','left')
      ->join('bookings b','b.id=pib.booking_id','left')  
      ->join('loading_receipts lr','b.id=lr.booking_id')
      ->where(['proforma_invoices.id' => $id])->groupBy('proforma_invoices.id')->first();
      // echo '<pre>'.$this->ProformaInvoiceModel->getLastQuery().'<pre>';print_r($this->view['proforma_invoice']);//die;

      $this->view['proforma_invoice_details'] = $this->ProformaInvoiceModel
      ->select('b.id b_id,b.status booking_status
                ,b.booking_number
                ,b.booking_date
                ,concat(bp.city,", ",bps.state_name,IF(bp.pincode != "" , ", ", ""),bp.pincode) pickup_state
                ,concat(bd.city,", ",bds.state_name,IF(bd.pincode != "" , ", ", ""),bd.pincode) drop_state 
                ,bc.party_name customer_party_name 
                ,bc.id
                ,lr.consignment_no
                ,lr.consignment_date
                ,lr.particulars
                ,lr.hsn_code
                ,lr.no_of_packages
                ,lr.charge_weight charge_weight
                ,lr.actual_weight  actual_weight
                ')
      ->join('proforma_invoice_bookings pib','proforma_invoices.id=pib.proforma_invoice_id','left')
      ->join('bookings b','b.id=pib.booking_id','left')  
      ->join('customer c2', 'c2.id = b.customer_id','left') 
      ->join('party bc', 'bc.id = c2.party_id','left') 
      ->join('booking_pickups bp','b.id=bp.booking_id','left')
      ->join('booking_drops bd','b.id=bd.booking_id','left')
      ->join('states bps', 'bp.state = bps.state_id','left')
      ->join('states bds', 'bd.state = bds.state_id','left')
      ->join('loading_receipts lr','b.id=lr.booking_id')
      ->where(['proforma_invoices.id' => $id])->findAll(); 
      // echo '<pre>'.$this->ProformaInvoiceModel->getLastQuery().'<pre>';print_r($this->view['proforma_invoice_details']);die; 
      
      if(isset($this->view['proforma_invoice']['party_type_id']) && !empty($this->view['proforma_invoice']['party_type_id'])){
        $this->view['is_tax_applicable'] = $this->PTModel->select('count(id) cnt')->whereIn('id', explode(',',$this->view['proforma_invoice']['party_type_id']))
                                            ->where('tax_applicable',1)
                                            ->first(); 
      }
      // echo '<pre>'.$this->ProformaInvoiceModel->getLastQuery().'<pre>';print_r($this->view['is_tax_applicable']);die; 
      $this->view['booking_expences'] = $this->ProformaInvoiceExpenseModel->select('proforma_invoice_expenses.*,eh.*')
      ->join('expense_heads eh','eh.id = proforma_invoice_expenses.expense')
      ->where('proforma_invoice_expenses.proforma_invoice_id', $id)
      ->where('proforma_invoice_expenses.bill_to_party',1)
      ->findAll();
      // echo '<pre>'.$this->ProformaInvoiceExpenseModel->getLastQuery().'<pre>';print_r($this->view['booking_expences']);exit;

      $this->view['party_doc'] =  $this->partyDocModel->select('number as gst')->where(['party_id'=>$this->view['proforma_invoice']['party_id'], 'flag_id'=>'3'])->first();
      // echo $this->partyDocModel->getLastQuery().'<pre>';print_r($this->view['gstn']);exit;
      return view('ProformaInvoice/preview', $this->view); 
    }

    function getBookingExpense($booking_id,$id= 0){   
      if($id > 0){ 
        $this->view['booking_expences'] = $this->ProformaInvoiceExpenseModel->where(['proforma_invoice_id'=>$id])->where('((expense > 0) or (value > 0) or (bill_to_party=1))')->findAll();  
        $this->view['booking_details'] = $this->ProformaInvoiceModel->where(['id'=> $id])->first();  
      }else{ 
        $this->view['booking_details'] = $this->BookingsModel->where(['id'=> $booking_id])->first();  
        $this->view['booking_vehicle_details'] = $this->VModel->where('id',$this->view['booking_details']['vehicle_id'])->first();
        $this->view['booking_expences'] = $this->BEModel->where(['booking_id'=>$booking_id])->where('((expense > 0) or (value > 0))')->findAll();  
      }
      
      // echo 'booking_details <pre>';print_r($this->view['booking_details']);  
      // echo 'booking_expences <pre>';print_r($this->view['booking_expences']);
      // exit;
      $this->view['expense_heads'] =  $this->ExpenseHeadModel->orderBy('head_name', 'asc')->findAll(); 
    
      echo view('ProformaInvoice/expense_block', $this->view);
    } 

    function getBookingCustomers($id){ 
      $Customers =  $this->BookingsModel->select('bookings.id, c.id c_id') 
      ->join('customer c','bookings.customer_id = c.id')->where(['bookings.id'=> $id])->findAll();  

      $Customers2 =  $this->BookingsModel->select('bookings.id,c.id c_id') 
      ->join('customer c','bookings.bill_to_party = c.id')->where(['bookings.id'=> $id])->findAll();  

      $Customers3 =  $this->BookingsModel->select('bookings.id,lr.consignor_id c_id') 
      ->join('loading_receipts lr','bookings.id = lr.booking_id')
      ->join('customer c','lr.consignor_id = c.id','left')->where(['bookings.id'=> $id])->findAll();  

      $Customers4 =  $this->BookingsModel->select('bookings.id,lr.consignee_id c_id') 
      ->join('loading_receipts lr','bookings.id = lr.booking_id')
      ->join('customer c','lr.consignee_id = c.id','left')->where(['bookings.id'=> $id])->findAll();  

      $Customers5 =  $this->BookingsModel->select('bookings.id,lr.transporter_id c_id') 
      ->join('loading_receipts lr','bookings.id = lr.booking_id')
      ->join('customer c','lr.transporter_id = c.id','left')->where(['bookings.id'=> $id])->findAll(); 
      
      $all_customers = array_merge($Customers,$Customers2,$Customers3,$Customers4,$Customers5); 
      $unique_customers =  array_unique(array_column($all_customers, 'c_id'));
      // echo 'all_customers<pre>';print_r($unique_customers);  
      $customers = [];
      if(!empty($unique_customers)){
        $customer = $this->CModel->select('customer.id,party.id pid,party.party_name')->whereIN('customer.id',$unique_customers)->join('party', 'customer.party_id = party.id')->orderBy('party.party_name')->findAll();
      }
      $data['customers'] = $customer;
      $booking_customer = $this->BookingsModel->select('bookings.id, c.id c_id,p.party_name ') 
      ->join('customer c','bookings.customer_id = c.id') 
      ->join('party p', 'c.party_id = p.id') 
      ->where(['bookings.id'=> $id])->first();
      $data['booking_customer'] = isset($booking_customer['party_name']) ? $booking_customer['party_name'] : '';
      // echo 'customer<pre>';print_r($customer); exit;
      echo json_encode($data);exit;
    }

    function getBookingDetails($booking_id,$id= 0){
      if($id > 0){
        $proformaInvoice = $this->ProformaInvoiceModel->where('id', $id)->first();     
        $total_freight = isset($proformaInvoice['invoice_total_amount']) && ($proformaInvoice['invoice_total_amount'] > 0) ? $proformaInvoice['invoice_total_amount'] : 0;  
      }else{
        $bookings = $this->BookingsModel->where('id', $booking_id)->first();     
        $total_freight = isset($bookings['total_freight']) && ($bookings['total_freight'] > 0) ? $bookings['total_freight'] : 0;
      }
      
      echo json_encode($total_freight);exit;
    }

    function checkTaxApplicable($customer_id){
      $customer = $this->CModel->where('id',$customer_id)->first();
      $customerPartyIds = isset($customer['party_type_id']) && ($customer['party_type_id']!='') ? explode(',',$customer['party_type_id']) : [];
      if(!empty($customerPartyIds)){
        $partyCount  = $this->PTModel->select('count(id) cnt')->whereIn('id',$customerPartyIds)->where('tax_applicable',1)->first();
      }
      // echo '<pre>';print_r($partyCount);exit;
      return isset($partyCount['cnt']) && ($partyCount['cnt'] > 0) ? $partyCount['cnt'] : 0;
    }

    function getCustomerBranches($customer_id = 0){
      $customer_branches = $this->CBModel->select('id,office_name') 
      ->where(['customer_branches.status'=>'1','customer_id' =>$customer_id]) 
      ->findAll();
      echo json_encode($customer_branches);exit;
    }

    function getLRBookingDetails($booking_id){
      $lrDetails = $this->BookingsModel
      ->select('lr.*') 
      ->join('loading_receipts lr','bookings.id = lr.booking_id')
      ->where('lr.booking_id', $booking_id)
      ->first(); 
      echo json_encode($lrDetails);exit;
    }

    function getMultipleBookingExpenses($id = 0){   
      if($id > 0){ 
        $this->view['booking_expences'] = $this->ProformaInvoiceExpenseModel->where(['proforma_invoice_id'=>$id])->where('((expense > 0) or (value > 0) or (bill_to_party=1))')->findAll();  
        $this->view['booking_details'] = $this->ProformaInvoiceModel->where(['id'=> $id])->first();  
      }else{ 
        $booking_ids = $this->request->getPost('booking_ids');  
        $booking_ids = json_decode($booking_ids); 
        // echo '<pre>';print_r($booking_ids);   
        $this->view['booking_details'] = $this->BookingsModel
        ->select('
        rate_type,
        sum(rate) rate,
        sum(guranteed_wt) guranteed_wt,
        sum(freight) freight,
        sum(other_expenses) other_expenses,
        sum(advance) advance,
        sum(discount) discount,
        sum(balance) balance,
        group_concat(distinct vehicle_id)  vehicle_id
        ')
        ->whereIn('id',$booking_ids)->first();  
        //  echo $this->BookingsModel->getLastQuery().'<pre>';print_r($this->view['booking_details']);//exit;

        $vehicle_ids = isset($this->view['booking_details']['vehicle_id']) && ($this->view['booking_details']['vehicle_id']) ? explode(',',$this->view['booking_details']['vehicle_id']) : [];
        
        $this->view['booking_vehicle_details'] = $this->VModel->select('charge_wt')->whereIn('id',$vehicle_ids)->first();

        // echo $this->VModel->getLastQuery().'<pre>';print_r($this->view['booking_vehicle_details']);//exit;

        $this->view['booking_expences'] = $this->BEModel
        ->select('sum(value) value,bill_to_party,expense,group_concat(booking_id)')
        ->whereIn('booking_id',$booking_ids)
        ->where('((expense > 0) or (value > 0))')
        ->groupBy('expense,bill_to_party')
        ->findAll();   
        
        // echo $this->BEModel->getLastQuery().' <pre>';print_r($this->view['booking_expences']);exit;
      }
      $this->view['expense_heads'] =  $this->ExpenseHeadModel->orderBy('head_name', 'asc')->findAll(); 
    
      echo view('ProformaInvoice/expense_block', $this->view);
    }

    function getMultipleBookingCustomers(){
      $booking_ids = $this->request->getPost('booking_ids');  
      $id = json_decode($booking_ids); 
      $Customers =  $this->BookingsModel->select('bookings.id, c.id c_id') 
      ->join('customer c','bookings.customer_id = c.id')->whereIn('bookings.id',$id)->findAll();  

      $Customers2 =  $this->BookingsModel->select('bookings.id,c.id c_id') 
      ->join('customer c','bookings.bill_to_party = c.id')->whereIn('bookings.id',$id)->findAll();  

      $Customers3 =  $this->BookingsModel->select('bookings.id,lr.consignor_id c_id') 
      ->join('loading_receipts lr','bookings.id = lr.booking_id')
      ->join('customer c','lr.consignor_id = c.id','left')->whereIn('bookings.id',$id)->findAll();  

      $Customers4 =  $this->BookingsModel->select('bookings.id,lr.consignee_id c_id') 
      ->join('loading_receipts lr','bookings.id = lr.booking_id')
      ->join('customer c','lr.consignee_id = c.id','left')->whereIn('bookings.id',$id)->findAll();  

      $Customers5 =  $this->BookingsModel->select('bookings.id,lr.transporter_id c_id') 
      ->join('loading_receipts lr','bookings.id = lr.booking_id')
      ->join('customer c','lr.transporter_id = c.id','left')->whereIn('bookings.id',$id)->findAll(); 
      
      $all_customers = array_merge($Customers,$Customers2,$Customers3,$Customers4,$Customers5); 
      $unique_customers =  array_unique(array_column($all_customers, 'c_id'));
      // echo 'all_customers<pre>';print_r($unique_customers);  
      $customers = [];
      if(!empty($unique_customers)){
        $customer = $this->CModel->select('customer.id,party.id pid,party.party_name')->whereIN('customer.id',$unique_customers)->join('party', 'customer.party_id = party.id')->orderBy('party.party_name')->findAll();
      }
      $data['customers'] = $customer; 
      // echo 'customer<pre>';print_r($customer); exit;
      echo json_encode($data);exit;
    }
}
