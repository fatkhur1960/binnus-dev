@extends('layouts.home')
@section('title', 'Profil Peserta')
@section('content')
<div class="card-header">Profil Peserta</div>

<div class="card-body">
    {{-- <form action="{{ route('update_profile') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
        @csrf --}}
        <div class="form-group">
            <div class="row">
                <div class="col-md-9 row">
                    <label for="nik" class="control-label col-md-4">NIK</label> 
                    <div class="col-md-8">
                        <input readonly value="{{ $peserta->nik }}" id="nik" name="nik" class="form-control" required="required" type="text">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-9 row">
                    <label for="no_induk" class="control-label col-md-4">No Induk</label> 
                    <div class="col-md-8">
                        <input value="{{ $peserta->no_induk }}" id="no_induk" name="no_induk" class="form-control" readonly="readonly" type="text">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9 row">
                <label for="nama_lengkap" class="control-label col-md-4">Nama Lengkap</label> 
                <div class="col-md-8">
                    <input readonly value="{{ $peserta->nama_lengkap }}" id="nama_lengkap" name="nama_lengkap" required="required" class="form-control" type="text">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9 row">
                <label for="jen_kel" class="control-label col-md-4">Jenis Kelamin</label> 
                <div class="col-md-8">
                    <select disabled="true" id="jen_kel" name="jen_kel" required="required" class="custom-select">
                        @if($peserta->jen_kel == 'L')
                        <option value="L" selected>Laki-laki</option>
                        <option value="P">Perempuan</option>
                        @else
                        <option value="L">Laki-laki</option>
                        <option value="P" selected>Perempuan</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9 row">
                <label for="ttl" class="control-label col-md-4">Tempat Tanggal Lahir</label> 
                <div class="col-md-8">
                    <input readonly value="{{ $peserta->ttl }}" id="ttl" name="ttl" class="form-control" required="required" type="text">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9 row">
                <label for="id_agama" class="control-label col-md-4">Agama</label> 
                <div class="col-md-8">
                    <select disabled id="id_agama" name="id_agama" class="custom-select" required="required">
                        <option value="">-- Pilih Agama --</option>
                        @foreach($agama as $item)
                        @if($peserta->id_agama == $item->id_agama)
                        <option value="{{ $item->id_agama }}" selected>{{ $item->nama_agama }}</option>
                        @else
                        <option value="{{ $item->id_agama }}">{{ $item->nama_agama }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9 row">
                <label for="alamat_instansi" class="control-label col-md-4">Alamat Sekolah/Kantor</label> 
                <div class="col-md-8">
                    <textarea readonly id="alamat_instansi" name="alamat_instansi" cols="40" rows="3" class="form-control" required="required">{{ $peserta->alamat_instansi }}</textarea>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9 row">
                <label for="no_hp" class="control-label col-md-4">No. HP</label> 
                <div class="col-md-8">
                    <input readonly value="{{ $peserta->no_hp }}" id="no_hp" name="no_hp" class="form-control" required="required" type="text">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9 row">
                <label for="alamat_rumah" class="control-label col-md-4">Alamat Rumah</label> 
                <div class="col-md-8">
                    <textarea readonly id="alamat_rumah" name="alamat_rumah" cols="40" rows="3" class="form-control" required="required">{{ $peserta->alamat_rumah }}</textarea>
                </div>
            </div>
        </div>
        <hr/>

        <div class="form-group row">
            <div class="col-md-9 row">
                <label for="nama_ayah" class="control-label col-md-4">Nama Ayah</label> 
                <div class="col-md-8">
                    <input readonly value="{{ $peserta->nama_ayah }}" id="nama_ayah" name="nama_ayah" class="form-control" required="required" type="text">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9 row">
                <label for="ttl_ayah" class="control-label col-md-4">Tempat Tanggal Lahir</label> 
                <div class="col-md-8">
                    <input readonly value="{{ $peserta->ttl_ayah }}" id="ttl_ayah" name="ttl_ayah" class="form-control" required="required" type="text">
                </div>
            </div>
        </div>
        
        <div class="form-group row">
            <div class="col-md-9 row">
                <label for="nama_ibu" class="control-label col-md-4">Nama Ibu</label> 
                <div class="col-md-8">
                    <input readonly value="{{ $peserta->nama_ibu }}" id="nama_ibu" name="nama_ibu" class="form-control" required="required" type="text">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9 row">
                <label for="ttl_ibu" class="control-label col-md-4">Tempat Tanggal Lahir</label> 
                <div class="col-md-8">
                    <input readonly value="{{ $peserta->ttl_ibu }}" id="ttl_ibu" name="ttl_ibu" class="form-control" required="required" type="text">
                </div>
            </div>
        </div>
        <hr/>
        <div class="form-group row">
            <div class="col-md-9 row">
                <label value="{{ $peserta->nama_wali }}" for="nama_wali" class="control-label col-md-4">Nama Wali</label> 
                <div class="col-md-8">
                    <input readonly value="{{ $peserta->nama_wali }}" id="nama_wali" name="nama_wali" class="form-control" required="required" type="text">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9 row">
                <label for="telp_wali" class="control-label col-md-4">No. Telp. Orangtua/Wali</label> 
                <div class="col-md-8">
                    <input readonly value="{{ $peserta->telp_wali }}" id="telp_wali" name="telp_wali" class="form-control" required="required" type="text">
                </div>
            </div>
        </div> 
        <div class="form-group row">
            <div class="col-md-12 row">
                <label for="id_sumber" class="control-label col-md-3">Mengetahui BINNUS dari</label> 
                <div class="col-md-9 row">
                    @foreach($sumber as $item)
                    <div class="col-md-4 align-middle">
                        @if($peserta->id_sumber == $item->id_sumber)
                        <label><input checked id="id_sumber" value="{{ $item->id_sumber }}" name="id_sumber" required="required" type="radio">&nbsp;&nbsp;<span style="padding-bottom: 11px !important;" class="align-middle">{{ $item->nama_sumber }}</span></label>
                        @else
                        <label><input id="id_sumber" value="{{ $item->id_sumber }}" name="id_sumber" required="required" type="radio">&nbsp;&nbsp;<span style="padding-bottom: 11px !important;" class="align-middle">{{ $item->nama_sumber }}</span></label>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div> 
        <hr/>
        <div class="form-group row">
            <div class="col-md-12 row">
                <label for="file_foto" class="control-label col-md-3">Foto</label> 
                <div class="col-md-4">
                    <a href="{{ url($peserta->file_foto) }}" data-toggle="lightbox">
                        <img width="114" height="150" src="{{ url($peserta->file_foto) }}" id="foto"/>
                    </a>
                </div>
            </div>
        </div> 
        <div class="form-group row">
            <div class="col-md-12 row">
                <label for="file_foto" class="control-label col-md-3">Kartu Keluarga</label> 
                <div class="col-md-4">
                    <a href="{{ url($peserta->file_kk) }}" data-toggle="lightbox">
                        <img width="114" height="150" src="{{ url($peserta->file_kk) }}" id="kk"/>
                    </a>
                </div>
            </div>
        </div>
    {{-- </form> --}}
</div>
@endsection
@section('style')
@endsection
@section('script')
@endsection