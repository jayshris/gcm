<?php

namespace App\Models;

use CodeIgniter\Model;

class VehicleModel extends Model
{
    protected $table = 'vehicle';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields = ['owner', 'party_id', 'vehicle_type_id', 'model_number_id', 'rc_number', 'rc_date', 'mfg', 'invoice_no', 'invoice_date',  'chassis_number', 'engine_number', 'colour', 'seating', 'unladen_wt', 'laden_wt', 'km_reading_start', 'image1', 'image2', 'image3', 'image4', 'trip_status', 'vehicle_status', 'created_at', 'status', 'working_status', 'updated_at', 'deleted_at', 'approved', 'approval_user_id', 'approval_user_type', 'approval_date', 'approval_ip_address','vehicle_class_id','address','city','state_id','pincode'];
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
