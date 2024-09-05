<?php

namespace App\Controllers;

use App\Models\VehicleTypeModel;
use App\Models\UserModel;
use App\Models\ModulesModel;


class Vehicletype extends BaseController
{
  public $_access;

  public function __construct()
  {
    $u = new UserModel();
    $access = $u->setPermission();
    $this->_access = $access;
    $this->vehicletypeModel = new VehicleTypeModel();
  }

  public function index()
  {
    $access = $this->_access;
    if ($access === 'false') {
      $session = \Config\Services::session();
      $session->setFlashdata('error', 'You are not permitted to access this page');
      return $this->response->redirect(site_url('/dashboard'));
    } else {

      $this->view['vehicletype_data'] = $this->vehicletypeModel->where(['status' => 'Active'])->orderBy('id', 'DESC')->paginate(10);
      $this->view['pagination_link'] = $this->vehicletypeModel->pager;

      $this->view['page_data'] = [
        'page_title' => view('partials/page-title', ['title' => 'Vehicle Type', 'li_1' => '123', 'li_2' => 'deals'])
      ];
      return view('VehicleType/index', $this->view);
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
        'page_title' => view('partials/page-title', ['title' => 'Add Vehicle Type', 'li_2' => 'profile'])
      ];

      $this->view['vehicletype_data'] = $this->vehicletypeModel->where(['status' => 'Active'])->orderBy('id')->findAll();


      $request = service('request');
      if ($this->request->getMethod() == 'POST') {
        $error = $this->validate([
          'name'   =>  'required|min_length[3]|max_length[50]|alpha_numeric_space',
          'number_of_tyres'   =>  'required|numeric|greater_than[0]',
        ]);
        if (!$error) {
          $this->view['error']   = $this->validator;
        } else {
          $normalizedStr = strtolower(str_replace(' ', '', $this->request->getVar('name')));
          $vehicletype_data = $this->vehicletypeModel
            ->where('status', 'Active')
            ->where('deleted_at', NULL)
            ->where('LOWER(REPLACE(name, " ", ""))', $normalizedStr)
            ->orderBy('id')->countAllResults();
          if ($vehicletype_data == 0) {
            $this->vehicletypeModel->save([
              'name'  =>  $this->request->getVar('name'),
              'number_of_tyres'  =>  $this->request->getVar('number_of_tyres'),
              'number_of_tyres_spare'  =>  $this->request->getVar('number_of_tyres_spare'),
              'status'  => 'Active',
              'created_at'  =>  date("Y-m-d h:i:sa"),
            ]);
          } else {
            $this->validator->setError('name', 'The field must contain a unique value.');
            $this->view['error']  = $this->validator;
            return view('VehicleType/create', $this->view);
            return false;
          }

          $session = \Config\Services::session();
          $session->setFlashdata('success', 'Vehicle Type Added');
          return $this->response->redirect(site_url('/vehicletype'));
        }
      }
      return view('VehicleType/create', $this->view);
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
      $request = service('request');
      $this->view['vehicletype_data'] = $this->vehicletypeModel->where('id', $id)->first();
      if ($this->request->getMethod() == 'POST') {
        $id = $this->request->getVar('id');
        $this->view['vehicletype_data'] = $this->vehicletypeModel->where('id', $id)->first();
        $error = $this->validate([
          'name'   =>  'required|min_length[3]|max_length[50]|alpha_numeric_space',
          'number_of_tyres'   =>  'required|numeric|greater_than[0]',
        ]);
        if (!$error) {
          $this->view['error']   = $this->validator;
        } else {
          $normalizedStr = strtolower(str_replace(' ', '', $this->request->getVar('name')));
          $vehicletype_data = $this->vehicletypeModel
            ->where('status', 'Active')
            ->where('deleted_at', NULL)
            ->where('LOWER(REPLACE(name, " ", ""))', $normalizedStr)
            ->where('id!=', $id)
            ->orderBy('id')->countAllResults();
          if ($vehicletype_data == 0) {
            $this->vehicletypeModel->update($id, [
              'name'  =>  $this->request->getVar('name'),
              'number_of_tyres'  =>  $this->request->getVar('number_of_tyres'),
              'number_of_tyres_spare'  =>  $this->request->getVar('number_of_tyres_spare'),
              'status'  => 'Active',
              'updated_at'  =>  date("Y-m-d h:i:sa"),
            ]);
          } else {
            $this->validator->setError('name', 'The field must contain a unique value.');
            $this->view['error']  = $this->validator;
            return view('VehicleType/edit', $this->view);
            return false;
          }


          $session = \Config\Services::session();

          $session->setFlashdata('success', 'Vehicle Type updated');
          return $this->response->redirect(site_url('/vehicletype'));
        }
      }
      return view('VehicleType/edit', $this->view);
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
      $this->vehicletypeModel->where('id', $id)->delete($id);
      $session = \Config\Services::session();
      $session->setFlashdata('success', 'Vehicle Type Deleted');
      return $this->response->redirect(site_url('/vehicletype'));
    }
  }
}
