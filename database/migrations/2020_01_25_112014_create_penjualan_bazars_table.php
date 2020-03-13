<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanBazarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan_bazars', function (Blueprint $table) {
            $table->string('kode_trx', 20);
            $table->integer('id_bazar');
            $table->string('username', 20);
            $table->timestamps();
            $table->softDeletes();
            $table->primary('kode_trx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualan_bazars');
    }
}
