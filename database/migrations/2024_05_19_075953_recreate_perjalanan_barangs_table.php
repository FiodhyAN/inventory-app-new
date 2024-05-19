<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the existing table
        Schema::dropIfExists('perjalanan_barangs');

        // Create the new table
        Schema::create('perjalanan_barangs', function (Blueprint $table) {
            $table->bigIncrements('perjalanan_id');
            $table->dateTime('tanggal');
            $table->string('lokasi');

            $table->string('barang_id')
                ->references('barang_id')
                ->on('barangs')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the new table
        Schema::dropIfExists('perjalanan_barangs');
    }
};
