@extends('layouts.app')
@section('title', 'Formulir Pendaftaran')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div style="padding: 10px;">
                    <ul class="nav nav-pills nav-justified nav-fill thumbnail setup-panel">
                        <li class="nav-item"><a class="nav-link active" href="#step-1">
                            <h4 class="list-group-item-heading">Step 1</h4>
                            <p style="margin: 0px;">Data Pribadi</p>
                        </a></li>
                        <li class="nav-item"><a class="nav-link" href="#step-2">
                            <h4 class="list-group-item-heading">Step 2</h4>
                            <p style="margin: 0px;">Data Orangtua</p>
                        </a></li>
                        <li class="nav-item"><a class="nav-link" href="#step-3">
                            <h4 class="list-group-item-heading">Step 3</h4>
                            <p style="margin: 0px;">Kuis</p>
                        </a></li>
                        <li class="nav-item"><a class="nav-link" href="#step-4">
                            <h4 class="list-group-item-heading">Step 4</h4>
                            <p style="margin: 0px;">Buat Akun</p>
                        </a></li>
                    </ul>
                </div>
            </div>
            <br/>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">Formulir Pendaftaran</div>

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
                    <form action="{{ route('register') }}" method="post" class="form-horizontal">
                        @csrf
                        <div class="steps" id="step-1">
                            <div class="form-group justify-content-center row">
                                <div class="col-md-9 row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">NIK</label> 
                                    <div class="col-md-8">
                                        <input value="{{ old('nik') }}" id="nik" name="nik" class="form-control" required="required" type="text">
                                    </div>
                                </div>  
                            </div>

                            <div class="form-group justify-content-center row">
                                <div class="col-md-9 row">
                                    <label for="nama_lengkap" class="col-md-4 col-form-label text-md-right">Nama Lengkap</label> 
                                    <div class="col-md-8">
                                        <input value="{{ old('nama_lengkap') }}" id="nama_lengkap" name="name" required="required" class="form-control" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group justify-content-center row">
                                <div class="col-md-9 row">
                                    <label for="jen_kel" class="col-md-4 col-form-label text-md-right">Jenis Kelamin</label> 
                                    <div class="col-md-8">
                                        <select id="jen_kel" name="jen_kel" required="required" class="custom-select">
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group justify-content-center row">
                                <div class="col-md-9 row">
                                    <label for="ttl" class="col-md-4 col-form-label text-md-right">Tempat Tanggal Lahir</label> 
                                    <div class="col-md-8">
                                        <input value="{{ old('ttl') }}" id="ttl" name="ttl" class="form-control" required="required" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group justify-content-center row">
                                <div class="col-md-9 row">
                                    <label for="id_agama" class="col-md-4 col-form-label text-md-right">Agama</label> 
                                    <div class="col-md-8">
                                        <select id="id_agama" name="id_agama" class="custom-select" required="required">
                                            <option value="">-- Pilih Agama --</option>
                                            @foreach($agama as $item)
                                            <option value="{{ $item->id_agama }}">{{ $item->nama_agama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group justify-content-center row">
                                <div class="col-md-9 row">
                                    <label for="alamat_instansi" class="col-md-4 col-form-label text-md-right">Alamat Sekolah/Kantor</label> 
                                    <div class="col-md-8">
                                        <textarea id="alamat_instansi" name="alamat_instansi" cols="40" rows="3" class="form-control" required="required">{{ old('alamat_instansi') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group justify-content-center row">
                                <div class="col-md-9 row">
                                    <label for="no_hp" class="col-md-4 col-form-label text-md-right">No. HP</label> 
                                    <div class="col-md-8">
                                        <input value="{{ old('no_hp') }}" id="no_hp" name="no_hp" class="form-control" required="required" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group justify-content-center row">
                                <div class="col-md-9 row">
                                    <label for="alamat_rumah" class="col-md-4 col-form-label text-md-right">Alamat Rumah</label> 
                                    <div class="col-md-8">
                                        <textarea id="alamat_rumah" name="alamat_rumah" cols="40" rows="3" class="form-control" required="required">{{ old('alamat_rumah') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group justify-content-center">
                                <div class="col-md-12">
                                    <a class="nav-link col-md-12 btn btn-lg btn-primary" href="#step-2">Selanjutnya</a>
                                </div>
                            </div>

                        </div>

                        <div class="steps" id="step-2" style="display: none;">
                            <div class="form-group justify-content-center row">
                                <div class="col-md-9 row">
                                    <label for="nama_ayah" class="col-md-4 col-form-label text-md-right">Nama Ayah</label> 
                                    <div class="col-md-8">
                                        <input value="{{ old('nama_ayah') }}" id="nama_ayah" name="nama_ayah" class="form-control" required="required" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group justify-content-center row">
                                <div class="col-md-9 row">
                                    <label for="ttl_ayah" class="col-md-4 col-form-label text-md-right">Tempat Tanggal Lahir</label> 
                                    <div class="col-md-8">
                                        <input value="{{ old('ttl_ayah') }}" id="ttl_ayah" name="ttl_ayah" class="form-control" required="required" type="text">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group justify-content-center row">
                                <div class="col-md-9 row">
                                    <label for="nama_ibu" class="col-md-4 col-form-label text-md-right">Nama Ibu</label> 
                                    <div class="col-md-8">
                                        <input value="{{ old('nama_ibu') }}" id="nama_ibu" name="nama_ibu" class="form-control" required="required" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group justify-content-center row">
                                <div class="col-md-9 row">
                                    <label for="ttl_ibu" class="col-md-4 col-form-label text-md-right">Tempat Tanggal Lahir</label> 
                                    <div class="col-md-8">
                                        <input value="{{ old('ttl_ibu') }}" id="ttl_ibu" name="ttl_ibu" class="form-control" required="required" type="text">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group justify-content-center row">
                                <div class="col-md-9 row">
                                    <label value="{{ old('nama_wali') }}" for="nama_wali" class="col-md-4 col-form-label text-md-right">Nama Wali</label> 
                                    <div class="col-md-8">
                                        <input value="{{ old('nama_wali') }}" id="nama_wali" name="nama_wali" class="form-control" required="required" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group justify-content-center row">
                                <div class="col-md-9 row">
                                    <label for="telp_wali" class="col-md-4 col-form-label text-md-right">No. Telp. Orangtua/Wali</label> 
                                    <div class="col-md-8">
                                        <input value="{{ old('telp_wali') }}" id="telp_wali" name="telp_wali" class="form-control" required="required" type="text">
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group justify-content-center row">
                                <div class="col-md-12">
                                    <div class="btn-group btn-group-lg col-md-12" role="group">
                                        <a class="nav-link col-md-6 btn btn-info" href="#step-1">Sebelumnya</a>
                                        <a class="nav-link col-md-6 btn btn-primary" href="#step-3">Selanjutnya</a>
                                    </div>
                                </div>
                            </div>
                        
                        </div>

                        <div class="steps" id="step-3" style="display: none;">

                            <div class="form-group justify-content-center row">
                                <div class="col-md-12 row">
                                    <label for="id_sumber" class="control-label col-md-3">Mengetahui BINNUS dari</label> 
                                    <div class="col-md-9 row">
                                        @foreach($sumber as $item)
                                        <div class="col-md-4 align-middle">
                                            <label><input id="id_sumber" value="{{ $item->id_sumber }}" name="id_sumber" required="required" type="radio">&nbsp;&nbsp;<span style="padding-bottom: 11px !important;" class="align-middle">{{ $item->nama_sumber }}</span></label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="form-group justify-content-center row">
                                <div class="col-md-12">
                                    <div class="btn-group btn-group-lg col-md-12" role="group">
                                        <a class="nav-link col-md-6 btn btn-info" href="#step-2">Sebelumnya</a>
                                        <a class="nav-link col-md-6 btn btn-primary" href="#step-4">Selanjutnya</a>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="steps" id="step-4" style="display: none;">
                            <div class="form-group justify-content-center">
        
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
        
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
        
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
        
                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
        
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
        
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
        
                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
        
                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <input type="submit" class="btn col-md-12 btn-lg btn-primary" value="Daftar">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
$(document).ready(function() {
    $('a.nav-link').click(function() {
        $('a.nav-link').removeClass('active');
        $(this)
        var target = $(this).attr('href');
        $('a[href="'+target+'"]').addClass('active');
        $('div.steps').hide();
        $(target).fadeIn();

        return false;
    });
});
</script>
@endsection