<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Category;

use Illuminate\Support\Facades\Hash;
class AdminController extends Controller
{
    public function index()
    {
      /*  $all_categories = Category::all()->map(function($category){
            unset($category->created_at);
            unset($category->updated_at);
            return $category;
        });*/
        return view('admin.home');
    }
}