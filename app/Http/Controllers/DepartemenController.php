<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required|unique:departemens,nama_departemen'
        ], [
            'department_name.required' => 'Nama departemen harus diisi',
            'department_name.unique' => 'Nama departemen sudah ada'
        ]);

        $departemen = new Departemen();
        $departemen->nama_departemen = $request->department_name;
        $departemen->save();

        $data = Departemen::all();

        return response()->json(['message' => 'Departemen created successfully', 'data' => $data]);
    }
}
