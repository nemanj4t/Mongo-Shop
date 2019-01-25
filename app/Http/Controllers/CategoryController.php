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
        if ($category)
        {
            // $products = Product::where('category._id', $category->_id)->get();
            if(!$category->children)
            {
                // ako nema dece onda se vracaju dodatni filteri po ko kojima
                // mogu da se pretrazuju proizvodi iz te kategorije
                // jer onda ova kategorija direktno sadrzi proizvode
                $filters = Category::getFiltersAndCount($category);
                dd($filters);
            }
            else
            {
                // ako ima dece onda treba rekurzivno da se prodje i pronadju
                // "listovi" podkategorije koje direktno sadrze decu
                // krece se od trenutne kategorije i traze se sve leaf kategorije
                $products = Category::getProductsForLeafCategories($category);
                dd($products);
            }
        }
    }
}
