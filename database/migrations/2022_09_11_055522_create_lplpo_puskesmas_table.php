<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLplpoPuskesmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lplpo_puskesmas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_puskesmas');
            $table->unsignedBigInteger('id_obat');
            $table->integer('awal')->nullable();
            $table->integer('penerimaan')->nullable();
            $table->integer('stok_puskesmas')->nullable();
            $table->integer('pemakaian')->nullable();
            $table->integer('sisa_stok')->nullable();
            $table->integer('permintaan')->nullable();
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
        Schema::dropIfExists('lplpo_puskesmas');
    }
}
