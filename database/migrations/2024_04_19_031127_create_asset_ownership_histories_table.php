<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetOwnershipHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('asset_ownership_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id');
            $table->unsignedBigInteger('previous_owner_id');
            $table->foreign('asset_id')->references('id')->on('rekap_aset')->onDelete('cascade');
            $table->foreign('previous_owner_id')->references('id')->on('tuan_rumah')->onDelete('cascade');
            $table->timestamp('ownership_changed_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asset_ownership_histories');
    }
}

