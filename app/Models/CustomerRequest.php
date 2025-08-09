<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerRequest extends Model
{

    const STATUSES = [
        'requested',
        'ordered_from_vendor',
        'ready_for_pickup',
        'called_to_pickup',
        'completed',
        'cancelled',
        'item_on_backorder',
        'item_discontinued',
        'called_item_in_bo',
        'called_item_dcd',
        'called_did_not_pickup',       // New
        'called_went_to_voicemail',    // New
    ];

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
