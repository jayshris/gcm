<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BranchAddressModel;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\UserModel;
use App\Models\PartyModel;
use App\Models\PartytypeModel;
use App\Models\StateModel;
use App\Models\FlagsModel;
use App\Models\BusinessTypeModel;
use App\Models\BusinessTypeFlagModel;
use App\Models\CustomerBranchModel;
use App\Models\CustomerBranchPersonModel;
use App\Models\CustomersModel;
use App\Models\KycLinksModel;
use App\Models\OfficeMasterModel;
use App\Models\PartyDocumentsModel;
use App\Models\PartyTypePartyModel;

class Kyc extends BaseController
{
    public $_access;
    public $session;
    public $KLModel;
    public $BAModel;
    public $officeModel;

    public function __construct()
    {
        $u = new UserModel();
        $access = $u->setPermission();
        $this->_access = $access;

        $this->session = \Config\Services::session();

        $this->KLModel = new KycLinksModel();
        $this->BAModel = new BranchAddressModel();
        $this->officeModel = new OfficeMasterModel();
    }

    public function index()
    {
        $partyModel = new PartyModel();
        $this->view['party_data'] = $partyModel->select('party.*')->join('customer', 'customer.party_id = party.id')->where('party.created_by', '')->orderBy('id', 'DESC')->findAll();
        $this->view['pagination_link'] = $partyModel->pager;
        $this->view['page_data'] = [
            'page_title' => view('partials/page-title', ['title' => 'Party', 'li_1' => '123', 'li_2' => 'deals'])
        ];
        return view('KYC/index', $this->view);
    }

