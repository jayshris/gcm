<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AccountsModel;
use CodeIgniter\HTTP\ResponseInterface;

class Accounts extends BaseController
{
    public $session;
    public $added_by;
    public $added_ip;

    public $AModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();

        $this->added_by = isset($_SESSION['id']) ? $_SESSION['id'] : '0';
        $this->added_ip = isset($_SERVER['REMOTE_ADDR'])  ? $_SERVER['REMOTE_ADDR'] : '';

        $this->AModel = new AccountsModel();
    }

    public function index()
    {
        if ($this->request->getPost('status') != '') {
            $this->AModel->where('status', $this->request->getPost('status'));
        } else {
            $this->AModel->where('status', '1');
        }

        $this->view['accounts'] = $this->AModel->findAll();

        return view('Accounts/index', $this->view);
    }

    public function create()
    {
        if ($this->request->getPost()) {
            // echo '<pre>';
            // print_r($this->request->getPost());
            // die;

            $this->AModel->insert([
                'ac_name' => $this->request->getPost('ac_name'),
                'ac_for' => $this->request->getPost('ac_for'),
                'ac_type' => $this->request->getPost('ac_type'),
                'ac_type_2' => $this->request->getPost('ac_type_2'),
                'created_by' =>  $this->added_by,
                'created_ip' => $this->added_ip
            ]);

            $this->session->setFlashdata('success', 'Account Successfully Added');
            return $this->response->redirect(base_url('accounts'));
        }

        return view('Accounts/action', $this->view);
    }

    public function edit($id)
    {

        $this->view['token'] = $id;
        $this->view['ac_details'] = $this->AModel->where('id', $id)->first();

        if ($this->request->getPost()) {
            // echo '<pre>';
            // print_r($this->request->getPost());
            // die;

            $this->AModel->update($id, [
                'ac_name' => $this->request->getPost('ac_name'),
                'ac_for' => $this->request->getPost('ac_for'),
                'ac_type' => $this->request->getPost('ac_type'),
                'ac_type_2' => $this->request->getPost('ac_type_2'),
                'updated_at' =>  date('Y-m-d H:i:s'),
                'updated_by' =>  $this->added_by,
                'updated_ip' => $this->added_ip
            ]);

            $this->session->setFlashdata('success', 'Account Successfully Updated');
            return $this->response->redirect(base_url('accounts'));
        }

        return view('Accounts/action', $this->view);
    }

    public function delete($id)
    {
        $this->AModel->delete($id);
        $this->session->setFlashdata('success', 'Account Deleted Successfully');
        return $this->response->redirect(base_url('accounts'));
    }
}
