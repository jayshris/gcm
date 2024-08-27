<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\DriverModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\StateModel;
use App\Models\ForemanModel;
use App\Models\AadhaarNumberMapModule;
use App\Models\DriverSchemeMapModel;
use App\Models\DriverVehicleAssignModel;
use App\Models\PartyModel;
use App\Models\VehicleTypeModel;
use App\Models\PartytypeModel;
use App\Models\PartyTypePartyModel;
use App\Models\DriverVehicleType;
use App\Models\PartyDocumentsModel;
use App\Models\SchemesModel;
use App\Models\VehicleModel;

class Driver extends BaseController
{
  public $_access;

  public function __construct()
  {
    $this->session = \Config\Services::session();
    $u = new UserModel();
    $access = $u->setPermission();
    $this->_access = $access;
    $this->partyModel = new PartyModel();
    $this->partyTypeModel = new PartytypeModel();
    $this->partyTypePartyModel = new PartyTypePartyModel();
    $this->vehicletypeDriver =  new DriverVehicleType();
    $this->vehicletype = new VehicleTypeModel();
    $this->DVAModel = new DriverVehicleAssignModel();
    $this->VTModel = new VehicleTypeModel();
    $this->VModel = new VehicleModel();
    $this->DModel = new DriverModel();
    $this->SCModel = new SchemesModel();
    $this->DSMModel = new DriverSchemeMapModel();
    $this->PDModel = new PartyDocumentsModel();

    $this->added_by = isset($_SESSION['id']) ? $_SESSION['id'] : '0';
    $this->added_ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
  }

  public function index()
  {
    $foremanModel = new ForemanModel();
    $this->view['foremen'] = $foremanModel->select('foreman.*, party.party_name as foreman_name')
      ->join('party', 'party.id = foreman.party_id')
      ->orderBy('party.party_name', 'asc')
      ->findAll();

    $this->view['drivers'] = $this->DModel->select('driver.*, party.party_name as driver_name')
      ->join('party', 'party.id = driver.party_id')
      ->orderBy('party.party_name', 'asc')
      ->findAll();

    $driverModel1 = new DriverModel();
    $driverModel1->select('driver.*, t2.party_name, t2.status, t4.party_name as foreman_name')
      ->join('party' . ' t2', 't2.id = driver.party_id')
      ->join('foreman' . ' t3', 't3.id = driver.foreman_id')
      ->join('party' . ' t4', 't4.id = t3.party_id');

    $driverModel = new DriverModel();
    $query = "(SELECT COUNT(bt.id) FROM booking_transactions bt WHERE booking_status_id = 11 and vehicle_id = v.id and driver_id =driver.id) total_completed_trips";
    
    $driverModel->select('driver.*, t2.party_name,t2.primary_phone, t2.status, t4.party_name as foreman_name,v.rc_number,b.booking_number,dvm.unassign_date, '.$query.'')
      ->join('party' . ' t2', 't2.id = driver.party_id')
      ->join('foreman' . ' t3', 't3.id = driver.foreman_id')
      ->join('party' . ' t4', 't4.id = t3.party_id')
      ->join('driver_vehicle_map  dvm', 'driver.id = dvm.driver_id and (dvm.unassign_date IS NULL or dvm.unassign_date="")','left')
      ->join('vehicle  v', 'v.id = dvm.vehicle_id','left')
      ->join('booking_vehicle_logs  bvl', 'v.id = bvl.vehicle_id and bvl.unassigned_by= 0','left')
      ->join('bookings  b', 'b.id = bvl.booking_id','left');

    if ($this->request->getPost('working_status') != '') {
      $driverModel->where('driver.working_status', $this->request->getPost('working_status'));
    }

    if ($this->request->getPost('driver_id') != '') {
      $driverModel->where('driver.id', $this->request->getPost('driver_id'));
    }

    if ($this->request->getPost('foreman_id') != '') {
      $driverModel->where('t3.id', $this->request->getPost('foreman_id'));
    }
    $driverModel->groupBy('driver.id');
    $this->view['driver_data'] = $driverModel->orderBy('t2.party_name', 'asc')->findAll();
    $this->view['DVAModel'] = $this->DVAModel;

    $this->view['page_data'] = ['page_title' => view('partials/page-title', ['title' => 'Driver', 'li_1' => '123', 'li_2' => 'deals'])];
    return view('Driver/index', $this->view);
  }

