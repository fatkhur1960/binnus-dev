<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelPeserta extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id_peserta';
    protected $table = 'tbl_peserta';
    protected $fillable = ['nik','id_user','no_induk','nama_lengkap','jen_kel','ttl','id_agama','alamat_instansi','no_hp','alamat_rumah','nama_ayah','ttl_ayah','nama_ibu','ttl_ibu','nama_wali','telp_wali','id_sumber','file_foto','file_kk'];
}
