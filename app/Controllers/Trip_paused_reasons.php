<?php

namespace App\Controllers;
  
use App\Controllers\BaseController;
use App\Models\TripPausedReasonModel; 
use CodeIgniter\HTTP\ResponseInterface;

class Trip_paused_reasons extends BaseController
{ 
    public $session; 
    public $TripPausedReasonModel;

    public function __construct()
    { 
      $this->session = \Config\Services::session(); 
      $this->TripPausedReasonModel = new TripPausedReasonModel();
    }
  
    public function index()
    {   
        $this->view['resaons'] = $this->TripPausedReasonModel->select('name,id')->findAll();
        $this->TripPausedReasonModel->select('trip_paused_reasons.*');
        if ($this->request->getPost('resaon_id') != '') {
            $this->TripPausedReasonModel->where('id', $this->request->getPost('resaon_id'));
         }
        if ($this->request->getPost('status') != '') {
           $this->TripPausedReasonModel->where('status', $this->request->getPost('status'));
        } 
        $this->view['data']  = $this->TripPausedReasonModel->findAll();
        return view('TripPausedReasons/index', $this->view); 
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

          $this->TripPausedReasonModel->save($data); 
          // echo 'data<pre>';print_r($data);exit;
          $this->session->setFlashdata('success', 'Trip Paused Reason Added Successfully');
  
          return $this->response->redirect(base_url('/trip_paused_reasons'));
        }
      }
      return view('TripPausedReasons/form', $this->view); 
    }
  
    function edit($id){   
      $this->view['token'] = $id;
      $this->view['data'] = $this->TripPausedReasonModel->where(['id' => $id])->first(); 
 
      if($this->request->getPost()){
        $error = $this->validate([ 
         'name'   =>  'required'  
        ]); 
        $validation = \Config\Services::validation(); 
  
        if (!$error) {
          $this->view['error']   = $this->validator;
        } else { 
          $data['name'] = $this->request->getVar('name'); 

          $this->TripPausedReasonModel->update($id,$data); 
          // echo 'data<pre>';print_r($data);exit;
          $this->session->setFlashdata('success', 'Trip Paused Reason Updated Successfully');
  
          return $this->response->redirect(base_url('/trip_paused_reasons'));
        }
      }
      return view('TripPausedReasons/form', $this->view); 
    } 
  
    public function delete($id = null)
    {  
      $this->TripPausedReasonModel->where('id', $id)->delete($id); 
      $this->session->setFlashdata('success', 'Trip Paused Reason has been deleted successfully');
      return $this->response->redirect(base_url('/trip_paused_reasons')); 
    }
  
    function preview($id){ 
      $this->view['data'] = $this->TripPausedReasonModel->where(['trip_paused_reasons.id' => $id])->first(); 
      return view('TripPausedReasons/preview', $this->view); 
    }
}
