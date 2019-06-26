@extends('layouts.home')
@section('title', 'Histori Pembayaran')
@section('content')
<div class="card-header">Histori Pembayaran</div>

<div class="card-body">
    @if (\Session::has('success'))
    <div class="alert alert-success">
        {{ \Session::get('success') }}
    </div>
    @endif
    <form action="" method="get" class="form-inline">
        <input type="text" placeholder="No. Induk" class="form-control mb-2 mr-sm-2" name="no_induk" />
        <select name="status" class="custom-select mb-2 mr-sm-2">
            <option value="">-- Status --</option>
            <option value="Pending">Pending</option>
            <option value="Processing">Dalam Proses</option>
            <option value="Confirmed">Terbayar</option>
            <option value="Canceled">Dibatalkan</option>
        </select>
        <input type="submit" value="Lihat" class="btn btn-primary mb-2 mr-sm-2"/>
    </form>
    <input type="hidden" value="{{ $num=1 }}"/>
    <div class="table-responsive mb-3">
        <table class="table table-sm table-border table-striped">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">No. Induk</th>
                    <th scope="col">Paket</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Tgl. Pembayaran</th>
                    <th scope="col">Tagihan</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($history as $row)
                <tr>
                    <td scope="row">{{ $num++ }}</td>
                    <td>{{ $row->no_induk == '' ? $row->peserta->no_induk : $row->no_induk }}</td>
                    <td>{{ $row->nama_paket == '' ? $row->paket->nama_paket : $row->nama_paket }}</td>
                    <td>{{ $row->created_at }}</td>
                    <td>{{ $row->status == 'Processing' || $row->status == 'Confirmed' ? $row->updated_at : '-' }}</td>
                    <td>Rp. {{ number_format($row->total_harga) }}</td>
                    <td>
                        @if($row->status == 'Pending')
                        <span class="badge badge-secondary">{{ $row->status }}</span>
                        @elseif($row->status == 'Confirmed')
                        <span class="badge badge-success">{{ $row->status }}</span>
                        @elseif($row->status == 'Processing')
                        <a href="#" data-id="{{ $row->id }}" data-toggle="modal" data-target="#confirmModal" class="badge badge-warning">
                            Detail
                        </a>
                        @else
                        <span class="badge badge-danger">{{ $row->status }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $history->links() }}
</div>
@endsection
@section('script')
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="confirmForm" action="" method="post" enctype="multipart/form-data">
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
                    <img class="img-fluid rounded mx-auto d-block" id="bukti"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Konfirmasi</button>
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
        var modal = $(this);
        $.ajax({
            url: '/home/histori-pembayaran/' + id,
            type: 'get',
            dataType: 'json',
            error: function(err) {
                console.log(err.responseText);
            },
            success: function(res) {
                modal.find('.modal-body img#bukti').attr('src', "{{ url('uploads/confirm') }}/" + res.confirm_file);
            }
        });
        modal.find('.modal-body input[name="id"]').val(id);
    });

    $('form#confirmForm').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var id = form.find('.modal-body input[name="id"]').val();
        
        $.ajax({
            url: "/home/histori-pembayaran/" + id,
            type: 'PUT',
            data: form.serialize(),
            dataType: 'json',
            error: function(err) {
                console.log(err.responseText);
            },
            success: function(res,status) {
                if(status == 'success') {
                    form.find('.modal-body').empty();
                    form.find('.modal-footer').empty();
                    form.find('.modal-body').append('<div class="alert alert-success">'+res.message+'</div>');
                    setTimeout(() => {
                        window.location = "{{ url('/home/histori-pembayaran?status=Confirmed') }}";
                    }, 1000);
                }
            }
        });

        return false;
    });
});
</script>
@endsection