  public function create()
  {    
    helper(['form', 'url']);
    $this->view['page_data'] = [
      'page_title' => view('partials/page-title', ['title' => 'Add Driver', 'li_2' => 'profile'])
    ];

    $stateModel = new StateModel();
    $this->view['state'] = $stateModel->where(['isStatus' => '1'])->orderBy('state_name', 'ASC')->findAll();
    $this->view['partytpe'] = $this->partyTypeModel->like('name', '%Driver%')->first();
    
    if (isset($this->view['partytpe'])) {
      $this->view['party_map_data'] = $this->partyTypePartyModel->where(['party_type_id' => $this->view['partytpe']['id']])->findAll();
    }

    $this->view['vehicletypes'] = $this->vehicletype->where('status', 'Active')->findAll();

    $foremanModel = new ForemanModel();
    $this->view['foreman'] = $foremanModel->findAll();

    $PartyModel = new PartyModel();
    // $this->view['parties'] = $PartyModel->where('status', '1')->findAll();

    $this->view['parties'] = $PartyModel->select('party.*,driver.party_id')
      ->join('driver', 'driver.party_id = party.id', 'left')
      ->where('driver.party_id', null)
      ->where('party.status', '1')->orderBy('party_name', 'ASC')->findAll();

    $this->view['schemes'] = $this->SCModel->orderBy('id', 'ASC')->findAll();

    if ($this->request->getMethod() == 'POST') {
      $error = $this->validate([
        'foreman_id'              =>  'required',
        'driver_type'             =>  'required',
      ]);
      if (!$error) {
        $this->view['error']   = $this->validator;
      } else {
        $driverModel = new DriverModel();

        $newName1 = '';
        $image1 = $this->request->getFile('profile_image1');
        if ($image1->isValid() && !$image1->hasMoved()) {
          $newName1 = $image1->getRandomName();
          $imgpath1 = 'public/uploads/driverDocs';
          if (!is_dir($imgpath1)) {
            mkdir($imgpath1, 0777, true);
          }
          $image1->move($imgpath1, $newName1);
        }
        $image_name1 = $newName1;


        $newName2 = '';
        $image2 = $this->request->getFile('profile_image2');
        if ($image2->isValid() && !$image2->hasMoved()) {
          $newName2 = $image2->getRandomName();
          $imgpath2 = 'public/uploads/driverDocs';
          if (!is_dir($imgpath2)) {
            mkdir($imgpath2, 0777, true);
          }
          $image2->move($imgpath2, $newName2);
        }
        $image_name2 = $newName2;


        $newName3 = '';
        $image3 = $this->request->getFile('dl_image_front');
        if ($image3->isValid() && !$image3->hasMoved()) {
          $newName3 =  $image3->getRandomName();

          $imgpath3 = 'public/uploads/driverDocs';
          if (!is_dir($imgpath3)) {
            mkdir($imgpath3, 0777, true);
          }
          $image3->move($imgpath3, $newName3);
        }
        $image_name3 =  $newName3;


        $newName4 = '';
        $image4 = $this->request->getFile('dl_image_back');
        if ($image4->isValid() && !$image4->hasMoved()) {
          $newName4 =  $image4->getRandomName();
          $imgpath4 = 'public/uploads/driverDocs';
          if (!is_dir($imgpath4)) {
            mkdir($imgpath4, 0777, true);
          }
          $image4->move($imgpath4, $newName4);
        }
        $image_name4 = $newName4;


        $newName5 = '';
        $image5 = $this->request->getFile('upi_id');
        if ($image5->isValid() && !$image5->hasMoved()) {
          $newName5 =  $image5->getRandomName();
          $imgpath5 = 'public/uploads/driverDocs';
          if (!is_dir($imgpath5)) {
            mkdir($imgpath5, 0777, true);
          }
          $image5->move($imgpath5, $newName5);
        }
        $image_name5 = $newName5;


        $driverModel->save([

          'party_id'  =>  $this->request->getVar('party_id'),
          'foreman_id'  =>  $this->request->getVar('foreman_id'),
          'driver_type'  =>   $this->request->getPost('driver_type'),
          'bank_ac' => $this->request->getPost('bank_account_number'),
          'bank_ifsc' => $this->request->getPost('bank_ifsc_code'),
          'whatsapp_no' => $this->request->getPost('whatsapp'),
          'dl_no' => $this->request->getPost('dl_no'),
          'dl_authority' => $this->request->getPost('dl_authority'),
          'dl_dob' => $this->request->getPost('dl_dob'),
          'dl_expiry' => $this->request->getPost('dl_expiry'),
          'dl_image_front' => $image_name3,
          'dl_image_back' => $image_name4,
          'upi_text' => $this->request->getPost('upi'),
          'upi_id'    =>  $image_name5,
          'profile_image1'  =>  $image_name1,
          'profile_image2'  => $image_name2,
          'address'  =>   $this->request->getPost('address'),
          'city'  =>   $this->request->getPost('city'),
          'state'  =>  $this->request->getPost('state'),
          'zip'  =>  $this->request->getPost('zip'),
          'working_status'  =>  '1',
          'created_at'  =>  date("Y-m-d h:i:sa")
        ]);

        $user_id = $driverModel->getInsertID();

        $vehicle = $this->request->getVar('vehicle_types');
        foreach ($vehicle as $key => $value) {
          $vehicledata = [
            'vehicle_type_id' =>  $value,
            'driver_id'       =>  $user_id,
          ];
          $this->vehicletypeDriver->save($vehicledata);
        }

        // add scheme
        $this->DSMModel->insert([
          'driver_id' => $user_id,
          'scheme_id' => $this->request->getPost('scheme_id'),
          'added_date' => date("Y-m-d h:i:sa")
        ]);

        $session = \Config\Services::session();
        $session->setFlashdata('success', 'Driver Added');
        return $this->response->redirect(base_url('driver'));
      }
    }
    return view('Driver/create', $this->view);
  }

