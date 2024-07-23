<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\StateModel;
use App\Models\OfficeModel;
use App\Models\ProfileModel;
use App\Models\VehicleModel;
use App\Models\BookingsModel; 
use App\Models\ExpenseHeadModel;
use App\Controllers\BaseController;
use App\Models\LoadingReceiptModel;
use CodeIgniter\HTTP\ResponseInterface;

class ExpenseHead extends BaseController
{
    public $OModel;
    public $BookingsModel;
    public $VModel;
    public $LoadingReceiptModel;
    public $session;
    public $profile;
    public $ExpenseHeadModel;
  
    public function __construct()
    {
      $u = new UserModel(); 
      $this->OModel = new OfficeModel();
      $this->BookingsModel = new BookingsModel();
      $this->VModel = new VehicleModel();
      $this->LoadingReceiptModel = new LoadingReceiptModel();
      $this->ExpenseHeadModel = new ExpenseHeadModel();
      $this->session = \Config\Services::session();
      $this->profile = new ProfileModel();
    }
  
    public function index()
    {   
      $this->view['expense_heads'] = $this->ExpenseHeadModel->orderBy('id', 'desc')->findAll();
      return view('ExpenseHead/index', $this->view); 
    } 
  
    function create(){  
      $stateModel = new StateModel();
      $this->view['states'] = $stateModel->where(['isStatus' => '1'])->orderBy('state_name', 'ASC')->findAll(); 
      if($this->request->getPost()){
        $error = $this->validate([ 
          'head_name'   =>  'required' ,
          'type_1'   =>  'required' ,
          'type_2'   =>  'required' ,
          'type_3'   =>  'required' ,
        ]); 
        $validation = \Config\Services::validation();
        // echo 'POst dt<pre>';print_r($this->request->getPost());
        // echo 'getErrors<pre>';print_r($validation->getErrors());exit;
  
        if (!$error) {
          $this->view['error']   = $this->validator;
        } else {  
          $data['head_name'] = $this->request->getVar('head_name');
          $data['type_1'] = $this->request->getVar('type_1');
          $data['type_2'] = $this->request->getVar('type_2');
          $data['type_3'] = $this->request->getVar('type_3');
          $data['status'] = 1;
  
          $this->ExpenseHeadModel->save($data); 
          // echo 'data<pre>';print_r($data);exit;
          $this->session->setFlashdata('success', 'Expense Head Added Successfully');
  
          return $this->response->redirect(base_url('/expensehead'));
        }
      }
      return view('ExpenseHead/create', $this->view); 
    }
  
    function edit($id){  
      $stateModel = new StateModel();
      $this->view['expense_heads'] = $this->ExpenseHeadModel->where(['id' => $id])->first();
      $this->view['states'] = $stateModel->where(['isStatus' => '1'])->orderBy('state_name', 'ASC')->findAll(); 

      // echo '<pre>';print_r($this->view['expense_heads']);exit;
      if($this->request->getPost()){
        $error = $this->validate([ 
         'head_name'   =>  'required' ,
         'type_1'   =>  'required' ,
         'type_2'   =>  'required' ,
         'type_3'   =>  'required' ,
        ]); 
        $validation = \Config\Services::validation();
        // echo 'POst dt<pre>';print_r($this->request->getPost());
        // echo 'getErrors<pre>';print_r($validation->getErrors());//exit;
  
        if (!$error) {
          $this->view['error']   = $this->validator;
        } else {
          $booking = $this->BookingsModel->where('id', $this->request->getVar('booking_id'))->first();
          $data['head_name'] = $this->request->getVar('head_name');
          $data['type_1'] = $this->request->getVar('type_1');
          $data['type_2'] = $this->request->getVar('type_2');
          $data['type_3'] = $this->request->getVar('type_3');

          $this->ExpenseHeadModel->update($id,$data); 
          // echo 'data<pre>';print_r($data);exit;
          $this->session->setFlashdata('success', 'Expense Head Updated Successfully');
  
          return $this->response->redirect(base_url('/expensehead'));
        }
      }
      return view('ExpenseHead/edit', $this->view); 
    } 
  
    public function delete($id = null)
    {  
      $this->ExpenseHeadModel->where('id', $id)->delete($id); 
      $this->session->setFlashdata('success', 'Expense Head has been deleted successfully');
      return $this->response->redirect(base_url('/expensehead')); 
    }
  
    function preview($id){
      $stateModel = new StateModel();
      $this->view['expense_heads'] = $this->ExpenseHeadModel->where(['expense_heads.id' => $id])->first();
      $this->view['states'] = $stateModel->where(['isStatus' => '1'])->orderBy('state_name', 'ASC')->findAll(); 
      // echo '<pre>';print_r($this->view['expense_heads']);exit;
      return view('ExpenseHead/preview', $this->view); 
    }
}
