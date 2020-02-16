<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBazarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bazars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_bazar', 50);
            $table->string('alamat', 120);
            $table->date('tgl_mulai');
            $table->date('tgl_akhir');
            $table->integer('potongan');
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
        Schema::dropIfExists('bazars');
    }
}
