@extends('admin.layouts.app')

@section('title','Paket')

@section('content')
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
<div class="alert alert-danger">Periksa kembali input Anda</div>
@endif
<style>
.modal-content { max-height: 85vh; }
.modal-body { overflow-y: auto; }
</style>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Paket Internet</h3>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="bi bi-plus-circle"></i> Tambah
    </button>
</div>
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Paket</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($paket as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->nama_paket }}</td>
                <td>{{ number_format($p->harga, 0, ',', '.') }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal"
                        data-id="{{ $p->id }}"
                        data-nama_paket="{{ $p->nama_paket }}"
                        data-harga="{{ $p->harga }}">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                        data-id="{{ $p->id }}" data-nama_paket="{{ $p->nama_paket }}">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Belum ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $paket->links() }}

<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Paket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('paket.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Paket</label>
                            <input type="text" name="nama_paket" class="form-control" value="{{ old('nama_paket') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Harga</label>
                            <input type="number" name="harga" class="form-control" value="{{ old('harga') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    </div>

<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Paket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" action="{{ route('paket.update', ':id') }}" method="POST" data-action-template="{{ route('paket.update', ':id') }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Paket</label>
                            <input type="text" name="nama_paket" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Harga</label>
                            <input type="number" name="harga" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    </div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Paket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteForm" action="{{ route('paket.destroy', ':id') }}" method="POST" data-action-template="{{ route('paket.destroy', ':id') }}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p id="deleteText" class="mb-0"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var form = document.getElementById('editForm');
        var template = form.getAttribute('data-action-template');
        form.action = template.replace(':id', button.getAttribute('data-id'));
        form.querySelector('[name=nama_paket]').value = button.getAttribute('data-nama_paket');
        form.querySelector('[name=harga]').value = button.getAttribute('data-harga');
    });

    var deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var form = document.getElementById('deleteForm');
        var template = form.getAttribute('data-action-template');
        form.action = template.replace(':id', button.getAttribute('data-id'));
        var text = document.getElementById('deleteText');
        text.textContent = 'Hapus paket "' + button.getAttribute('data-nama_paket') + '"?';
    });
});
</script>
@endsection
