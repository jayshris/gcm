<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookingDropsModel;
use App\Models\BookingExpensesModel;
use App\Models\BookingLinkModel;
use App\Models\BookingPickupsModel;
use App\Models\BookingsModel;
use App\Models\BookingStatusModel;
use App\Models\BookingVehicleLogModel;
use App\Models\CityModel;
use App\Models\CustomerBranchModel;
use App\Models\CustomersModel;
use App\Models\EmployeeModel;
use App\Models\ExpenseHeadModel;
use App\Models\LoadingReceiptModel;
use App\Models\NotificationModel;
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

    public $CityModel;

    public $user;
    public $profile;
    public $ExpenseHeadModel;
    public $EmployeeModel;
    public $BookingLinkModel;
    public $NModel;
    public $LoadingReceiptModel;
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
        $this->CityModel = new CityModel();
        $this->ExpenseHeadModel = new ExpenseHeadModel();
        $this->EmployeeModel = new EmployeeModel();
        $this->BookingLinkModel = new BookingLinkModel();
        $this->NModel = new NotificationModel();
        $this->LoadingReceiptModel = new LoadingReceiptModel();
    }

    public function index()
    { 
        $this->BModel->select('bookings.*, party.party_name, vehicle.rc_number, 
          IF(bookings.status = 0, "Created", booking_status.status_name) as status_name,
          IF(bookings.status = 0, "bg-success", booking_status.status_bg) as status_bg,
          lr.id as lr_id,lr.status lr_Status,lr.approved lr_approved')
            ->join('customer', 'customer.id = bookings.customer_id', 'left')
            ->join('party', 'party.id = customer.party_id', 'left')
            ->join('vehicle', 'vehicle.id = bookings.vehicle_id', 'left')
            ->join('booking_status', 'booking_status.id = bookings.status', 'left')
            ->join('loading_receipts lr', 'bookings.id = lr.booking_id', 'left');

        if ($this->request->getPost('status') != '') {
            $this->BModel->where('bookings.status', $this->request->getPost('status'));
        }

        $this->view['bookings'] = $this->BModel->orderBy('bookings.id', 'desc')->groupBy('bookings.id')->findAll();

        $this->view['statuses'] = $this->BSModel->findAll();
        $this->view['pickup'] = $this->BPModel;
        $this->view['drop'] = $this->BDModel;

        return view('Booking/index', $this->view); 
    }

    public function create()
    {    
        if ($this->request->getPost()) {
            $post = $this->request->getPost();
            // echo '<pre>';print_r($post);//exit;                      
                //show booking_details page
            if(isset($post['office_id'])){
                // echo '<pre>';print_r($post);exit;   
                $error = $this->validate([
                    'vehicle_type' =>  'required',
                    'office_id' =>  'required',
                    'customer_branch' =>  'required',
                    'customer_id' =>  'required',
                    'booking_by' =>  'required',
                    'booking_date' =>  'required',
                    ]);
    
                if (!$error) {
                    // echo 'b<pre>';print_r($error);exit;
                    $this->view['error']   = $this->validator;
                } else {
                    $profile =  $this->profile->where('logged_in_userid',  session()->get('id'))->first();//echo __LINE__.'<pre>';print_r($profile);die;
                    $last_booking = $this->BModel->orderBy('id', 'desc')->first();
                    $lastBooking = isset($last_booking['id']) ? ((int)$last_booking['id']+1) : 1;
                    $booking_number = isset($profile['booking_prefix']) && !empty($profile['booking_prefix']) ? $profile['booking_prefix'].'/'.date('m').'/000'.$lastBooking : 'BK/'.date('m').'/000'.$lastBooking;

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
                        'lr_first_party' => $this->request->getPost('lr_first_party'),
                    ];
                    
                    $booking_id = $this->BModel->insert($bookingData) ? $this->BModel->getInsertID() : '0';    

                    if(isset($post['next_or_generate_link']) && ($post['next_or_generate_link'] == 'next')){
                        $this->view['booking_customer'] = $this->CModel->select('customer.*, party.party_name')
                        ->join('bookings b', 'customer.id = b.customer_id')
                        ->join('party', 'party.id = customer.party_id')
                        ->where('b.id', $booking_id) 
                        ->first();
                        $this->view['booking_details'] = $this->BModel->where('id',$booking_id)->first();
                        $this->view['booking_number'] =$booking_number;
                        $this->view['booking_type'] =$post['booking_type'];
                        $this->view['booking_id'] = $booking_id;
                    }elseif(isset($post['next_or_generate_link']) && ($post['next_or_generate_link'] == 'generate_link')){
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
                        
                    }else{
                        $this->session->setFlashdata('success', 'Booking Successfully Added');
                        return $this->response->redirect(base_url('booking'));
                    }
                }
                
            }else if(isset($post['booking_details']) && ($post['booking_details'] ==  'PTL' || $post['booking_details'] ==  'FTL')){
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
                    // echo 'post <pre>';print_r($post);exit;
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
                        'added_ip' => $this->added_ip
                    ];//echo __LINE__.'<pre>';print_r($bookingData);die;

                    $this->BModel->update($booking_id,$bookingPTLData);
                    
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
                        $this->BEModel->insert([
                            'booking_id' => $booking_id,
                            'expense' => $this->request->getPost('expense')[$key],
                            'value' => $this->request->getPost('expense_value')[$key],
                            'bill_to_party' =>  ($this->request->getPost('expense_flag_' . $key +1) == 'on') ? '1' : '0'
                        ]);
                    }

                    $this->session->setFlashdata('success', 'Booking Successfully Added');

                    return $this->response->redirect(base_url('booking'));
                    //redirect to bookings index
                }                     
            }else{
                return $this->response->redirect(base_url('booking'));
            }  
        }
        $this->view['party'] = $this->PModel->select('party.*')->join('party_type_party_map', 'party_type_party_map.party_id = party.id')
            ->whereIn('party_type_party_map.party_type_id', [1, 2, 5])->groupBy('party.id')->orderBy('party.party_name')->findAll();
        $this->view['offices'] = $this->OModel->where('status', '1')->findAll(); 
        $this->view['vehicle_types'] = $this->VTModel->where('status', 'Active')->findAll();
        $this->view['employees'] = $this->EmployeeModel->whereIN('dept_id', [1,2])->where('status', 1)->findall();
        $this->view['states'] =  $this->SModel->orderBy('state_name', 'asc')->findAll();
        $this->view['expense_heads'] =  $this->ExpenseHeadModel->orderBy('head_name', 'asc')->findAll();
        
        $party_type_ids = $this->PTModel->select("(GROUP_CONCAT(id)) party_type_ids") 
        ->where('sale', '1') 
        ->first(); 
         $party_type_ids = str_replace([',',', '],'|', $party_type_ids );
       
        $this->view['customers'] = $this->CModel->select('customer.*, party.party_name')
            ->join('party', 'party.id = customer.party_id')
            ->where('customer.status', '1')
            ->where('CONCAT(",", party_type_id, ",") REGEXP ",('.$party_type_ids['party_type_ids'].'),"')
            ->findAll();

        // $db = \Config\Database::connect();  
        // echo  $db->getLastQuery()->getQuery(); 
        // echo '  <pre>';print_r($this->view['customers'] );exit; 

        return view('Booking/create', $this->view); 
    }
    public function getCitiesByState()
    {
        $cities = $this->CityModel->where('state_id', $this->request->getPost('state_id'))->findAll();
        echo json_encode($cities);exit;
    }

    public function getPatyTypeDetails()
    {
        $party_type = $this->PTModel->where('id', $this->request->getPost('customer_id'))->first();
        echo $party_type['lr_first_party'];exit;
    }

    public function create_bk()
    {
         if ($this->request->getPost()) {
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
                // 'status' => $isVehicle ? '3' : '2',
                'status' => 2,
                'approved_by' => $this->added_by,
                'approved_ip' => $this->added_ip,
                'approved_date' => date('Y-m-d h:i:s'),
                'approved' => $this->request->getPost('approve'),
            ]);

            // update Drops, Pickups and delete Expences 
            $this->BEModel->where('booking_id', $id)->delete();

            // save pickups
            $bpdata= [ 
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
                $expense_data = [
                    'booking_id' => $id,
                    'expense' => $this->request->getPost('expense')[$key],
                    'value' => $this->request->getPost('expense_value')[$key],
                    'bill_to_party' => ($this->request->getPost('expense_flag_' . $key +1) == 'on') ? '1' : '0'
                ]; 
                $this->BEModel->insert($expense_data);
            }    

            $this->session->setFlashdata('success', 'Booking Successfully Updated');

            return $this->response->redirect(base_url('booking'));
        }

        $this->view['party'] = $this->PModel->select('party.*')->join('party_type_party_map', 'party_type_party_map.party_id = party.id')
            ->whereIn('party_type_party_map.party_type_id', [1, 2, 5])->groupBy('party.id')->orderBy('party.party_name')->findAll();

        $this->view['offices'] = $this->OModel->where('status', '1')->findAll();

        $this->view['vehicle_types'] = $this->VTModel->where('status', 'Active')->findAll();
        $this->view['employees'] = $this->EmployeeModel->whereIN('dept_id', [1,2])->where('status', 1)->findall();
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
        $this->view['vehicle_rcs'] =  $this->VModel->where('vehicle_type_id', $this->view['booking_details']['vehicle_type_id'] )->where('status', '1')->where('working_status', '1')->findAll();

        //city drop down changes 
        $this->view['pickup_cities'] = isset($this->view['booking_pickups']) ? $this->CityModel->where('state_id', $this->view['booking_pickups']['state'])->findAll() : [];
        $this->view['drop_cities'] = isset($this->view['booking_drops']) ? $this->CityModel->where('state_id', $this->view['booking_drops']['state'])->findAll() : [];

        $this->view['selected_pickup_city'] = isset($this->view['booking_pickups']) ? $this->view['booking_pickups']['city'] : '';
        $this->view['selected_drop_city'] = isset($this->view['booking_drops']) ? $this->view['booking_drops']['city'] : '';

        $this->view['pickup_cities']  = array_column($this->view['pickup_cities'],'city','id');
        $this->view['drop_cities']  = array_column($this->view['drop_cities'],'city','id');
        if(isset($this->view['booking_pickups']) && !empty($this->view['booking_pickups']['city'])){
            if(!in_array($this->view['booking_pickups']['city'],$this->view['pickup_cities'])){
                array_push($this->view['pickup_cities'],$this->view['booking_pickups']['city']);
            }
        } 

        if(isset($this->view['booking_drops']) && !empty($this->view['booking_drops']['city'])){
            if(!in_array($this->view['booking_drops']['city'],$this->view['drop_cities'])){
                array_push($this->view['drop_cities'],$this->view['booking_drops']['city']);
            }
        } 
        $this->view['token'] = $id;
        $this->view['expense_heads'] =  $this->ExpenseHeadModel->orderBy('head_name', 'asc')->findAll();
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

    public function getUnassignVehicles()
    {
        $current_booking = $this->BModel->select('id,booking_type,vehicle_id')->where('id',$this->request->getPost('booking_id'))->first();
        $booking_id = $current_booking['id'];
        $isVehicle_type = $this->request->getPost('vehicle_type');
        //get unassigned vehicles  
        $unassigned_vehicles =  $this->VModel->select('vehicle.id, vehicle.rc_number, party.party_name,vehicle.vehicle_type_id')
        ->join('booking_vehicle_logs bvl', 'bvl.vehicle_id = vehicle.id','left')
        ->join('driver_vehicle_map', 'driver_vehicle_map.vehicle_id = vehicle.id','left')
        ->join('driver', 'driver.id = driver_vehicle_map.driver_id','left')
        ->join('party', 'party.id = driver.party_id','left')
        ->where('driver_vehicle_map.unassign_date', '')
        ->where('vehicle.vehicle_type_id', $isVehicle_type)
        ->where('vehicle.status', '1')
        ->where('vehicle.working_status', '1')
        ->orWhere("(bvl.booking_id = '$booking_id' and vehicle.working_status = '2' and vehicle.vehicle_type_id = '$isVehicle_type' )")
        ->groupBy('vehicle.id')
        ->findAll();
        
        // $db = \Config\Database::connect();  
        // echo  $db->getLastQuery()->getQuery(); 
        // echo '<pre>';print_r($unassigned_vehicles);exit;
        
        if(isset($current_booking['booking_type']) && ($current_booking['booking_type'] == 'PTL')){
            //get assigned vehicles(working_status=2) but assigned booking type PTL
            $assigned_vehicles = $this->VModel->select('vehicle.id, vehicle.rc_number, party.party_name')
            ->join('booking_vehicle_logs bvl', 'bvl.vehicle_id = vehicle.id','left')
            ->join('bookings b', 'b.id = bvl.booking_id','left')
            ->where('vehicle.vehicle_type_id', $isVehicle_type)
            ->join('driver_vehicle_map', 'driver_vehicle_map.vehicle_id = vehicle.id','left')
            ->join('driver', 'driver.id = driver_vehicle_map.driver_id','left')
            ->join('party', 'party.id = driver.party_id','left')
            ->where('driver_vehicle_map.unassign_date', '')
            ->where('vehicle.status', '1')
            ->where('vehicle.working_status', '2')
            ->where('b.booking_type', 'PTL')
            ->where('b.status', '1')
            ->orWhere("(bvl.booking_id = '$booking_id' and vehicle.working_status = '2' and vehicle.vehicle_type_id = '$isVehicle_type' )")
            ->groupBy('vehicle.id')
            ->findAll();
            
            $rows = array_merge($unassigned_vehicles,$assigned_vehicles); 
            // echo '  <pre>';print_r($assigned_vehicles);
        }else{
            $rows = $unassigned_vehicles; 
        }
         
        // echo '  <pre>';print_r($rows);exit; 

        $html = '<option value="">Select Vehicle</option>';
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $party_name = isset($row['party_name']) ? ' - '.$row['party_name'] : '';
                $html .= '<option value="' . $row['id'] . '" ' . ($current_booking['vehicle_id'] == $row['id'] ? 'selected' : '') . '>' . $row['rc_number']. $party_name . '</option>';
            }
        }

        return $html;
    }

    public function assign_vehicle($id)
    {
   
        //for booking data
        $this->view['booking_details'] = $this->BModel->where('id', $id)->first();
        
        // IF BOOKING NOT APPROVED (STATUS LESS THAN 2), THEN VEHICLE ASSIGN FEATURE WILL BE DISABLED.
        if($this->view['booking_details']['approved'] !=1){
            $this->session->setFlashdata('danger', 'You does not have access to assign vehicle because this booking is not approved.'); 
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
            ->join('driver_vehicle_map', 'driver_vehicle_map.vehicle_id = vehicle.id','left')
            ->join('driver', 'driver.id = driver_vehicle_map.driver_id','left')
            ->join('party', 'party.id = driver.party_id','left')
            ->where('driver_vehicle_map.unassign_date', '')
            ->where('vehicle_type_id', $this->view['booking_details']['vehicle_type_id'])
            ->where('vehicle.status', 1)->where('vehicle.working_status', '1')->groupBy('vehicle.id')->findAll(); 
        

        // $this->view['vehicle_rcs'] =  $this->VModel->where('vehicle_type_id', $this->view['booking_details']['vehicle_type_id'] )->where('status', '1')->where('working_status', '1')->findAll();
       
        $this->view['expense_heads'] =  $this->ExpenseHeadModel->orderBy('head_name', 'asc')->findAll();
        
       //get last log i.e unassign_date = ''
       $this->view['booking_vehicle'] = $this->BVLModel->where('booking_id', $id)->where('unassign_date IS NULL')->first();
    //   echo '<pre>';print_r($this->view['booking_vehicle']);exit;
       if ($this->request->getPost()) {
        $current_booking = $this->BModel->select('status,booking_type,vehicle_id')->where('id',$id)->first();
        
        //IF ON VEHICLE ASSIGNED, BOOKING STATUS IS APPROVED (2) IT WILL CHANGE TO READY FOR TRIP (3)
        $booking_status = 3;

        // IF ON VEHICLE ASSIGNED, BOOKING STATUS IS GREATER THAN APPROVED (2) THEN IT WILL CHANGE TO 1
        if($current_booking['status'] > 2){
            $booking_status = 1;
        }

        if(($current_booking['status']==2) && ($current_booking['booking_type'] == 'PTL')){
            $booking_status = 1;
        }

        $this->BModel->update($id, [
            'vehicle_id' => $this->request->getPost('vehicle_rc'),
            'vehicle_type_id' => $this->request->getPost('vehicle_type'),
            'status' => $booking_status,
            'is_vehicle_assigned' => 1
        ]);
        //if already assign vehicle to booking then change vehile status not assigned and vehicle log as unassign vehicle
        $result = $this->BVLModel->where('booking_id', $id)->where('unassign_date IS NULL')->first();
        if ($result) {
            //update old vehicle status  
            $this->VModel->update($result['vehicle_id'], [ 
                'working_status' => '1'
            ]); 
            $this->BVLModel->update($result['id'], ['unassign_date' => date('Y-m-d h:i:s'), 'unassigned_by' => $this->added_by]);
        }

        $this->BVLModel->insert([
            'booking_id' => $id,
            'vehicle_id' => $this->request->getPost('vehicle_rc'),
            'assign_by' => $this->added_by,
            'assign_date' => $this->request->getPost('assign_date'),
            'vehicle_location' => $this->request->getPost('vehicle_location'),
        ]);

        //update vevhicl status assigned as 2
        $this->VModel->update($this->request->getPost('vehicle_rc'), [ 
            'working_status' => '2'
        ]); 

        $this->session->setFlashdata('success', 'Vehicle Assigned To Booking');

        return $this->response->redirect(base_url('booking'));
    }

        return view('Booking/vehicle', $this->view);
    }

    public function getBookingVehicleDetails()
    {
        $bookings = $this->BVLModel->select('p.party_name,bp.city bpcity,bpstates.state_name bpstate,bp.pincode bppin,,bd.*,bdstates.state_name bdstate')
        ->join('bookings b', 'b.id = booking_vehicle_logs.booking_id')
        ->join('customer c', 'c.id = b.customer_id','left')
        ->join('party p', 'p.id = c.party_id','left')
        ->join('booking_pickups bp', 'b.id = bp.booking_id','left')
        ->join('states bpstates', 'bp.state = bpstates.state_id','left')
        ->join('booking_drops bd', 'b.id = bd.booking_id','left')
        ->join('states bdstates', 'bd.state = bdstates.state_id','left')
        ->where('b.id !=', $this->request->getPost('booking_id'))
        ->where('booking_vehicle_logs.vehicle_id', $this->request->getPost('vehicle_id'))
        ->findAll();
        echo json_encode($bookings);exit;
    }

    public function cancel($id)
    {
        $booking_details =  $this->BModel->where('id', $id)->first();

        // echo '<pre>';
        // print_r($booking_details);

        //change sstatus of driver and vehicle too

        if ($booking_details['status'] >= 5) {
            if($booking_details['status'] == 14){
                $this->session->setFlashdata('danger', 'Booking approval is already send for Cancellation');
                return $this->response->redirect(base_url('booking'));
            }else{
                $this->session->setFlashdata('danger', 'Booking Cancellation Not Allowed As Trip Has Started');
                return $this->response->redirect(base_url('booking'));
            }
            
        } else {   
            //send notfication 
            $this->sendNotification($booking_details);
            $this->BModel->update($id, ['status' => '14']);
            $this->session->setFlashdata('success', 'Approval is send for Cancellation');
            return $this->response->redirect(base_url('booking'));
        }
    }

    function sendNotification($booking_details){ 
        $this->NModel->save([
            'order_id' => $booking_details['id'],
            'user_id'=>$_SESSION['id'],
            'message' => $booking_details['booking_number'].' order has been send approval for cancellation'
        ]); 
    }

    public function edit($id, $token = ''){
        //Check booking link validation
        if($token){
            $id = base64_decode(str_replace(['-','_'], ['+','/'], $id)); 
           // echo $decode_id;exit;

             // validate token and validity
            $link_data = $this->BookingLinkModel->where('token', $token)->first();
            if($link_data){
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
            }else {
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
                // echo $id.$token.'<pre>';print_r($post);exit;      
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
                    'status' => 1,
                    'added_by' => $this->added_by,
                    'added_ip' => $this->added_ip
                ];//echo __LINE__.'<pre>';print_r($bookingData);die;

                $this->BModel->update($id,$bookingData);
                
                // update Drops, Pickups and delete Expences 
                $this->BEModel->where('booking_id', $id)->delete();

                // save pickups
                $bpdata= [ 
                    'booking_id' =>$id,
                    'sequence' => $this->request->getPost('pickup_seq'),
                    'city' => $this->request->getPost('pickup_city'),
                    'state' => $this->request->getPost('pickup_state_id'),
                    'pincode' => $this->request->getPost('pickup_pin'),
                    'city_id' => $this->request->getPost('pickup_city_id'),
                ]; 
                //if not exist then insert otherwise update
                $isbpdata = $this->BPModel->where('booking_id', $id)->first();
                if(empty($isbpdata)){
                    $this->BPModel->insert($bpdata);
                }else{
                    $this->BPModel->set($bpdata)->where('id', $isbpdata['id'])->update();
                }
                // echo $id.$token.'<pre>';print_r($bpdata);exit;     
                // save drops 
                $bddata = [ 
                    'booking_id' =>$id,
                    'sequence' => $this->request->getPost('drop_seq'),
                    'city' => $this->request->getPost('drop_city'),
                    'state' => $this->request->getPost('drop_state_id'),
                    'pincode' => $this->request->getPost('drop_pin'),
                    'city_id' => $this->request->getPost('drop_city_id'),
                ]; 
                
                $isbddata = $this->BDModel->where('booking_id', $id)->first();
                if(empty($isbddata)){
                    $this->BDModel->insert($bddata);
                }else{
                    $this->BDModel->set($bddata)->where('id', $isbddata['id'])->update();
                }

                // save expenses
                foreach ($this->request->getPost('expense') as $key => $val) {
                    $expense_data = [
                        'booking_id' => $id,
                        'expense' => $this->request->getPost('expense')[$key],
                        'value' => $this->request->getPost('expense_value')[$key],
                        'bill_to_party' => ($this->request->getPost('expense_flag_' . $key +1) == 'on') ? '1' : '0'
                    ]; 
                    $this->BEModel->insert($expense_data);
                }   

                if($token){
                     // discard link
                     $this->BookingLinkModel->set('link_used', '1')->where('token', $token)->update();
                     $this->session->setFlashdata('success', 'Booking Details Successfully Updated'); 
                     return $this->response->redirect(base_url('bookinglinks'));
                }else{
                    $this->session->setFlashdata('success', 'Booking Successfully Updated'); 
                    return $this->response->redirect(base_url('booking'));
                } 
            } 
        }
        $this->view['booking_link_token'] = $token;
        $this->view['token'] = $id;
        $this->view['booking_details'] = $this->BModel->where('id', $id)->first();
        $this->view['booking_pickups'] = $this->BPModel->where('booking_id', $id)->first();
        $this->view['booking_drops'] = $this->BDModel->where('booking_id', $id)->first();
        $this->view['booking_expences'] = $this->BEModel->where('booking_id', $id)->findAll();  
        $this->view['states'] =  $this->SModel->orderBy('state_name', 'asc')->findAll();

        $this->view['pickup_cities'] = isset($this->view['booking_pickups']) ? $this->CityModel->where('state_id', $this->view['booking_pickups']['state'])->findAll() : [];
        $this->view['drop_cities'] = isset($this->view['booking_drops']) ? $this->CityModel->where('state_id', $this->view['booking_drops']['state'])->findAll() : [];

        $this->view['selected_pickup_city'] = isset($this->view['booking_pickups']) ? $this->view['booking_pickups']['city'] : '';
        $this->view['selected_drop_city'] =isset($this->view['booking_drops']) ? $this->view['booking_drops']['city'] : '';

        $this->view['pickup_cities']  = array_column($this->view['pickup_cities'],'city','id');
        $this->view['drop_cities']  = array_column($this->view['drop_cities'],'city','id');
        if(isset($this->view['booking_pickups']) && !empty($this->view['booking_pickups']['city'])){
            if(!in_array($this->view['booking_pickups']['city'],$this->view['pickup_cities'])){
                array_push($this->view['pickup_cities'],$this->view['booking_pickups']['city']);
            }
        } 

        if(isset($this->view['booking_drops']) && !empty($this->view['booking_drops']['city'])){
            if(!in_array($this->view['booking_drops']['city'],$this->view['drop_cities'])){
                array_push($this->view['drop_cities'],$this->view['booking_drops']['city']);
            }
        } 

        //get only those customers whose sale = 1
        $party_type_ids = $this->PTModel->select("(GROUP_CONCAT(id)) party_type_ids") 
        ->where('sale', '1') 
        ->first(); 
         $party_type_ids = str_replace([',',', '],'|', $party_type_ids );
       
        $this->view['customers'] = $this->CModel->select('customer.*, party.party_name')
            ->join('party', 'party.id = customer.party_id')
            ->where('customer.status', '1')
            ->where('CONCAT(",", party_type_id, ",") REGEXP ",('.$party_type_ids['party_type_ids'].'),"')
            ->findAll();

        // $db = \Config\Database::connect();  
        // echo  $db->getLastQuery()->getQuery(); 
        // echo '  <pre>';print_r($this->view['customers'] );exit; 
        $this->view['expense_heads'] =  $this->ExpenseHeadModel->orderBy('head_name', 'asc')->findAll();
        return view('Booking/edit', $this->view); 
    }
    
    function preview($id){
        $this->view['token'] = $id;
        $this->view['booking_details'] = $this->BModel->select('bookings.*,cb.office_name,cb.city cb_city,e.name booking_by_name,vt.name vehicle_type_name,v.rc_number,p.party_name bill_to_party_name,party.party_name as customer')
        ->join('vehicle v', 'v.id = bookings.vehicle_id','left')
        ->join('vehicle_type vt', 'vt.id = bookings.vehicle_type_id','left')
        ->join('employee e', 'e.id = bookings.booking_by','left')
        ->join('customer_branches cb', 'cb.id = bookings.customer_branch','left')
        ->join('customer c', 'c.id = bookings.bill_to_party','left')
        ->join('party p', 'p.id = c.party_id','left')
        ->join('customer cust', 'cust.id = bookings.customer_id','left')
        ->join('party', 'party.id = cust.party_id','left')
        ->where('bookings.id', $id)->first();
        // echo '  <pre>';print_r($this->view['booking_details'] );exit;  
        
        $this->view['booking_pickups'] = $this->BPModel->where('booking_id', $id)->first();
        $this->view['booking_drops'] = $this->BDModel->where('booking_id', $id)->first();
        $pickup_state = isset($this->view['booking_pickups']['state']) ? $this->view['booking_pickups']['state'] : 0;
        $drop_state = isset($this->view['booking_drops']['state']) ? $this->view['booking_drops']['state'] : 0;
        $this->view['booking_pickups_state'] = ($pickup_state>0) ? $this->SModel->where('state_id', $pickup_state)->first() : [];
        $this->view['booking_drops_state'] =  ($drop_state>0) ? $this->SModel->where('state_id', $drop_state)->first() : []; 
        
        $this->view['booking_expences'] = $this->BEModel->select('eh.id eh_id,eh.*,booking_expenses.*')
        ->join('expense_heads eh','eh.id= booking_expenses.expense')
        ->where('booking_expenses.booking_id', $id)->findAll();   

        // $db = \Config\Database::connect();  
        // echo  $db->getLastQuery()->getQuery(); 
        // echo '  <pre>';print_r($this->view['booking_expences'] );exit; 
      
        return view('Booking/preview', $this->view); 
    }
    
    public function approval_for_cancellation($id)
    { 
        $booking_details =  $this->BModel->where('id', $id)->first();
        if(isset($booking_details['status']) && $booking_details['status'] != 14){
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
            if($this->request->getPost('approval_for_cancellation')){
                $data['status'] = $this->request->getPost('approval_for_cancellation'); 
            }
            if($this->request->getPost('approval_for_cancellation') == 15){
                $data['is_vehicle_assigned'] = 0; 
            } 
            // echo '<pre>';print_r( $data);exit; 
            $this->BModel->update($id,$data);

            // update Drops, Pickups and delete Expences 
            $this->BEModel->where('booking_id', $id)->delete();  
          
            // save expenses
            foreach ($this->request->getPost('expense') as $key => $val) {
                $expense_data = [
                    'booking_id' => $id,
                    'expense' => $this->request->getPost('expense')[$key],
                    'value' => $this->request->getPost('expense_value')[$key],
                    'bill_to_party' => ($this->request->getPost('expense_flag_' . $key +1) == 'on') ? '1' : '0'
                ]; 
                $this->BEModel->insert($expense_data);
            }    
            if($this->request->getPost('approval_for_cancellation') == 15){
                 //Change vehile status not assigned and vehicle log as unassign vehicle
                $result = $this->BVLModel->where('booking_id', $id)->where('unassign_date IS NULL')->first();
                if ($result) {
                    //update old vehicle status  
                    $this->VModel->update($result['vehicle_id'], [ 
                        'working_status' => '1'
                    ]); 
                    $this->BVLModel->update($result['id'], ['unassign_date' =>date('Y-m-d H:i:s'), 'unassigned_by' => $this->added_by]);
                }  
                
                //update LR as cancel
                $lrresult = $this->LoadingReceiptModel->where('booking_id', $id)->first();
                if( $lrresult){
                    $this->LoadingReceiptModel->set(['status' => 2])->where('booking_id', $id)->update();
                }
 
                $this->session->setFlashdata('success', 'Booking is approved for cancellation Successfully');
            }else if($this->request->getPost('approval_for_cancellation') == 2){
                $this->session->setFlashdata('success', 'Revert to approve Successfully');
            }else{
                $this->session->setFlashdata('success', 'Booking is updated');
            }    
            return $this->response->redirect(base_url('booking'));
        }

        $this->view['party'] = $this->PModel->select('party.*')->join('party_type_party_map', 'party_type_party_map.party_id = party.id')
            ->whereIn('party_type_party_map.party_type_id', [1, 2, 5])->groupBy('party.id')->orderBy('party.party_name')->findAll();

        $this->view['offices'] = $this->OModel->where('status', '1')->findAll();

        $this->view['vehicle_types'] = $this->VTModel->where('status', 'Active')->findAll();
        $this->view['employees'] = $this->EmployeeModel->whereIN('dept_id', [1,2])->where('status', 1)->findall();
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
        $this->view['vehicle_rcs'] =  $this->VModel->where('vehicle_type_id', $this->view['booking_details']['vehicle_type_id'] )->where('status', '1')->where('working_status', '1')->findAll();

        //city drop down changes 
        $this->view['pickup_cities'] = isset($this->view['booking_pickups']) ? $this->CityModel->where('state_id', $this->view['booking_pickups']['state'])->findAll() : [];
        $this->view['drop_cities'] = isset($this->view['booking_drops']) ? $this->CityModel->where('state_id', $this->view['booking_drops']['state'])->findAll() : [];

        $this->view['selected_pickup_city'] = isset($this->view['booking_pickups']) ? $this->view['booking_pickups']['city'] : '';
        $this->view['selected_drop_city'] = isset($this->view['booking_drops']) ? $this->view['booking_drops']['city'] : '';

        $this->view['pickup_cities']  = array_column($this->view['pickup_cities'],'city','id');
        $this->view['drop_cities']  = array_column($this->view['drop_cities'],'city','id');
        if(isset($this->view['booking_pickups']) && !empty($this->view['booking_pickups']['city'])){
            if(!in_array($this->view['booking_pickups']['city'],$this->view['pickup_cities'])){
                array_push($this->view['pickup_cities'],$this->view['booking_pickups']['city']);
            }
        } 

        if(isset($this->view['booking_drops']) && !empty($this->view['booking_drops']['city'])){
            if(!in_array($this->view['booking_drops']['city'],$this->view['drop_cities'])){
                array_push($this->view['drop_cities'],$this->view['booking_drops']['city']);
            }
        } 
        $this->view['token'] = $id;
        $this->view['expense_heads'] =  $this->ExpenseHeadModel->orderBy('head_name', 'asc')->findAll();
        return view('Booking/approval_for_cancellation', $this->view); 
    }

    public function unassign_vehicle($id)
    {
        //for booking data
        $this->view['booking_details'] = $this->BModel->where('id', $id)->first();
        
        // Check if booking assign to a vehicle
        if($this->view['booking_details']['is_vehicle_assigned'] != 1){
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
            ->join('driver_vehicle_map', 'driver_vehicle_map.vehicle_id = vehicle.id','left')
            ->join('driver', 'driver.id = driver_vehicle_map.driver_id','left')
            ->join('party', 'party.id = driver.party_id','left')
            ->where('driver_vehicle_map.unassign_date', '')
            ->where('vehicle_type_id', $this->view['booking_details']['vehicle_type_id'])
            ->where('vehicle.status', 1)->where('vehicle.working_status', '1')->groupBy('vehicle.id')->findAll(); 
         
        $this->view['expense_heads'] =  $this->ExpenseHeadModel->orderBy('head_name', 'asc')->findAll();
        //get last log i.e unassign_date = ''
        $this->view['booking_vehicle'] = $this->BVLModel->where('booking_id', $id)->where('unassign_date IS NULL')->first();
        // echo '<pre>';print_r($this->view['booking_vehicle']);exit;
        if ($this->request->getPost()) {
            $current_booking = $this->BModel->select('status,booking_type,vehicle_id')->where('id',$id)->first();
            //update vevhicle status unassigned as 1
            $this->VModel->update($current_booking['vehicle_id'], [ 
                'working_status' => '1'
            ]); 

            $booking_status = 2;

            $this->BModel->update($id, [
                // 'vehicle_id' => $this->request->getPost('vehicle_rc'),
                // 'vehicle_type_id' => $this->request->getPost('vehicle_type'),
                'status' => $booking_status,
                'is_vehicle_assigned' => 0
            ]);

            //Change vehile status not assigned and vehicle log as unassign vehicle
            $result = $this->BVLModel->where('booking_id', $id)->where('unassign_date IS NULL')->first();
            if ($result) {
                //update old vehicle status  
                $this->VModel->update($result['vehicle_id'], [ 
                    'working_status' => '1'
                ]); 
                $this->BVLModel->update($result['id'], ['unassign_date' =>$this->request->getPost('unassign_date'), 'unassigned_by' => $this->added_by]);
            }

            $this->session->setFlashdata('success', 'Vehicle is Unassigned To Booking');

            return $this->response->redirect(base_url('booking'));
        }

        return view('Booking/unassign_vehicle', $this->view);
    }
}
