<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ProductDetail;
use App\Http\Resources\ProductDetailIndexResource;
use App\Http\Resources\ProductDetailShowResource;

class ProductDetailController extends Controller
{
    public function index()
    {
        return ProductDetailIndexResource::collection(
            ProductDetail::all()
        );
    }

    public function show($id)
    {
        return new ProductDetailShowResource(ProductDetail::findOrFail($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'stock' => 'required|max:1000',
            'type' => 'required|max:5',
            'size' => 'required',
            'product_id' => 'required|exists:products,id'
        ]);
        $product_detail = ProductDetail::make($data);
        $product_detail->save();
        return new ProductDetailShowResource($product_detail);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'stock' => 'required|max:1000',
            'type' => 'required|max:5',
            'size' => 'required',
            'product_id' => 'required|exists:products,id'
        ]);

        $product_detail = ProductDetail::where('id', $id)->update($data);
        return new ProductDetailShowResource($product_detail);
    }
}
