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
        Schema::create('wa', function (Blueprint $table) {
            $table->bigInteger('id')->nullable(false)->primary();            
            $table->string('no_wa', 100)->nullable(true);
            $table->text('wa_group')->nullable(true);
            $table->json('template_bc')->nullable(true)->default('{"data":[{"title":"hadir","message":null},{"title":"sakit","message":null},{"title":"absen","message":null},{"title":"izin","message":null}]}');
            $table->string('token_account_wa')->nullable(true);
            $table->string('token_api_wa')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wa');
    }
};
