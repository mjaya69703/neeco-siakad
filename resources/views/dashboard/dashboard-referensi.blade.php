@extends('themes.core-backpage')

@section('custom-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Enhanced Dashboard Styling */
        :root {
            --primary-color: #435ebe;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
            --purple-color: #7c3aed;
            --orange-color: #f56565;
            --teal-color: #38b2ac;
        }

        /* Dashboard Cards */
        .dashboard-card {
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border-radius: 16px;
            transition: all 0.3s ease;
            overflow: hidden;
            
        }

        .dashboard-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }

        .stat-card {
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--info-color));
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-icon {
            transform: rotate(5deg) scale(1.1);
        }

        .bg-light-primary { background: linear-gradient(135deg, rgba(67, 94, 190, 0.15), rgba(67, 94, 190, 0.05)); color: var(--primary-color); }
        .bg-light-success { background: linear-gradient(135deg, rgba(40, 167, 69, 0.15), rgba(40, 167, 69, 0.05)); color: var(--success-color); }
        .bg-light-warning { background: linear-gradient(135deg, rgba(255, 193, 7, 0.15), rgba(255, 193, 7, 0.05)); color: var(--warning-color); }
        .bg-light-info { background: linear-gradient(135deg, rgba(23, 162, 184, 0.15), rgba(23, 162, 184, 0.05)); color: var(--info-color); }
        .bg-light-danger { background: linear-gradient(135deg, rgba(220, 53, 69, 0.15), rgba(220, 53, 69, 0.05)); color: var(--danger-color); }
        .bg-light-purple { background: linear-gradient(135deg, rgba(124, 58, 237, 0.15), rgba(124, 58, 237, 0.05)); color: var(--purple-color); }
        .bg-light-orange { background: linear-gradient(135deg, rgba(245, 101, 101, 0.15), rgba(245, 101, 101, 0.05)); color: var(--orange-color); }
        .bg-light-teal { background: linear-gradient(135deg, rgba(56, 178, 172, 0.15), rgba(56, 178, 172, 0.05)); color: var(--teal-color); }

        /* Chart Containers */
        .chart-container {
            position: relative;
            height: 300px;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .chart-container.large {
            height: 400px;
        }

        .chart-container.small {
            height: 250px;
        }

        /* Progress bars */
        .distribution-bar {
            height: 10px;
            background: linear-gradient(90deg, #f8f9fa, #e9ecef);
            border-radius: 5px;
            overflow: hidden;
            margin: 0.75rem 0;
            position: relative;
        }

        .distribution-fill {
            height: 100%;
            border-radius: 5px;
            transition: width 0.8s ease;
            position: relative;
            overflow: hidden;
        }

        .distribution-fill::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        /* Activity Items */
        .activity-item {
            padding: 1rem;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            position: relative;
        }

        .activity-item:hover {
            background: rgba(67, 94, 190, 0.03);
            transform: translateX(5px);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-badge {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            margin-right: 1rem;
        }

        /* Reference Lists */
        .reference-grid .card {
            height: 100%;
            border: 1px solid rgba(0,0,0,0.08);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .reference-grid .card:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .reference-item {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.2s ease;
        }

        .reference-item:hover {
            background: rgba(0,0,0,0.02);
            padding-left: 2rem;
        }

        .reference-item:last-child {
            border-bottom: none;
        }

        /* Management Buttons */
        .management-btn {
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .management-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .management-btn:hover::before {
            left: 100%;
        }

        .management-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        /* Section Headers */
        .section-header {
            border-left: 4px solid var(--primary-color);
            padding-left: 1rem;
            margin-bottom: 1.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .stat-icon {
                width: 50px;
                height: 50px;
                font-size: 1.3rem;
            }
            
            .chart-container {
                height: 250px;
            }
        }
    </style>
@endsection

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    <i class="fas fa-database me-2"></i>Dashboard Data Referensi
                </h2>
                <div class="text-muted">
                    Monitoring dan statistik seluruh data referensi sistem SIAKAD
                </div>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('dashboard.dashboard-referensi') }}" class="btn btn-primary management-btn">
                        <i class="fas fa-cog me-1"></i>
                        Kelola Data Referensi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <!-- Overview Statistics -->
        <div class="section-header">
            <h3 class="h4 mb-0">
                <i class="fas fa-chart-bar me-2"></i>Ringkasan Statistik
            </h3>
            <div class="text-muted small">Grafik data referensi dalam sistem</div>
        </div>

        <!-- Primary Statistics Cards -->
        <div class="row row-deck row-cards mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card dashboard-card stat-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-light-primary me-3">
                            <i class="fas fa-pray"></i>
                        </div>
                        <div>
                            <div class="h2 m-0 fw-bold counter" data-target="{{ $stats['agama'] }}">0</div>
                            <div class="text-muted small">Jenis Agama</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card dashboard-card stat-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-light-danger me-3">
                            <i class="fas fa-tint"></i>
                        </div>
                        <div>
                            <div class="h2 m-0 fw-bold counter" data-target="{{ $stats['golongan_darah'] }}">0</div>
                            <div class="text-muted small">Golongan Darah</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card dashboard-card stat-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-light-success me-3">
                            <i class="fas fa-venus-mars"></i>
                        </div>
                        <div>
                            <div class="h2 m-0 fw-bold counter" data-target="{{ $stats['jenis_kelamin'] }}">0</div>
                            <div class="text-muted small">Jenis Kelamin</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card dashboard-card stat-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-light-info me-3">
                            <i class="fas fa-flag"></i>
                        </div>
                        <div>
                            <div class="h2 m-0 fw-bold counter" data-target="{{ $stats['kewarganegaraan'] }}">0</div>
                            <div class="text-muted small">Kewarganegaraan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary Statistics Cards -->
        <div class="row row-deck row-cards mb-5">
            <div class="col-sm-6 col-lg-3">
                <div class="card dashboard-card stat-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-light-warning me-3">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div>
                            <div class="h2 m-0 fw-bold counter" data-target="{{ $stats['jabatan'] }}">0</div>
                            <div class="text-muted small">Jabatan</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card dashboard-card stat-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-light-purple me-3">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div>
                            <div class="h2 m-0 fw-bold counter" data-target="{{ $stats['semester'] }}">0</div>
                            <div class="text-muted small">Semester</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card dashboard-card stat-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-light-orange me-3">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div>
                            <div class="h2 m-0 fw-bold counter" data-target="{{ $stats['status_mahasiswa'] }}">0</div>
                            <div class="text-muted small">Status Mahasiswa</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card dashboard-card stat-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-light-teal me-3">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <div>
                            <div class="h2 m-0 fw-bold counter" data-target="{{ $stats['role'] }}">0</div>
                            <div class="text-muted small">Role Pengguna</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advanced Statistics -->
        <div class="row mb-5">
            <div class="col-lg-8">
                <div class="card dashboard-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-line me-2"></i>Statistik Lengkap Data Referensi
                        </h3>
                        <div class="text-muted small">Ringkasan data referensi berdasarkan kategori</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Polymorphic Data Statistics -->
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <div class="stat-icon bg-light-info mx-auto mb-2">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div class="h3 mb-1 counter" data-target="{{ $stats['alamat'] }}">0</div>
                                        <div class="text-muted small">Data Alamat</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <div class="stat-icon bg-light-success mx-auto mb-2">
                                            <i class="fas fa-graduation-cap"></i>
                                        </div>
                                        <div class="h3 mb-1 counter" data-target="{{ $stats['pendidikan'] }}">0</div>
                                        <div class="text-muted small">Riwayat Pendidikan</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <div class="stat-icon bg-light-warning mx-auto mb-2">
                                            <i class="fas fa-home"></i>
                                        </div>
                                        <div class="h3 mb-1 counter" data-target="{{ $stats['keluarga'] }}">0</div>
                                        <div class="text-muted small">Data Keluarga</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <div class="h1 mb-1 counter" data-target="{{ $stats['total_users'] }}">0</div>
                            <div class="text-muted">Total Pengguna Aktif</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- User Distribution Charts -->
                <div class="card dashboard-card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie me-2"></i>Distribusi Pengguna
                        </h3>
                        <div class="text-muted small">Berdasarkan data referensi</div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container small">
                            <canvas id="genderChart"></canvas>
                        </div>
                    </div>
                </div>
                
                <div class="card dashboard-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-doughnut me-2"></i>Distribusi Agama
                        </h3>
                        <div class="text-muted small">Persentase berdasarkan agama</div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container small">
                            <canvas id="agamaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row mb-5">
            <div class="col-lg-6">
                <div class="card dashboard-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-bar me-2"></i>Statistik Pengguna - Jenis Kelamin
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="genderBarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card dashboard-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-bar me-2"></i>Statistik Pengguna - Agama
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="agamaBarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Reference Data -->
        <div class="section-header">
            <h3 class="h4 mb-0">
                <i class="fas fa-list me-2"></i>Detail Data Referensi
            </h3>
            <div class="text-muted small">Daftar lengkap data referensi yang tersedia</div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <!-- Agama -->
                    <div class="col-md-6 mb-4">
                        <div class="card reference-grid dashboard-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="card-title">
                                    <i class="fas fa-pray me-2 text-primary"></i>Data Agama
                                </h3>
                                <span class="badge bg-primary badge-count">{{ $sample_data['agamas']->count() }}</span>
                            </div>
                            <div class="card-body p-0">
                                @forelse($sample_data['agamas'] as $agama)
                                    <div class="reference-item">
                                        <span class="fw-medium">{{ $agama->name }}</span>
                                        <span class="badge bg-light text-dark">
                                            {{ $agama->users->count() }} pengguna
                                        </span>
                                    </div>
                                @empty
                                    <div class="p-3 text-center text-muted">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Tidak ada data agama
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Golongan Darah -->
                    <div class="col-md-6 mb-4">
                        <div class="card reference-grid dashboard-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="card-title">
                                    <i class="fas fa-tint me-2 text-danger"></i>Golongan Darah
                                </h3>
                                <span class="badge bg-danger badge-count">{{ $sample_data['golongan_darahs']->count() }}</span>
                            </div>
                            <div class="card-body p-0">
                                @forelse($sample_data['golongan_darahs'] as $gd)
                                    <div class="reference-item">
                                        <span class="fw-medium">{{ $gd->name }}</span>
                                        <span class="badge bg-light text-dark">
                                            {{ $gd->users->count() }} pengguna
                                        </span>
                                    </div>
                                @empty
                                    <div class="p-3 text-center text-muted">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Tidak ada data golongan darah
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="col-md-6 mb-4">
                        <div class="card reference-grid dashboard-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="card-title">
                                    <i class="fas fa-venus-mars me-2 text-success"></i>Jenis Kelamin
                                </h3>
                                <span class="badge bg-success badge-count">{{ $sample_data['jenis_kelamins']->count() }}</span>
                            </div>
                            <div class="card-body p-0">
                                @forelse($sample_data['jenis_kelamins'] as $jk)
                                    <div class="reference-item">
                                        <span class="fw-medium">{{ $jk->name }}</span>
                                        <span class="badge bg-light text-dark">
                                            {{ $jk->users->count() }} pengguna
                                        </span>
                                    </div>
                                @empty
                                    <div class="p-3 text-center text-muted">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Tidak ada data jenis kelamin
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Kewarganegaraan -->
                    <div class="col-md-6 mb-4">
                        <div class="card reference-grid dashboard-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="card-title">
                                    <i class="fas fa-flag me-2 text-info"></i>Kewarganegaraan
                                </h3>
                                <span class="badge bg-info badge-count">{{ $sample_data['kewarganegaraans']->count() }}</span>
                            </div>
                            <div class="card-body p-0">
                                @forelse($sample_data['kewarganegaraans'] as $kw)
                                    <div class="reference-item">
                                        <span class="fw-medium">{{ $kw->name }}</span>
                                        <span class="badge bg-light text-dark">
                                            {{ $kw->users->count() }} pengguna
                                        </span>
                                    </div>
                                @empty
                                    <div class="p-3 text-center text-muted">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Tidak ada data kewarganegaraan
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar - Recent Activities & Distribution -->
            <div class="col-lg-4">
                <!-- User Distribution Details -->
                <div class="card dashboard-card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-users me-2"></i>Distribusi Pengguna
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- Gender Distribution -->
                        <div class="mb-4">
                            <h5 class="h6 mb-3">
                                <i class="fas fa-venus-mars me-2 text-success"></i>
                                Berdasarkan Jenis Kelamin
                            </h5>
                            @foreach($user_distribution['by_jenis_kelamin'] as $dist)
                                @php
                                    $percentage = $stats['total_users'] > 0 ? ($dist->total / $stats['total_users']) * 100 : 0;
                                @endphp
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-medium">{{ $dist->jenisKelamin->name ?? 'Tidak Diketahui' }}</span>
                                        <span class="small text-muted">{{ $dist->total }} ({{ number_format($percentage, 1) }}%)</span>
                                    </div>
                                    <div class="distribution-bar">
                                        <div class="distribution-fill bg-success" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Religion Distribution -->
                        <div>
                            <h5 class="h6 mb-3">
                                <i class="fas fa-pray me-2 text-primary"></i>
                                Berdasarkan Agama
                            </h5>
                            @foreach($user_distribution['by_agama'] as $dist)
                                @php
                                    $percentage = $stats['total_users'] > 0 ? ($dist->total / $stats['total_users']) * 100 : 0;
                                @endphp
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-medium">{{ $dist->agama->name ?? 'Tidak Diketahui' }}</span>
                                        <span class="small text-muted">{{ $dist->total }} ({{ number_format($percentage, 1) }}%)</span>
                                    </div>
                                    <div class="distribution-bar">
                                        <div class="distribution-fill bg-primary" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="card dashboard-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-clock me-2"></i>Aktivitas Terbaru
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        @if($recent_alamats->count() > 0)
                            <div class="activity-item">
                                <div class="d-flex align-items-center">
                                    <div class="activity-badge bg-info text-white">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <strong class="d-block">Alamat Terbaru</strong>
                                        <div class="text-muted small">
                                            {{ Str::limit($recent_alamats->first()->alamat_lengkap ?? 'Tidak tersedia', 50) }}
                                        </div>
                                    </div>
                                    <span class="badge bg-info">{{ $recent_alamats->count() }}</span>
                                </div>
                            </div>
                        @endif

                        @if($recent_pendidikans->count() > 0)
                            <div class="activity-item">
                                <div class="d-flex align-items-center">
                                    <div class="activity-badge bg-success text-white">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <strong class="d-block">Pendidikan Terbaru</strong>
                                        <div class="text-muted small">
                                            {{ Str::limit($recent_pendidikans->first()->nama_institusi ?? 'Tidak tersedia', 50) }}
                                        </div>
                                    </div>
                                    <span class="badge bg-success">{{ $recent_pendidikans->count() }}</span>
                                </div>
                            </div>
                        @endif

                        @if($recent_keluargas->count() > 0)
                            <div class="activity-item">
                                <div class="d-flex align-items-center">
                                    <div class="activity-badge bg-warning text-white">
                                        <i class="fas fa-home"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <strong class="d-block">Keluarga Terbaru</strong>
                                        <div class="text-muted small">
                                            {{ Str::limit($recent_keluargas->first()->nama ?? 'Tidak tersedia', 30) }}
                                            <small>({{ $recent_keluargas->first()->hubungan ?? 'Tidak tersedia' }})</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-warning">{{ $recent_keluargas->count() }}</span>
                                </div>
                            </div>
                        @endif

                        @if($recent_alamats->count() == 0 && $recent_pendidikans->count() == 0 && $recent_keluargas->count() == 0)
                            <div class="p-4 text-center text-muted">
                                <i class="fas fa-info-circle fa-2x mb-2"></i>
                                <div>Belum ada aktivitas terbaru</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Management Actions -->
        <div class="section-header mt-5">
            <h3 class="h4 mb-0">
                <i class="fas fa-cogs me-2"></i>Kelola Data Referensi
            </h3>
            <div class="text-muted small">Akses cepat untuk mengelola data referensi</div>
        </div>

        <div class="card dashboard-card">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4 col-lg-2">
                        <a href="{{ url('/referensi/agama') }}" class="management-btn btn btn-primary w-100">
                            <i class="fas fa-pray me-2"></i>
                            <div class="small">Kelola Agama</div>
                        </a>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <a href="{{ url('/referensi/golongan-darah') }}" class="management-btn btn btn-danger w-100">
                            <i class="fas fa-tint me-2"></i>
                            <div class="small">Kelola Golongan Darah</div>
                        </a>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <a href="{{ url('/referensi/jenis-kelamin') }}" class="management-btn btn btn-success w-100">
                            <i class="fas fa-venus-mars me-2"></i>
                            <div class="small">Kelola Jenis Kelamin</div>
                        </a>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <a href="{{ url('/referensi/kewarganegaraan') }}" class="management-btn btn btn-info w-100">
                            <i class="fas fa-flag me-2"></i>
                            <div class="small">Kelola Kewarganegaraan</div>
                        </a>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <a href="{{ url('/referensi/jabatan') }}" class="management-btn btn btn-warning w-100">
                            <i class="fas fa-briefcase me-2"></i>
                            <div class="small">Kelola Jabatan</div>
                        </a>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <a href="{{ url('/referensi/semester') }}" class="management-btn btn btn-purple w-100">
                            <i class="fas fa-calendar-alt me-2"></i>
                            <div class="small">Kelola Semester</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@php
    // Prepare data for charts
    $genderLabels = [];
    $genderValues = [];
    foreach ($user_distribution['by_jenis_kelamin'] as $dist) {
        $genderLabels[] = $dist->jenisKelamin->name ?? 'Tidak Diketahui';
        $genderValues[] = $dist->total;
    }
    
    $agamaLabels = [];
    $agamaValues = [];
    foreach ($user_distribution['by_agama'] as $dist) {
        $agamaLabels[] = $dist->agama->name ?? 'Tidak Diketahui';
        $agamaValues[] = $dist->total;
    }
@endphp
<script>
    // Enhanced Chart.js configurations
    const chartColors = {
        primary: '#435ebe',
        success: '#28a745',
        warning: '#ffc107',
        danger: '#dc3545',
        info: '#17a2b8',
        purple: '#7c3aed',
        orange: '#f56565',
        teal: '#38b2ac'
    };

    const bgColors = [
        'rgba(67, 94, 190, 0.8)',
        'rgba(40, 167, 69, 0.8)',
        'rgba(255, 193, 7, 0.8)',
        'rgba(23, 162, 184, 0.8)',
        'rgba(220, 53, 69, 0.8)',
        'rgba(124, 58, 237, 0.8)',
        'rgba(245, 101, 101, 0.8)',
        'rgba(56, 178, 172, 0.8)',
        'rgba(108, 117, 125, 0.8)'
    ];

    const bdColors = [
        'rgba(67, 94, 190, 1)',
        'rgba(40, 167, 69, 1)',
        'rgba(255, 193, 7, 1)',
        'rgba(23, 162, 184, 1)',
        'rgba(220, 53, 69, 1)',
        'rgba(124, 58, 237, 1)',
        'rgba(245, 101, 101, 1)',
        'rgba(56, 178, 172, 1)',
        'rgba(108, 117, 125, 1)'
    ];

    const pick = (arr, len) => Array.from({ length: len }, (_, i) => arr[i % arr.length]);

    // Initialize all charts
    document.addEventListener('DOMContentLoaded', function() {
        // Animate counters
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const target = parseInt(counter.dataset.target);
            if (isNaN(target)) return;
            
            counter.innerText = '0';
            let current = 0;
            const increment = target / 60;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    counter.innerText = target.toLocaleString('id-ID');
                    clearInterval(timer);
                } else {
                    counter.innerText = Math.ceil(current).toLocaleString('id-ID');
                }
            }, 25);
        });

        // Gender Pie Chart
        const genderLabels = @json($genderLabels);
        const genderValues = @json($genderValues);
        
        if (genderLabels.length && genderValues.some(v => v > 0)) {
            const genderCtx = document.getElementById('genderChart');
            if (genderCtx) {
                new Chart(genderCtx.getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: genderLabels,
                        datasets: [{
                            data: genderValues,
                            backgroundColor: pick(bgColors, genderLabels.length),
                            borderColor: pick(bdColors, genderLabels.length),
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { 
                                position: 'bottom',
                                labels: { padding: 20, usePointStyle: true }
                            },
                            title: { 
                                display: true, 
                                text: 'Distribusi Jenis Kelamin',
                                font: { size: 14, weight: 'bold' }
                            }
                        }
                    }
                });
            }
        }

        // Religion Doughnut Chart
        const agamaLabels = @json($agamaLabels);
        const agamaValues = @json($agamaValues);
        
        if (agamaLabels.length && agamaValues.some(v => v > 0)) {
            const agamaCtx = document.getElementById('agamaChart');
            if (agamaCtx) {
                new Chart(agamaCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: agamaLabels,
                        datasets: [{
                            data: agamaValues,
                            backgroundColor: pick(bgColors, agamaLabels.length),
                            borderColor: pick(bdColors, agamaLabels.length),
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { 
                                position: 'bottom',
                                labels: { padding: 20, usePointStyle: true }
                            },
                            title: { 
                                display: true, 
                                text: 'Distribusi Agama',
                                font: { size: 14, weight: 'bold' }
                            }
                        }
                    }
                });
            }
        }

        // Gender Bar Chart
        if (genderLabels.length && genderValues.some(v => v > 0)) {
            const genderBarCtx = document.getElementById('genderBarChart');
            if (genderBarCtx) {
                new Chart(genderBarCtx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: genderLabels,
                        datasets: [{
                            label: 'Jumlah Pengguna',
                            data: genderValues,
                            backgroundColor: 'rgba(40, 167, 69, 0.8)',
                            borderColor: 'rgba(40, 167, 69, 1)',
                            borderWidth: 2,
                            borderRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            title: { 
                                display: true, 
                                text: 'Statistik Pengguna Berdasarkan Jenis Kelamin',
                                font: { size: 14, weight: 'bold' }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            }
        }

        // Religion Bar Chart
        if (agamaLabels.length && agamaValues.some(v => v > 0)) {
            const agamaBarCtx = document.getElementById('agamaBarChart');
            if (agamaBarCtx) {
                new Chart(agamaBarCtx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: agamaLabels,
                        datasets: [{
                            label: 'Jumlah Pengguna',
                            data: agamaValues,
                            backgroundColor: 'rgba(67, 94, 190, 0.8)',
                            borderColor: 'rgba(67, 94, 190, 1)',
                            borderWidth: 2,
                            borderRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            title: { 
                                display: true, 
                                text: 'Statistik Pengguna Berdasarkan Agama',
                                font: { size: 14, weight: 'bold' }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            }
        }
    });
</script>
@endsection