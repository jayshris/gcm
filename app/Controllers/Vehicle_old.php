<?php

namespace App\Controllers;

use App\Models\VehicleModel;
use App\Models\VehicleTyreDetailsMapModel;
use App\Models\VehicleTypeModel;
use App\Models\VehicleTModel;
use App\Models\UserModel;
use App\Models\ModulesModel;
use App\Models\PartyModel;

class Vehicle extends BaseController
{

  public $_access;



  public function __construct()

  {

    $u = new UserModel();

    $access = $u->setPermission();

    $this->_access = $access;

    $this->vehicleModel = new VehicleModel();
    $this->vehicletyredetailsmapModel = new VehicleTyreDetailsMapModel();
    $this->vehicletypeModel = new VehicleTypeModel();
    $this->vehicletModel = new VehicleTModel();

    $this->PModel = new PartyModel();
  }



  public function index()

  {

    $access = $this->_access;

    if ($access === 'false') {

      $session = \Config\Services::session();

      $session->setFlashdata('error', 'You are not permitted to access this page');

      return $this->response->redirect(site_url('/dashboard'));
    } else {
      $this->view['vehicle_data'] = $this->vehicleModel->select('vehicle.*, GROUP_CONCAT(vehicle_tyre_details_map.tyre_serial_text) as tyre_serial_text, vehicle_type.name as vehiclename,vehicle_model.model_no as model_no', false)

        ->join('vehicle_tyre_details_map', 'vehicle_tyre_details_map.vehicle_id = vehicle.id', 'left')

        ->join('vehicle_type', 'vehicle_type.id = vehicle.vehicle_type_id', 'left')

        ->join('vehicle_model', 'vehicle_model.id = vehicle.model_number_id', 'left')

        ->where('vehicle.deleted_at', NULL)
        ->groupBy('vehicle.id')

        ->orderBy('vehicle.id', 'DESC')

        ->findAll();

      return view('Vehicle/index', $this->view);
    }
  }



  public function create()

