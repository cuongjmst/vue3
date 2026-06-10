<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bills';

    protected $fillable = [
        'customer_name',
        'customer_address',
        'customer_phone',
        'customer_email',
        'payment_method',
        'payment_amount',
        'order_note',
        'status',
        'last_modified_by'
    ];
}