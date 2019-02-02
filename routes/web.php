<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Http\Request;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function(){
    Route::get('/', 'LoginController@showLoginForm')->name('admin.showLoginForm');
    Route::post('/', 'LoginController@login')->name('admin.login');
    Route::group(['middleware' => 'auth:admin'], function(){
        Route::get('/home', 'AdminController@index')->name('admin.home');
        Route::post('/logout', 'LoginController@logout')->name('admin.logout');
    });
});

Route::get('/home', 'HomeController@index')->name('home');


// Kada se promeni kategorija onda se izbace
// proizvodi koji spadaju tu kategoriju ???
Route::get('/categories', 'CategoryController@index');
Route::get('/categories/{category}', 'CategoryController@show');


Route::get('/products/{product}', 'ProductController@show');
Route::get('/products/create', 'ProductController@create');
Route::get('/products/edit', 'ProductController@edit');
Route::post('/products', 'ProductController@store');
Route::put('/products', 'ProductController@update');
Route::delete('/products/{product}', 'ProductController@destroy');

// Test za sesije
Route::get('/shoppingcart/get', function(Request $request) {
    if($request->session()->has('shoppingCart')) {
        return response()->json(['shoppingCart' => $request->session()->get('shoppingCart')]);
    } else {
        return "Nije postavljen shopping cart.";
    }
});

Route::post('/shoppingcart/add', function(Request $request) {
     if($request->session()->has('shoppingCart')) {
        $request->session()->push('shoppingCart.products', $request->newProduct);
     } else {
         $cart = new App\ShoppingCart;
         $cart->products[] = $request->newProduct;
         $request->session()->put('shoppingCart', $cart);
     }
});

