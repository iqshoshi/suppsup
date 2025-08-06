<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerRequest extends Model
{
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
        'called_to_pickup_at',  // add this too since you'll update it
    ];

    // Cast the called_to_pickup_at field to a datetime (Carbon instance)
    protected $casts = [
        'called_to_pickup_at' => 'datetime',
    ];
}
