@extends('admin.layouts.app')

@section('title', 'Pelanggan')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">Periksa kembali input Anda</div>
    @endif
    <style>
        .modal-content {
            max-height: 85vh;
        }

        .modal-body {
            overflow-y: auto;
        }
    </style>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Pelanggan</h3>
        <div class="d-flex gap-2">
            <form method="GET" action="{{ url('admin/pelanggan/cari/') }}" class="d-flex">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama pelanggan..."
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-secondary btn-sm ms-1">Cari</button>
            </form>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i
                    class="bi bi-plus-circle"></i> Tambah</button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Nomor</th>
                    <th>Alamat</th>
                    <th>ID Paket</th>
                    <th>Tagihan</th>
                    <th>Tanggal Bayar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelanggan as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->nomor }}</td>
                        <td>{{ $p->alamat }}</td>
                        <td>{{ $p->paket->nama_paket }}</td>
                        <td>{{ number_format($p->tagihan, 0, ',', '.') }}</td>
                        <td>{{ $p->tanggal_bayar }}</td>
                        <td>
                            <span class="badge {{ $p->status == 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editModal" data-id="{{ $p->id }}" data-nama="{{ $p->nama }}"
                                data-nomor="{{ $p->nomor }}" data-alamat="{{ $p->alamat }}"
                                data-id_paket="{{ $p->id_paket }}" data-tagihan="{{ $p->tagihan }}"
                                data-tanggal_bayar="{{ $p->tanggal_bayar }}" data-status="{{ $p->status }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteModal" data-id="{{ $p->id }}"
                                data-nama="{{ $p->nama }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Belum ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $pelanggan->links('pagination::bootstrap-5') }}

    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addForm" action="{{ route('pelanggan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nomor</label>
                                <input type="text" name="nomor" class="form-control" value="{{ old('nomor') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Paket</label>
                                <select name="id_paket" class="form-select">
                                    <option value="">-- Pilih Paket --</option>
                                    @foreach ($paket as $pkt)
                                        <option value="{{ $pkt->id }}"
                                            {{ old('id_paket') == $pkt->id ? 'selected' : '' }}>
                                            {{ $pkt->nama_paket }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tagihan</label>
                                <input type="number" name="tagihan" class="form-control" value="{{ old('tagihan') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Bayar</label>
                                <select name="tanggal_bayar" class="form-select">
                                    <option value="">-- Pilih Tanggal --</option>
                                    @for ($i = 1; $i <= 31; $i++)
                                        <option value="{{ $i }}"
                                            {{ old('tanggal_bayar') == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
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
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" action="{{ route('pelanggan.update', ':id') }}" method="POST"
                    data-action-template="{{ route('pelanggan.update', ':id') }}">

                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nomor</label>
                                <input type="text" name="nomor" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Paket</label>
                                <select name="id_paket" class="form-select">
                                    <option value="">-- Pilih Paket --</option>
                                    @foreach ($paket as $pkt)
                                        <option value="{{ $pkt->id }}">
                                            {{ $pkt->nama_paket }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tagihan</label>
                                <input type="number" name="tagihan" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tanggal Bayar</label>
                                <select name="tanggal_bayar" class="form-select">
                                    <option value="">-- Pilih Tanggal --</option>
                                    @for ($i = 1; $i <= 31; $i++)
                                        <option value="{{ $i }}">
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="3"></textarea>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteForm" action="{{ route('pelanggan.destroy', ':id') }}" method="POST"
                    data-action-template="{{ route('pelanggan.destroy', ':id') }}">
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
        document.addEventListener('DOMContentLoaded', function() {
            var editModal = document.getElementById('editModal');
            editModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var form = document.getElementById('editForm');
                var template = form.getAttribute('data-action-template');
                form.action = template.replace(':id', button.getAttribute('data-id'));
                form.querySelector('[name=nama]').value = button.getAttribute('data-nama');
                form.querySelector('[name=nomor]').value = button.getAttribute('data-nomor');
                form.querySelector('[name=alamat]').value = button.getAttribute('data-alamat');
                form.querySelector('[name=id_paket]').value = button.getAttribute('data-id_paket');
                form.querySelector('[name=tagihan]').value = button.getAttribute('data-tagihan');
                form.querySelector('[name=tanggal_bayar]').value = button.getAttribute(
                    'data-tanggal_bayar');
                form.querySelector('[name=status]').value = button.getAttribute('data-status');
            });

            var deleteModal = document.getElementById('deleteModal');
            deleteModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var form = document.getElementById('deleteForm');
                var template = form.getAttribute('data-action-template');
                form.action = template.replace(':id', button.getAttribute('data-id'));
                var text = document.getElementById('deleteText');
                text.textContent = 'Hapus pelanggan "' + button.getAttribute('data-nama') + '"?';
            });
        });
    </script>
@endsection
