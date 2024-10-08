<?php

namespace App\Controllers;
  
use App\Models\VehicleModel;
use App\Models\BookingsModel;
use App\Models\CustomersModel;
use App\Models\PartytypeModel;
use App\Controllers\BaseController;
use App\Models\ShippingCompaniesModel;
use CodeIgniter\HTTP\ResponseInterface;

class Pod_management extends BaseController
{ 
    public $session; 
    public $TripPausedReasonModel;
    public $BModel;
    public $VehicleModel;
    public $CModel;
    public $PTModel;
    public $ShippingCompaniesModel;
    public function __construct()
    { 
      $this->session = \Config\Services::session(); 
      $this->BModel = new BookingsModel(); 
      $this->VehicleModel = new VehicleModel();
      $this->CModel = new CustomersModel();
      $this->PTModel = new PartytypeModel();
      $this->ShippingCompaniesModel = new ShippingCompaniesModel();
    }
  
    public function index()
    {   
        $this->BModel->select('bookings.*, party.party_name, v2.rc_number,bp.city bp_city,bd.city bd_city')
            ->join('customer', 'customer.id = bookings.customer_id', 'left')
            ->join('party', 'party.id = customer.party_id', 'left')   
            ->join('booking_transactions bts', 'bookings.id = bts.booking_id and booking_status_id =11', 'left')
            ->join('vehicle v2', 'v2.id = bts.vehicle_id', 'left')
            ->join('booking_pickups bp', 'bookings.id = bp.booking_id', 'left')
            ->join('booking_drops bd', 'bookings.id = bd.booking_id', 'left');

        if ($this->request->getPost('booking_id') != '') {
            $this->BModel->where('bookings.id', $this->request->getPost('booking_id'));
        }

        if ($this->request->getPost('customer_id') != '') {
            $this->BModel->where('bookings.customer_id', $this->request->getPost('customer_id'));
        }

        if ($this->request->getPost('vehicle_rc') != '') { 
            $this->BModel->where('v2.id', $this->request->getPost('vehicle_rc')); 
        }
            
        $this->view['bookings'] = $this->BModel->where(['bookings.status' => 11,'is_physical_pod_received' => 1])->orderBy('bookings.id', 'desc')->findAll();
        // echo  $this->BModel->getLastQuery().'<pre>';print_r($this->view['bookings']);exit;

        $this->view['booking_numbers'] = $this->BModel->select('id,booking_number')->findAll(); 
        $this->view['vehicles'] = $this->getDriverAssignedVehicles();
        $this->view['customers'] = $this->getCustomers();
        return view('PodManagement/index', $this->view); 
    } 
   
    function getDriverAssignedVehicles(){
            return $this->VehicleModel->select('vehicle.id, vehicle.rc_number, party.party_name')
            ->join('driver_vehicle_map', 'driver_vehicle_map.vehicle_id = vehicle.id','left')
            ->join('driver', 'driver.id = driver_vehicle_map.driver_id','left')
            ->join('party', 'party.id = driver.party_id','left')
            ->where('(driver_vehicle_map.unassign_date = "" or driver_vehicle_map.unassign_date IS NULL or (UNIX_TIMESTAMP(driver_vehicle_map.unassign_date) = 0))')
            ->where('vehicle.status', 1)->groupBy('vehicle.id')->findAll(); 
    }

