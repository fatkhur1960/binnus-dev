<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelJadwal extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id_jadwal';
    protected $table = 'tbl_jadwal';
    protected $fillable = ['id_paket', 'periode', 'hari', 'kuota', 'waktu'];

    public function paket()
    {
        return $this->belongsTo(ModelPaket::class, 'id_paket', 'id_paket');
    }

    public function getJadwal($id_paket, $id_jadwal, $periode)
    {
        $data = DB::table('tbl_kelas')
            ->select('tbl_jadwal.*', DB::raw('(tbl_jadwal.kuota-peserta.jumlah) as sisa'))
            ->rightJoin('tbl_paket', function($join) {
                $join->on('tbl_paket.id_paket','=','tbl_kelas.id_paket');
            })
            ->join('tbl_jadwal', function($join) {
                $join->on('tbl_jadwal.id_paket','=','tbl_paket.id_paket');
            })
            ->leftJoin(DB::raw('(SELECT tbl_jadwal.id_jadwal, count(tbl_kelas.id_kelas) as jumlah FROM tbl_jadwal left join tbl_kelas on tbl_jadwal.id_jadwal=tbl_kelas.id_jadwal GROUP BY tbl_jadwal.id_jadwal ) as peserta'), function($join) {
                $join->on('tbl_jadwal.id_jadwal','=','peserta.id_jadwal');
            })
            ->where([
                'tbl_jadwal.id_paket' => $id_paket,
                'tbl_jadwal.periode' => $periode
            ]);
        if($id_jadwal) {
            $data = $data->whereNotIn('tbl_jadwal.id_jadwal', [$id_jadwal])
                ->groupBy('tbl_jadwal.id_jadwal','peserta.jumlah')
                ->get();
        } else {
            $data = $data->groupBy('tbl_jadwal.id_jadwal','peserta.jumlah')
                ->get();
        }

        return $data;
    }
}
