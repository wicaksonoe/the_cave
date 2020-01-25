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
						$table->bigIncrements('id');
						$table->integer('id_bazar');
						$table->date('tgl');
						$table->string('barcode');
						$table->integer('hpp');
						$table->integer('hjual');
						$table->timestamps();
						$table->softDeletes();
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