  {

    $access = $this->_access;

    if ($access === 'false') {

      $session = \Config\Services::session();

      $session->setFlashdata('error', 'You are not permitted to access this page');

      return $this->response->redirect(site_url('/dashboard'));
    } else {

      helper(['form', 'url']);

      $this->view['page_data'] = [

        'page_title' => view('partials/page-title', ['title' => 'Add Vehicle', 'li_2' => 'profile'])

      ];

      $this->view['party'] = $this->PModel->where('status', '1')->findAll();

      $this->view['vehicletype_data'] = $this->vehicletypeModel->where(['status' => 'Active'])->orderBy('name')->findAll();

      $this->view['vehiclemodel_data'] = $this->vehicletModel->where(['status' => 'Active'])->orderBy('model_no')->findAll();

      $request = service('request');

      if ($this->request->getMethod() == 'POST') {

        $error = $this->validate([
          'owner'   =>  'required',
          'vehicletype'   =>  'required',
          'model_no'   =>  'required',
          // 'rc'   =>  'required|alpha_numeric_space|trim|is_unique[vehicle.rc_number]',
          // 'chassis'   =>  'required|alpha_numeric_space|trim|is_unique[vehicle.chassis_number]',
          // 'engine'   =>  'required|alpha_numeric_space|trim|is_unique[vehicle.engine_number]',
          // 'km'   =>  'required|numeric',
          'image1'   =>  'max_size[image1,100]|ext_in[image1,jpg,jpeg,png]',
          'image2'   =>  'max_size[image2,100]|ext_in[image2,jpg,jpeg,png]',
          'image3'   =>  'max_size[image3,100]|ext_in[image3,jpg,jpeg,png]',
          'image4'   =>  'max_size[image4,100]|ext_in[image4,jpg,jpeg,png]',
        ]);

        if (!$error) {
          $this->view['error']   = $this->validator;
        } else {
          $newName1 = '';
          $image1 = $this->request->getFile('image1');
          if ($image1->isValid() && !$image1->hasMoved()) {
            $newName1 = $image1->getRandomName();
            $imgpath = 'public/uploads/vehicles';
            if (!is_dir($imgpath)) {
              mkdir($imgpath, 0777, true);
            }

            $image1->move($imgpath, $newName1);
          }
          if ($newName1 == '') {
            $image_name1 = '';
          } else {
            $image_name1 = $newName1;
          }

          $newName2 = '';
          $image2 = $this->request->getFile('image2');
          if ($image2->isValid() && !$image2->hasMoved()) {
            $newName2 = $image2->getRandomName();
            $imgpath = 'public/uploads/vehicles';
            if (!is_dir($imgpath)) {
              mkdir($imgpath, 0777, true);
            }

            $image2->move($imgpath, $newName2);
          }
          if ($newName2 == '') {
            $image_name2 = '';
          } else {
            $image_name2 = $newName2;
          }

          $newName3 = '';
          $image3 = $this->request->getFile('image3');
          if ($image3->isValid() && !$image3->hasMoved()) {
            $newName3 = $image3->getRandomName();
            $imgpath = 'public/uploads/vehicles';
            if (!is_dir($imgpath)) {
              mkdir($imgpath, 0777, true);
            }

            $image3->move($imgpath, $newName3);
          }
          if ($newName3 == '') {
            $image_name3 = '';
          } else {
            $image_name3 =  $newName3;
          }

          $newName4 = '';
          $image4 = $this->request->getFile('image4');
          if ($image4->isValid() && !$image4->hasMoved()) {
            $newName4 = $image4->getRandomName();
            $imgpath = 'public/uploads/vehicles';
            if (!is_dir($imgpath)) {
              mkdir($imgpath, 0777, true);
            }

            $image4->move($imgpath, $newName4);
          }
          if ($newName4 == '') {
            $image_name4 = '';
          } else {
            $image_name4 =  $newName4;
          }


          $this->vehicleModel->save([
            'owner'  =>  $this->request->getVar('owner'),
            'party_id' =>  $this->request->getVar('vendor_id') != null ? $this->request->getVar('vendor_id') : '0',
            'vehicle_type_id'  =>  $this->request->getVar('vehicletype'),
            'model_number_id'  =>  $this->request->getVar('model_no'),
            'rc_number'  =>  $this->request->getVar('rc'),
            'rc_date'  =>  $this->request->getVar('rc_date'),
            'mfg' => $this->request->getVar('mfg'),
            'invoice_no' => $this->request->getVar('inv_no'),
            'invoice_date' => $this->request->getVar('inv_date'),
            'chassis_number'  =>  $this->request->getVar('chassis'),
            'engine_number'  =>  $this->request->getVar('engine'),
            'colour'  =>  $this->request->getVar('colour'),
            'seating'  =>  $this->request->getVar('seating'),
            'unladen_wt'  =>  $this->request->getVar('unladen_wt'),
            'laden_wt'  =>  $this->request->getVar('laden_wt'),
            'km_reading_start'  =>  $this->request->getVar('km'),
            'image1'  =>  $image_name1,
            'image2'  =>  $image_name2,
            'image3'  =>  $image_name3,
            'image4'  =>  $image_name4,
            'status'  => 'Active',
            'created_at'  =>  date("Y-m-d h:i:sa"),
          ]);

          $vehicle_id = $this->vehicleModel->getInsertID();

          $selectedFuelNameId = $this->request->getPost('fuel_types');

          foreach ($selectedFuelNameId as $fuelTypeId) {

            $this->vehicletyredetailsmapModel->save([

              'vehicle_id' => $vehicle_id,

              'tyre_serial_text' => $fuelTypeId,

              'status'  => 'Active',

              'created_at'  =>  date("Y-m-d h:i:sa"),

            ]);
          }
          $session = \Config\Services::session();

          $session->setFlashdata('success', 'Vehicle Added Successfully');

          return $this->response->redirect(base_url('/vehicle'));
        }
      }

      return view('Vehicle/create', $this->view);
    }
  }



  public function edit($id = null)