    function getCustomers(){
        //Get only that customers which party sale is yes
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

    function receive_pod(){
        $this->view['vehicles'] = $this->VehicleModel->select('vehicle.id,vehicle.rc_number') 
        ->where(['vehicle.status' =>1])  
        ->findAll(); 

        $this->view['bookings'] = [];

        if ($this->request->getPost('vehicle_id') != '') {
            $query = "(SELECT status_date FROM booking_transactions bt  WHERE booking_status_id = 9 and booking_id = bookings.id order by bt.id desc limit 1) unloading_date";
            $this->BModel->select('bookings.*, party.party_name,p.party_name transporter_name, v2.rc_number,bp.city bp_city,bd.city bd_city,'.$query)
            ->join('customer', 'customer.id = bookings.customer_id', 'left')
            ->join('party', 'party.id = customer.party_id', 'left')   
            ->join('loading_receipts lr', 'lr.booking_id = bookings.id', 'left')  
            ->join('customer lrc', 'lrc.id = lr.transporter_id','left')
            ->join('party p', 'p.id = lrc.party_id','left') 
            ->join('booking_transactions bts', 'bookings.id = bts.booking_id and booking_status_id =11')
            ->join('vehicle v2', 'v2.id = bts.vehicle_id', 'left')
            ->join('booking_pickups bp', 'bookings.id = bp.booking_id', 'left')
            ->join('booking_drops bd', 'bookings.id = bd.booking_id', 'left'); 
            
            $this->BModel->where('v2.id', $this->request->getPost('vehicle_id'));

            $this->view['bookings'] = $this->BModel->where(['bookings.status' => 11,'is_physical_pod_received' => 0])->orderBy('bookings.id', 'desc')->findAll();
            // echo  $this->BModel->getLastQuery().'<pre>';print_r($this->view['bookings']);exit;
        }
    
        if($this->request->getPost('vehicle_id') && $this->request->getPost('is_physical_pod_received') && $this->request->getPost('pod_received_date')){
            // echo '<pre>';print_r($this->request->getPost());//exit;
            // save pod details
            $success = false;
            foreach ($this->request->getPost('id') as $key => $id) { 
                $is_physical_pod_received = $this->request->getPost('is_physical_pod_received');
                $pod_received_date = $this->request->getPost('pod_received_date');
                if((isset($is_physical_pod_received[$key]) && $is_physical_pod_received[$key] >0) && (isset($pod_received_date[$key]) && $pod_received_date[$key] != '')){                 
                    $this->BModel->update($id,[
                        'is_physical_pod_received' => $this->request->getPost('is_physical_pod_received')[$key],
                        'pod_received_date' => $this->request->getPost('pod_received_date')[$key],
                    ]); 
                    $success = true;
                }
            } 
            if($success){
                $this->session->setFlashdata('success', 'Received POD Successfully'); 
                return $this->response->redirect(base_url('pod_management/receive_pod'));
            }
            
        }

        return view('PodManagement/receive_pod', $this->view);
    }

    function courier_pod(){ 
         $this->view['shipping_companies'] = $this->ShippingCompaniesModel->where(['status'=>1,'isDeleted' =>0])->findAll();
         $this->BModel->select('bookings.*, party.party_name,p.party_name transporter_name, v2.rc_number,bp.city bp_city,bd.city bd_city')
        ->join('customer', 'customer.id = bookings.customer_id', 'left')
        ->join('party', 'party.id = customer.party_id', 'left')   
        ->join('loading_receipts lr', 'lr.booking_id = bookings.id', 'left')  
        ->join('customer lrc', 'lrc.id = lr.transporter_id','left')
        ->join('party p', 'p.id = lrc.party_id','left') 
        ->join('booking_transactions bts', 'bookings.id = bts.booking_id and booking_status_id =11')
        ->join('vehicle v2', 'v2.id = bts.vehicle_id', 'left')
        ->join('booking_pickups bp', 'bookings.id = bp.booking_id', 'left')
        ->join('booking_drops bd', 'bookings.id = bd.booking_id', 'left');
        
        $this->view['bookings'] = $this->BModel->where(['bookings.status' => 11,'is_physical_pod_received' => 1,'tracking_no'=>''])->orderBy('bookings.id', 'desc')->findAll();
        // echo  $this->BModel->getLastQuery().'<pre>';print_r($this->view['bookings']);exit;
        
        if($this->request->getPost('courier_date') && $this->request->getPost('tracking_no') && $this->request->getPost('courier_company_id')){
            // echo '<pre>';print_r($this->request->getPost());//exit;
            // save pod details
            $success = false;
            foreach ($this->request->getPost('id') as $key => $id) { 
                $courier_date = $this->request->getPost('courier_date');
                $tracking_no = $this->request->getPost('tracking_no');
                $courier_company_id = $this->request->getPost('courier_company_id');
                if((isset($courier_date[$key]) && $courier_date[$key] != '') && (isset($tracking_no[$key]) && $tracking_no[$key] != '') && (isset($courier_company_id[$key]) && $courier_company_id[$key] >0)){                 
                    $this->BModel->update($id,[
                        'courier_date' => $this->request->getPost('courier_date')[$key],
                        'tracking_no' => $this->request->getPost('tracking_no')[$key],
                        'courier_company_id' => $this->request->getPost('courier_company_id')[$key],
                    ]); 
                    $success = true;
                }
            } 
            if($success){
                $this->session->setFlashdata('success', 'Courier POD Successfully'); 
                return $this->response->redirect(base_url('pod_management/courier_pod'));
            } 
        }

        return view('PodManagement/courier_pod', $this->view);
    }

    function pod_tracking(){ 
        $this->BModel->select('bookings.*, party.party_name,p.party_name transporter_name, v2.rc_number,bp.city bp_city,bd.city bd_city')
        ->join('customer', 'customer.id = bookings.customer_id', 'left')
        ->join('party', 'party.id = customer.party_id', 'left')   
        ->join('loading_receipts lr', 'lr.booking_id = bookings.id', 'left')  
        ->join('customer lrc', 'lrc.id = lr.transporter_id','left')
        ->join('party p', 'p.id = lrc.party_id','left') 
        ->join('booking_transactions bts', 'bookings.id = bts.booking_id and booking_status_id =11')
        ->join('vehicle v2', 'v2.id = bts.vehicle_id', 'left')
        ->join('booking_pickups bp', 'bookings.id = bp.booking_id', 'left')
        ->join('booking_drops bd', 'bookings.id = bd.booking_id', 'left')
        ->where('courier_delivery_date IS NULL AND courier_date IS NOT NULL');
        
        $this->view['bookings'] = $this->BModel->where(['bookings.status' => 11,'is_physical_pod_received' => 1,'tracking_no !='=>'','courier_company_id >'=>0])->orderBy('bookings.id', 'desc')->findAll();
        // echo  $this->BModel->getLastQuery().'<pre>';print_r($this->view['bookings']);exit;
        
        if($this->request->getPost('courier_delivery_date')){
            // echo '<pre>';print_r($this->request->getPost());exit;
            // save pod details
            $success = false;
            foreach ($this->request->getPost('id') as $key => $id) {  
                $courier_delivery_date = $this->request->getPost('courier_delivery_date');
                if((isset($courier_delivery_date[$key]) && $courier_delivery_date[$key] != '')){                 
                    $this->BModel->update($id,[
                        'courier_delivery_date' => $this->request->getPost('courier_delivery_date')[$key], 
                    ]); 
                    $success = true;
                }
            } 
            if($success){
                $this->session->setFlashdata('success', 'Courier Delivered Successfully');                 
            }else{
                $this->session->setFlashdata('success', 'Some error has been occurred, please try again'); 
            } 
            return $this->response->redirect(base_url('pod_management/pod_tracking'));
        }

        return view('PodManagement/pod_tracking', $this->view);
   }
}
