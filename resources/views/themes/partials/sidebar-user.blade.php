
<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard-index') }}">
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
    <li class="nav-item">
        <a class="nav-link" href="{{ route('profile-index') }}">
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
    
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#navbar-referensi" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
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
                    <a class="dropdown-item" href="{{ route('referensi-index') }}">Semua Referensi</a>
                    <a class="dropdown-item" href="{{ route('referensi.agama-index') }}">Agama</a>
                    <a class="dropdown-item" href="{{ route('referensi.golongan-darah-index') }}">Golongan Darah</a>
                    <a class="dropdown-item" href="{{ route('referensi.jenis-kelamin-index') }}">Jenis Kelamin</a>
                    <a class="dropdown-item" href="{{ route('referensi.kewarganegaraan-index') }}">Kewarganegaraan</a>
                    <a class="dropdown-item" href="{{ route('referensi.semester-index') }}">Semester</a>
                    <a class="dropdown-item" href="{{ route('referensi.status-mahasiswa-index') }}">Status Mahasiswa</a>
                    <a class="dropdown-item" href="{{ route('referensi.jabatan-index') }}">Jabatan</a>
                    <a class="dropdown-item" href="{{ route('referensi.role-index') }}">Role</a>
                    <a class="dropdown-item" href="{{ route('referensi.alamat-index') }}">Alamat</a>
                    <a class="dropdown-item" href="{{ route('referensi.keluarga-index') }}">Keluarga</a>
                    <a class="dropdown-item" href="{{ route('referensi.pendidikan-index') }}">Pendidikan</a>
                </div>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('pengaturan-index') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                    <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                    <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                </svg>
            </span>
            <span class="nav-link-title">Pengaturan</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('auth.handle-logout') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                    <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                    <path d="M9 12h12l-3 -3" />
                    <path d="M18 15l3 -3" />
                </svg>
            </span>
            <span class="nav-link-title">Logout</span>
        </a>
    </li>
</ul>