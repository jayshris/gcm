<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookingDropsModel;
use App\Models\BookingExpensesModel;
use App\Models\BookingPickupsModel;
use App\Models\BookingsModel;
use App\Models\BookingStatusModel;
use App\Models\BookingVehicleLogModel;
use App\Models\CustomerBranchModel;
use App\Models\CustomersModel;
use App\Models\OfficeModel;
use App\Models\PartyModel;
use App\Models\PartytypeModel;
use App\Models\ProfileModel;
use App\Models\StateModel;
use App\Models\UserModel;
use App\Models\VehicleModel;
use App\Models\VehicleTypeModel;
use CodeIgniter\HTTP\ResponseInterface;

class Booking extends BaseController
{
    public $session;
    public $access;
    public $added_by;
    public $added_ip;
    public $SModel;
    public $BSModel;
    public $VTModel;
    public $VModel;
    public $PModel;
    public $PTModel;

    public $BModel;
    public $BPModel;
    public $BDModel;
    public $BEModel;
    public $OModel;
    public $CModel;
    public $CBModel;
    public $BVLModel;

    public $user;
    public $profile;


    public function __construct()
    {
        $this->session = \Config\Services::session();

        $this->user = new UserModel();
        $this->profile = new ProfileModel();
        $this->access = $this->user->setPermission();

        $this->added_by = isset($_SESSION['id']) ? $_SESSION['id'] : '0';
        $this->added_ip = isset($_SERVER['REMOTE_ADDR'])  ? $_SERVER['REMOTE_ADDR'] : '';

        $this->SModel = new StateModel();
        $this->BSModel = new BookingStatusModel();

        $this->VTModel = new VehicleTypeModel();
        $this->VModel = new VehicleModel();
        $this->PModel = new PartyModel();
        $this->PTModel = new PartytypeModel();

        $this->BModel = new BookingsModel();
        $this->BPModel = new BookingPickupsModel();
        $this->BDModel = new BookingDropsModel();
        $this->BEModel = new BookingExpensesModel();
        $this->OModel = new OfficeModel();
        $this->CModel = new CustomersModel();
        $this->CBModel = new CustomerBranchModel();
        $this->BVLModel = new BookingVehicleLogModel();
    }

    public function index()
    {
        if ($this->access === 'false') {
            $this->session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(base_url('/dashboard'));
        } else {
            $this->BModel->select('bookings.*, party.party_name, vehicle.rc_number, booking_status.status_name, booking_status.status_bg')
                ->join('customer', 'customer.id = bookings.customer_id')
                ->join('party', 'party.id = customer.party_id')
                ->join('vehicle', 'vehicle.id = bookings.vehicle_id', 'left')
                ->join('booking_status', 'booking_status.id = bookings.status', 'left');

            if ($this->request->getPost('status') != '') {
                $this->BModel->where('bookings.status', $this->request->getPost('status'));
            }

            $this->view['bookings'] = $this->BModel->orderBy('bookings.id', 'desc')->findAll();

            $this->view['statuses'] = $this->BSModel->findAll();
            $this->view['pickup'] = $this->BPModel;
            $this->view['drop'] = $this->BDModel;

            return view('Booking/index', $this->view);
        }
    }

