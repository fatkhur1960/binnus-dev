@extends('layouts.home')
@section('title', 'Paket')
@section('content')
<div class="card-header">Paket</div>
<div class="card-body">
    {{-- @if (\Session::has('success'))
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
    @endif --}}
    <div class="row">
        <div class="col-md-12 mb-3">
            <form action="" class="row" method="GET">
                <div class="col-md-4">
                    <a href="#" data-toggle="modal" data-target="#paketModal" class="btn btn-primary">Tambah Paket</a>
                </div>
            </form>
        </div>
    </div>
    <div class="message"></div>
    <div class="table-responsive mb-3">
        <table class="table table-sm table-border table-striped">
            <thead>
                <tr>
                    <th width="30">No.</th>
                    <th>Nama Paket</th>
                    <th>Pertemuan</th>
                    <th>Biaya Admin.</th>
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
                        <a style="padding: 0px;" class="btn btn-link" href="#" onclick="editPaket('{{ url('home/paket-kursus/' . $row->id_paket) }}');return false;">Edit</a> &nbsp;|&nbsp; 
                        <form method="post" onsubmit="hapusPaket(event, this);" action="{{ url('home/paket-kursus/' . $row->id_paket) }}">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="submit" value="Hapus" style="padding: 0px;" class="btn btn-link">
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $paket->links() }}
</div>

<div class="modal fade" id="paketModal" tabindex="-1" role="dialog" aria-labelledby="paketModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" id="formPaket" class="col-md-12" action="{{ url('/home/paket-kursus') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paketModalLabel">{{ __('Tambah Paket') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="">
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
                            <label for="harga" class="col-4 col-form-label">Biaya Administrasi</label> 
                            <div class="col-8">
                                <input id="harga" name="harga" type="text" value="{{ old('harga') }}" class="form-control{{ $errors->has('harga') ? ' is-invalid' : '' }}">
                            </div>
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
@section('script')
<script type="text/javascript">
$(document).ready(function() {
    $('#paketModal').on('hidden.bs.modal', function () {
        reset();
    });
});
function hapusPaket(e, form) {
    e.preventDefault();
    Swal.fire({
        title: 'Hapus paket ini?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
            form.submit();
        }
    });
}
const editPaket = function(url) {
    var modal = $('div#paketModal');
    var form = modal.find('form#formPaket');
    modal.find('button[data-dismiss="modal"]').attr('onclick','javascript:reset();');
    $.getJSON(url, function(result, status) {
        if(status == 'success') {
            modal.find('#paketModalLabel').text('Edit Paket');
            form.attr('action', url);
            form.prepend('<input type="hidden" name="_method" value="PATCH">');
            form.find('[name="nama_paket"]').val(result.nama_paket);
            form.find('[name="pertemuan"]').val(result.pertemuan);
            form.find('[name="harga"]').val(result.harga);
            modal.modal('show');
        }
    });
}
const reset = function() {
    console.log("reseting...");
    var modal = $('div#paketModal');
    var form = modal.find('form#formPaket');
    modal.find('#paketModalLabel').text('Tambah Paket');
    form.attr('action', '{{ url('/home/paket-kursus') }}');
    form.find('input[name="_method"]').remove();
    form.find('[name="nama_paket"]').val('');
    form.find('[name="pertemuan"]').val('');
    form.find('[name="harga"]').val('');
}
</script>
@endsection
@endsection