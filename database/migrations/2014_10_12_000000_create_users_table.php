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
        Schema::create('masyarakat', function (Blueprint $table) {
            $table->char('nik',16)->primary();
            $table->string('nama',35);
            $table->string('username',25)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('telp',13);
            $table->enum('status',['nonAktif','Aktif'])->default('NonAktif');
            //$table->enum('level',['admin','petugas','masyarakat']);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
