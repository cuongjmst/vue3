<?php

namespace App\Repositories\Eloquent;

use App\Models\Image;
use App\Repositories\BaseEloquentRepository;

class ImageRepository extends BaseEloquentRepository
{
    public function model()
    {
        return Image::class;
    }

    public function getThumbnails()
    {
        return Image::where('role', 'thumbnail')->get();
    }
}