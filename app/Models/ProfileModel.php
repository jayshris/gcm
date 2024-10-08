<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfileModel extends Model
{
	protected $table = 'profile';

	protected $primaryKey = 'id';

	protected $allowedFields = ['company_name','logged_in_userid', 'abbreviation', 'email', 'phone_number', 'landline_number', 'alternate_phone_number', 'otherid', 'gst', 'pan_no', 'company_logo', 'company_business_address', 'city', 'state', 'country', 'pincode', 'purchase_order_prefix', 'invoice_prefix', 'booking_prefix', 'loading_receipt_prefix','created_at', 'updated_at','proforma_invoice_prefix','tax_invoice_prefix'];
}
