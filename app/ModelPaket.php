<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelPaket extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id_paket';
    protected $table = 'tbl_paket';
    protected $fillable = ['nama_paket', 'pertemuan', 'harga'];
}
