<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\StateModel;
use App\Models\OfficeModel;
use App\Models\ProfileModel;
use App\Models\VehicleModel;
use App\Models\BookingsModel; 
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class LoadingReceipt extends BaseController
{ 
  public $OModel;
  public $BookingsModel;
  public $VModel;
  public function __construct()
  {
    $u = new UserModel(); 
    $this->OModel = new OfficeModel();
    $this->BookingsModel = new BookingsModel();
    $this->VModel = new VehicleModel();
  }

  public function index()
  {  
    return view('LoadingReceipt/index', $this->view); 
  } 

  function create(){  
    $stateModel = new StateModel();
    $this->view['states'] = $stateModel->where(['isStatus' => '1'])->orderBy('state_name', 'ASC')->findAll();
    $this->view['offices'] = $this->OModel->where('status', '1')->findAll();
    $this->view['bookings'] = $this->BookingsModel->where('status', '1')->findAll();
    $this->view['vehicles'] = $this->VModel->where('status', 1)->findAll();
    return view('LoadingReceipt/create', $this->view); 
  }

  function getBookingDetails(){
    $rows =  $this->BookingsModel->where('id', $this->request->getPost('booking_id'))->first();
    echo json_encode($rows);exit;
  }
}
