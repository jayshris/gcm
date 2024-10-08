<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\BusinessTypeModel;
use App\Models\FlagsModel;
use App\Models\BusinessTypeFlagModel;

class Businesstype extends BaseController
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
      return $this->response->redirect(site_url('/dashboard'));
    } else {
      $businestsypeModel = new BusinessTypeModel();
      $this->view['businestsype_data'] = $businestsypeModel->select('business_type.*, MAX(business_type_flags.flags_id) as flags_id, GROUP_CONCAT(flags.title) as flags_names', false)

        ->join('business_type_flags', 'business_type_flags.business_type_id = business_type.id', 'left')

        ->join('flags', 'flags.id = business_type_flags.flags_id', 'left')

        ->where('business_type.status', 'Active')

        ->groupBy('business_type.id')
        ->orderBy('business_type.id', 'DESC')
        ->paginate(10);
      $this->view['pagination_link'] = $businestsypeModel->pager;
      $this->view['page_data'] = [
        'page_title' => view('partials/page-title', ['title' => 'Business Type', 'li_1' => '123', 'li_2' => 'deals'])
      ];
      return view('BusinessType/index', $this->view);
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
      $flags = new FlagsModel();
      $this->view['flags'] = $flags->where('status', 'Active')->findAll();

      helper(['form', 'url']);
      $this->view['page_data'] = [
        'page_title' => view('partials/page-title', ['title' => 'Add Driver', 'li_2' => 'profile'])
      ];

      $request = service('request');
      if ($this->request->getMethod() == 'POST') {



        $error = $this->validate([
          'company_structure_name' =>  'required|alpha_numeric_space|is_unique[business_type.company_structure_name]',
          'flags' =>  'required',
        ]);

        if (!$error) {
          $this->view['error']   = $this->validator;
        } else {
          $businestsypeModel = new BusinessTypeModel();
          $businestsypeModel->save([
            'company_structure_name'      =>  $this->request->getVar('company_structure_name'),
            'condition'     =>   'Enable',
            'created_at'  =>  date("Y-m-d h:i:sa"),
          ]);

          $business_type_id = $businestsypeModel->getInsertID();
          $flags_array = $this->request->getVar('flags');
          if (!isset($flags_array) || empty($flags_array)) {
            $this->view['error'] = "Please select atleast one flag";
          } else {
            $flagModel = new BusinessTypeFlagModel();
            foreach ($flags_array as $key => $value) {
              $flagsData = [
                'business_type_id' =>  $business_type_id,
                'flags_id' =>   $value,
                'mandatory' => $this->request->getVar('radio_' . $value)
              ];
              $flagModel->save($flagsData);
            }
          }

          $session = \Config\Services::session();
          $session->setFlashdata('success', 'Business type added');
          return $this->response->redirect(site_url('/Businesstype'));
        }
      }
      return view('BusinessType/create', $this->view);
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
      $businestsypeModel = new BusinessTypeModel();
      $this->view['business_data'] = $businestsypeModel->where('id', $id)->first();

      $flags = new FlagsModel();
      $this->view['flags'] = $flags->where('status', 'Active')->findAll();

      $businessFlags = new BusinessTypeFlagModel();
      $this->view['businessFlags'] = $businessFlags->where('business_type_id', $id)->findAll();


      $this->view['BusinessFlagModel'] = $businessFlags;

      $request = service('request');
      if ($this->request->getMethod() == 'POST') {
        $id = $this->request->getVar('id');
        $error = $this->validate([
          'company_structure_name' =>  'required|alpha_numeric_space',
          'flags' =>  'required',
        ]);
        if (!$error) {
          $this->view['error']   = $this->validator;
        } else {
          $businestsypeModel = new BusinessTypeModel();
          $normalizedStr = strtolower(str_replace(' ', '', $this->request->getVar('company_structure_name')));
          $flagstypecnt_data = $businestsypeModel
            ->where('status', 'Active')
            ->where('deleted_at', NULL)
            ->where('LOWER(REPLACE(company_structure_name, " ", ""))', $normalizedStr)
            ->where('id!=', $id)
            ->orderBy('id')->countAllResults();
          if ($flagstypecnt_data == 0) {
            $businestsypeModel->update($id, [
              'company_structure_name'  =>  $this->request->getVar('company_structure_name'),
              'updated_at'  =>  date("Y-m-d h:i:sa"),
            ]);

            $flagModel = new BusinessTypeFlagModel();
            $flagModeldata = $flagModel->where('business_type_id', $id)->delete();
            $flags_array = $this->request->getVar('flags');

            foreach ($flags_array as $key => $value) {
              $flagData1 = [
                'business_type_id'       =>  $id,
                'flags_id'     =>   $value,
                'mandatory' => $this->request->getVar('radio_' . $value)
              ];
              $flagModel->save($flagData1);
            }
          } else {
            $this->validator->setError('company_structure_name', 'The field must contain a unique value.');
            $this->view['error']  = $this->validator;
            $this->view['businessFlags'] = $businessFlags->where('business_type_id', $id)->findAll();
            $this->view['business_data'] = $businestsypeModel->where('id', $id)->first();
            return view('BusinessType/edit', $this->view);
            return false;
          }
          $session = \Config\Services::session();
          $session->setFlashdata('success', 'Business type updated');
          return $this->response->redirect(site_url('/Businesstype'));
        }
      }
    }

    return view('BusinessType/edit', $this->view);
  }

  public function delete($id = null)
  {

    $access = $this->_access;
    if ($access === 'false') {
      $session = \Config\Services::session();
      $session->setFlashdata('error', 'You are not permitted to access this page');
      return $this->response->redirect(site_url('/dashboard'));
    } else {
      $BusinessTypeModel = new BusinessTypeModel();
      $BusinessTypeModel->where('id', $id)->delete($id);
      $session = \Config\Services::session();
      $session->setFlashdata('success', 'Business type Deleted');
      return $this->response->redirect(site_url('/Businesstype'));
    }
  }

  public function statusupdate($id = null)
  {
    $access = $this->_access;
    if ($access === 'false') {
      $session = \Config\Services::session();
      $session->setFlashdata('error', 'You are not permitted to access this page');
      return $this->response->redirect(site_url('/dashboard'));
    } else {
      $BusinessTypeModel = new BusinessTypeModel();
      $model = $BusinessTypeModel->where('id', $id)->first();
      if ($model['condition'] == 'Enable') {
        $status = 'Disable';
      } elseif ($model['condition'] == 'Disable') {
        $status = 'Enable';
      }
      $BusinessTypeModel->update($id, [
        'condition'  =>  $status,
        'updated_at'  =>  date("Y-m-d h:i:sa"),
      ]);
      $session = \Config\Services::session();
      $session->setFlashdata('success', 'Business type status changed');
      return $this->response->redirect(site_url('/Businesstype'));
    }
  }
}
