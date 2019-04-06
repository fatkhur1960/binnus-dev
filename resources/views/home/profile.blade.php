@extends('layouts.home')
@section('title', 'Profil')
@section('content')
<div class="card-header">Profil</div>

<div class="card-body">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul style="margin: 0px; padding: 0px;padding-left: 10px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('update_profile') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-md-9 row">
                    <label for="nik" class="control-label col-md-4">NIK</label> 
                    <div class="col-md-8">
                        <input value="{{ $peserta->nik }}" id="nik" name="nik" class="form-control" required="required" type="text">
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
                    <input value="{{ $peserta->nama_lengkap }}" id="nama_lengkap" name="nama_lengkap" required="required" class="form-control" type="text">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9 row">
                <label for="jen_kel" class="control-label col-md-4">Jenis Kelamin</label> 
                <div class="col-md-8">
                    <select id="jen_kel" name="jen_kel" required="required" class="custom-select">
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
                    <input value="{{ $peserta->ttl }}" id="ttl" name="ttl" class="form-control" required="required" type="text">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9 row">
                <label for="id_agama" class="control-label col-md-4">Agama</label> 
                <div class="col-md-8">
                    <select id="id_agama" name="id_agama" class="custom-select" required="required">
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
                    <textarea id="alamat_instansi" name="alamat_instansi" cols="40" rows="3" class="form-control" required="required">{{ $peserta->alamat_instansi }}</textarea>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9 row">
                <label for="no_hp" class="control-label col-md-4">No. HP</label> 
                <div class="col-md-8">
                    <input value="{{ $peserta->no_hp }}" id="no_hp" name="no_hp" class="form-control" required="required" type="text">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9 row">
                <label for="alamat_rumah" class="control-label col-md-4">Alamat Rumah</label> 
                <div class="col-md-8">
                    <textarea id="alamat_rumah" name="alamat_rumah" cols="40" rows="3" class="form-control" required="required">{{ $peserta->alamat_rumah }}</textarea>
                </div>
            </div>
        </div>
        <hr/>

        <div class="form-group row">
            <div class="col-md-9 row">
                <label for="nama_ayah" class="control-label col-md-4">Nama Ayah</label> 
                <div class="col-md-8">
                    <input value="{{ $peserta->nama_ayah }}" id="nama_ayah" name="nama_ayah" class="form-control" required="required" type="text">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9 row">
                <label for="ttl_ayah" class="control-label col-md-4">Tempat Tanggal Lahir</label> 
                <div class="col-md-8">
                    <input value="{{ $peserta->ttl_ayah }}" id="ttl_ayah" name="ttl_ayah" class="form-control" required="required" type="text">
                </div>
            </div>
        </div>
        
        <div class="form-group row">
            <div class="col-md-9 row">
                <label for="nama_ibu" class="control-label col-md-4">Nama Ibu</label> 
                <div class="col-md-8">
                    <input value="{{ $peserta->nama_ibu }}" id="nama_ibu" name="nama_ibu" class="form-control" required="required" type="text">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9 row">
                <label for="ttl_ibu" class="control-label col-md-4">Tempat Tanggal Lahir</label> 
                <div class="col-md-8">
                    <input value="{{ $peserta->ttl_ibu }}" id="ttl_ibu" name="ttl_ibu" class="form-control" required="required" type="text">
                </div>
            </div>
        </div>
        <hr/>
        <div class="form-group row">
            <div class="col-md-9 row">
                <label value="{{ $peserta->nama_wali }}" for="nama_wali" class="control-label col-md-4">Nama Wali</label> 
                <div class="col-md-8">
                    <input value="{{ $peserta->nama_wali }}" id="nama_wali" name="nama_wali" class="form-control" required="required" type="text">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9 row">
                <label for="telp_wali" class="control-label col-md-4">No. Telp. Orangtua/Wali</label> 
                <div class="col-md-8">
                    <input value="{{ $peserta->telp_wali }}" id="telp_wali" name="telp_wali" class="form-control" required="required" type="text">
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
            <div class="col-md-9 row">
                <label for="file_foto" class="control-label col-md-4">Foto</label> 
                <div class="col-md-8">
                    <input value="{{ $peserta->file_foto }}" id="file_foto" accept="image/*" name="file_foto" class="form-control" required="required" type="file">
                    <div>*) Foto ukuran 114x150 pixel</div>
                    <div>*) Maksimal 500kb</div>
                </div>
            </div>
        </div> 
        <div class="form-group row">
            <div class="col-md-9 row">
                <label for="file_kk" class="control-label col-md-4">Scan KK</label> 
                <div class="col-md-8">
                    <input value="{{ $peserta->file_kk }}" id="file_kk" accept="image/*" name="file_kk" class="form-control" required="required" type="file">
                    <div>*) Maksimal 800kb</div>
                </div>
            </div>
        </div> 
        <div class="form-group row">
            <div class="col-md-9 row">
                <div class="col-md-offset-4 col-md-8">
                    <input type="hidden" name="id_peserta" value="{{ $peserta->id_peserta }}"/>
                    <input type="submit" class="btn btn-primary" value="Simpan">
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
