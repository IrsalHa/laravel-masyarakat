<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetugasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petugas', function (Blueprint $table) {
          $table->char('id_petugas',16)->primary();
            $table->string('nama_petugas',35);
            $table->string('username',25);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password',32);
            $table->string('telp',13);
            $table->enum('level',['admin','petugas']);
            $table->rememberToken();
            $table->timestamps();

                  //  $table->foreign('id_petugas')->references('id_petugas')->on('petugas');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('petugas');
    }
}
