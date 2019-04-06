<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Kelas extends Migration
{
    public function up()
    {
        Schema::create('tbl_kelas', function(Blueprint $table) {
            $table->increments('id_kelas');
            $table->unsignedInteger('id_paket');
            $table->unsignedInteger('id_jadwal')->nullable();
            $table->unsignedInteger('id_peserta');

            $table->foreign('id_jadwal')
                ->references('id_jadwal')->on('tbl_jadwal')
                ->onDelete('cascade');

            $table->foreign('id_peserta')
                ->references('id_peserta')->on('tbl_peserta')
                ->onDelete('cascade');
            
            $table->foreign('id_paket')
                ->references('id_paket')->on('tbl_paket')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_kelas');
    }
}
