<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTanggapansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tanggapan', function (Blueprint $table) {
            $table->integer('id_tanggapan',11);
            //  $table->dropPrimary('id_pengaduan');
               $table->integer('id_pengaduan');
               $table->date('tgl_tanggapan');
               $table->timestamp('email_verified_at')->nullable();
               $table->text('tanggapan');
              $table->char('id_petugas',16);
               $table->rememberToken();
               $table->timestamps();
               //2021_03_01_085630_create_tanggapans_table.php
             $table->foreign('id_petugas')->references('id_petugas')->on('petugas');
               $table->foreign('id_pengaduan')->references('id_pengaduan')->on('pengaduan');
              // $table->foreign('id_pengaduan')->references('id_pengaduan')->on('pengaduan');
   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tanggapans');
    }
}
