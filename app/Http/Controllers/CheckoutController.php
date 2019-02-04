<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Cartalyst\Stripe\Exception\CardErrorException;

class CheckoutController extends Controller 
{

    public function index()
    {
        return view('checkout');
    }

    public function payment(Request $request)
    {
        $shoppingCart = ($request->session()->get('shoppingCart'));

        if ($shoppingCart != null)
        {
            $metadata = [];
            foreach ($shoppingCart['cartItems'] as $index => $item){
                $metadata[] = ['item' . $index => $item['product']['name']];
            }
            try {
                $charge = Stripe::charges()->create([
                    'amount' => $shoppingCart['price'],
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
                $request->session()->forget('shoppingCart');
                return back()->with('success_message', 'Thank you! Your payment has been accepted.');
            } catch (CardErrorException $e) {
                // save info to database for failed
                return back()->withErrors('Error! ' . $e->getMessage());
            }
        }
        return back()->withErrors('Your shopping cart is Empty!');
    }
}