  public function edit($id = null)
  {
    if (session()->get('isLoggedIn')) {
      $login_id = session()->get('id');
    }
    if (isset($login_id)) {
      $user = new UserModel();
      $user = $user->where('id', $login_id)->first();
    }
    $stateModel = new StateModel();
    $this->view['state'] = $stateModel->where(['isStatus' => '1'])->orderBy('state_name', 'ASC')->findAll();

    $driverModel = new DriverModel();
    $this->view['driver_data'] = $driverModel->select('driver.*,party.email,party.primary_phone')
      ->join('party', 'party.id = driver.party_id')
      ->where('driver.id', $id)->first();

    $this->view['vehicletypes'] = $this->vehicletype->where('status', 'Active')->findAll();
    $this->view['vehicletypesdriver'] = $this->vehicletypeDriver->where('driver_id', $id)->findAll();

    $foremanModel = new ForemanModel();
    $this->view['foreman'] = $foremanModel->select('foreman.*, party.party_name, party.id as party_id')
      ->join('party', 'foreman.party_id = party.id')
      ->findAll();

    $PartyModel = new PartyModel();
    $this->view['parties'] = $PartyModel->where('status', '1')->orderBy('party_name', 'ASC')->findAll();

    $this->view['schemes'] = $this->SCModel->orderBy('id', 'ASC')->findAll();
    $this->view['driver_scheme'] = $this->DSMModel->where('driver_id', $id)->first();

    if ($this->request->getMethod() == 'POST') {
      $driverModel = new DriverModel();

      $driverModel->update($id, [
        'name'  =>  $this->request->getVar('name'),
        'foreman_id'  =>  $this->request->getVar('foreman_id'),
        'driver_type'  =>   $this->request->getPost('driver_type'),
        'bank_ac' => $this->request->getPost('bank_account_number'),
        'bank_ifsc' => $this->request->getPost('bank_ifsc_code'),
        'whatsapp_no' => $this->request->getPost('whatsapp'),
        'dl_no' => $this->request->getPost('dl_no'),
        'dl_authority' => $this->request->getPost('dl_authority'),
        'dl_dob' => $this->request->getPost('dl_dob'),
        'dl_expiry' => $this->request->getPost('dl_expiry'),
        'upi_text' => $this->request->getPost('upi'),
        'address'  =>   $this->request->getPost('address'),
        'city'  =>   $this->request->getPost('city'),
        'state'  =>  $this->request->getPost('state'),
        'zip'  =>  $this->request->getPost('zip'),
        'working_status' =>  '1',
        'updated_at' =>  date("Y-m-d h:i:sa"),
      ]);

      // update image if uploaded

      // dl front
      if ($_FILES['dl_image_front']['name'] != '') {
        $newName1 = '';
        $image1 = $this->request->getFile('dl_image_front');
        if ($image1->isValid() && !$image1->hasMoved()) {
          $newName1 =  $image1->getRandomName();
          $imgpath1 = 'public/uploads/driverDocs';
          if (!is_dir($imgpath1)) {
            mkdir($imgpath1, 0777, true);
          }
          $image1->move($imgpath1, $newName1);
        }

        $driverModel->update($id, ['dl_image_front' => $newName1]);
      }

      if ($_FILES['dl_image_back']['name'] != '') {
        $newName2 = '';
        $image2 = $this->request->getFile('dl_image_back');
        if ($image2->isValid() && !$image2->hasMoved()) {
          $newName2 =  $image2->getRandomName();
          $imgpath2 = 'public/uploads/driverDocs';
          if (!is_dir($imgpath2)) {
            mkdir($imgpath2, 0777, true);
          }
          $image2->move($imgpath2, $newName2);
        }
        $image_namexx = $newName2;

        $driverModel->update($id, ['dl_image_back' => $newName2]);
      }


      if ($_FILES['upi_id']['name'] != '') {
        $newName3 = '';
        $image3 = $this->request->getFile('upi_id');
        if ($image3->isValid() && !$image3->hasMoved()) {
          $newName3 =  $image3->getRandomName();
          $imgpath3 = 'public/uploads/driverDocs';
          if (!is_dir($imgpath3)) {
            mkdir($imgpath3, 0777, true);
          }
          $image3->move($imgpath3, $newName3);
        }
        $image_namexx = $newName3;

        $driverModel->update($id, ['upi_id' => $newName3]);
      }

      if ($_FILES['profile_image1']['name'] != '') {
        $newName4 = '';
        $image4 = $this->request->getFile('profile_image1');
        if ($image4->isValid() && !$image4->hasMoved()) {
          $newName4 =  $image4->getRandomName();
          $imgpath4 = 'public/uploads/driverDocs';
          if (!is_dir($imgpath4)) {
            mkdir($imgpath4, 0777, true);
          }
          $image4->move($imgpath4, $newName4);
        }
        $image_namexx = $newName4;

        $driverModel->update($id, ['profile_image1' => $newName4]);
      }

      if ($_FILES['profile_image2']['name'] != '') {
        $newName5 = '';
        $image5 = $this->request->getFile('profile_image2');
        if ($image5->isValid() && !$image5->hasMoved()) {
          $newName5 =  $image5->getRandomName();
          $imgpath5 = 'public/uploads/driverDocs';
          if (!is_dir($imgpath5)) {
            mkdir($imgpath5, 0777, true);
          }
          $image5->move($imgpath5, $newName5);
        }
        $image_name5 = $newName5;

        $driverModel->update($id, ['profile_image2' => $newName5]);
      }


      $this->vehicletypeDriver->where('driver_id', $id)->delete();

      $vehicle = $this->request->getVar('vehicle_types');
      foreach ($vehicle as $key => $value) {
        $vehicledata = [
          'vehicle_type_id' =>  $value,
          'driver_id'       =>  $id,
        ];
        $this->vehicletypeDriver->save($vehicledata);
      }


      // add scheme
      $this->DSMModel->where('driver_id', $id)->where('removal_date', '')->set(['removal_date' => date('Y-m-d h:i:s')])->update();

      $this->DSMModel->insert([
        'driver_id' => $id,
        'scheme_id' => $this->request->getPost('scheme_id'),
        'added_date' => date("Y-m-d h:i:s")
      ]);

      $session = \Config\Services::session();
      $session->setFlashdata('success', 'Driver updated');
      return $this->response->redirect(base_url('driver'));
    }
    return view('Driver/edit', $this->view);
  }

