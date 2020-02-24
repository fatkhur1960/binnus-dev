<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ModelPaket extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id_paket';
    protected $table = 'tbl_paket';
    protected $fillable = ['nama_paket', 'pertemuan', 'harga'];

    function list($id_peserta) {
        $data = DB::table('tbl_kelas')
            ->select('tbl_paket.nama_paket', 'tbl_jadwal.hari', 'tbl_jadwal.waktu', 'tbl_order.status', DB::raw('DATE(tbl_jadwal.created_at) as created_at'), 'tbl_jadwal.id_jadwal', 'tbl_kelas.id_kelas', 'tbl_paket.id_paket')
            ->leftJoin('tbl_paket', function($join) {
                $join->on('tbl_paket.id_paket', '=', 'tbl_kelas.id_paket');
            })
            ->leftJoin('tbl_jadwal', function($join) {
                $join->on('tbl_jadwal.id_jadwal', '=', 'tbl_kelas.id_jadwal');
            })
            ->leftJoin('tbl_order', function($join) {
                $join->on('tbl_order.id_paket', '=', 'tbl_kelas.id_paket');
            })
            ->where([
                'tbl_kelas.id_peserta' => $id_peserta,
                'tbl_order.id_peserta' => $id_peserta,
            ]);
        return $data;
    }
}
