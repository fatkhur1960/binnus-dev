@extends('layouts.home')
@section('title', 'Jadwal')
@section('content')
<div class="card-header">Jadwal</div>

<div class="card-body">
    @if (\Session::has('success'))
    <div class="alert alert-success">
        {{ \Session::get('success') }}
    </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        Tolong isi form dengan benar!
    </div>
    @endif
    <form method="post" class="col-md-12 mb-3" action="{{ url('/home/jadwal-kursus') }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="id_paket" class="col-4 col-form-label">Paket</label> 
                    <div class="col-8">
                        <select name="id_paket" class="custom-select{{ $errors->has('id_paket') ? ' is-invalid' : '' }}">
                        <option value="">-- Pilih Paket --</option>
                        @foreach ($paket as $item)
                           <option value="{{ $item->id_paket }}">{{ $item->nama_paket }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="hari" class="col-4 col-form-label">Hari</label> 
                    <div class="col-4">
                        <select name="hari_1" class="custom-select{{ $errors->has('hari_1') ? ' is-invalid' : '' }}">
                            <option value="">-- Hari --</option>
                            @foreach ($hari as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                        <select name="hari_2" class="custom-select{{ $errors->has('hari_2') ? ' is-invalid' : '' }}">
                            <option value="">-- Hari --</option>
                            @foreach ($hari as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row" >
                    <label class="col-4 col-form-label" for="waktu">Kuota</label>
                    <div class="col-8">
                        <input type="number" name="kuota" class="form-control{{ $errors->has('kuota') ? ' is-invalid' : '' }}"/>
                    </div>
                </div>
                <div class="form-group row" >
                    <label class="col-4 col-form-label" for="waktu">Waktu</label>
                    <div class="col-md-4 mb-3 date">
                        <input type="text" placeholder="Mulai" name="mulai" class="form-control{{ $errors->has('mulai') ? ' is-invalid' : '' }}"/>
                    </div>
                    <div class="col-md-4 date">
                        <input type="text" placeholder="Selesai" name="selesai" class="form-control{{ $errors->has('selesai') ? ' is-invalid' : '' }}"/>
                    </div>
                    <script type="text/javascript">
                        (function($){
                            $(function(){
                                $('input[name="mulai"]').datetimepicker({
                                    "allowInputToggle": true,
                                    "showClose": true,
                                    "showClear": true,
                                    "showTodayButton": true,
                                    "format": "HH:mm",
                                });
                                $('input[name="selesai"]').datetimepicker({
                                    "allowInputToggle": true,
                                    "showClose": true,
                                    "showClear": true,
                                    "showTodayButton": true,
                                    "format": "HH:mm",
                                });
                            });
                        })(jQuery);
                    </script>
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
                    <th>Paket</th>
                    <th>Hari</th>
                    <th>Kuota</th>
                    <th>Waktu</th>
                    <th width="140">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwal as $row)
                <tr>
                    <td>{{ $num++ }}</td>
                    <td>{{ $row->paket->nama_paket }}</td>
                    <td>{{ $row->hari }}</td>
                    <td>{{ $row->kuota }}</td>
                    <td>{{ $row->waktu }}</td>
                    <td class="d-flex justify-content-start">
                        <a style="padding: 0px;" class="btn btn-link" href="{{ url('home/jadwal-kursus/' . $row->id_jadwal . '/edit') }}">Edit</a> &nbsp;|&nbsp; 
                        <form method="post" action="{{ url('home/jadwal-kursus/' . $row->id_jadwal) }}">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <input onclick="var x = confirm('Hapus jadwal ini?'); if(x) { return true; }; return false;" type="submit" value="Hapus" style="padding: 0px;" class="btn btn-link">
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $jadwal->links() }}
</div>
@endsection