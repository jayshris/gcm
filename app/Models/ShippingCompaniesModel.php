<?php

namespace App\Models;

use CodeIgniter\Model;

class ShippingCompaniesModel extends Model
{
    protected $table            = 'shipping_companies';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'status', 'added_date', 'added_by', 'added_ip', 'updated_date', 'updated_by', 'updated_ip', 'isDeleted'];
}
