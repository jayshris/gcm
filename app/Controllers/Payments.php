<?php

namespace App\Controllers;
   
use App\Models\DriverModel;
use App\Models\PaymentModel;
use App\Models\ProfileModel;
use App\Models\VehicleModel;
use App\Models\BookingsModel;
use App\Models\CustomersModel;
use App\Models\TaxInvoiceModel;
use App\Models\ExpenseHeadModel;
use App\Models\PaymentModeModel;
use App\Models\PaymentTypeModel;
use App\Models\FuelPumpBrandModel;
use App\Controllers\BaseController;
use App\Models\BookingExpensesModel;
use App\Models\ProformaInvoiceModel;
use CodeIgniter\HTTP\ResponseInterface;

class Payments extends BaseController
{ 
    public $session; 
    public $BookingsModel;
    public $TaxInvoiceModel;
    public $BEModel;
    public $ExpenseHeadModel;
    public $CModel;
    public $added_by;
    public $PaymentTypeModel;
    public $PaymentModel;
    public $VehicleModel;
    public $FuelPumpBrandModel;
    public $DModel;
    public $PaymentModeModel;
    
    public function __construct()
    { 
      $this->session = \Config\Services::session(); 
      $this->BookingsModel = new BookingsModel();
      $this->TaxInvoiceModel= new TaxInvoiceModel();
      $this->BEModel = new BookingExpensesModel();
      $this->ExpenseHeadModel = new ExpenseHeadModel();    
      $this->CModel = new CustomersModel();
      $this->added_by = isset($_SESSION['id']) ? $_SESSION['id'] : '0'; 
      $this->PaymentTypeModel = new PaymentTypeModel();
      $this->PaymentModel = new PaymentModel();
      $this->VehicleModel = new VehicleModel();
      $this->FuelPumpBrandModel = new FuelPumpBrandModel();
      $this->DModel = new DriverModel();
      $this->PaymentModeModel = new PaymentModeModel();
    }
  
    public function index()
    {      
        $this->view['payments']  = $this->PaymentModel
        ->select('payments.*,p.party_name,pt.name payment_type,v.rc_number')
        ->join('driver d','d.id= payments.driver_id','left')
        ->join('party p', 'p.id = d.party_id','left') 
        ->join('payment_types pt','pt.id= payments.payment_type_id') 
        ->join('vehicle v', 'v.id = payments.vehicle_id','left') 
        ->findAll();
        // echo ' <pre>';print_r($this->view['payments']); exit;
        return view('Payment/index', $this->view); 
    }  

