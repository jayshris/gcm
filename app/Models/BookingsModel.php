<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingsModel extends Model
{
    protected $table            = 'bookings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    // protected $allowedFields    = ['booking_number', 'booking_for', 'office_id', 'customer_id', 'customer_branch', 'customer_type', 'vehicle_type_id', 'vehicle_id', 'pickup_date', 'drop_date', 'booking_by', 'booking_date', 'rate_type', 'rate', 'guranteed_wt', 'freight', 'advance', 'balance', 'discount', 'bill_to_party', 'remarks', 'status', 'added_by', 'added_ip', 'added_date', 'approved', 'approved_date', 'approved_by', 'approved_ip','booking_type','lr_first_party','is_vehicle_assigned','loading_date_time','loading_doc','parent_id','loading_doc_2','loading_doc_3','commission'];
    protected $allowedFields    = ['booking_number', 'booking_for', 'office_id', 'customer_id', 'customer_branch', 'customer_type', 'vehicle_type_id', 'vehicle_id', 'pickup_date', 'drop_date', 'booking_by', 'booking_date', 'rate_type', 'rate', 'guranteed_wt', 'freight', 'advance', 'balance', 'discount', 'bill_to_party', 'remarks', 'status', 'added_by', 'added_ip', 'added_date', 'approved', 'approved_date', 'approved_by', 'approved_ip','booking_type','lr_first_party','is_vehicle_assigned','loading_date_time','loading_doc','parent_id','loading_doc_2','loading_doc_3','other_expenses','is_physical_pod_received','pod_received_date','courier_date','tracking_no','courier_delivery_date','courier_company_id'];

}
