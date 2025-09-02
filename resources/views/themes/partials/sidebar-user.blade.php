<ul class="navbar-nav">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle {{ request()->routeIs('dashboard.*') ? 'show' : '' }}" href="#navbar-referensi" data-bs-toggle="dropdown"
            data-bs-auto-close="outside" role="button" aria-expanded="{{ request()->routeIs('referensi*') ? 'true' : 'false' }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-1">
                    <path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
                    <path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
                    <path d="M3 6l0 13" />
                    <path d="M12 6l0 13" />
                    <path d="M21 6l0 13" />
                </svg>
            </span>
            <span class="nav-link-title">Dashboard</span>
        </a>
        <div class="dropdown-menu {{ request()->routeIs('dashboard.*') ? 'show' : '' }}">
            <div class="dropdown-menu-columns">
                <div class="dropdown-menu-column">
                    <a class="dropdown-item {{ request()->routeIs('dashboard.dashboard-infra') ? 'active' : '' }}" href="{{ route('dashboard.dashboard-infra') }}">Dashboard Infrastruktur</a>
                    <a class="dropdown-item {{ request()->routeIs('dashboard.dashboard-referensi') ? 'active' : '' }}" href="{{ route('dashboard.dashboard-referensi') }}">Dashboard Referensi</a>
                </div>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('profile-index') ? 'active' : '' }}" href="{{ route('profile-index') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-1">
                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                    <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                    <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                </svg>
            </span>
            <span class="nav-link-title">Profil</span>
        </a>
    </li>


    <li class="nav-item">
        <a class="nav-link" href="#">
            <span class="nav-link-title">Master Data</span>
        </a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle {{ request()->routeIs('referensi*') ? 'show' : '' }}" href="#navbar-referensi" data-bs-toggle="dropdown"
            data-bs-auto-close="outside" role="button" aria-expanded="{{ request()->routeIs('referensi*') ? 'true' : 'false' }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-1">
                    <path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
                    <path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
                    <path d="M3 6l0 13" />
                    <path d="M12 6l0 13" />
                    <path d="M21 6l0 13" />
                </svg>
            </span>
            <span class="nav-link-title">Data Referensi</span>
        </a>
        <div class="dropdown-menu {{ request()->routeIs('referensi*') ? 'show' : '' }}">
            <div class="dropdown-menu-columns">
                <div class="dropdown-menu-column">
                    <a class="dropdown-item {{ request()->routeIs('referensi.agama*') ? 'active' : '' }}" href="{{ route('referensi.agama-index') }}">Agama</a>
                    <a class="dropdown-item {{ request()->routeIs('referensi.golongan-darah*') ? 'active' : '' }}" href="{{ route('referensi.golongan-darah-index') }}">Golongan Darah</a>
                    <a class="dropdown-item {{ request()->routeIs('referensi.jenis-kelamin*') ? 'active' : '' }}" href="{{ route('referensi.jenis-kelamin-index') }}">Jenis Kelamin</a>
                    <a class="dropdown-item {{ request()->routeIs('referensi.kewarganegaraan*') ? 'active' : '' }}" href="{{ route('referensi.kewarganegaraan-index') }}">Kewarganegaraan</a>
                    <a class="dropdown-item {{ request()->routeIs('referensi.semester*') ? 'active' : '' }}" href="{{ route('referensi.semester-index') }}">Semester</a>
                    <a class="dropdown-item {{ request()->routeIs('referensi.status-mahasiswa*') ? 'active' : '' }}" href="{{ route('referensi.status-mahasiswa-index') }}">Status Mahasiswa</a>
                    <a class="dropdown-item {{ request()->routeIs('referensi.jabatan*') ? 'active' : '' }}" href="{{ route('referensi.jabatan-index') }}">Jabatan</a>
                    <a class="dropdown-item {{ request()->routeIs('referensi.role*') ? 'active' : '' }}" href="{{ route('referensi.role-index') }}">Role</a>
                    <a class="dropdown-item {{ request()->routeIs('referensi.alamat*') ? 'active' : '' }}" href="{{ route('referensi.alamat-index') }}">Alamat</a>
                    <a class="dropdown-item {{ request()->routeIs('referensi.keluarga*') ? 'active' : '' }}" href="{{ route('referensi.keluarga-index') }}">Keluarga</a>
                    <a class="dropdown-item {{ request()->routeIs('referensi.pendidikan*') ? 'active' : '' }}" href="{{ route('referensi.pendidikan-index') }}">Pendidikan</a>
                </div>
            </div>
        </div>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle {{ request()->routeIs('infra*', 'inventaris*', 'transaksi-barang*', 'perawatan*') ? 'show' : '' }}" href="#navbar-infra" data-bs-toggle="dropdown" data-bs-auto-close="outside"
            role="button" aria-expanded="{{ request()->routeIs('infra*', 'inventaris*', 'transaksi-barang*', 'perawatan*') ? 'true' : 'false' }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="icon icon-1">
                    <path d="M3 12h1l3 8l3 -16l3 16l3 -8h4" />
                    <path d="M4 4l1 1" />
                    <path d="M18 5l1 -1" />
                    <path d="M17 10l1 1" />
                    <path d="M13 10l1 1" />
                    <path d="M9 10l1 1" />
                    <path d="M5 10l1 1" />
                </svg>
            </span>
            <span class="nav-link-title">Master Infrastruktur</span>
        </a>
        <div class="dropdown-menu {{ request()->routeIs('infra*', 'inventaris*', 'transaksi-barang*', 'perawatan*') ? 'show' : '' }}">
            <div class="dropdown-menu-columns">
                <div class="dropdown-menu-column">
                    <a class="dropdown-item {{ request()->routeIs('infra.gedung*') ? 'active' : '' }}" href="{{ route('infra.gedung-index') }}">Data Gedung</a>
                    <a class="dropdown-item {{ request()->routeIs('infra.ruangan*') ? 'active' : '' }}" href="{{ route('infra.ruangan-index') }}">Data Ruangan</a>
                    <div class="dropend">
                        <a class="dropdown-item dropdown-toggle {{ request()->routeIs('inventaris*') ? 'show' : '' }}" href="#sidebar-inventaris"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button"
                            aria-expanded="{{ request()->routeIs('inventaris*') ? 'true' : 'false' }}">
                            Data Inventaris
                        </a>
                        <div class="dropdown-menu {{ request()->routeIs('inventaris*') ? 'show' : '' }}">
                            <a class="dropdown-item {{ request()->routeIs('inventaris.kategori-barang*') ? 'active' : '' }}" href="{{ route('inventaris.kategori-barang-index') }}">Kategori Barang</a>
                            <a class="dropdown-item {{ request()->routeIs('inventaris.barang*') ? 'active' : '' }}" href="{{ route('inventaris.barang-index') }}">Barang</a>
                            <a class="dropdown-item {{ request()->routeIs('inventaris.barang-inventaris*') ? 'active' : '' }}" href="{{ route('inventaris.barang-inventaris-index') }}">Barang Inventaris</a>
                        </div>
                    </div>
                    <div class="dropend">
                        <a class="dropdown-item dropdown-toggle {{ request()->routeIs('transaksi-barang*') ? 'show' : '' }}" href="#sidebar-transaksi-barang"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button"
                            aria-expanded="{{ request()->routeIs('transaksi-barang*') ? 'true' : 'false' }}">
                            Data Transaksi Barang
                        </a>
                        <div class="dropdown-menu {{ request()->routeIs('transaksi-barang*') ? 'show' : '' }}">
                            <a class="dropdown-item {{ request()->routeIs('transaksi-barang.peminjaman*') ? 'active' : '' }}" href="{{ route('transaksi-barang.peminjaman-index') }}">Peminjaman</a>
                            <a class="dropdown-item {{ request()->routeIs('transaksi-barang.pengecekan*') ? 'active' : '' }}" href="{{ route('transaksi-barang.pengecekan-index') }}">Pengecekan</a>
                            <a class="dropdown-item {{ request()->routeIs('transaksi-barang.pengajuan*') ? 'active' : '' }}" href="{{ route('transaksi-barang.pengajuan-index') }}">Pengajuan Perbaikan</a>
                            <a class="dropdown-item {{ request()->routeIs('transaksi-barang.riwayat*') ? 'active' : '' }}" href="{{ route('transaksi-barang.riwayat-index') }}">Riwayat Perbaikan</a>
                        </div>
                    </div>
                    <div class="dropend">
                        <a class="dropdown-item dropdown-toggle {{ request()->routeIs('perawatan*') ? 'show' : '' }}" href="#sidebar-perawatan"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button"
                            aria-expanded="{{ request()->routeIs('perawatan*') ? 'true' : 'false' }}">
                            Data Perawatan
                        </a>
                        <div class="dropdown-menu {{ request()->routeIs('perawatan*') ? 'show' : '' }}">
                            <a class="dropdown-item {{ request()->routeIs('perawatan.jadwal*') ? 'active' : '' }}" href="{{ route('perawatan.jadwal-index') }}">Jadwal Pemeliharaan</a>
                            <a class="dropdown-item {{ request()->routeIs('perawatan.histori*') ? 'active' : '' }}" href="{{ route('perawatan.histori-index') }}">Histori Pemeliharaan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>



    <li class="nav-item">
        <a class="nav-link" href="#">
            <span class="nav-link-title">Lainnya</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('pengaturan-index') ? 'active' : '' }}" href="{{ route('pengaturan-index') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="icon icon-1">
                    <path
                        d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                    <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                </svg>
            </span>
            <span class="nav-link-title">Pengaturan</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('auth.handle-logout') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="icon icon-1">
                    <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                    <path d="M9 12h12l-3 -3" />
                    <path d="M18 15l3 -3" />
                </svg>
            </span>
            <span class="nav-link-title">Logout</span>
        </a>
    </li>
</ul>