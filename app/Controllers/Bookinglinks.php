<?php

namespace App\Controllers;


use App\Models\CityModel;
use App\Models\UserModel;
use App\Models\PartyModel;
use App\Models\StateModel;
use App\Models\OfficeModel;
use App\Models\ProfileModel;
use App\Models\VehicleModel;
use App\Models\BookingsModel;
use App\Models\EmployeeModel;
use App\Models\CustomersModel;
use App\Models\PartytypeModel;
use App\Models\BookingLinkModel;
use App\Models\ExpenseHeadModel;
use App\Models\VehicleTypeModel;
use App\Models\BookingDropsModel;
use App\Models\BookingStatusModel;
use App\Controllers\BaseController;
use App\Models\BookingPickupsModel;
use App\Models\CustomerBranchModel;
use App\Models\BookingExpensesModel;
use App\Models\BookingVehicleLogModel;
use CodeIgniter\HTTP\ResponseInterface;

class Bookinglinks extends BaseController
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
    public function __construct()
    {
        $this->session = \Config\Services::session();

        $this->user = new UserModel(); 
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
    }


    public function index()
    {
        $this->view['booking_links'] = $this->BookingLinkModel->orderBy('id', 'desc')->findAll(50);

        return view('BookingLinks/index', $this->view);
    }

    public function thanks()
    {
        return view('KYC/thanks');
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
                    $this->session->setFlashdata('error', 'Your Booking details is already submitted,  Please Contact The Administrator');
                    return $this->response->redirect(base_url('bookinglinks/thanks'));
                } else if ($dateProvidedTimestamp < $currentDateTimestamp) {
                    $this->session->setFlashdata('error', 'This Link Has Expired,  Please Contact The Administrator');
                    return $this->response->redirect(base_url('bookinglinks/thanks'));
                } 
            }else {
                $this->session->setFlashdata('error', 'Invalid Booking Link, Please Contact The Administrator');
                return $this->response->redirect(base_url('bookinglinks/thanks'));
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
                $isVehicle = $this->BModel->where('id', $id)->first()['vehicle_id'] > 0 ? true : false;
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
                    'status' => $isVehicle ? '3' : '2',
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
                     $this->session->setFlashdata('error', 'Booking Details Successfully Updated'); 
                     return $this->response->redirect(base_url('bookinglinks/thanks'));
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
        return view('BookingLinks/edit', $this->view); 
    }

    public function addExpense()
    {
        $this->view['index'] = $this->request->getPost('index');
        $this->view['expense_heads'] =  $this->ExpenseHeadModel->orderBy('head_name', 'asc')->findAll();
        echo view('Booking/expense_block', $this->view);
    }
    
    public function getCitiesByState()
    {
        $cities = $this->CityModel->where('state_id', $this->request->getPost('state_id'))->findAll();
        echo json_encode($cities);exit;
    }

}
