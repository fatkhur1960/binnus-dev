@extends('layouts.home')
@section('title', 'Pembayaran')
@section('content')
<div class="card-header">Pembayaran</div>

<div class="card-body">
    @if (\Session::has('success'))
    <div class="alert alert-success">
        {{ \Session::get('success') }}
    </div>
    @endif
    <form action="" method="get" class="form-inline">
        <select name="status" class="custom-select mb-2 mr-sm-2">
            <option value="">-- Status --</option>
            <option value="Pending">Pending</option>
            <option value="Processing">Dalam Proses</option>
            <option value="Confirmed">Terbayar</option>
            <option value="Canceled">Dibatalkan</option>
        </select>
        <input type="submit" value="Lihat" class="btn btn-primary mb-2 mr-sm-2"/>
    </form>
    <div class="table-responsive mb-3">
        <table class="table table-sm table-border table-striped">
            <thead>
                <tr>
                    <th wi scope="col">No</th>
                    <th scope="col">Paket</th>
                    <th scope="col">Tgl.</th>
                    <th scope="col">Tgl. Pembayaran</th>
                    <th scope="col">Tagihan</th>
                    <th scope="col">Status</th>
                    @if($status == 'Pending')
                    <th scope="col">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($history as $row)
                <tr>
                    <td scope="row">{{ $num++ }}</td>
                    <td>{{ $row->paket->nama_paket }}</td>
                    <td>{{ $row->created_at }}</td>
                    <td>{{ $row->updated_at }}</td>
                    <td>Rp. {{ number_format($row->total_harga) }}</td>
                    <td>
                        @if($row->status == 'Pending')
                        <span class="badge badge-secondary">{{ $row->status }}</span>
                        @elseif($row->status == 'Confirmed')
                        <span class="badge badge-success">{{ $row->status }}</span>
                        @else
                        <span class="badge badge-warning">{{ $row->status }}</span>
                        @endif
                    </td>
                    @if($status == 'Pending')
                    <td>
                        <div class="btn-group" style="position: relative;">
                            <button class="btn btn-link btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Aksi
                            </button>
                            <div class="dropdown-menu" style="position: absolute;z-index: 99999;">
                                <a data-id="{{ $row->id }}" data-nik="{{ $row->peserta->nik }}" data-toggle="modal" data-target="#confirmModal" class="dropdown-item" href="#">Konfirmasi Pembayaran</a>
                                <a onclick="var x = confirm('Batalkan Pembayaran?'); if(x) {return true;} return false;" class="dropdown-item" href="{{ url('home/cancel/' . $row->id) }}">Batalkan Pembayaran</a>
                            </div>
                        </div>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $history->links() }}
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ url('home/confirm') }}" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">{{ __('Konfirmasi Pembayaran') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id">
                    <input type="hidden" name="nik">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Upload Bukti Pembayaran:</label>
                        <input required="required" type="file" name="confirm_file" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#confirmModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var nik = button.data('nik');
        var modal = $(this);
        modal.find('.modal-body input[name="id"]').val(id);
        modal.find('.modal-body input[name="nik"]').val(nik);
    });
});
</script>
@endsection
