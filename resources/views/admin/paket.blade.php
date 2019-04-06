@extends('layouts.home')
@section('title', 'Paket')
@section('content')
<div class="card-header">Paket</div>

<div class="card-body">
    @if (\Session::has('success'))
    <div class="alert alert-success">
        {{ \Session::get('success') }}
    </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul style="margin: 0px; padding: 0px;padding-left: 10px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form method="post" class="col-md-12" action="{{ url('/home/paket-kursus') }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="nama_paket" class="col-4 col-form-label">Nama Paket</label> 
                    <div class="col-8">
                        <input id="nama_paket" name="nama_paket" type="text" value="{{ old('nama_paket') }}" class="form-control{{ $errors->has('nama_paket') ? ' is-invalid' : '' }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pertemuan" class="col-4 col-form-label">Pertemuan</label> 
                    <div class="col-8">
                        <input id="pertemuan" name="pertemuan" type="number" value="{{ old('pertemuan') }}" class="form-control{{ $errors->has('pertemuan') ? ' is-invalid' : '' }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="harga" class="col-4 col-form-label">Harga</label> 
                    <div class="col-8">
                        <input id="harga" name="harga" type="text" value="{{ old('harga') }}" class="form-control{{ $errors->has('harga') ? ' is-invalid' : '' }}">
                    </div>
                </div> 
            </div>
            <div class="col-md-4">
                <input name="submit" type="submit" class="btn btn-primary" value="Simpan">
            </div>
        </div>
    </form>

    <div class="table-responsive mb-3">
        <table class="table table-border table-striped">
            <thead>
                <tr>
                    <th width="30">No.</th>
                    <th>Nama Paket</th>
                    <th>Pertemuan</th>
                    <th>Harga</th>
                    <th width="140">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paket as $row)
                <tr>
                    <td>{{ $num++ }}</td>
                    <td>{{ $row->nama_paket }}</td>
                    <td>{{ $row->pertemuan }} Kali Pertemuan</td>
                    <td>Rp. {{ number_format($row->harga) }}</td>
                    <td class="d-flex justify-content-start">
                        <a style="padding: 0px;" class="btn btn-link" href="{{ url('home/paket-kursus/' . $row->id_paket . '/edit') }}">Edit</a> &nbsp;|&nbsp; 
                        <form method="post" action="{{ url('home/paket-kursus/' . $row->id_paket) }}">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <input onclick="var x = confirm('Hapus paket ini?'); if(x) { return true; }; return false;" type="submit" value="Hapus" style="padding: 0px;" class="btn btn-link">
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $paket->links() }}
</div>
@endsection