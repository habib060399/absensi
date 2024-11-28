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
        Schema::create('jurusan', function (Blueprint $table) {
            // $table->id();
            $table->bigInteger('id')->nullable(false)->primary();
            $table->bigInteger('id_sekolah');
            $table->string('nama_jurusan', 100);
            $table->timestamps();
            $table->foreign('id_sekolah')->on('sekolah')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurusan');
    }
};
