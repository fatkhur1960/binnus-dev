<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class Agama extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_agama', function(Blueprint $table) {
            $table->increments('id_agama');
            $table->string('nama_agama');
        });

        DB::table('tbl_agama')->insert(
            [
                ['id_agama' => 1, 'nama_agama' => 'Islam'],
                ['id_agama' => 2, 'nama_agama' => 'Katholik'],
                ['id_agama' => 3, 'nama_agama' => 'Kristen'],
                ['id_agama' => 4, 'nama_agama' => 'Hindu'],
                ['id_agama' => 5, 'nama_agama' => 'Budha'],
                ['id_agama' => 6, 'nama_agama' => 'Konghucu']
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_agama');
    }
}
