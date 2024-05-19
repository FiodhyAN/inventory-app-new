<?php

namespace App\Listeners;

use App\Events\BarangMasuk;
use App\Models\PerjalananBarang;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CatatBarangMasuk
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BarangMasuk $event): void
    {
        $barang = $event->barang;
        $lokasi = $event->lokasi;
        PerjalananBarang::create([
            'tanggal' => now(),
            'lokasi' => $lokasi,
            'barang_id' => $barang->barang_id,
        ]);
    }
}
