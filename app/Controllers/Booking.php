<?php

namespace App\Controllers;

use App\Models\CityModel;
use App\Models\UserModel;
use App\Models\PartyModel;
use App\Models\StateModel;
use App\Models\DriverModel;
use App\Models\OfficeModel;
use App\Models\ProfileModel;
use App\Models\VehicleModel;
use App\Models\BookingsModel;
use App\Models\EmployeeModel;
use App\Models\CustomersModel;
use App\Models\MaterialsModel;
use App\Models\PartytypeModel;
use App\Models\BookingLinkModel;
use App\Models\ExpenseHeadModel;
use App\Models\VehicleTypeModel;
use App\Models\BookingDropsModel;
use App\Models\NotificationModel;
use App\Models\BookingStatusModel;
use App\Controllers\BaseController;
use App\Models\BookingPickupsModel;
use App\Models\CustomerBranchModel;
use App\Models\LoadingReceiptModel;
use App\Models\BookingExpensesModel;
use App\Models\ProformaInvoiceModel;
use App\Models\TripPausedReasonModel;
use App\Models\BookingVehicleLogModel;
use App\Models\BookingLoadingDocsModel;
use App\Models\BookingsTripUpdateModel;
use App\Models\BookingTransactionModel;
use App\Models\BookingUploadedPodModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\DriverVehicleAssignModel;
use App\Models\BookingUploadedKantaParchiModel;

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

    public $CityModel;

    public $user;
    public $profile;
    public $ExpenseHeadModel;
    public $EmployeeModel;
    public $BookingLinkModel;
    public $NModel;
    public $LoadingReceiptModel;
    public $BUPModel;
    public $DModel;
    public $BookingTransactionModel;
    public $BookingUploadedKantaParchiModel;
    public $TripPausedReasonModel;
    public $BookingsTripUpdateModel;
    public $DVLModel;
    public $ProformaInvoiceModel;
    public $email;
    public $MaterialsModel;
    
    public function __construct()
    {
        // date_default_timezone_set("Asia/Kolkata");
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
        $this->CityModel = new CityModel();
        $this->ExpenseHeadModel = new ExpenseHeadModel();
        $this->EmployeeModel = new EmployeeModel();
        $this->BookingLinkModel = new BookingLinkModel();
        $this->NModel = new NotificationModel();
        $this->LoadingReceiptModel = new LoadingReceiptModel();
        $this->BUPModel = new BookingUploadedPodModel();
        $this->DModel = new DriverModel();
        $this->BookingTransactionModel = new BookingTransactionModel();
        $this->BookingUploadedKantaParchiModel = new BookingUploadedKantaParchiModel();
        $this->TripPausedReasonModel = new TripPausedReasonModel();
        $this->BookingsTripUpdateModel = new BookingsTripUpdateModel();
        $this->DVLModel = new DriverVehicleAssignModel();
        $this->ProformaInvoiceModel = new ProformaInvoiceModel();
        $this->MaterialsModel = new MaterialsModel();

        $this->email = \Config\Services::email();
    }

    public function index()
    {
        $this->view['booking_numbers'] = $this->BModel->select('id,booking_number')->findAll();
        
        $query = "(SELECT vehicle.rc_number FROM booking_transactions bt join vehicle on vehicle.id = bt.vehicle_id  WHERE booking_status_id = 11 and booking_id = bookings.id group by bt.booking_id)";
        $this->BModel->select('bookings.*, party.party_name , 
         IF(bookings.status = 11,v2.rc_number, vehicle.rc_number) as rc_number,
          IF(bookings.status = 0, "Created", booking_status.status_name) as status_name,
          IF(bookings.status = 0, "bg-success", booking_status.status_bg) as status_bg,
          lr.id as lr_id,lr.status lr_Status,lr.approved lr_approved')
            ->join('customer', 'customer.id = bookings.customer_id', 'left')
            ->join('party', 'party.id = customer.party_id', 'left')
            ->join('vehicle', 'vehicle.id = bookings.vehicle_id', 'left')
            ->join('booking_status', 'booking_status.id = bookings.status', 'left')
            ->join('loading_receipts lr', 'bookings.id = lr.booking_id', 'left')
            ->join('booking_transactions bts', 'bookings.id = bts.booking_id and booking_status_id =11', 'left')
            ->join('vehicle v2', 'v2.id = bts.vehicle_id', 'left');

        if ($this->request->getPost('status') != '') {
            $this->BModel->where('bookings.status', $this->request->getPost('status'));
        } else if ($this->request->getGet('status')) {
            $this->BModel->where('bookings.status', $this->request->getGet('status'));
        } else {
            $this->BModel->whereNotIn('bookings.status', [11, 15]);
        }

        if ($this->request->getPost('customer_id') != '') {
            $this->BModel->where('bookings.customer_id', $this->request->getPost('customer_id'));
        }

        if ($this->request->getPost('vehicle_rc') != '') {
            if ($this->request->getPost('status') == 11) {
                $this->BModel->where('v2.id', $this->request->getPost('vehicle_rc'));
            } else {
                $this->BModel->where('bookings.vehicle_id', $this->request->getPost('vehicle_rc'));
            }
        }

        if ($this->request->getPost('booking_id') != '') {
            $this->BModel->where('bookings.id', $this->request->getPost('booking_id'));
        }

        $this->view['bookings'] = $this->BModel->orderBy('bookings.id', 'desc')->groupBy('bookings.id')->findAll();
        // echo count($this->view['bookings']).' '.$this->BModel->getLastQuery().'<pre>';print_r($this->view['bookings']);exit;

        $this->view['statuses'] = $this->BSModel->where('status_name !=', '')->findAll();
        $this->view['pickup'] = $this->BPModel;
        $this->view['drop'] = $this->BDModel;

        $this->view['vehicles'] = $this->getDriverAssignedVehicles();
        $this->view['customers'] = $this->getCustomers();
        return view('Booking/index', $this->view);
    }

    function getDriverAssignedVehicles()
    {
        return $this->VModel->select('vehicle.id, vehicle.rc_number, party.party_name')
            ->join('driver_vehicle_map', 'driver_vehicle_map.vehicle_id = vehicle.id', 'left')
            ->join('driver', 'driver.id = driver_vehicle_map.driver_id', 'left')
            ->join('party', 'party.id = driver.party_id', 'left')
            ->where('(driver_vehicle_map.unassign_date = "" or driver_vehicle_map.unassign_date IS NULL or (UNIX_TIMESTAMP(driver_vehicle_map.unassign_date) = 0))')
            ->where('vehicle.status', 1)->groupBy('vehicle.id')->findAll();
    }
    function getCustomers()
    {
        //Get only that customers which party sale is yes
        $party_type_ids = $this->PTModel->select("(GROUP_CONCAT(id)) party_type_ids")
            ->where('sale', '1')
            ->first();
        $party_type_ids = str_replace([',', ', '], '|', $party_type_ids);

        return $this->CModel->select('customer.*, party.party_name')
            ->join('party', 'party.id = customer.party_id')
            ->where('customer.status', '1')
            ->where('CONCAT(",", party_type_id, ",") REGEXP ",(' . $party_type_ids['party_type_ids'] . '),"')
            ->findAll();
    }

    public function create()
    {
        $this->view['booking_for'] = $this->MaterialsModel->where(['status'=>1,'isDeleted' =>0])->findAll();
        if ($this->request->getPost()) {
            $post = $this->request->getPost();
            if (isset($post['office_id'])) {
                $error = $this->validate([
                    'vehicle_type' =>  'required',
                    'office_id' =>  'required',
                    'customer_branch' =>  'required',
                    'customer_id' =>  'required',
                    'booking_by' =>  'required',
                    'booking_date' =>  'required',
                ]);

                if (!$error) {
                    $this->view['error']   = $this->validator;
                } else {
                    $profile =  $this->profile->where('logged_in_userid',  '1')->first(); //session()->get('id')
                    $last_booking = $this->BModel->orderBy('id', 'desc')->first();
                    $lastBooking = isset($last_booking['id']) ? ((int)$last_booking['id'] + 1) : 1;
                    $booking_number = isset($profile['booking_prefix']) && !empty($profile['booking_prefix']) ? $profile['booking_prefix'] . '/' . date('m') . '/000' . $lastBooking : 'BK/' . date('m') . '/000' . $lastBooking;

                    // save booking
                    $bookingData = [
                        'booking_number' => $booking_number,
                        'booking_for' => $this->request->getPost('booking_for'),
                        'office_id' => $this->request->getPost('office_id'),
                        'vehicle_type_id' => $this->request->getPost('vehicle_type'),
                        'vehicle_id' => $this->request->getPost('vehicle_rc'),
                        'customer_id' => $this->request->getPost('customer_id'),
                        'customer_branch' => $this->request->getPost('customer_branch'),
                        'booking_by' => $this->request->getPost('booking_by'),
                        'booking_date' => $this->request->getPost('booking_date'),
                        'booking_type' => $this->request->getPost('booking_type') ? $this->request->getPost('booking_type') : '',
                        'lr_first_party' => $this->request->getPost('lr_first_party')
                    ];

                    // echo ' <pre>';print_r($bookingData);
                    // exit;
                    $booking_id = $this->BModel->insert($bookingData) ? $this->BModel->getInsertID() : '0';
                    //assign vehicle
                    if ($this->request->getPost('vehicle_type') > 0  && $this->request->getPost('vehicle_rc') > 0) {
                        $this->assignVehicleBooking($booking_id, $this->request->getPost(), 0);
                    } else {
                        //update booking status 
                        $this->update_booking_status($booking_id, 0);
                    }

                    if (isset($post['next_or_generate_link']) && ($post['next_or_generate_link'] == 'next')) {
                        $this->view['booking_customer'] = $this->CModel->select('customer.*, party.party_name')
                            ->join('bookings b', 'customer.id = b.customer_id')
                            ->join('party', 'party.id = customer.party_id')
                            ->where('b.id', $booking_id)
                            ->first();
                        $this->view['booking_details'] = $this->BModel->where('id', $booking_id)->first();
                        $this->view['booking_vehicle_details'] = $this->VModel->where('id', $this->view['booking_details']['vehicle_id'])->first();
                        $this->view['booking_number'] = $booking_number;
                        $this->view['booking_type'] = $post['booking_type'];
                        $this->view['booking_id'] = $booking_id;

                        //get last drop vehicle location if selected vehicle 27-09-2024
                        if ($post['vehicle_rc'] > 0) {
                            //last trip end booking drop location
                            $this->view['last_booking_transaction'] = $this->getLastDropOfBooking($post['vehicle_rc']);
                        }
                    } elseif (isset($post['next_or_generate_link']) && ($post['next_or_generate_link'] == 'generate_link')) {
                        $token = md5(date('YMDHis'));

                        $generate_link_data = [
                            'token' => $token,
                            'booking_id' => $booking_id,
                            'gen_by' => isset($_SESSION['id']) ? $_SESSION['id'] : '0',
                            'gen_ip' => isset($_SERVER['REMOTE_ADDR'])  ? $_SERVER['REMOTE_ADDR'] : '',
                        ];
                        $this->BookingLinkModel->save($generate_link_data);
                        $this->session->setFlashdata('success', 'Booking link generated successfully');
                        return $this->response->redirect(base_url('bookinglinks'));
                    } else {
                        $this->session->setFlashdata('success', 'Booking Successfully Added');
                        return $this->response->redirect(base_url('booking'));
                    }
                }
            } else if (isset($post['booking_details']) && ($post['booking_details'] ==  'PTL' || $post['booking_details'] ==  'FTL')) {
                //validation for booking details
                $error = $this->validate([
                    'pickup_state_id' =>  'required',
                    'pickup_city' =>  'required',
                    'pickup_date' =>  'required',
                    'drop_state_id' =>  'required',
                    'drop_city' =>  'required',
                    'rate_type' =>  'required',
                    'rate' =>  'required',
                    'bill_to' =>  'required',
                ]);

                if (!$error) {
                    $this->view['error']   = $this->validator;
                } else {
                    $booking_id =  $this->request->getPost('id');
                    $bookingPTLData = [
                        'customer_type' => ($this->request->getPost('customer_type')) ? $this->request->getPost('customer_type') : 0,
                        'pickup_date' => $this->request->getPost('pickup_date'),
                        'drop_date' => $this->request->getPost('drop_date'),
                        'rate_type' => $this->request->getPost('rate_type'),
                        'rate' => $this->request->getPost('rate'),
                        'guranteed_wt' => $this->request->getPost('guranteed_wt'),
                        'freight' => $this->request->getPost('freight'),
                        'advance' => $this->request->getPost('advance'),
                        'balance' => $this->request->getPost('balance'),
                        'discount' => $this->request->getPost('discount'),
                        'bill_to_party' => $this->request->getPost('bill_to'),
                        'remarks' => $this->request->getPost('remarks'),
                        'status' => '1',
                        'added_by' => $this->added_by,
                        'added_ip' => $this->added_ip,
                        'other_expenses' => $this->request->getPost('other_expenses'),
                        // 'commission' => $this->request->getPost('commission'),
                    ];

                    $this->BModel->update($booking_id, $bookingPTLData);
                    //update booking status 
                    $this->update_booking_status($booking_id, 1);
                    // save pickups 
                    $this->BPModel->insert([
                        'booking_id' => $booking_id,
                        'sequence' => $this->request->getPost('pickup_seq'),
                        'city' => $this->request->getPost('pickup_city'),
                        'state' => $this->request->getPost('pickup_state_id'),
                        'pincode' => $this->request->getPost('pickup_pin'),
                        'city_id' => $this->request->getPost('pickup_city_id'),
                    ]);

                    // save drops
                    $this->BDModel->insert([
                        'booking_id' => $booking_id,
                        'sequence' => $this->request->getPost('drop_seq'),
                        'city' => $this->request->getPost('drop_city'),
                        'state' => $this->request->getPost('drop_state_id'),
                        'pincode' => $this->request->getPost('drop_pin'),
                        'city_id' => $this->request->getPost('drop_city_id'),
                    ]);


                    // save expenses
                    foreach ($this->request->getPost('expense') as $key => $val) {
                        if (($this->request->getPost('expense')[$key] > 0) || ($this->request->getPost('expense_value')[$key] > 0) || ($this->request->getPost('expense_flag_' . $key + 1) == 'on')) {
                            $this->BEModel->insert([
                                'booking_id' => $booking_id,
                                'expense' => $this->request->getPost('expense')[$key],
                                'value' => $this->request->getPost('expense_value')[$key],
                                'bill_to_party' => ($this->request->getPost('expense_flag_' . $key + 1) == 'on') ? '1' : '0'
                            ]);
                        }
                    }


                    $this->session->setFlashdata('success', 'Booking Successfully Added');

                    return $this->response->redirect(base_url('booking'));
                }
            } else {
                return $this->response->redirect(base_url('booking'));
            }
        }
        $this->view['party'] = $this->PModel->select('party.*')->join('party_type_party_map', 'party_type_party_map.party_id = party.id')
            ->whereIn('party_type_party_map.party_type_id', [1, 2, 5])->groupBy('party.id')->orderBy('party.party_name')->findAll();
        $this->view['offices'] = $this->OModel->where('status', '1')->findAll();
        $this->view['vehicle_types'] = $this->VTModel->where('status', 'Active')->findAll();
        $this->view['employees'] = $this->EmployeeModel->select('employee.id,employee.name')
            ->join('departments d', 'd.id= employee.dept_id')
            ->where(['d.booking' => 1, 'd.status' => 1, 'employee.status' => 1])
            ->findall();
        // echo  $this->EmployeeModel->getLastQuery().'<pre>';print_r($this->view['employees'] );exit; 
        $this->view['states'] =  $this->SModel->orderBy('state_name', 'asc')->findAll();
        $this->view['expense_heads'] =  $this->ExpenseHeadModel->orderBy('head_name', 'asc')->findAll();

        $party_type_ids = $this->PTModel->select("(GROUP_CONCAT(id)) party_type_ids")
            ->where('sale', '1')
            ->first();
        $party_type_ids = str_replace([',', ', '], '|', $party_type_ids);

        $this->view['customers'] = $this->CModel->select('customer.*, party.party_name')
            ->join('party', 'party.id = customer.party_id')
            ->where('customer.status', '1')
            ->where('CONCAT(",", party_type_id, ",") REGEXP ",(' . $party_type_ids['party_type_ids'] . '),"')
            ->findAll();

        // $db = \Config\Database::connect();  
        // echo  $db->getLastQuery()->getQuery();  

        return view('Booking/create', $this->view);
    }

    public function getCitiesByState()
    {
        $cities = $this->CityModel->where('state_id', $this->request->getPost('state_id'))->findAll();
        echo json_encode($cities);
        exit;
    }

    public function getPatyTypeDetails()
    {
        $party_type = $this->PTModel->where('id', $this->request->getPost('customer_id'))->first();
        echo $party_type['lr_first_party'];
        exit;
    }

    public function create_bk()
    {
        if ($this->request->getPost()) {
            $profile =  $this->profile->first(); //echo __LINE__.'<pre>';print_r($profile);die;
            $last_booking = $this->BModel->orderBy('id', 'desc')->first();
            $lastBooking = isset($last_booking['id']) ? ((int)$last_booking['id'] + 1) : 1;
            $booking_number = isset($profile['booking_prefix']) ? $profile['booking_prefix'] . '/' . $lastBooking : 'BK/' . $lastBooking;

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
            ]; //echo __LINE__.'<pre>';print_r($bookingData);die;
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
            $this->view['states'] =  $this->SModel->orderBy('state_name', 'asc')->findAll();

            $this->view['customers'] = $this->CModel->select('customer.*, party.party_name')
                ->join('party', 'party.id = customer.party_id')
                ->where('customer.status', '1')
                ->findAll();

            return view('Booking/create', $this->view);
        }
    }

    public function approve($id)
    {
        $this->view['booking_for'] = $this->MaterialsModel->where(['status'=>1,'isDeleted' =>0])->findAll();
        if ($this->request->getPost()) {

            // $isVehicle = $this->BModel->where('id', $id)->first()['vehicle_id'] > 0 ? true : false;
            // update Drops, Pickups and delete Expences 
            $booking_details =  $this->BModel->where('id', $id)->first();

            //if status is waitng for approval and vehicle assign then status is ready for trip
            if (($booking_details['status'] == 1 && $this->request->getPost('vehicle_rc') > 0) || ($this->request->getPost('vehicle_rc') > 0)) {
                $booking_status = 3;
            } else {
                $booking_status = ($this->request->getPost('approve')) ? 2 : 1;
            }

            //get last booking status before pause booking
            $last_booking_status_id = $this->BookingTransactionModel->where(['booking_id' => $id])->orderBy('id', 'desc')->findAll(1, 1);
            $last_booking_status = isset($last_booking_status_id[0]['booking_status_id']) && ($last_booking_status_id[0]['booking_status_id'] > 0) ? $last_booking_status_id[0]['booking_status_id'] : 0;
            $booking_status = ($last_booking_status > 3) ? $last_booking_status :  $booking_status;
            // echo '$booking_status = '.' / $last_booking_status = '.$last_booking_status;exit;
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
                // 'status' => $isVehicle ? '3' : '2',
                'status' => $booking_status,
                'approved_by' => $this->added_by,
                'approved_ip' => $this->added_ip,
                'approved_date' => date('Y-m-d h:i:s'),
                'approved' => $this->request->getPost('approve'),
                'rate' => $this->request->getPost('rate'),
                'other_expenses' => $this->request->getPost('other_expenses'),
            ]);

            //assign vehicle
            if ($this->request->getPost('vehicle_type') > 0  && $this->request->getPost('vehicle_rc') > 0 && ($booking_details['vehicle_id'] != $this->request->getPost('vehicle_rc'))) {
                $this->assignVehicleBooking($id, $this->request->getPost(), $booking_status);
            } else {
                //update booking status 
                $this->update_booking_status($id, $booking_status);
                //update PTL booking
                $this->update_PTLBookings($id, $booking_status, 0, 0, '', []);
            }
            // update Drops, Pickups and delete Expences 
            $this->BEModel->where('booking_id', $id)->delete();

            // save pickups
            $bpdata = [
                'sequence' => $this->request->getPost('pickup_seq'),
                'city' => $this->request->getPost('pickup_city'),
                'state' => $this->request->getPost('pickup_state_id'),
                'pincode' => $this->request->getPost('pickup_pin'),
                'city_id' => $this->request->getPost('pickup_city_id'),
            ];
            $this->BPModel->set($bpdata)->where('booking_id', $id)->update();

            // save drops 
            $bddata = [
                'sequence' => $this->request->getPost('drop_seq'),
                'city' => $this->request->getPost('drop_city'),
                'state' => $this->request->getPost('drop_state_id'),
                'pincode' => $this->request->getPost('drop_pin'),
                'city_id' => $this->request->getPost('drop_city_id'),
            ];
            $this->BDModel->set($bddata)->where('booking_id', $id)->update();

            // save expenses
            foreach ($this->request->getPost('expense') as $key => $val) {
                if (($this->request->getPost('expense')[$key] > 0) || ($this->request->getPost('expense_value')[$key] > 0) || ($this->request->getPost('expense_flag_' . $key + 1) == 'on')) {
                    $expense_data = [
                        'booking_id' => $id,
                        'expense' => $this->request->getPost('expense')[$key],
                        'value' => $this->request->getPost('expense_value')[$key],
                        'bill_to_party' => ($this->request->getPost('expense_flag_' . $key + 1) == 'on') ? '1' : '0'
                    ];
                    $this->BEModel->insert($expense_data);
                }
            }

            $this->session->setFlashdata('success', 'Booking Successfully Updated');

            return $this->response->redirect(base_url('booking'));
        }

        $this->view['party'] = $this->PModel->select('party.*')->join('party_type_party_map', 'party_type_party_map.party_id = party.id')
            ->whereIn('party_type_party_map.party_type_id', [1, 2, 5])->groupBy('party.id')->orderBy('party.party_name')->findAll();

        $this->view['offices'] = $this->OModel->where('status', '1')->findAll();

        $this->view['vehicle_types'] = $this->VTModel->where('status', 'Active')->findAll();
        $this->view['employees'] = $this->EmployeeModel->select('employee.id,employee.name')
            ->join('departments d', 'd.id= employee.dept_id')
            ->where(['d.booking' => 1, 'd.status' => 1, 'employee.status' => 1])
            ->findall();
        $this->view['states'] =  $this->SModel->orderBy('state_name', 'asc')->findAll();

        $this->view['customers'] = $this->CModel->select('customer.*, party.party_name')
            ->join('party', 'party.id = customer.party_id')
            ->where('customer.status', '1')
            ->findAll();

        //for booking data
        $this->view['booking_details'] = $this->BModel->where('id', $id)->first();
        $this->view['booking_vehicle_details'] = $this->VModel->where('id', $this->view['booking_details']['vehicle_id'])->first();
        $this->view['booking_pickups'] = $this->BPModel->where('booking_id', $id)->first();
        $this->view['booking_drops'] = $this->BDModel->where('booking_id', $id)->first();
        $this->view['booking_expences'] = $this->BEModel->where('booking_id', $id)->findAll();
        // $this->view['vehicle_rcs'] = $this->VModel->where('status', 'active')->findAll();
        //$this->view['vehicle_rcs'] =  $this->VModel->where('vehicle_type_id', $this->view['booking_details']['vehicle_type_id'] )->where('status', '1')->where('working_status', '1')->findAll();
        $this->view['vehicle_rcs'] =  [];
        //city drop down changes 
        $this->view['pickup_cities'] = isset($this->view['booking_pickups']) ? $this->CityModel->where('state_id', $this->view['booking_pickups']['state'])->findAll() : [];
        $this->view['drop_cities'] = isset($this->view['booking_drops']) ? $this->CityModel->where('state_id', $this->view['booking_drops']['state'])->findAll() : [];

        $this->view['selected_pickup_city'] = isset($this->view['booking_pickups']) ? $this->view['booking_pickups']['city'] : '';
        $this->view['selected_drop_city'] = isset($this->view['booking_drops']) ? $this->view['booking_drops']['city'] : '';

        $this->view['pickup_cities']  = array_column($this->view['pickup_cities'], 'city', 'id');
        $this->view['drop_cities']  = array_column($this->view['drop_cities'], 'city', 'id');
        if (isset($this->view['booking_pickups']) && !empty($this->view['booking_pickups']['city'])) {
            if (!in_array($this->view['booking_pickups']['city'], $this->view['pickup_cities'])) {
                array_push($this->view['pickup_cities'], $this->view['booking_pickups']['city']);
            }
        }

        if (isset($this->view['booking_drops']) && !empty($this->view['booking_drops']['city'])) {
            if (!in_array($this->view['booking_drops']['city'], $this->view['drop_cities'])) {
                array_push($this->view['drop_cities'], $this->view['booking_drops']['city']);
            }
        }
        $this->view['token'] = $id;
        $this->view['expense_heads'] =  $this->ExpenseHeadModel->orderBy('head_name', 'asc')->findAll();

        //get last drop vehicle location if selected vehicle 27-09-2024
        if ($this->view['booking_details']['vehicle_id'] > 0) {
            //last trip end booking drop location
            $this->view['last_booking_transaction'] = $this->getLastDropOfBooking($this->view['booking_details']['vehicle_id'], $id);
        }

        return view('Booking/approve', $this->view);
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
        $this->view['expense_heads'] =  $this->ExpenseHeadModel->orderBy('head_name', 'asc')->findAll();
        echo view('Booking/expense_block', $this->view);
    }

    public function getCustomerType()
    {
        $customer = $this->CModel->where('id', $this->request->getPost('customer_id'))->first();
        $current_booking = $this->BModel->select('id,customer_type')->where('id', $this->request->getPost('booking_id'))->first();
        $customer_type = isset($current_booking['customer_type']) ? $current_booking['customer_type'] : 0;
        $html = '';

        if ($customer) {
            $customer_party_type = explode(',', $customer['party_type_id']);

            $rows = $this->PTModel->whereIn('id', $customer_party_type)->where('sale', '1')->findAll();
            if (count($rows) > 0) {
                foreach ($rows as $row) {
                    $selected = ($customer_type == $row['id']) ? 'selected' : '';
                    $html .= '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['name'] . '</option>';
                }
            }
        }

        return $html;
    }

    public function getCustomerBranch()
    {
        $current_booking = $this->BModel->select('id,customer_branch')->where('id', $this->request->getPost('booking_id'))->first();
        $customer_branch = isset($current_booking['customer_branch']) ? $current_booking['customer_branch'] : 0;
        // echo '$customer_branch '.$customer_branch;exit;
        $html = '';
        $rows = $this->CBModel->where('customer_id', $this->request->getPost('customer_id'))->findAll();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $selected = ($customer_branch == $row['id']) ? 'selected' : '';
                $html .= '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['office_name'] . '</option>';
            }
        }
        return $html;
    }

    public function getVehicles()
    {
        $rows =  $this->VModel->where('vehicle_type_id', $this->request->getPost('vehicle_type'))->where('status', '1')->where('working_status', '2')->findAll();

        $html = '<option value="">Select Vehicle</option>';
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $html .= '<option value="' . $row['id'] . '">' . $row['rc_number'] . '</option>';
            }
        }

        return $html;
    }

    public function getUnassignVehicles()
    {
        $current_booking = $this->BModel->select('id,booking_type,vehicle_id')->where('id', $this->request->getPost('booking_id'))->first();
        $booking_id = isset($current_booking['id']) ? $current_booking['id'] : 0;
        $vehicle_id = isset($current_booking['vehicle_id']) ? $current_booking['vehicle_id'] : 0;
        $isVehicle_type = $this->request->getPost('vehicle_type');
        //get unassigned vehicles  
        $unassigned_vehicles =  $this->VModel->select('vehicle.id, vehicle.rc_number, party.party_name,vehicle.vehicle_type_id')
            ->join('booking_vehicle_logs bvl', 'bvl.vehicle_id = vehicle.id', 'left')
            ->join('driver_vehicle_map', 'driver_vehicle_map.vehicle_id = vehicle.id')
            ->join('driver', 'driver.id = driver_vehicle_map.driver_id')
            ->join('party', 'party.id = driver.party_id', 'left')
            ->where('(driver_vehicle_map.unassign_date = "" or driver_vehicle_map.unassign_date IS NULL or (UNIX_TIMESTAMP(driver_vehicle_map.unassign_date) = 0)) ')
            ->where('vehicle.vehicle_type_id', $isVehicle_type)
            ->where('vehicle.status', '1')
            ->where('vehicle.working_status', '2')
            ->orWhere("(bvl.booking_id = '$booking_id' and vehicle.working_status = '3' and vehicle.vehicle_type_id = '$isVehicle_type' )")
            ->groupBy('vehicle.id')
            ->findAll();

        // $db = \Config\Database::connect();  
        // echo  $db->getLastQuery()->getQuery(); 
        // echo 'unassigned_vehicles <pre>';print_r($unassigned_vehicles);//exit;

        if (isset($current_booking['booking_type']) && ($current_booking['booking_type'] == 'PTL')) {
            //get assigned vehicles(working_status=2) but assigned booking type PTL
            $assigned_vehicles = $this->VModel->select('vehicle.id, vehicle.rc_number, party.party_name,b.id booking_id')
                ->join('booking_vehicle_logs bvl', 'bvl.vehicle_id = vehicle.id', 'left')
                ->join('bookings b', 'b.id = bvl.booking_id', 'left')
                ->where('vehicle.vehicle_type_id', $isVehicle_type)
                ->join('driver_vehicle_map', 'driver_vehicle_map.vehicle_id = vehicle.id')
                ->join('driver', 'driver.id = driver_vehicle_map.driver_id')
                ->join('party', 'party.id = driver.party_id', 'left')
                ->where('(driver_vehicle_map.unassign_date = "" or driver_vehicle_map.unassign_date IS NULL or (UNIX_TIMESTAMP(driver_vehicle_map.unassign_date) = 0))')
                ->where('vehicle.status', '1')
                ->where('vehicle.working_status', '3')
                ->where('b.booking_type', 'PTL')
                ->where('b.status <', '4')
                ->orWhere("(bvl.booking_id = '$booking_id' and vehicle.working_status = '3' and vehicle.vehicle_type_id = '$isVehicle_type' )")
                ->groupBy('vehicle.id')
                ->findAll();
            //  echo ' assigned_vehicles  <pre>';print_r($assigned_vehicles);exit;
            $rows = array_merge($unassigned_vehicles, $assigned_vehicles);
            if (!empty($assigned_vehicles)) {
                $temp = array_unique(array_column($rows, 'id'));
                $rows = array_intersect_key($rows, $temp);
            }
        } else {
            $rows = $unassigned_vehicles;
        }
        //   echo ' rows <pre>';print_r($rows);exit; 

        $html = '<option value="">Select Vehicle</option>';
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $party_name = isset($row['party_name']) ? ' - ' . $row['party_name'] : '';
                $html .= '<option value="' . $row['id'] . '" ' . ($vehicle_id == $row['id'] ? 'selected' : '') . '>' . $row['rc_number'] . $party_name . '</option>';
            }
        }

        return $html;
    }

    public function assign_vehicle($id)
    {

        //for booking data
        $this->view['booking_details'] = $this->BModel->where('id', $id)->first();

        $this->view['offices'] = $this->OModel->where('status', '1')->findAll();
        $this->view['vehicle_types'] = $this->VTModel->where('status', 'Active')->findAll();
        $this->view['customers'] = $this->CModel->select('customer.*, party.party_name')
            ->join('party', 'party.id = customer.party_id')
            ->where('customer.status', '1')
            ->findAll();
        $this->view['states'] =  $this->SModel->findAll();

        $this->view['booking_pickups'] = $this->BPModel->where('booking_id', $id)->findAll();
        $this->view['booking_drops'] = $this->BDModel->where('booking_id', $id)->findAll();
        $this->view['booking_expences'] = $this->BEModel->where('booking_id', $id)->findAll();
        $this->view['vehicle_rcs'] =  [];
        $this->view['expense_heads'] =  $this->ExpenseHeadModel->orderBy('head_name', 'asc')->findAll();

        //get last log i.e unassign_date = ''
        $this->view['booking_vehicle'] = $this->BVLModel->where('booking_id', $id)->where('(unassign_date IS NULL or UNIX_TIMESTAMP(unassign_date) = 0)')->first();
        //   echo '<pre>';print_r($this->view['booking_vehicle']);exit;    

        if ($this->request->getPost()) {
            $result = $this->assignVehicleBooking($id, $this->request->getPost(), -1);
            if ($result) {
                $this->session->setFlashdata('success', 'Vehicle Assigned To Booking');
            } else {
                $this->session->setFlashdata('danger', 'Some error occurred, Vehicle is not Assigned To Booking');
            }
            return $this->response->redirect(base_url('booking'));
        }

        return view('Booking/vehicle', $this->view);
    }

    public function getBookingVehicleDetails()
    {
        $bookings = $this->BVLModel->select('p.party_name,bp.city bpcity,bpstates.state_name bpstate,bp.pincode bppin,,bd.*,bdstates.state_name bdstate,b.booking_number')
            ->join('bookings b', 'b.id = booking_vehicle_logs.booking_id')
            ->join('customer c', 'c.id = b.customer_id', 'left')
            ->join('party p', 'p.id = c.party_id', 'left')
            ->join('booking_pickups bp', 'b.id = bp.booking_id', 'left')
            ->join('states bpstates', 'bp.state = bpstates.state_id', 'left')
            ->join('booking_drops bd', 'b.id = bd.booking_id', 'left')
            ->join('states bdstates', 'bd.state = bdstates.state_id', 'left')
            ->where('b.id !=', $this->request->getPost('booking_id'))
            ->where('booking_vehicle_logs.unassign_date is NULL')
            ->where('booking_vehicle_logs.vehicle_id', $this->request->getPost('vehicle_id'))
            ->where('b.status !=', 11)
            ->groupBy('b.id')
            ->findAll();
        echo json_encode($bookings);
        exit;
    }

    function assignVehicleBooking($id, $post, $booking_status = -1)
    {
        $current_booking = $this->BModel->select('id,status,booking_type,vehicle_id,customer_id,approved')->where('id', $id)->first();

        if ($booking_status < 0) {
            //IF ON VEHICLE ASSIGNED, BOOKING STATUS IS APPROVED (2) IT WILL CHANGE TO READY FOR TRIP (3)
            $booking_status = 3;
            // IF ON VEHICLE ASSIGNED, BOOKING STATUS IS GREATER THAN APPROVED (2) THEN IT WILL CHANGE TO 1
            if ($current_booking['status'] > 2) {
                $booking_status = 1;
            }

            if (($current_booking['status'] == 2) && ($current_booking['booking_type'] == 'PTL')) {
                $booking_status = 1;
            }

            //if booking status is one then after assign vehicle it remain same
            if ($current_booking['status'] == 1) {
                $booking_status = 1;
            }
        }

        $this->BModel->update($id, [
            'vehicle_id' => $post['vehicle_rc'],
            'vehicle_type_id' => $post['vehicle_type'],
            'status' => $booking_status,
            'is_vehicle_assigned' => 1
        ]);

        //if already assign vehicle to booking then change vehile status not assigned and vehicle log as unassign vehicle
        $result = $this->BVLModel->where('booking_id', $id)->where('(unassign_date IS NULL or UNIX_TIMESTAMP(unassign_date) = 0)')->first();
        //echo $this->BVLModel->getLastQuery().'<pre>';print_r($result);exit;
        if ($result) {
            //update old driver status
            $this->updateDriverWorkingStatus($result['vehicle_id'], 2);

            //update old vehicle status  
            $this->VModel->update($result['vehicle_id'], [
                'working_status' => '2'
            ]);
            $this->BVLModel->update($result['id'], ['unassign_date' => date('Y-m-d h:i:s'), 'unassigned_by' => $this->added_by]);
        }

        $this->BVLModel->insert([
            'booking_id' => $id,
            'vehicle_id' => $post['vehicle_rc'],
            'assign_by' => $this->added_by,
            'assign_date' => isset($post['assign_date']) && !empty($post['assign_date']) ? $post['assign_date'] : date('Y-m-d H:i:s'),
            'vehicle_location' => isset($post['vehicle_location']) ? $post['vehicle_location'] : '',
        ]);

        $result = $this->VModel->update($post['vehicle_rc'], [
            'working_status' => '3'
        ]);

        //update new driver status
        $this->updateDriverWorkingStatus($post['vehicle_rc'], 3);

        //update booking status 
        $this->update_booking_status($id, $booking_status);

        $this->update_PTLBookings($id, $booking_status, 0, 0, '', []);

        //Check if booking type is PTL and vehicle > 0, for booking_type and vehicle
        // If records exist then get parent_id ==0 and assign with new booking parent_id
        $bookingParentId = 0;
        if (($current_booking['booking_type'] == 'PTL') && $post['vehicle_rc'] > 0 && $current_booking['approved'] == 1) {
            $bookingParentId =  $this->getBookingParentId($current_booking['id'], $current_booking['booking_type'], $post['vehicle_rc']);
            $this->BModel->update($current_booking['id'], ['parent_id' => $bookingParentId]);
        }

        //update vevhicle status assigned as 2

        //Check if LR is generated then update flag
        $lrResult = $this->LoadingReceiptModel->where(['booking_id' => $id])->findAll();
        // echo '<pre>';print_r($lrResult);exit;
        if (!empty($lrResult)) {
            foreach ($lrResult as $val) {
                if (isset($val['id']) && ($val['id'] > 0)) {
                    $this->LoadingReceiptModel->update($val['id'], ['is_update_vehicle' => 1]);
                }
            }
        }
        return  $result;
    }

    function updateDriverWorkingStatus($vehicle_id, $working_status)
    {
        $driverVehicle = $this->DVLModel->where('vehicle_id', $vehicle_id)->where('(unassign_date="" or unassign_date IS NULL or UNIX_TIMESTAMP(unassign_date) = 0)')->first();
        // echo $working_status.' == '.$this->DVLModel->getLastQuery().'<pre>';print_r($driverVehicle);
        if (isset($driverVehicle['driver_id']) && ($driverVehicle['driver_id'] > 0)) {
            //update old driver working status  3- On trip to 2 assigned
            $this->DModel->update($driverVehicle['driver_id'], [
                'working_status' => $working_status
            ]);
            // echo $working_status.' == '.$this->DModel->getLastQuery();
        }
    }
    function validateBookingLr($id)
    {
        $current_booking = $this->BModel->select('status,booking_type,vehicle_id,customer_id')->where('id', $id)->first();
        // LR of booking is approved
        $bookingLr = $this->LoadingReceiptModel->select('id')->where(['booking_id' => $id, 'approved' => 1])->first();
        // echo $id.' $bookingLr <pre>';print_r($bookingLr);

        //get customer party type: LR details 
        $bookingPartyLR = $this->CModel->where('customer.id', $current_booking['customer_id'])->first();
        echo   $current_booking['customer_id'] . ' $bookingPartyLR <pre>';
        print_r($bookingPartyLR);
        $party_types = isset($bookingPartyLR['party_type_id']) && (!empty($bookingPartyLR['party_type_id'])) ? explode(',', $bookingPartyLR['party_type_id']) : [];
        //get only those customers whose sale = 1
        if (!empty($party_types)) {
            $party_type_ids = $this->PTModel
                ->whereIn('id', $party_types)
                ->where('(lr_first_party = 1 or lr_third_party =1)')
                ->findAll();
        }
        // echo  ' $party_type_ids <pre>';print_r($party_type_ids);

        if (!empty($bookingLr) && !empty($party_type_ids)) {
            return 1;
        } else {
            return 0;
        }
        return $booking_status;
    }
    public function cancel($id)
    {
        $booking_details =  $this->BModel->where('id', $id)->first();

        // echo '<pre>';
        // print_r($booking_details);

        //change status of driver and vehicle too 

        if ($booking_details['status'] >= 5) {
            if ($booking_details['status'] == 14) {
                $this->session->setFlashdata('danger', 'Booking approval is already send for Cancellation');
                return $this->response->redirect(base_url('booking'));
            } else {
                $this->session->setFlashdata('danger', 'Booking Cancellation Not Allowed As Trip Has Started');
                return $this->response->redirect(base_url('booking'));
            }
        } else {
            //send notfication 
            $this->sendNotification($booking_details);
            $this->BModel->update($id, ['status' => '14']);

            //update booking status 
            $this->update_booking_status($id, 14, 0, 0, $this->request->getPost('status_date'));

            //Unlink PTL Bookings
            $this->unlinkPTLBookings($id);

            $this->session->setFlashdata('success', 'Approval is send for Cancellation');
            return $this->response->redirect(base_url('booking'));
        }
    }

    function sendNotification($booking_details)
    {
        $this->NModel->save([
            'order_id' => $booking_details['id'],
            'user_id' => $_SESSION['id'],
            'message' => $booking_details['booking_number'] . ' order has been send approval for cancellation'
        ]);
    }

    public function edit($id, $token = '')
    {
        $this->view['booking_for'] = $this->MaterialsModel->where(['status'=>1,'isDeleted' =>0])->findAll();
        //Check booking link validation
        if ($token) {
            $id = base64_decode(str_replace(['-', '_'], ['+', '/'], $id));
            // echo $decode_id;exit;

            // validate token and validity
            $link_data = $this->BookingLinkModel->where('token', $token)->first();
            if ($link_data) {
                $dateProvided = $link_data['gen_date'];
                $dateProvidedTimestamp = strtotime($dateProvided) + (24 * 60 * 60);
                $currentDateTimestamp = time();
                if ($link_data['link_used'] != 0) {
                    $this->session->setFlashdata('danger', 'Your Booking details is already submitted,  Please Contact The Administrator');
                    return $this->response->redirect(base_url('bookinglinks'));
                } else if ($dateProvidedTimestamp < $currentDateTimestamp) {
                    $this->session->setFlashdata('danger', 'This Link Has Expired,  Please Contact The Administrator');
                    return $this->response->redirect(base_url('bookinglinks'));
                }
            } else {
                $this->session->setFlashdata('danger', 'Invalid Booking Link, Please Contact The Administrator');
                return $this->response->redirect(base_url('bookinglinks'));
            }
        }
        if ($this->request->getPost()) {
            $post = $this->request->getPost();
            // echo $id.$token.'<pre>';print_r($post);exit;     
            //validation for booking details
            $error = $this->validate([
                'pickup_state_id' =>  'required',
                'pickup_city' =>  'required',
                'pickup_date' =>  'required',
                'drop_state_id' =>  'required',
                'drop_city' =>  'required',
                'rate_type' =>  'required',
                'rate' =>  'required',
                'bill_to' =>  'required',
            ]);

            if (!$error) {
                // echo 'error <pre>';print_r($error);exit;
                $this->view['error']   = $this->validator;
            } else {

                // $id =  $this->request->getPost('id');
                // echo $id.$token.'<pre>';print_r($post); 

                $booking_details =  $this->BModel->where('id', $id)->first();
                $bookingData = [
                    'pickup_date' => $this->request->getPost('pickup_date'),
                    'drop_date' => $this->request->getPost('drop_date'),
                    'rate_type' => $this->request->getPost('rate_type'),
                    'rate' => $this->request->getPost('rate'),
                    'guranteed_wt' => $this->request->getPost('guranteed_wt'),
                    'freight' => $this->request->getPost('freight'),
                    'advance' => $this->request->getPost('advance'),
                    'balance' => $this->request->getPost('balance'),
                    'discount' => $this->request->getPost('discount'),
                    'bill_to_party' => $this->request->getPost('bill_to'),
                    'remarks' => $this->request->getPost('remarks'),
                    'added_by' => $this->added_by,
                    'added_ip' => $this->added_ip,
                    'booking_type' => $this->request->getPost('booking_type'),
                    'other_expenses' => $this->request->getPost('other_expenses'),
                    // 'commission' => $this->request->getPost('commission'),
                ]; //echo __LINE__.'<pre>';print_r($bookingData);die;

                //update status only when booking status is created i.e 0 
                //after edit booking, booking will goes for waiting for approval every time
                // if($booking_details['status'] == 0){
                $bookingData['status'] = 1;
                //update booking status 
                $this->update_booking_status($id, $bookingData['status']);
                // } 

                $this->BModel->update($id, $bookingData);

                // update Drops, Pickups and delete Expences 
                $this->BEModel->where('booking_id', $id)->delete();

                // save pickups
                $bpdata = [
                    'booking_id' => $id,
                    'sequence' => $this->request->getPost('pickup_seq'),
                    'city' => $this->request->getPost('pickup_city'),
                    'state' => $this->request->getPost('pickup_state_id'),
                    'pincode' => $this->request->getPost('pickup_pin'),
                    'city_id' => $this->request->getPost('pickup_city_id'),
                ];
                //if not exist then insert otherwise update
                $isbpdata = $this->BPModel->where('booking_id', $id)->first();
                if (empty($isbpdata)) {
                    $this->BPModel->insert($bpdata);
                } else {
                    $this->BPModel->set($bpdata)->where('id', $isbpdata['id'])->update();
                }
                // echo $id.$token.'<pre>';print_r($bpdata);exit;     
                // save drops 
                $bddata = [
                    'booking_id' => $id,
                    'sequence' => $this->request->getPost('drop_seq'),
                    'city' => $this->request->getPost('drop_city'),
                    'state' => $this->request->getPost('drop_state_id'),
                    'pincode' => $this->request->getPost('drop_pin'),
                    'city_id' => $this->request->getPost('drop_city_id'),
                ];

                $isbddata = $this->BDModel->where('booking_id', $id)->first();
                if (empty($isbddata)) {
                    $this->BDModel->insert($bddata);
                } else {
                    $this->BDModel->set($bddata)->where('id', $isbddata['id'])->update();
                }

                // save expenses
                foreach ($this->request->getPost('expense') as $key => $val) {
                    if (($this->request->getPost('expense')[$key] > 0) || ($this->request->getPost('expense_value')[$key] > 0) || ($this->request->getPost('expense_flag_' . $key + 1) == 'on')) {
                        $expense_data = [
                            'booking_id' => $id,
                            'expense' => $this->request->getPost('expense')[$key],
                            'value' => $this->request->getPost('expense_value')[$key],
                            'bill_to_party' => ($this->request->getPost('expense_flag_' . $key + 1) == 'on') ? '1' : '0'
                        ];
                        $this->BEModel->insert($expense_data);
                    }
                }

                if ($token) {
                    // discard link
                    $this->BookingLinkModel->set('link_used', '1')->where('token', $token)->update();
                    $this->session->setFlashdata('success', 'Booking Details Successfully Updated');
                    return $this->response->redirect(base_url('bookinglinks'));
                } else {
                    $this->session->setFlashdata('success', 'Booking Successfully Updated');
                    return $this->response->redirect(base_url('booking'));
                }
            }
        }
        $this->view['booking_link_token'] = $token;
        $this->view['token'] = $id;
        $this->view['booking_details'] = $this->BModel->where('id', $id)->first();
        $this->view['booking_vehicle_details'] = $this->VModel->where('id', $this->view['booking_details']['vehicle_id'])->first();

        $this->view['booking_pickups'] = $this->BPModel->where('booking_id', $id)->first();
        $this->view['booking_drops'] = $this->BDModel->where('booking_id', $id)->first();
        $this->view['booking_expences'] = $this->BEModel->where('booking_id', $id)->findAll();
        $this->view['states'] =  $this->SModel->orderBy('state_name', 'asc')->findAll();

        $this->view['pickup_cities'] = isset($this->view['booking_pickups']) ? $this->CityModel->where('state_id', $this->view['booking_pickups']['state'])->findAll() : [];
        $this->view['drop_cities'] = isset($this->view['booking_drops']) ? $this->CityModel->where('state_id', $this->view['booking_drops']['state'])->findAll() : [];

        $this->view['selected_pickup_city'] = isset($this->view['booking_pickups']) ? $this->view['booking_pickups']['city'] : '';
        $this->view['selected_drop_city'] = isset($this->view['booking_drops']) ? $this->view['booking_drops']['city'] : '';

        $this->view['pickup_cities']  = array_column($this->view['pickup_cities'], 'city', 'id');
        $this->view['drop_cities']  = array_column($this->view['drop_cities'], 'city', 'id');
        if (isset($this->view['booking_pickups']) && !empty($this->view['booking_pickups']['city'])) {
            if (!in_array($this->view['booking_pickups']['city'], $this->view['pickup_cities'])) {
                array_push($this->view['pickup_cities'], $this->view['booking_pickups']['city']);
            }
        }

        if (isset($this->view['booking_drops']) && !empty($this->view['booking_drops']['city'])) {
            if (!in_array($this->view['booking_drops']['city'], $this->view['drop_cities'])) {
                array_push($this->view['drop_cities'], $this->view['booking_drops']['city']);
            }
        }

        //get only those customers whose sale = 1
        $party_type_ids = $this->PTModel->select("(GROUP_CONCAT(id)) party_type_ids")
            ->where('sale', '1')
            ->first();
        $party_type_ids = str_replace([',', ', '], '|', $party_type_ids);

        $this->view['customers'] = $this->CModel->select('customer.*, party.party_name')
            ->join('party', 'party.id = customer.party_id')
            ->where('customer.status', '1')
            ->where('CONCAT(",", party_type_id, ",") REGEXP ",(' . $party_type_ids['party_type_ids'] . '),"')
            ->findAll();

        // $db = \Config\Database::connect();  
        // echo  $db->getLastQuery()->getQuery(); 
        // echo '  <pre>';print_r($this->view['customers'] );exit; 
        $this->view['expense_heads'] =  $this->ExpenseHeadModel->orderBy('head_name', 'asc')->findAll();
        $this->view['offices'] = $this->OModel->where('status', '1')->findAll();
        $this->view['vehicle_types'] = $this->VTModel->where('status', 'Active')->findAll();
        $this->view['employees'] = $this->EmployeeModel->select('employee.id,employee.name')
            ->join('departments d', 'd.id= employee.dept_id')
            ->where(['d.booking' => 1, 'd.status' => 1, 'employee.status' => 1])
            ->findall();
        // echo ' employees <pre>';print_r($this->view['employees'] );exit; 
        $this->view['vehicle_rcs'] = [];
        //get last drop vehicle location if selected vehicle 27-09-2024
        if ($this->view['booking_details']['vehicle_id'] > 0) {
            //last trip end booking drop location
            $this->view['last_booking_transaction'] = $this->getLastDropOfBooking($this->view['booking_details']['vehicle_id'], $id);
        }
        return view('Booking/edit', $this->view);
    }

    function getPTLBookings($id, $vehicle_id)
    {
        return $this->BVLModel->select('GROUP_CONCAT(p.party_name) ptl_customers,GROUP_CONCAT(b.booking_number) ptl_bokking_no, count(b.id) ptl_cnt')
            ->join('bookings b', 'b.id = booking_vehicle_logs.booking_id')
            ->join('customer c', 'c.id = b.customer_id', 'left')
            ->join('party p', 'p.id = c.party_id', 'left')
            ->where('b.id !=', $id)
            ->where('b.booking_type', 'PTL')
            ->where('booking_vehicle_logs.unassign_date is NULL')
            ->where('booking_vehicle_logs.vehicle_id', $vehicle_id)
            ->groupBy('booking_vehicle_logs.vehicle_id')
            ->first();
    }

    function getTotalPTLBookings($id, $vehicle_id)
    {
        return $this->BVLModel->select('ROUND(sum(b.guranteed_wt),2) total_charged_weight,ROUND(sum(b.freight),2) total_freight ')
            ->join('bookings b', 'b.id = booking_vehicle_logs.booking_id')
            ->where('booking_vehicle_logs.unassign_date is NULL')
            ->where('b.booking_type', 'PTL')
            ->where('booking_vehicle_logs.vehicle_id', $vehicle_id)
            ->groupBy('b.id')
            ->first();
    }

    function preview($id)
    {
        $this->view['token'] = $id;
        $this->view['booking_details'] = $this->BModel->select('bookings.*,cb.office_name,cb.city cb_city,e.name booking_by_name,vt.name vehicle_type_name,v.rc_number,p.party_name bill_to_party_name,party.party_name as customer,v.id v_id,party.contact_person,party.primary_phone')
            ->join('vehicle v', 'v.id = bookings.vehicle_id', 'left')
            ->join('vehicle_type vt', 'vt.id = bookings.vehicle_type_id', 'left')
            ->join('employee e', 'e.id = bookings.booking_by', 'left')
            ->join('customer_branches cb', 'cb.id = bookings.customer_branch', 'left')
            ->join('customer c', 'c.id = bookings.bill_to_party', 'left')
            ->join('party p', 'p.id = c.party_id', 'left')
            ->join('customer cust', 'cust.id = bookings.customer_id', 'left')
            ->join('party', 'party.id = cust.party_id', 'left')
            ->where('bookings.id', $id)->first();
        // echo '  <pre>';print_r($this->view['booking_details'] );exit;  

        $this->view['booking_pickups'] = $this->BPModel->where('booking_id', $id)->first();
        $this->view['booking_drops'] = $this->BDModel->where('booking_id', $id)->first();
        $pickup_state = isset($this->view['booking_pickups']['state']) ? $this->view['booking_pickups']['state'] : 0;
        $drop_state = isset($this->view['booking_drops']['state']) ? $this->view['booking_drops']['state'] : 0;
        $this->view['booking_pickups_state'] = ($pickup_state > 0) ? $this->SModel->where('state_id', $pickup_state)->first() : [];
        $this->view['booking_drops_state'] =  ($drop_state > 0) ? $this->SModel->where('state_id', $drop_state)->first() : [];

        $this->view['booking_expences'] = $this->BEModel->select('eh.id eh_id,eh.*,booking_expenses.*')
            ->join('expense_heads eh', 'eh.id= booking_expenses.expense')
            ->where('booking_expenses.booking_id', $id)->findAll();


        $this->view['driver'] = [];
        $this->view['getPTLBookings'] = [];
        $vehicle_id = isset($this->view['booking_details']['v_id']) && ($this->view['booking_details']['v_id'] > 0) ? $this->view['booking_details']['v_id'] : 0;
        if ($vehicle_id > 0) {
            $this->view['driver'] = $this->DModel->select('driver.id, party.party_name as driver_name,party.primary_phone')
                ->join('driver_vehicle_map dvp', 'driver.id = dvp.driver_id')
                ->join('party', 'party.id = driver.party_id')
                ->where('(dvp.unassign_date = "" or dvp.unassign_date IS NULL or (UNIX_TIMESTAMP(dvp.unassign_date) = 0))')
                ->where('dvp.vehicle_id', $vehicle_id)
                ->first();

            if ($this->view['booking_details']['booking_type'] == 'PTL') {
                $this->view['ptl_bookings'] = $this->getPTLBookings($id, $vehicle_id);
                $this->view['booking_total'] = $this->getTotalPTLBookings($id, $vehicle_id);
            }

            // echo '  <pre>';print_r($this->view['ptl_bookings']);exit;
            // echo '  <pre>';print_r($this->view['booking_total']);exit;
        }

        // $db = \Config\Database::connect();  
        // echo  $db->getLastQuery()->getQuery(); 
        // echo '  <pre>';print_r($this->view['driver'] );exit; 


        if ($this->request->getGet('print') > 0) {

            // ========= for pdf download ==================================================================== 
            set_time_limit(0);
            ini_set('memory_limit', '-1');
            ob_clean();

            $html = view('Booking/preview_pdf', $this->view);

            // echo $html;die;

            $mpdf = new \Mpdf\Mpdf(['orientation' => 'L', 'format' => 'A4']);

            $mpdf->WriteHTML($html);
            // $mpdf->WriteHTML('Hello world');

            // Output a PDF file directly to the browser
            $this->response->setHeader('Content-Type', 'application/pdf');
            $mpdf->Output('booking-report.pdf', 'I');
            die;
            $mpdf->Output('public\uploads\booking-mail.pdf', 'F'); // for downloading in project folder

            // ========= for mail ==================================================================== 

            $config['protocol'] = 'smtp';
            $config['SMTPHost'] = 'gator3099.hostgator.com';
            $config['SMTPPort'] = 465;
            $config['SMTPUser'] = 'booking@gaegroup.in';
            $config['SMTPPass'] = 'August@110321';
            $config['charset']   = 'utf-8';
            $config['mailType']  = 'html';
            $config['newline']   = "\r\n";

            $this->email->initialize($config);

            $this->email->setFrom('booking@gaegroup.in', 'GAE Group');
            $this->email->setTo('kishorejha.php@gmail.com');
            // $this->email->setCC('cc@example.com');
            // $this->email->setBCC('bcc@example.com');

            $this->email->setSubject('LR Test With Attachment');
            $this->email->setMessage('Hello from the other side..!!!');

            $pdf_path = FCPATH . 'public\uploads\booking-mail.pdf';
            //$this->email->attach($pdf_path, 'pdf_file.pdf', 'application/pdf');

            if ($this->email->send()) {
                echo 'Email sent successfully';
            } else {
                echo 'Error sending email: ' . $this->email->printDebugger();
            }
        } else {
            return view('Booking/preview', $this->view);
        }
    }

    public function approval_for_cancellation($id)
    {
        $this->view['booking_for'] = $this->MaterialsModel->where(['status'=>1,'isDeleted' =>0])->findAll();
        $booking_details =  $this->BModel->where('id', $id)->first();
        if (isset($booking_details['status']) && $booking_details['status'] != 14) {
            $this->session->setFlashdata('danger', 'Booking is not send for cancellation approval');
            return $this->response->redirect(base_url('booking'));
        }
        if ($this->request->getPost()) {
            // echo '<pre>';print_r( $this->request->getPost()); 
            // update booking
            $data['guranteed_wt'] = $this->request->getPost('guranteed_wt');
            $data['freight'] = $this->request->getPost('freight');
            $data['advance'] = $this->request->getPost('advance');
            $data['balance'] = $this->request->getPost('balance');
            $data['discount'] = $this->request->getPost('discount');
            if ($this->request->getPost('approval_for_cancellation')) {
                $data['status'] = $this->request->getPost('approval_for_cancellation');
            }
            if ($this->request->getPost('approval_for_cancellation') == 15) {
                $data['is_vehicle_assigned'] = 0;
                $data['vehicle_id'] = 0;
            }
            $data['other_expenses'] = $this->request->getPost('other_expenses');
            // echo '<pre>';print_r( $data);exit; 
            $this->BModel->update($id, $data);

            // update Drops, Pickups and delete Expences 
            $this->BEModel->where('booking_id', $id)->delete();

            // save expenses
            foreach ($this->request->getPost('expense') as $key => $val) {
                if (($this->request->getPost('expense')[$key] > 0) || ($this->request->getPost('expense_value')[$key] > 0) || ($this->request->getPost('expense_flag_' . $key + 1) == 'on')) {
                    $expense_data = [
                        'booking_id' => $id,
                        'expense' => $this->request->getPost('expense')[$key],
                        'value' => $this->request->getPost('expense_value')[$key],
                        'bill_to_party' => ($this->request->getPost('expense_flag_' . $key + 1) == 'on') ? '1' : '0'
                    ];
                    $this->BEModel->insert($expense_data);
                }
            }
            if ($this->request->getPost('approval_for_cancellation') == 15) {
                //Change vehile status not assigned and vehicle log as unassign vehicle
                $result = $this->BVLModel->where('booking_id', $id)->where('(unassign_date IS NULL or UNIX_TIMESTAMP(unassign_date) = 0)')->first();
                if ($result) {
                    //Driver working status change to assigned
                    $this->updateDriverWorkingStatus($result['vehicle_id'], 2);
                    //update old vehicle status  
                    $this->VModel->update($result['vehicle_id'], [
                        'working_status' => 2
                    ]);
                    $this->BVLModel->update($result['id'], ['unassign_date' => date('Y-m-d H:i:s'), 'unassigned_by' => $this->added_by]);
                }

                //update LR as cancel
                $lrresult = $this->LoadingReceiptModel->where('booking_id', $id)->first();
                if ($lrresult) {
                    $this->LoadingReceiptModel->set(['status' => 2])->where('booking_id', $id)->update();
                }

                $this->session->setFlashdata('success', 'Booking is approved for cancellation Successfully');
            } else if ($this->request->getPost('approval_for_cancellation') == 2) {
                $this->session->setFlashdata('success', 'Revert to approve Successfully');
            } else {
                $this->session->setFlashdata('success', 'Booking is updated');
            }
            //update booking status 
            if ($this->request->getPost('approval_for_cancellation')) {
                $this->update_booking_status($id, $this->request->getPost('approval_for_cancellation'));
            }

            return $this->response->redirect(base_url('booking'));
        }

        $this->view['party'] = $this->PModel->select('party.*')->join('party_type_party_map', 'party_type_party_map.party_id = party.id')
            ->whereIn('party_type_party_map.party_type_id', [1, 2, 5])->groupBy('party.id')->orderBy('party.party_name')->findAll();

        $this->view['offices'] = $this->OModel->where('status', '1')->findAll();

        $this->view['vehicle_types'] = $this->VTModel->where('status', 'Active')->findAll();
        $this->view['employees'] = $this->EmployeeModel->select('employee.id,employee.name')
            ->join('departments d', 'd.id= employee.dept_id')
            ->where(['d.booking' => 1, 'd.status' => 1, 'employee.status' => 1])
            ->findall();
        $this->view['states'] =  $this->SModel->orderBy('state_name', 'asc')->findAll();

        $this->view['customers'] = $this->CModel->select('customer.*, party.party_name')
            ->join('party', 'party.id = customer.party_id')
            ->where('customer.status', '1')
            ->findAll();

        //for booking data
        $this->view['booking_details'] = $this->BModel->where('id', $id)->first();
        $this->view['booking_pickups'] = $this->BPModel->where('booking_id', $id)->first();
        $this->view['booking_drops'] = $this->BDModel->where('booking_id', $id)->first();
        $this->view['booking_expences'] = $this->BEModel->where('booking_id', $id)->findAll();
        // $this->view['vehicle_rcs'] = $this->VModel->where('status', 'active')->findAll();
        $this->view['vehicle_rcs'] =  $this->VModel->where('vehicle_type_id', $this->view['booking_details']['vehicle_type_id'])->where('status', '1')->where('working_status', '2')->findAll();

        //city drop down changes 
        $this->view['pickup_cities'] = isset($this->view['booking_pickups']) ? $this->CityModel->where('state_id', $this->view['booking_pickups']['state'])->findAll() : [];
        $this->view['drop_cities'] = isset($this->view['booking_drops']) ? $this->CityModel->where('state_id', $this->view['booking_drops']['state'])->findAll() : [];

        $this->view['selected_pickup_city'] = isset($this->view['booking_pickups']) ? $this->view['booking_pickups']['city'] : '';
        $this->view['selected_drop_city'] = isset($this->view['booking_drops']) ? $this->view['booking_drops']['city'] : '';

        $this->view['pickup_cities']  = array_column($this->view['pickup_cities'], 'city', 'id');
        $this->view['drop_cities']  = array_column($this->view['drop_cities'], 'city', 'id');
        if (isset($this->view['booking_pickups']) && !empty($this->view['booking_pickups']['city'])) {
            if (!in_array($this->view['booking_pickups']['city'], $this->view['pickup_cities'])) {
                array_push($this->view['pickup_cities'], $this->view['booking_pickups']['city']);
            }
        }

        if (isset($this->view['booking_drops']) && !empty($this->view['booking_drops']['city'])) {
            if (!in_array($this->view['booking_drops']['city'], $this->view['drop_cities'])) {
                array_push($this->view['drop_cities'], $this->view['booking_drops']['city']);
            }
        }
        $this->view['token'] = $id;
        $this->view['expense_heads'] =  $this->ExpenseHeadModel->orderBy('head_name', 'asc')->findAll();
        return view('Booking/approval_for_cancellation', $this->view);
    }

    function unlinkPTLBookings($id)
    {
        //Check If current booking is parent or child
        $booking_details = $this->BModel->where('id', $id)->first();
        if ($booking_details) {
            $parent_id = isset($booking_details['parent_id']) && ($booking_details['parent_id'] > 0) ? $booking_details['parent_id'] : 0;
            echo $parent_id;
            if ($parent_id > 0) {
                //child booking - only unlink current booking
                $this->BModel->update($booking_details['id'], ['parent_id' => 0]);
            } else {
                //parent booking              
                //unlink all child bookings i.e get all child and set parent_id = 0
                $childBookings = $this->BModel->select('id')->where('parent_id', $booking_details['id'])->findAll();
                // echo 'childBookings <pre>';print_r($childBookings);exit;
                if ($childBookings) {
                    foreach ($childBookings as $childBooking) {
                        $this->BModel->update($childBooking['id'], ['parent_id' => 0]);
                    }
                }
            }
        }
    }
    public function unassign_vehicle($id)
    {
        //for booking data
        $this->view['booking_details'] = $this->BModel->where('id', $id)->first();

        // Check if booking assign to a vehicle
        if ($this->view['booking_details']['is_vehicle_assigned'] != 1) {
            $this->session->setFlashdata('danger', 'Booking not assign to any vehicle');
            return $this->response->redirect(base_url('booking'));
        }

        $this->view['offices'] = $this->OModel->where('status', '1')->findAll();
        $this->view['vehicle_types'] = $this->VTModel->where('status', 'Active')->findAll();
        $this->view['customers'] = $this->CModel->select('customer.*, party.party_name')
            ->join('party', 'party.id = customer.party_id')
            ->where('customer.status', '1')
            ->findAll();
        $this->view['states'] =  $this->SModel->findAll();

        $this->view['booking_pickups'] = $this->BPModel->where('booking_id', $id)->findAll();
        $this->view['booking_drops'] = $this->BDModel->where('booking_id', $id)->findAll();
        $this->view['booking_expences'] = $this->BEModel->where('booking_id', $id)->findAll();

        $this->view['vehicle_rcs'] = $this->VModel->select('vehicle.id, vehicle.rc_number, party.party_name')
            ->join('driver_vehicle_map', 'driver_vehicle_map.vehicle_id = vehicle.id', 'left')
            ->join('driver', 'driver.id = driver_vehicle_map.driver_id', 'left')
            ->join('party', 'party.id = driver.party_id', 'left')
            ->where('(driver_vehicle_map.unassign_date = "" or driver_vehicle_map.unassign_date IS NULL or (UNIX_TIMESTAMP(driver_vehicle_map.unassign_date) = 0))')
            ->where('vehicle_type_id', $this->view['booking_details']['vehicle_type_id'])
            ->where('vehicle.status', 1)->where('vehicle.working_status', '2')->groupBy('vehicle.id')->findAll();

        $this->view['expense_heads'] =  $this->ExpenseHeadModel->orderBy('head_name', 'asc')->findAll();
        //get last log i.e unassign_date = ''
        $this->view['booking_vehicle'] = $this->BVLModel->where('booking_id', $id)->where('(unassign_date IS NULL or (UNIX_TIMESTAMP(unassign_date) = 0))')->first();
        // echo '<pre>';print_r($this->view['booking_vehicle']);exit;
        if ($this->request->getPost()) {
            $current_booking = $this->BModel->select('status,booking_type,vehicle_id,approved')->where('id', $id)->first();
            //update driver working status
            $this->updateDriverWorkingStatus($current_booking['vehicle_id'], 2);

            //update vevhicle status unassigned as 1
            $this->VModel->update($current_booking['vehicle_id'], [
                'working_status' => '2'
            ]);


            $booking_status = 2;

            //if current booking status is waiting for approval then after unassign the status remains same
            //if current booking status is 3 and booking not approved then status will 1
            if ($current_booking['status'] == 1 || ($current_booking['status'] == 3 && $current_booking['approved'] == 0)) {
                $booking_status = 1;
            }


            //if current status is > than 3 then status is paused 8
            if ($current_booking['status'] > 3) {
                $booking_status = 8;
            }

            $this->BModel->update($id, [
                // 'vehicle_id' => $this->request->getPost('vehicle_rc'),
                // 'vehicle_type_id' => $this->request->getPost('vehicle_type'),
                'status' => $booking_status,
                'is_vehicle_assigned' => 0,
                'vehicle_id' => 0
            ]);

            //Change vehile status not assigned and vehicle log as unassign vehicle
            $result = $this->BVLModel->where('booking_id', $id)->where('(unassign_date IS NULL or (UNIX_TIMESTAMP(unassign_date) = 0))')->first();
            if ($result) {
                //update driver working status
                $this->updateDriverWorkingStatus($current_booking['vehicle_id'], 2);

                //update old vehicle status  
                $this->VModel->update($result['vehicle_id'], [
                    'working_status' => '2'
                ]);
                $this->BVLModel->update($result['id'], ['unassign_date' => $this->request->getPost('unassign_date'), 'unassigned_by' => $this->added_by]);
            }

            //update booking status 
            $this->update_booking_status($id, $booking_status);

            //Unlink PTL Bookings
            $this->unlinkPTLBookings($id);
            $this->session->setFlashdata('success', 'Vehicle is Unassigned To Booking');

            return $this->response->redirect(base_url('booking'));
        }

        return view('Booking/unassign_vehicle', $this->view);
    }


    function upload_pod($booking_id)
    {
        $this->view['token'] = $booking_id;
        if ($this->request->getPost()) {
            // echo '<pre>';print_r($this->request->getPost());exit;  
            if ($this->request->getPost('is_upload_pod') == 1) {
                $this->validate([
                    'pod_date' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The pod date field is required'
                        ],
                    ],
                    'received_by' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The received by field is required'
                        ],
                    ],
                    'upload_doc' => [
                        'rules' => 'uploaded[upload_doc]|mime_in[upload_doc,image/png,image/PNG,image/jpg,image/jpeg,image/JPEG,application/pdf]',
                        'errors' => [
                            'mime_in' => 'Image must be in jpeg/png/pdf format'
                        ]
                    ]
                ]);
            } else {
                $this->validate([
                    'remarks' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The remarks field is required'
                        ],
                    ],
                ]);
            }

            $validation = \Config\Services::validation();
            if (!empty($validation->getErrors())) {
                $this->view['error'] = $this->validator;
            } else {
                // echo '$result<pre>';print_r($this->request->getPost());//exit;
                $result = $this->BUPModel->where('booking_id', $booking_id)->where('status', 1)->first();
                // echo '$result<pre>';print_r($result);exit;
                if ($result) {
                    // $this->BUPModel->update($result['id'], [ 
                    //     'status' => 0
                    // ]);
                }

                $image = $this->request->getFile('upload_doc');

                $image_name = '';
                if (isset($image)) {
                    if ($image->isValid() && !$image->hasMoved()) {
                        $image_name = $image->getRandomName();
                        $imgpath = 'public/uploads/booking_pods';
                        if (!is_dir($imgpath)) {
                            mkdir($imgpath, 0777, true);
                        }
                        $image->move($imgpath, $image_name);
                    }
                }
                // echo $image_name.' = image_name <pre>';print_r($this->request->getFile('upload_doc'));
                // exit;
                $data['booking_id'] = $booking_id;
                $data['remarks'] = $this->request->getPost('remarks');
                $data['created_by'] = $this->added_by;
                $data['is_upload_pod'] = $this->request->getPost('is_upload_pod');

                if ($this->request->getPost('is_upload_pod') == 1) {
                    $data['upload_doc'] = $image_name;
                    $data['received_by'] = $this->request->getPost('received_by');
                    $data['pod_date'] = $this->request->getPost('pod_date');
                }
                //  echo '$data<pre>';print_r($data);exit;
                $this->BUPModel->save($data);

                //update booking status 10 - uploaded 
                $this->BModel->update($booking_id, [
                    'guranteed_wt' => $this->request->getPost('guranteed_wt'),
                    'freight' => $this->request->getPost('freight'),
                    'advance' => $this->request->getPost('advance'),
                    'discount' => $this->request->getPost('discount'),
                    'balance' => $this->request->getPost('balance'),
                    'status' => 10,
                    'other_expenses' => $this->request->getPost('other_expenses'),
                ]);

                // update Drops, Pickups and delete Expences 
                $this->BEModel->where('booking_id', $booking_id)->delete();

                // save expenses
                foreach ($this->request->getPost('expense') as $key => $val) {
                    if (($this->request->getPost('expense')[$key] > 0) || ($this->request->getPost('expense_value')[$key] > 0) || ($this->request->getPost('expense_flag_' . $key + 1) == 'on')) {
                        $expense_data = [
                            'booking_id' => $booking_id,
                            'expense' => $this->request->getPost('expense')[$key],
                            'value' => $this->request->getPost('expense_value')[$key],
                            'bill_to_party' => ($this->request->getPost('expense_flag_' . $key + 1) == 'on') ? '1' : '0'
                        ];
                        $this->BEModel->insert($expense_data);
                    }
                }

                //update booking status 
                $this->update_booking_status($booking_id, 10);
                $this->update_PTLBookings($booking_id, 10);
                $this->session->setFlashdata('success', 'Uploaded pod Successfully');
                return $this->response->redirect(base_url('booking'));
            }
        }
        $this->view['booking_details'] = $this->BModel->where('id', $booking_id)->first();
        $this->view['booking_expences'] = $this->BEModel->where('booking_id', $booking_id)->findAll();
        $this->view['expense_heads'] =  $this->ExpenseHeadModel->orderBy('head_name', 'asc')->findAll();
        return view('Booking/upload_pod', $this->view);
    }

    function free_vehivle($id)
    {
        //Change vehile status not assigned and vehicle log as unassign vehicle
        $result = $this->BVLModel->where('booking_id', $id)->where('(unassign_date IS NULL or ((UNIX_TIMESTAMP(unassign_date)) = 0))')->first();
        // $db = \Config\Database::connect();  
        // echo  $db->getLastQuery()->getQuery(); 
        // echo $id.' $result<pre>';print_r($result);exit;
        // echo '$result<pre>';print_r($result);exit;
        if ($result) {
            //update driver working status
            $this->updateDriverWorkingStatus($result['vehicle_id'], 2);

            //update old vehicle status  
            $this->VModel->update($result['vehicle_id'], [
                'working_status' => '2'
            ]);
            $this->BVLModel->update($result['id'], ['unassign_date' => date('Y-m-d'), 'unassigned_by' => $this->added_by]);
        }
    }

    function approval_for_pod($booking_id)
    {
        if ($this->request->getPost()) {
            // echo '$result<pre>';print_r($this->request->getPost());//exit;       
            $error = $this->validate([
                'trip_end_approved' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'The trip end approved field is required'
                    ],
                ]
            ]);

            if (!$error) {
                $this->view['error'] = $this->validator;
            } else {
                //19-09-2024
                //Check proforma invoice is generated or not, if generated then only allow to approve for trip end
                if ($this->request->getPost('trip_end_approved') && $this->request->getPost('trip_end_approved')  == 1) {
                    $isProformaInvoice = $this->ProformaInvoiceModel->where('booking_id', $booking_id)->first();
                    // echo '<pre>';print_r($isProformaInvoice);exit;
                    if (empty($isProformaInvoice)) {
                        $this->session->setFlashdata('danger', 'Proforma invoice is not generated, you can not able to end trip');
                        return $this->response->redirect(base_url('booking'));
                    }

                    //Check loadingreceipt is generated or not, if generated then only allow to approve for trip end
                    $isLR = $this->LoadingReceiptModel->where('booking_id', $booking_id)->first();
                    if (empty($isLR)) {
                        $this->session->setFlashdata('danger', 'Loading Receipt is not generated, you can not able to end trip');
                        return $this->response->redirect(base_url('booking'));
                    }
                }

                //update booking status 9 for UNLOADING done - upload again pod
                $status = 9;
                $booking_data['status'] = $status;
                $booking_details =  $this->BModel->where('id', $booking_id)->first();
                //get assigned vehicle_id and driver id
                $driver_assigned_vehicle = $this->getDriverAssignedVehicle($booking_id);
                $msg =  'Trip end not approved verification';
                $alert = 'danger';
                if ($this->request->getPost('trip_end_approved') && $this->request->getPost('trip_end_approved')  == 1) {
                    //update booking status 11 - trip end 
                    $status = 11;

                    $booking_data['status'] = $status;
                    $booking_data['is_vehicle_assigned'] = 0;
                    $booking_data['vehicle_id'] = 0;

                    // free vehicles
                    $this->free_vehivle($booking_id);

                    $result = $this->BUPModel->where('booking_id', $booking_id)->where('status', 1)->first();
                    // echo '$result<pre>';print_r($result);exit;
                    if ($result) {
                        //update pod as approved
                        $this->BUPModel->update($result['id'], [
                            'status' => 2
                        ]);
                    }
                    $msg =  'Trip end approved verification successfully';
                    $alert = 'success';
                }

                $this->BModel->update($booking_id, $booking_data);
                //update booking status 
                $v_id = 0;
                $d_id = 0;
                if ($this->request->getPost('trip_end_approved') && $this->request->getPost('trip_end_approved')  == 1) {
                    $v_id = $booking_details['vehicle_id'];
                    $d_id = isset($driver_assigned_vehicle['d_id']) && ($driver_assigned_vehicle['d_id'] > 0) ? $driver_assigned_vehicle['d_id'] : 0;
                }
                $this->update_booking_status($booking_id, $status, $v_id, $d_id);
                $this->update_PTLBookings($booking_id, $status, $v_id, $d_id);

                $this->session->setFlashdata($alert, $msg);
                return $this->response->redirect(base_url('booking'));
            }
        }
        $this->view['token'] = $booking_id;
        $this->view['pod_data'] = $this->BUPModel->where('booking_id', $booking_id)->where('status', 1)->first();
        return view('Booking/trip_end_verification', $this->view);
    }

    function trip_start($id)
    {
        // echo '  <pre>';print_r($this->request->getPost());exit; 
        $this->BModel->update($id, ['status' => '4']);
        //update booking status 
        $this->update_booking_status($id, 4, 0, 0, $this->request->getPost('status_date'));
        $this->update_PTLBookings($id, 4, 0, 0, $this->request->getPost('status_date'));
        $this->session->setFlashdata('success', 'Trip is started');
        return $this->response->redirect(base_url('booking'));
    }

    function loading_done($id)
    {
        if ($this->request->getPost()) {
            $error = $this->validate([
                'loading_date_time' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'The loading date time field is required'
                    ],
                ],
                'loading_doc' => [
                    'rules' => 'mime_in[loading_doc,image/png,image/PNG,image/jpg,image/jpeg,image/JPEG,application/pdf]',
                    'errors' => [
                        'mime_in' => 'Image must be in jpeg/png/pdf format'
                    ]
                ],
                'loading_doc_2' => [
                    'rules' => 'mime_in[loading_doc_2,image/png,image/PNG,image/jpg,image/jpeg,image/JPEG,application/pdf]',
                    'errors' => [
                        'mime_in' => 'Image must be in jpeg/png/pdf format'
                    ]
                ],
                'loading_doc_3' => [
                    'rules' => 'mime_in[loading_doc_3,image/png,image/PNG,image/jpg,image/jpeg,image/JPEG,application/pdf]',
                    'errors' => [
                        'mime_in' => 'Image must be in jpeg/png/pdf format'
                    ]
                ],
            ]);

            if (!$error) {
                $this->view['error'] = $this->validator;
            } else {
                //upload  loading_doc 1  
                $image = $this->request->getFile('loading_doc');
                $image_name = '';
                if (isset($image)) {
                    if ($image->isValid() && !$image->hasMoved()) {
                        $image_name = $image->getRandomName();
                        $imgpath = 'public/uploads/loading_docs';
                        if (!is_dir($imgpath)) {
                            mkdir($imgpath, 0777, true);
                        }
                        $image->move($imgpath, $image_name);
                    }
                }

                //upload  loading_doc 2  
                $image = $this->request->getFile('loading_doc_2');
                $image_name_2 = '';
                if (isset($image)) {
                    if ($image->isValid() && !$image->hasMoved()) {
                        $image_name_2 = $image->getRandomName();
                        $imgpath = 'public/uploads/loading_docs';
                        if (!is_dir($imgpath)) {
                            mkdir($imgpath, 0777, true);
                        }
                        $image->move($imgpath, $image_name_2);
                    }
                }

                //upload  loading_doc 3  
                $image = $this->request->getFile('loading_doc_3');
                $image_name_3 = '';
                if (isset($image)) {
                    if ($image->isValid() && !$image->hasMoved()) {
                        $image_name_3 = $image->getRandomName();
                        $imgpath = 'public/uploads/loading_docs';
                        if (!is_dir($imgpath)) {
                            mkdir($imgpath, 0777, true);
                        }
                        $image->move($imgpath, $image_name_3);
                    }
                }

                $booking_data['status'] = 5;
                $booking_data['loading_doc'] = $image_name;
                $booking_data['loading_doc_2'] = $image_name_2;
                $booking_data['loading_doc_3'] = $image_name_3;
                $booking_data['loading_date_time'] = $this->request->getPost('loading_date_time');
                // echo '  <pre>';print_r($booking_data);exit; 
                $this->BModel->update($id, $booking_data);

                //update booking status 
                $this->update_booking_status($id, 5);
                $this->update_PTLBookings($id, 5);
                $this->session->setFlashdata('success', "Loading done successfully");
                return $this->response->redirect(base_url('booking'));
            }
        }
        $this->view['booking_details'] = $this->BModel->select('booking_date')->where('id', $id)->first();
        $this->view['token'] = $id;
        return view('Booking/loading_done', $this->view);
    }

    function kanta_parchi_uploaded($id)
    {
        if ($this->request->getPost()) {
            $error = $this->validate([
                'kanta_parchi' => [
                    'rules' => 'uploaded[kanta_parchi]|mime_in[kanta_parchi,image/png,image/PNG,image/jpg,image/jpeg,image/JPEG,application/pdf]',
                    'errors' => [
                        'mime_in' => 'Image must be in jpeg/png/pdf format'
                    ]
                ],
                'kanta_parchi_datetime' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'The kanta parchi datetime field is required'
                    ],
                ],
                'actual_weight' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'The actual weight field is required'
                    ],
                ]
            ]);

            if (!$error) {
                $this->view['error'] = $this->validator;
            } else {
                //upload kanta parchi 
                $image = $this->request->getFile('kanta_parchi');
                $image_name = '';
                if (isset($image)) {
                    if ($image->isValid() && !$image->hasMoved()) {
                        $image_name = $image->getRandomName();
                        $imgpath = 'public/uploads/kanta_parchies';
                        if (!is_dir($imgpath)) {
                            mkdir($imgpath, 0777, true);
                        }
                        $image->move($imgpath, $image_name);
                    }
                }
                //Change: 10-09-2024 for allow multiple kanta parchi uploading
                //2. Kanta Parchi Upload should not change the status. It should be allowed multiple times from Trip Start to Upload POD
                // $booking_status_id = 7;
                $booking_data['booking_id'] = $id;
                $booking_data['created_by'] = $this->added_by;
                // $booking_data['status'] = $booking_status_id; 
                $booking_data['actual_weight'] = $this->request->getPost('actual_weight');
                $booking_data['kanta_parchi_datetime'] = $this->request->getPost('kanta_parchi_datetime');
                $booking_data['kanta_parchi'] = $image_name;
                // $this->BModel->update($id, ['status' => $booking_status_id]);  

                $this->BookingUploadedKantaParchiModel->insert($booking_data);
                $this->session->setFlashdata('success', "Kanta parchi is uploaded successfully");
                return $this->response->redirect(base_url('booking'));
            }
        }
        $this->view['booking_details'] = $this->BModel->select('loading_date_time')->where('id', $id)->first();
        $this->view['token'] = $id;
        return view('Booking/kanta_parchi', $this->view);
    }

    function getDriverAssignedVehicle($booking_id)
    {
        return $this->BModel->select(' bookings.id b_id, v.id v_id,dvm.id dvm_id,d.id d_id, p.party_name')
            ->join('vehicle v', 'bookings.vehicle_id = v.id')
            ->join(' (
                SELECT    MAX(id) max_id,vehicle_id
                FROM      driver_vehicle_map 
                GROUP BY  vehicle_id
            ) dvm_max', 'dvm_max.vehicle_id = v.id')
            ->join('driver_vehicle_map dvm', 'dvm.id = dvm_max.max_id')
            ->join('driver d', 'dvm.driver_id = d.id')
            ->join('party p', 'p.id = d.party_id', 'left')
            ->where('bookings.id', $booking_id)
            ->first();
    }
    //update booking status 
    function update_booking_status($booking_id, $booking_status_id, $vehicle_id = 0, $driver_id = 0, $status_date = '', $post = [])
    {
        $booking_details =  $this->BModel->where('id', $booking_id)->first();
        //get driver details if vehicle is assigned
        $d_id = 0;
        if ($booking_details['vehicle_id'] > 0) {
            //get assigned vehicle_id and driver id
            $driver_assigned_vehicle = $this->getDriverAssignedVehicle($booking_id);
            $d_id = isset($driver_assigned_vehicle['d_id']) && ($driver_assigned_vehicle['d_id'] > 0) ? $driver_assigned_vehicle['d_id'] : 0;
        }

        if ($status_date) {
            $data['status_date'] = $status_date;
        } else {
            $data['status_date'] = date('Y-m-d H:i');
        }

        if (!empty($post)) {
            $data['location'] = $post['location'];
            $data['reason_id'] = $post['reason'];
            $data['remarks'] = $post['remarks'];
        }
        $data['booking_id'] = $booking_id;
        $data['booking_status_id'] = $booking_status_id;
        $data['created_by'] = $this->added_by;
        $data['vehicle_id'] = ($vehicle_id > 0) ? $vehicle_id : $booking_details['vehicle_id'];
        $data['driver_id'] = ($driver_id > 0) ? $driver_id : $d_id;

        // echo ' post <pre>';print_r($post);
        // echo ' driver_assigned_vehicle <pre>';print_r($driver_assigned_vehicle);
        // echo ' data <pre>';print_r($data);exit;
        $this->BookingTransactionModel->insert($data);
    }

    function getBookingDetails($id, $action)
    {
        if ($action == 'unloading') {
            $data = $this->BookingTransactionModel->select('DATE_FORMAT(status_date, "%Y-%m-%d %H:%i")  statusDate')->where('booking_id', $id)->orderBy('id', 'desc')->first();
        } else {
            $data = $this->BModel->select('DATE_FORMAT(booking_date, "%Y-%m-%d %H:%i") statusDate')->where('id', $id)->first();
        }
        echo json_encode($data);
    }

    function trip_paused($id)
    {

        if ($this->request->getPost()) {
            $error = $this->validate([
                'status_date' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'The date time field is required'
                    ],
                ],
                'location' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'The location field is required'
                    ],
                ]
            ]);

            if (!$error) {
                $this->view['error'] = $this->validator;
            } else {

                $booking_data['status'] = 8;
                $this->BModel->update($id, $booking_data);
                //update booking status 
                $this->update_booking_status($id, $booking_data['status'], '', '', $this->request->getPost('status_date'), $this->request->getPost());
                $this->update_PTLBookings($id, $booking_data['status'], '', '', $this->request->getPost('status_date'), $this->request->getPost());
                $this->session->setFlashdata('success', "Trip has been paused successfully");
                return $this->response->redirect(base_url('booking'));
            }
        }
        $this->view['reasons'] = $this->TripPausedReasonModel->where('status', 1)->orderBy('name', 'asc')->findAll();
        $this->view['booking_details'] = $this->BookingTransactionModel->where('booking_id', $id)->orderBy('id', 'desc')->first();
        // echo 'status <pre>';print_r($this->view['booking_details']);exit;
        $this->view['token'] = $id;
        return view('Booking/trip_paused', $this->view);
    }

    function unloading($id)
    {
        // echo '  <pre>';print_r($this->request->getPost());exit; 
        $booking_status = 9;
        $this->BModel->update($id, ['status' => $booking_status]);
        //update booking status 
        $this->update_booking_status($id, $booking_status, 0, 0, $this->request->getPost('status_date'));
        $this->update_PTLBookings($id, $booking_status, 0, 0, $this->request->getPost('status_date'));
        //Unlink PTL Bookings
        $this->unlinkPTLBookings($id);
        $this->session->setFlashdata('success', 'Unloading is done successfully');
        return $this->response->redirect(base_url('booking'));
    }

    function trip_running($id)
    {
        $booking_status = 7;
        $this->BModel->update($id, ['status' => $booking_status]);
        //update booking status 
        $this->update_booking_status($id, $booking_status, 0, 0, $this->request->getPost('status_date'));
        $this->update_PTLBookings($id, $booking_status, 0, 0, $this->request->getPost('status_date'));

        $this->session->setFlashdata('success', 'Trip has been running');
        return $this->response->redirect(base_url('booking'));
    }

    function trip_update($id)
    {
        $this->view['employees'] = $this->EmployeeModel->select('employee.id,employee.name')
            ->where(['employee.status' => 1])
            ->findall();
        $this->view['data'] = $this->BookingsTripUpdateModel->select('bookings_trip_updates.*,e.name e_name')
            ->join('employee e', 'e.id = bookings_trip_updates.updated_by')
            ->where('bookings_trip_updates.booking_id', $id)
            ->orderBy('id', 'desc')->findAll();
        // echo '  <pre>';print_r($this->view['data']); exit;
        if ($this->request->getPost()) {
            $error = $this->validate([
                'status_date' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'The date time field is required'
                    ],
                ],
                'location' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'The location field is required'
                    ],
                ],
                'updated_by' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'The authorised by field is required'
                    ],
                ],
                'purpose_of_update' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'The purpose of update field is required'
                    ],
                ],
            ]);

            if ($this->request->getPost('purpose_of_update') == 2) {
                $this->validate([
                    'fuel' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The fuel field is required'
                        ],
                    ],
                ]);
            }
            if (in_array($this->request->getPost('purpose_of_update'), [3, 4, 5, 6, 7])) {
                $this->validate([
                    'money' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The money field is required'
                        ],
                    ],
                ]);
            }
            $validation = \Config\Services::validation();
            if (!empty($validation->getErrors())) {
                $this->view['error'] = $this->validator;
            } else {
                // echo '<pre>';print_r($this->request->getPost());exit;
                //update booking trip update info 
                $data['booking_id'] = $id;
                $data['updated_by'] = $this->request->getPost('updated_by');
                $data['created_by'] = $this->added_by;
                $data['status_date'] = $this->request->getPost('status_date');
                $data['location'] = $this->request->getPost('location');
                $data['remarks'] = $this->request->getPost('remarks');
                $data['purpose_of_update'] = $this->request->getPost('purpose_of_update');
                $data['fuel'] = $this->request->getPost('fuel');
                $data['money'] = $this->request->getPost('money');
                $this->BookingsTripUpdateModel->insert($data);
                $this->session->setFlashdata('success', "Trip has been updated successfully");
                return $this->response->redirect(base_url('booking'));
            }
        }
        $this->view['token'] = $id;
        return view('Booking/trip_update', $this->view);
    }

    function trip_restart($id)
    {
        // echo '  <pre>';print_r($this->request->getPost());    

        // 17-09-2024 change - Driver reassign to vehicle evenif booking is assigned and trip paused 
        // Check Trip restart vehicle is assigned to driver
        //If booking is assign and booking status is paused i.e 8 then driver can be unassign vehicle
        $bookingVehicle = $this->BModel->select('v.working_status')
            ->join('vehicle v', 'v.id = bookings.vehicle_id')
            ->first();

        //If vehicle not assign to driver then not able to restart trip
        if (isset($bookingVehicle['working_status']) && ($bookingVehicle['working_status'] == 1)) {
            $this->session->setFlashdata('danger', "Driver is not assign to vehicle, please assign driver");
            return $this->response->redirect(base_url('booking'));
        }
        // echo ' <pre>';print_r($bookingVehicle);exit;   
        //get last booking status before pause booking
        $last_booking_status = $this->BookingTransactionModel->where(['booking_id' => $id, 'booking_status_id < ' => 8])->orderBy('id', 'desc')->first();
        $booking_status = isset($last_booking_status['booking_status_id']) && ($last_booking_status['booking_status_id'] > 0) ? $last_booking_status['booking_status_id'] : 16;
        $this->BModel->update($id, ['status' => $booking_status]);

        //update booking status 
        $this->update_booking_status($id, $booking_status, 0, 0, $this->request->getPost('status_date'));
        $this->update_PTLBookings($id, $booking_status, 0, 0, $this->request->getPost('status_date'));
        $this->session->setFlashdata('success', 'Trip is restarted');
        return $this->response->redirect(base_url('booking'));
    }

    function getBookingParentId($id, $booking_type, $vehicle_rc)
    {
        $getPTLBooking = $this->BModel->where([
            'booking_type' => $booking_type,
            'vehicle_id' => $vehicle_rc,
            'approved' => 1,
            'id !=' => $id
        ])->findAll();
        if ($getPTLBooking) {
            //get booking where parent_id = 0 in 
            $getPTLBookingIds = array_unique(array_column($getPTLBooking, 'id'));
            $getParentPTLBooking = $this->BModel->whereIn('id', $getPTLBookingIds)->where('parent_id', 0)->first();
        }
        return isset($getParentPTLBooking['id']) && ($getParentPTLBooking['id'] > 0) ? $getParentPTLBooking['id'] : 0;
    }


    //Update all PTL bookings status for child and parent
    function update_all_child_bookings($id, $booking_status, $child_id = 0, $vehicle_id = 0, $driver_id = 0, $status_date = '', $post = [])
    {
        $this->BModel->where(['parent_id' => $id, 'approved' => 1, 'booking_type' => 'PTL']);
        if ($child_id > 0) {
            $this->BModel->where('id != ', $child_id);
        }
        $child_bookings = $this->BModel->findAll();
        // echo 'child_bookings <pre>';print_r($child_bookings);exit;
        if ($child_bookings) {
            //get child vehicle
            $parent_vehicle = $this->BModel->where('id', $id)->first();
            foreach ($child_bookings as $child_booking) {
                if ($parent_vehicle['vehicle_id'] == $child_booking['vehicle_id']) {
                    $this->update_booking_status($child_booking['id'], $booking_status, $vehicle_id, $driver_id, $status_date, $post);
                }
            }
        }
    }

    //Get PTL Child or Parent bookings
    function update_PTLBookings($id, $booking_status, $vehicle_id = 0, $driver_id = 0, $status_date = '', $post = [])
    {
        //If booking type is PTL
        //Check current booking is parent or child
        $booking_details = $this->BModel->where(['id' => $id, 'approved' => 1])->first();
        // echo 'update_PTLBookings <pre>';print_r($booking_details); exit;
        if (isset($booking_details['booking_type']) && $booking_details['booking_type'] == 'PTL') {
            if ($booking_details['parent_id'] > 0) {
                //booking is child
                //update all same parent_id  
                $this->update_all_child_bookings($booking_details['parent_id'], $booking_status, $booking_details['id'], $vehicle_id, $driver_id, $status_date, $post);

                $this->BModel->set('status', $booking_status)->where('parent_id', $booking_details['parent_id'])->update();

                //update parent also, id = parent id  
                //get parent vehicle
                $parent_vehicle = $this->BModel->where('id', $booking_details['parent_id'])->first();
                if ($parent_vehicle['vehicle_id'] == $booking_details['vehicle_id']) {
                    $this->BModel->set('status', $booking_status)->where('id', $booking_details['parent_id'])->update();
                    $this->update_booking_status($booking_details['parent_id'], $booking_status, $vehicle_id, $driver_id, $status_date, $post);
                }
            } else {
                //booking is parent 
                //update all child booking
                $this->update_all_child_bookings($booking_details['id'], $booking_status, 0, $vehicle_id, $driver_id, $status_date, $post);
            }
        }
        // exit;
    }

    function booking_details($id)
    {
        $this->view['token'] = $id;
        $this->view['booking_details'] = $this->BModel->select('bookings.*,cb.office_name,cb.city cb_city,e.name booking_by_name,vt.name vehicle_type_name,v.rc_number,p.party_name bill_to_party_name,party.party_name as customer,v.id v_id,party.contact_person,party.primary_phone')
            ->join('vehicle v', 'v.id = bookings.vehicle_id', 'left')
            ->join('vehicle_type vt', 'vt.id = bookings.vehicle_type_id', 'left')
            ->join('employee e', 'e.id = bookings.booking_by', 'left')
            ->join('customer_branches cb', 'cb.id = bookings.customer_branch', 'left')
            ->join('customer c', 'c.id = bookings.bill_to_party', 'left')
            ->join('party p', 'p.id = c.party_id', 'left')
            ->join('customer cust', 'cust.id = bookings.customer_id', 'left')
            ->join('party', 'party.id = cust.party_id', 'left')
            ->where('bookings.id', $id)->first();
        // echo '  <pre>';print_r($this->view['booking_details'] );exit;  

        $this->view['booking_pickups'] = $this->BPModel->where('booking_id', $id)->first();
        $this->view['booking_drops'] = $this->BDModel->where('booking_id', $id)->first();
        $pickup_state = isset($this->view['booking_pickups']['state']) ? $this->view['booking_pickups']['state'] : 0;
        $drop_state = isset($this->view['booking_drops']['state']) ? $this->view['booking_drops']['state'] : 0;
        $this->view['booking_pickups_state'] = ($pickup_state > 0) ? $this->SModel->where('state_id', $pickup_state)->first() : [];
        $this->view['booking_drops_state'] =  ($drop_state > 0) ? $this->SModel->where('state_id', $drop_state)->first() : [];

        $this->view['booking_expences'] = $this->BEModel->select('eh.id eh_id,eh.*,booking_expenses.*')
            ->join('expense_heads eh', 'eh.id= booking_expenses.expense')
            ->where('booking_expenses.booking_id', $id)->findAll();


        $this->view['driver'] = [];
        $this->view['getPTLBookings'] = [];
        $vehicle_id = isset($this->view['booking_details']['v_id']) && ($this->view['booking_details']['v_id'] > 0) ? $this->view['booking_details']['v_id'] : 0;
        if ($vehicle_id > 0) {
            $this->view['driver'] = $this->DModel->select('driver.id, party.party_name as driver_name,party.primary_phone')
                ->join('driver_vehicle_map dvp', 'driver.id = dvp.driver_id')
                ->join('party', 'party.id = driver.party_id')
                ->where('dvp.vehicle_id', $vehicle_id)
                ->first();

            $this->view['ptl_bookings'] = $this->getPTLBookings($id, $vehicle_id);
            $this->view['booking_total'] = $this->getTotalPTLBookings($id, $vehicle_id);
        }


        $this->view['trip_start_details'] = $this->getBookingTransactions($id, 4);

        $this->view['loading_details'] = $this->getBookingTransactions($id, 5);

        $this->view['trip_running_details'] = $this->getBookingTransactions($id, 7);

        $this->view['unloading_details'] = $this->getBookingTransactions($id, 9);;

        $this->view['pod_details'] = $this->getBookingTransactions($id, 10);;

        $this->view['kanta_parchi_details'] = $this->BookingUploadedKantaParchiModel->where(['booking_id' => $id])->findAll();

        $this->view['uploaded_pods_details'] = $this->BUPModel->where(['booking_id' => $id])->findAll();
        // echo 'trip_start_details  <pre>';print_r($this->view['trip_start_details'] );exit; 

        $this->view['trip_update_details'] = $this->BookingsTripUpdateModel->where(['booking_id' => $id])->findAll();

        return view('Booking/booking_details', $this->view);
    }

    function getBookingTransactions($id, $status)
    {
        return $this->BookingTransactionModel
            ->select('booking_transactions.*,party.party_name driver,v.rc_number')
            ->join('driver d', 'd.id = booking_transactions.driver_id', 'left')
            ->join('party', 'party.id = d.party_id', 'left')
            ->join('vehicle v', 'v.id = booking_transactions.vehicle_id', 'left')
            ->where(['booking_id' => $id, 'booking_status_id' => $status])->findAll();
    }

    function getLastDropOfBooking($vehicle_id, $booking_id = 0)
    {
        $conditions['booking_transactions.vehicle_id'] = $vehicle_id;
        $conditions['booking_transactions.booking_status_id'] = 11;
        if ($booking_id > 0) {
            $conditions['booking_transactions.booking_id !='] = $booking_id;
        }
        return $this->BookingTransactionModel
            ->select('b.id bid,bd.city,s.state_name,bd.pincode, booking_transactions.*')
            ->join('bookings b', 'b.id = booking_transactions.booking_id')
            ->join('booking_drops bd', 'b.id = bd.booking_id')
            ->join('states s', 's.state_id = bd.state')
            ->where($conditions)
            ->orderBy('booking_transactions.booking_id', 'desc')
            ->first();
        // echo $this->BookingTransactionModel->getLastQuery().'<pre>';print_r($dt);exit; 
    }

    //get last drop vehicle location if selected vehicle 30-09-2024
    function getLastVehicleBookingDetails()
    {
        $last_drop = '';
        if ($this->request->getPost('vehicle_id') > 0) {
            //last trip end booking drop location
            $last_booking_transaction = $this->getLastDropOfBooking($this->request->getPost('vehicle_id'), $this->request->getPost('booking_id'));
            $city = isset($last_booking_transaction['city']) && ($last_booking_transaction['city']) ? $last_booking_transaction['city'] : '';
            $state = isset($last_booking_transaction['state_name']) && ($last_booking_transaction['state_name']) ? ' , ' . $last_booking_transaction['state_name'] : '';
            $pincode = isset($last_booking_transaction['pincode']) && ($last_booking_transaction['pincode']) ? ' , ' . $last_booking_transaction['pincode'] : '';
            $last_drop = $city . $state . $pincode;
        }
        echo $last_drop;
        exit;
    }
}
