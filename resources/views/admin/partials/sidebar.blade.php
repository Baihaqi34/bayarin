    <div class="col-lg-2 col-md-3 px-0 sidebar">
        <div class="d-flex flex-column h-100">
            <!-- Logo -->
            <div class="text-center pt-3 mb-4">
                <h3 class="text-white fw-bold"><i class="bi bi-wifi"></i> Bayarin</h3>
                <p class="text-white-50 small">Admin Dashboard</p>
            </div>
 
            <!-- Menu Navigasi --> 
            <ul class="nav flex-column px-3 flex-grow-1">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/dashboard*') ? 'active' : '' }}" href="{{ url('admin/dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/pelanggan*') ? 'active' : '' }}" href="{{ url('admin/pelanggan') }}">
                        <i class="bi bi-people"></i> Pelanggan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/tagihan*') ? 'active' : '' }}" href="{{ url('admin/tagihan') }}">
                        <i class="bi bi-credit-card"></i> Tagihan
                    </a>
                </li>
            </ul>

            <!-- Info Admin -->
            <div class="px-3 mb-4">
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
