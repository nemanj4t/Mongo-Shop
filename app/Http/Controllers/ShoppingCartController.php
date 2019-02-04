<?php

namespace App\Http\Controllers;
use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShoppingCartController extends Controller
{
    public function shoppingCart()
    {
        return view('shopping-cart');
    }

    public function get(Request $request)
    {
        if(Auth::user()) {
            // Ako je ulogovan onda se vadi iz baze
            $user = $request->user();
            $cart = $user->shoppingCart->transformToArray();
            return response()->json(['shoppingCart' => $cart]);
        } else {
            if ($request->session()->has('shoppingCart')) {
                return response()->json(['shoppingCart' => $request->session()->get('shoppingCart')]);
            } else {
                return "Nije postavljen shopping cart.";
            }
        }
    }

    public function add(Request $request)
    {
        if(Auth::user()) {
            // Ako je ulogovan user
            $user = $request->user();
            $user->shoppingCart->addItem($request->newProduct);
        } else {
            // Ako nije onda se koristi sesija
            if($request->session()->has('shoppingCart')) {
                $shoppingCart = $request->session()->get('shoppingCart');
                $exists = false;
                foreach($shoppingCart['cartItems'] as $key => $item) {
                    if($item['product']['_id'] == $request->newProduct['product']['_id']) {
                        $shoppingCart['cartItems'][$key]['quantity'] += 1;
                        $shoppingCart['price'] += $item['product']['price'];
                        $exists = true;
                        break;
                    }
                }
                if(!$exists) {
                    $item = [
                        'product' => $request->newProduct['product'],
                        'quantity' => $request->newProduct['quantity']
                    ];
                    array_push($shoppingCart['cartItems'], $item);
                    $shoppingCart['price'] += $item['product']['price'];
                }
                $request->session()->put('shoppingCart', $shoppingCart);

            } else {
                $item = [
                    'product' => $request->newProduct['product'],
                    'quantity' => $request->newProduct['quantity']
                ];
                $items = [];
                $items[] = $item;
                $cart = [
                    'cartItems' => $items,
                    'price' => $item['product']['price']
                ];
                $request->session()->put('shoppingCart', $cart);
            }
        }
    }

    public function remove(Request $request, $id) {
        if(Auth::user()) {
            $user = $request->user();
            $user->shoppingCart->removeItem($id);
        } else {
            if($request->session()->has('shoppingCart')) {
                $cart = $request->session()->get('shoppingCart');
                foreach ($cart['cartItems'] as $key => $item) {
                    if ($item['product']['_id'] == $id) {
                        $cart['price'] -= $item['quantity'] * $item['product']['price'];
                        array_splice($cart['cartItems'], $key, 1);
                        break;
                    }
                }
                $request->session()->put('shoppingCart', $cart);
            }
        }
    }

    public function decrement(Request $request, $id)
    {
        if (Auth::user()) {
            $user = $request->user();
            $user->shoppingCart->decrementItemQuantity($id);
        } else {
            if ($request->session()->has('shoppingCart')) {
                $cart = $request->session()->get('shoppingCart');
                foreach ($cart['cartItems'] as $key => $item) {
                    if ($item['product']['_id'] == $id) {
                        $cart['price'] -= $item['product']['price'];
                        $cart['cartItems'][$key]['quantity'] -= 1;
                        $request->session()->put('shoppingCart', $cart);
                        break;
                    }
                }
            }
        }
    }
}
