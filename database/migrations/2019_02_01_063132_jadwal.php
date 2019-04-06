<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Jadwal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_jadwal', function(Blueprint $table) {
            $table->increments('id_jadwal');
            $table->unsignedInteger('id_paket');
            $table->string('hari');
            $table->integer('kuota');
            $table->string('waktu');
            $table->timestamp('created_at')->nullable();

            $table->foreign('id_paket')
                ->references('id_paket')->on('tbl_paket')
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
        Schema::dropIfExists('tbl_jadwal');
    }
}
