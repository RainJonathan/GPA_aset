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
        Schema::create('outbox', function (Blueprint $table) {
            $table->id();
            $table->string('wa_no')->nullable();
            $table->string('wa_text')->nullable();
            $table->string('send_status')->default('N');
            $table->string('subcribe_message')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outbox');
    }
};
