<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DepartemenController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate the request
            $validation = Validator::make($request->all(), [
                'department_name' => 'required|unique:departemens,nama_departemen'
            ], [
                'department_name.required' => 'Nama departemen harus diisi',
                'department_name.unique' => 'Nama departemen sudah ada'
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validation->errors()
                ], 422);
            }

            // Create the new department
            $departemen = new Departemen();
            $departemen->nama_departemen = $request->department_name;
            $departemen->save();

            $departemen = Departemen::all();

            DB::commit();
            return response()->json([
                'message' => 'Departemen created successfully',
                'data' => [
                    'departemen' => $departemen,
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create departemen',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $validation = Validator::make($request->all(), [
                'departemen_id' => 'required|exists:departemens,departemen_id',
                'nama_departemen' => 'required|unique:departemens,nama_departemen,' . $request->departemen_id . ',departemen_id'
            ], [
                'departemen_id.required' => 'ID departemen harus diisi',
                'departemen_id.exists' => 'ID departemen tidak ditemukan',
                'nama_departemen.required' => 'Nama departemen harus diisi',
                'nama_departemen.unique' => 'Nama departemen sudah ada'
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validation->errors()
                ], 422);
            }

            $departemen = Departemen::find($request->departemen_id);
            $departemen->nama_departemen = $request->nama_departemen;
            $departemen->save();

            $departemen = Departemen::all();

            DB::commit();
            return response()->json([
                'message' => 'Departemen updated successfully',
                'data' => [
                    'departemen' => $departemen,
                ]
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to update departemen',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $validation = Validator::make($request->all(), [
                'departemen_id' => 'required|exists:departemens,departemen_id'
            ], [
                'departemen_id.required' => 'ID departemen harus diisi',
                'departemen_id.exists' => 'ID departemen tidak ditemukan'
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validation->errors()
                ], 422);
            }

            $users = User::where('departemen_id', $request->departemen_id)->get();
            foreach ($users as $user) {
                $user->departemen_id = null;
                $user->save();
            }

            $departemen = Departemen::find($request->departemen_id);
            $departemen->delete();


            $departemen = Departemen::all();

            DB::commit();
            return response()->json([
                'message' => 'Departemen deleted successfully',
                'data' => [
                    'departemen' => $departemen,
                ]
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to delete departemen',
                'errors' => $e->getMessage()
            ], 500);
        }
    }
}
