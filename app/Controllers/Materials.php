<?php

namespace App\Controllers;

use App\Models\MaterialsModel;
use App\Models\UserModel;

class Materials extends BaseController
{
  public $session;
  public $access;
  public $added_by;
  public $added_ip;
  public $MModel;

  public function __construct()
  {
    $this->session = \Config\Services::session();

    $user = new UserModel();
    $this->access = $user->setPermission();

    $this->added_by = isset($_SESSION['id']) ? $_SESSION['id'] : '0';
    $this->added_ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';

    $this->MModel = new MaterialsModel();
  }

  public function index()
  {
    if ($this->request->getPost('status') != '') {
      $this->MModel->where('status', $this->request->getPost('status'));
    }
    $this->view['materials'] = $this->MModel->where('isDeleted', '0')->orderBy('name', 'DESC')->findAll();

    return view('Materials/index', $this->view);
  }

  public function create()
  {
    if ($this->request->getPost()) {

      $this->MModel->save([
        'name' => $this->request->getPost('name'),
        'added_by' => $this->added_by,
        'added_ip' => $this->added_ip
      ]);

      $this->session->setFlashdata('success', 'Material Added');
      return $this->response->redirect(base_url('materials'));
    } else {
      return view('Materials/action', $this->view);
    }
  }

  public function edit($id)
  {
    $this->view['token'] = $id;

    if ($this->request->getPost()) {

      $this->MModel->update($id, [
        'name' => $this->request->getPost('name'),
        'status' => $this->request->getPost('status'),
        'updated_date' => date('Y-m-d'),
        'updated_by' => $this->added_by,
        'updated_ip' => $this->added_ip
      ]);

      $this->session->setFlashdata('success', 'Material Updated');
      return $this->response->redirect(base_url('materials'));
    } else {

      $this->view['material_details'] = $this->MModel->where('id', $id)->first();
      return view('Materials/action', $this->view);
    }
  }

  public function delete($id)
  {
    $this->MModel->update($id, ['isDeleted' => '1']);
    $this->session->setFlashdata('success', 'Material Deleted');
    return $this->response->redirect(base_url('materials'));
  }
}
