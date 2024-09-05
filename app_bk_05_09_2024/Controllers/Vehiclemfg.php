<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\VehicleMfgModel;
use CodeIgniter\HTTP\ResponseInterface;

class Vehiclemfg extends BaseController
{
    public $model;
    public $view = [];

    public function __construct()
    {
        $this->model = new VehicleMfgModel();
    }

    public function index()
    {
        try {
            $this->view['body_types'] = $this->model->where(['is_deleted' => '0'])->orderBy('id', 'DESC')->findAll();
            return view($this->view['currentController'] . '/' . $this->view['currentMethod'], $this->view); //echo __LINE__;die;
        } catch (\Exception $e) {
            print_r($e->getMessage());
            die;
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);
        }
    }

    public function create()
    {
        if ($this->request->getPost()) {
            $valid = $this->validate([
                'mfg_name' => [
                    'rules' => 'required|trim|is_unique[vehicle_mfg.name]',
                    'errors' => [
                        'required' => 'The Body Type Name field is required',
                        'is_unique' => 'Duplicate Body Type is not allowed',
                    ],
                ]
            ]);

            if (!$valid) {
                $this->view['error'] = $this->validator;
                return view($this->view['currentController'] . '/action', $this->view);
            } else {

                $this->model->save([
                    'name' => $this->request->getVar('mfg_name'),
                    'created_by' => $this->view['loggedIn'],
                    'created_ip' => $this->view['loggedIP'],
                    'modified_at' => $this->view['actionTime']
                ]);
                $this->view['session']->setFlashdata('success', 'Vehicle Manufacturer Successfully Added');

                return $this->response->redirect(base_url($this->view['currentController']));
            }
        }

        return view($this->view['currentController'] . '/action', $this->view);
    }

    public function edit($id)
    {
        $this->view['token'] = $id;
        if ($this->request->getPost()) {
            $this->model->update($id, [
                'name' => $this->request->getVar('mfg_name'),
                'status' => $this->request->getVar('status'),
                'modified_by' => $this->view['loggedIn'],
                'modified_at' => $this->view['actionTime'],
                'modified_ip' => $this->view['loggedIP']
            ]);

            $this->view['session']->setFlashdata('success', 'Vehicle Manufacturer Updated Successfully ');
            return $this->response->redirect(base_url($this->view['currentController']));
        }

        $this->view['mfg_details'] = $this->model->where('id', $id)->first();
        return view($this->view['currentController'] . '/action', $this->view);
    }

    public function delete($id)
    {
        $this->model->update($id, ['is_deleted' => '1']);
        $this->view['session']->setFlashdata('success', 'Vehicle Manufacturer Successfully Deleted');
        return redirect()->to('/' . $this->view['currentController']);
        return $this->response->redirect(base_url($this->view['currentController']));
    }
}
