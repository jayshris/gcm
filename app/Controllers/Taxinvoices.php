<?php

namespace App\Controllers;
   
use App\Models\ProfileModel;
use App\Models\BookingsModel;
use App\Models\CustomersModel;
use App\Models\TaxInvoiceModel;
use App\Models\ExpenseHeadModel;
use App\Controllers\BaseController;
use App\Models\BookingExpensesModel;
use App\Models\ProformaInvoiceModel; 
use CodeIgniter\HTTP\ResponseInterface;

class Taxinvoices extends BaseController
{ 
    public $session; 
    public $BookingsModel;
    public $TaxInvoiceModel;
    public $BEModel;
    public $ExpenseHeadModel;
    public $CModel;
    public $added_by;
    public $profile;
    public function __construct()
    { 
      $this->session = \Config\Services::session(); 
      $this->BookingsModel = new BookingsModel();
      $this->TaxInvoiceModel= new TaxInvoiceModel();
      $this->BEModel = new BookingExpensesModel();
      $this->ExpenseHeadModel = new ExpenseHeadModel();    
      $this->CModel = new CustomersModel();
      $this->added_by = isset($_SESSION['id']) ? $_SESSION['id'] : '0';
      $this->profile = new ProfileModel();
    }
  
    public function index()
    {    
        $this->TaxInvoiceModel->select('*');  
        $this->view['invoices']  = $this->TaxInvoiceModel->select('tax_invoices.*,b.booking_number')
        ->join('bookings b','b.id=tax_invoices.booking_id')->findAll();
        return view('TaxInvoices/index', $this->view); 
    } 
    function getvehicles(){
        return  $this->BookingsModel->select('v.id,v.rc_number') 
        ->join('vehicle v','bookings.vehicle_id = v.id') 
        ->where(['bookings.status >='=> '11']) 
        ->orderBy('v.id', 'desc')
        ->groupBy('bookings.vehicle_id')
        ->findAll();
    }
    function getBooking(){
      return $this->BookingsModel->where(['status >='=> '11'])->findAll();  
    }
    function create(){     
      $this->view['bookings'] = $this->getBooking();  
      $this->view['vehicles'] =  $this->getvehicles();

      if($this->request->getPost()){
        $error = $this->validate([ 
          'booking_id'   =>  'required',
          'bill_to_party_id'   =>  'required',
          'total_freight'   =>  'required'
        ]);   
        if (!$error) {
          $this->view['error']   = $this->validator;
        } else {  
          $this->update_tax_invoice($this->request->getVar());
           
          $this->session->setFlashdata('success', 'Tax Invoice Added Successfully');
          return $this->response->redirect(base_url('/taxinvoices'));
        }
      }
      return view('TaxInvoices/form', $this->view); 
    }
  
    function getVehicleBookings(){   
      if($this->request->getPost('vehicle_id')){
        $this->BookingsModel->where('vehicle_id', $this->request->getPost('vehicle_id'));
      }
      $bookings = $this->BookingsModel->where(['status >='=> '11'])->findAll();       
      echo json_encode($bookings);exit;
    }

    function update_tax_invoice($post,$id =0){
      // echo $id.'<pre>';print_r($post); 
      if($id>0){
        $data['id'] = $id;
        $data['updated_by'] = $this->added_by;
      }else{
        $profile =  $this->profile->where('logged_in_userid',  session()->get('id'))->first();//echo __LINE__.'<pre>';print_r($profile);die;
        $lastr = $this->TaxInvoiceModel->orderBy('id', 'desc')->first();
        $lastr = isset($lastr['id']) ? ((int)$lastr['id']+1) : 1; 
        $data['invoices_no'] = isset($profile['tax_invoice_prefix']) && !empty($profile['tax_invoice_prefix']) ? $profile['tax_invoice_prefix'].'/'.date('m').'/000'.$lastr : 'PR/'.date('m').'/000'.$lastr;
        $data['created_by'] =$this->added_by;
      }
      $data['booking_id'] = $post['booking_id'];
      $data['bill_to_party_id'] = $post['bill_to_party_id'];
      $data['total_freight'] = $post['total_freight']; 
      // echo  'Invoice <pre>';print_r($data);exit;
      $this->TaxInvoiceModel->save($data);
      
      if($post['expense']){
        // update Expences 
        $this->BEModel->where('booking_id', $data['booking_id'])->delete();
        // save expenses 
        foreach ($post['expense'] as $key => $val) {
          if(($post['expense'][$key]) || $post['expense_value'][$key] || isset($post['expense_flag_' . $key +1])){
            $expense_data = [
                'booking_id' => $data['booking_id'],
                'expense' => $post['expense'][$key],
                'value' => $post['expense_value'][$key],
                'bill_to_party' =>isset($post['expense_flag_' . $key +1]) && ($post['expense_flag_' . $key +1] == 'on') ? '1' : '0'
            ]; 
            // echo  'expense_data <pre>';print_r($expense_data);
            $this->BEModel->insert($expense_data);
          }
        }    
        $booking['discount'] = $post['discount'];
        $booking['balance'] = $post['balance'];
        $booking['guranteed_wt'] = $post['guranteed_wt']; 
        $booking['advance'] = $post['advance']; 
        $booking['rate'] = $post['rate'];   
      }
      $booking['freight'] = $post['total_freight'];
      // echo  $post['booking_id'].' booking <pre>';print_r($booking);exit;
      $this->BookingsModel->update($post['booking_id'],$booking); 
    } 