    public function create()
    {
        if ($this->access === 'false') {
            $this->session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(base_url('/dashboard'));
        }
        else if ($this->request->getPost()) {
            $profile =  $this->profile->first();//echo __LINE__.'<pre>';print_r($profile);die;

            $last_booking = $this->BModel->orderBy('id', 'desc')->first();
            $lastBooking = isset($last_booking['id']) ? ((int)$last_booking['id']+1) : 1;

            $booking_number = isset($profile['booking_prefix']) ? $profile['booking_prefix'].'/'.$lastBooking : 'BK/'.$lastBooking;

            // save booking
            $bookingData = [
                'booking_number' => $booking_number,
                'booking_for' => $this->request->getPost('booking_for'),
                'office_id' => $this->request->getPost('office_id'),
                'vehicle_type_id' => $this->request->getPost('vehicle_type'),
                'vehicle_id' => $this->request->getPost('vehicle_rc'),
                'customer_id' => $this->request->getPost('customer_id'),
                'customer_branch' => $this->request->getPost('customer_branch'),
                'customer_type' => ($this->request->getPost('customer_type')) ? $this->request->getPost('customer_type') : 0,
                'pickup_date' => $this->request->getPost('pickup_date'),
                'drop_date' => $this->request->getPost('drop_date'),
                'rate_type' => $this->request->getPost('rate_type'),
                'rate' => $this->request->getPost('rate'),
                'booking_by' => $this->request->getPost('booking_by'),
                'booking_date' => $this->request->getPost('booking_date'),
                'guranteed_wt' => $this->request->getPost('guranteed_wt'),
                'freight' => $this->request->getPost('freight'),
                'advance' => $this->request->getPost('advance'),
                'balance' => $this->request->getPost('balance'),
                'discount' => $this->request->getPost('discount'),
                'bill_to_party' => $this->request->getPost('bill_to'),
                'remarks' => $this->request->getPost('remarks'),
                'status' => '1',
                'added_by' => $this->added_by,
                'added_ip' => $this->added_ip
            ];//echo __LINE__.'<pre>';print_r($bookingData);die;
            $booking_id = $this->BModel->insert($bookingData) ? $this->BModel->getInsertID() : '0';


            if ($booking_id > 0) {

                // save pickups
                foreach ($this->request->getPost('pickup_seq') as $key => $val) {
                    $this->BPModel->insert([
                        'booking_id' => $booking_id,
                        'sequence' => $this->request->getPost('pickup_seq')[$key],
                        'city' => $this->request->getPost('pickup_city')[$key],
                        'state' => $this->request->getPost('pickup_state_id')[$key],
                        'pincode' => $this->request->getPost('pickup_pin')[$key]
                    ]);
                }

                // save drops
                foreach ($this->request->getPost('drop_seq') as $key => $val) {
                    $this->BDModel->insert([
                        'booking_id' => $booking_id,
                        'sequence' => $this->request->getPost('drop_seq')[$key],
                        'city' => $this->request->getPost('drop_city')[$key],
                        'state' => $this->request->getPost('drop_state_id')[$key],
                        'pincode' => $this->request->getPost('drop_pin')[$key]
                    ]);
                }

                // save expenses
                foreach ($this->request->getPost('expense') as $key => $val) {
                    $this->BEModel->insert([
                        'booking_id' => $booking_id,
                        'expense' => $this->request->getPost('expense')[$key],
                        'value' => $this->request->getPost('expense_value')[$key],
                        'bill_to_party' => $this->request->getPost('expense_flag_' . $key) != null ? '1' : '0'
                    ]);
                }

                $this->session->setFlashdata('success', 'Booking Successfully Added');

                return $this->response->redirect(base_url('booking'));
            } else {
                $this->session->setFlashdata('success', 'Something went wrong. Please try again');
                return $this->response->redirect(base_url('booking/create'));
            }
        } else {

            $this->view['party'] = $this->PModel->select('party.*')->join('party_type_party_map', 'party_type_party_map.party_id = party.id')
                ->whereIn('party_type_party_map.party_type_id', [1, 2, 5])->groupBy('party.id')->orderBy('party.party_name')->findAll();

            $this->view['offices'] = $this->OModel->where('status', '1')->findAll();

            $this->view['vehicle_types'] = $this->VTModel->where('status', 'Active')->findAll();
            $this->view['employees'] = $this->user->where('usertype', 'employee')->where('status', 'active')->findall();
            $this->view['states'] =  $this->SModel->findAll();

            $this->view['customers'] = $this->CModel->select('customer.*, party.party_name')
                ->join('party', 'party.id = customer.party_id')
                ->where('customer.status', '1')
                ->findAll();

            return view('Booking/create', $this->view);
        }
    }

