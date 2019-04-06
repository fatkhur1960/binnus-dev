<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Order extends Migration
{
    public function up()
    {
        Schema::create('tbl_order', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_peserta');
            $table->unsignedInteger('id_paket');
            $table->integer('total_harga');
            $table->enum('status', ['Pending','Confirmed','Processing','Canceled'])->default('Pending');
            $table->string('confirm_file')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            
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
        Schema::dropIfExists('tbl_order');
    }
}