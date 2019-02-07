<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Notifications\NewProduct;
use App\User;
use App\Product;
use Notification;

class ProductController extends Controller
{

    public function show($id)
    {
        $product = Product::findOrFail($id);

        if(!$product) {
            return abort(404);
        }

        $s1 = 0;
        $s2 = 0;
        $s3 = 0;
        $s4 = 0;
        $s5 = 0;

        foreach($product->comments as $comment)
        {
            switch($comment->rating) {
                case "1": $s1++;
                break;
                case "2": $s2++;
                break;
                case "3": $s3++;
                break;
                case "4": $s4++;
                break;
                case "5": $s5++;
                break;
            }
        }

        return view('products.show', compact('product', 's1', 's2', 's3', 's4', 's5'));
    }

    public function store(Request $request)
    {
        $product = new Product;
        $product->name = $request->name;
        $product->image = $request->image;
        $product->category_id = $request->category["_id"];
        $product->stock = intval($request->stock);
        $product->price = floatval($request->price);
        foreach($request->additionalFields as $key => $value) {
            $product[$key] = $value;
        }
        $product->product_properties = $request->productFields;
        $product->recommendation = false;

        $product->save();
        $product = Product::orderBy('created_at', 'desc')->first();
        $users = User::all();
        Notification::send($users, new NewProduct($product));

        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->name = $request->name;
        $product->image = $request->image;
        $product->category_id = $request->category["_id"];
<<<<<<< HEAD
        $product->stock = intval($request->stock);
        $product->price = floatval($request->price);
=======
        $product->stock = $request->stock;
        $product->price = $request->price;

>>>>>>> bf096b60f7b4d80b5dcb2c185dbe33c5714d5106
        foreach($request->additionalFields as $key => $value) {
            $product[$key] = $value;
        }
        $product->product_properties = $request->productFields;
        $product->recommendation = $request->recommendation;

        if ($request->fieldsToDelete != null) {
            foreach($request->fieldsToDelete as $key => $field) {
                $product->unset($key);
            }
        }

        $product->save();

        return response()->json($product);
    }

    public function destroy(Request $request, $id)
    {
        $product = Product::find($id);
        $product->delete();

        return response()->json($product);
    }

    public function getProducts()
    {
        $products = Product::all();

        return response()->json($products);
    }

    public function getById($id)
    {
        $product = Product::find($id);

        return response()->json($product);
    }

}
