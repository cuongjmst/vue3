<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\ImageRepository;

class IndexController extends Controller
{
    protected $productRepo;
    protected $categoryRepo;
    protected $imageRepo;

    public function __construct(
        ProductRepository $productRepo,
        CategoryRepository $categoryRepo,
        ImageRepository $imageRepo
    ) {
        $this->productRepo = $productRepo;
        $this->categoryRepo = $categoryRepo;
        $this->imageRepo = $imageRepo;
    }

    public function index()
    {
        $product = $this->productRepo->all();

        $hotProduct = $this->productRepo->getProductsByCategory(12);

        $newProduct = $this->productRepo->getProductsByCategory(11);

        $thumbnail = $this->imageRepo->getThumbnails();

        return response()->json([
            'product' => $product,
            'hotProduct' => $hotProduct,
            'newProduct' => $newProduct,
            'thumbnail' => $thumbnail
        ]);
    }

    public function productDetail($id)
    {
        $product = $this->productRepo->findById($id);

        if (!$product) {
            return response()->json([
                'status' => 401,
                'message' => 'Product not found'
            ]);
        }

        return response()->json([
            'status' => 200,
            'data' => $product
        ]);
    }

    public function addProduct(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
        ]);

        $product = $this->productRepo->create($request->all());

        return response()->json([
            'status' => 200,
            'data' => $product
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
        ]);

        $product = $this->productRepo->update($id, $request->all());

        return response()->json([
            'status' => 200,
            'data' => $product
        ]);
    }

    public function destroy($id)
    {
        $this->productRepo->delete($id);

        return response()->json([
            'status' => 200,
            'message' => 'Deleted successfully'
        ]);
    }
}