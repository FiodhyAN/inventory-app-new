<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanBarang;
use App\Models\Barang;

class PengajuanController extends Controller
{
    public function index()
    {
        if (auth()->user()->is_admin) {
            $pengajuans = PengajuanBarang::all();
        } else {
            $pengajuans = PengajuanBarang::mine()->get();
        }
        $barangs = Barang::isFree()->get();
        return view('pengajuan.index',[
            'pengajuans' => $pengajuans,
            'barangs' => $barangs
        ]);
    }

    public function store(){
        $data = request()->validate([
            'barang_id' => 'required',
        ]);

        PengajuanBarang::create([
            'barang_id' => $data['barang_id'],
            'user_id' => auth()->user()->user_id,
            'status_pengajuan' => 's'
        ]);

        Barang::find($data['barang_id'])->update([
            'is_free' => false
        ]);

        return response()->json([
            'message' => 'Pengajuan berhasil disimpan'
        ]);
    }

    public function accept($id){
        $pengajuan = PengajuanBarang::find($id);
        $pengajuan->update([
            'status_pengajuan' => 'y'
        ]);

        return response()->json([
            'message' => 'Pengajuan berhasil diterima'
        ]);
    }   
    
    public function reject($id){
        $pengajuan = PengajuanBarang::find($id);
        $pengajuan->update([
            'status_pengajuan' => 'n'
        ]);

        return response()->json([
            'message' => 'Pengajuan berhasil ditolak'
        ]);
    }
    public function return($id){
        $pengajuan = PengajuanBarang::find($id);
        $pengajuan->update([
            'status_pengajuan' => 'r'
        ]);

        Barang::find($pengajuan->barang_id)->update([
            'is_free' => true
        ]);

        return response()->json([
            'message' => 'Barang berhasil dikembalikan'
        ]);
    }
}