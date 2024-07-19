<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\VehicleMfgModel;
use CodeIgniter\HTTP\ResponseInterface;

class Vehiclemfg extends BaseController
{

    public $access;
    public $session;
    public $added_by;
    public $added_ip;
    public $VMModel;

    public function __construct()
    {
        $user = new UserModel();
        $this->access = $user->setPermission();

        $this->session = \Config\Services::session();

        $this->VMModel = new VehicleMfgModel();

        $this->added_by = isset($_SESSION['id']) ? $_SESSION['id'] : '0';
        $this->added_ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
    }

    public function index()
    {
        if ($this->access === 'false') {
            $this->session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(base_url('/dashboard'));
        } else {

            $this->view['body_types'] = $this->VMModel->where(['is_deleted' => '0'])->orderBy('id', 'DESC')->findAll();

            return view('VehicleMfg/index', $this->view);
        }
    }

    public function create()
    {
        if ($this->access === 'false') {
            $this->session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(base_url('/dashboard'));
        } else {
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
                    return view('VehicleMfg/action', $this->view);
                } else {

                    $this->VMModel->save([
                        'name' => $this->request->getVar('mfg_name'),
                        'created_by' => $this->added_by,
                        'created_ip' => $this->added_ip
                    ]);
                    $this->session->setFlashdata('success', 'Vehicle Manufacturer Successfully Added');

                    return $this->response->redirect(base_url('vehicle-mfg'));
                }
            }

            return view('VehicleMfg/action');
        }
    }

    public function edit($id)
    {
        if ($this->access === 'false') {
            $this->session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(base_url('/dashboard'));
        } else {

            if ($this->request->getPost()) {

                $this->VMModel->update($id, [
                    'name' => $this->request->getVar('mfg_name'),
                    'status' => $this->request->getVar('status'),
                    'modified_by' => $this->added_by,
                    'modified_at' => date('Y-m-d h:i:s'),
                    'modified_ip' => $this->added_ip
                ]);

                $this->session->setFlashdata('success', 'Vehicle Manufacturer Updated Successfully ');
                return $this->response->redirect(base_url('vehicle-mfg'));
            }

            $this->view['mfg_details'] = $this->VMModel->where('id', $id)->first();
            return view('VehicleMfg/action', $this->view);
        }
    }

    public function delete($id)
    {
        $this->VMModel->update($id, ['is_deleted' => '1']);
        $this->session->setFlashdata('success', 'Vehicle Manufacturer Successfully Deleted');
        return $this->response->redirect(base_url('vehicle-mfg'));
    }
}
