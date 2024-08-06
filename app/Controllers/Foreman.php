<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\ModulesModel;
use App\Models\ForemanModel;
use App\Models\StateModel;
use App\Models\AadhaarNumberMapModule;
use App\Models\PartyModel;
use App\Models\PartytypeModel;
use App\Models\PartyTypePartyModel;

class Foreman extends BaseController
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
  }

  public function index()
  {
    $access = $this->_access;
    if ($access === 'false') {
      $session = \Config\Services::session();
      $session->setFlashdata('error', 'You are not permitted to access this page');
      return $this->response->redirect(site_url('/dashboard'));
    } else {
      $foremanModel = new ForemanModel();
      $foremanModel->select('foreman.*, party.party_name, party.status')
        ->join('party', 'party.id = foreman.party_id');
      if ($this->request->getPost('status') != '') {
        $foremanModel->where('party.status', $this->request->getPost('status'));
      } else {
        $foremanModel->where('party.status', '1');
      }

      $this->view['foreman_data'] = $foremanModel->orderBy('id', 'DESC')->findAll();

      $this->view['page_data'] = [
        'page_title' => view('partials/page-title', ['title' => 'Foreman', 'li_1' => '123', 'li_2' => 'deals'])
      ];
      return view('Foreman/index', $this->view);
    }
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

      $PartyModel = new PartyModel();
      $this->view['parties'] = $PartyModel->select('party.*,foreman.party_id')
        ->join('foreman', 'foreman.party_id = party.id', 'left')
        ->where('foreman.party_id', null)
        ->where('party.status', '1')->findAll();

      // echo '<pre>';
      // print_r($this->view['parties']);
      // die;

      $request = service('request');
      if ($this->request->getMethod() == 'POST') {

        $error = $this->validate([
          'party_id' =>  'required|alpha_numeric'
        ]);

        if (!$error) {
          $this->view['error']   = $this->validator;
        } else {
          $foremanModel = new ForemanModel();

          $newName1 = '';
          $image1 = $this->request->getFile('profile_image1');
          if ($image1->isValid() && !$image1->hasMoved()) {
            $newName1 = $image1->getRandomName();
            $imgpath1 = 'public/uploads/foremanDocs';
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
            $imgpath2 = 'public/uploads/foremanDocs';
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

            $imgpath3 = 'public/uploads/foremanDocs';
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
            $imgpath4 = 'public/uploads/foremanDocs';
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
            $imgpath5 = 'public/uploads/foremanDocs';
            if (!is_dir($imgpath5)) {
              mkdir($imgpath5, 0777, true);
            }
            $image5->move($imgpath5, $newName5);
          }
          $image_name5 = $newName5;


          $foremanModel->save([
            'party_id'  =>  $this->request->getVar('party_id'),
            'email'  =>  $this->request->getVar('email'),
            'mobile'  =>   $request->getPost('mobile'),
            'bank_account_number' => $request->getPost('bank_account_number'),
            'bank_ifsc_code' => $request->getPost('bank_ifsc_code'),
            'dl_no' => $request->getPost('dl_no'),
            'dl_authority' => $request->getPost('dl_authority'),
            'dl_dob' => $request->getPost('dl_dob'),
            'dl_expiry' => $request->getPost('dl_expiry'),
            'dl_image_front' => $image_name3,
            'dl_image_back' => $image_name4,
            'upi_text' => $request->getPost('upi'),
            'profile_image1'  =>  $image_name1,
            'profile_image2'  => $image_name2,
            'upi_id'    =>  $image_name5,
            'created_at'  =>  date("Y-m-d h:i:sa"),
          ]);
          $user_id = $foremanModel->getInsertID();

          $session = \Config\Services::session();
          $session->setFlashdata('success', 'Foreman Added');
          return $this->response->redirect(base_url('foreman'));
        }
      }
      return view('Foreman/create', $this->view);
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

      $PartyModel = new PartyModel();
      $this->view['parties'] = $PartyModel->where('status', '1')->findAll();


      if (session()->get('isLoggedIn')) {
        $login_id = session()->get('id');
      }
      $user = new UserModel();
      if (isset($login_id)) {
        $userdata = $user->where('id', $login_id)->first();
      }
      $foremanModel = new ForemanModel();
      $this->view['foreman_data'] = $foremanModel->where('id', $id)->first();

      helper(['form', 'url']);
      $this->view['page_data'] = [
        'page_title' => view('partials/page-title', ['title' => 'Add Driver', 'li_2' => 'profile'])
      ];
      $stateModel = new StateModel();
      $this->view['state'] = $stateModel->where(['isStatus' => '1'])->orderBy('state_id')->findAll();

      $aadhaarModel = new AadhaarNumberMapModule();
      $request = service('request');
      if ($this->request->getMethod() == 'POST') {
        $id = $this->request->getVar('id');
        $error = $this->validate([
          'party_id' =>  'required|alpha_numeric',
        ]);

        if (!$error) {
          $this->view['error']   = $this->validator;
        } else {

          $foremanModel->update($id, [
            'party_id'  =>  $this->request->getVar('party_id'),
            'email'  =>  $this->request->getVar('email'),
            'mobile'  =>   $request->getPost('mobile'),
            'bank_account_number' => $request->getPost('bank_account_number'),
            'bank_ifsc_code' => $request->getPost('bank_ifsc_code'),
            'dl_no' => $request->getPost('dl_no'),
            'dl_authority' => $request->getPost('dl_authority'),
            'dl_dob' => $request->getPost('dl_dob'),
            'dl_expiry' => $request->getPost('dl_expiry'),
            'upi_text' => $request->getPost('upi'),
            'updated_at'  =>  date("Y-m-d h:i:sa"),
          ]);


          if ($this->request->getFile('profile_image1') != null) {
            $image = $this->request->getFile('profile_image1');
            if ($image->isValid() && !$image->hasMoved()) {
              $newName1 = $image->getRandomName();
              $imgpath = 'public/uploads/foremanDocs';
              if (!is_dir($imgpath)) {
                mkdir($imgpath, 0777, true);
              }
              $image->move($imgpath, $newName1);
              $foremanModel->update($id, ['profile_image1' => $newName1]);
            }
          }

          if ($this->request->getFile('profile_image2') != null) {
            $image = $this->request->getFile('profile_image2');
            if ($image->isValid() && !$image->hasMoved()) {
              $newName2 = $image->getRandomName();
              $imgpath = 'public/uploads/foremanDocs';
              if (!is_dir($imgpath)) {
                mkdir($imgpath, 0777, true);
              }
              $image->move($imgpath, $newName2);
              $foremanModel->update($id, ['profile_image2' => $newName2]);
            }
          }


          if ($this->request->getFile('dl_image_front') != null) {
            $image = $this->request->getFile('dl_image_front');
            if ($image->isValid() && !$image->hasMoved()) {
              $newName3 = $image->getRandomName();
              $imgpath = 'public/uploads/foremanDocs';
              if (!is_dir($imgpath)) {
                mkdir($imgpath, 0777, true);
              }
              $image->move($imgpath, $newName3);
              $foremanModel->update($id, ['dl_image_front' => $newName3]);
            }
          }


          if ($this->request->getFile('dl_image_back') != null) {
            $image = $this->request->getFile('dl_image_back');
            if ($image->isValid() && !$image->hasMoved()) {
              $newName4 = $image->getRandomName();
              $imgpath = 'public/uploads/foremanDocs';
              if (!is_dir($imgpath)) {
                mkdir($imgpath, 0777, true);
              }
              $image->move($imgpath, $newName4);
              $foremanModel->update($id, ['dl_image_back' => $newName4]);
            }
          }

          if ($this->request->getFile('upi_id') != null) {
            $image = $this->request->getFile('upi_id');
            if ($image->isValid() && !$image->hasMoved()) {
              $newName5 = $image->getRandomName();
              $imgpath = 'public/uploads/foremanDocs';
              if (!is_dir($imgpath)) {
                mkdir($imgpath, 0777, true);
              }
              $image->move($imgpath, $newName5);
              $foremanModel->update($id, ['upi_id' => $newName5]);
            }
          }

          $session = \Config\Services::session();
          $session->setFlashdata('success', 'Foreman updated');
          return $this->response->redirect(base_url('foreman'));
        }
      }
      return view('Foreman/edit', $this->view);
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
      $foremanModel = new ForemanModel();
      $foremanModel->where('id', $id)->delete($id);
      $session = \Config\Services::session();
      $session->setFlashdata('success', 'Foreman Deleted');
      return $this->response->redirect(base_url('/foreman'));
    }
  }


  public function populate_fields_data()
  {
    if (isset($_POST['party_id'])) {
      $party = $this->partyModel->where('id', $_POST['party_id'])->first();
      $email =  $party['email'];
      $primary_phone = $party['primary_phone'];

      if (isset($_POST['foreman_id'])) {
        $foreman = new ForemanModel();
        $foreman = $foreman->where('id', $_POST['foreman_id'])->first();
        if (isset($foreman['email'])) {
          $email = $foreman['email'];
        } else {
          $email = $party['email'];
        }
        if (isset($foreman['mobile'])) {
          $primary_phone = $foreman['mobile'];
        } else {
          $primary_phone = $party['primary_phone'];
        }
      }

      if (isset($party)) {
        echo '<div class="row"><div class="col-md-6">
                <div class="form-wrap">
                  <label class="col-form-label">
                    Email
                  </label>
                  <input readonly type="text" required name="email" class="form-control" 
                  value="' . $email . '">
                  </div>
                </div>
                <div class="col-md-6">
                <div class="form-wrap">
                  <label class="col-form-label">
                    Phone Number
                  </label>
                  <input readonly type="text" required name="mobile" class="form-control" 
                  value="' . $primary_phone . '">
                  </div>
                  </div>
                  <div class="col-md-12">              
                                    ';
      }
    }
  }

  public function validate_dl()
  {
    $foremanModel = new ForemanModel();
    $row = $foremanModel->where('dl_no', $this->request->getPost('dl_no'))->first();

    echo  $row ? '1' : '0';
  }
}
