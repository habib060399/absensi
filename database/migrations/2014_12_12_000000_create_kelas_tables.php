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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_user')->nullable(false);
            $table->string('id_sekolah', 100);
            $table->bigInteger('id_jurusan')->nullable(false);
            $table->string('kelas', 50);
            $table->timestamps();
            $table->foreign('id_user')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('id_jurusan')->on('jurusan')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
