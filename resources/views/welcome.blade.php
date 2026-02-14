<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Billing Internet</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --success-color: #4cc9f0;
            --warning-color: #f72585;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }
        
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .sidebar {
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 12px 20px;
            margin-bottom: 5px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
        }
        
        .sidebar .nav-link i {
            width: 24px;
            text-align: center;
            margin-right: 10px;
        }
        
        .main-content {
            padding: 20px;
        }
        
        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 20px;
        }
        
        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        
        .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }
        
        .stat-card-1 .card-icon {
            background-color: var(--primary-color);
        }
        
        .stat-card-2 .card-icon {
            background-color: var(--success-color);
        }
        
        .stat-card-3 .card-icon {
            background-color: var(--warning-color);
        }
        
        .stat-card-4 .card-icon {
            background-color: #7209b7;
        }
        
        .table-custom th {
            background-color: #f8f9fa;
            border-top: none;
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .badge-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
        }
        
        .badge-aktif {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .badge-tunggak {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .badge-nonaktif {
            background-color: #e5e7eb;
            color: #374151;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        .header {
            background-color: white;
            border-bottom: 1px solid #eaeaea;
            padding: 15px 0;
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--warning-color);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 8px;
            padding: 10px 20px;
        }
        
        .btn-primary-custom:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .chart-container {
            height: 300px;
            position: relative;
        }
        
        .search-box {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 10px 15px;
        }
        
        .search-box:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        }
        
        .modal-header-custom {
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
                position: static;
            }
            
            .main-content {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 col-md-3 px-0 sidebar">
                <div class="d-flex flex-column pt-3">
                    <!-- Logo -->
                    <div class="text-center mb-4">
                        <h3 class="text-white fw-bold"><i class="bi bi-wifi"></i> NetBilling</h3>
                        <p class="text-white-50 small">Admin Dashboard</p>
                    </div>
                    
                    <!-- Menu Navigasi -->
                    <ul class="nav flex-column px-3">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-people"></i> Pelanggan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-credit-card"></i> Tagihan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-cash-stack"></i> Pembayaran
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-bar-chart"></i> Laporan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-gear"></i> Pengaturan
                            </a>
                        </li>
                        <li class="nav-item mt-4">
                            <a class="nav-link" href="#">
                                <i class="bi bi-question-circle"></i> Bantuan
                            </a>
                        </li>
                    </ul>
                    
                    <!-- Info Admin -->
                    <div class="px-3 mt-auto mb-4">
                        <div class="d-flex align-items-center text-white">
                            <div class="user-avatar me-3">AD</div>
                            <div>
                                <h6 class="mb-0">Admin User</h6>
                                <small class="text-white-50">Super Administrator</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">
                <!-- Header -->
                <div class="header mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="mb-0 fw-bold">Dashboard Billing Internet</h4>
                            <p class="text-muted mb-0">Selamat datang kembali, Admin</p>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            <div class="d-flex align-items-center">
                                <!-- Pencarian -->
                                <div class="input-group me-3" style="width: 250px;">
                                    <input type="text" class="form-control search-box" placeholder="Cari pelanggan...">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                                
                                <!-- Notifikasi -->
                                <div class="position-relative me-3">
                                    <button class="btn btn-light rounded-circle p-2" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-bell"></i>
                                        <span class="notification-badge">3</span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><h6 class="dropdown-header">Notifikasi</h6></li>
                                        <li><a class="dropdown-item" href="#">Pembayaran baru dari Pelanggan #123</a></li>
                                        <li><a class="dropdown-item" href="#">5 tagihan akan jatuh tempo</a></li>
                                        <li><a class="dropdown-item" href="#">Pelanggan baru terdaftar</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-primary" href="#">Lihat semua</a></li>
                                    </ul>
                                </div>
                                
                                <!-- Tombol Aksi -->
                                <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#tambahPelangganModal">
                                    <i class="bi bi-plus-circle me-2"></i>Tambah Pelanggan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Statistik -->
                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-custom stat-card-1">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title text-muted">Total Pelanggan</h5>
                                        <h2 class="fw-bold">1,245</h2>
                                        <p class="card-text"><span class="text-success"><i class="bi bi-arrow-up"></i> 5.2%</span> dari bulan lalu</p>
                                    </div>
                                    <div class="card-icon">
                                        <i class="bi bi-people-fill"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-custom stat-card-2">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title text-muted">Pendapatan Bulan Ini</h5>
                                        <h2 class="fw-bold">Rp 84,5 Jt</h2>
                                        <p class="card-text"><span class="text-success"><i class="bi bi-arrow-up"></i> 12.8%</span> dari bulan lalu</p>
                                    </div>
                                    <div class="card-icon">
                                        <i class="bi bi-cash-coin"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-custom stat-card-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title text-muted">Tagihan Tertunggak</h5>
                                        <h2 class="fw-bold">Rp 12,3 Jt</h2>
                                        <p class="card-text"><span class="text-danger"><i class="bi bi-arrow-down"></i> 3.5%</span> dari bulan lalu</p>
                                    </div>
                                    <div class="card-icon">
                                        <i class="bi bi-exclamation-triangle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-custom stat-card-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title text-muted">Aktivitas Bulan Ini</h5>
                                        <h2 class="fw-bold">1,028</h2>
                                        <p class="card-text"><span class="text-success"><i class="bi bi-arrow-up"></i> 8.7%</span> dari bulan lalu</p>
                                    </div>
                                    <div class="card-icon">
                                        <i class="bi bi-activity"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tabel Pelanggan & Chart -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card card-custom">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0 fw-bold">Daftar Pelanggan Terbaru</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-custom">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Pelanggan</th>
                                                <th>Paket Internet</th>
                                                <th>Tagihan</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="user-avatar me-3">AS</div>
                                                        <div>
                                                            <strong>Ahmad Sanusi</strong><br>
                                                            <small class="text-muted">ahmad@email.com</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Business 50 Mbps</td>
                                                <td>Rp 550.000</td>
                                                <td><span class="badge badge-status badge-aktif">Aktif</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary me-1">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-warning">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="user-avatar me-3">BS</div>
                                                        <div>
                                                            <strong>Budi Santoso</strong><br>
                                                            <small class="text-muted">budi@email.com</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Family 30 Mbps</td>
                                                <td>Rp 350.000</td>
                                                <td><span class="badge badge-status badge-tunggak">Tunggak</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary me-1">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-warning">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="user-avatar me-3">CD</div>
                                                        <div>
                                                            <strong>Cindy Dewi</strong><br>
                                                            <small class="text-muted">cindy@email.com</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Premium 100 Mbps</td>
                                                <td>Rp 850.000</td>
                                                <td><span class="badge badge-status badge-aktif">Aktif</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary me-1">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-warning">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="user-avatar me-3">DW</div>
                                                        <div>
                                                            <strong>Dian Wulandari</strong><br>
                                                            <small class="text-muted">dian@email.com</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Basic 10 Mbps</td>
                                                <td>Rp 200.000</td>
                                                <td><span class="badge badge-status badge-nonaktif">Nonaktif</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary me-1">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-warning">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="user-avatar me-3">ER</div>
                                                        <div>
                                                            <strong>Eko Riyadi</strong><br>
                                                            <small class="text-muted">eko@email.com</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Business 50 Mbps</td>
                                                <td>Rp 550.000</td>
                                                <td><span class="badge badge-status badge-aktif">Aktif</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary me-1">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-warning">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div class="text-muted">Menampilkan 5 dari 1,245 pelanggan</div>
                                    <button class="btn btn-outline-primary">Lihat Semua Pelanggan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card card-custom mb-4">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0 fw-bold">Statistik Pembayaran</h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <!-- Chart sederhana (bisa diganti dengan library chart seperti Chart.js) -->
                                    <div class="d-flex justify-content-center align-items-center h-100">
                                        <div class="text-center">
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-center mb-2">
                                                    <div class="rounded-circle bg-primary d-flex justify-content-center align-items-center" style="width: 120px; height: 120px;">
                                                        <span class="text-white fw-bold">85%</span>
                                                    </div>
                                                </div>
                                                <h5>Pembayaran Tepat Waktu</h5>
                                            </div>
                                            <div class="row text-center">
                                                <div class="col-4">
                                                    <div class="p-2 border rounded">
                                                        <div class="fw-bold">85%</div>
                                                        <small class="text-muted">Lunas</small>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="p-2 border rounded">
                                                        <div class="fw-bold">10%</div>
                                                        <small class="text-muted">Tunggak</small>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="p-2 border rounded">
                                                        <div class="fw-bold">5%</div>
                                                        <small class="text-muted">Nonaktif</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card card-custom">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0 fw-bold">Aksi Cepat</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-primary text-start">
                                        <i class="bi bi-receipt me-2"></i> Generate Tagihan Bulanan
                                    </button>
                                    <button class="btn btn-outline-success text-start">
                                        <i class="bi bi-cash-stack me-2"></i> Input Pembayaran Manual
                                    </button>
                                    <button class="btn btn-outline-warning text-start">
                                        <i class="bi bi-envelope me-2"></i> Kirim Pengingat Tagihan
                                    </button>
                                    <button class="btn btn-outline-info text-start">
                                        <i class="bi bi-file-earmark-text me-2"></i> Export Laporan Bulanan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Tambah Pelanggan -->
    <div class="modal fade" id="tambahPelangganModal" tabindex="-1" aria-labelledby="tambahPelangganModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title" id="tambahPelangganModalLabel">Tambah Pelanggan Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" placeholder="Masukkan nama lengkap">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Masukkan email">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telepon" class="form-label">No. Telepon</label>
                                <input type="text" class="form-control" id="telepon" placeholder="Masukkan nomor telepon">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="paket" class="form-label">Paket Internet</label>
                                <select class="form-select" id="paket">
                                    <option selected>Pilih paket internet</option>
                                    <option value="basic">Basic 10 Mbps - Rp 200.000</option>
                                    <option value="family">Family 30 Mbps - Rp 350.000</option>
                                    <option value="business">Business 50 Mbps - Rp 550.000</option>
                                    <option value="premium">Premium 100 Mbps - Rp 850.000</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tanggal" class="form-label">Tanggal Bergabung</label>
                                <input type="date" class="form-control" id="tanggal">
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" id="aktif" checked>
                                    <label class="form-check-label" for="aktif">
                                        Aktifkan pelanggan
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary-custom">Simpan Pelanggan</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Inisialisasi tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Simulasi data untuk chart (dalam implementasi nyata bisa menggunakan Chart.js)
            console.log("Dashboard Billing Internet Admin siap digunakan!");
            
            // Menampilkan modal jika ada parameter di URL (untuk demo)
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('modal') === 'tambah') {
                const myModal = new bootstrap.Modal(document.getElementById('tambahPelangganModal'));
                myModal.show();
            }
        });
    </script>
</body>
</html>