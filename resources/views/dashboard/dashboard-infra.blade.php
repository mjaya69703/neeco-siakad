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

        /* Card styling */
        .card {
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border-radius: 16px;
            transition: all 0.3s ease;
            overflow: hidden;
            margin-bottom: 1.25rem;
        }
        
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.12);
        }
        
        .card-header {
            background: none;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 1.25rem 1.5rem;
        }
        
        .card-body {
            padding: 1.5rem;
        }

        /* Section Headers */
        .section-header {
            border-left: 4px solid var(--primary-color);
            padding-left: 1rem;
            margin-bottom: 1.5rem;
        }

        /* Table styling */
        .recent-activity-table {
            font-size: 0.9rem;
        }
        .recent-activity-table th {
            font-weight: 600;
            color: #495057;
            border-bottom: 2px solid #dee2e6;
        }
        .recent-activity-table td {
            vertical-align: middle;
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
                    <i class="fas fa-building me-2"></i>Dashboard Infrastruktur & Inventaris
                </h2>
                <div class="text-muted">
                    Monitoring dan statistik infrastruktur, inventaris, dan transaksi sistem
                </div>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('dashboard-index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Kembali ke Dashboard
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
            <div class="text-muted small">Grafik infrastruktur dan inventaris dalam sistem</div>
        </div>

    <!-- Primary Statistics Cards -->
    <div class="row row-deck row-cards mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card dashboard-card stat-card">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-light-primary me-3">
                        <i class="fas fa-building"></i>
                    </div>
                    <div>
                        <div class="h2 m-0 fw-bold counter" data-target="{{ $stats['gedung'] ?? 0 }}">0</div>
                        <div class="text-muted small">Total Gedung</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card dashboard-card stat-card">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-light-success me-3">
                        <i class="fas fa-door-open"></i>
                    </div>
                    <div>
                        <div class="h2 m-0 fw-bold counter" data-target="{{ $stats['ruangan'] ?? 0 }}">0</div>
                        <div class="text-muted small">Total Ruangan</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card dashboard-card stat-card">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-light-warning me-3">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <div>
                        <div class="h2 m-0 fw-bold counter" data-target="{{ $stats['kategori_barang'] ?? 0 }}">0</div>
                        <div class="text-muted small">Kategori Barang</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card dashboard-card stat-card">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-light-info me-3">
                        <i class="fas fa-box"></i>
                    </div>
                    <div>
                        <div class="h2 m-0 fw-bold counter" data-target="{{ $stats['barang'] ?? 0 }}">0</div>
                        <div class="text-muted small">Total Barang</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Secondary Statistics Cards -->
    <div class="row row-deck row-cards mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card dashboard-card stat-card">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-light-purple me-3">
                        <i class="fas fa-barcode"></i>
                    </div>
                    <div>
                        <div class="h2 m-0 fw-bold counter" data-target="{{ $stats['barang_inventaris'] ?? 0 }}">0</div>
                        <div class="text-muted small">Barang Inventaris</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card dashboard-card stat-card">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-light-success me-3">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <div>
                        <div class="h2 m-0 fw-bold counter" data-target="{{ $stats['peminjaman_barang'] ?? 0 }}">0</div>
                        <div class="text-muted small">Peminjaman Aktif</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card dashboard-card stat-card">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-light-orange me-3">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <div>
                        <div class="h2 m-0 fw-bold counter" data-target="{{ $stats['pengecekan_barang'] ?? 0 }}">0</div>
                        <div class="text-muted small">Pengecekan</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card dashboard-card stat-card">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-light-teal me-3">
                        <i class="fas fa-tools"></i>
                    </div>
                    <div>
                        <div class="h2 m-0 fw-bold counter" data-target="{{ $stats['pengajuan_perbaikan'] ?? 0 }}">0</div>
                        <div class="text-muted small">Pengajuan Perbaikan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tertiary Statistics Cards -->
    <div class="row row-deck row-cards mb-5">
        <div class="col-sm-6 col-lg-3">
            <div class="card dashboard-card stat-card">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-light-purple me-3">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div>
                        <div class="h2 m-0 fw-bold counter" data-target="{{ $stats['jadwal_pemeliharaan'] ?? 0 }}">0</div>
                        <div class="text-muted small">Jadwal Pemeliharaan</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card dashboard-card stat-card">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-light-teal me-3">
                        <i class="fas fa-history"></i>
                    </div>
                    <div>
                        <div class="h2 m-0 fw-bold counter" data-target="{{ $stats['histori_pemeliharaan'] ?? 0 }}">0</div>
                        <div class="text-muted small">Histori Pemeliharaan</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card dashboard-card stat-card">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-light-orange me-3">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <div>
                        <div class="h2 m-0 fw-bold">Rp {{ number_format($stats['total_biaya_perbaikan'] ?? 0, 0, ',', '.') }}</div>
                        <div class="text-muted small">Total Biaya Perbaikan</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card dashboard-card stat-card">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-light-success me-3">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <div class="h2 m-0 fw-bold">{{ round($stats['rata_rata_kondisi_barang'] ?? 0, 1) }}%</div>
                        <div class="text-muted small">Rata-rata Kondisi Barang</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Grafik Pertumbuhan Bulanan</h5>
                </div>
                <div class="card-body">
                    <div id="annualChart" class="chart-container"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Distribusi Infrastruktur</h5>
                </div>
                <div class="card-body">
                    <div id="infraChart" class="chart-container"></div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Distribusi Inventaris</h5>
                </div>
                <div class="card-body">
                    <div id="inventoryChart" class="chart-container"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Distribusi Transaksi</h5>
                </div>
                <div class="card-body">
                    <div id="transactionChart" class="chart-container"></div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Distribusi Pemeliharaan</h5>
                </div>
                <div class="card-body">
                    <div id="maintenanceChart" class="chart-container"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Distribusi Kondisi Barang</h5>
                </div>
                <div class="card-body">
                    <div id="conditionChart" class="chart-container d-flex justify-content-center"></div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Statistik Kondisi Barang</h5>
                </div>
                <div class="card-body">
                    <div class="progress-bar-label">Baik <span class="float-end">{{ $condition_stats['baik'] ?? 0 }} barang</span></div>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($condition_stats['baik'] ?? 0) > 0 ? (($condition_stats['baik'] / ($condition_stats['total'] ?? 1)) * 100) : 0 }}%" aria-valuenow="{{ $condition_stats['baik'] ?? 0 }}" aria-valuemin="0" aria-valuemax="{{ $condition_stats['total'] ?? 1 }}"></div>
                    </div>
                    
                    <div class="progress-bar-label">Rusak Ringan <span class="float-end">{{ $condition_stats['rusak_ringan'] ?? 0 }} barang</span></div>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ ($condition_stats['rusak_ringan'] ?? 0) > 0 ? (($condition_stats['rusak_ringan'] / ($condition_stats['total'] ?? 1)) * 100) : 0 }}%" aria-valuenow="{{ $condition_stats['rusak_ringan'] ?? 0 }}" aria-valuemin="0" aria-valuemax="{{ $condition_stats['total'] ?? 1 }}"></div>
                    </div>
                    
                    <div class="progress-bar-label">Rusak Berat <span class="float-end">{{ $condition_stats['rusak_berat'] ?? 0 }} barang</span></div>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ ($condition_stats['rusak_berat'] ?? 0) > 0 ? (($condition_stats['rusak_berat'] / ($condition_stats['total'] ?? 1)) * 100) : 0 }}%" aria-valuenow="{{ $condition_stats['rusak_berat'] ?? 0 }}" aria-valuemin="0" aria-valuemax="{{ $condition_stats['total'] ?? 1 }}"></div>
                    </div>
                    
                    <div class="mt-4">
                        <h6>Rata-rata Kondisi: <span class="badge bg-primary">{{ round($stats['rata_rata_kondisi_barang'] ?? 0, 1) }}%</span></h6>
                        <p class="text-muted">Skor berdasarkan: Baik (100%), Rusak Ringan (70%), Rusak Berat (30%)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Sections -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Ringkasan Infrastruktur</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="section-header">Gedung Terbaru</h6>
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table recent-activity-table">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Nama Gedung</th>
                                            <th>Jumlah Lantai</th>
                                            <th>Kondisi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse(($recent_gedung ?? []) as $gedung)
                                            <tr>
                                                <td>{{ $gedung->code }}</td>
                                                <td>{{ $gedung->name }}</td>
                                                <td>{{ $gedung->jumlah_lantai }}</td>
                                                <td>
                                                    @if($gedung->kondisi == 'Baik')
                                                        <span class="badge bg-success">{{ $gedung->kondisi }}</span>
                                                    @elseif($gedung->kondisi == 'Rusak Ringan')
                                                        <span class="badge bg-warning">{{ $gedung->kondisi }}</span>
                                                    @else
                                                        <span class="badge bg-danger">{{ $gedung->kondisi }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak ada data gedung</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="section-header">Ruangan Terbaru</h6>
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table recent-activity-table">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Nama Ruangan</th>
                                            <th>Gedung</th>
                                            <th>Kapasitas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse(($recent_ruangan ?? []) as $ruangan)
                                            <tr>
                                                <td>{{ $ruangan->code }}</td>
                                                <td>{{ $ruangan->name }}</td>
                                                <td>{{ $ruangan->gedung->name ?? '-' }}</td>
                                                <td>{{ $ruangan->kapasitas }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak ada data ruangan</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Ringkasan Inventaris</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="section-header">Barang Inventaris Terbaru</h6>
                            <div class="table-responsive">
                                <table class="table table-striped recent-activity-table">
                                    <thead>
                                        <tr>
                                            <th>No. Inventaris</th>
                                            <th>Nama Barang</th>
                                            <th>Kondisi</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recent_barang_inventaris as $inventaris)
                                            <tr>
                                                <td>{{ $inventaris->nomor_inventaris }}</td>
                                                <td>{{ $inventaris->barang->name ?? '-' }}</td>
                                                <td>
                                                    @if($inventaris->kondisi == 'Baik')
                                                        <span class="badge bg-success">{{ $inventaris->kondisi }}</span>
                                                    @elseif($inventaris->kondisi == 'Rusak Ringan')
                                                        <span class="badge bg-warning">{{ $inventaris->kondisi }}</span>
                                                    @else
                                                        <span class="badge bg-danger">{{ $inventaris->kondisi }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($inventaris->is_active)
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-secondary">Nonaktif</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak ada data barang inventaris</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="section-header">Kategori Barang</h6>
                            <div class="table-responsive">
                                <table class="table table-striped recent-activity-table">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Nama Kategori</th>
                                            <th>Jumlah Barang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($kategori_barang as $kategori)
                                            <tr>
                                                <td>{{ $kategori->code }}</td>
                                                <td>{{ $kategori->name }}</td>
                                                <td>{{ $kategori->barang_count }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">Tidak ada data kategori barang</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Ringkasan Transaksi & Perawatan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="section-header">Peminjaman Terbaru</h6>
                            <div class="table-responsive">
                                <table class="table table-striped recent-activity-table">
                                    <thead>
                                        <tr>
                                            <th>Barang</th>
                                            <th>Peminjam</th>
                                            <th>Tanggal Pinjam</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recent_peminjaman as $peminjaman)
                                            <tr>
                                                <td>{{ $peminjaman->barangInventaris->barang->name ?? '-' }}</td>
                                                <td>{{ $peminjaman->peminjam->name ?? '-' }}</td>
                                                <td>{{ $peminjaman->tanggal_pinjam ? \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y H:i') : '-' }}</td>
                                                <td>
                                                    @if($peminjaman->status == 'Dipinjam')
                                                        <span class="badge bg-primary">{{ $peminjaman->status }}</span>
                                                    @elseif($peminjaman->status == 'Dikembalikan')
                                                        <span class="badge bg-success">{{ $peminjaman->status }}</span>
                                                    @else
                                                        <span class="badge bg-danger">{{ $peminjaman->status }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak ada data peminjaman</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="section-header">Pengajuan Perbaikan Terbaru</h6>
                            <div class="table-responsive">
                                <table class="table table-striped recent-activity-table">
                                    <thead>
                                        <tr>
                                            <th>Barang</th>
                                            <th>Pengaju</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recent_pengajuan as $pengajuan)
                                            <tr>
                                                <td>{{ $pengajuan->barangInventaris->barang->name ?? '-' }}</td>
                                                <td>{{ $pengajuan->pengaju->name ?? '-' }}</td>
                                                <td>{{ $pengajuan->tanggal_pengajuan ? \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d/m/Y') : '-' }}</td>
                                                <td>
                                                    @if($pengajuan->status == 'Diajukan')
                                                        <span class="badge bg-warning">{{ $pengajuan->status }}</span>
                                                    @elseif($pengajuan->status == 'Disetujui')
                                                        <span class="badge bg-primary">{{ $pengajuan->status }}</span>
                                                    @elseif($pengajuan->status == 'Diproses')
                                                        <span class="badge bg-info">{{ $pengajuan->status }}</span>
                                                    @elseif($pengajuan->status == 'Selesai')
                                                        <span class="badge bg-success">{{ $pengajuan->status }}</span>
                                                    @else
                                                        <span class="badge bg-danger">{{ $pengajuan->status }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak ada data pengajuan perbaikan</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animate counters (smooth count-up)
            (function(){
                var counters = document.querySelectorAll('.counter');
                counters.forEach(function(el){
                    var target = parseInt(el.getAttribute('data-target')) || 0;
                    var duration = 1000; // ms
                    var startTime = null;
                    function animate(ts){
                        if(!startTime) startTime = ts;
                        var progress = Math.min((ts - startTime) / duration, 1);
                        var value = Math.floor(progress * target);
                        el.textContent = value.toLocaleString('id-ID');
                        if(progress < 1) requestAnimationFrame(animate);
                    }
                    requestAnimationFrame(animate);
                });
            })();

            // Initialize all charts
            initInfraCharts();
        });
        
        function initInfraCharts() {
            // Chart 1: Infrastructure Distribution
            var infraOptions = {
                series: [{{ $stats['gedung'] ?? 0 }}, {{ $stats['ruangan'] ?? 0 }}],
                chart: {
                    type: 'pie',
                    height: 300
                },
                labels: ['Gedung', 'Ruangan'],
                colors: ['#1976d2', '#2e7d32'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + " unit"
                        }
                    }
                }
            };
            
            var infraChart = new ApexCharts(document.querySelector("#infraChart"), infraOptions);
            infraChart.render();
            
            // Chart 2: Inventory Distribution
            var inventoryOptions = {
                series: [
                    {{ $stats['kategori_barang'] ?? 0 }}, 
                    {{ $stats['barang'] ?? 0 }}, 
                    {{ $stats['barang_inventaris'] ?? 0 }}
                ],
                chart: {
                    type: 'donut',
                    height: 300
                },
                labels: ['Kategori Barang', 'Total Barang', 'Barang Inventaris'],
                colors: ['#f57c00', '#1976d2', '#2e7d32'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + " item"
                        }
                    }
                }
            };
            
            var inventoryChart = new ApexCharts(document.querySelector("#inventoryChart"), inventoryOptions);
            inventoryChart.render();
            
            // Chart 3: Transaction Distribution
            var transactionOptions = {
                series: [{
                    name: 'Jumlah',
                    data: [
                        {{ $stats['peminjaman_barang'] ?? 0 }}, 
                        {{ $stats['pengecekan_barang'] ?? 0 }}, 
                        {{ $stats['pengajuan_perbaikan'] ?? 0 }}
                    ]
                }],
                chart: {
                    type: 'bar',
                    height: 300,
                    toolbar: {
                        show: true
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: ['Peminjaman', 'Pengecekan', 'Perbaikan'],
                },
                yaxis: {
                    title: {
                        text: 'Jumlah'
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + " transaksi"
                        }
                    }
                }
            };
            
            var transactionChart = new ApexCharts(document.querySelector("#transactionChart"), transactionOptions);
            transactionChart.render();
            
            // Chart 4: Maintenance Distribution
            var maintenanceOptions = {
                series: [{
                    name: 'Jumlah',
                    data: [
                        {{ $stats['jadwal_pemeliharaan'] ?? 0 }}, 
                        {{ $stats['histori_pemeliharaan'] ?? 0 }}
                    ]
                }],
                chart: {
                    type: 'bar',
                    height: 300,
                    toolbar: {
                        show: true
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: ['Jadwal', 'Histori'],
                },
                yaxis: {
                    title: {
                        text: 'Jumlah'
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + " item"
                        }
                    }
                }
            };
            
            var maintenanceChart = new ApexCharts(document.querySelector("#maintenanceChart"), maintenanceOptions);
            maintenanceChart.render();
            
            // Chart 5: Condition Distribution Pie Chart
            var conditionOptions = {
                series: [
                    {{ $condition_stats['baik'] ?? 0 }}, 
                    {{ $condition_stats['rusak_ringan'] ?? 0 }}, 
                    {{ $condition_stats['rusak_berat'] ?? 0 }}
                ],
                chart: {
                    width: 380,
                    type: 'pie',
                },
                labels: ['Baik', 'Rusak Ringan', 'Rusak Berat'],
                colors: ['#2e7d32', '#f57c00', '#d32f2f'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + " barang"
                        }
                    }
                }
            };
            
            var conditionChart = new ApexCharts(document.querySelector("#conditionChart"), conditionOptions);
            conditionChart.render();
            
            // Chart 6: Monthly Growth Chart
            var monthlyOptions = {
                series: [{
                    name: 'Infrastruktur',
                    data: {!! json_encode($monthly_stats['infrastruktur'] ?? array_fill(0, 12, 0)) !!}
                }, {
                    name: 'Inventaris',
                    data: {!! json_encode($monthly_stats['inventaris'] ?? array_fill(0, 12, 0)) !!}
                }, {
                    name: 'Transaksi',
                    data: {!! json_encode($monthly_stats['transaksi'] ?? array_fill(0, 12, 0)) !!}
                }],
                chart: {
                    type: 'line',
                    height: 350,
                    stacked: false,
                    toolbar: {
                        show: true
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                },
                yaxis: {
                    title: {
                        text: 'Jumlah'
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + " unit"
                        }
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right'
                },
                colors: ['#1976d2', '#2e7d32', '#f57c00']
            };
            
            var monthlyChart = new ApexCharts(document.querySelector("#annualChart"), monthlyOptions);
            monthlyChart.render();
        }
    </script>
@endsection