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
        Schema::create('guru', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_sekolah')->nullable(false);
            $table->string('id_jabatan', 255)->nullable(true);
            $table->text('id_jurusan')->nullable(true);
            $table->text('id_kelas')->nullable(false);
            $table->string('nama_guru', 100);
            $table->string('email', 100);
            $table->string('no_wa', 20);
            $table->string('foto', 200)->nullable(true);
            $table->timestamps();
            $table->foreign('id_sekolah')->on('sekolah')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru');
    }
};
