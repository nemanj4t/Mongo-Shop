<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use function MongoDB\BSON\toJSON;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories');
    }

    public function show(Request $request, $id)
    {
        $category = Category::find($id);
        if ($category)
        {
            // ako nije ajax onda se samo vrati view sa kategorijom
            if(!$request->ajax()) return view('categories', compact('category'));

            if(!$category->children)
            {
                // ako nema dece onda se vracaju filteri po kojima mogu da se pretrazuju proizvodi
                $filters = Category::getFiltersAndCount($category);
                $products = Product::where('category.name', $category->name)->get();
                // treba da vratim i sve prethodnike da bih prikazao path

                return compact('category', 'filters', 'products');
            }
            else
            {
                // ako ima dece onda treba rekurzivno da se prodje i pronadju
                // "listovi" podkategorije koje direktno sadrze decu
                $products = Category::getProductsForLeafCategories($category);

                return compact('category', 'products');
            }
        }
        else
        {
            // ovde neki redirect da se odradi
            return view('categories');
        }
    }
}
