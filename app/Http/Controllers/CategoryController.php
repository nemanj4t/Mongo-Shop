<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;

class CategoryController extends Controller
{
    public function show(Request $request, $id)
    {
        $category = Category::find($id);
        if($category)   // ako postoji
        {
            // Prvo bi trebalo da se proveri da li ima
            // ili nema podkategorije jer u zavinosti
            // od toga zavisi da li ima filtere ili nema ???
            if(!$category->children)
            {
                // ako nema podkategorija onda
                $product = Product::where('category.name', $category->name)->first();
                return ($product->name) ? $product->name : "String";
            }
        }
    }
}
