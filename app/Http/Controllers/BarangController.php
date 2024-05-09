<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        return view('admin.barangs.index');
    }

    public function create()
    {
        return view('admin.barangs.create');
    }

    public function store(Request $request)
    {
        // Validate the request...
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);

        $barang = new Barang;

        $barang->name = $request->name;
        $barang->price = $request->price;
        $barang->stock = $request->stock;

        $barang->save();

        return redirect()->route('admin.barangs.index');
    }

    public function edit($id)
    {
        $barang = Barang::find($id);

        return view('admin.barangs.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request...
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);

        $barang = Barang::find($id);

        $barang->name = $request->name;
        $barang->price = $request->price;
        $barang->stock = $request->stock;

        $barang->save();

        return redirect()->route('admin.barangs.index');
    }

    public function destroy($id)
    {
        $barang = Barang::find($id);

        $barang->delete();

        return redirect()->route('admin.barangs.index');
    }

    public function show($id)
    {
        $barang = Barang::find($id);

        return view('admin.barangs.show', compact('barang'));
    }
}