  public function delete($id)
  {
    $driverModel = new DriverModel();
    $driverModel->where('id', $id)->delete($id);
    $session = \Config\Services::session();
    $session->setFlashdata('success', 'Driver Deleted');
    return $this->response->redirect(base_url('/driver'));
  }

  public function view($id = null)
  {
    $driverModel = new DriverModel();
    $this->view['driver_data'] = $driverModel->where('id', $id)->first();
    return view('Driver/view', $this->view);
  }

  public function approve($id = null)
  {
    if (session()->get('isLoggedIn')) {
      $login_id = session()->get('id');
    }
    $user = new UserModel();
    $user = $user->where('id', $login_id)->first();
    $driverModel = new DriverModel();
    $driverModel->update($id, [
      'approved'              =>  1,
      'approval_user_id'      =>  $user['id'],
      'approval_user_type'    =>  $user['usertype'],
      'approval_date'         =>  date("Y-m-d h:i:sa"),
      'approval_ip_address'   =>  $_SERVER['REMOTE_ADDR']
    ]);

    $session = \Config\Services::session();
    $session->setFlashdata('success', 'Driver Approved');
    return $this->response->redirect(base_url('/foreman'));
  }

  public function populate_fields_data()
  {
    if (isset($_POST['party_id'])) {
      $party = $this->partyModel->where('id', $_POST['party_id'])->first();
      return json_encode($party);
    }
  }

