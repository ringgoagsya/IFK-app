<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailObatKeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_obat_keluars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_obat_keluar');
            $table->unsignedBigInteger('id_obat');
            $table->unsignedBigInteger('id_stok');
            $table->integer('jumlah');
            $table->integer('sisa_stok');
            $table->date('expired');
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
        Schema::dropIfExists('detail_obat_keluars');
    }
}
