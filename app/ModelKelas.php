<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo(ModelOrder::class, 'id_peserta', 'id_peserta');
    }
}
