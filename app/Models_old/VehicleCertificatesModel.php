<?php

namespace App\Models;

use CodeIgniter\Model;

class VehicleCertificatesModel extends Model
{
    protected $table            = 'vehiclewise_certificates';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['vehicle_id', 'certificate_id', 'party_id', 'certificate_no', 'issue_date', 'expiry_date', 'img1', 'img2', 'added_by', 'added_ip', 'added_date'];
}
