<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = [
        'product_id',
        'url',
        'role',
        'last_modified_by'
    ];
}