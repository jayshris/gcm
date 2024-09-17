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
use App\Models\BookingTransactionModel;
use CodeIgniter\HTTP\ResponseInterface;

class Bookingreport extends BaseController
{ 
    public $OModel;
    public $BookingsModel;
    public $VModel;
    public $LoadingReceiptModel;
    public $session;
    public $profile;
    public $BookingTransactionModel;

    public function __construct()
    {
      $u = new UserModel(); 
      $this->OModel = new OfficeModel();
      $this->BookingsModel = new BookingsModel();
      $this->VModel = new VehicleModel();
      $this->LoadingReceiptModel = new LoadingReceiptModel();
      $this->session = \Config\Services::session();
      $this->profile = new ProfileModel();
      $this->BookingTransactionModel = new BookingTransactionModel();
    }
   
    function index(){
        $this->view['bookings'] = $this->BookingsModel->select('id,booking_number')
        ->orderBy('id', 'desc')->findAll();  
  
        $this->view['rc_number'] =  $this->VModel->select('id,rc_number')  
        ->orderBy('id', 'desc')->findAll(); 

        $this->BookingTransactionModel->select('booking_transactions.*,b.booking_number,bs.status_name,v.rc_number,p.party_name,tp.name resaon');

        if ($this->request->getPost('booking_id') != '') {
          $this->BookingTransactionModel->where('booking_transactions.booking_id', $this->request->getPost('booking_id'));
        }

        if ($this->request->getPost('vehicle_id') != '') {
          $this->BookingTransactionModel->where('booking_transactions.vehicle_id', $this->request->getPost('vehicle_id'));
        }

        $this->view['booking_transactions'] = $this->BookingTransactionModel
                                    ->join('bookings b','b.id = booking_transactions.booking_id')
                                    ->join('booking_status bs','bs.id = booking_transactions.booking_status_id')
                                    ->join('vehicle v','v.id = booking_transactions.vehicle_id','left')
                                    ->join('driver d','d.id = booking_transactions.driver_id','left')
                                    ->join('party p','p.id = d.party_id','left')
                                    ->join('trip_paused_reasons tp','tp.id = booking_transactions.reason_id','left')
                                    ->findAll();
        // echo '<pre>';print_r($this->view['booking_transactions']);exit;
        return view('Bookingreport/index', $this->view);
    }

    function preview($id){    
      return view('Bookingreport/preview', $this->view); 
    }
  }
