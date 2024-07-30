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
    echo 'sdf';exit;
    $this->view['booking'] = $this->LoadingReceiptModel->select('loading_receipts.id,b.booking_number')
    ->join('bookings b','loading_receipts.booking_id = b.id')
    ->orderBy('id', 'desc')->findAll();
    $this->view['rc_number'] = $this->LoadingReceiptModel->select('v.rc_number')
    ->join('bookings b','loading_receipts.booking_id = b.id')
    ->orderBy('id', 'desc')->findAll();
    return view('ConsignmentNoteOfficialUse/index', $this->view); 
  } 

  function preview($id){ 
  }
}
