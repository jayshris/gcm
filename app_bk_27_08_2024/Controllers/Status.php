<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookingStatusModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Status extends BaseController
{
    public $SModel;
    public $access;
    public $session;
    public $added_by;
    public $added_ip;

    public function __construct()
    {
        $this->session = \Config\Services::session();

        $this->SModel = new BookingStatusModel();

        $user = new UserModel();
        $this->access = $user->setPermission();

        $this->added_by = isset($_SESSION['id']) ? $_SESSION['id'] : '0';
        $this->added_ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
    }

    public function index()
    {
        if ($this->access === 'false') {
            $this->session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(base_url('/dashboard'));
        } else {

            $this->view['statuses'] = $this->SModel->findAll();

            return view('Status/index', $this->view);
        }
    }

    public function create()
    {
        if ($this->access === 'false') {
            $this->session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(base_url('/dashboard'));
        } else {
            if ($this->request->getPost()) {

                $this->SModel->save([
                    'status_name' => $this->request->getVar('status'),
                    'status_bg' => $this->request->getVar('status_bg')
                ]);
                $this->session->setFlashdata('success', 'New Status Successfully Added');

                return $this->response->redirect(base_url('status'));
            }
            return view('Status/create', $this->view);
        }
    }

    public function edit($id)
    {
        if ($this->access === 'false') {
            $this->session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(base_url('/dashboard'));
        } else {
            if ($this->request->getPost()) {

                $this->SModel->update($id, [
                    'status_name' => $this->request->getVar('status'),
                    'status_bg' => $this->request->getVar('status_bg'),
                    'updated_date' => date('Y-m-d h:i:s')
                ]);
                $this->session->setFlashdata('success', 'Status Successfully Updated');

                return $this->response->redirect(base_url('status'));
            }

            $this->view['status_details'] = $this->SModel->where('id', $id)->first();
            return view('Status/create', $this->view);
        }
    }

    public function delete($id)
    {
        $this->SModel->delete($id);

        $this->session->setFlashdata('danger', 'Status Deleted Successfully');

        return $this->response->redirect(base_url('status'));
    }
}
