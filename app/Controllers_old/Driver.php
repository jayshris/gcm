<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\DriverModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\StateModel;
use App\Models\ForemanModel;
use App\Models\AadhaarNumberMapModule;
use App\Models\PartyModel;
use App\Models\VehicleTypeModel;
use App\Models\PartytypeModel;
use App\Models\PartyTypePartyModel;
use App\Models\DriverVehicleType;

class Driver extends BaseController
{
  public $_access;

  public function __construct()
  {
    $u = new UserModel();
    $access = $u->setPermission();
    $this->_access = $access;
    $this->partyModel = new PartyModel();
    $this->partyTypeModel = new PartytypeModel();
    $this->partyTypePartyModel = new PartyTypePartyModel();
    $this->vehicletypeDriver =  new DriverVehicleType();
    $this->vehicletype = new VehicleTypeModel();
  }

  public function index()
  {
    $userModel = new UserModel();
    $this->view['driver'] = $userModel->where('usertype', 'driver')->orderBy('id', 'DESC')->paginate(10);
    $driverModel = new DriverModel();
    $this->view['driver_data'] = $driverModel->select('driver.*,t2.party_name, t3.party_name as foreman_name')
      ->join('party' . ' t2', 't2.id = driver.name')
      ->join('party' . ' t3', 't3.id = driver.foreman_id')
      ->orderBy('driver.id', 'DESC')->findAll();

    // print_r($this->view['driver_data']);
    // die;

    $this->view['pagination_link'] = $userModel->pager;
    $this->view['page_data'] = ['page_title' => view('partials/page-title', ['title' => 'Driver', 'li_1' => '123', 'li_2' => 'deals'])];
    return view('Driver/index', $this->view);
  }

