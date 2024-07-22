<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingDropsModel extends Model
{
    protected $table            = 'booking_drops';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['booking_id', 'sequence', 'city', 'state', 'pincode'];
}
