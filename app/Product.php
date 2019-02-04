<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Product extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'products';

//    public $id;
//    public $name;
//    public $description;
//    public $available;
//    public $quantity;
//    public $price;
//    public $categories;
//    public $manufacturer_details; // manufacturer, model_number, release_date

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', null, 'product_ids', 'user_ids');
    }

    public static function reduceStock($id, $amount)
    {
        $product = Product::find($id);
        $product->stock = $product->stock - $amount;
        $product->save();
    }
}
