<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        if (request()->filled('search')) {
            $products = Product::query()->whereLike('name', request('search'))->paginate();
        } else {
            $products = Product::paginate();
        }
        return response()->json($products);
    }


    public function store(ProductRequest $request)
    {
        return Product::create($request->all());
    }


    public function show(Product $product)
    {
        //
    }


    public function update(Request $request, Product $product)
    {
        //
    }


    public function destroy(Product $product)
    {
        //
    }
}
