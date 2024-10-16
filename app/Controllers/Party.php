<?php

namespace App\Controllers;

use App\Controllers\BaseController;
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
use App\Models\PartyDocumentsModel;
use App\Models\PartyTypePartyModel;

class Party extends BaseController
{
  public $_access;
  public $PModel;
  public $PDModel;

  public function __construct()
  {
    $u = new UserModel();
    $access = $u->setPermission();
    $this->_access = $access;

    $this->PModel = new PartyModel();
    $this->PDModel = new PartyDocumentsModel();
  }

  public function index()
  {
    $access = $this->_access;
    if ($access === 'false') {
      $session = \Config\Services::session();
      $session->setFlashdata('error', 'You are not permitted to access this page');
      return $this->response->redirect(base_url('/dashboard'));
    } else {
      $partyModel = new PartyModel();

      if ($this->request->getPost('party_id') != '') {
        $partyModel->where('id', $this->request->getPost('party_id'));
      }

      if ($this->request->getPost('status') != '') {
        $partyModel->where('status', $this->request->getPost('status'));
      } else {
        $partyModel->where('status', '1');
      }
      $this->view['party_data'] = $partyModel->where('created_by !=', '')->orderBy('party_name')->findAll();

      return view('Party/index', $this->view);
    }
  }

  public function create()
  {
    $access = $this->_access;
    if ($access === 'false') {
      $session = \Config\Services::session();
      $session->setFlashdata('error', 'You are not permitted to access this page');
      return $this->response->redirect(base_url('/dashboard'));
    } else {
      helper(['form', 'url']);
      $this->view['page_data'] = [
        'page_title' => view('partials/page-title', ['title' => 'Add Party', 'li_2' => 'profile'])
      ];
      $partytype = new PartytypeModel();
      $this->view['partytype'] = $partytype->orderby('name', 'ASC')->findAll();

      $stateModel = new StateModel();
      $this->view['state'] = $stateModel->where(['isStatus' => '1'])->orderBy('state_name', 'ASC')->findAll();

      $businesstypeModel = new BusinessTypeModel();
      $this->view['businesstype'] = $businesstypeModel->orderBy('company_structure_name', 'ASC')->findAll();

      $flagsmodel = new FlagsModel();
      $this->view['flags'] = $flagsmodel->where('status', 'Active')->orderBy('id')->findAll();

      $partyDocModel = new PartyDocumentsModel();


      if ($this->request->getMethod() == 'POST') {

        $error = $this->validate([
          'party_name'              =>  'required|trim|regex_match[/^[a-z\d\-_\s]+$/i]|is_unique[party.party_name]',
          'state'                   =>  'required',
          'city'                    =>  'required',
          'postcode'                =>  'required',
          'primary_phone'           =>  'required|numeric',
          'business_type_id'        =>  'required'
        ]);

        if (!$error) {
          $this->view['error']   = $this->validator;
        } else {
          $partyModel = new PartyModel();

          $arr = [
            'party_name'      =>  $this->request->getVar('party_name'),
            'contact_person'   =>  $this->request->getVar('contact_person'),
            'alias' => $this->request->getVar('alias'),
            'business_address'   =>  $this->request->getVar('business_address'),
            'city'   =>  $this->request->getVar('city'),
            'state_id'   =>  $this->request->getVar('state'),
            'postcode'   =>  $this->request->getVar('postcode'),
            'primary_phone'   =>  $this->request->getVar('primary_phone'),
            'other_phone'   =>  $this->request->getVar('other_phone'),
            'email'   =>  $this->request->getVar('email'),
            'business_type_id'   =>  $this->request->getVar('business_type_id'),
            'created_at'  =>  date("Y-m-d h:i:sa"),
            'created_by' => isset($_SESSION['id']) ? $_SESSION['id'] : '0'
          ];
          $partyModel->save($arr);

          $party_id = $partyModel->getInsertID();

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
            $partyDocModel->save($docarr);
          }

          $session = \Config\Services::session();
          $session->setFlashdata('success', 'Party added');
          return $this->response->redirect(base_url('/party'));
        }
      }
      return view('Party/create', $this->view);
    }
  }

  public function edit($id = null)
  {
    $access = $this->_access;
    if ($access === 'false') {
      $session = \Config\Services::session();
      $session->setFlashdata('error', 'You are not permitted to access this page');
      return $this->response->redirect(base_url('/dashboard'));
    } else {
      $pcModel = new PartyModel();
      $this->view['pc_data'] = $pcModel->where('id', $id)->first();

      $partytype = new PartytypeModel();
      $this->view['partytype'] = $partytype->orderby('name', 'ASC')->where('status', 'Active')->findAll();
      $partyTypes = new PartyTypePartyModel();
      $this->view['partyTypes'] = $partyTypes->where('party_id', $id)->findAll();
      $stateModel = new StateModel();
      $this->view['state'] = $stateModel->where(['isStatus' => '1'])->orderBy('state_id')->findAll();
      $businesstypeModel = new BusinessTypeModel();
      $this->view['businesstype'] = $businesstypeModel->orderBy('id')->findAll();

      $PartyDocModel = new PartyDocumentsModel();

      $this->view['partyDocs'] = $PartyDocModel->select('party_documents.*, flags.title')
        ->join('flags', 'flags.id = party_documents.flag_id')
        ->where('party_id', $id)->findAll();

      if ($this->request->getMethod() == 'POST') {
        $id = $this->request->getVar('id');

        $error = $this->validate([
          'party_name'                =>  'required|trim|regex_match[/^[a-z\d\-_\s]+$/i]',
          'state'                     =>  'required',
          'city'                      =>  'required',
          'postcode'                  =>  'required',
          'primary_phone'             =>  'required|numeric'
        ]);
        if (!$error) {
          $this->view['error']   = $this->validator;
        } else {

          $pcModel = new PartyModel();
          $pcModel->update($id, [
            'party_name'      =>  $this->request->getVar('party_name'),
            'party_classification_id' =>  $this->request->getVar('party_name'),
            'contact_person'   =>  $this->request->getVar('contact_person'),
            'alias' => $this->request->getVar('alias'),
            'business_address'   =>  $this->request->getVar('business_address'),
            'city'   =>  $this->request->getVar('city'),
            'state_id'   =>  $this->request->getVar('state'),
            'postcode'   =>  $this->request->getVar('postcode'),
            'primary_phone'   =>  $this->request->getVar('primary_phone'),
            'other_phone'   =>  $this->request->getVar('other_phone'),
            'email'   =>  $this->request->getVar('email'),
            'updated_at'  =>  date("Y-m-d h:i:sa"),
            'status'     =>  0,
            'approved'   =>  0
          ]);

          $session = \Config\Services::session();
          $session->setFlashdata('success', 'Party  Updated');
          return $this->response->redirect(base_url('party'));
        }
      }
    }

    return view('Party/edit', $this->view);
  }

  public function approve($id = null)
  {
    $access = $this->_access;
    if ($access === 'false') {
      $session = \Config\Services::session();
      $session->setFlashdata('error', 'You are not permitted to access this page');
      return $this->response->redirect(base_url('/dashboard'));
    } else {

      $pcModel = new PartyModel();
      $this->view['pc_data'] = $pcModel->where('id', $id)->first();

      $session = \Config\Services::session();

      if ($this->view['pc_data']['approved'] == 1) {
        $session->setFlashdata('success', 'Party Already Approved');
        return $this->response->redirect(base_url('party'));
      }


      $partytype = new PartytypeModel();
      $this->view['partytype'] = $partytype->orderby('name', 'ASC')->where('status', 'Active')->findAll();
      $partyTypes = new PartyTypePartyModel();
      $this->view['partyTypes'] = $partyTypes->where('party_id', $id)->findAll();
      $stateModel = new StateModel();
      $this->view['state'] = $stateModel->where(['isStatus' => '1'])->orderBy('state_id')->findAll();
      $businesstypeModel = new BusinessTypeModel();
      $this->view['businesstype'] = $businesstypeModel->orderBy('id')->findAll();

      $PartyDocModel = new PartyDocumentsModel();

      $this->view['partyDocs'] = $PartyDocModel->select('party_documents.*, flags.title')
        ->join('flags', 'flags.id = party_documents.flag_id')
        ->where('party_id', $id)->findAll();

      if ($this->request->getMethod() == 'POST') {


        $id = $this->request->getVar('id');

        $error = $this->validate([
          'party_name'                =>  'required|trim|regex_match[/^[a-z\d\-_\s]+$/i]',
          'state'                     =>  'required',
          'city'                      =>  'required',
          'postcode'                  =>  'required',
          'primary_phone'             =>  'required|numeric',
          'business_type_id'          =>  'required',
        ]);
        if (!$error) {
          $this->view['error']   = $this->validator;
        } else {

          $pcModel = new PartyModel();
          $pcModel->update($id, [
            'party_name'      =>  $this->request->getVar('party_name'),
            'party_classification_id' =>  $this->request->getVar('party_name'),
            'business_owner_name'   =>  $this->request->getVar('business_owner_name'),
            'alias' => $this->request->getVar('alias'),
            'accounts_person'   =>  $this->request->getVar('accounts_person'),
            'contact_person'   =>  $this->request->getVar('contact_person'),
            'business_address'   =>  $this->request->getVar('business_address'),
            'city'   =>  $this->request->getVar('city'),
            'state_id'   =>  $this->request->getVar('state'),
            'postcode'   =>  $this->request->getVar('postcode'),
            'primary_phone'   =>  $this->request->getVar('primary_phone'),
            'other_phone'   =>  $this->request->getVar('other_phone'),
            'email'   =>  $this->request->getVar('email'),
            'business_type_id'   =>  $this->request->getVar('business_type_id'),
            'updated_at'  =>  date("Y-m-d h:i:sa"),
            'status'                  =>  $this->request->getVar('approve'),
            'approved'                =>  $this->request->getVar('approve'),
            'approval_user_id'        =>  isset($user['id']) ? $user['id'] : '',
            'approval_user_type'      =>  isset($user['usertype']) ? $user['usertype'] : '',
            'approval_date'           =>  date("Y-m-d h:i:sa"),
            'approval_ip_address'     =>  $_SERVER['REMOTE_ADDR'],
          ]);


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



          $session->setFlashdata('success', 'Party Approved Successfully');
          return $this->response->redirect(base_url('party'));
        }
      }
    }

    return view('Party/approval', $this->view);
  }

  public function delete($id = null)
  {

    $access = $this->_access;
    if ($access === 'false') {
      $session = \Config\Services::session();
      $session->setFlashdata('error', 'You are not permitted to access this page');
      return $this->response->redirect(base_url('/dashboard'));
    } else {
      $partyModel = new PartyModel();
      $partyModel->where('id', $id)->delete($id);
      $session = \Config\Services::session();
      $session->setFlashdata('success', 'Party Deleted');
      return $this->response->redirect(base_url('/party'));
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
                    <label class="col-form-label">' . $flag['title'] . ' Image 1 ' . ($flag['mandatory'] ? '<span class="text-danger">*</span>' : '') . '</label>
                    <input type="file" ' . ($flag['mandatory'] ? 'required' : '') . ' name="img_' . $flag['flags_id'] . '_1" class="form-control" accept="image/png, image/gif, image/jpeg">
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-wrap">
                    <label class="col-form-label">' . $flag['title'] . '  Image 2</label>
                    <input type="file" name="img_' . $flag['flags_id'] . '_2" class="form-control" accept="image/png, image/gif, image/jpeg">
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

  public function status($id = null)
  {
    $access = $this->_access;
    if ($access === 'false') {
      $session = \Config\Services::session();
      $session->setFlashdata('error', 'You are not permitted to access this page');
      return $this->response->redirect(base_url('/dashboard'));
    } else {
      $status = '';
      $partyModel = new PartyModel();
      $pModel = $partyModel->where('id', $id)->first();
      if (isset($pModel)) {

        if ($pModel['approved'] == '1') {
          if ($pModel['status'] == '1') {
            $status = '0';
          } else {
            $status = '1';
          }
        } else {
          $session = \Config\Services::session();
          $session->setFlashdata('success', "Party Not Approved, Status Can't Be updated");
          return $this->response->redirect(base_url('/party'));
        }
      }

      $partyModel->update($id, [
        'status'              => $status,
        'updated_at'         =>  date("Y-m-d h:i:sa"),
      ]);
      $session = \Config\Services::session();
      $session->setFlashdata('success', 'Party Status updated');
      return $this->response->redirect(base_url('/party'));
    }
  }

  public function searchByStatus()
  {
    if ($this->request->getMethod() == 'POST') {
      $status = $this->request->getVar('status');
      $partModel = new PartyModel();
      $this->view['party_data'] = $partModel->where('status', $status)->orderBy('id', 'DESC')->findAll();
      $this->view['page_data'] = [
        'page_title' => view('partials/page-title', ['title' => 'Party', 'li_1' => '123', 'li_2' => 'deals'])
      ];
      return view('Party/search', $this->view);
    }
  }

  public function preview($id = null)
  {

    $this->view['party_details'] = $this->PModel->select('party.*,business_type.company_structure_name as business_type,states.state_name')
      ->join('business_type', 'business_type.id = party.business_type_id')
      ->join('states', 'states.state_id = party.state_id')
      ->where('party.id', $id)->first();

    $this->view['party_docs'] = $this->PDModel
      ->join('flags', 'flags.id = party_documents.flag_id')
      ->where('party_id', $id)->findAll();

    // echo '<pre>';
    // print_r($this->view['party_details']);
    // print_r($this->view['party_docs']);
    // die;

    return view('Party/preview', $this->view);
  }
}
