<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function show(Request $request, $id)
    {
        $product = Product::find($id);
        //$product = Product::where('name', '=', $product)->first();

        return $product->toJson();
    }


}
