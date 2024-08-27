<?php
namespace App\Controllers;
use App\Models\FueltypeModel;
use App\Models\UserModel;
use App\Models\ModulesModel;


class Fueltype extends BaseController {
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
          $fueltypeModel = new FueltypeModel();

          $this->view['fueltype_data'] = $fueltypeModel->where(['status'=>'Active'])->orderBy('id', 'DESC')->paginate(10);
          $this->view['pagination_link'] = $fueltypeModel->pager;

          $this->view['page_data'] = [
            'page_title' => view( 'partials/page-title', [ 'title' => 'Fuel Type','li_1' => '123','li_2' => 'deals' ] )
            ];
          return view('FuelType/index',$this->view);
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
            'page_title' => view( 'partials/page-title', [ 'title' => 'Add Fuel Type','li_2' => 'profile' ] )
            ];

            $fueltypeModel = new FueltypeModel();
            
		        $this->view['fueltype_data'] = $fueltypeModel->where(['status'=>'Active'])->orderBy('id')->findAll();
        

            $request = service('request');
            if($this->request->getMethod()=='POST'){
              $error = $this->validate([
                'fuel_name'   =>  'required|min_length[3]|max_length[50]|alpha_numeric_space',
              ]);
              if(!$error)
              {
                $this->view['error'] 	= $this->validator;
              }else {
                $normalizedStr = strtolower(str_replace(' ', '', $this->request->getVar('fuel_name')));
                $fueltypeModel = new FueltypeModel();
                $flags_data = $fueltypeModel
                ->where('status','Active')
                ->where('deleted_at',NULL)
                ->where('LOWER(REPLACE(fuel_name, " ", ""))',$normalizedStr)
                ->orderBy('id')->countAllResults();
                if($flags_data==0){
                  $fueltypeModel = new FueltypeModel();
                  $fueltypeModel->save([
                    'fuel_name'	=>	$this->request->getVar('fuel_name'),
                    'status'  => 'Active',
                    'created_at'  =>  date("Y-m-d h:i:sa"),

                  ]);
                }else{
                  $this->validator->setError('fuel_name', 'The field must contain a unique value.');
                  $this->view['error']  = $this->validator;
                  return view( 'FuelType/create',$this->view );
                  return false;
                }
                $session = \Config\Services::session();
    
                $session->setFlashdata('success', 'Fuel Type Added');
                return $this->response->redirect(site_url('/fueltype'));
              }
    
              
            }
            return view( 'FuelType/create',$this->view );
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

          $fueltypeModel = new FueltypeModel();
          if($id!=''){
            $this->view['fueltype_data'] = $fueltypeModel->where('id', $id)->first();
          }
          $request = service('request');
          if($this->request->getMethod()=='POST'){
            $id = $this->request->getVar('id');
            $this->view['fueltype_data'] = $fueltypeModel->where('id', $id)->first();
            $error = $this->validate([
              'fuel_name'   =>  'required|min_length[3]|max_length[50]|alpha_numeric_space',
            ]);
            if(!$error)
            {
              $this->view['error'] 	= $this->validator;
              
            }else {
              $normalizedStr = strtolower(str_replace(' ', '', $this->request->getVar('fuel_name')));
                $fueltypeModel = new FueltypeModel();
                $flags_data = $fueltypeModel
                ->where('status','Active')
                ->where('deleted_at',NULL)
                ->where('LOWER(REPLACE(fuel_name, " ", ""))',$normalizedStr)
                ->where('id!=',$id)
                ->orderBy('id')->countAllResults();
                if($flags_data==0){
                  $fueltypeModel = new FueltypeModel();
                  $fueltypeModel->update($id,[
                    'fuel_name'  =>  $this->request->getVar('fuel_name'),
                    'status'  => 'Active',
                    'updated_at'  =>  date("Y-m-d h:i:sa"),
                  ]);
                }else{
                  $this->validator->setError('fuel_name', 'The field must contain a unique value.');
                  $this->view['error']  = $this->validator;
                  return view( 'FuelType/edit_fueltype',$this->view );
                  return false;
                }
              
              $session = \Config\Services::session();
  
              $session->setFlashdata('success', 'Fuel Type updated');
              return $this->response->redirect(site_url('/fueltype'));
            }
  
            
          }
          return view('FuelType/edit_fueltype', $this->view);
         }
         }

         public function delete($id){
          $access = $this->_access; 
          if($access === 'false'){
            $session = \Config\Services::session();
            $session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(site_url('/dashboard'));
            }else{
            $fueltypeModel = new FueltypeModel();
            $fueltypeModel->where('id', $id)->delete($id);
            $session = \Config\Services::session();
            $session->setFlashdata('success', 'Fuel Type Deleted');
            return $this->response->redirect(site_url('/fueltype'));
           }
         }

         
}
?>