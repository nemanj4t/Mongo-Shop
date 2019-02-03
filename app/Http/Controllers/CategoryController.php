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

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $category = new Category;
        $category->name = $request->name;
        $category->category_id = $request->category_id;
        $category->details = $request->additionalFields;
        $category->amount = 0;
        $category->save();
        return response()->json($category);
    }

    public function update(Request $request)
    {
        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->category_id = $request->category_id;
        $category->details = $request->additionalFields;
        $category->save();
        return response()->json($category);
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

    public function getCategories()
    {
        $categories = Category::all();
        $tree = Category::buildTree($categories, 0);

        $response = ['tree' => $tree, 'categories' => $categories];

        return response()->json($response);
    }

    public function getById(Request $request)
    {
        $category = Category::find($request->id);

        return response()->json($category);
    }

    public function destroy(Request $request, $id)
    {
       // $result = [];
        $category = Category::find($id);
        $children =  Category::allChildren($category);
        foreach($children as $child) {
            $child->delete();
        }
        $category->delete();
        return response()->json($children);
    }

}