    function edit($id){  
      $this->view['bookings'] = $this->getBooking();  
      $this->view['vehicles'] =  $this->getvehicles();
      $this->view['token'] = $id; 
      $this->view['invoice'] = $this->TaxInvoiceModel->where(['id' => $id])->first(); 
      
      if($this->request->getPost()){
        $error = $this->validate([ 
          'booking_id'   =>  'required',
          'bill_to_party_id'   =>  'required',
          'total_freight'   =>  'required'
        ]);   
        if (!$error) {
          $this->view['error']   = $this->validator;
        } else {            
          $this->update_tax_invoice($this->request->getVar(),$id);           
          $this->session->setFlashdata('success', 'Tax Invoice Updated Successfully');
          return $this->response->redirect(base_url('/taxinvoices'));
        }
      }
      return view('TaxInvoices/form', $this->view); 
    } 
  
    public function delete($id = null)
    {   
        $this->TaxInvoiceModel->where('id', $id)->delete($id); 
        $this->session->setFlashdata('success', 'Tax Invoice has been deleted successfully');
        return $this->response->redirect(base_url('/taxinvoices')); 
    }
  
    function preview($id){ 
      $this->view['invoice'] = $this->TaxInvoiceModel
      ->select('tax_invoices.*,b.*,p.*,v.rc_number,s.state_name,bps.state_name pickup_state,bds.state_name drop_state')
      ->join('bookings b','b.id=tax_invoices.booking_id')
      ->join('booking_pickups bp','b.id=bp.booking_id')
      ->join('states bps', 'bp.state = bps.state_id','left')
      ->join('booking_drops bd','b.id=bd.booking_id')
      ->join('states bds', 'bd.state = bds.state_id','left')
      ->join('vehicle v', 'v.id = b.vehicle_id','left')
      ->join('customer c','c.id=tax_invoices.bill_to_party_id')
      ->join('party p','c.party_id = p.id')
      ->join('states s', 'p.state_id = s.state_id','left')
      ->where(['tax_invoices.id' => $id])->first(); 

      $this->view['booking_expences'] = $this->BEModel->select('booking_expenses.*,eh.*')
      ->join('expense_heads eh','eh.id = booking_expenses.expense')
      ->where('booking_expenses.booking_id', $this->view['invoice']['booking_id'])
      ->where('booking_expenses.bill_to_party',1)
      ->findAll();   
      //  echo '<pre>';print_r($this->view['booking_expences']);exit;
      return view('TaxInvoices/preview', $this->view); 
    }

    function getBookingExpense($id){ 
      $this->view['booking_details'] = $this->BookingsModel->where(['id'=> $id])->first();  
      $this->view['booking_expences'] = $this->BEModel->where('booking_id', $id)->findAll();  
      $this->view['expense_heads'] =  $this->ExpenseHeadModel->orderBy('head_name', 'asc')->findAll();

      // echo 'expense_heads <pre>';print_r($this->view['expense_heads']);
      // echo 'booking_expences <pre>';print_r($this->view['booking_expences']);
      // exit;
      echo view('TaxInvoices/expense_block', $this->view);
    } 
    function getBookingCustomers($id){ 
      $Customers =  $this->BookingsModel->select('bookings.id, c.id c_id ') 
      ->join('customer c','bookings.customer_id = c.id')->where(['bookings.id'=> $id])->findAll();  

      $Customers2 =  $this->BookingsModel->select('bookings.id,c.id c_id') 
      ->join('customer c','bookings.bill_to_party = c.id')->where(['bookings.id'=> $id])->findAll();  

      $Customers3 =  $this->BookingsModel->select('bookings.id,lr.consignor_id c_id') 
      ->join('loading_receipts lr','bookings.id = lr.booking_id')
      ->join('customer c','lr.consignor_id = c.id','left')->where(['bookings.id'=> $id])->findAll();  

      $Customers4 =  $this->BookingsModel->select('bookings.id,lr.consignee_id c_id') 
      ->join('loading_receipts lr','bookings.id = lr.booking_id')
      ->join('customer c','lr.consignee_id = c.id','left')->where(['bookings.id'=> $id])->findAll();  
      
      $all_customers = array_merge($Customers,$Customers2,$Customers3,$Customers4); 
      $unique_customers =  array_unique(array_column($all_customers, 'c_id'));
      // echo 'all_customers<pre>';print_r($unique_customers);  
      $customers = [];
      if(!empty($unique_customers)){
        $customers = $this->CModel->whereIN('customer.id',$unique_customers)->join('party', 'customer.party_id = party.id')->orderBy('party.party_name')->findAll();
      }
      echo json_encode($customers);exit;
    }

    function getBookingDetails($id){
      $bookings = $this->BookingsModel->where('id', $id)->first();       
      echo json_encode($bookings);exit;
    }
}