    public function approve($id)
    {
        if ($this->access === 'false') {
            $this->session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(base_url('/dashboard'));
        } else {

            if ($this->request->getPost()) {

                $isVehicle = $this->BModel->where('id', $id)->first()['vehicle_id'] > 0 ? true : false;

                // echo '<pre>';
                // print_r($this->request->getPost());
                // print_r($isVehicle);
                // die;


                // update booking
                $this->BModel->update($id, [
                    'booking_for' => $this->request->getPost('booking_for'),
                    'office_id' => $this->request->getPost('office_id'),
                    'vehicle_type_id' => $this->request->getPost('vehicle_type'),
                    'vehicle_id' => $this->request->getPost('vehicle_rc'),
                    'customer_id' => $this->request->getPost('customer_id'),
                    'customer_branch' => $this->request->getPost('customer_branch'),
                    'customer_type' => $this->request->getPost('customer_type'),
                    'pickup_date' => $this->request->getPost('pickup_date'),
                    'drop_date' => $this->request->getPost('drop_date'),
                    'booking_by' => $this->request->getPost('booking_by'),
                    'booking_date' => $this->request->getPost('booking_date'),
                    'guranteed_wt' => $this->request->getPost('guranteed_wt'),
                    'freight' => $this->request->getPost('freight'),
                    'advance' => $this->request->getPost('advance'),
                    'balance' => $this->request->getPost('balance'),
                    'discount' => $this->request->getPost('discount'),
                    'bill_to_party' => $this->request->getPost('bill_to'),
                    'remarks' => $this->request->getPost('remarks'),
                    'status' => $isVehicle ? '3' : '2',
                    'approved_by' => $this->added_by,
                    'approved_ip' => $this->added_ip,
                    'approved_date' => date('Y-m-d h:i:s'),
                    'approved' => $this->request->getPost('approve'),
                ]);

                // delete Drops, Pickups and Expences
                $this->BDModel->where('booking_id', $id)->delete();
                $this->BPModel->where('booking_id', $id)->delete();
                $this->BEModel->where('booking_id', $id)->delete();

                // save pickups
                foreach ($this->request->getPost('pickup_seq') as $key => $val) {
                    $this->BPModel->insert([
                        'booking_id' => $id,
                        'sequence' => $this->request->getPost('pickup_seq')[$key],
                        'city' => $this->request->getPost('pickup_city')[$key],
                        'state' => $this->request->getPost('pickup_state_id')[$key],
                        'pincode' => $this->request->getPost('pickup_pin')[$key]
                    ]);
                }

                // save drops
                foreach ($this->request->getPost('drop_seq') as $key => $val) {
                    $this->BDModel->insert([
                        'booking_id' => $id,
                        'sequence' => $this->request->getPost('drop_seq')[$key],
                        'city' => $this->request->getPost('drop_city')[$key],
                        'state' => $this->request->getPost('drop_state_id')[$key],
                        'pincode' => $this->request->getPost('drop_pin')[$key]
                    ]);
                }

                // save expenses
                foreach ($this->request->getPost('expense') as $key => $val) {
                    $this->BEModel->insert([
                        'booking_id' => $id,
                        'expense' => $this->request->getPost('expense')[$key],
                        'value' => $this->request->getPost('expense_value')[$key],
                        'bill_to_party' => $this->request->getPost('expense_flag_' . $key) != null ? '1' : '0'
                    ]);
                }


                $this->session->setFlashdata('success', 'Booking Successfully Updated');

                return $this->response->redirect(base_url('booking'));
            }

            $this->view['party'] = $this->PModel->select('party.*')->join('party_type_party_map', 'party_type_party_map.party_id = party.id')
                ->whereIn('party_type_party_map.party_type_id', [1, 2, 5])->groupBy('party.id')->orderBy('party.party_name')->findAll();

            $this->view['offices'] = $this->OModel->where('status', '1')->findAll();

            $this->view['vehicle_types'] = $this->VTModel->where('status', 'Active')->findAll();
            $this->view['employees'] = $this->user->where('usertype', 'employee')->where('status', 'active')->findall();
            $this->view['states'] =  $this->SModel->findAll();

            $this->view['customers'] = $this->CModel->select('customer.*, party.party_name')
                ->join('party', 'party.id = customer.party_id')
                ->where('customer.status', '1')
                ->findAll();

            //for booking data
            $this->view['booking_details'] = $this->BModel->where('id', $id)->first();
            $this->view['booking_pickups'] = $this->BPModel->where('booking_id', $id)->findAll();
            $this->view['booking_drops'] = $this->BDModel->where('booking_id', $id)->findAll();
            $this->view['booking_expences'] = $this->BEModel->where('booking_id', $id)->findAll();
            $this->view['vehicle_rcs'] = $this->VModel->where('status', 'active')->findAll();


            return view('Booking/approve', $this->view);
        }
    }