    function create(){
        $this->view['drivers'] = $this->DModel->select('driver.*,v.rc_number, party.party_name as driver_name,b.id b_id,b.booking_number')  
        ->join('party', 'party.id = driver.party_id') 
        ->join('driver_vehicle_map dvm', 'dvm.driver_id = driver.id and (dvm.unassign_date="" or dvm.unassign_date IS NULL or UNIX_TIMESTAMP(dvm.unassign_date) = 0)')
        ->join('vehicle v', 'dvm.vehicle_id = v.id')
        ->join('booking_vehicle_logs bvl', 'bvl.vehicle_id = v.id  and (bvl.unassign_date IS NULL or UNIX_TIMESTAMP(bvl.unassign_date) = 0)')
        ->join('bookings b', 'bvl.booking_id = b.id')
        ->where(['b.status >=' => 3,'b.status < '=>11])
        ->groupBy('v.id,driver.id')
        ->orderBy('party.party_name', 'asc')
        ->findAll();
        
        // echo $this->DModel->getLastQuery().'<pre>';print_r($this->view['drivers']); exit;

        $this->view['fuel_pump_brands']  = $this->FuelPumpBrandModel->where('status',1)->findAll(); 
        $this->view['payment_types']  = $this->PaymentTypeModel->findAll(); 
        
        //get vendors
        $this->view['vendors'] = $this->CModel
        ->select('customer.id,p.party_name')
        ->join('party p', 'p.id = customer.party_id') 
        ->where("FIND_IN_SET (6,customer.party_type_id)")
        ->findAll(); 

        $paymentTypeM = $this->PaymentTypeModel->where(['name'=>'Money'])->first(); 
        $payment_type_id = isset($paymentTypeM['id']) ? $paymentTypeM['id'] : 0;
        
        $this->view['money_payment_type_id'] = $payment_type_id;

        $this->view['payment_modes'] = $this->PaymentModeModel->findAll(); 
        // echo $this->PaymentModeModel->getLastQuery().'<pre>';print_r($this->view['payment_modes']); exit;
        if($this->request->getPost()){
            $error = $this->validate([ 
                'amount' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'The amount field is required'
                    ],
                ],
                'payment_mode' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'The payment mode field is required'
                    ],
                ], 
            ]);
            if($this->request->getPost('payment_for') == 'driver'){
                $this->validate([
                    'driver_id' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The driver field is required'
                        ],
                    ],
                    'payment_type_id' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The payment type field is required'
                        ],
                    ], 
                ]);
                $payment_type_id = $this->request->getPost('payment_type_id');
            } 

            if($this->request->getPost('payment_type_id') == 1){
                $this->validate([
                    'fuel_fill_type' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The fuel fill type field is required'
                        ],
                    ],
                ]);
            }

            if($this->request->getPost('payment_type_id') == 2){
                $this->validate([
                    'vendor_id' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The vendor field is required'
                        ],
                    ],
                ]);
            }

            if($this->request->getPost('payment_type_id') == 1 || $this->request->getPost('payment_type_id') == 2){
                $this->validate([
                    'vehicle_id' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The vehicle field is required'
                        ],
                    ],
                ]);

                $this->validate([
                    'quantity' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The quantity field is required'
                        ],
                    ],
                ]);

                $this->validate([
                    'km_reading' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The km reading is required'
                        ],
                    ],
                ]);
            }

            if($this->request->getPost('fuel_fill_type') == 1){
                $this->validate([
                    'transfer_from_vehicle_id' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The transfer from vehicle field is required'
                        ],
                    ],
                ]);
            }

            if($this->request->getPost('fuel_fill_type') == 2){
                $this->validate([
                    'fuel_pump_brand_id' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The fuel pump brand field is required'
                        ],
                    ],
                ]);
            }

            if($this->request->getPost('payment_mode') == 1){
                $this->validate([
                    'card_no' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The card no field is required'
                        ],
                    ],
                ]);
            }

            if($this->request->getPost('payment_mode') == 2){
                $this->validate([
                    'upi_no' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The upi no field is required'
                        ],
                    ],
                ]);
            }

            if($this->request->getPost('payment_mode') == 3){
                $this->validate([
                    'account_no' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The account no field is required'
                        ],
                    ],
                ]);
            }
            $validation = \Config\Services::validation();
            // echo 'POst dt<pre>';print_r($this->request->getPost());
            // echo 'getErrors<pre>';print_r($validation->getErrors()); //exit;
            if (!empty($validation->getErrors())) {
                $this->view['error'] = $this->validator;
            } else {  
              $data['fuel_fill_type'] = ($this->request->getVar('fuel_fill_type')) ? $this->request->getVar('fuel_fill_type') : '';
              $data['vehicle_id'] = ($this->request->getVar('vehicle_id')) ? $this->request->getVar('vehicle_id') : 0;
              $data['driver_id'] = ($this->request->getVar('driver_id')) ? $this->request->getVar('driver_id') : '';
              $data['transfer_from_vehicle_id'] = ($this->request->getVar('transfer_from_vehicle_id')) ? $this->request->getVar('transfer_from_vehicle_id') : '';
              $data['km_reading'] = ($this->request->getVar('km_reading')) ? $this->request->getVar('km_reading') : '';
              $data['quantity'] = ($this->request->getVar('quantity')) ? $this->request->getVar('quantity') : '';
              $data['fuel_pump_brand_id'] = ($this->request->getVar('fuel_pump_brand_id')) ? $this->request->getVar('fuel_pump_brand_id') : '';
              $data['vendor_id'] = ($this->request->getVar('vendor_id')) ? $this->request->getVar('vendor_id') : '';
              $data['amount'] = ($this->request->getVar('amount')) ? $this->request->getVar('amount') : '';
              $data['payment_type_id'] = $payment_type_id;
              $data['payment_mode'] = $this->request->getVar('payment_mode');
              $data['card_no'] = $this->request->getVar('card_no');
              $data['upi_no'] = $this->request->getVar('upi_no');
              $data['account_no'] = $this->request->getVar('account_no');
              $data['transaction_no'] = $this->request->getVar('transaction_no');
              $data['reason_id'] = ($this->request->getVar('reason_id')) ? $this->request->getVar('reason_id') : ''; 
              $data['payment_for'] = $this->request->getVar('payment_for');
              $data['created_by'] =  $this->added_by;
              
            //   echo 'data<pre>';print_r($data);exit;

              $this->PaymentModel->save($data); 
              
              $this->session->setFlashdata('success', 'Payment Added Successfully');
      
              return $this->response->redirect(base_url('/payments'));
            }
          }

        return view('Payment/form', $this->view); 
    }

    function getDriverVehicles(){
        $driverVehicles = $this->VehicleModel->select('vehicle.id,vehicle.rc_number')   
        ->join('driver_vehicle_map dvm', 'dvm.vehicle_id = vehicle.id and (dvm.unassign_date="" or dvm.unassign_date IS NULL or UNIX_TIMESTAMP(dvm.unassign_date) = 0)')
        ->where(['vehicle.status' =>1,'dvm.driver_id' =>  $this->request->getVar('driver_id')])  
        ->findAll(); 
        echo json_encode($driverVehicles);exit;
    }
    function getSameTypesVehicles(){
        $vehicleType = $this->VehicleModel->select('vehicle.vehicle_type_id')->where(['id' =>  $this->request->getVar('vehicle_id')])->first();   
        
        $vehicles = $this->VehicleModel->select('vehicle.id,vehicle.rc_number')    
        ->where(['vehicle.status' =>1,'vehicle.vehicle_type_id'=>$vehicleType,'vehicle.id !=' =>  $this->request->getVar('vehicle_id')])  
        ->findAll();
        // echo $this->DModel->getLastQuery().'<pre>';print_r($vehicles); exit;
        echo json_encode($vehicles);exit;
    }

    function getDriverBookings(){
        $bookings = $this->DModel->select('b.id b_id,b.booking_number')  
        ->join('driver_vehicle_map dvm', 'dvm.driver_id = driver.id and (dvm.unassign_date="" or dvm.unassign_date IS NULL or UNIX_TIMESTAMP(dvm.unassign_date) = 0)')
        ->join('vehicle v', 'dvm.vehicle_id = v.id')
        ->join('booking_vehicle_logs bvl', 'bvl.vehicle_id = v.id  and (bvl.unassign_date IS NULL or UNIX_TIMESTAMP(bvl.unassign_date) = 0)')
        ->join('bookings b', 'bvl.booking_id = b.id')
        ->where(['b.status >=' => 3,'b.status < '=>11,'driver.id' =>$this->request->getVar('driver_id')])  
        ->findAll();
        echo json_encode($bookings);exit;
    }
}
