<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProfileModel;
use App\Models\StateModel;
use App\Models\UserModel;

class LoadingReceipt extends BaseController
{
  public $_access;

  public function __construct()
  {
    $u = new UserModel();
    $access = $u->setPermission();
    $this->_access = $access;
  }

  public function index()
  {
    $access = $this->_access;
    if ($access === 'false') {
      $session = \Config\Services::session();
      $session->setFlashdata('error', 'You are not permitted to access this page');
      return $this->response->redirect(base_url('/dashboard'));
    } else { 
      return view('LoadingReceipt/create', $this->view);
    }
  } 

  function create(){
    $access = $this->_access;
    if ($access === 'false') {
      $session = \Config\Services::session();
      $session->setFlashdata('error', 'You are not permitted to access this page');
      return $this->response->redirect(base_url('/dashboard'));
    } else {
      if (session()->get('isLoggedIn')) {
        $login_id = session()->get('id');
      } 
      $stateModel = new StateModel();
      $this->view['state'] = $stateModel->where(['isStatus' => '1'])->orderBy('state_name', 'ASC')->findAll();
      $profiledata = new ProfileModel();
      $this->view['profile_data'] = $profiledata->where('id', 1)->first();

      return view('LoadingReceipt/create', $this->view);
    }
  }
}
