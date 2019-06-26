@extends('layouts.home')
@section('title', 'Jadwal')
@section('content')
<div class="card-header">Jadwal</div>

<div class="card-body">
    {{-- @if (\Session::has('success'))
    <div class="alert alert-success">
        {{ \Session::get('success') }}
    </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        Tolong isi form dengan benar!
    </div>
    @endif --}}
    <div class="message"></div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <form action="" class="row" method="GET">
                <div class="col-md-4">
                    <a href="#" data-toggle="modal" data-target="#jadwalModal" class="btn btn-primary">Tambah Jadwal</a>
                </div>
                <div class="col-md-8 form-inline justify-content-end">
                    <select name="id_paket" class="mr-sm-2 custom-select{{ $errors->has('id_paket') ? ' is-invalid' : '' }}">
                        <option value="">-- Paket --</option>
                        @foreach ($paket as $item)
                        <option {{ $req->input('id_paket') == $item->id_paket ? "selected" : "" }} value="{{ $item->id_paket }}">{{ $item->nama_paket }}</option>
                        @endforeach
                    </select>
                    <input type="submit" value="Filter" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
    <div class="table-responsive mb-3">
        <table class="table table-hover table-border table-striped">
            <thead>
                <tr>
                    <th width="30">No.</th>
                    <th>Paket</th>
                    <th>Periode</th>
                    <th>Hari</th>
                    <th>Kuota</th>
                    <th>Waktu</th>
                    <th width="190">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @if ($jadwal->count() > 0)
                @foreach ($jadwal as $row)
                <tr class="data-{{ $row->id_jadwal }}">
                    <td>{{ $num++ }}</td>
                    <td>{{ $row->paket->nama_paket }}</td>
                    <td>{{ $row->periode }}</td>
                    <td>{{ $row->hari }}</td>
                    <td>{{ $row->kuota }}</td>
                    <td>{{ $row->waktu }}</td>
                    <td>
                        <a href="#" onclick="javascript:editJadwal('{{ url('home/jadwal-kursus/' . $row->id_jadwal) }}');return false;">Edit</a> &nbsp;|&nbsp; 
                        <a data-toggle="modal" data-target="#peserta" href="{{ url('home/kelas/peserta/' . $row->paket->id_paket . '/' . $row->id_jadwal) }}">Peserta</a> &nbsp;|&nbsp; 
                        <a href="#" onclick="javascript:hapusJadwal(event, '{{ url('home/jadwal-kursus/' . $row->id_jadwal) }}', '.data-{{ $row->id_jadwal }}');return false;">Hapus</a>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" align="center">Tidak ada data</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
    @if ($req->input('id_paket'))
        {{ $jadwal->appends(['id_paket' => $req->input('id_paket')])->links() }}
    @else
        {{ $jadwal->links() }}
    @endif
</div>

<div class="modal fade" id="jadwalModal" tabindex="-1" role="dialog" aria-labelledby="jadwalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="formJadwal" method="post" class="col-md-12 mb-3" action="{{ url('/home/jadwal-kursus') }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jadwalModalLabel">{{ __('Tambah Jadwal') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
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
                    <div class="form-group row" >
                        <label class="col-4 col-form-label" for="waktu">Periode</label>
                        <div class="col-8">
                            <input type="text" placeholder="Periode" name="periode" class="form-control{{ $errors->has('periode') ? ' is-invalid' : '' }}"/>
                        </div>
                    </div>
                    <div class="form-group row" >
                        <label class="col-4 col-form-label" for="waktu">Kuota</label>
                        <div class="col-8">
                            <input type="number" name="kuota" class="form-control{{ $errors->has('kuota') ? ' is-invalid' : '' }}"/>
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
                        <label class="col-4 col-form-label" for="waktu">Waktu</label>
                        <div class="col-md-4 date">
                            <input type="text" placeholder="Mulai" name="mulai" class="form-control{{ $errors->has('mulai') ? ' is-invalid' : '' }}"/>
                        </div>
                        <div class="col-md-4 date">
                            <input type="text" placeholder="Selesai" name="selesai" class="form-control{{ $errors->has('selesai') ? ' is-invalid' : '' }}"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="peserta" tabindex="-1" role="dialog" aria-labelledby="pesertaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jadwalModalLabel">{{ __('Daftar Peserta') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <strong>Paket: <span id="paket"></span></strong>&nbsp;&nbsp;
                    <strong>Kelas: <span id="kelas"></span></strong>&nbsp;&nbsp;
                    <strong>Periode: <span id="periode"></span></strong>&nbsp;&nbsp;
                </div>
                <table class="table table-sm table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No. Induk</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>TTL</th>
                            <th>L/P</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" align="center">Tidak ada data</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
        $('input[name="periode"]').datepicker({
            autoclose: true,
            minViewMode: 1,
            format: 'mm/yyyy'
        }); 
    });
})(jQuery);

const editJadwal = function(url) {
    var modal = $('div#jadwalModal');
    var form = modal.find('form#formJadwal');
    $.getJSON(url, function(result, status) {
        if(status == 'success') {
            var day = result.hari.split('-');
            var time = result.waktu.split('-');
            modal.find('#jadwalModalLabel').text('Edit Jadwal');
            form.attr('action', url);
            form.prepend('<input type="hidden" name="_method" value="PATCH">');
            form.find('[name="id_paket"]').val(result.id_paket);
            form.find('[name="id_paket"]').attr('disabled',true);
            form.find('[name="periode"]').val(result.periode);
            form.find('[name="periode"]').attr('readonly',true);
            form.find('[name="kuota"]').val(result.kuota);
            form.find('[name="hari_1"]').val(day[0]);
            form.find('[name="hari_2"]').val(day[1]);
            form.find('[name="mulai"]').val(time[0]);
            form.find('[name="selesai"]').val(time[1]);
            modal.modal('show');
        }
    });
}
const hapusJadwal = function(e, url, data) {
    e.preventDefault();
    Swal.fire({
        title: 'Hapus jadwal ini?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
            $.post(url, {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "_method": "DELETE"
            }, function(res, status) {
                $('tr').remove(data);
                Swal.fire({
                    type: 'success',
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        }
    });
}
$(document).ready(function() {
    $('#peserta').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var link = button.attr('href')
        
        var table = $(this).find('table > tbody');
        $.ajax({
            url: link,
            type: 'GET',
            dataType: 'JSON',
            error: function(err) {
                console.log(err.responseText);
            },
            success: function(res) {
                $('span#paket').text(res.paket);
                $('span#kelas').text(res.kelas);
                $('span#periode').text(res.periode);
                table.empty();
                if(res.data.length > 0) {
                    $.each(res.data, function(i, item) {
                        var url = "{{ url('/home/peserta/') }}/"+item.id_peserta;
                        table.append('<tr><td>'+item.no_induk+'</td><td>'+item.nik+'</td><td>'+item.nama_lengkap+'</td><td>'+item.ttl+'</td><td>'+item.jen_kel+'</td><td><a href="'+url+'">Detail</td></tr>');
                    });
                } else {
                    table.append('<tr><td colspan="6" align="center">Tidak ada data</td></tr>');
                }
            }
        });
    });
});
</script>   
@endsection