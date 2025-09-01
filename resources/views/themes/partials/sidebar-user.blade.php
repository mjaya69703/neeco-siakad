
-------------------------------------------------------------------------<ul class="navbar-nav">
    <li class="nav-item {{ request()->routeIs('dashboard-index') ? 'active' : '' }}">
        <a class="nav-link {{ request()->routeIs('dashboard-index') ? 'active' : '' }}" href="{{ route('dashboard-index') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                    <rect x="3" y="3" width="7" height="9" />
                    <rect x="14" y="3" width="7" height="5" />
                    <rect x="14" y="12" width="7" height="9" />
                    <rect x="3" y="16" width="7" height="5" />
                </svg>
            </span>
            <span class="nav-link-title">Dashboard</span>
        </a>
    </li>
    
    <li class="nav-item dropdown {{ request()->routeIs('infra.*') ? 'active' : '' }}">
        <a class="nav-link dropdown-toggle {{ request()->routeIs('infra.*') ? 'active' : '' }}" href="#navbar-master-infra" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
            </span>
            <span class="nav-link-title">Master Infra</span>
        </a>
        <div class="dropdown-menu">
            <div class="dropdown-menu-columns">
                <div class="dropdown-menu-column">
                    <a class="dropdown-item {{ request()->routeIs('infra.gedung-*') ? 'active' : '' }}" href="{{ route('infra.gedung-index') }}">Gedung</a>
                    <a class="dropdown-item {{ request()->routeIs('infra.ruangan-*') ? 'active' : '' }}" href="{{ route('infra.ruangan-index') }}">Ruangan</a>
                </div>
            </div>
        </div>
    </li>
    
    <li class="nav-item dropdown {{ request()->routeIs('inventaris.*') ? 'active' : '' }}">
        <a class="nav-link dropdown-toggle {{ request()->routeIs('inventaris.*') ? 'active' : '' }}" href="#navbar-master-inventaris" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                    <path d="M16 16v2a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h2m5.66 0H14a2 2 0 0 1 2 2v2M15 2H9a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zm0 10H9a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1z" />
                </svg>
            </span>
            <span class="nav-link-title">Master Inventaris</span>
        </a>
        <div class="dropdown-menu">
            <div class="dropdown-menu-columns">
                <div class="dropdown-menu-column">
                    <a class="dropdown-item {{ request()->routeIs('inventaris.kategori-barang-*') ? 'active' : '' }}" href="{{ route('inventaris.kategori-barang-index') }}">Kategori Barang</a>
                    <a class="dropdown-item {{ request()->routeIs('inventaris.barang-*') && !request()->routeIs('inventaris.barang-inventaris-*') ? 'active' : '' }}" href="{{ route('inventaris.barang-index') }}">Barang</a>
                    <a class="dropdown-item {{ request()->routeIs('inventaris.barang-inventaris-*') ? 'active' : '' }}" href="{{ route('inventaris.barang-inventaris-index') }}">Barang Inventaris</a>
                </div>
            </div>
        </div>
    </li>
    
    <li class="nav-item dropdown {{ request()->routeIs('transaksi-barang.*') ? 'active' : '' }}">
        <a class="nav-link dropdown-toggle {{ request()->routeIs('transaksi-barang.*') ? 'active' : '' }}" href="#navbar-transaksi-barang" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                    <path d="M7 10h3V5L7 7v3zm7-5v5h3V7l-3-2z" />
                    <path d="M3 3h18v18H3V3zm0 18v-4h18v4H3z" />
                    <path d="M3 11h18" />
                </svg>
            </span>
            <span class="nav-link-title">Transaksi Barang</span>
        </a>
        <div class="dropdown-menu">
            <div class="dropdown-menu-columns">
                <div class="dropdown-menu-column">
                    <a class="dropdown-item {{ request()->routeIs('transaksi-barang.peminjaman-*') ? 'active' : '' }}" href="{{ route('transaksi-barang.peminjaman-index') }}">Peminjaman Barang</a>
                    <a class="dropdown-item {{ request()->routeIs('transaksi-barang.pengecekan-*') ? 'active' : '' }}" href="{{ route('transaksi-barang.pengecekan-index') }}">Pengecekan Barang</a>
                    <a class="dropdown-item {{ request()->routeIs('transaksi-barang.pengajuan-*') ? 'active' : '' }}" href="{{ route('transaksi-barang.pengajuan-index') }}">Pengajuan Perbaikan</a>
                    <a class="dropdown-item {{ request()->routeIs('transaksi-barang.riwayat-*') ? 'active' : '' }}" href="{{ route('transaksi-barang.riwayat-index') }}">Riwayat Perbaikan</a>
                </div>
            </div>
        </div>
    </li>
    <li class="nav-item {{ request()->routeIs('profile-index') || request()->routeIs('profile-update') || request()->routeIs('profile.delete-pendidikan') || request()->routeIs('profile.delete-keluarga') ? 'active' : '' }}">
        <a class="nav-link {{ request()->routeIs('profile-index') || request()->routeIs('profile-update') || request()->routeIs('profile.delete-pendidikan') || request()->routeIs('profile.delete-keluarga') ? 'active' : '' }}" href="{{ route('profile-index') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                    <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                    <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                </svg>
            </span>
            <span class="nav-link-title">Profil</span>
        </a>
    </li>
    
    <li class="nav-item dropdown {{ request()->routeIs('referensi-index') || request()->routeIs('referensi.*') ? 'active' : '' }}">
        <a class="nav-link dropdown-toggle {{ request()->routeIs('referensi-index') || request()->routeIs('referensi.*') ? 'active' : '' }}" href="#navbar-referensi" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                    <path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
                    <path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
                    <path d="M3 6l0 13" />
                    <path d="M12 6l0 13" />
                    <path d="M21 6l0 13" />
                </svg>
            </span>
            <span class="nav-link-title">Referensi</span>
        </a>
        <div class="dropdown-menu">
            <div class="dropdown-menu-columns">
                <div class="dropdown-menu-column">
                    <a class="dropdown-item {{ request()->routeIs('referensi-index') ? 'active' : '' }}" href="{{ route('referensi-index') }}">Semua Referensi</a>
                    <a class="dropdown-item {{ request()->routeIs('referensi.agama-*') ? 'active' : '' }}" href="{{ route('referensi.agama-index') }}">Agama</a>
                    <a class="dropdown-item {{ request()->routeIs('referensi.golongan-darah-*') ? 'active' : '' }}" href="{{ route('referensi.golongan-darah-index') }}">Golongan Darah</a>
                    <a class="dropdown-item {{ request()->routeIs('referensi.jenis-kelamin-*') ? 'active' : '' }}" href="{{ route('referensi.jenis-kelamin-index') }}">Jenis Kelamin</a>
                    <a class="dropdown-item {{ request()->routeIs('referensi.kewarganegaraan-*') ? 'active' : '' }}" href="{{ route('referensi.kewarganegaraan-index') }}">Kewarganegaraan</a>
                    <a class="dropdown-item {{ request()->routeIs('referensi.semester-*') ? 'active' : '' }}" href="{{ route('referensi.semester-index') }}">Semester</a>
                    <a class="dropdown-item {{ request()->routeIs('referensi.status-mahasiswa-*') ? 'active' : '' }}" href="{{ route('referensi.status-mahasiswa-index') }}">Status Mahasiswa</a>
                    <a class="dropdown-item {{ request()->routeIs('referensi.jabatan-*') ? 'active' : '' }}" href="{{ route('referensi.jabatan-index') }}">Jabatan</a>
                    <a class="dropdown-item {{ request()->routeIs('referensi.role-*') ? 'active' : '' }}" href="{{ route('referensi.role-index') }}">Role</a>
                    <a class="dropdown-item {{ request()->routeIs('referensi.alamat-*') ? 'active' : '' }}" href="{{ route('referensi.alamat-index') }}">Alamat</a>
                    <a class="dropdown-item {{ request()->routeIs('referensi.keluarga-*') ? 'active' : '' }}" href="{{ route('referensi.keluarga-index') }}">Keluarga</a>
                    <a class="dropdown-item {{ request()->routeIs('referensi.pendidikan-*') ? 'active' : '' }}" href="{{ route('referensi.pendidikan-index') }}">Pendidikan</a>
                </div>
            </div>
        </div>
    </li>


    <li class="nav-item {{ request()->routeIs('pengaturan-index') || request()->routeIs('pengaturan-update') ? 'active' : '' }}">
        <a class="nav-link {{ request()->routeIs('pengaturan-index') || request()->routeIs('pengaturan-update') ? 'active' : '' }}" href="{{ route('pengaturan-index') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                    <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                    <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                </svg>
            </span>
            <span class="nav-link-title">Pengaturan</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('auth.handle-logout') ? 'active' : '' }}">
        <a class="nav-link {{ request()->routeIs('auth.handle-logout') ? 'active' : '' }}" href="{{ route('auth.handle-logout') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                    <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                    <path d="M7 12h14l-3 -3m0 6l3 -3" />
                </svg>
            </span>
            <span class="nav-link-title">Logout</span>
        </a>
    </li>
</ul>