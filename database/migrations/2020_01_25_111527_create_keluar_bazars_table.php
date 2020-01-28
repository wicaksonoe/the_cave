<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeluarBazarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keluar_bazars', function (Blueprint $table) {
						$table->bigIncrements('id');
						$table->integer('id_bazar');
						$table->date('date');
						$table->string('barcode');
						$table->integer('jml');
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
        Schema::dropIfExists('keluar_bazars');
    }
}
