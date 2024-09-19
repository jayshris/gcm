<?php
// Pankaj
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PartyModel;
use App\Models\StateModel;
use App\Models\CustomersModel;
use App\Models\PartytypeModel;
use App\Models\BranchAddressModel;
use App\Models\CustomerBranchModel;
use App\Controllers\BaseController; 
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CustomerBranchPersonModel;

class Customers extends BaseController
{
    public $access;
    public $session;
    public $added_by;
    public $added_ip;

    public $PTModel;
    public $PModel;
    public $CModel;
    public $SModel;
    public $CBModel;
    public $CBPModel;
    public $BAModel;
    public function __construct()
    {
        $this->session = \Config\Services::session();

        $this->PTModel = new PartytypeModel();
        $this->PModel = new PartyModel();
        $this->CModel = new CustomersModel();
        $this->SModel = new StateModel();

        $user = new UserModel();
        $this->access = $user->setPermission();

        $this->added_by = isset($_SESSION['id']) ? $_SESSION['id'] : '0';
        $this->added_ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';

        $this->CBModel = new CustomerBranchModel();
        $this->CBPModel = new CustomerBranchPersonModel();
        $this->BAModel = new BranchAddressModel();
    }

    public function index()
    {
        if ($this->access === 'false') {
            $this->session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(base_url('dashboard'));
        } else {

            $this->view['party_types'] = $this->PTModel->where('status', 'Active')->findAll();
            $this->view['parties'] = $this->PModel->where('approved', '1')->orderBy('party_name', 'asc')->findAll();

            if ($this->request->getPost('party_type_id') > 0) {
                $this->CModel->where('party_type_id', $this->request->getPost('party_type_id'));
            }
            if ($this->request->getPost('party_id') > 0) {
                $this->CModel->where('party_id', $this->request->getPost('party_id'));
            }
            if ($this->request->getPost('status') != '') {
                $this->CModel->where('customer.status', $this->request->getPost('status'));
            } else {
                $this->CModel->where('customer.status', '1');
            }
            $this->view['customers'] = $this->CModel->select('customer.*, party.party_name')
                ->join('party', 'party.id = customer.party_id')
                ->where('party.created_by !=', '')
                ->orderBy('party.party_name', 'asc')
                ->findAll();

            return view('Customers/index', $this->view);
        }
    }

    public function create()
    {
        $this->view['party_types'] = $this->PTModel->where('status', 'Active')->findAll();
        $this->view['parties'] = $this->PModel->where('approved', '1')->findAll();
        $this->view['state'] = $this->SModel->where(['isStatus' => '1'])->orderBy('state_name', 'ASC')->findAll();

        if ($this->access === 'false') {
            $this->session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(base_url('/dashboard'));
        } else {
            if ($this->request->getPost()) {

                // print_r($this->request->getPost());
                // die;

                $this->CModel->save([
                    'party_type_id' => implode(',', $this->request->getPost('party_type')),
                    'party_id' => $this->request->getPost('party_id'),
                    'address' => $this->request->getPost('address'),
                    'city' => $this->request->getPost('city'),
                    'state_id' => $this->request->getPost('state_id'),
                    'postcode' => $this->request->getPost('pin'),
                    'phone' => $this->request->getPost('phone'),
                    'added_by' => $this->added_by,
                    'added_ip' => $this->added_ip
                ]);
                $this->session->setFlashdata('success', 'Customer Successfully Added');

                return $this->response->redirect(base_url('customers'));
            }
            return view('Customers/action', $this->view);
        }
    }

