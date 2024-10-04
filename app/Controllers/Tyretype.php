<?php

namespace App\Controllers;

use App\Models\TyreTypeModel;
use App\Models\UserModel;

class Tyretype extends BaseController
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

    $this->TBModel = new TyreTypeModel();
  }

  public function index()
  {
    if ($this->request->getPost('status') != '') {
      $this->TBModel->where('status', $this->request->getPost('status'));
    }
    $this->view['tyretypes'] = $this->TBModel->orderBy('type', 'DESC')->findAll();

    return view('TyreType/index', $this->view);
  }

  public function create()
  {
    if ($this->request->getPost()) {

      $this->TBModel->save([
        'type' => $this->request->getPost('type'),
        'added_by' => $this->added_by,
        'added_ip' => $this->added_ip
      ]);

      $this->session->setFlashdata('success', 'Tyre Type Added');
      return $this->response->redirect(base_url('tyretype'));
    } else {
      return view('TyreType/action', $this->view);
    }
  }

  public function edit($id)
  {
    $this->view['token'] = $id;

    if ($this->request->getPost()) {

      $this->TBModel->update($id, [
        'type' => $this->request->getPost('type'),
        'status' => $this->request->getPost('status'),
        'updated_date' => date('Y-m-d'),
        'updated_by' => $this->added_by,
        'updated_ip' => $this->added_ip
      ]);

      $this->session->setFlashdata('success', 'Tyre Type Updated');
      return $this->response->redirect(base_url('tyretype'));
    } else {

      $this->view['tyre_details'] = $this->TBModel->where('id', $id)->first();
      return view('TyreType/action', $this->view);
    }
  }

  public function delete($id)
  {
    $this->TBModel->delete($id);
    $this->session->setFlashdata('success', 'Tyre Type Deleted');
    return $this->response->redirect(base_url('tyretype'));
  }
}
