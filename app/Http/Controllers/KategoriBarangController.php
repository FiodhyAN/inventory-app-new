<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriBarang;

class KategoriBarangController extends Controller
{
    public function index()
    {
        return view('admin.categories.index', [
            'categories' => KategoriBarang::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|unique:kategori_barangs,kategori_id|string',
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori = new KategoriBarang;
        $kategori->kategori_id = $request->kategori_id;
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        $categories = KategoriBarang::all();

        return response()->json(['message' => 'Kategori barang berhasil ditambahkan', 'categories' => $categories]);
    }

    public function edit(Request $request)
    {
        $kategori = KategoriBarang::find($request->kategori_id);
        return response()->json($kategori);
    }

    public function update(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|string',
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori = KategoriBarang::find($request->kategori_id);
        $kategori->nama_kategori = $request->nama_kategori;

        $kategori->save();

        return response()->json(['message' => 'Kategori barang berhasil diubah', 'categories' => KategoriBarang::all()]);
    }

    public function destroy(Request $request)
    {
        $kategori = KategoriBarang::find($request->kategori_id);

        $kategori->delete();

        return response()->json(['message' => 'Kategori barang berhasil dihapus', 'categories' => KategoriBarang::all()]);
    }
}