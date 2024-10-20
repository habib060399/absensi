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
            $table->id();
            $table->bigInteger('id_user')->nullable(false);
            $table->bigInteger('id_wa')->nullable(true);
            $table->string('id_mesin', 17);
            $table->string('nama_sekolah', 100);
            $table->string('email', 100);
            $table->string('pendidikan', 100);
            $table->string('npsn', 100);
            $table->timestamps();
            $table->foreign('id_user')->on('users')->references('id');
            $table->foreign('id_wa')->on('wa')->references('id');
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
