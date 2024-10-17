<?php

namespace App\Models;

use CodeIgniter\Model;

class ProformaInvoiceBookingModel extends Model
{
    protected $table            = 'proforma_invoice_bookings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['proforma_invoice_id','booking_id'];
 
}
