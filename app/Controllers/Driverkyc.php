<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BusinessTypeFlagModel;
use App\Models\DriverKycLinksModel;
use App\Models\DriverModel;
use App\Models\DriverSchemeMapModel;
use App\Models\DriverVehicleType;
use App\Models\ForemanModel;
use App\Models\PartyDocumentsModel;
use App\Models\PartyModel;
use App\Models\SchemesModel;
use App\Models\StateModel;
use App\Models\UserModel;
use App\Models\VehicleTypeModel;
use CodeIgniter\HTTP\ResponseInterface;

class Driverkyc extends BaseController
{
    public $_access;
    public $session;
    public $SModel;
    public $KLModel;
    public $FModel;
    public $VTModel;
    public $BTFModel;
    public $PModel;
    public $PDModel;
    public $DModel;
    public $VTDModule;
    public $SCModel;
    public $DSMModel;

    public function __construct()
    {
        $u = new UserModel();
        $access = $u->setPermission();
        $this->_access = $access;

        $this->session = \Config\Services::session();

        $this->SModel = new StateModel();
        $this->KLModel = new DriverKycLinksModel();
        $this->FModel = new ForemanModel();
        $this->VTModel = new VehicleTypeModel();
        $this->BTFModel = new BusinessTypeFlagModel();
        $this->PModel = new PartyModel();
        $this->PDModel = new PartyDocumentsModel();
        $this->DModel = new DriverModel();
        $this->VTDModule = new DriverVehicleType();
        $this->SCModel = new SchemesModel();
        $this->DSMModel = new DriverSchemeMapModel();
    }

    public function index()
    {
        $access = $this->_access;
        if ($access === 'false') {
            $session = \Config\Services::session();
            $session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(site_url('/dashboard'));
        } else {
            $this->view['party_data'] = $this->PModel
                ->join('driver', 'driver.party_id = party.id')
                ->where('party.created_by', '0')->orderBy('driver.id', 'DESC')->findAll();

            return view('Driverkyc/index', $this->view);
        }
    }

    public function create()
    {
        $this->view['gen_links'] = $this->KLModel->select('driver_kyc_links.*, users.first_name, users.last_name')
            ->join('users', 'users.id = driver_kyc_links.gen_by')
            ->orderBy('driver_kyc_links.id', 'desc')->findAll(50);

        return view('Driverkyc/kyc_link_gen', $this->view);
    }

    public function getLink()
    {
        $token = md5(date('YMDHis'));

        $this->view = [
            'token' => $token,
            'gen_for' => $this->request->getPost('gen_for'),
            'gen_by' => isset($_SESSION['id']) ? $_SESSION['id'] : '0',
            'gen_ip' => isset($_SERVER['REMOTE_ADDR'])  ? $_SERVER['REMOTE_ADDR'] : '',
        ];
        $this->KLModel->save($this->view);

        echo base_url('Driverkyc/register/' . $token);
    }