    public function addPickup()
    {
        $this->view['states'] =  $this->SModel->findAll();
        $this->view['index'] = $this->request->getPost('index');
        echo view('Booking/pickup_block', $this->view);
    }

    public function addDrop()
    {
        $this->view['states'] =  $this->SModel->findAll();
        $this->view['index'] = $this->request->getPost('index');
        echo view('Booking/drop_block', $this->view);
    }

    public function addExpense()
    {
        $this->view['index'] = $this->request->getPost('index');
        echo view('Booking/expense_block', $this->view);
    }

    public function getCustomerType()
    {
        $customer = $this->CModel->where('id', $this->request->getPost('customer_id'))->first();

        $html = '';

        if ($customer) {
            $customer_party_type = explode(',', $customer['party_type_id']);

            $rows = $this->PTModel->whereIn('id', $customer_party_type)->where('sale', '1')->findAll();
            if (count($rows) > 0) {
                foreach ($rows as $row) {
                    $html .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                }
            }
        }

        return $html;
    }

    public function getCustomerBranch()
    {
        $html = '';
        $rows = $this->CBModel->where('customer_id', $this->request->getPost('customer_id'))->findAll();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $html .= '<option value="' . $row['id'] . '">' . $row['office_name'] . '</option>';
            }
        }
        return $html;
    }

    public function getVehicles()
    {
        $rows =  $this->VModel->where('vehicle_type_id', $this->request->getPost('vehicle_type'))->where('status', '1')->where('working_status', '1')->findAll();

        $html = '<option value="">Select Vehicle</option>';
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $html .= '<option value="' . $row['id'] . '">' . $row['rc_number'] . '</option>';
            }
        }

        return $html;
    }

    public function assign_vehicle($id)
    {
        $this->view['offices'] = $this->OModel->where('status', '1')->findAll();
        $this->view['vehicle_types'] = $this->VTModel->where('status', 'Active')->findAll();
        $this->view['customers'] = $this->CModel->select('customer.*, party.party_name')
            ->join('party', 'party.id = customer.party_id')
            ->where('customer.status', '1')
            ->findAll();
        $this->view['states'] =  $this->SModel->findAll();
        //for booking data
        $this->view['booking_details'] = $this->BModel->where('id', $id)->first();
        $this->view['booking_pickups'] = $this->BPModel->where('booking_id', $id)->findAll();
        $this->view['booking_drops'] = $this->BDModel->where('booking_id', $id)->findAll();
        $this->view['booking_expences'] = $this->BEModel->where('booking_id', $id)->findAll();

        $this->view['vehicle_rcs'] = $this->VModel->select('vehicle.id, vehicle.rc_number, party.party_name')
            ->join('driver_vehicle_map', 'driver_vehicle_map.vehicle_id = vehicle.id')
            ->join('driver', 'driver.id = driver_vehicle_map.driver_id')
            ->join('party', 'party.id = driver.name')
            ->where('driver_vehicle_map.unassign_date', '')
            ->where('vehicle_type_id', $this->view['booking_details']['vehicle_type_id'])
            ->where('vehicle.status', 'active')->groupBy('vehicle.id')->findAll();



        if ($this->request->getPost()) {
            $this->BModel->update($id, [
                'vehicle_id' => $this->request->getPost('vehicle_rc'),
                'status' => '3'
            ]);

            $this->BVLModel->insert([
                'booking_id' => $id,
                'vehicle_id' => $this->request->getPost('vehicle_rc'),
                'assign_by' => $this->added_by
            ]);

            $this->session->setFlashdata('success', 'Vehicle Assigned To Booking');

            return $this->response->redirect(base_url('booking'));
        }




        return view('Booking/vehicle', $this->view);
    }

    public function cancel($id)
    {
        $booking_details =  $this->BModel->where('id', $id)->first();

        // echo '<pre>';
        // print_r($booking_details);

        //change sstatus of driver and vehicle too

        if ($booking_details['status'] >= '5') {
            $this->session->setFlashdata('danger', 'Booking Cancellation Not Allowed As Trip Has Started');
            return $this->response->redirect(base_url('booking'));
        } else {
            $this->BModel->update($id, ['status' => '15']);
            $this->session->setFlashdata('sucess', 'Booking Cancelled');
            return $this->response->redirect(base_url('booking'));
        }
    }
}
