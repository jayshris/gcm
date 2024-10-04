<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TyreBrandModel;

class Tyrebrand extends BaseController
{
  public $session;
  public $access;
  public $added_by;
  public $added_ip;
  public $TBModel;

  public function __construct()
  {
    $this->session = \Config\Services::session();

    $user = new UserModel();
    $this->access = $user->setPermission();

    $this->added_by = isset($_SESSION['id']) ? $_SESSION['id'] : '0';
    $this->added_ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';

    $this->TBModel = new TyreBrandModel();
  }

  public function index()
  {
    if ($this->request->getPost('status') != '') {
      $this->TBModel->where('status', $this->request->getPost('status'));
    }
    $this->view['tyrebrands'] = $this->TBModel->orderBy('brand', 'DESC')->findAll();

    return view('TyreBrand/index', $this->view);
  }

  public function create()
  {
    if ($this->request->getPost()) {

      $this->TBModel->save([
        'brand' => $this->request->getPost('brand_name'),
        'added_by' => $this->added_by,
        'added_ip' => $this->added_ip
      ]);

      $this->session->setFlashdata('success', 'Tyre Brand Added');
      return $this->response->redirect(base_url('tyrebrand'));
    } else {
      return view('TyreBrand/action', $this->view);
    }
  }

  public function edit($id)
  {
    $this->view['token'] = $id;

    if ($this->request->getPost()) {

      $this->TBModel->update($id, [
        'brand' => $this->request->getPost('brand_name'),
        'status' => $this->request->getPost('status'),
        'updated_date' => date('Y-m-d'),
        'updated_by' => $this->added_by,
        'updated_ip' => $this->added_ip
      ]);

      $this->session->setFlashdata('success', 'Tyre Brand Updated');
      return $this->response->redirect(base_url('tyrebrand'));
    } else {

      $this->view['tyre_details'] = $this->TBModel->where('id', $id)->first();
      return view('TyreBrand/action', $this->view);
    }
  }

  public function delete($id)
  {
    $this->TBModel->delete($id);
    $this->session->setFlashdata('success', 'Tyre Brand Deleted');
    return $this->response->redirect(base_url('tyrebrand'));
  }
}