  public function validate_dl()
  {
    $row = $this->DModel->where('dl_no', $this->request->getPost('dl_no'))->first();
    echo  $row ? '1' : '0';
  }

  public function assign_vehicle($id=0)
  {
    if ($this->request->getPost()) {
      $result = $this->DVAModel->where('driver_id', $id)->where('(unassign_date IS NULL or unassign_date="")')->first();
      if ($result) {
        $this->VModel->update($result['vehicle_id'], ['is_driver_assigned' => 0]);
        $this->DVAModel->update($result['id'], ['unassign_date' => date('Y-m-d h:i:s'), 'unassigned_by' => $this->added_by]);
      }
      
      $arr = [
        'driver_id' => $id,
        'vehicle_id' => $this->request->getPost('vehicle_id'),
        'vehicle_location' => $this->request->getPost('location'),
        'vehicle_fuel_status' => $this->request->getPost('fuel'),
        'vehicle_km_reading' => $this->request->getPost('km'),
        'assigned_by' => $this->added_by,
        'assign_date' => $this->request->getPost('assigned_date'),
      ];
      $this->DVAModel->insert($arr);
      $this->session->setFlashdata('success', 'Vehicle assigned to driver');

      // change driver and vehicle status
      $this->VModel->update($this->request->getPost('vehicle_id'), ['is_driver_assigned' => '1']);
      $this->DModel->update($id, ['working_status' => 2]);
      return $this->response->redirect(base_url('driver'));
    }
    
    $this->view['token'] = $id;
    //$this->view['free_vehicles'] = $this->VModel->where('is_driver_assigned', '0')->findAll();
    //$this->view['vehicles'] = $this->VModel->findAll();

    $this->view['driver_detail'] = $this->DModel->select('driver.*, party.party_name')->join('party', 'party.id = driver.party_id')->where('driver.id', $id)->first();
    $this->view['assignment_details'] = $this->DVAModel->where('driver_id', $id)->where('(driver_vehicle_map.unassign_date IS NULL or driver_vehicle_map.unassign_date="")')->first();
    
    $this->view['driverAllowedVehicleTypes'] = $this->vehicletypeDriver->select('t2.id, t2.rc_number')->join('vehicle as t2','t2.vehicle_type_id=driver_vehicle_type_map.vehicle_type_id','inner')->where('driver_id', $id)->where('t2.is_driver_assigned', '0')->orderBy('t2.rc_number', 'ASC')->findAll();

    return view('Driver/assign', $this->view);
  }

