<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\BaseEloquentRepository;
use Illuminate\Support\Facades\DB;

class ProductRepository extends BaseEloquentRepository
{
    public function model()
    {
        return Product::class;
    }

    public function getProductsIndex()
    {
        return DB::table('products')
            ->leftJoin('images', function ($join) {
                $join->on('products.id', '=', 'images.product_id')
                     ->where('images.role', 'thumbnail');
            })
            ->select('products.*', 'images.url')
            ->get();
    }

    public function getProductsByCategory($id)
    {
        return DB::table('products')
            ->join('product_category', 'products.id', '=', 'product_category.product_id')
            ->leftJoin('images', function ($join) {
                $join->on('products.id', '=', 'images.product_id')
                     ->where('images.role', 'thumbnail');
            })
            ->where('product_category.category_id', $id)
            ->select('products.*', 'images.url')
            ->get();
    }
}