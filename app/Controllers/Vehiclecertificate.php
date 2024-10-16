<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\VehicleCertificateModel;

class Vehiclecertificate extends BaseController
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
        if($access === 'false'){
            $session = \Config\Services::session();
            $session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(site_url('/dashboard'));
        }else{
            $vcModel = new VehicleCertificateModel();
            $this->view['certificate_data'] = $vcModel->orderBy('id', 'DESC')->paginate(50);
            $this->view['pagination_link'] = $vcModel->pager;
            $this->view['page_data'] = [
                'page_title' => view( 'partials/page-title', [ 'title' => 'Vehicle Certificate','li_1' => '123','li_2' => 'deals' ] )
            ];
            return view('VehicleCertificate/index',$this->view);
        }
    }

    public function create()
    {
          $access = $this->_access; 
          if($access === 'false'){
            $session = \Config\Services::session();
            $session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(site_url('/dashboard'));
          }else{
              helper(['form', 'url']);
              $this->view ['page_data']= [
                'page_title' => view( 'partials/page-title', [ 'title' => 'Add Vehicle Certificate','li_2' => 'profile' ] )
                ];
                $request = service('request');
                if($this->request->getMethod()=='POST'){
                  $error = $this->validate([
                    'name'	                    =>  'required|regex_match[/^[a-z\d\-_\s]+$/i]|is_unique[party_type.name]',
                  ]);

                  if(!$error){
                    $this->view['error'] 	= $this->validator;
                  }else {
                    $vcModel = new VehicleCertificateModel();
                    $vcModel->save([
                      'name'	    =>	$this->request->getVar('name'),
                      'created_at'  =>  date("Y-m-d h:i:sa"),
                    ]);
                    $session = \Config\Services::session();
                    $session->setFlashdata('success', 'Vehicle Certificate added');
                    return $this->response->redirect(site_url('/vehiclecertificate'));
                  }
                }
                return view( 'VehicleCertificate/create',$this->view );
          }
    }

    public function edit($id=null)
    {
          $access = $this->_access; 
          if($access === 'false'){
            $session = \Config\Services::session();
            $session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(site_url('/dashboard'));
          }else{
            $vcModel = new VehicleCertificateModel();
            $this->view['vc_data'] = $vcModel->where('id', $id)->first();
            
            $request = service('request');
            if($this->request->getMethod()=='POST'){
              $id = $this->request->getVar('id');
              $error = $this->validate([
                'name'	=>	'required',
              ]);
              if(!$error)
              {
                $this->view['error'] 	= $this->validator;
              }else {
                $vcModel = new VehicleCertificateModel();
                $vcModel->update($id,[
                    'name'	        =>	$this->request->getVar('name'),
                    'updated_at'    =>  date("Y-m-d h:i:sa"),
                ]);
                $session = \Config\Services::session();
                $session->setFlashdata('success', 'Vehicle Certificate Updated');
                return $this->response->redirect(site_url('/vehiclecertificate'));
              }
            }
          }

        return view('VehicleCertificate/edit', $this->view);

    }

    public function delete($id){
        $access = $this->_access; 
        if($access === 'false'){
        $session = \Config\Services::session();
        $session->setFlashdata('error', 'You are not permitted to access this page');
        return $this->response->redirect(site_url('/dashboard'));
        }else{
            $vcModel = new VehicleCertificateModel();
            $vcModel->where('id', $id)->delete($id);
            $session = \Config\Services::session();
            $session->setFlashdata('success', 'Vehicle Certificate Deleted');
            return $this->response->redirect(site_url('/vehiclecertificate'));
        }
    }
}
