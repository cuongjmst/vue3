<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\BaseEloquentRepository;

class CategoryRepository extends BaseEloquentRepository
{
    public function model()
    {
        return Category::class;
    }
}