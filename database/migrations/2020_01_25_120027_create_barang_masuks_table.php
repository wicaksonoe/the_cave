<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_masuks', function (Blueprint $table) {
            $table->string('barcode', 15)->unique();
            $table->string('namabrg', 50);
            $table->integer('id_jenis');
            $table->integer('id_tipe');
            $table->integer('id_sup');
            $table->integer('jumlah');
            $table->integer('hpp');
            $table->integer('hjual');
            $table->integer('grosir');
            $table->integer('partai');
            $table->date('tgl');
            $table->timestamps();
            $table->softDeletes();
            $table->primary('barcode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang_masuks');
    }
}
