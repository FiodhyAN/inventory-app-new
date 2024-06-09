<?php

namespace App\Http\Controllers;

use App\Events\BarangMasuk;
use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        $kategori = KategoriBarang::all();
        return view('admin.barangs.index', [
            'barangs' => $barangs,
            'categories' => $kategori
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validation = Validator::make($request->all(), [
                'barang_id' => 'required|unique:barangs,barang_id',
                'nama_barang' => 'required'
            ], [
                'barang_id.required' => 'ID Barang harus diisi',
                'barang_id.unique' => 'ID Barang sudah ada',
                'nama_barang.required' => 'Nama Barang harus diisi'
            ]);

            if ($validation->fails()) {
                throw new \Exception($validation->errors());
            }

            $barang = Barang::create([
                'barang_id' => $request->barang_id,
                'nama_barang' => $request->nama_barang,
                'is_free' => true
            ]);
            
            $barangs = Barang::all();
            $categories = KategoriBarang::all();

            event(new BarangMasuk($request->barang_id, 'Gudang'));

            $data = [
                'barangs' => $barangs,
                'categories' => $categories
            ];

            $errors = [];
            $message = 'Barang created successfully';
            $data = $data;
            $code = 200;

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $errors[] = $e->getMessage();
            $message = 'Failed to create barang';
            $data = null;
            $code = 500;
        }

        return response()->json([
            'message' => $message,
            'errors' => $errors,
            'data' => $data
        ], $code);
    }

    public function updateKategori(Request $request)
    {
        DB::beginTransaction();
        try {
            $validation = Validator::make($request->all(), [
                'barang_id' => 'required|exists:barangs,barang_id',
                'kategori_id' => 'required|exists:kategori_barangs,kategori_id'
            ], [
                'barang_id.required' => 'ID Barang harus diisi',
                'barang_id.exists' => 'ID Barang tidak ditemukan',
                'kategori_id.required' => 'ID Kategori harus diisi',
                'kategori_id.exists' => 'ID Kategori tidak ditemukan'
            ]);

            if ($validation->fails()) {
                throw new \Exception($validation->errors());
            }

            $barang = Barang::find($request->barang_id);
            $barang->kategori_id = $request->kategori_id;
            $barang->save();

            DB::commit();
            $message = 'Berhasil Update Kategori Barang';
            $data = true;
            $errors = [];
        } catch (\Exception $e) {
            DB::rollBack();
            $errors[] = $e->getMessage();
            $message = 'Gagal Update Kategori Barang';
            $data = false;
        }

        return response()->json([
            'message' => $message,
            'errors' => $errors,
            'data' => $data
        ]);
    }

    public function edit(Request $request)
    {
        $barang = Barang::find($request->barang_id);

        return response()->json([
            'data' => $barang
        ]);
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $validation = Validator::make($request->all(), [
                'barang_id' => 'required|unique:barangs,barang_id,' . $request->old_barang_id . ',barang_id',
                'nama_barang' => 'required'
            ], [
                'barang_id.required' => 'ID Barang harus diisi',
                'barang_id.exists' => 'ID Barang tidak ditemukan',
                'nama_barang.required' => 'Nama Barang harus diisi'
            ]);

            if ($validation->fails()) {
                throw new \Exception($validation->errors(), 422);
            }

            $barang = Barang::find($request->old_barang_id);
            $barang->barang_id = $request->barang_id;
            $barang->nama_barang = $request->nama_barang;
            $barang->save();

            $barangs = Barang::all();
            $categories = KategoriBarang::all();
            $data = [
                'barangs' => $barangs,
                'categories' => $categories
            ];

            DB::commit();
            $message = 'Berhasil Update Barang';
            $errors = [];
            $code = 200;
        } catch (\Exception $e) {
            DB::rollBack();
            $errors[] = $e->getMessage();
            $message = 'Gagal Update Barang';
            $data = false;
            $code = $e->getCode();
        }

        return response()->json([
            'message' => $message,
            'errors' => $errors,
            'data' => $data
        ], $code);
    }

    public function perjalanan(Barang $barang)
    {
        $perjalanans = $barang->perjalanan;
        return view('admin.barangs.perjalanan', [
            'perjalanans' => $perjalanans,
            'barang' => $barang
        ]);
    }
}