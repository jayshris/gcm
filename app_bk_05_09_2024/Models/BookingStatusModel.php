<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingStatusModel extends Model
{
    protected $table            = 'booking_status';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['status_name', 'status_bg', 'added_date', 'updated_date'];
}
