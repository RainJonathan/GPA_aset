<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHostAssetHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('host_asset_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('host_id');
            $table->unsignedBigInteger('asset_id');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('harga_sewa', 10, 2);
            $table->string('status_penyewaan');
            $table->timestamps();
            $table->foreign('host_id')->references('id')->on('tuan_rumah')->onDelete('cascade');
            $table->foreign('asset_id')->references('id')->on('rekap_aset')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('host_asset_histories');
    }
}