<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'brand',
        'name',
        'title',
        'specification',
        'description',
        'price',
        'quanity',
        'status',
        'last_modified_by'
    ];
}