<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('user_id', '!=', auth()->id())->get();
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

    public function edit(Request $request)
    {
        $user = User::find($request->user_id);
        return response()->json($user);
    }

    public function destroy(Request $request)
    {
        $user = User::find($request->user_id);
        $user->delete();
        $users = User::all();

        return response()->json(['message' => 'User deleted successfully', 'users' => $users]);
    }
}
