<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{

    public function show($id)
    {
        $product = Product::findOrFail($id);

        if(!$product) {
            return abort(404);
        }

        return view('products.show', compact('product'));
    }

    public function store(Request $request)
    {
        //dd($request);
        $product = new Product;
        $product->name = $request->name;
        $product->image = $request->image;
        $product->category_id = $request->category["_id"];
        $product->stock = $request->stock;
        $product->price = $request->price;
        foreach($request->additionalFields as $key => $value) {
            $product[$key] = $value;
        }
             
        $product->save();

        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->name = $request->name;
        $product->image = $request->image;
        $product->category_id = $request->category["_id"];
        $product->stock = $request->stock;
        $product->price = $request->price;
        foreach($request->additionalFields as $key => $value) {
            $product[$key] = $value;
        }
        $product->save();

        return response()->json($product);
    }

    public function destroy(Request $request, $id)
    {
        $product = Product::find($id);
        $product->delete();

        return response()->json($product);
    }

    public function getProducts()
    {
        $products = Product::all();

        return response()->json($products);
    }

    public function getById($id)
    {
        $product = Product::find($id);

        return response()->json($product);
    }

}
