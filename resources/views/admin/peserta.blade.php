@extends('layouts.home')
@section('title', 'Daftar Peserta')
@section('content')
<div class="card-header">Daftar Peserta</div>
<div class="card-body">
    <div class="row">
        <div class="col-md-4">
            <select id="id_paket" class="custom-select mb-4">
                <option value="">-- Pilih Paket --</option>
                @foreach ($paket as $item)
                    <option value="{{ $item->id_paket }}">{{ $item->nama_paket }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select onchange="getDataPeserta(this.value)" id="id_jadwal" class="custom-select mb-4" disabled>
                <option value="">-- Pilih Kelas --</option>
            </select>
        </div>
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
@endsection

@section('script')
<script type="text/javascript">
$(document).ready(function() {
    $('select#id_paket').change(function() {
        $.ajax({
            url: '/home/get-jadwal',
            type: 'GET',
            data: {id_paket: $(this).val()},
            dataType: 'JSON',
            error: function(err) {
                console.log(err.responseText);
            },
            success: function(res) {
                $('select#id_jadwal').removeAttr('disabled');
                $('select#id_jadwal').empty();
                $('select#id_jadwal').append('<option value="">-- Pilih Periode --</option>');
                $.each(res.jadwal, function(index, item) {
                    $('select#id_jadwal').append('<option value="'+item.id_jadwal+'">'+item.periode+'</option>');
                });
            }
        });
    });
});

function getDataPeserta(id_jadwal) {
    var table = $('table tbody');
    $.ajax({
        url: '/home/get-peserta',
        type: 'POST',
        data: {
            id_paket: $('select#id_paket').val(),
            id_jadwal: id_jadwal,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'JSON',
        error: function(err) {
            console.log(err.responseText);
        },
        success: function(res) {
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
}
</script>
@endsection