<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        if(Auth::user()) {
            $orders = Auth::user()->orders;
            return view('orders', compact('orders'));
        }
    }
}