  {

    $access = $this->_access;

    if ($access === 'false') {

      $session = \Config\Services::session();

      $session->setFlashdata('error', 'You are not permitted to access this page');

      return $this->response->redirect(site_url('/dashboard'));
    } else {

      // if (!empty($id)) {
      //   $this->vehicleModel->update($id, [
      //     'status'                  =>  'Inactive',
      //     'approved'                =>  '',
      //     'approval_user_id'        =>  '',
      //     'approval_user_type'      =>  '',
      //     'approval_date'           =>  '',
      //     'approval_ip_address'     =>  $_SERVER['REMOTE_ADDR'],
      //     'updated_at'              =>  date("Y-m-d h:i:sa"),
      //   ]);
      // }
      $this->view['party'] = $this->PModel->where('status', '1')->findAll();

      $this->view['vehicletype_data'] = $this->vehicletypeModel->where(['status' => 'Active'])->orderBy('name')->findAll();

      $this->view['vehiclemodel_data'] = $this->vehicletModel->where(['status' => 'Active'])->orderBy('model_no')->findAll();

      $this->view['vehicle_data'] = $this->vehicleModel->select('vehicle.*, GROUP_CONCAT(vehicle_tyre_details_map.tyre_serial_text) as tyre_serial_text, vehicle_type.name as vehiclename,vehicle_model.model_no as model_no', false)

        ->join('vehicle_tyre_details_map', 'vehicle_tyre_details_map.vehicle_id = vehicle.id', 'left')

        ->join('vehicle_type', 'vehicle_type.id = vehicle.vehicle_type_id', 'left')

        ->join('vehicle_model', 'vehicle_model.id = vehicle.model_number_id', 'left')

        ->where('vehicle_tyre_details_map.deleted_at', NULL)

        ->where('vehicle.deleted_at', NULL)

        ->where('vehicle.id', $id)

        ->groupBy('vehicle.id')

        ->first();


      $request = service('request');

      if ($this->request->getMethod() == 'POST') {

        $id = $this->request->getVar('id');

        $this->view['vehicle_data'] = $this->vehicleModel->select('vehicle.*, GROUP_CONCAT(vehicle_tyre_details_map.tyre_serial_text) as tyre_serial_text, vehicle_type.name as vehiclename,vehicle_model.model_no as model_no')

          ->join('vehicle_tyre_details_map', 'vehicle_tyre_details_map.vehicle_id = vehicle.id', 'left')

          ->join('vehicle_type', 'vehicle_type.id = vehicle.vehicle_type_id', 'left')

          ->join('vehicle_model', 'vehicle_model.id = vehicle.model_number_id', 'left')

          ->where('vehicle.deleted_at', NULL)
          ->where('vehicle_tyre_details_map.deleted_at', NULL)

          ->where('vehicle.id', $id)

          ->groupBy('vehicle.id')

          ->first();

        $error = $this->validate([

          'owner'   =>  'required',
          'vehicletype'   =>  'required',
          'model_no'   =>  'required',
          // 'rc'   =>  'required|alpha_numeric_space',
          // 'chassis'   =>  'required|alpha_numeric_space',
          // 'engine'   =>  'required|alpha_numeric_space',
          // 'km'   =>  'required|numeric',
          'image1'   =>  'max_size[image1,100]|ext_in[image1,jpg,jpeg,png]',
          'image2'   =>  'max_size[image2,100]|ext_in[image2,jpg,jpeg,png]',
          'image3'   =>  'max_size[image3,100]|ext_in[image3,jpg,jpeg,png]',
          'image4'   =>  'max_size[image4,100]|ext_in[image4,jpg,jpeg,png]',
        ]);

        if (!$error) {

          $this->view['error']   = $this->validator;
        } else {

          $normalizedrc = strtolower(str_replace(' ', '', $this->request->getVar('rc')));
          $normalizedchassis = strtolower(str_replace(' ', '', $this->request->getVar('chassis')));
          $normalizedengine = strtolower(str_replace(' ', '', $this->request->getVar('engine')));
          $vehiclerccnt = $this->vehicleModel
            ->where('status', 'Active')
            ->where('deleted_at', NULL)
            ->where('id!=', $id)
            ->where('LOWER(REPLACE(rc_number, " ", ""))', $normalizedrc)
            ->orderBy('id')->countAllResults();
          $vehiclechassiscnt = $this->vehicleModel
            ->where('status', 'Active')
            ->where('deleted_at', NULL)
            ->where('id!=', $id)
            ->where('LOWER(REPLACE(chassis_number, " ", ""))', $normalizedchassis)
            ->orderBy('id')->countAllResults();
          $vehicleenginecnt = $this->vehicleModel
            ->where('status', 'Active')
            ->where('deleted_at', NULL)
            ->where('id!=', $id)
            ->where('LOWER(REPLACE(engine_number, " ", ""))', $normalizedengine)
            ->orderBy('id')->countAllResults();
          if ($vehiclerccnt == 0 && $vehiclechassiscnt == 0 && $vehicleenginecnt == 0) {



            if ($this->request->getVar('active') == 1) {
              $status = 'Active';
            } else {
              $status = 'Inactive';
            }

            $this->vehicleModel->update($id, [
              'owner'  =>  $this->request->getVar('owner'),
              'party_id' =>  $this->request->getVar('owner') == 'onhire' ? $this->request->getVar('vendor_id') : '0',
              'vehicle_type_id'  =>  $this->request->getVar('vehicletype'),
              'model_number_id'  =>  $this->request->getVar('model_no'),
              'rc_number'  =>  $this->request->getVar('rc'),
              'rc_date'  =>  $this->request->getVar('rc_date'),
              'mfg' => $this->request->getVar('mfg'),
              'invoice_no' => $this->request->getVar('inv_no'),
              'invoice_date' => $this->request->getVar('inv_date'),
              'chassis_number'  =>  $this->request->getVar('chassis'),
              'engine_number'  =>  $this->request->getVar('engine'),
              'colour'  =>  $this->request->getVar('colour'),
              'seating'  =>  $this->request->getVar('seating'),
              'unladen_wt'  =>  $this->request->getVar('unladen_wt'),
              'laden_wt'  =>  $this->request->getVar('laden_wt'),
              'km_reading_start'  =>  $this->request->getVar('km'),
              'status'                  =>  $status,
              'approved'                =>  $this->request->getVar('approve'),
              'approval_user_id'        =>  isset($user['id']) ? $user['id'] : '',
              'approval_user_type'      =>  isset($user['usertype']) ? $user['usertype'] : '',
              'approval_date'           =>  date("Y-m-d h:i:sa"),
              'approval_ip_address'     =>  $_SERVER['REMOTE_ADDR'],
              'updated_at'              =>  date("Y-m-d h:i:sa")
            ]);


            if ($this->request->getFile('image1') != null) {
              $image = $this->request->getFile('image1');
              if ($image->isValid() && !$image->hasMoved()) {
                $newName1 = $image->getRandomName();
                $imgpath = 'public/uploads/vehicles';
                if (!is_dir($imgpath)) {
                  mkdir($imgpath, 0777, true);
                }
                $image->move($imgpath, $newName1);
                $this->vehicleModel->update($id, ['image1' => $newName1]);
              }
            }

            if ($this->request->getFile('image2') != null) {
              $image = $this->request->getFile('image2');
              if ($image->isValid() && !$image->hasMoved()) {
                $newName2 = $image->getRandomName();
                $imgpath = 'public/uploads/vehicles';
                if (!is_dir($imgpath)) {
                  mkdir($imgpath, 0777, true);
                }
                $image->move($imgpath, $newName2);
                $this->vehicleModel->update($id, ['image2' => $newName2]);
              }
            }

            if ($this->request->getFile('image3') != null) {
              $image = $this->request->getFile('image3');
              if ($image->isValid() && !$image->hasMoved()) {
                $newName3 = $image->getRandomName();
                $imgpath = 'public/uploads/vehicles';
                if (!is_dir($imgpath)) {
                  mkdir($imgpath, 0777, true);
                }
                $image->move($imgpath, $newName3);
                $this->vehicleModel->update($id, ['image3' => $newName3]);
              }
            }

            if ($this->request->getFile('image4') != null) {
              $image = $this->request->getFile('image4');
              if ($image->isValid() && !$image->hasMoved()) {
                $newName4 = $image->getRandomName();
                $imgpath = 'public/uploads/vehicles';
                if (!is_dir($imgpath)) {
                  mkdir($imgpath, 0777, true);
                }
                $image->move($imgpath, $newName4);
                $this->vehicleModel->update($id, ['image4' => $newName4]);
              }
            }

            // First delete existing records

            $checkdel = $this->vehicletyredetailsmapModel->where('vehicle_id', $id)->delete();

            $selectedFuelNameId = $this->request->getPost('fuel_types');
            foreach ($selectedFuelNameId as $fuelTypeId) {

              $this->vehicletyredetailsmapModel->save([

                'vehicle_id' => $id,

                'tyre_serial_text' => $fuelTypeId,

                'status'  => 'Active',

                'created_at'  =>  date("Y-m-d h:i:sa"),

              ]);
            }
          } else {
            if ($vehiclerccnt > 0) {
              $this->validator->setError('rc', 'The field must contain a unique value.');
              $this->view['error']  = $this->validator;
            }
            if ($vehiclechassiscnt > 0) {
              $this->validator->setError('chassis', 'The field must contain a unique value.');
              $this->view['error']  = $this->validator;
            }
            if ($vehicleenginecnt > 0) {
              $this->validator->setError('engine', 'The field must contain a unique value.');
              $this->view['error']  = $this->validator;
            }

            return view('vehicle/edit', $this->view);
            return false;
          }
          $session = \Config\Services::session();



          $session->setFlashdata('success', 'Vehicle updated');

          return $this->response->redirect(site_url('/vehicle'));
        }
      }

      return view('Vehicle/edit', $this->view);
    }
  }



