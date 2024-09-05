<?php

namespace App\Models;

use CodeIgniter\Model;

class VehicleTModel extends Model
{
    protected $table = 'vehicle_model';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = ['vehicle_type_id', 'body_type_id', 'mfg_id', 'model_no', 'laden_weight', 'unladen_weight', 'fuel_type_id', 'status', 'created_at', 'updated_at', 'created_by', 'created_ip', 'updated_by', 'updated_ip', 'deleted_at'];
}
