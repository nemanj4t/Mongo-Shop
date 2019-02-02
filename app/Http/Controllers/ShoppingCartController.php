<?php

namespace App\Http\Controllers;
use App;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    public function get(Request $request)
    {
        if ($request->session()->has('shoppingCart')) {
            return response()->json(['shoppingCart' => $request->session()->get('shoppingCart')]);
        } else {
            return "Nije postavljen shopping cart.";
        }
    }

    public function add(Request $request)
    {
        if($request->session()->has('shoppingCart')) {
            $shoppingCart = $request->session()->get('shoppingCart');
            $exists = false;
            foreach($shoppingCart->products as $key => $item) {
                if($item['product']['_id'] == $request->newProduct['product']['_id']) {
                    $shoppingCart->products[$key]['quantity'] += 1;
                    //$shoppingCart->price += $item['product']['Cena']; // mozda ce nekad malim slovom da bude
                    $exists = true;
                    break;
                }
            }
            if(!$exists) {
                $shoppingCart->products[] = $request->newProduct;
                //$shoppingCart->price += $request->newproduct['product']['Cena'];
            }

            $request->session()->put('shoppingCart', $shoppingCart);

        } else {
            $cart = new App\ShoppingCart;
            $cart->products[] = $request->newProduct;
            //$cart->price += $request->newproduct['product']['Cena'];
            $request->session()->put('shoppingCart', $cart);
        }
    }

    public function remove(Request $request, $id) {
        if($request->session()->has('shoppingCart')) {
            $cart = $request->session()->get('shoppingCart');
            foreach($cart->products as $key => $item) {
                if($item['product']['_id'] == $id) {
                    //$cart->price -= $item['quantity'] * $item['product']['Cena'];
                    array_splice($cart->products, $key, 1);
                    break;
                }
            }
            $request->session()->put('shoppingCart', $cart);
            return response()->json(['success' => 'success'], 200);
        } else {
            return response()->json(['error' => 'invalid'], 401);
        }
    }

    public function decrement(Request $request, $id) {
        if($request->session()->has('shoppingCart')) {
            $cart = $request->session()->get('shoppingCart');
            foreach($cart->products as $key => $item) {
                if($item['product']['_id'] == $id) {
                    //$cart->price -= $item['product']['Cena'];
                    $cart->products[$key]['quantity'] -= 1;
                    $request->session()->put('shoppingCart', $cart);
                    break;
                }
            }
        }
    }
}
