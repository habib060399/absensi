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
        Schema::create('sekolah', function (Blueprint $table) {
            // $table->id();
            $table->bigInteger('id')->nullable(false)->primary();
            $table->bigInteger('id_user')->nullable(false);
            $table->bigInteger('id_wa')->nullable(true);
            $table->bigInteger('id_paket')->nullable(true);
            $table->string('id_mesin', 17);
            $table->string('id_slug_user', 50);
            $table->string('nama_sekolah', 100);
            $table->string('email', 100);
            $table->string('no_hp', 100);
            $table->string('pendidikan', 100);
            $table->string('npsn', 100);
            $table->string('limit_siswa', 100)->nullable(true);
            $table->string('th_ajaran_awal', 100)->nullable(true);
            $table->string('th_ajaran_akhir', 100)->nullable(true);
            $table->timestamps();
            $table->foreign('id_user')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('id_wa')->on('broadcast')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sekolah');
    }
};