  public function delete($id)
  {

    $access = $this->_access;

    if ($access === 'false') {

      $session = \Config\Services::session();

      $session->setFlashdata('error', 'You are not permitted to access this page');

      return $this->response->redirect(site_url('/dashboard'));
    } else {

      $this->vehicleModel->where('id', $id)->delete($id);

      $session = \Config\Services::session();

      $session->setFlashdata('success', 'Vehicle Deleted');

      return $this->response->redirect(site_url('/vehicle'));
    }
  }

  public function view($id = null)
  {
    $access = $this->_access;
    if ($access === 'false') {
      $session = \Config\Services::session();
      $session->setFlashdata('error', 'You are not permitted to access this page');
      return $this->response->redirect(site_url('/dashboard'));
    } else {


      $this->view['vehicletype_data'] = $this->vehicletypeModel->where(['status' => 'Active'])->orderBy('name')->findAll();

      $this->view['vehiclemodel_data'] = $this->vehicletModel->where(['status' => 'Active'])->orderBy('model_no')->findAll();

      $this->view['vehicle_data'] = $this->vehicleModel->select('vehicle.*, GROUP_CONCAT(vehicle_tyre_details_map.tyre_serial_text) as tyre_serial_text, vehicle_type.name as vehiclename,vehicle_model.model_no as model_no', false)

        ->join('vehicle_tyre_details_map', 'vehicle_tyre_details_map.vehicle_id = vehicle.id', 'left')

        ->join('vehicle_type', 'vehicle_type.id = vehicle.vehicle_type_id', 'left')

        ->join('vehicle_model', 'vehicle_model.id = vehicle.model_number_id', 'left')

        ->where('vehicle.deleted_at', NULL)
        ->where('vehicle_tyre_details_map.deleted_at', NULL)

        ->where('vehicle.id', $id)

        ->groupBy('vehicle.id')

        ->first();
      return view('Vehicle/details', $this->view);
    }
  }


  public function getVehicletypedetails()
  {

    $vehicletypeId = $this->request->getPost('vehicletype_id');
    $vehicletyres = $this->vehicletypeModel->where('status', 'Active')->where('id', $vehicletypeId)->orderBy('id')->first();
    $this->view['vehiclemodels'] = $this->vehicletModel->where('status', 'Active')->where('vehicle_type_id', $vehicletypeId)->orderBy('id')->findAll();
    $this->view['vehicletyres1'] = [];
    for ($i = 1; $i <= $vehicletyres['number_of_tyres'] + $vehicletyres['number_of_tyres_spare']; $i++) {
      $this->view['vehicletyres1'][] = [
        ['id' => $i, 'name' => 'Tyre ' . $i],
      ];
    }
    return $this->response->setJSON($this->view);
  }

  public function getVehicleModelDetails()
  {
    $vehicleModelId = $this->request->getPost('model_id');
    $vehicleModel = $this->vehicletModel->where('id', $vehicleModelId)->first();

    return $this->response->setJSON($vehicleModel);
  }
}
