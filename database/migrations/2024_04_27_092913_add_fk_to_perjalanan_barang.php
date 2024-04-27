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
        Schema::table('perjalanan_barangs', function (Blueprint $table) {
            $table->bigInteger('pengajuan_id')->unsigned();
            $table->foreign('pengajuan_id')->references('pengajuan_id')->on('pengajuan_barangs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perjalanan_barangs', function (Blueprint $table) {
            //
        });
    }
};
