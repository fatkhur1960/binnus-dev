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
        $test = DB::table('tbl_kelas')
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
        $peserta = DB::table('tbl_kelas')
            ->select(
                DB::raw('
                    Max(tbl_kelas.id_kelas) as id_kelas, 
                    Max(tbl_kelas.id_paket) as id_paket,
                    Max(tbl_peserta.id_peserta) as id_peserta, 
                    Max(tbl_peserta.no_induk) as no_induk, 
                    Max(tbl_jadwal.id_jadwal) as id_jadwal,
                    Max(tbl_jadwal.hari) as hari, 
                    Max(tbl_jadwal.waktu) as waktu
                ')
            )
            ->leftJoin('tbl_peserta', function($join) {
                $join->on('tbl_kelas.id_peserta','=','tbl_peserta.id_peserta');
            })
            ->leftJoin('tbl_jadwal', function($join) {
                $join->on('tbl_kelas.id_jadwal','=','tbl_jadwal.id_jadwal');
            })
            ->where('tbl_peserta.id_peserta','=',$id_peserta);
        $data = DB::table('tbl_order')
            ->select(DB::raw('tbl_custom.*, tbl_order.status, tbl_order.created_at'))
            ->joinSub($peserta, 'tbl_custom', function ($join) {
                $join->on('tbl_order.id_peserta', '=', 'tbl_custom.id_peserta');
            });
        $paket = DB::table('tbl_paket')
            ->select(DB::raw('
                data.*,
                tbl_paket.nama_paket
            '))
            ->joinSub($data, 'data', function($join) {
                $join->on('tbl_paket.id_paket','=','data.id_paket');
            });
        return $test;
    }
}
