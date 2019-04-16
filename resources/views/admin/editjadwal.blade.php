@extends('layouts.home')
@section('title', 'Edit Jadwal')
@section('content')
<div class="card-header">Edit Jadwal</div>

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
    <form method="post" class="col-md-12" action="{{ action('JadwalController@update', $jadwal->id_jadwal) }}">
        @csrf
        <input type="hidden" name="_method" value="PATCH"/>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="id_paket" class="col-4 col-form-label">Paket</label> 
                    <div class="col-8">
                        <select name="id_paket" class="custom-select" disabled="true">
                        @foreach ($paket as $item)
                            @if($item->id_paket == $jadwal->id_paket)
                                <option selected="selected" value="{{ $item->id_paket }}">{{ $item->nama_paket }}</option>
                            @else
                                <option value="{{ $item->id_paket }}">{{ $item->nama_paket }}</option>
                            @endif
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="hari" class="col-4 col-form-label">Hari</label> 
                    <div class="col-4">
                        <select name="hari_1" class="custom-select{{ $errors->has('hari_1') ? ' is-invalid' : '' }}">
                            @foreach ($hari as $item)
                                @if($item == $day[0])
                                    <option selected="selected" value="{{ $item }}">{{ $item }}</option>
                                @else
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                        <select name="hari_2" class="custom-select{{ $errors->has('hari_2') ? ' is-invalid' : '' }}">
                            @foreach ($hari as $item)
                                @if($item == $day[1])
                                    <option selected="selected" value="{{ $item }}">{{ $item }}</option>
                                @else
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row" >
                    <label class="col-4 col-form-label" for="waktu">Kuota</label>
                    <div class="col-8">
                        <input value="{{ $jadwal->kuota }}" type="number" name="kuota" class="form-control{{ $errors->has('kuota') ? ' is-invalid' : '' }}"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label" for="waktu">Waktu</label>
                    <div class="col-md-4 date">
                        <input type="text" value="{{ $time[0] }}" placeholder="Mulai" name="mulai" class="form-control"/>
                    </div>
                    <div class="col-md-4 date">
                        <input type="text" value="{{ $time[1] }}" placeholder="Selesai" name="selesai" class="form-control"/>
                    </div>
                </div>
                <div class="form-group row" >
                    <label class="col-4 col-form-label" for="waktu">Periode</label>
                    <div class="col-8">
                        <input type="text" name="periode" class="form-control{{ $errors->has('periode') ? ' is-invalid' : '' }}"/>
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
@section('script')
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
@endsection