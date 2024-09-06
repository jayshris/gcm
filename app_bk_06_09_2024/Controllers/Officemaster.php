<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OfficeMasterModel;
use CodeIgniter\HTTP\ResponseInterface;

class Officemaster extends BaseController
{
  public $session;
  public $OMModel;
  public $added_by;

  public function __construct()
  {
    $this->session = \Config\Services::session();
    $this->OMModel = new OfficeMasterModel();

    $this->added_by = isset($_SESSION['id']) ? $_SESSION['id'] : '0';
  }

  public function index()
  {
    if ($this->request->getPost('office_id') != '') {
      $this->OMModel->where('id', $this->request->getPost('office_id'));
    }
    if ($this->request->getPost('status') != '') {
      $this->OMModel->where('status', $this->request->getPost('status'));
    }

    $this->view['offices']  = $this->OMModel->findAll();

    return view('Officemaster/index', $this->view);
  }

  function create()
  {
    if ($this->request->getPost()) {

      $this->OMModel->save([
        'name' => $this->request->getVar('name'),
        'added_by' => $this->added_by,
      ]);
      $this->session->setFlashdata('success', 'Office Added Successfully');

      return $this->response->redirect(base_url('officemaster'));
    }

    return view('Officemaster/action', $this->view);
  }

  function edit($id)
  {
    $this->view['office_detail'] = $this->OMModel->where(['id' => $id])->first();
    $this->view['token'] = $id;

    if ($this->request->getPost()) {

      $this->OMModel->update($id, [
        'name' => $this->request->getVar('name'),
        'status' => $this->request->getVar('status'),
        'updated_at' => date('Y-m-d h:i:s'),
        'updated_by' => $this->added_by
      ]);

      $this->session->setFlashdata('success', 'Office Updated Successfully');
      return $this->response->redirect(base_url('officemaster'));
    }
    return view('Officemaster/action', $this->view);
  }

  public function delete($id)
  {
    $this->OMModel->where('id', $id)->delete($id);
    $this->session->setFlashdata('success', 'Office deleted successfully');
    return $this->response->redirect(base_url('officemaster'));
  }

  public function validate_office()
  {
    if ($this->request->getPost('name'))
      $row = $this->OMModel->where('name', $this->request->getPost('name'))->first();

    echo $row ? 1 : 0;
  }
}
