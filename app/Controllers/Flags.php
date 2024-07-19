<?php

namespace App\Controllers;

use App\Models\FlagsModel;
use App\Models\UserModel;
use App\Models\ModulesModel;


class Flags extends BaseController
{
  public $_access;

  public function __construct()
  {
    $u = new UserModel();
    $access = $u->setPermission();
    $this->_access = $access;
    $this->flagsModel = new FlagsModel();
  }

  public function index()
  {
    $access = $this->_access;
    if ($access === 'false') {
      $session = \Config\Services::session();
      $session->setFlashdata('error', 'You are not permitted to access this page');
      return $this->response->redirect(site_url('/dashboard'));
    } else {

      $this->view['flags_data'] = $this->flagsModel->where(['status' => 'Active'])->orderBy('id', 'DESC')->paginate(10);
      $this->view['pagination_link'] = $this->flagsModel->pager;

      $this->view['page_data'] = [
        'page_title' => view('partials/page-title', ['title' => 'Flags', 'li_1' => '123', 'li_2' => 'deals'])
      ];
      return view('Flags/index', $this->view);
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
        'page_title' => view('partials/page-title', ['title' => 'Add Flags', 'li_2' => 'profile'])
      ];


      $request = service('request');
      if ($this->request->getMethod() == 'POST') {

        $error = $this->validate([
          'title'   =>  'required|min_length[3]|max_length[50]|alpha_numeric_space',
        ]);
        if (!$error) {
          $this->view['error']   = $this->validator;
        } else {
          $normalizedStr = strtolower(str_replace(' ', '', $this->request->getVar('title')));
          $flags_data = $this->flagsModel
            ->where('status', 'Active')
            ->where('deleted_at', NULL)
            ->where('LOWER(REPLACE(title, " ", ""))', $normalizedStr)
            ->orderBy('id')->countAllResults();
          if ($flags_data == 0) {
            $this->flagsModel->save([
              'title' =>  $this->request->getVar('title'),
              'status'  => 'Active',
              'created_at'  =>  date("Y-m-d h:i:sa"),

            ]);
          } else {
            $this->validator->setError('title', 'The field must contain a unique value.');
            $this->view['error']  = $this->validator;
            return view('Flags/create', $this->view);
            return false;
          }


          $session = \Config\Services::session();

          $session->setFlashdata('success', 'Flags Added');
          return $this->response->redirect(site_url('/flags'));
        }
      }
      return view('Flags/create', $this->view);
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
      $this->view['flags_data'] = $this->flagsModel->where('id', $id)->first();
      if ($this->request->getMethod() == 'POST') {
        $id = $this->request->getVar('id');
        $this->view['flags_data'] = $this->flagsModel->where('id', $id)->first();
        $error = $this->validate([
          'title'   =>  'required|min_length[3]|max_length[50]|alpha_numeric_space',
        ]);
        if (!$error) {
          $this->view['error']   = $this->validator;
        } else {
          $normalizedStr = strtolower(str_replace(' ', '', $this->request->getVar('title')));
          $flags_data = $this->flagsModel
            ->where('status', 'Active')
            ->where('deleted_at', NULL)
            ->where('LOWER(REPLACE(title, " ", ""))', $normalizedStr)
            ->where('id!=', $id)
            ->orderBy('id')->countAllResults();
          if ($flags_data == 0) {
            $this->flagsModel->update($id, [
              'title'  =>  $this->request->getVar('title'),
              'status'  => 'Active',
              'updated_at'  =>  date("Y-m-d h:i:sa"),
            ]);
          } else {
            $this->validator->setError('title', 'The field must contain a unique value.');
            $this->view['error']  = $this->validator;
            return view('Flags/create', $this->view);
            return false;
          }


          $session = \Config\Services::session();

          $session->setFlashdata('success', 'Flags updated');
          return $this->response->redirect(site_url('/flags'));
        }
      }
      return view('Flags/edit', $this->view);
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
      $this->flagsModel->where('id', $id)->delete($id);
      $session = \Config\Services::session();
      $session->setFlashdata('success', 'Flag Deleted');
      return $this->response->redirect(site_url('/flags'));
    }
  }
}
