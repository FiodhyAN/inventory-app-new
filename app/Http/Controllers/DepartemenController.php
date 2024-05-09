<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:departemen,nama_departemen'
        ]);

        $departemen = new Departemen();
        $departemen->name = $request->name;
        $departemen->save();

        return response()->json(['message' => 'Departemen created successfully']);
    }
}
