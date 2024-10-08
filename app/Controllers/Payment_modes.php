<?php

namespace App\Controllers;
  
use App\Controllers\BaseController; 
use App\Models\PaymentModeModel; 
use CodeIgniter\HTTP\ResponseInterface;

class Payment_modes extends BaseController
{ 
    public $session; 
    public $PaymentModeModel;

    public function __construct()
    { 
      $this->session = \Config\Services::session(); 
      $this->PaymentModeModel = new PaymentModeModel();
    }
  
    public function index()
    {   
        $this->view['data'] = $this->PaymentModeModel->select('name,id')->findAll();
        $this->PaymentModeModel->select('payment_modes.*');  
        $this->view['data']  = $this->PaymentModeModel->findAll();
        return view('PaymentMode/index', $this->view); 
    } 
  
    function create(){   
      if($this->request->getPost()){
        $error = $this->validate([ 
          'name'   =>  'required' 
        ]); 
        $validation = \Config\Services::validation();
        // echo 'POst dt<pre>';print_r($this->request->getPost());
        // echo 'getErrors<pre>';print_r($validation->getErrors());exit;
  
        if (!$error) {
          $this->view['error']   = $this->validator;
        } else {  
          $data['name'] = $this->request->getVar('name'); 

          $this->PaymentModeModel->save($data); 
          // echo 'data<pre>';print_r($data);exit;
          $this->session->setFlashdata('success', 'Payment Mode Added Successfully');
  
          return $this->response->redirect(base_url('/payment_modes'));
        }
      }
      return view('PaymentMode/form', $this->view); 
    }
  
    function edit($id){   
      $this->view['token'] = $id;
      $this->view['data'] = $this->PaymentModeModel->where(['id' => $id])->first(); 
 
      if($this->request->getPost()){
        $error = $this->validate([ 
         'name'   =>  'required'  
        ]); 
        $validation = \Config\Services::validation(); 
  
        if (!$error) {
          $this->view['error']   = $this->validator;
        } else { 
          $data['name'] = $this->request->getVar('name'); 

          $this->PaymentModeModel->update($id,$data); 
          // echo 'data<pre>';print_r($data);exit;
          $this->session->setFlashdata('success', 'Payment Mode Updated Successfully');
  
          return $this->response->redirect(base_url('/payment_modes'));
        }
      }
      return view('PaymentMode/form', $this->view); 
    } 
  
    public function delete($id = null)
    {  
      $this->PaymentModeModel->where('id', $id)->delete($id); 
      $this->session->setFlashdata('success', 'Payment Mode has been deleted successfully');
      return $this->response->redirect(base_url('/payment_modes')); 
    }
  
    function preview($id){ 
      $this->view['data'] = $this->PaymentModeModel->where(['payment_modes.id' => $id])->first(); 
      return view('PaymentMode/preview', $this->view); 
    }
}
