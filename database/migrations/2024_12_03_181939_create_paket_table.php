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
        Schema::create('paket', function (Blueprint $table) {
            $table->bigInteger('id')->nullable(false)->primary();
            $table->string('type', 100)->nullable(true);
            $table->string('nama_paket', 100);
            $table->string('siswa', 100);
            $table->string('active', 100);
            $table->string('price', 100);
            $table->text('detail')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket');
    }
};