  public function create()
  {
    $access = $this->_access;
    if ($access === 'false') {
      $session = \Config\Services::session();
      $session->setFlashdata('error', 'You are not permitted to access this page');
      return $this->response->redirect(site_url('/dashboard'));
    } else {
      helper(['form', 'url']);
      $this->view['page_data'] = [
        'page_title' => view('partials/page-title', ['title' => 'Add Driver', 'li_2' => 'profile'])
      ];

      $stateModel = new StateModel();
      $this->view['state'] = $stateModel->where(['isStatus' => '1'])->orderBy('state_id')->findAll();
      $this->view['partytpe'] = $this->partyTypeModel->like('name', '%Driver%')->first();
      if (isset($this->view['partytpe'])) {
        $this->view['party_map_data'] = $this->partyTypePartyModel->where(['party_type_id' => $this->view['partytpe']['id']])->findAll();
      }

      $this->view['vehicletypes'] = $this->vehicletype->where('status', 'Active')->findAll();

      //print_r($this->view['vehicletypes']); die;
      $foremanModel = new ForemanModel();
      $this->view['foreman'] = $foremanModel->findAll();

      $PartyModel = new PartyModel();
      $this->view['parties'] = $PartyModel->where('status', '1')->findAll();


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

            'name'  =>  $this->request->getVar('name'),
            'foreman_id'  =>  $this->request->getVar('foreman_id'),
            'driver_type'  =>   $this->request->getPost('driver_type'),
            'bank_ac' => $this->request->getPost('bank_account_number'),
            'bank_ifsc' => $this->request->getPost('bank_ifsc_code'),
            'whatsapp_no' => $this->request->getPost('whatsapp'),
            'dl_no' => $this->request->getPost('dl_no'),
            'dl_authority' => $this->request->getPost('dl_authority'),
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
            'status'  =>  'Active',

            'created_at'  =>  date("Y-m-d h:i:sa"),
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

          $session = \Config\Services::session();
          $session->setFlashdata('success', 'Driver Added');
          return $this->response->redirect(base_url('/driver'));
        }
      }
      return view('Driver/create', $this->view);
    }
  }

  public function edit($id = null)
  {
    $access = $this->_access;
    if ($access === 'false') {
      $session = \Config\Services::session();
      $session->setFlashdata('error', 'You are not permitted to access this page');
      return $this->response->redirect(site_url('/dashboard'));
    } else {

      if (session()->get('isLoggedIn')) {
        $login_id = session()->get('id');
      }
      if (isset($login_id)) {
        $user = new UserModel();
        $user = $user->where('id', $login_id)->first();
      }
      $stateModel = new StateModel();
      $this->view['state'] = $stateModel->where(['isStatus' => '1'])->orderBy('state_id')->findAll();

      $this->view['partytpe'] = $this->partyTypeModel->like('name', '%Driver%')->first();
      $this->view['party_map_data'] = $this->partyTypePartyModel->where(['party_type_id' => $this->view['partytpe']['id']])->findAll();

      $driverModel = new DriverModel();
      $this->view['driver_data'] = $driverModel->select('driver.*,party.email,party.primary_phone')
        ->join('party', 'party.id = driver.name')
        ->where('driver.id', $id)->first();

      $this->view['vehicletypes'] = $this->vehicletype->where('status', 'Active')->findAll();
      $this->view['vehicletypesdriver'] = $this->vehicletypeDriver->where('driver_id', $id)->findAll();

      $foremanModel = new ForemanModel();
      $this->view['foreman'] = $foremanModel->select('foreman.*, party.party_name, party.id as party_id')
        ->join('party', 'foreman.name = party.id')
        ->findAll();

      $PartyModel = new PartyModel();
      $this->view['parties'] = $PartyModel->where('status', '1')->findAll();

      if ($this->request->getMethod() == 'POST') {

        $driverModel = new DriverModel();

        if ($this->request->getVar('approve') == 1) {
          $status = 'Active';
        } else {
          $status = 'Inactive';
        }

        $driverModel->update($id, [
          'name'  =>  $this->request->getVar('name'),
          'foreman_id'  =>  $this->request->getVar('foreman_id'),
          'driver_type'  =>   $this->request->getPost('driver_type'),
          'bank_ac' => $this->request->getPost('bank_account_number'),
          'bank_ifsc' => $this->request->getPost('bank_ifsc_code'),
          'whatsapp_no' => $this->request->getPost('whatsapp'),
          'dl_no' => $this->request->getPost('dl_no'),
          'dl_authority' => $this->request->getPost('dl_authority'),
          'dl_expiry' => $this->request->getPost('dl_expiry'),
          'upi_text' => $this->request->getPost('upi'),
          'address'  =>   $this->request->getPost('address'),
          'city'  =>   $this->request->getPost('city'),
          'state'  =>  $this->request->getPost('state'),
          'zip'  =>  $this->request->getPost('zip'),
          'status'  =>  'Active',
          'approved'                =>  $this->request->getVar('approve'),
          'approval_user_id'        =>  isset($user['id']) ? $user['id'] : '',
          'approval_user_type'      =>  isset($user['usertype']) ? $user['usertype'] : '',
          'approval_date'           =>  date("Y-m-d h:i:sa"),
          'approval_ip_address'     =>  $_SERVER['REMOTE_ADDR'],
          'updated_at'              =>  date("Y-m-d h:i:sa"),
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


        $session = \Config\Services::session();
        $session->setFlashdata('success', 'Driver updated');
        return $this->response->redirect(site_url('/driver'));
      }
      return view('Driver/edit', $this->view);
    }
  }

  public function delete($id)
  {
    $access = $this->_access;
    if ($access === 'false') {
      $session = \Config\Services::session();
      $session->setFlashdata('error', 'You are not permitted to access this page');
      return $this->response->redirect(site_url('/dashboard'));
    } else {
      $driverModel = new DriverModel();
      $driverModel->where('id', $id)->delete($id);
      $session = \Config\Services::session();
      $session->setFlashdata('success', 'Driver Deleted');
      return $this->response->redirect(site_url('/driver'));
    }
  }
  public function view($id = null)
  {
    $access = $this->_access;
    if ($access === 'false') {
      $session = \Config\Services::session();
      $session->setFlashdata('error', 'You are not permitted to access this page');
      return $this->response->redirect(site_url('/dashboard'));
    } else {
      $driverModel = new DriverModel();
      $this->view['driver_data'] = $driverModel->where('id', $id)->first();

      return view('Driver/view', $this->view);
    }
  }

  public function approve($id = null)
  {
    $access = $this->_access;
    if ($access === 'false') {
      $session = \Config\Services::session();
      $session->setFlashdata('error', 'You are not permitted to access this page');
      return $this->response->redirect(site_url('/dashboard'));
    } else {
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
      return $this->response->redirect(site_url('/foreman'));
    }
  }

  public function populate_fields_data()
  {
    if (isset($_POST['party_id'])) {
      $party = $this->partyModel->where('id', $_POST['party_id'])->first();
      return json_encode($party);
    }
  }
}
