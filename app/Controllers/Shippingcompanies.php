<?php

namespace App\Controllers;

use App\Models\ShippingCompaniesModel;
use App\Models\UserModel;

class Shippingcompanies extends BaseController
{
  public $session;
  public $access;
  public $added_by;
  public $added_ip;
  public $SCModel;

  public function __construct()
  {
    $this->session = \Config\Services::session();

    $user = new UserModel();
    $this->access = $user->setPermission();

    $this->added_by = isset($_SESSION['id']) ? $_SESSION['id'] : '0';
    $this->added_ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';

    $this->SCModel = new ShippingCompaniesModel();
  }

  public function index()
  {
    if ($this->request->getPost('status') != '') {
      $this->SCModel->where('status', $this->request->getPost('status'));
    }
    $this->view['companies'] = $this->SCModel->where('isDeleted', '0')->orderBy('name', 'DESC')->findAll();

    return view('ShippingCompanies/index', $this->view);
  }

  public function create()
  {
    if ($this->request->getPost()) {

      $this->SCModel->save([
        'name' => $this->request->getPost('name'),
        'added_by' => $this->added_by,
        'added_ip' => $this->added_ip
      ]);

      $this->session->setFlashdata('success', 'Company Added');
      return $this->response->redirect(base_url('shippingcompanies'));
    } else {
      return view('ShippingCompanies/action', $this->view);
    }
  }

  public function edit($id)
  {
    $this->view['token'] = $id;

    if ($this->request->getPost()) {

      $this->SCModel->update($id, [
        'name' => $this->request->getPost('name'),
        'status' => $this->request->getPost('status'),
        'updated_date' => date('Y-m-d'),
        'updated_by' => $this->added_by,
        'updated_ip' => $this->added_ip
      ]);

      $this->session->setFlashdata('success', 'Company Updated');
      return $this->response->redirect(base_url('shippingcompanies'));
    } else {

      $this->view['company_details'] = $this->SCModel->where('id', $id)->first();
      return view('ShippingCompanies/action', $this->view);
    }
  }

  public function delete($id)
  {
    $this->SCModel->update($id, ['isDeleted' => '1']);
    $this->session->setFlashdata('success', 'Company Deleted');
    return $this->response->redirect(base_url('shippingcompanies'));
  }
}