    public function register($token)
    {
        // validate token and validity
        $link_data = $this->KLModel->where('token', $token)->first();


        if ($link_data) {

            $dateProvided = $link_data['gen_date'];
            $dateProvidedTimestamp = strtotime($dateProvided) + (24 * 60 * 60);

            $currentDateTimestamp = time();

            if ($link_data['link_used'] != 0) {
                $this->session->setFlashdata('error', 'Your Kyc is already submitted,  Please Contact The Administrator');
                return $this->response->redirect(base_url('kyc/thanks'));
            } else if ($dateProvidedTimestamp < $currentDateTimestamp) {
                $this->session->setFlashdata('error', 'This Link Has Expired,  Please Contact The Administrator');
                return $this->response->redirect(base_url('kyc/thanks'));
            } else {

                $this->view['foreman'] = $this->FModel->select('foreman.*,party.party_name')
                    ->join('party', 'party.id = foreman.party_id')
                    ->findAll();
                $this->view['vehicletypes'] = $this->VTModel->where('status', 'Active')->findAll();

                $this->view['flagData'] = $this->BTFModel->select('business_type_flags.*, flags.title,')
                    ->join('flags', 'flags.id = business_type_flags.flags_id')
                    ->where('business_type_flags.business_type_id', '2')
                    ->findAll();

                $this->view['state'] = $this->SModel->where(['isStatus' => '1'])->orderBy('state_name', 'ASC')->findAll();
                $this->view['schemes'] = $this->SCModel->orderBy('id', 'ASC')->findAll();

                $this->view['token'] = $token;

                if ($this->request->getPost()) {

                    // save party
                    $arr = [
                        'party_name' => $this->request->getVar('driver_name'),
                        'business_address' => $this->request->getVar('address_p'),
                        'city'   =>  $this->request->getVar('city_p'),
                        'state_id'   =>  $this->request->getVar('state_p'),
                        'postcode'   =>  $this->request->getVar('zip_p'),
                        'primary_phone'   =>  $this->request->getVar('whatsapp'),
                        'other_phone'   =>  $this->request->getVar('mobile'),
                        'business_type_id'   =>  '2',
                        'created_at'  =>  date("Y-m-d h:i:sa")
                    ];
                    $this->PModel->save($arr);

                    $party_id = $this->PModel->getInsertID();

                    // save party documents
                    foreach ($this->request->getVar('flag_id') as $flag) {

                        $img1 = '';
                        if ($_FILES['img_' . $flag . '_1']['name'] != '') {

                            $image = $this->request->getFile('img_' . $flag . '_1');
                            if ($image->isValid() && !$image->hasMoved()) {
                                $newName1 = $image->getRandomName();
                                $imgpath = 'public/uploads/partyDocs';
                                if (!is_dir($imgpath)) {
                                    mkdir($imgpath, 0777, true);
                                }
                                $image->move($imgpath, $newName1);
                            }
                            $img1 = $newName1;
                        }

                        $img2 = '';
                        if ($_FILES['img_' . $flag . '_2']['name'] != '') {

                            $image = $this->request->getFile('img_' . $flag . '_2');
                            if ($image->isValid() && !$image->hasMoved()) {
                                $newName2 = $image->getRandomName();
                                $imgpath = 'public/uploads/partyDocs';
                                if (!is_dir($imgpath)) {
                                    mkdir($imgpath, 0777, true);
                                }
                                $image->move($imgpath, $newName2);
                            }
                            $img2 = $newName2;
                        }

                        $docarr = [
                            'party_id' => $party_id,
                            'flag_id' => $flag,
                            'number' => $this->request->getVar('number_' . $flag),
                            'img1' => $img1,
                            'img2' => $img2
                        ];
                        $this->PDModel->save($docarr);
                    }


                    // add Driver documents
                    $newName1 = '';
                    $image1 = $this->request->getFile('profile_image1');
                    if ($image1->isValid() && !$image1->hasMoved()) {
                        $newName1 = $image1->getRandomName();
                        $imgpath1 = 'public/uploads/driverDocs';
                        if (!is_dir($imgpath1)) {
                            mkdir($imgpath1, 0777, true);
                        }
                        $image1->move($imgpath1, $newName1);
                    }
                    $image_name1 = $newName1;


                    $newName3 = '';
                    $image3 = $this->request->getFile('dl_image_front');
                    if ($image3->isValid() && !$image3->hasMoved()) {
                        $newName3 =  $image3->getRandomName();

                        $imgpath3 = 'public/uploads/driverDocs';
                        if (!is_dir($imgpath3)) {
                            mkdir($imgpath3, 0777, true);
                        }
                        $image3->move($imgpath3, $newName3);
                    }
                    $image_name3 =  $newName3;


                    $newName4 = '';
                    $image4 = $this->request->getFile('dl_image_back');
                    if ($image4->isValid() && !$image4->hasMoved()) {
                        $newName4 =  $image4->getRandomName();
                        $imgpath4 = 'public/uploads/driverDocs';
                        if (!is_dir($imgpath4)) {
                            mkdir($imgpath4, 0777, true);
                        }
                        $image4->move($imgpath4, $newName4);
                    }
                    $image_name4 = $newName4;


                    $newName5 = '';
                    $image5 = $this->request->getFile('upi_id');
                    if ($image5->isValid() && !$image5->hasMoved()) {
                        $newName5 =  $image5->getRandomName();
                        $imgpath5 = 'public/uploads/driverDocs';
                        if (!is_dir($imgpath5)) {
                            mkdir($imgpath5, 0777, true);
                        }
                        $image5->move($imgpath5, $newName5);
                    }
                    $image_name5 = $newName5;


                    $this->DModel->save([
                        'party_id'  =>  $party_id,
                        'foreman_id'  =>  $this->request->getVar('foreman_id'),
                        'driver_type'  =>   $this->request->getPost('driver_type'),
                        'bank_ac' => $this->request->getPost('bank_account_number'),
                        'bank_ifsc' => $this->request->getPost('bank_ifsc_code'),
                        'whatsapp_no' => $this->request->getPost('whatsapp'),
                        'dl_no' => $this->request->getPost('dl_no'),
                        'dl_authority' => $this->request->getPost('dl_authority'),
                        'dl_dob' => $this->request->getPost('dl_dob'),
                        'dl_expiry' => $this->request->getPost('dl_expiry'),
                        'dl_image_front' => $image_name3,
                        'dl_image_back' => $image_name4,
                        'upi_text' => $this->request->getPost('upi'),
                        'upi_id'    =>  $image_name5,
                        'profile_image1'  =>  $image_name1,
                        'address'  =>   $this->request->getPost('address'),
                        'city'  =>   $this->request->getPost('city'),
                        'state'  =>  $this->request->getPost('state'),
                        'zip'  =>  $this->request->getPost('zip'),
                        'emergency_person' =>  $this->request->getPost('emergency_person'),
                        'emergency_relation' =>  $this->request->getPost('emergency_relation'),
                        'emergency_contact' =>  $this->request->getPost('emergency_contact'),
                        'working_status'  =>  '1',
                        'created_at'  =>  date("Y-m-d h:i:sa")
                    ]);

                    $driver_id = $this->DModel->getInsertID();

                    $vehicle = $this->request->getVar('vehicle_types');
                    foreach ($vehicle as $key => $value) {
                        $vehicledata = [
                            'vehicle_type_id' =>  $value,
                            'driver_id'       =>  $driver_id,
                        ];
                        $this->VTDModule->save($vehicledata);
                    }


                    // add scheme
                    $this->DSMModel->insert([
                        'driver_id' => $driver_id,
                        'scheme_id' => $this->request->getPost('scheme_id'),
                        'added_date' => date("Y-m-d h:i:sa")
                    ]);

                    // echo '<pre>';
                    // print_r($arr);
                    // print_r($docarr);
                    // print_r($this->request->getPost());
                    // die;

                    // discard link
                    $this->KLModel->set('link_used', '1')->where('token', $token)->update();

                    $this->session->setFlashdata('error', 'Thank You for submitting your KYC');
                    return $this->response->redirect(base_url('driverkyc/thanks/' . $driver_id));
                }

                return view('Driverkyc/kyc_form', $this->view);
            }
        } else {
            $this->session->setFlashdata('error', 'Invalid KYC Link, Please Contact The Administrator');
            return $this->response->redirect(base_url('driverkyc/thanks'));
        }
    }