    public function edit($id)
    {
        $this->view['party_types'] = $this->PTModel->where('status', 'Active')->findAll();
        $this->view['parties'] = $this->PModel->where('approved', '1')->findAll();
        $this->view['state'] = $this->SModel->where(['isStatus' => '1'])->orderBy('state_name', 'ASC')->findAll();

        $this->view['customer_detail'] = $this->CModel->where('id', $id)->first();

        if ($this->access === 'false') {
            $this->session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(base_url('/dashboard'));
        } else {
            if ($this->request->getPost()) {

                $this->CModel->update($id, [
                    'party_type_id' => implode(',', $this->request->getPost('party_type')),
                    'party_id' => $this->request->getPost('party_id'),
                    'address' => $this->request->getPost('address'),
                    'city' => $this->request->getPost('city'),
                    'state_id' => $this->request->getPost('state_id'),
                    'postcode' => $this->request->getPost('pin'),
                    'phone' => $this->request->getPost('phone'),
                    'status' => $this->request->getPost('status'),
                    'modify_date' => date('Y-m-d h:i:s'),
                    'modify_ip' => $this->added_ip,
                    'modify_by' => $this->added_by,
                ]);
                $this->session->setFlashdata('success', 'Customer Successfully Modified');

                return $this->response->redirect(base_url('customers'));
            }
            return view('Customers/edit', $this->view);
        }
    }

    public function getPartyDetail()
    {
        $customer = $this->CModel->where('party_id', $this->request->getPost('party_id'))->first();



        $party = $this->PModel->where('id', $this->request->getPost('party_id'))->first();

        $party['isCustomer'] = $customer ? true : false;

        echo json_encode($party);
    }

    public function preview($id)
    {  
        $this->view['customer_detail'] = $this->CModel
        ->select('customer.*,p.party_name,p.business_address,p.city pcity,p.postcode ppost,ps.state_name ps_state,s.state_name, a.number adhar_no,pn.number pan_no,g.number gst_no,m.number msme_no,t.number tan_no,c.number cin_no')
        ->join('party p','p.id = customer.party_id')
        ->join('states ps','ps.state_id = p.state_id','left')
        ->join('party_type pt','pt.id = customer.party_type_id')
        ->join('states s','s.state_id = customer.state_id','left')
        ->join('party_documents a','p.id = a.party_id and a.flag_id = 1','left')
        ->join('party_documents pn','p.id = pn.party_id and pn.flag_id = 2','left')
        ->join('party_documents g','p.id = g.party_id and g.flag_id = 3','left')
        ->join('party_documents m','p.id = m.party_id and m.flag_id = 5','left')
        ->join('party_documents t','p.id = t.party_id and t.flag_id = 6','left')
        ->join('party_documents c','p.id = c.party_id and c.flag_id = 7','left')
        ->where('customer.id', $id)
        ->first();        
        
        $party_type_ids = isset($this->view['customer_detail']['party_type_id']) && ($this->view['customer_detail']['party_type_id']) ? explode(',',$this->view['customer_detail']['party_type_id']) : [];
        $this->view['party_types'] = ($party_type_ids) ? $this->PTModel->select('group_concat(UCASE(LEFT(name, 1)),SUBSTRING(LCASE(name), 2)) pt')->whereIn('id',$party_type_ids)->first() : '';
         
        $this->view['customer_branches'] = $this->CBModel->select('customer_branches.*, customer.phone, party.party_name')
        ->join('customer', 'customer.id = customer_branches.customer_id')
        ->join('party', 'party.id = customer.party_id')
        ->where('party.created_by!=', '')
        ->where('customer.id',$id)
        ->orderBy('party.party_name', 'asc')
        ->findAll();

        // echo '<pre>';print_r( $this->view['customer_branches']); 

        if($this->view['customer_branches']){
            foreach($this->view['customer_branches'] as $key => $val){
                $this->view['customer_branches'][$key]['branch_persons'] = $this->CBPModel->where('branch_id', $val['id'])->findAll();
                $this->view['customer_branches'][$key]['reg_address'] = $this->BAModel
                ->select('branch_address.*,s.state_name')
                ->join('states s','s.state_id = branch_address.state','left')
                ->where('branch_id', $id)->orderBy('id', 'desc')->findAll();
            }
        }
        // echo '<pre>';print_r( $this->view['customer_branches']);exit;

        return view('Customers/preview', $this->view);
    }
}
