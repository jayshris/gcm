<?php
namespace App\Controllers;
use App\Models\RoleModel;
use App\Models\RoleModulesModel;

class Role extends BaseController
{
        public $model;
        
        public function __construct(){
            $this->model = new RoleModel();
        }

        public function index(){
                $this->view['rows'] = $this->model->where('id!=1')->where('status_id', '1')->orderBy('role_name', 'ASC')->paginate(10);
                //echo __LINE__.$this->model->getLastQuery().'<pre>';print_r($this->view['rows']);die;
                // $this->view['pagination_link'] = $this->model->pager;
                // $this->view['page_data'] = [
                // 'page_title' => view( 'partials/page-title', [ 'title' => 'Company','li_1' => '123','li_2' => 'deals' ] )
                // ];
                return view($this->view['currentController'].'/'.$this->view['currentMethod'],$this->view);
        }

        public function create(){
                $request = service('request');
                if($this->request->getMethod()=='POST'){
                        $rules = [
                                'role_name' => ['label'=>'Role Name', 'rules'=>'required|trim|is_unique[roles.role_name]']
                        ];

                        if($this->validate($rules)){
                                $data = [
                                        'role_name' => $this->request->getVar('role_name'),
                                        'added_by' => $this->view['loggedIn'],
                                        'added_ip' => $this->view['loggedIP'],
                                        'added_date' => $this->view['actionTime'],
                                        'modify_date' => $this->view['actionTime']
                                ];
                                $this->model->save($data);
                                $session = \Config\Services::session();
                                $session->setFlashdata('success', 'User Added');
                                return redirect()->to('/'.$this->view['currentController']);
                        }else{
                                $this->view['validation'] = $this->validator;
                                return view($this->view['currentController'].'/action', $this->view);
                        }
                }
                return view($this->view['currentController'].'/action',$this->view);
        }

        public function edit($id=0){
                $this->view['token'] = $id;
                if($this->request->getMethod()=='POST'){
                        $rules = [
                                'role_name' => ['label'=>'Role Name', 'rules'=>'required|trim|is_unique[roles.role_name,id,'.$id.']'],
                                'status_id' =>'required|trim'
                        ];

                        if($this->validate($rules)){                                
                                $data = [
                                        'id'        => $this->view['token'],
                                        'role_name' => $this->request->getVar('role_name'),
                                        'status_id' => $this->request->getVar('status_id'),
                                        'modify_by' => $this->view['loggedIn'],
                                        'modify_ip' => $this->view['loggedIP'],
                                        'modify_date' => $this->view['actionTime']
                                ];
                                
                                $this->model->update($this->view['token'], $data);//echo '<pre>'.$this->model->getLastQuery();die;
                                
                                $session = \Config\Services::session();
                                $session->setFlashdata('success', 'Role detail updated!');
                                return redirect()->to('/'.$this->view['currentController']);
                        }else{
                                $this->view['validation'] = $this->validator;
                                return view($this->view['currentController'].'/action', $this->view);
                                //return redirect()->to('/'.$this->view['currentController'].'/'.$this->view['currentMethod'].'/'.$this->view['token'])->with('error', $this->view['error'] );
                        }
                }

                $this->view['row'] = $this->model->where('id', $id)->first();
                return view($this->view['currentController'].'/action',$this->view);
        }

        public function delete($id=null){
                $this->model->where('id', $id)->delete($id);
                $session = \Config\Services::session();
                $session->setFlashdata('success', 'User Deleted');
                return $this->response->redirect(site_url('/user'));
        }       

        public function permission($id=0)
        {
                $this->view['token'] = $id;
                $roleModule = new RoleModulesModel(); 
                $request = service('request');
                if($this->request->getMethod()=='POST'){
                        //Delete all assigned access
                        $roleModule->where('role_id', $id)->delete();

                        $modules = ($this->request->getVar('module')) ? $this->request->getVar('module') : [];
                        //echo __LINE__.'<pre>';print_r($modules);die;
                        if(!empty($modules)){
                                foreach($modules as $k=>$m){//echo __LINE__.'<pre>';print_r($m);print_r($modules);die;
                                        $sections = isset($m['sections']) ? $m['sections'] : [0=>0];
                                        foreach($sections as $s){
                                                $data = [
                                                        'role_id' => $id,
                                                        'module_id' => $k,
                                                        'section_id' => $s,
                                                        'added_by' => 1,
                                                        'added_ip' => $_SERVER['REMOTE_ADDR']
                                                ];
                                                $roleModule->save($data);
                                        }
                                }
                        }

                        $session = \Config\Services::session();
                        $session->setFlashdata('success', 'Role permission added!');
                        return redirect()->to('/'.$this->view['currentController']);
                }

                $this->view['row'] = $this->model->where('id', $id)->first();
                $this->view['modules'] = $this->model->getModules();
                $this->view['sections'] = $this->model->getSections();
                $this->view['role_modules'] = $roleModule->where('role_id', $id)->findAll();
                //echo '<pre>';print_r($this->view['sections']);die;

                return view($this->view['currentController'].'/'.$this->view['currentMethod'],$this->view);
        }
}