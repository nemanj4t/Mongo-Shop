<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product;
use phpDocumentor\Reflection\DocBlock\Tags\Property;

class UserController extends Controller
{

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json($user);
    }

    public function getUsers()
    {
        $users = User::all();

        return response()->json($users);
    }

    public function wishList()
    {
        return view('wish-list');
    }

    public function getWishes()
    {
        return auth()->user()->products;
    }

    public function addWishes(Request $request)
    {
        $product = Product::find($request->product_id);
        $user = auth()->user();

        $user_ids = $product->user_ids;
        $product_ids = $user->product_ids;

        if(!$product_ids){
            $product_ids = Array();
        }

        if(!$user_ids) {
            $user_ids = Array();
        }

        $user_id = Array($user->id);
        $product_id = Array($product->id);

        $user_ids = array_merge($user_ids, $user_id);
        $product_ids = array_merge($product_ids, $product_id);

        $user->product_ids = $product_ids;
        $product->user_ids = $user_ids;

        $user->save();
        $product->save();
    }

    public function deleteWish(Request $request)
    {
        $user_key = -1;
        $product_key = -1;

        $product = Product::find($request->product_id);
        $user = auth()->user();

        $user_ids = $product->user_ids;
        $product_ids = $user->product_ids;

        foreach($user_ids as $key => $id) {
            if ($id === $user->id) {
                $user_key = $key;
                break;
            }
        }

        foreach($product_ids as $key => $id) {
            if ($id === $product->id) {
                $product_key = $key;
                break;
            }
        }

        $user->product_ids = array_splice($product_ids, 1, $product_key);
        $product->user_ids = array_splice($user_ids, 1, $user_key);

        $user->save();
        $product->save();
    }
}