<?php

namespace App\Controllers;
  
use App\Controllers\BaseController;
use App\Models\BookingsTripUpdateModel;
use App\Models\PurposeOfUpdateModel; 
use CodeIgniter\HTTP\ResponseInterface;

class Purpose_of_updates extends BaseController
{ 
    public $session; 
    public $PurposeOfUpdateModel;
    public $BookingsTripUpdateModel;
    public function __construct()
    { 
      $this->session = \Config\Services::session(); 
      $this->PurposeOfUpdateModel = new PurposeOfUpdateModel();
      $this->BookingsTripUpdateModel =  new BookingsTripUpdateModel();
    }
  
    public function index()
    {   
        $this->view['names'] = $this->PurposeOfUpdateModel->select('name,id')->findAll();
        $this->PurposeOfUpdateModel->select('purpose_of_updates.*'); 
        if ($this->request->getPost('name') != '') {
            $this->PurposeOfUpdateModel->where('id', $this->request->getPost('name'));
         } 
        if ($this->request->getPost('status') != '') {
           $this->PurposeOfUpdateModel->where('status', $this->request->getPost('status'));
        } 
        $this->view['data']  = $this->PurposeOfUpdateModel->orderBy('id','desc')->findAll();
        return view('PurposeOfUpdates/index', $this->view); 
    } 
  
    function create(){   
      if($this->request->getPost()){
        $error = $this->validate([ 
          'name'   =>  'required|trim|is_unique[purpose_of_updates.name]',
          'is_money_mandatory'  =>  'required',  
          'is_fuel_mandatory'  =>  'required',  
        ]); 
        $validation = \Config\Services::validation();
        // echo 'POst dt<pre>';print_r($this->request->getPost());
        // echo 'getErrors<pre>';print_r($validation->getErrors());exit;
  
        if (!$error) {
          $this->view['error']   = $this->validator;
        } else {  
          $data['name'] = $this->request->getVar('name');
          $data['status'] = 1;
          $data['is_money_mandatory'] = $this->request->getVar('is_money_mandatory'); 
          $data['is_fuel_mandatory'] = $this->request->getVar('is_fuel_mandatory');  
          $this->PurposeOfUpdateModel->save($data); 
          // echo 'data<pre>';print_r($data);exit;
          $this->session->setFlashdata('success', 'Purpose Of Update Added Successfully');
  
          return $this->response->redirect(base_url('/purpose_of_updates'));
        }
      }
      return view('PurposeOfUpdates/form', $this->view); 
    }
  
    function edit($id){   
      $this->view['token'] = $id;
      $this->view['data'] = $this->PurposeOfUpdateModel->where(['id' => $id])->first(); 
 
      if($this->request->getPost()){
        $error = $this->validate([ 
         'name'   =>  'required|trim|is_unique[purpose_of_updates.name, purpose_of_updates.id,'.$id.']',
         'is_money_mandatory'  =>  'required',  
         'is_fuel_mandatory'  =>  'required',  
        ]); 
        $validation = \Config\Services::validation(); 
  
        if (!$error) {
          $this->view['error']   = $this->validator;
        } else { 
          $data['name'] = $this->request->getVar('name'); 
          $data['is_money_mandatory'] = $this->request->getVar('is_money_mandatory'); 
          $data['is_fuel_mandatory'] = $this->request->getVar('is_fuel_mandatory'); 
          $this->PurposeOfUpdateModel->update($id,$data); 
          // echo 'data<pre>';print_r($data);exit;
          $this->session->setFlashdata('success', 'Purpose Of Update Updated Successfully');
  
          return $this->response->redirect(base_url('/purpose_of_updates'));
        }
      }
      return view('PurposeOfUpdates/form', $this->view); 
    } 
  
    public function delete($id = null)
    {  
      //Check if purpose of update link to booking 
      $booking = $this->BookingsTripUpdateModel->where('purpose_of_update_id',$id)->first();

      if(!empty($booking)){
        $this->session->setFlashdata('danger', 'Purpose Of Update is link to booking, you can not able to delete this record');
        return $this->response->redirect(base_url('/purpose_of_updates'));
      }

      $this->PurposeOfUpdateModel->where('id', $id)->delete($id); 
      $this->session->setFlashdata('success', 'Purpose Of Update has been deleted successfully');
      return $this->response->redirect(base_url('/purpose_of_updates')); 
    }
  
    function preview($id){ 
      $this->view['data'] = $this->PurposeOfUpdateModel->where(['purpose_of_updates.id' => $id])->first(); 
      return view('PurposeOfUpdates/preview', $this->view); 
    }
}
