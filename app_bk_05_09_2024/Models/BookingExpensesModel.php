<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingExpensesModel extends Model
{
    protected $table            = 'booking_expenses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['booking_id', 'expense', 'value', 'bill_to_party'];
}
