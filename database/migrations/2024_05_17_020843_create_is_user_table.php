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
        Schema::create('is_user', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('nik');
            $table->string('nama_user');
            $table->string('password');
            $table->unsignedBigInteger('id_wilayah');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('is_user');
    }
};
