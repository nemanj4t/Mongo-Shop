<?php
/**
 * Created by PhpStorm.
 * User: vtmr
 * Date: 2/1/19
 * Time: 10:43 PM
 */

namespace App;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ShoppingCart extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'shoppingCarts';

    public function cartItems()
    {
        return $this->hasMany('App\CartItem', 'shoppingCart_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function addItem($cartItem)
    {
        $product = Product::find($cartItem['product']['_id']);
        if($product) {
            $newCartItem = new CartItem;
            $newCartItem->product_id = $product->id;
            $newCartItem->shoppingCart_id = $this->id;
            $newCartItem->quantity = $cartItem['quantity'];
            $newCartItem->save();
        }
    }

    public function evaluate()
    {
        // Preracuna se cena korpe
        $price = 0;
        foreach($this->cartItems as $item) {
            if($item->product == null) {
                $item->delete(); // ako proizvod vise ne postoji onda se izbrise
            } else {
                $price += $item->product->price * $item->quantity;
            }
        }
        $this->price = $price;
        $this->save();
    }

    public function transformToArray()
    {
        $items = [];
        foreach($this->cartItems as $item) {
            $items[] = [
                'product' => $item->product,
                'quantity' => $item->quantity
            ];
        }
        $cart = [
            'cartItems' => $items,
            'price' => $this->price
        ];
        return $cart;
    }

    public function mergeWithSessionCart($sessionCart)
    {
        if(!empty($sessionCart['cartItems'])) {
            foreach($sessionCart['cartItems'] as $item) {
                $this->addItem($item);
            }
            $this->evaluate();
        }
    }
}
