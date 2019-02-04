<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Cartalyst\Stripe\Exception\CardErrorException;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\CartItem;
use App\User;


class CheckoutController extends Controller 
{

    public function index()
    {
        return view('checkout');
    }

    public function payment(Request $request)
    {
        $shoppingCart = Auth::user()->shoppingCart;
        $cartItems = $shoppingCart->cartItems;
        $price = 0;
        foreach($cartItems as $item) {
            $price = $price + $item->product['price'];
        }

        if ($shoppingCart != null)
        {
            $metadata = [];
            foreach ($shoppingCart['cartItems'] as $index => $item){
                $metadata[] = ['item' . $index => $item['product']['name']];
            }
            try {
                $charge = Stripe::charges()->create([
                    'amount' => $price,
                    'currency' => 'RSD',
                    'source' => $request->stripeToken,
                    'description' => 'Your order',
                    'receipt_email' => $request->email,
                    'metadata' => [
                        'data1' => 'metadata 1',
                        'data2' => 'metadata 2',
                        'data3' => 'metadata 3',
                    ],
                ]);
                // save this info to your database
                // SUCCESSFUL
                //foreach($)
                $request->session()->forget('shoppingCart');
                foreach($cartItems as $item) {
                    Product::reduceStock($item->product_id, $item->quantity);
                    $item->delete();
                }
                return back()->with('success_message', 'Thank you! Your payment has been accepted.');
            } catch (CardErrorException $e) {
                // save info to database for failed
                return back()->withErrors('Error! ' . $e->getMessage());
            }
        }
        return back()->withErrors('Your shopping cart is Empty!');
    }
}