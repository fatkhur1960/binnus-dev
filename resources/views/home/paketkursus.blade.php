@extends('layouts.home')
@section('title', 'Paket Kursus')
@section('content')
<div class="card-header">Paket Kursus</div>

<div class="card-body">
    @if($user->file_foto == '' || $user->file_kk == '')
    <div class="alert alert-danger" role="alert">
        <strong>Info!</strong> Mohon untuk melengkapi foto dan scan Kartu Keluarga 
        (<a href="{{ url('home/profil') }}" class="alert-link">di sini</a>) sebelum mengambil paket kursus
    </div>
    @else
    @if (\Session::has('success'))
    <div class="alert alert-success">
        {{ \Session::get('success') }}
    </div>
    @endif
    <form method="post" class="col-md-12 mb-3" action="{{ url('/home/ambil-paket') }}">
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
                    <label for="id_paket" class="col-4 col-form-label">Biaya</label> 
                    <div class="col-8">
                        <input type="text" class="form-control" id="biaya" readonly/>
                        <input type="hidden" class="form-control" name="harga"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id_paket" class="col-4 col-form-label">Pertemuan</label> 
                    <div class="col-8">
                        <input type="text" class="form-control" id="pertemuan" readonly/>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <input type="hidden" name="id_peserta" value="{{ $user->id_peserta }}"/>
                <input name="submit" type="submit" class="btn btn-primary" value="Ambil">
            </div>
        </div>
    </form>

    <div class="table-responsive mb-3">
        <input type="hidden" value="{{ $no = 1 }}"/>
        <table class="table table-border table-sm table-striped">
            <thead>
                <tr>
                    <th width="30">No.</th>
                    <th>No. Induk</th>
                    <th>Paket</th>
                    <th>Jadwal</th>
                    <th>Waktu</th>
                    <th>Status</th>
                    <th width="140">Operasi</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($kelas as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $item->peserta->no_induk }}</td>
                <td>{{ $item->paket->nama_paket }}</td>
                @if($item->id_jadwal != '')
                <td>{{ $item->jadwal->hari }}</td>
                <td>{{ $item->jadwal->waktu }} WIB</td>
                @else
                <td>-</td>
                <td>-</td>
                @endif
                @if($item->pembayaran->status == 'Pending')
                <td>Pembayaran</td>
                @else
                <td>Terbayar</td>
                @endif
                @if($item->id_jadwal == '' && $item->pembayaran->status == 'Confirmed')
                <td><a href="#" data-toggle="modal" data-target="#ambilJadwal" data-kelas="{{ $item->id_kelas }}" data-paket="{{ $item->paket->id_paket }}">Ambil Jadwal</a></td>
                @elseif($item->id_jadwal != '' && $item->pembayaran->status == 'Confirmed')
                <td><a href="#" data-toggle="modal" data-target="#ambilJadwal" data-jadwal="{{ $item->id_jadwal }}" data-kelas="{{ $item->id_kelas }}" data-paket="{{ $item->paket->id_paket }}">Ubah Jadwal</a></td>
                @else
                <td><a href="{{ url('home/pembayaran?status=Pending') }}">Konfirmasi</a></td>
                @endif
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
@section('script')
<div class="modal fade" id="ambilJadwal" tabindex="-1" role="dialog" aria-labelledby="ambilJadwalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ambilJadwalLabel">{{ __('Ambil Jadwal') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                <table class="table table-condensed table-sm table-striped">
                    <thead>
                        <tr>
                            <th>Hari</th>
                            <th>Waktu</th>
                            <th>Kuota</th>
                            <th>Sisa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('select[name="id_paket"]').change(function() {
        $.ajax({
            type: 'get',
            url: '/home/get-paket',
            data: {id_paket: $(this).val()},
            dataType: 'json',
            error: function(err) {
              console.log(err.responseText);  
            },
            success: function(result) {
                if(result) {
                    $('input#biaya').val(toRupiah(result.paket.harga));
                    $('input[name="harga"]').val(result.paket.harga);
                    $('input#pertemuan').val(result.paket.pertemuan + " Kali Pertemuan");
                } else {
                    alert('Belum ada jadwal');
                }
            }
        });
    });

    $('#ambilJadwal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id_paket = button.data('paket');
        var id_kelas = button.data('kelas');
        var id_jadwal = button.data('jadwal');
        var modal = $(this);
        $.ajax({
            type: 'get',
            url: '/home/get-jadwal',
            data: {id_paket: id_paket, id_jadwal: id_jadwal},
            dataType: 'json',
            error: function(err) {
              console.log(err.responseText);  
            },
            success: function(result) {
                if(result) {
                    var link = '';
                    modal.find('.modal-body tbody').empty();
                    $.each(result.jadwal, function(i, item) {
                        if(item.sisa > 0) {
                            link = '<a href="#" onclick="updateJadwal(\''+id_kelas+'\',\''+item.id_jadwal+'\');return false;">Pilih</a>';
                        } else {
                            link = 'Penuh';
                        }
                        modal.find('.modal-body tbody').append('<tr><td>'+item.hari+'</td><td>'+item.waktu+'</td><td>'+item.kuota+'</td><td>'+item.sisa+'</td><td>'+link+'</td></tr>');
                    });
                } else {
                    alert('Belum ada jadwal');
                }
            }
        });
    });
});
function updateJadwal(id_kelas, id_jadwal) {
    var modal = $('div#ambilJadwal');
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: 'POST',
        url: '/home/ambil-jadwal',
        data: {_token: CSRF_TOKEN, id_kelas: id_kelas, id_jadwal: id_jadwal},
        dataType: 'json',
        error: function(err) {
            console.log(err.responseText);  
        },
        success: function(result, response) {
            if(response == 'success') {
                modal.find('.modal-body').empty();
                modal.find('.modal-body').append('<div class="alert alert-success">'+result.message+'</div>');
                setTimeout(() => {
                    window.location = "{{ url('/home/pilih-paket-kursus') }}";
                }, 1000);
            }
        }
    });
}
function toRupiah(angka) {
    var number_string = angka.toString().replace(/[^,\d]/g, '').toString(),
    split   		= number_string.split(','),
    sisa     		= split[0].length % 3,
    rupiah     		= split[0].substr(0, sisa),
    ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return 'Rp. ' + rupiah;
}
</script>
@endsection