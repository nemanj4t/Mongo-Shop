<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Model;
use MongoDB\BSON\ObjectID;
use App\Product;
use Illuminate\Support\Collection;

class Category extends Model
{
    protected $fillable = ['name'];
    protected $connection = 'mongodb';
    protected $collection = 'categories';

    public function parent()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function children()
    {
        return $this->hasMany('App\Category', 'category_id');
    }

    public function products()
    {
        return $this->hasMany('App\Product', 'category_id');
    }

    public static function getFullPath(Category $category)
    {
        // Vraca sve putanju do te kategorije(ne vraca samu sebe)
        $path = [];
        $current = $category->parent;
        while($current != null) {
            array_unshift($path, ['name' => $current->name, 'id' => $current->id]);
            $current = $current->parent;
        }
        return $path;
    }


    public static function getProductsForLeafCategories(Category $category)
    {
        // Rekurzivno prolazi kroz sve podkategorije date kategorije
        // i vraca sve proizvode koji se nalaze u tom podstablu koje
        // krece od zadate kategorije
        if(!$category->children()->exists())    // !$category->children
        {
            // ako nema dece onda je ona leaf pa se traze proizvodi koji joj pripadaju
            $products = $category->products;
            return $products;
        }
        else
        {
            $all = new Collection();
            foreach($category->children as $child)
            {
                $products = self::getProductsForLeafCategories($child);
                $all = $all->merge($products);
            }
            return $all;
        }
    }

    public static function getFiltersAndCount(Category $category)
    {
        $filterArray = [];  // za svaki atribut kategorije se izbaci broj proizvoda

        if(!$category->details)
            return null;

        foreach ($category->details as $detail) {
            // $details je zapravo: Tip | Kapacitet | Brzina | Broj jezgara itd.
            // mozda sve moze u jednom upitu da se resi, ali neka ga za sad ovako
            // i da se promeni da na osnovu id-ja trazi bolje... ovako je zbog lakseg testiranja
            $allValues = Product::raw()->aggregate([
                [
                    '$match' => [
                        'category_id' => $category->id
                    ]
                ],
                [
                    '$group' => [
                        '_id' => '$' . $detail,
                        'count' => ['$sum' => 1]
                    ]
                ],
                [
                    '$sort' => [
                        '_id' => 1  // sortira po vrednosti => 1GB, 2GB, 4GB...
                    ]
                ]]);
            // allValues vraca npr. (name => count) "2GB" => 3, "8GB" => 4
            $values = [];
            foreach ($allValues as $document) {
                // oni proizvodi koji nemaju taj atribut ce se izbrojati
                // i imace ime => ""
                if ($document->_id != "") {
                    $values += [$document->_id => $document->count];
                }
            }
            $filterArray += [$detail => $values];
        }
        return $filterArray;
    }

    public static function buildTree($elements, $parentId = 0) 
    {
        $branch = array();
    
        foreach ($elements as $element) {
            if ($element->supercategory == $parentId) {
                $children = Category::buildTree($elements, $element->id);
                if ($children) {
                    $element->children = $children;
                }
                $branch[$element->name] = $element;
                unset($elements[$element->name]);
            }
        }
        return $branch;
    }

    public static function allChildren(Category $branch) 
    {
        $collectionOfCategories = $branch->children;
        $children = [];
        foreach($collectionOfCategories as $category) {
            $children[] = $category;
        }
        foreach($branch->children as $child) {
            $children = array_merge($children, Category::allChildren($child));
        }

        return array_reverse($children);
    }

    public static function getMainCategories()
    {
        //$mainCategories = self::whereRaw(['category_id' => ['$exists' => false]])->get();
        $mainCategories = self::where('category_id', null)->get();
        if(count($mainCategories) === 1) {
            return $mainCategories->first()->children;
        } else {
            return $mainCategories;
        }
    }

    /*public static function allParents(Categoory $node) 
    {
        $collectionOfParent = $node->parent;
        $parents = [];
        foreach($collectionOfParent as $parent) {
            $parents[] = $parent;
        }

        $parents = array_merge($parents, Category::allParents($node->parent));
        
        return $parents;
    }*/
}
