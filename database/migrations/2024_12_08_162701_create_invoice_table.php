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
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number', 100);
            $table->string('id_paket', 100);
            $table->string('id_sekolah', 100);
            $table->string('nama_paket', 100);
            $table->string('jml_siswa', 100);
            $table->string('kuantiti', 100);
            $table->string('harga', 100);
            $table->string('total', 100);
            $table->json('paket_detail');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice');
    }
};
