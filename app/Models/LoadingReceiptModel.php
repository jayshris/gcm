<?php

namespace App\Models;

use CodeIgniter\Model;

class LoadingReceiptModel extends Model
{
    protected $table            = 'loading_receipts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'consignment_no',
        'booking_id', 
        'office_id', 
        'booking_date', 
        'vehicle_id', 
        'loading_station', 
        'delivery_station', 
        'consignment_date', 
        'consignor_name', 
        'consignor_address', 
        'consignor_city', 
        'consignor_state', 
        'consignor_pincode', 
        'consignor_GSTIN',  
        'consignee_name', 
        'consignee_address',  
        'consignee_city', 
        'consignee_state', 
        'consignee_pincode', 
        'consignee_GSTIN',  
        'place_of_delivery_address',  
        'place_of_delivery_city', 
        'place_of_delivery_state', 
        'place_of_delivery_pincode', 
        'place_of_dispatch_address',  
        'place_of_dispatch_city', 
        'place_of_dispatch_state', 
        'place_of_dispatch_pincode', 
        'particulars',  
        'hsn_code', 
        'no_of_packages', 
        'actual_weight', 
        'charge_weight',  
        'payment_terms', 
        'e_way_bill_number', 
        'e_way_expiry_date', 
        'freight_charges_amount', 
        'invoice_boe_no',  
        'invoice_boe_date', 
        'invoice_value', 
        'reporting_datetime', 
        'releasing_datetime',
        'policy_date', 
        'policy_no',
        'consignor_id',
        'consignor_office',
        'consignee_id',
        'consignee_office',
        'customer_name',
        'transporter_bilti_no',
        'transporter_id',
        'transporter_office_id',
        'transporter_address',
        'transporter_city',
        'transporter_state',
        'transporter_pincode',
        'transporter_GSTIN',
        'approved',
        'status',
        'place_of_delivery_name',
        'place_of_dispatch_name',
        'edit_count',
        'is_approved',
        'is_update_vehicle',
        'seal_no',
        'supplier_office_id',
        'recipient_office_id',
        'added_by',
        'consignor_country_id',
        'consignee_country_id',
        'consignor_city_id',
        'consignee_city_id'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
