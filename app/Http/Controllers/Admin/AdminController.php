<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

use Illuminate\Support\Facades\Hash;
class AdminController extends Controller
{
    public function index()
    {
        return view('admin.home');
    }
}