    public function create()
    {
        $this->view['gen_links'] = $this->KLModel->select('kyc_links.*, users.first_name, users.last_name')
            ->join('users', 'users.id = kyc_links.gen_by')
            ->orderBy('kyc_links.id', 'desc')->findAll(50);

        return view('KYC/kyc_link_gen', $this->view);
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

        echo  base_url('kyc/register/' . $token);
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

                $partytype = new PartytypeModel();
                $this->view['partytype'] = $partytype->where('status', 'Active')->orderby('name', 'ASC')->findAll();

                $partyModel = new PartyModel();
                $partyDocModel = new PartyDocumentsModel();
                $CModel = new CustomersModel();
                $CBModel = new CustomerBranchModel();
                $CBPModel = new CustomerBranchPersonModel();

                $stateModel = new StateModel();
                $this->view['state'] = $stateModel->where(['isStatus' => '1'])->orderBy('state_name', 'ASC')->findAll();

                $businesstypeModel = new BusinessTypeModel();
                $this->view['businesstype'] = $businesstypeModel->orderBy('company_structure_name', 'ASC')->findAll();

                $this->view['offices'] = $this->officeModel->select('name')->where('status', 1)->orderBy('name', 'ASC')->findAll();

                $flagsmodel = new FlagsModel();
                $this->view['flags'] = $flagsmodel->where('status', 'Active')->orderBy('id')->findAll();
                $this->view['token'] = $token;

                if ($this->request->getPost()) {


                    // save party
                    $arr = [
                        'party_name' => $this->request->getVar('party_name'),
                        'contact_person' => $this->request->getVar('contact_person'),
                        'alias' => $this->request->getVar('alias'),
                        'business_address' => $this->request->getVar('business_address'),
                        'city'   =>  $this->request->getVar('business_city'),
                        'state_id'   =>  $this->request->getVar('business_state'),
                        'postcode'   =>  $this->request->getVar('business_postcode'),
                        'primary_phone'   =>  $this->request->getVar('business_primary_phone'),
                        'email'   =>  $this->request->getVar('business_email'),
                        'business_type_id'   =>  $this->request->getVar('business_type_id'),
                        'created_at'  =>  date("Y-m-d h:i:sa"),
                    ];
                    $partyModel->save($arr);

                    $party_id = $partyModel->getInsertID();

                    // save party documents
                    $flags = ($this->request->getVar('flag_id')) ? $this->request->getVar('flag_id') : [];
                    if (!empty($flags)) {
                        foreach ($flags as $flag) {

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
                            $partyDocModel->save($docarr);
                        }
                    }

                    // add customer
                    $CModel->save([
                        'party_id' => $party_id,
                        'address' => $this->request->getPost('business_address'),
                        'city' => $this->request->getPost('business_city'),
                        'state_id' => $this->request->getPost('business_state'),
                        'postcode' => $this->request->getPost('business_postcode'),
                        'phone' => $this->request->getPost('business_primary_phone')
                    ]);

                    $customer_id = $CModel->getInsertID();

                    // add customer branch
                    $CBModel->save([
                        'customer_id' => $customer_id,
                        'office_name' => $this->request->getPost('office_name'),
                        'gst' => $this->request->getPost('office_gst'),
                        'address' => $this->request->getPost('office_address'),
                        'city' => $this->request->getPost('office_city'),
                        'state_id' => $this->request->getPost('office_state_id'),
                        'pincode' => $this->request->getPost('office_postcode')
                    ]);
                    $branch_id = $CBModel->getInsertID();

                    //save branch address if found
                    if ($this->request->getPost('office_address') != '') {

                        $this->BAModel->save([
                            'branch_id' => $branch_id,
                            'address' => $this->request->getPost('office_address'),
                            'city' => $this->request->getPost('office_city'),
                            'state' => $this->request->getPost('office_state_id'),
                            'zip' => $this->request->getPost('office_postcode'),
                            'effective_from' => $this->request->getPost('effective_from'),
                        ]);
                    }


                    // add customer branch person
                    $arr = [
                        'branch_id' => $branch_id,
                        'name' => $this->request->getPost('office_person'),
                        'designation' => $this->request->getPost('office_designation'),
                        'phone' => $this->request->getPost('office_phone'),
                        'email' => $this->request->getPost('office_email')
                    ];
                    $CBPModel->save($arr);

                    // echo '<pre>';
                    // print_r($this->request->getPost());
                    // die;

                    // discard link
                    $this->KLModel->set('link_used', '1')->where('token', $token)->update();

                    $this->session->setFlashdata('error', 'Thank You for submitting your KYC');
                    return $this->response->redirect(base_url('kyc/thanks'));
                }

                return view('KYC/kyc_form', $this->view);
            }
        } else {
            $this->session->setFlashdata('error', 'Invalid KYC Link, Please Contact The Administrator');
            return $this->response->redirect(base_url('kyc/thanks'));
        }
    }

    public function get_flags_fields()
    {
        if (isset($_POST['business_type'])) {

            $BTFModel = new BusinessTypeFlagModel();

            $flagData = $BTFModel->select('business_type_flags.*, flags.title,')
                ->join('flags', 'flags.id = business_type_flags.flags_id')
                ->where('business_type_flags.business_type_id', $this->request->getPost('business_type'))
                ->findAll();


            foreach ($flagData as $flag) {

                echo '<div class="col-md-6">
                  <div class="form-wrap">
                    <label class="col-form-label" >' . $flag['title'] . ' ' . ($flag['mandatory'] ? '<span class="text-danger">*</span>' : '') . '<span class="text-danger" id="span_' . $flag['flags_id'] . '"></span></label>
                    <input type="text" ' . ($flag['mandatory'] ? 'required' : '') . ' name="number_' . $flag['flags_id'] . '" id="num_' . $flag['flags_id'] . '" onchange="$.validate(' . $flag['flags_id'] . ');" class="form-control">
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-wrap">
                    <label class="col-form-label">' . $flag['title'] . ' Image 1 </label>
                    <input type="file" name="img_' . $flag['flags_id'] . '_1" class="form-control" accept="image/png, image/gif, image/jpeg" >
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-wrap">
                    <label class="col-form-label">' . $flag['title'] . '  Image 2</label>
                    <input type="file" name="img_' . $flag['flags_id'] . '_2" class="form-control" accept="image/png, image/gif, image/jpeg" >
                  </div>
                </div>

                <input type="hidden" name="flag_id[]" value="' . $flag['flags_id'] . '">
                ';
            }
        }
    }

    public function get_flags_fields_cond()
    {
        if (isset($_POST['business_type'])) {

            $BTFModel = new BusinessTypeFlagModel();

            $flagData = $BTFModel->select('business_type_flags.*, flags.title,')
                ->join('flags', 'flags.id = business_type_flags.flags_id')
                ->where('business_type_flags.business_type_id', $this->request->getPost('business_type'))
                ->findAll();


            foreach ($flagData as $flag) {

                echo '<div class="col-md-6">
                  <div class="form-wrap">
                    <label class="col-form-label" >' . $flag['title'] . ' ' . ($flag['mandatory'] ? '<span class="text-danger">*</span>' : '') . '<span class="text-danger" id="span_' . $flag['flags_id'] . '"></span></label>
                    <input type="text" ' . ($flag['mandatory'] ? 'required' : '') . ' name="number_' . $flag['flags_id'] . '" id="num_' . $flag['flags_id'] . '" onchange="$.validate(' . $flag['flags_id'] . ');" class="form-control">
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-wrap">
                    <label class="col-form-label">' . $flag['title'] . ' Image 1 ' . ($flag['mandatory'] ? '<span class="text-danger">*</span>' : '') . '</label>
                    <input type="file" ' . ($flag['mandatory'] ? 'required' : '') . ' name="img_' . $flag['flags_id'] . '_1" class="form-control" accept="image/png, image/gif, image/jpeg" >
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-wrap">
                    <label class="col-form-label">' . $flag['title'] . '  Image 2</label>
                    <input type="file" name="img_' . $flag['flags_id'] . '_2" class="form-control" accept="image/png, image/gif, image/jpeg" >
                  </div>
                </div>

                <input type="hidden" name="flag_id[]" value="' . $flag['flags_id'] . '">
                ';
            }
        }
    }

    public function validate_doc()
    {
        $partyDocModel = new PartyDocumentsModel();

        $row = $partyDocModel->where('flag_id', $this->request->getPost('flag_id'))->where('number', $this->request->getPost('number'))->first();

        echo  $row ? '1' : '0';
    }

    public function thanks()
    {
        return view('KYC/thanks');
    }

    public function approve($id = 0)
    {
        $access = $this->_access;
        if ($access === 'false') {
            $session = \Config\Services::session();
            $session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(site_url('/dashboard'));
        } else {
            $pcModel = new PartyModel();
            $partytype = new PartytypeModel();
            $partyTypes = new PartyTypePartyModel();
            $stateModel = new StateModel();
            $businesstypeModel = new BusinessTypeModel();
            $PartyDocModel = new PartyDocumentsModel();
            $CustomerModel = new CustomersModel();
            $CustomerBranchModel = new CustomerBranchModel();
            $CustomerBranchPersonModel = new CustomerBranchPersonModel();

            $this->view['partytype'] = $partytype->orderby('name', 'ASC')->where('status', 'Active')->findAll();
            $this->view['partyTypes'] = $partyTypes->where('party_id', $id)->findAll();
            $this->view['state'] = $stateModel->where(['isStatus' => '1'])->orderBy('state_id')->findAll();
            $this->view['businesstype'] = $businesstypeModel->orderBy('id')->findAll();

            $this->view['pc_data'] = $pcModel->where('id', $id)->first();

            $this->view['customer_details'] = $CustomerModel->select('customer_branches.*,customer_branch_persons.name, customer_branch_persons.designation, customer_branch_persons.phone, customer_branch_persons.email')
                ->join('customer_branches', 'customer_branches.customer_id = customer.id')
                ->join('customer_branch_persons', 'customer_branch_persons.branch_id = customer_branches.id')
                ->where('party_id', $id)->first();

            $customerID = isset($this->view['customer_details']['id']) ? $this->view['customer_details']['id'] : 0;
            $this->view['reg_address_office'] = $this->BAModel->where('branch_id', $customerID)->orderBy('id', 'desc')->first();

            $this->view['partyDocs'] = $PartyDocModel->select('party_documents.*, flags.title, business_type_flags.mandatory')
                ->join('flags', 'flags.id = party_documents.flag_id')
                ->join('business_type_flags', 'business_type_flags.flags_id = flags.id')
                ->where('party_id', $id)
                ->where('business_type_flags.business_type_id', $this->view['pc_data']['business_type_id'])
                ->groupBy('party_documents.flag_id')
                ->findAll();

            if ($this->request->getPost()) {
                // update party details
                $pcModel->update($id, [
                    'party_name'      =>  $this->request->getVar('party_name'),
                    'contact_person'   =>  $this->request->getVar('contact_person'),
                    'alias' => $this->request->getVar('alias'),
                    'business_address'   =>  $this->request->getVar('business_address'),
                    'city'   =>  $this->request->getVar('business_city'),
                    'state_id'   =>  $this->request->getVar('business_state'),
                    'postcode'   =>  $this->request->getVar('business_postcode'),
                    'primary_phone'   =>  $this->request->getVar('business_primary_phone'),
                    'email'   =>  $this->request->getVar('business_email'),
                    'business_type_id'   =>  $this->request->getVar('business_type_id'),
                    'created_by'  => $this->request->getVar('approve') == '1' ? (isset($_SESSION['id']) ? $_SESSION['id'] : '0') : '',
                    'created_at'  =>  date("Y-m-d h:i:sa"),
                    'updated_at'  =>  date("Y-m-d h:i:sa"),
                    'status'                  =>  $this->request->getVar('approve'),
                    'approved'                =>  $this->request->getVar('approve'),
                    'approval_user_id'        =>  isset($_SESSION['id']) ? $_SESSION['id'] : '0',
                    'approval_user_type'      =>  isset($user['usertype']) ? $user['usertype'] : '',
                    'approval_date'           =>  date("Y-m-d h:i:sa"),
                    'approval_ip_address'     =>  $_SERVER['REMOTE_ADDR'],
                ]);

                // save party documents
                $flags = ($this->request->getVar('flag_id')) ? $this->request->getVar('flag_id') : [];
                if (!empty($flags)) {
                    foreach ($flags as $flag) {

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
                            $img1 = $PartyDocModel->where(['party_id' => $id, 'flag_id' => $flag])->first()['img1'];
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
                            $img2 = $PartyDocModel->where(['party_id' => $id, 'flag_id' => $flag])->first()['img2'];
                        }

                        $PartyDocModel->where('party_id', $id)->where('flag_id', $flag)->delete();

                        $docarr = [
                            'party_id' => $id,
                            'flag_id' => $flag,
                            'number' => $this->request->getVar('number_' . $flag),
                            'img1' => $img1,
                            'img2' => $img2
                        ];
                        $PartyDocModel->save($docarr);
                    }
                }

                // update customer details
                $CustomerModel->where('party_id', $id)->set([
                    'party_type_id' => implode(',', $this->request->getPost('party_type')),
                    'party_id' => $id,
                    'address' => $this->request->getPost('business_address'),
                    'city' => $this->request->getPost('business_city'),
                    'state_id' => $this->request->getPost('business_state'),
                    'postcode' => $this->request->getPost('business_postcode'),
                    'phone' => $this->request->getPost('business_primary_phone'),
                    'status' => $this->request->getPost('approve'),
                    'modify_date' => date('Y-m-d h:i:s'),
                    'added_by' => isset($_SESSION['id']) ? $_SESSION['id'] : '0',
                    'added_ip' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '',
                    'modify_by' => isset($_SESSION['id']) ? $_SESSION['id'] : '0',
                    'modify_ip' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '',
                ])->update();

                $customerInfo = $CustomerModel->where('party_id', $id)->first();
                $customer_id = isset($customerInfo['id']) ? $customerInfo['id'] : 0;

                //update customer branch
                $CustomerBranchModel->where('customer_id', $customer_id)->set([
                    'office_name' => $this->request->getPost('office_name'),
                    'gst' => $this->request->getPost('office_gst'),
                    'status' => $this->request->getPost('approve'),
                    'added_by' => isset($_SESSION['id']) ? $_SESSION['id'] : '0',
                    'added_ip' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '',
                    'modify_by' => isset($_SESSION['id']) ? $_SESSION['id'] : '0',
                    'modify_ip' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '',
                    'modify_date' => date('Y-m-d h:i:s')
                ])->update();

                $customerBranchInfo = $CustomerBranchModel->where('customer_id', $customer_id)->first();
                $customer_branch_id = isset($customerBranchInfo['id']) ? $customerBranchInfo['id'] : 0;

                //========================================
                if ($this->request->getPost('office_address_id') != '') {

                    $this->BAModel->update($this->request->getPost('office_address_id'), [
                        'address' => $this->request->getPost('office_address'),
                        'city' => $this->request->getPost('office_city'),
                        'state' => $this->request->getPost('office_state_id'),
                        'country' => $this->request->getPost('country'),
                        'zip' => $this->request->getPost('office_postcode'),
                        'effective_from' => $this->request->getPost('effective_from'),
                        'created_by' => isset($_SESSION['id']) ? $_SESSION['id'] : '0'
                    ]);
                }

                $CustomerBranchPersonModel->where('branch_id', $customer_branch_id)->delete();

                $CustomerBranchPersonModel->save([
                    'branch_id' => $customer_branch_id,
                    'name' => $this->request->getPost('office_person'),
                    'designation' => $this->request->getPost('office_designation'),
                    'phone' => $this->request->getPost('office_phone'),
                    'email' => $this->request->getPost('office_email')
                ]);

                $this->session->setFlashdata('success', 'KYC Status Updated');
                return $this->response->redirect(base_url('kyc'));
                // echo '<pre>';
                // print_r($this->request->getPost());
                // die;
            }

            return view('KYC/approval', $this->view);
        }
    }
}
