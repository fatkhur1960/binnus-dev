<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class Sumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sumber', function(Blueprint $table) {
            $table->increments('id_sumber');
            $table->string('nama_sumber');
        });

        DB::table('tbl_sumber')->insert(
            [
                ['id_sumber' => 1, 'nama_sumber' => 'Radio'],
                ['id_sumber' => 2, 'nama_sumber' => 'Koran'],
                ['id_sumber' => 3, 'nama_sumber' => 'Browser'],
                ['id_sumber' => 4, 'nama_sumber' => 'Instagram'],
                ['id_sumber' => 5, 'nama_sumber' => 'Teman'],
                ['id_sumber' => 6, 'nama_sumber' => 'Keluarga'],
                ['id_sumber' => 7, 'nama_sumber' => 'Banner'],
                ['id_sumber' => 8, 'nama_sumber' => 'Google'],
                ['id_sumber' => 9, 'nama_sumber' => 'Facebook'],
                ['id_sumber' => 10, 'nama_sumber' => 'Lainnya']
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
        Schema::dropIfExists('tbl_sumber');
    }
}
