<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PartyModel;
use App\Models\UserModel;
use App\Models\VehicleCertificatesModel;
use App\Models\VehicleCertificateModel;
use App\Models\VehicleModel;
use CodeIgniter\HTTP\ResponseInterface;

class Vehiclecertificates extends BaseController
{
    public $access;
    public $session;
    public $added_by;
    public $added_ip;

    public $VCModel;
    public $VModel;
    public $DTModel;
    public $PModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();

        $user = new UserModel();
        $this->access = $user->setPermission();

        $this->added_by = isset($_SESSION['id']) ? $_SESSION['id'] : '0';
        $this->added_ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';

        $this->VCModel = new VehicleCertificatesModel();
        $this->VModel = new VehicleModel();
        $this->DTModel = new VehicleCertificateModel();
        $this->PModel = new PartyModel();
    }

    public function index()
    {
        if ($this->access === 'false') {
            $this->session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(base_url('/dashboard'));
        } else {

            $this->VCModel->select('vehiclewise_certificates.*, vehicle.rc_number, vehicle_certificates.name, party.party_name');
            $this->VCModel->join('vehicle', 'vehicle.id = vehiclewise_certificates.vehicle_id');
            $this->VCModel->join('vehicle_certificates', 'vehicle_certificates.id = vehiclewise_certificates.certificate_id');
            $this->VCModel->join('party', 'party.id = vehiclewise_certificates.party_id', 'left');

            if ($this->request->getPost('vehicle_id') != '') {
                $this->VCModel->where('vehiclewise_certificates.vehicle_id', $this->request->getPost('vehicle_id'));
            }
            if ($this->request->getPost('certificate_id') != '') {
                $this->VCModel->where('vehiclewise_certificates.certificate_id', $this->request->getPost('certificate_id'));
            }
            if ($this->request->getPost('party_id') != '') {
                $this->VCModel->where('vehiclewise_certificates.party_id', $this->request->getPost('party_id'));
            }
            $this->view['certificates'] = $this->VCModel->findAll();

            $this->view['party'] = $this->PModel->where('status', '1')->findAll();
            $this->view['vehicles'] = $this->VModel->findAll();
            $this->view['cert_type'] = $this->DTModel->findAll();

            return view('VehicleCertificates/index', $this->view);
        }
    }

    public function create()
    {

        if ($this->access === 'false') {
            $this->session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(base_url('dashboard'));
        } else if ($this->request->getPost()) { 

            $image1 = '';
            if ($this->request->getFile('image1') != null) {

                $image = $this->request->getFile('image1');
                if ($image->isValid() && !$image->hasMoved()) {
                    $newName = $image->getRandomName();
                    $imgpath = 'public/uploads/vehicle_certificates';
                    if (!is_dir($imgpath)) {
                        mkdir($imgpath, 0777, true);
                    }
                    $image->move($imgpath, $newName);
                }
                $image1 = $newName;
            }

            $image2 = '';
            if ($this->request->getFile('image2') != null) {

                $image = $this->request->getFile('image2');
                if ($image->isValid() && !$image->hasMoved()) {
                    $newName = $image->getRandomName();
                    $imgpath = 'public/uploads/vehicle_certificates';
                    if (!is_dir($imgpath)) {
                        mkdir($imgpath, 0777, true);
                    }
                    $image->move($imgpath, $newName);
                }
                $image2 = $newName;
            }

             // save multiple certificates
            //  foreach ($this->request->getPost('expense') as $key => $val) {
            //     $expense_data = [
            //         'booking_id' => $id,
            //         'expense' => $this->request->getPost('expense')[$key],
            //         'value' => $this->request->getPost('expense_value')[$key],
            //         'bill_to_party' => ($this->request->getPost('expense_flag_' . $key +1) == 'on') ? '1' : '0'
            //     ]; 
            //     $this->BEModel->insert($expense_data);
            // }    

            $this->VCModel->save([
                'vehicle_id' => $this->request->getVar('vehicle_id'),
                'certificate_id' => $this->request->getVar('certificate_id'),
                'party_id' => $this->request->getVar('party_id'),
                'certificate_no' => $this->request->getVar('doc_no'),
                'issue_date' => $this->request->getVar('issue_date'),
                'expiry_date' => $this->request->getVar('expiry_date'),
                'img1' => $image1,
                'img2' => $image2,
                'added_by' => $this->added_by,
                'added_ip' => $this->added_ip
            ]);
            $this->session->setFlashdata('success', 'Vehicle Certificate Successfully Added');

            return $this->response->redirect(base_url('vehiclecertificates'));
        } else {
            $this->view['party'] = $this->PModel->where('status', '1')->findAll();
            $this->view['vehicles'] = $this->VModel->findAll();
            $this->view['cert_type'] = $this->DTModel->findAll();

            return view('VehicleCertificates/create', $this->view);
        }
    }

    public function delete($id)
    {
        $this->VCModel->where('id', $id)->delete($id);

        $this->session->setFlashdata('danger', 'Certificate Deleted Successfully');

        return $this->response->redirect(base_url('VehicleCertificates'));
    }

    function addCertificate(){
        $this->view['party'] = $this->PModel->where('status', '1')->findAll();
        $this->view['vehicles'] = $this->VModel->findAll();
        $this->view['cert_type'] = $this->DTModel->findAll();
        $this->view['index'] = $this->request->getPost('index'); 
        echo view('VehicleCertificates/certificate_block', $this->view);
    }
}
