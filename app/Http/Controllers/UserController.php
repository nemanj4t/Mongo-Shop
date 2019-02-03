<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

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
}