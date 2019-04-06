<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Peserta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_peserta', function (Blueprint $table) {
            $table->increments('id_peserta');
            $table->unsignedInteger('id_user');
            $table->string('nik');
            $table->string('no_induk');
            $table->string('nama_lengkap');
            $table->enum('jen_kel', ['L','P']);
            $table->string('ttl');
            $table->unsignedInteger('id_agama');
            $table->string('alamat_instansi');
            // $table->unsignedInteger('id_paket');
            $table->string('no_hp');
            $table->string('alamat_rumah');
            $table->string('nama_ayah');
            $table->string('ttl_ayah');
            $table->string('nama_ibu');
            $table->string('ttl_ibu');
            $table->string('nama_wali');
            $table->string('telp_wali');
            $table->unsignedInteger('id_sumber');
            $table->string('file_foto')->default('NULL');
            $table->string('file_kk')->default('NULL');
            $table->timestamp('created_at')->nullable();

            $table->foreign('id_agama')
                ->references('id_agama')->on('tbl_agama')
                ->onDelete('cascade');

            $table->foreign('id_user')
                ->references('id')->on('users')
                ->onDelete('cascade');
            
            // $table->foreign('id_paket')
            //     ->references('id_paket')->on('tbl_paket')
            //     ->onDelete('cascade');

            $table->foreign('id_sumber')
                ->references('id_sumber')->on('tbl_sumber')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_peserta');
    }
}
