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
        Schema::create('report', function (Blueprint $table) {
            $table->integer('id');
            $table->string('id_sekolah', 255);
            $table->string('id_kelas', 255);
            $table->string('device', 255);
            $table->string('target', 255);
            $table->longText('message');
            $table->string('stateid', 255);
            $table->string('status', 255);
            $table->string('state', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report');
    }
};
