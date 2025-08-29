@extends('themes.core-backpage')

@section('custom-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Dashboard Cards */
        .dashboard-card {
            border: none;
            box-shadow: 0 0 20px rgba(0,0,0,0.08);
            border-radius: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .bg-light-primary { background-color: rgba(67, 94, 190, 0.1); color: #435ebe; }
        .bg-light-success { background-color: rgba(40, 167, 69, 0.1); color: #28a745; }
        .bg-light-warning { background-color: rgba(255, 193, 7, 0.1); color: #ffc107; }
        .bg-light-info { background-color: rgba(23, 162, 184, 0.1); color: #17a2b8; }
        .bg-light-danger { background-color: rgba(220, 53, 69, 0.1); color: #dc3545; }
        .bg-light-purple { background-color: rgba(124, 58, 237, 0.1); color: #7c3aed; }
        .bg-light-orange { background-color: rgba(245, 101, 101, 0.1); color: #f56565; }
        .bg-light-teal { background-color: rgba(56, 178, 172, 0.1); color: #38b2ac; }

        .chart-container {
            position: relative;
            height: 300px;
        }

        .activity-item {
            padding: 0.75rem;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            transition: background-color 0.2s ease;
        }

        .activity-item:hover {
            background-color: rgba(0,0,0,0.02);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .reference-grid .card {
            height: 100%;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .reference-item {
            padding: 1rem;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .reference-item:last-child {
            border-bottom: none;
        }

        .badge-count {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }

        .management-btn {
            border-radius: 8px;
            padding: 0.5rem 1rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .management-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        /* Progress bars for distribution */
        .distribution-bar {
            height: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
            margin: 0.5rem 0;
        }

        .distribution-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.3s ease;
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
                    <a href="{{ route('referensi-index') }}" class="btn btn-primary">
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
        <!-- Statistics Overview -->
        <div class="row row-deck row-cards mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card dashboard-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-light-primary me-3">
                            <i class="fas fa-pray"></i>
                        </div>
                        <div>
                            <div class="h3 m-0">{{ $stats['agama'] }}</div>
                            <div class="text-muted">Agama</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card dashboard-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-light-danger me-3">
                            <i class="fas fa-tint"></i>
                        </div>
                        <div>
                            <div class="h3 m-0">{{ $stats['golongan_darah'] }}</div>
                            <div class="text-muted">Golongan Darah</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card dashboard-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-light-success me-3">
                            <i class="fas fa-venus-mars"></i>
                        </div>
                        <div>
                            <div class="h3 m-0">{{ $stats['jenis_kelamin'] }}</div>
                            <div class="text-muted">Jenis Kelamin</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card dashboard-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-light-info me-3">
                            <i class="fas fa-flag"></i>
                        </div>
                        <div>
                            <div class="h3 m-0">{{ $stats['kewarganegaraan'] }}</div>
                            <div class="text-muted">Kewarganegaraan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary Statistics -->
        <div class="row row-deck row-cards mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card dashboard-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-light-warning me-3">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div>
                            <div class="h3 m-0">{{ $stats['jabatan'] }}</div>
                            <div class="text-muted">Jabatan</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card dashboard-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-light-purple me-3">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div>
                            <div class="h3 m-0">{{ $stats['semester'] }}</div>
                            <div class="text-muted">Semester</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card dashboard-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-light-orange me-3">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div>
                            <div class="h3 m-0">{{ $stats['status_mahasiswa'] }}</div>
                            <div class="text-muted">Status Mahasiswa</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card dashboard-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-light-teal me-3">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <div>
                            <div class="h3 m-0">{{ $stats['role'] }}</div>
                            <div class="text-muted">Role</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Polymorphic Data Statistics -->
        <div class="row row-deck row-cards mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card dashboard-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-light-info me-3">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <div class="h3 m-0">{{ $stats['alamat'] }}</div>
                            <div class="text-muted">Data Alamat</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card dashboard-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-light-success me-3">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div>
                            <div class="h3 m-0">{{ $stats['pendidikan'] }}</div>
                            <div class="text-muted">Riwayat Pendidikan</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card dashboard-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-light-warning me-3">
                            <i class="fas fa-home"></i>
                        </div>
                        <div>
                            <div class="h3 m-0">{{ $stats['keluarga'] }}</div>
                            <div class="text-muted">Data Keluarga</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card dashboard-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-light-primary me-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <div class="h3 m-0">{{ $stats['total_users'] }}</div>
                            <div class="text-muted">Total Pengguna</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Reference Data Lists -->
            <div class="col-lg-8">
                <div class="row">
                    <!-- Agama -->
                    <div class="col-md-6 mb-4">
                        <div class="card reference-grid">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="card-title">
                                    <i class="fas fa-pray me-2"></i>Data Agama
                                </h3>
                                <span class="badge bg-primary badge-count">{{ $sample_data['agamas']->count() }}</span>
                            </div>
                            <div class="card-body p-0">
                                @forelse($sample_data['agamas'] as $agama)
                                    <div class="reference-item">
                                        <span>{{ $agama->name }}</span>
                                        <span class="badge bg-light text-dark">
                                            {{ $agama->users->count() }} pengguna
                                        </span>
                                    </div>
                                @empty
                                    <div class="p-3 text-center text-muted">
                                        Tidak ada data agama
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Golongan Darah -->
                    <div class="col-md-6 mb-4">
                        <div class="card reference-grid">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="card-title">
                                    <i class="fas fa-tint me-2"></i>Golongan Darah
                                </h3>
                                <span class="badge bg-danger badge-count">{{ $sample_data['golongan_darahs']->count() }}</span>
                            </div>
                            <div class="card-body p-0">
                                @forelse($sample_data['golongan_darahs'] as $gd)
                                    <div class="reference-item">
                                        <span>{{ $gd->name }}</span>
                                        <span class="badge bg-light text-dark">
                                            {{ $gd->users->count() }} pengguna
                                        </span>
                                    </div>
                                @empty
                                    <div class="p-3 text-center text-muted">
                                        Tidak ada data golongan darah
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="col-md-6 mb-4">
                        <div class="card reference-grid">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="card-title">
                                    <i class="fas fa-venus-mars me-2"></i>Jenis Kelamin
                                </h3>
                                <span class="badge bg-success badge-count">{{ $sample_data['jenis_kelamins']->count() }}</span>
                            </div>
                            <div class="card-body p-0">
                                @forelse($sample_data['jenis_kelamins'] as $jk)
                                    <div class="reference-item">
                                        <span>{{ $jk->name }}</span>
                                        <span class="badge bg-light text-dark">
                                            {{ $jk->users->count() }} pengguna
                                        </span>
                                    </div>
                                @empty
                                    <div class="p-3 text-center text-muted">
                                        Tidak ada data jenis kelamin
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Kewarganegaraan -->
                    <div class="col-md-6 mb-4">
                        <div class="card reference-grid">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="card-title">
                                    <i class="fas fa-flag me-2"></i>Kewarganegaraan
                                </h3>
                                <span class="badge bg-info badge-count">{{ $sample_data['kewarganegaraans']->count() }}</span>
                            </div>
                            <div class="card-body p-0">
                                @forelse($sample_data['kewarganegaraans'] as $kw)
                                    <div class="reference-item">
                                        <span>{{ $kw->name }}</span>
                                        <span class="badge bg-light text-dark">
                                            {{ $kw->users->count() }} pengguna
                                        </span>
                                    </div>
                                @empty
                                    <div class="p-3 text-center text-muted">
                                        Tidak ada data kewarganegaraan
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Management Actions -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-cogs me-2"></i>Kelola Data Referensi
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <a href="{{ url('/referensi/agama') }}" class="management-btn btn btn-primary w-100">
                                    <i class="fas fa-pray me-2"></i>Kelola Agama
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ url('/referensi/golongan-darah') }}" class="management-btn btn btn-danger w-100">
                                    <i class="fas fa-tint me-2"></i>Kelola Golongan Darah
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ url('/referensi/jenis-kelamin') }}" class="management-btn btn btn-success w-100">
                                    <i class="fas fa-venus-mars me-2"></i>Kelola Jenis Kelamin
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ url('/referensi/kewarganegaraan') }}" class="management-btn btn btn-info w-100">
                                    <i class="fas fa-flag me-2"></i>Kelola Kewarganegaraan
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ url('/referensi/jabatan') }}" class="management-btn btn btn-warning w-100">
                                    <i class="fas fa-briefcase me-2"></i>Kelola Jabatan
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ url('/referensi/semester') }}" class="management-btn btn btn-purple w-100">
                                    <i class="fas fa-calendar-alt me-2"></i>Kelola Semester
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Distribution & Activity -->
            <div class="col-lg-4">
                <!-- User Distribution -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie me-2"></i>Distribusi Pengguna
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- By Gender -->
                        <div class="mb-3">
                            <h4 class="h6">Berdasarkan Jenis Kelamin</h4>
                            @foreach($user_distribution['by_jenis_kelamin'] as $dist)
                                @php
                                    $percentage = $stats['total_users'] > 0 ? ($dist->total / $stats['total_users']) * 100 : 0;
                                @endphp
                                <div class="mb-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="small">{{ $dist->jenisKelamin->name ?? 'Tidak Diketahui' }}</span>
                                        <span class="small">{{ $dist->total }} ({{ number_format($percentage, 1) }}%)</span>
                                    </div>
                                    <div class="distribution-bar">
                                        <div class="distribution-fill bg-success" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- By Religion -->
                        <div class="mb-3">
                            <h4 class="h6">Berdasarkan Agama</h4>
                            @foreach($user_distribution['by_agama'] as $dist)
                                @php
                                    $percentage = $stats['total_users'] > 0 ? ($dist->total / $stats['total_users']) * 100 : 0;
                                @endphp
                                <div class="mb-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="small">{{ $dist->agama->name ?? 'Tidak Diketahui' }}</span>
                                        <span class="small">{{ $dist->total }} ({{ number_format($percentage, 1) }}%)</span>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-clock me-2"></i>Aktivitas Terbaru
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        @if($recent_alamats->count() > 0)
                            <div class="activity-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Alamat Terbaru</strong>
                                        <div class="text-muted small">
                                            {{ $recent_alamats->first()->alamat_lengkap }}
                                        </div>
                                    </div>
                                    <span class="badge bg-info">{{ $recent_alamats->count() }}</span>
                                </div>
                            </div>
                        @endif

                        @if($recent_pendidikans->count() > 0)
                            <div class="activity-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Pendidikan Terbaru</strong>
                                        <div class="text-muted small">
                                            {{ $recent_pendidikans->first()->nama_institusi }}
                                        </div>
                                    </div>
                                    <span class="badge bg-success">{{ $recent_pendidikans->count() }}</span>
                                </div>
                            </div>
                        @endif

                        @if($recent_keluargas->count() > 0)
                            <div class="activity-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Keluarga Terbaru</strong>
                                        <div class="text-muted small">
                                            {{ $recent_keluargas->first()->nama }} ({{ $recent_keluargas->first()->hubungan }})
                                        </div>
                                    </div>
                                    <span class="badge bg-warning">{{ $recent_keluargas->count() }}</span>
                                </div>
                            </div>
                        @endif

                        @if($recent_alamats->count() == 0 && $recent_pendidikans->count() == 0 && $recent_keluargas->count() == 0)
                            <div class="p-3 text-center text-muted">
                                Belum ada aktivitas terbaru
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
<script>
    // Add any interactive features here
    document.addEventListener('DOMContentLoaded', function() {
        // Animate counters on page load
        const counters = document.querySelectorAll('.h3');
        counters.forEach(counter => {
            const target = parseInt(counter.innerText);
            counter.innerText = '0';
            
            let current = 0;
            const increment = target / 50;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    counter.innerText = target;
                    clearInterval(timer);
                } else {
                    counter.innerText = Math.ceil(current);
                }
            }, 20);
        });
    });
</script>
@endsection