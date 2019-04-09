@extends('layouts.home')
@section('title', 'Pengaturan Akun')
@section('content')

<div class="card-header">Pengaturan Akun</div>

<div class="card-body">
    @if (session('error'))
    <div class="alert alert-danger">
    {{ session('error') }}
    </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success">
    {{ session('success') }}
    </div>
    @endif
    
    <form class="form-horizontal" method="POST" action="{{ route('changePassword') }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} row">
            <label for="email" class="col-md-2 control-label">Alamat Email</label>
            
            <div class="col-md-4">
                <input id="email" type="text" value="{{ Auth::user()->email }}" class="form-control" name="email" required>
            
                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('current-password') }}</strong>
                </span>
                @endif
            </div>
        </div>
        
        <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }} row">
            <label for="new-password" class="col-md-2 control-label">Password Lama</label>
            
            <div class="col-md-4">
                <input id="current-password" type="password" class="form-control" name="current-password" required>
            
                @if ($errors->has('current-password'))
                <span class="help-block">
                    <strong>{{ $errors->first('current-password') }}</strong>
                </span>
                @endif
            </div>
        </div>
            
        <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }} row">
            <label for="new-password" class="col-md-2 control-label">Password Baru</label>
            
            <div class="col-md-4">
                <input id="new-password" type="password" class="form-control" name="new-password" required>
                
                @if ($errors->has('new-password'))
                <span class="help-block">
                    <strong>{{ $errors->first('new-password') }}</strong>
                </span>
            @endif
            </div>
        </div>
            
        <div class="form-group row">
            <label for="new-password-confirm" class="col-md-2 control-label">Konfirmasi</label>
            
            <div class="col-md-4">
                <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>
            </div>
        </div>
            
        <div class="form-group row">
            <div class="col-md-4 col-md-offset-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </form>
</div>
@endsection