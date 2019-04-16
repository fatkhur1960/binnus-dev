@extends('layouts.home')
@section('title', 'Edit Paket')
@section('content')
<div class="card-header">Edit Paket</div>

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
    <form method="POST" class="col-md-12" action="{{ action('PaketController@update', $paket->id_paket) }}">
        @csrf
        <input name="_method" type="hidden" value="PATCH">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="nama_paket" class="col-4 col-form-label">Nama Paket</label> 
                    <div class="col-8">
                        <input id="nama_paket" name="nama_paket" type="text" value="{{ $paket->nama_paket }}" class="form-control{{ $errors->has('nama_paket') ? ' is-invalid' : '' }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pertemuan" class="col-4 col-form-label">Pertemuan</label> 
                    <div class="col-8">
                        <input id="pertemuan" name="pertemuan" type="number" value="{{ $paket->pertemuan }}" class="form-control{{ $errors->has('pertemuan') ? ' is-invalid' : '' }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="harga" class="col-4 col-form-label">Harga</label> 
                    <div class="col-8">
                        <input id="harga" name="harga" type="text" value="{{ $paket->harga }}" class="form-control{{ $errors->has('harga') ? ' is-invalid' : '' }}">
                    </div>
                </div> 
            </div>
            <div class="col-md-4">
                <input name="submit" type="submit" class="btn btn-primary" value="Perbarui">
                <a href="javascript:history.back(-1);" class="btn btn-warning">Batalkan</a>
            </div>
        </div>
    </form>
</div>
@endsection