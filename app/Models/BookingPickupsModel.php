<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingPickupsModel extends Model
{
    protected $table            = 'booking_pickups';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['booking_id', 'sequence', 'city', 'state', 'pincode','city_id','country_id'];
}
