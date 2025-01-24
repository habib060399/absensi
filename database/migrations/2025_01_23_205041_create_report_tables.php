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
        Schema::create('report_tables', function (Blueprint $table) {
            $table->id();
            $table->string('id_sekolah', 100);
            $table->string('id_jurusan', 255);
            $table->string('id_kelas', 255);
            $table->string('nama_guru', 100);
            $table->string('jabatan', 100);
            $table->string('email', 100);
            $table->string('no_wa', 100);
            $table->string('foto', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_tables');
    }
};
