@extends('admin.layouts.app')

@section('title', 'Tagihan')

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
        <h3 class="mb-0">Tagihan Bulanan</h3>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#generateModal">
                <i class="bi bi-receipt"></i> Generate Tagihan
            </button>
            {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bi bi-plus-circle"></i> Tambah
            </button> --}}
        </div>
    </div>
    <form class="row g-2 align-items-end mb-3" method="GET" action="{{ route('tagihan.index') }}">
        <div class="col-md-4">
            <label class="form-label">Nama Pelanggan</label>
            <input type="text" name="nama" value="{{ $filters['nama'] ?? '' }}" class="form-control"
                placeholder="Cari nama">
        </div>
        <div class="col-md-3">
            <label class="form-label">Bulan</label>
            <input type="number" name="bulan" min="1" max="12" value="{{ $filters['bulan'] ?? '' }}"
                class="form-control" placeholder="1-12">
        </div>
        <div class="col-md-3">
            <label class="form-label">Tahun</label>
            <input type="number" name="tahun" min="2000" max="2100" value="{{ $filters['tahun'] ?? '' }}"
                class="form-control" placeholder="YYYY">
        </div>
        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-outline-secondary">Filter</button>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pelanggan</th>
                    <th>Nominal</th>
                    <th>Periode</th>
                    <th>Jatuh Tempo</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tagihan as $t)
                    <tr>
                        <td>{{ $t->id }}</td>
                        <td>{{ optional($pelangganList->firstWhere('id', $t->pelanggan_id))->nama }}</td>
                        <td>{{ number_format($t->nominal, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($t->periode)->locale('id')->translatedFormat('F Y') }}</td>
                        @php
                            $jatuhTempo = \Carbon\Carbon::parse($t->jatuh_tempo);
                            $now = \Carbon\Carbon::now();
                            $diffDays = $now->diffInDays($jatuhTempo, false);
                        @endphp
                        <td>
                            <span
                                class="badge 
                                            @if ($t->status === 'lunas') bg-success" title="Sudah lunas
                                            @elseif ($diffDays < 0 && $t->status !== 'lunas') bg-danger" title="Sudah lewat jatuh tempo
                                            @elseif($diffDays <= 3) bg-warning text-dark" title="Mendekati jatuh tempo
                                            @elseif($diffDays >= 3) text-black" title="Mendekati jatuh tempo @endif
                                        ">
                                {{ $jatuhTempo->locale('id')->translatedFormat('d F Y') }}
                            </span>
                        </td>
                        <td>
                            @if ($t->status !== 'lunas')
                                <span class="badge bg-warning text-dark">Belum Lunas</span>
                            @endif
                            @if ($t->status === 'lunas')
                                <span class="badge bg-success">Lunas</span>
                            @endif
                        </td>
                        <td>
                            {{-- <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editModal" data-id="{{ $t->id }}"
                                data-pelanggan_id="{{ $t->pelanggan_id }}" data-nominal="{{ $t->nominal }}"
                                data-periode="{{ $t->periode }}" data-jatuh_tempo="{{ $t->jatuh_tempo }}"
                                data-status="{{ $t->status }}">
                                <i class="bi bi-pencil"></i>
                            </button> --}}
                            @if ($t->status !== 'lunas')
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                    title="Bayar Tagihan" data-bs-target="#payModal" data-id="{{ $t->id }}"
                                    data-nama="{{ optional($pelangganList->firstWhere('id', $t->pelanggan_id))->nama }}"
                                    data-nominal="{{ number_format($t->nominal, 0, ',', '.') }}">
                                    <i class="bi bi-cash-coin"></i> Bayar
                                </button>
                            @endif
                            @if ($t->status === 'lunas')
                                <a href="{{ route('tagihan.print', $t->id) }}" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-printer"></i>
                                </a>
                            @endif

                            @if($t->status !== 'lunas')
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteModal" data-id="{{ $t->id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $tagihan->links('pagination::bootstrap-5') }}

    <div class="modal fade" id="generateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generate Tagihan Bulanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tagihan.generate') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Bulan</label>
                                <input type="number" min="1" max="12" name="bulan" class="form-control"
                                    value="{{ now()->month }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tahun</label>
                                <input type="number" min="2000" max="2100" name="tahun" class="form-control"
                                    value="{{ now()->year }}">
                            </div>
                            <div class="col-12">
                                <small class="text-muted">Generate dilakukan untuk semua pelanggan. Jatuh tempo mengikuti
                                    tanggal_bayar tiap pelanggan dan disesuaikan dengan akhir bulan.</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Generate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Tagihan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tagihan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Pelanggan</label>
                                <select name="pelanggan_id" class="form-select">
                                    @foreach ($pelangganList as $p)
                                        <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                           
                            <div class="col-md-6">
                                <label class="form-label">Bulan</label>
                                <input type="number" name="bulan" class="form-control" min="1" max="12" value="{{ now()->month }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tahun</label>
                                <input type="number" name="tahun" class="form-control" min="2000" max="2100" value="{{ now()->year }}">
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
    </div> --}}

    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Tagihan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" action="{{ route('tagihan.update', ':id') }}" method="POST"
                    data-action-template="{{ route('tagihan.update', ':id') }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Pelanggan</label>
                                <select name="pelanggan_id" class="form-select">
                                    @foreach ($pelangganList as $p)
                                        <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nominal</label>
                                <input type="number" name="nominal" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Periode</label>
                                <input type="date" name="periode" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jatuh Tempo</label>
                                <input type="date" name="jatuh_tempo" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <input type="text" name="status" class="form-control">
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

    <div class="modal fade" id="payModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bayar Tagihan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="payForm" action="/admin/tagihan/:id/bayar" method="POST"
                    data-action-template="/admin/tagihan/:id/bayar">
                    @csrf
                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label">Nama Pelanggan</label>
                            <input type="disabled" id="pay_nama" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Total Tagihan</label>
                            <input type="disabled" id="pay_nominal" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Bayar</label>
                            <input type="date" name="tanggal_bayar" class="form-control"
                                value="{{ now()->toDateString() }}">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Bayar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Tagihan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteForm" action="{{ route('tagihan.destroy', ':id') }}" method="POST"
                    data-action-template="{{ route('tagihan.destroy', ':id') }}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Yakin menghapus tagihan ini?</p>
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
                form.querySelector('[name=pelanggan_id]').value = button.getAttribute('data-pelanggan_id');
                form.querySelector('[name=nominal]').value = button.getAttribute('data-nominal');
                form.querySelector('[name=periode]').value = button.getAttribute('data-periode');
                form.querySelector('[name=jatuh_tempo]').value = button.getAttribute('data-jatuh_tempo');
                form.querySelector('[name=status]').value = button.getAttribute('data-status');
            });

            var payModal = document.getElementById('payModal');
            payModal.addEventListener('show.bs.modal', function(event) {

                var button = event.relatedTarget;
                var form = document.getElementById('payForm');

                var template = form.getAttribute('data-action-template');
                form.action = template.replace(':id', button.getAttribute('data-id'));

                // isi data pelanggan
                document.getElementById('pay_nama').value =
                    button.getAttribute('data-nama');

                document.getElementById('pay_nominal').value =
                    'Rp ' + button.getAttribute('data-nominal');

            });


            var deleteModal = document.getElementById('deleteModal');
            deleteModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var form = document.getElementById('deleteForm');
                var template = form.getAttribute('data-action-template');
                form.action = template.replace(':id', button.getAttribute('data-id'));
            });
        });
    </script>
@endsection
