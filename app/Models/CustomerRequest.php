<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerRequest extends Model
{
    //
    protected $fillable = [
    'sku_code', 
    'vendor', 
    'brand', 
    'product_description', 
    'quantity',
    'customer_name', 
    'contact_no', 
    'associate',
    'customer_called', 
    'status', 
    'notes',
];

}
