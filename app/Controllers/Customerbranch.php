<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomerBranchModel;
use App\Models\CustomerBranchPersonModel;
use App\Models\CustomersModel;
use App\Models\StateModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Customerbranch extends BaseController
{
    public $access;
    public $session;
    public $added_by;
    public $added_ip;

    public $CModel;
    public $SModel;
    public $CBModel;
    public $CBPModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();

        $this->CModel = new CustomersModel();
        $this->SModel = new StateModel();
        $this->CBModel = new CustomerBranchModel();
        $this->CBPModel = new CustomerBranchPersonModel();

        $user = new UserModel();
        $this->access = $user->setPermission();

        $this->added_by = isset($_SESSION['id']) ? $_SESSION['id'] : '0';
        $this->added_ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
    }

    public function index()
    {
        if ($this->access === 'false') {
            $this->session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(base_url('dashboard'));
        } else {

            if ($this->request->getPost('status') != '') {
                $this->CBModel->where('customer_branches.status', $this->request->getPost('status'));
            } else {
                $this->CBModel->where('customer_branches.status', '1');
            }
            $this->view['branches'] = $this->CBModel->select('customer_branches.*, customer.phone, party.party_name')
                ->join('customer', 'customer.id = customer_branches.customer_id')
                ->join('party', 'party.id = customer.party_id')
                ->where('party.created_by!=', '')
                ->findAll();

            return view('Customerbranch/index', $this->view);
        }
    }

    public function create()
    {
        $this->view['customers'] = $this->CModel->select('customer.*, party.party_name')
            ->join('party', 'party.id = customer.party_id')
            ->findAll();
        $this->view['state'] = $this->SModel->where(['isStatus' => '1'])->orderBy('state_name', 'ASC')->findAll();

        if ($this->access === 'false') {
            $this->session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(base_url('/dashboard'));
        } else {
            if ($this->request->getPost()) {

                $this->CBModel->save([
                    'customer_id' => $this->request->getPost('party_id'),
                    'office_name' => $this->request->getPost('office_name'),
                    'gst' => $this->request->getPost('gst'),
                    'address' => $this->request->getPost('address'),
                    'city' => $this->request->getPost('city'),
                    'state_id' => $this->request->getPost('state_id'),
                    'country' => $this->request->getPost('country'),
                    'pincode' => $this->request->getPost('pin'),
                    'added_by' => $this->added_by,
                    'added_ip' => $this->added_ip
                ]);
                $branch_id = $this->CBModel->getInsertID();

                foreach ($this->request->getPost('contact_person') as $key => $val) {
                    $arr = [
                        'branch_id' => $branch_id,
                        'name' => $this->request->getPost('contact_person')[$key],
                        'designation' => $this->request->getPost('contact_designation')[$key],
                        'phone' => $this->request->getPost('contact_phone')[$key],
                        'email' => $this->request->getPost('contact_email')[$key]
                    ];
                    $this->CBPModel->save($arr);
                }

                $this->session->setFlashdata('success', 'Branch Successfully Added');

                return $this->response->redirect(base_url('customerbranch'));
            }
            return view('Customerbranch/action', $this->view);
        }
    }

    public function edit($id)
    {
        $this->view['customers'] = $this->CModel->select('customer.*, party.party_name')
            ->join('party', 'party.id = customer.party_id')
            ->findAll();
        $this->view['state'] = $this->SModel->where(['isStatus' => '1'])->orderBy('state_name', 'ASC')->findAll();

        $this->view['branch_detail'] = $this->CBModel->select('customer_branches.*, customer.phone, party.party_name')
            ->join('customer', 'customer.id = customer_branches.customer_id')
            ->join('party', 'party.id = customer.party_id')
            ->where('customer_branches.id', $id)
            ->first();

        $this->view['branch_persons'] = $this->CBPModel->where('branch_id', $id)->findAll();

        if ($this->access === 'false') {
            $this->session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(base_url('/dashboard'));
        } else {
            if ($this->request->getPost()) {

                $this->CBModel->update($id, [
                    'customer_id' => $this->request->getPost('party_id'),
                    'office_name' => $this->request->getPost('office_name'),
                    'gst' => $this->request->getPost('gst'),
                    'address' => $this->request->getPost('address'),
                    'city' => $this->request->getPost('city'),
                    'state_id' => $this->request->getPost('state_id'),
                    'country' => $this->request->getPost('country'),
                    'pincode' => $this->request->getPost('pin'),
                    'status' => $this->request->getPost('status'),
                    'modify_date' => date('Y-m-d h:i:s'),
                    'modify_ip' => $this->added_ip,
                    'modify_by' => $this->added_by,
                ]);

                $this->CBPModel->where('branch_id', $id)->delete();

                foreach ($this->request->getPost('contact_person') as $key => $val) {
                    $arr = [
                        'branch_id' => $id,
                        'name' => $this->request->getPost('contact_person')[$key],
                        'designation' => $this->request->getPost('contact_designation')[$key],
                        'phone' => $this->request->getPost('contact_phone')[$key],
                        'email' => $this->request->getPost('contact_email')[$key]
                    ];
                    $this->CBPModel->save($arr);
                }

                $this->session->setFlashdata('success', 'Customer Successfully Modified');

                return $this->response->redirect(base_url('Customerbranch'));
            }
            return view('Customerbranch/action', $this->view);
        }
    }


    public function personBlock($count)
    {
        echo '
            <div class="col-md-4 count del' . $count . '">
              <label class="col-form-label">Contact Person Name</label>
              <input type="text" class="form-control" name="contact_person[]">
            </div>
            <div class="col-md-2 del' . $count . '">
              <label class="col-form-label">Designation</label>
              <input type="text" class="form-control" name="contact_designation[]">
            </div>
            <div class="col-md-2 del' . $count . '">
              <label class="col-form-label">Phone No.</label>
              <input type="text" class="form-control" name="contact_phone[]">
            </div>
            <div class="col-md-3 del' . $count . '">
              <label class="col-form-label">Email</label>
              <input type="text" class="form-control" name="contact_email[]">
            </div>
            <div class="col-md-1 del' . $count . '"><button type="button" class="btn btn-danger" style="margin-top: 26px;" onclick="$.delete(' . $count . ');"><i class="fa fa-trash" aria-hidden="true"></i></button></div>
        ';
    }
}
