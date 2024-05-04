<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('superadmin.user', compact('users'));
    }

    public function updateAdmin(Request $request)
    {
        $user = User::find($request->user_id);
        if ($user->is_admin) {
            $user->is_admin = false;
        } else {
            $user->is_admin = true;
        }
        $user->save();

        return response()->json(['message' => 'User updated successfully']);
    }
}
