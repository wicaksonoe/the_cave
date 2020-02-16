<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('username', 20)->unique();
            $table->string('password');
            $table->string('nama', 50);
            $table->string('alamat', 120);
            $table->string('telp', 12);
            $table->enum('role', ['pegawai', 'admin']);
            $table->timestamps();
            $table->softDeletes();
            $table->primary('username');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
