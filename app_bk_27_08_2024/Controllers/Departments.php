<?php

namespace App\Controllers;
  
use App\Controllers\BaseController;
use App\Models\DepartmentModel;
use App\Models\EmployeeDepartmentModel;
use CodeIgniter\HTTP\ResponseInterface;

class Departments extends BaseController
{ 
    public $session; 
    public $DepartmentModel;
    public $EmployeeDepartmentModel;
    public function __construct()
    { 
      $this->session = \Config\Services::session(); 
      $this->DepartmentModel = new DepartmentModel();
      $this->EmployeeDepartmentModel= new EmployeeDepartmentModel();

    }
  
    public function index()
    {    
        $this->DepartmentModel->select('departments.*'); 
        if ($this->request->getPost('status') != '') {
           $this->DepartmentModel->where('status', $this->request->getPost('status'));
        } 
        $this->view['departments']  = $this->DepartmentModel->findAll();
        return view('Department/index', $this->view); 
    } 
  
    function create(){   
      if($this->request->getPost()){
        $error = $this->validate([ 
          'dept_name'   =>  'required' 
        ]);   
        if (!$error) {
          $this->view['error']   = $this->validator;
        } else {  
          $data['dept_name'] = $this->request->getVar('dept_name');
          $data['status'] = 1;

          $this->DepartmentModel->save($data);  
          $this->session->setFlashdata('success', 'Department Added Successfully');
  
          return $this->response->redirect(base_url('/departments'));
        }
      }
      return view('Department/create', $this->view); 
    }
  
    function edit($id){   
      $this->view['department'] = $this->DepartmentModel->where(['id' => $id])->first(); 

      // echo '<pre>';print_r($this->view['department']);exit;
      if($this->request->getPost()){
        $error = $this->validate([ 
         'dept_name'   =>  'required'  
        ]); 
        $validation = \Config\Services::validation();
        // echo 'POst dt<pre>';print_r($this->request->getPost());
        // echo 'getErrors<pre>';print_r($validation->getErrors());//exit;
  
        if (!$error) {
          $this->view['error']   = $this->validator;
        } else { 
          $data['dept_name'] = $this->request->getVar('dept_name'); 

          $this->DepartmentModel->update($id,$data); 
          // echo 'data<pre>';print_r($data);exit;
          $this->session->setFlashdata('success', 'Department Updated Successfully');
  
          return $this->response->redirect(base_url('/departments'));
        }
      }
      return view('Department/edit', $this->view); 
    } 
  
    public function delete($id = null)
    {  
      $exist_emp_dept =  $this->EmployeeDepartmentModel->where('department_id',$id)->first();
      // print_r($exist_emp_dept);exit;
      if($exist_emp_dept){
        $this->session->setFlashdata('danger', 'Department can not be deleted, department is assigned to employee');
        return $this->response->redirect(base_url('/departments')); 
      }else{
        $this->DepartmentModel->where('id', $id)->delete($id); 
        $this->session->setFlashdata('success', 'Department has been deleted successfully');
        return $this->response->redirect(base_url('/departments')); 
      }
    }
  
    function preview($id){ 
      $this->view['department'] = $this->DepartmentModel->where(['departments.id' => $id])->first();
      // echo '<pre>';print_r($this->view['department']);exit;
      return view('Department/preview', $this->view); 
    }
}
