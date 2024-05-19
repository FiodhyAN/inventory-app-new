<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('departemen')
            ->where('user_id', '!=', auth()->id())->get();
        $departments = Departemen::all();
        $departments = Departemen::all();
        return view('superadmin.user', compact('users', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $user = new User();
        $user->username = $request->username;
        $user->nama = $request->name;
        $user->password = bcrypt($request->password);
        $user->save();

        $users = User::where('user_id', '!=', auth()->id())->get();
        $departments = Departemen::all();

        $data = [
            'users' => $users,
            'departments' => $departments
        ];

        return response()->json(['message' => 'User created successfully', 'data' => $data]);
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

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $request->user_id . ',user_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'user' => $request->all()], 422);
        }

        $user = User::find($request->user_id);
        $user->username = $request->username;
        $user->nama = $request->name;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        $users = User::where('user_id', '!=', auth()->id())->get();
        $departments = Departemen::all();

        $data = [
            'users' => $users,
            'departments' => $departments
        ];

        return response()->json(['message' => 'User updated successfully', 'data' => $data]);
    }

    public function destroy(Request $request)
    {
        $user = User::find($request->user_id);
        $user->delete();
        $users = User::where('user_id', '!=', auth()->id())->get();

        return response()->json(['message' => 'User deleted successfully', 'users' => $users]);
    }

    public function updateDepartment(Request $request)
    {
        DB::beginTransaction();
        try {
            $validation = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,user_id',
                'departemen_id' => 'required|exists:departemens,departemen_id'
            ], [
                'user_id.required' => 'User ID harus diisi',
                'user_id.exists' => 'User ID tidak ditemukan',
                'departemen_id.required' => 'Departemen ID harus diisi',
                'departemen_id.exists' => 'Departemen ID tidak ditemukan'
            ]);

            if ($validation->fails()) {
                throw new \Exception($validation->errors());
            }

            $user = User::find($request->user_id);
            $user->departemen_id = $request->departemen_id;
            $user->save();

            DB::commit();
            $message = 'Berhasil Update Data Departemen';
            $data = true;
            $errors = [];
        } catch (\Exception $e) {
            DB::rollBack();
            $errors[] = $e->getMessage();
            $data = false;
            $message = 'Gagal Update Data Departemen';
        }

        return response()->json(['message' => $message, 'data' => $data, 'errors' => $errors]);
    }
}
