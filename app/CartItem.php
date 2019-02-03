<?php
/**
 * Created by PhpStorm.
 * User: vtmr
 * Date: 2/3/19
 * Time: 1:45 PM
 */

namespace App;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class CartItem extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'cartItems';

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }

    public function shoppingCart()
    {
        return $this->belongsTo('App\ShoppingCart', 'shoppingCart_id');
    }
}
