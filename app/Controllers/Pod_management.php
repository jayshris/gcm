<?php

namespace App\Controllers;
  
use App\Controllers\BaseController;
use App\Models\BookingsModel;
use App\Models\VehicleModel;
use CodeIgniter\HTTP\ResponseInterface;

class Pod_management extends BaseController
{ 
    public $session; 
    public $TripPausedReasonModel;
    public $BModel;
    public $VehicleModel;
    public function __construct()
    { 
      $this->session = \Config\Services::session(); 
      $this->BModel = new BookingsModel(); 
      $this->VehicleModel = new VehicleModel();
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
        $this->view['bookings'] = $this->BModel->where(['bookings.status' => 11,'is_physical_pod_received' => 1])->orderBy('bookings.id', 'desc')->findAll();
        // echo  $this->BModel->getLastQuery().'<pre>';print_r($this->view['bookings']);exit;
        return view('PodManagement/index', $this->view); 
    } 
   
    function receive_pod(){
        $this->view['vehicles'] = $this->VehicleModel->select('vehicle.id,vehicle.rc_number') 
        ->where(['vehicle.status' =>1])  
        ->findAll(); 

        $this->view['bookings'] = [];

        if ($this->request->getPost('vehicle_id') != '') {
            $query = "(SELECT status_date FROM booking_transactions bt  WHERE booking_status_id = 9 and booking_id = bookings.id order by bt.id desc limit 1) unloading_date";
            $this->BModel->select('bookings.*, party.party_name, v2.rc_number,bp.city bp_city,bd.city bd_city,'.$query)
            ->join('customer', 'customer.id = bookings.customer_id', 'left')
            ->join('party', 'party.id = customer.party_id', 'left')   
            ->join('booking_transactions bts', 'bookings.id = bts.booking_id and booking_status_id =11', 'left')
            ->join('vehicle v2', 'v2.id = bts.vehicle_id', 'left')
            ->join('booking_pickups bp', 'bookings.id = bp.booking_id', 'left')
            ->join('booking_drops bd', 'bookings.id = bd.booking_id', 'left');
            $this->BModel->where('v2.id', $this->request->getPost('vehicle_id'));
            $this->view['bookings'] = $this->BModel->where(['bookings.status' => 11,'is_physical_pod_received' => 0])->orderBy('bookings.id', 'desc')->findAll();
            // echo  $this->BModel->getLastQuery().'<pre>';print_r($this->view['bookings']);exit;
        }
    
        

        return view('PodManagement/receive_pod', $this->view);
    }
}
