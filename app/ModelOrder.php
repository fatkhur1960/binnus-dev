<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelOrder extends Model
{
    protected $table = 'tbl_order';
    protected $fillable = ['id_peserta','id_paket','total_harga','status','confirm_file','updated_at'];

    public function paket() {
        return $this->belongsTo(ModelPaket::class, 'id_paket', 'id_paket');
    }

    public function peserta() {
        return $this->belongsTo(ModelPeserta::class, 'id_peserta', 'id_peserta');
    }

    public function getFiltered($no_induk,$status = '') {
        $data = DB::table($this->table)
            ->select('tbl_order.*', 'tbl_peserta.no_induk', 'tbl_paket.nama_paket')
            ->innerJoin('tbl_paket', function($join) {
                $join->on('tbl_paket.id_paket','=','tbl_order.id_paket');
            })
            ->innerJoin('tbl_peserta', function($join) {
                $join->on('tbl_peserta.id_peserta','=','tbl_order.id_peserta');
            })
            ->where('tbl_peserta.no_induk', $no_induk);
        if($status) {
            $data = $data->where('tbl_order.status', $status);
        }

        return $data->orderBy('tbl_order.created_at','DESC')->paginate(20);
    }
}
