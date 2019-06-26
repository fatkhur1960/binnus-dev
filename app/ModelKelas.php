<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelKelas extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id_kelas';
    protected $table = 'tbl_kelas';
    protected $fillable = ['id_paket', 'id_peserta', 'id_jadwal'];

    public function paket()
    {
        return $this->belongsTo(ModelPaket::class, 'id_paket', 'id_paket');
    }

    public function peserta()
    {
        return $this->belongsTo(ModelPeserta::class, 'id_peserta', 'id_peserta');
    }

    public function jadwal()
    {
        return $this->belongsTo(ModelJadwal::class, 'id_jadwal', 'id_jadwal');
    }

    public function pembayaran()
    {
        // $data = DB::table($this->table)
        //     ->select('tbl_kelas.*', 'tbl_order.*')
        //     ->leftJoin('tbl_order', function($join) {
        //         $join->on('tbl_kelas.id_peserta','=','tbl_order.id_peserta');
        //     })
        //     ->groubBy('tbl_order.status');
        // return $this->belongsTo(ModelOrder::class);
    }

    public function getPeserta($id_paket, $id_jadwal) 
    {
        $data = DB::table($this->table)
            ->select('tbl_kelas.*', 'tbl_peserta.*')
            ->leftJoin('tbl_peserta', function($join) {
                $join->on('tbl_peserta.id_peserta','=','tbl_kelas.id_peserta');
            })
            ->where('tbl_kelas.id_paket', $id_paket)
            ->where('tbl_kelas.id_jadwal', $id_jadwal);

        return $data->orderBy('tbl_peserta.no_induk','ASC')->get();
    }
}
