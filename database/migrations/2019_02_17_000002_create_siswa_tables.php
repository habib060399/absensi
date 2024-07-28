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
        Schema::create('siswa', function (Blueprint $table) {
            $table->uuid('id')->nullable(false)->primary();
            $table->string('id_sekolah', 100);
            $table->string('id_jurusan', 100);
            $table->string('id_kelas', 100);
            $table->string('nama_siswa', 200);
            $table->string('email', 100);
            $table->string('foto', 100)->nullable(true);
            $table->string('rfid', 100);
            $table->string('no_hp', 100);
            $table->string('no_hp_ortu', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
