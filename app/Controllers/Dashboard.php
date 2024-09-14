<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookingsModel;
use App\Models\DriverVehicleAssignModel;
use App\Models\VehicleModel;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    public $VehicleModel;
    public $VehicleMapModel;
    public $BookingsModel;

    public function __construct()
    {
        $this->VehicleMapModel = new DriverVehicleAssignModel();
        $this->VehicleModel = new VehicleModel();
        $this->BookingsModel = new BookingsModel();

        $this->added_by = isset($_SESSION['id']) ? $_SESSION['id'] : '0';
        $this->added_ip = isset($_SERVER['REMOTE_ADDR'])  ? $_SERVER['REMOTE_ADDR'] : '';
    }

    public function getVehiclesAvailableForBooking($limit = 0) //driver assigned but not in booking
    {

        $booked_vehicles = $this->BookingsModel->select('vehicle_id')
            ->where('is_vehicle_assigned', '1')->whereNotIn('status', ['11', '15'])
            ->groupBy('vehicle_id')->findAll();

        if ($booked_vehicles) {
            $arr = [];
            foreach ($booked_vehicles as $b) {
                array_push($arr, $b['vehicle_id']);
            }

            $res = $this->VehicleMapModel->select('
                        driver_vehicle_map.driver_id,
                        driver_vehicle_map.vehicle_id,
                        party.party_name as driver_name,
                        vehicle.rc_number,
                        vehicle_type.name as type
                    ')
                ->join('driver', 'driver.id = driver_vehicle_map.driver_id')
                ->join('party', 'party.id = driver.party_id')
                ->join('vehicle', 'vehicle.id = driver_vehicle_map.vehicle_id')
                ->join('vehicle_type', 'vehicle_type.id = vehicle.vehicle_type_id')
                ->where('unassign_date', '')
                ->whereNotIn('driver_vehicle_map.vehicle_id', $arr)
                ->groupBy('driver_vehicle_map.vehicle_id')->orderBy('assign_date', 'desc')->findAll($limit);

            return $res;
        } else return [];
    }

    public function getVehiclesHavingBookingAssigned($limit = 0) //vehicles in booking status = unloading or POD uploaded
    {
        $res = $this->VehicleMapModel->select('
                driver_vehicle_map.driver_id,
                driver_vehicle_map.vehicle_id,
                party.party_name as driver_name,
                vehicle.rc_number,
                vehicle_type.name as type,
                bookings.booking_number
            ')
            ->join('driver', 'driver.id = driver_vehicle_map.driver_id')
            ->join('party', 'party.id = driver.party_id')
            ->join('vehicle', 'vehicle.id = driver_vehicle_map.vehicle_id')
            ->join('vehicle_type', 'vehicle_type.id = vehicle.vehicle_type_id')
            ->join('bookings', 'bookings.vehicle_id = vehicle.id')
            ->where('unassign_date', '')
            ->whereIn('bookings.status', ['9', '10'])
            ->groupBy('driver_vehicle_map.vehicle_id')->orderBy('assign_date', 'desc')->findAll($limit);

        return $res;
    }

    public function getVehiclesPaused($limit = 0) //vehicles paused
    {
        $res = $this->VehicleMapModel->select('
                driver_vehicle_map.driver_id,
                driver_vehicle_map.vehicle_id,
                party.party_name as driver_name,
                vehicle.rc_number,
                vehicle_type.name as type,
                bookings.booking_number
            ')
            ->join('driver', 'driver.id = driver_vehicle_map.driver_id')
            ->join('party', 'party.id = driver.party_id')
            ->join('vehicle', 'vehicle.id = driver_vehicle_map.vehicle_id')
            ->join('vehicle_type', 'vehicle_type.id = vehicle.vehicle_type_id')
            ->join('bookings', 'bookings.vehicle_id = vehicle.id')
            ->where('unassign_date', '')
            ->whereIn('bookings.status', ['8'])
            ->groupBy('driver_vehicle_map.vehicle_id')->orderBy('assign_date', 'desc')->findAll($limit);

        return $res;
    }

    public function getVehiclesEmpty($limit = 0) //vehicles where driver not assigned
    {
        $res = $this->VehicleModel->select('vehicle.rc_number,vehicle_type.name as type')
            ->join('vehicle_type', 'vehicle_type.id = vehicle.vehicle_type_id')
            ->where('working_status', '1')->findAll($limit);

        return $res;
    }

    public function getVehiclesInLoading($limit = 0) //vehicles in loading
    {
        $res = $this->VehicleMapModel->select('
                driver_vehicle_map.driver_id,
                driver_vehicle_map.vehicle_id,
                party.party_name as driver_name,
                vehicle.rc_number,
                vehicle_type.name as type,
                bookings.booking_number
            ')
            ->join('driver', 'driver.id = driver_vehicle_map.driver_id')
            ->join('party', 'party.id = driver.party_id')
            ->join('vehicle', 'vehicle.id = driver_vehicle_map.vehicle_id')
            ->join('vehicle_type', 'vehicle_type.id = vehicle.vehicle_type_id')
            ->join('bookings', 'bookings.vehicle_id = vehicle.id')
            ->where('unassign_date', '')
            ->whereIn('bookings.status', ['5'])
            ->groupBy('driver_vehicle_map.vehicle_id')->orderBy('assign_date', 'desc')->findAll($limit);

        return $res;
    }

    public function getVehiclesInRunning($limit = 0) //vehicles in running
    {
        $res = $this->VehicleMapModel->select('
                driver_vehicle_map.driver_id,
                driver_vehicle_map.vehicle_id,
                party.party_name as driver_name,
                vehicle.rc_number,
                vehicle_type.name as type,
                bookings.booking_number
            ')
            ->join('driver', 'driver.id = driver_vehicle_map.driver_id')
            ->join('party', 'party.id = driver.party_id')
            ->join('vehicle', 'vehicle.id = driver_vehicle_map.vehicle_id')
            ->join('vehicle_type', 'vehicle_type.id = vehicle.vehicle_type_id')
            ->join('bookings', 'bookings.vehicle_id = vehicle.id')
            ->where('unassign_date', '')
            ->whereIn('bookings.status', ['7'])
            ->groupBy('driver_vehicle_map.vehicle_id')->orderBy('assign_date', 'desc')->findAll($limit);

        return $res;
    }

    public function index()
    {
        if (session()->get('isLoggedIn')) {

            $this->view['block1'] = $this->getVehiclesAvailableForBooking(5);
            $this->view['block2'] = $this->getVehiclesHavingBookingAssigned(5);
            $this->view['block3'] = $this->getVehiclesPaused(5);
            $this->view['block4'] = $this->getVehiclesEmpty(5);
            $this->view['block5'] = $this->getVehiclesInLoading(5);
            $this->view['block6'] = $this->getVehiclesInRunning(5);

            return view('Dashboard/dashboard', $this->view);
        } else {
            return $this->response->redirect(base_url());
        }
    }

    public function block1()
    {
        $this->view['block1'] = $this->getVehiclesAvailableForBooking();

        return view('Dashboard/block1', $this->view);
    }

    public function block2()
    {
        $this->view['block2'] = $this->getVehiclesHavingBookingAssigned();

        return view('Dashboard/block2', $this->view);
    }

    public function block3()
    {
        $this->view['block3'] = $this->getVehiclesPaused();

        return view('Dashboard/block3', $this->view);
    }

    public function block4()
    {
        $this->view['block4'] = $this->getVehiclesEmpty();

        return view('Dashboard/block4', $this->view);
    }

    public function block5()
    {
        $this->view['block5'] = $this->getVehiclesInLoading();

        return view('Dashboard/block5', $this->view);
    }

    public function block6()
    {
        $this->view['block6'] = $this->getVehiclesInRunning();

        return view('Dashboard/block6', $this->view);
    }
}