    public function validate_doc()
    {
        $row = $this->PDModel->where('flag_id', $this->request->getPost('flag_id'))->where('number', $this->request->getPost('number'))->first();

        echo  $row ? '1' : '0';
    }

    public function thanks($driver_id = 0)
    {

        $data['details'] =  $this->DModel->select('driver.*, t2.party_name, t3.mobile as foreman_mobile, t4.party_name as foreman_name')
            ->join('party' . ' t2', 't2.id = driver.party_id')
            ->join('foreman' . ' t3', 't3.id = driver.foreman_id')
            ->join('party' . ' t4', 't4.id = t3.party_id')
            ->where('driver.id', $driver_id)->first();

        $data['vehicle_type'] = $this->VTDModule->select('name')
            ->join('vehicle_type', 'vehicle_type.id = driver_vehicle_type_map.vehicle_type_id')
            ->where('driver_id', $driver_id)->first();

        $data['scheme'] = $this->DSMModel
            ->join('schemes' . ' t2', 't2.id = driver_scheme_map.scheme_id')
            ->where('driver_scheme_map.driver_id', $driver_id)->first();

        return view('Driverkyc/thanks', $data);
    }

    public function approve($id)
    {
        $access = $this->_access;
        if ($access === 'false') {
            $session = \Config\Services::session();
            $session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(site_url('/dashboard'));
        } else {

            $this->view['foreman'] = $this->FModel->select('foreman.*,party.party_name')
                ->join('party', 'party.id = foreman.party_id')
                ->findAll();

            $this->view['vehicletypes'] = $this->VTModel->where('status', 'Active')->findAll();
            $this->view['vehicletypesdriver'] = $this->VTDModule->where('driver_id', $id)->findAll();

            $this->view['flagData'] = $this->BTFModel->select('business_type_flags.*, flags.title,')
                ->join('flags', 'flags.id = business_type_flags.flags_id')
                ->where('business_type_flags.business_type_id', '2')
                ->findAll();

            $this->view['state'] = $this->SModel->where(['isStatus' => '1'])->orderBy('state_name', 'ASC')->findAll();
            $this->view['schemes'] = $this->SCModel->orderBy('id', 'ASC')->findAll();

            $this->view['driver_data'] = $this->DModel->where('id', $id)->first();
            $this->view['driver_scheme'] = $this->DSMModel->where('driver_id', $id)->first();
            $this->view['party_data'] = $this->PModel->where('id', $this->view['driver_data']['party_id'])->first();

            $this->view['party_docs'] = $this->PDModel->select('party_documents.*, flags.title, business_type_flags.mandatory,business_type_flags.flags_id')
                ->join('flags', 'flags.id = party_documents.flag_id')
                ->join('business_type_flags', 'business_type_flags.flags_id = flags.id')
                ->where('party_id', $this->view['party_data']['id'])
                ->where('business_type_flags.business_type_id', $this->view['party_data']['business_type_id'])
                ->groupBy('party_documents.flag_id')
                ->findAll(); //echo '<pre>'.$PartyDocModel->getLastQuery();die;


            if ($this->request->getPost()) {

                // update party details
                $arr = [
                    'party_name' => $this->request->getVar('driver_name'),
                    'business_address' => $this->request->getVar('address_p'),
                    'city'   =>  $this->request->getVar('city_p'),
                    'state_id'   =>  $this->request->getVar('state_p'),
                    'postcode'   =>  $this->request->getVar('zip_p'),
                    'primary_phone'   =>  $this->request->getVar('whatsapp'),
                    'other_phone'   =>  $this->request->getVar('mobile'),
                    'business_type_id'   =>  '2',
                    'created_by'  => isset($_SESSION['id']) ? $_SESSION['id'] : '0',
                    'updated_at'  =>  date("Y-m-d h:i:sa"),
                    'status'                  =>  '1',
                    'approved'                =>  '1',
                    'approval_user_id'        =>  isset($_SESSION['id']) ? $_SESSION['id'] : '0',
                    'approval_user_type'      =>  isset($_SESSION['usertype']) ? $_SESSION['usertype'] : '',
                    'approval_date'           =>  date("Y-m-d h:i:sa"),
                    'approval_ip_address'     =>  $_SERVER['REMOTE_ADDR'],
                ];
                $this->PModel->update($this->view['driver_data']['party_id'], $arr);

                // save party documents
                foreach ($this->request->getVar('flag_id') as $flag) {

                    $img1 = '';
                    if ($_FILES['img_' . $flag . '_1']['name'] != '') {

                        $image = $this->request->getFile('img_' . $flag . '_1');
                        if ($image->isValid() && !$image->hasMoved()) {
                            $newName1 = $image->getRandomName();
                            $imgpath = 'public/uploads/partyDocs';
                            if (!is_dir($imgpath)) {
                                mkdir($imgpath, 0777, true);
                            }
                            $image->move($imgpath, $newName1);
                        }
                        $img1 = $newName1;
                    } else {
                        $img1 = $this->PDModel->where(['party_id' => $this->view['driver_data']['party_id'], 'flag_id' => $flag])->first()['img1'];
                    }

                    $img2 = '';
                    if ($_FILES['img_' . $flag . '_2']['name'] != '') {

                        $image = $this->request->getFile('img_' . $flag . '_2');
                        if ($image->isValid() && !$image->hasMoved()) {
                            $newName2 = $image->getRandomName();
                            $imgpath = 'public/uploads/partyDocs';
                            if (!is_dir($imgpath)) {
                                mkdir($imgpath, 0777, true);
                            }
                            $image->move($imgpath, $newName2);
                        }
                        $img2 = $newName2;
                    } else {
                        $img2 = $this->PDModel->where(['party_id' => $this->view['driver_data']['party_id'], 'flag_id' => $flag])->first()['img2'];
                    }

                    $this->PDModel->where('party_id', $this->view['driver_data']['party_id'])->where('flag_id', $flag)->delete();

                    $docarr = [
                        'party_id' => $this->view['driver_data']['party_id'],
                        'flag_id' => $flag,
                        'number' => $this->request->getVar('number_' . $flag),
                        'img1' => $img1,
                        'img2' => $img2
                    ];
                    $this->PDModel->save($docarr);
                }



                $this->DModel->update($id, [
                    'name'  =>  $this->request->getVar('driver_name'),
                    'foreman_id'  =>  $this->request->getVar('foreman_id'),
                    'driver_type'  =>   $this->request->getPost('driver_type'),
                    'bank_ac' => $this->request->getPost('bank_account_number'),
                    'bank_ifsc' => $this->request->getPost('bank_ifsc_code'),
                    'whatsapp_no' => $this->request->getPost('whatsapp'),
                    'dl_no' => $this->request->getPost('dl_no'),
                    'dl_authority' => $this->request->getPost('dl_authority'),
                    'dl_dob' => $this->request->getPost('dl_dob'),
                    'dl_expiry' => $this->request->getPost('dl_expiry'),
                    'upi_text' => $this->request->getPost('upi'),
                    'address'  =>   $this->request->getPost('address'),
                    'city'  =>   $this->request->getPost('city'),
                    'state'  =>  $this->request->getPost('state'),
                    'zip'  =>  $this->request->getPost('zip'),
                    'emergency_person' =>  $this->request->getPost('emergency_person'),
                    'emergency_relation' =>  $this->request->getPost('emergency_relation'),
                    'emergency_contact' =>  $this->request->getPost('emergency_contact'),
                    'working_status' =>  '1',
                    'updated_at' =>  date("Y-m-d h:i:sa"),
                ]);

                // update image if uploaded

                // dl front
                if ($_FILES['dl_image_front']['name'] != '') {
                    $newName1 = '';
                    $image1 = $this->request->getFile('dl_image_front');
                    if ($image1->isValid() && !$image1->hasMoved()) {
                        $newName1 =  $image1->getRandomName();
                        $imgpath1 = 'public/uploads/driverDocs';
                        if (!is_dir($imgpath1)) {
                            mkdir($imgpath1, 0777, true);
                        }
                        $image1->move($imgpath1, $newName1);
                    }

                    $this->DModel->update($id, ['dl_image_front' => $newName1]);
                }

                if ($_FILES['dl_image_back']['name'] != '') {
                    $newName2 = '';
                    $image2 = $this->request->getFile('dl_image_back');
                    if ($image2->isValid() && !$image2->hasMoved()) {
                        $newName2 =  $image2->getRandomName();
                        $imgpath2 = 'public/uploads/driverDocs';
                        if (!is_dir($imgpath2)) {
                            mkdir($imgpath2, 0777, true);
                        }
                        $image2->move($imgpath2, $newName2);
                    }

                    $this->DModel->update($id, ['dl_image_back' => $newName2]);
                }


                if ($_FILES['upi_id']['name'] != '') {
                    $newName3 = '';
                    $image3 = $this->request->getFile('upi_id');
                    if ($image3->isValid() && !$image3->hasMoved()) {
                        $newName3 =  $image3->getRandomName();
                        $imgpath3 = 'public/uploads/driverDocs';
                        if (!is_dir($imgpath3)) {
                            mkdir($imgpath3, 0777, true);
                        }
                        $image3->move($imgpath3, $newName3);
                    }

                    $this->DModel->update($id, ['upi_id' => $newName3]);
                }

                if ($_FILES['profile_image1']['name'] != '') {
                    $newName4 = '';
                    $image4 = $this->request->getFile('profile_image1');
                    if ($image4->isValid() && !$image4->hasMoved()) {
                        $newName4 =  $image4->getRandomName();
                        $imgpath4 = 'public/uploads/driverDocs';
                        if (!is_dir($imgpath4)) {
                            mkdir($imgpath4, 0777, true);
                        }
                        $image4->move($imgpath4, $newName4);
                    }

                    $this->DModel->update($id, ['profile_image1' => $newName4]);
                }

                $this->VTDModule->where('driver_id', $id)->delete();

                $vehicle = $this->request->getVar('vehicle_types');
                foreach ($vehicle as $key => $value) {
                    $vehicledata = [
                        'vehicle_type_id' =>  $value,
                        'driver_id'       =>  $id,
                    ];
                    $this->VTDModule->save($vehicledata);
                }


                // add scheme
                $this->DSMModel->where('driver_id', $id)->where('removal_date', '')->set(['removal_date' => date('Y-m-d h:i:s')])->update();

                $this->DSMModel->insert([
                    'driver_id' => $id,
                    'scheme_id' => $this->request->getPost('scheme_id'),
                    'added_date' => date("Y-m-d h:i:s")
                ]);

                // echo '<pre>';
                // print_r($this->request->getPost());
                // die;

                $this->session->setFlashdata('success', 'KYC Status Updated');
                return $this->response->redirect(base_url('driverkyc'));
            }

            return view('Driverkyc/approval', $this->view);
        }
    }

    public function validate_dl()
    {
        $row = $this->DModel->where('dl_no', $this->request->getPost('dl_no'))->first();

        echo  $row ? '1' : '0';
    }
}
