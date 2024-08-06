<?php

namespace App\Controllers;
  
use App\Controllers\BaseController;
use App\Models\BookingCancellationReasonModel; 
use CodeIgniter\HTTP\ResponseInterface;

class Bookingcancellationreasons extends BaseController
{ 
    public $session; 
    public $BookingCancellationReasonModel;

    public function __construct()
    { 
      $this->session = \Config\Services::session(); 
      $this->BookingCancellationReasonModel = new BookingCancellationReasonModel();
    }
  
    public function index()
    {   
        $this->view['resaons'] = $this->BookingCancellationReasonModel->select('name,id')->findAll();
        $this->BookingCancellationReasonModel->select('booking_cancellation_reasons.*');
        if ($this->request->getPost('resaon_id') != '') {
            $this->BookingCancellationReasonModel->where('id', $this->request->getPost('resaon_id'));
         }
        if ($this->request->getPost('status') != '') {
           $this->BookingCancellationReasonModel->where('status', $this->request->getPost('status'));
        } 
        $this->view['booking_cancellation_reasons']  = $this->BookingCancellationReasonModel->findAll();
        return view('BookingCancellationReasons/index', $this->view); 
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
          $data['status'] = 1;

          $this->BookingCancellationReasonModel->save($data); 
          // echo 'data<pre>';print_r($data);exit;
          $this->session->setFlashdata('success', 'Booking Cancellation Reason Added Successfully');
  
          return $this->response->redirect(base_url('/bookingcancellationreasons'));
        }
      }
      return view('BookingCancellationReasons/create', $this->view); 
    }
  
    function edit($id){   
      $this->view['booking_cancellation_reasons'] = $this->BookingCancellationReasonModel->where(['id' => $id])->first(); 

      // echo '<pre>';print_r($this->view['booking_cancellation_reasons']);exit;
      if($this->request->getPost()){
        $error = $this->validate([ 
         'name'   =>  'required'  
        ]); 
        $validation = \Config\Services::validation();
        // echo 'POst dt<pre>';print_r($this->request->getPost());
        // echo 'getErrors<pre>';print_r($validation->getErrors());//exit;
  
        if (!$error) {
          $this->view['error']   = $this->validator;
        } else { 
          $data['name'] = $this->request->getVar('name'); 

          $this->BookingCancellationReasonModel->update($id,$data); 
          // echo 'data<pre>';print_r($data);exit;
          $this->session->setFlashdata('success', 'Booking Cancellation Reason Updated Successfully');
  
          return $this->response->redirect(base_url('/bookingcancellationreasons'));
        }
      }
      return view('BookingCancellationReasons/edit', $this->view); 
    } 
  
    public function delete($id = null)
    {  
      $this->BookingCancellationReasonModel->where('id', $id)->delete($id); 
      $this->session->setFlashdata('success', 'Booking Cancellation Reason has been deleted successfully');
      return $this->response->redirect(base_url('/bookingcancellationreasons')); 
    }
  
    function preview($id){ 
      $this->view['booking_cancellation_reasons'] = $this->BookingCancellationReasonModel->where(['booking_cancellation_reasons.id' => $id])->first();
      // echo '<pre>';print_r($this->view['booking_cancellation_reasons']);exit;
      return view('BookingCancellationReasons/preview', $this->view); 
    }
}
