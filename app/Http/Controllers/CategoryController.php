<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use MongoDB\BSON;

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
                // ako ima filtere
                if(!empty($request->all())) {
                    $products = self::buildFilterQuery($request->all()); // filtrira
                    return compact('products');
                }
                else {
                    $products = Product::where('category.name', $category->name)->get();
                }
                // ako nema dece onda se vracaju filteri po kojima mogu da se pretrazuju proizvodi
                $filters = Category::getFiltersAndCount($category);
                $filters = array_filter($filters, function($filter) {   // izbace se prazni
                    return (!empty($filter));
                });

                // treba da vratim i sve prethodnike da bih prikazao path

                return compact('filters', 'category', 'products');
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

    private static function buildFilterQuery($filters)
    {
        // treba da dodam i da matchuje kategoriju prvo
        $query = [['$match' => ['$or' => []]]]; // $query[0]['$match']['$or'] ovde ubacujem
        foreach($filters as $key => $filter) {
            $filterArray = [$key => ['$in' => []]];  // $filterArray[$key]['$in']
            foreach($filter as $value) {
                $filterArray[$key]['$in'][] = $value;
            }
            $query[0]['$match']['$or'][] = $filterArray;
        }
        $result = Product::raw()->aggregate($query);
        $products = [];
        foreach($result as $doc) {
            $products[] = $doc;
        }
        return $products;
    }
}