  public function unassign_vehicle($id)
  {
    if ($this->request->getPost()) {
      $error = $this->validate([
        'unassigned_date'              =>  'required',
        'location'             =>  'required',
      ]);
      if (!$error) {
        $this->view['error']   = $this->validator;
      } else {
        $link = $this->DVAModel->where('driver_id', $id)->where('(unassign_date IS NULL or unassign_date = "" )')->first();

        if ($link) {
          $this->DVAModel->update($link['id'], [
              'unassign_date' => date('Y-m-d H:i:s',strtotime($this->request->getPost('unassigned_date'))),
              'unassigned_by' => $this->added_by,
              'vehicle_location' => $this->request->getPost('location'),
              'vehicle_fuel_status' => $this->request->getPost('fuel'),
              'vehicle_km_reading' => $this->request->getPost('km'),
             ]
            );
          $this->VModel->update($link['vehicle_id'], ['is_driver_assigned' => '0']);
          $this->DModel->update($id, ['working_status' => 1]);
          
          $this->session->setFlashdata('success', 'Vehicle Unassigned From Driver');
        } else $this->session->setFlashdata('success', 'No Vehicle Assigned');

        return $this->response->redirect(base_url('driver'));
      }
  }
   $this->view['token'] = $id; 
   $this->view['driver_detail'] = $this->DModel->select('driver.*, party.party_name')->join('party', 'party.id = driver.party_id')->where('driver.id', $id)->first();
   $this->view['assignment_details'] = $this->DVAModel->where('driver_id', $id)->where('(unassign_date IS NULL or unassign_date = "" )')->first();
   echo '<pre>';print_r($this->view['assignment_details']); exit;
   $this->view['driverAllowedVehicleTypes'] = $this->vehicletypeDriver->select('t2.id, t2.rc_number')->join('vehicle as t2','t2.vehicle_type_id=driver_vehicle_type_map.vehicle_type_id','inner')->where('driver_id', $id)->where('t2.is_driver_assigned', '1')->orderBy('t2.rc_number', 'ASC')->findAll();
   return view('Driver/unassign', $this->view);
  }
  public function assigned_list()
  {
    $data['assigned_list'] = $this->DVAModel->select('driver_vehicle_map.*, vehicle.rc_number, party.party_name ')
      ->join('vehicle', 'vehicle.id = driver_vehicle_map.vehicle_id')
      ->join('driver', 'driver.id = driver_vehicle_map.driver_id')
      ->orderBy('driver_vehicle_map.assign_date', 'descs')
      ->join('party', 'party.id = driver.party_id')
      ->where('(driver_vehicle_map.unassign_date IS NULL or driver_vehicle_map.unassign_date="")')
      ->findAll();
    return view('Driver/assigned_list', $data);
  }

  public function preview($id)
  {
    $driverModel = new DriverModel();

    $this->view['driver_data'] = $driverModel->select('driver.*, t1.party_name as driver_name, t1.primary_phone, t1.other_phone, t1.email, t2.party_name as foreman_name')
      ->join('party t1', 't1.id = driver.party_id')
      ->join('foreman', 'foreman.id = driver.foreman_id')
      ->join('party t2', 't2.id = foreman.party_id')
      ->where('driver.id', $id)->first();

    $this->view['driver_docs'] = $this->PDModel->where('party_id', $this->view['driver_data']['party_id'])->where('flag_id', '1')->first();

    // echo '<pre>';
    // print_r($this->view['driver_data']);
    // print_r($this->view['driver_docs']);
    // die;

    return view('Driver/preview', $this->view);
  }
}
