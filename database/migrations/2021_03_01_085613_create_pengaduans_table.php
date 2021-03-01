<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengaduansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->integer('id_pengaduan')->primary();
            $table->date('tgl_pengaduan');
            $table->char('nik',16);
            $table->timestamp('email_verified_at')->nullable();
            $table->text('isi_laporan');
            $table->string('foto',255);
            $table->enum('status',['0','proses','selesai']);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('nik')->references('nik')->on('masyarakat');
 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengaduans');
    }
}
