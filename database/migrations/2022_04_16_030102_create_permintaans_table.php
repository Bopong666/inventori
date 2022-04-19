<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermintaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permintaans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('puskesmas_id');
            $table->unsignedBigInteger('barang_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('jumlah');
            $table->text('keterangan')->nullable();
            $table->enum('status', ['terima', 'tolak'])->nullable()->change();
            $table->enum('terbaca_pengurus', ['y', 't'])->nullable()->change();
            $table->enum('terbaca_user', ['y', 't'])->nullable()->change();
            $table->foreign('puskesmas_id')->references('id')->on('puskesmas')->onDelete('cascade');
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permintaans');
    }
}
