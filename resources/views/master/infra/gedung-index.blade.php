@extends('themes.core-backpage')

@section('custom-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <style>
        /* Stats cards */
        .bg-light-primary {
            background-color: rgba(67, 94, 190, 0.1);
        }
        
        .bg-light-success {
            background-color: rgba(40, 167, 69, 0.1);
        }
        
        .bg-light-warning {
            background-color: rgba(255, 193, 7, 0.1);
        }
        
        .bg-light-info {
            background-color: rgba(23, 162, 184, 0.1);
        }

        /* Card styling */
        .card {
            border: none;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            border-radius: 10px;
        }

        .card-header {
            background: none;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 5px;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
        }

        /* Form styling */
        .form-control, .form-select {
            border-radius: 5px;
            border: 1px solid rgba(0,0,0,0.1);
            padding: 0.5rem 1rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: #435ebe;
            box-shadow: 0 0 0 0.2rem rgba(67, 94, 190, 0.25);
        }

        /* Badge styling */
        .badge {
            padding: 0.5em 0.75em;
            font-weight: 500;
        }

        /* Collapsible form */
        .collapse {
            transition: all 0.3s ease;
        }

        .collapse.show {
            margin-top: 1rem;
        }

        /* Image preview */
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
        }

        /* SECTION TABLE SUPER */

        table {
            /* border: 1px solid #ccc; */
            /* border-collapse: collapse; */
            margin: 0;
            padding: 0;
            /* width: 100%; */
            table-layout: fixed;
        }

        /* table caption {
            font-size: 1.5em;
            margin: 0.5em 0 0.75em;
        } */

        table tr {
            /* background-color: #f8f8f8; */
            border: 1px solid #ddd;
            /* padding: 0.35em; */
        }

        table th,
        table td {
            padding: 0.625em;
            text-align: center;
        }

        table th {
            font-size: 0.85em;
            text-align: center !important;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }


        @media screen and (max-width: 600px) {
            table {
                border: 0;
            }

            table caption {
                font-size: 1.3em;
            }

            table thead {
                border: none;
                clip: rect(0 0 0 0);
                height: 1px;
                margin: -1px;
                overflow: hidden;
                padding: 0;
                position: absolute;
                width: 1px;
            }

            table tr {
                border-bottom: 3px solid #ddd;
                display: block;
                margin-bottom: 0.625em;
            }

            table td {
                border-bottom: 1px solid #ddd;
                display: block;
                font-size: 0.8em;
                text-align: right;
            }

            table td::before {
                content: attr(data-label);
                float: left;
                font-weight: bold;
                text-transform: uppercase;
            }

            table td:last-child {
                border-bottom: 0;
            }
            
            /* Improve delete info display on mobile */
            table td[data-label="Dihapus Oleh"] .d-flex.align-items-center,
            table td[data-label="Dihapus Pada"] .d-flex.align-items-center {
                align-items: flex-end !important;
                justify-content: flex-end !important;
            }
            
            /* Make delete info more compact on mobile */
            table td[data-label="Dihapus Pada"] div {
                text-align: right;
            }
        }
        
        /* DataTables Buttons Styling */
        .dt-buttons {
            margin-bottom: 1rem;
        }
        
        .dt-buttons .btn {
            margin-right: 5px;
            margin-bottom: 5px;
        }
        
        /* Custom DataTables styling */
        #gedungTable_wrapper .row:first-child {
            margin-bottom: 1rem;
        }
        
        .dataTables_filter input {
            border-radius: 5px;
            border: 1px solid #dee2e6;
            padding: 0.375rem 0.75rem;
        }
        
        .dataTables_length select {
            border-radius: 5px;
            border: 1px solid #dee2e6;
            padding: 0.375rem 0.75rem;
        }
        
        /* Custom toolbar styling */
        .dataTables-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .export-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }
        
        .entries-filter {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        @media (max-width: 768px) {
            .dataTables-toolbar {
                flex-direction: column;
                align-items: stretch;
            }
            
            .export-buttons {
                justify-content: center;
            }
            
            .entries-filter {
                justify-content: center;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card bg-light-primary">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Gedung</h6>
                            <h3 class="mt-2 mb-0">{{ count($gedungs) }}</h3>
                        </div>
                        <div class="rounded-circle p-3 bg-primary text-white">
                            <i class="fas fa-building fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card bg-light-success">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Kondisi Baik</h6>
                            <h3 class="mt-2 mb-0">{{ $gedungs->where('kondisi', 'Baik')->count() }}</h3>
                        </div>
                        <div class="rounded-circle p-3 bg-success text-white">
                            <i class="fas fa-check-circle fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card bg-light-warning">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Rusak Ringan</h6>
                            <h3 class="mt-2 mb-0">{{ $gedungs->where('kondisi', 'Rusak Ringan')->count() }}</h3>
                        </div>
                        <div class="rounded-circle p-3 bg-warning text-white">
                            <i class="fas fa-exclamation-triangle fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card bg-light-info">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Rusak Berat</h6>
                            <h3 class="mt-2 mb-0">{{ $gedungs->where('kondisi', 'Rusak Berat')->count() }}</h3>
                        </div>
                        <div class="rounded-circle p-3 bg-danger text-white">
                            <i class="fas fa-times-circle fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-9 col-12 mb-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $pages ?? 'Daftar Gedung' }}</h5>
                    <div>
                        @if($is_trash)
                            <a href="{{ route('infra.gedung-index') }}" class="btn btn-sm btn-secondary me-2">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Utama
                            </a>
                        @else
                            <a href="{{ route('infra.gedung-trash') }}" class="btn btn-sm btn-warning me-2">
                                <i class="fas fa-trash me-2"></i>Trash
                            </a>
                            <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseForm" aria-expanded="false" aria-controls="collapseForm">
                                <i class="fas fa-plus-circle me-2"></i>Tambah Gedung
                            </button>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <!-- Collapsible Form -->
                    @if(!$is_trash)
                        <div class="collapse" id="collapseForm">
                            <div class="card card-body border">
                                <h5 class="card-title mb-3">Tambah Gedung Baru</h5>
                                <form action="{{ route('infra.gedung-store') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Nama Gedung</label>
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan nama gedung" required>
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="code" class="form-label">Kode Gedung</label>
                                            <input type="text" class="form-control" name="code" id="code" placeholder="Masukkan kode gedung" required>
                                            @error('code')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" name="alamat" id="alamat" placeholder="Masukkan alamat gedung" rows="3"></textarea>
                                            @error('alamat')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="jumlah_lantai" class="form-label">Jumlah Lantai</label>
                                            <input type="number" class="form-control" name="jumlah_lantai" id="jumlah_lantai" value="1" min="1" required>
                                            @error('jumlah_lantai')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="tahun_dibangun" class="form-label">Tahun Dibangun</label>
                                            <input type="number" class="form-control" name="tahun_dibangun" id="tahun_dibangun" min="1900" max="{{ date('Y') }}" placeholder="Masukkan tahun dibangun">
                                            @error('tahun_dibangun')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="kondisi" class="form-label">Kondisi</label>
                                            <select class="form-select" name="kondisi" id="kondisi" required>
                                                <option value="Baik">Baik</option>
                                                <option value="Rusak Ringan">Rusak Ringan</option>
                                                <option value="Rusak Berat">Rusak Berat</option>
                                            </select>
                                            @error('kondisi')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                                                <label class="form-check-label" for="is_active">Aktif</label>
                                            </div>
                                            @error('is_active')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                <i class="fas fa-save me-2"></i>Simpan
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Custom Toolbar -->
                    <div class="dataTables-toolbar mt-3" id="customToolbar" style="display: none;">
                        <div class="export-buttons" id="exportButtons">
                            <!-- Export buttons will be moved here -->
                        </div>
                        <div class="entries-filter">
                            <label for="entriesSelect" class="form-label mb-0">Tampilkan:</label>
                            <select class="form-select form-select-sm" id="entriesSelect" style="width: auto;">
                                <option value="10">10 entries</option>
                                <option value="25">25 entries</option>
                                <option value="50">50 entries</option>
                                <option value="100">100 entries</option>
                                <option value="-1">Semua entries</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="gedungTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Gedung</th>
                                    <th>Kode</th>
                                    <th>Alamat</th>
                                    <th>Lantai</th>
                                    <th>Kondisi</th>
                                    <th>Status</th>
                                    @if($is_trash)
                                        <th>Dihapus Oleh</th>
                                        <th>Dihapus Pada</th>
                                    @endif
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gedungs as $key => $item)
                                    <tr>
                                        <td data-label="No">{{ ++$key }}</td>
                                        <td data-label="Nama Gedung">{{ $item->name }}</td>
                                        <td data-label="Kode">{{ $item->code }}</td>
                                        <td data-label="Alamat">{{ $item->alamat ?? '-' }}</td>
                                        <td data-label="Lantai">{{ $item->jumlah_lantai }}</td>
                                        <td data-label="Kondisi">
                                            @if($item->kondisi == 'Baik')
                                                <span class="badge bg-success">{{ $item->kondisi }}</span>
                                            @elseif($item->kondisi == 'Rusak Ringan')
                                                <span class="badge bg-warning">{{ $item->kondisi }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ $item->kondisi }}</span>
                                            @endif
                                        </td>
                                        <td data-label="Status">
                                            @if($item->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            @endif
                                        </td>
                                        @if($is_trash)
                                            <td data-label="Dihapus Oleh">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-user-times text-danger me-2"></i>
                                                    <span>{{ $item->deletedBy ? $item->deletedBy->name : 'Tidak diketahui' }}</span>
                                                </div>
                                            </td>
                                            <td data-label="Dihapus Pada">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-calendar-times text-danger me-2"></i>
                                                    <div>
                                                        <small class="d-block">{{ $item->deleted_at ? $item->deleted_at->format('d/m/Y H:i') : '-' }}</small>
                                                        <small class="text-muted">{{ $item->deleted_at ? $item->deleted_at->diffForHumans() : '-' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                        <td data-label="Aksi">
                                            @if($is_trash)
                                                <form action="{{ route('infra.gedung-restore', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" data-bs-toggle="tooltip" title="Restore Gedung">
                                                        <i class="fas fa-undo me-1"></i> Restore
                                                    </button>
                                                </form>
                                            @else
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#editData{{ $item->id }}" class="btn btn-sm btn-primary me-1" data-bs-toggle="tooltip" title="Edit Gedung">
                                                    <i class="fas fa-edit me-1"></i> Edit
                                                </a>
                                                <form action="{{ route('infra.gedung-destroy', $item->id) }}" method="POST" class="d-inline" id="delete-form-{{ $item->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger" data-confirm-delete="true" data-bs-toggle="tooltip" title="Hapus Gedung" onclick="confirmDelete('{{ $item->id }}')">
                                                        <i class="fas fa-trash me-1"></i> Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar Content -->
        <div class="col-lg-3 col-12 mb-2">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Informasi Gedung</h5>
                </div>
                <div class="card-body">
                    <p>Bagian ini menampilkan informasi umum dan petunjuk terkait pengelolaan Gedung.</p>
                    
                    <div class="alert alert-light-primary">
                        <h6 class="">Petunjuk Penggunaan:</h6>
                        <ul class="mb-0">
                            <li>Klik tombol "Tambah Gedung" untuk menambahkan gedung baru</li>
                            <li>Klik ikon <i class="fas fa-edit"></i> untuk mengedit gedung</li>
                            @if($is_trash)
                                <li>Klik ikon <i class="fas fa-undo"></i> untuk restore gedung</li>
                            @else
                                <li>Klik ikon <i class="fas fa-trash"></i> untuk menghapus gedung</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Gedung Terbaru -->
            @if(count($gedungs) > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Gedung Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($gedungs->sortByDesc('created_at')->take(5) as $item)
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $item->name }}</h6>
                                    <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <small class="text-muted">Kode: {{ $item->code }}</small>
                                    <span class="badge {{ $item->kondisi == 'Baik' ? 'bg-success' : ($item->kondisi == 'Rusak Ringan' ? 'bg-warning' : 'bg-danger') }}">{{ $item->kondisi }}</span>
                                </div>
                                <small class="d-block mt-1">Lantai: {{ $item->jumlah_lantai }} | Tahun: {{ $item->tahun_dibangun ?? 'N/A' }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Statistik Gedung -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Statistik Gedung</h5>
                </div>
                <div class="card-body">
                    <canvas id="gedungChart" width="100%" height="200"></canvas>
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modals -->
    @if(!$is_trash)
        @foreach ($gedungs as $item)
            <div class="modal fade" id="editData{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <form action="{{ route('infra.gedung-update', $item->id) }}" method="POST">
                            @method('PATCH')
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Gedung - {{ $item->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="edit_name{{ $item->id }}" class="form-label">Nama Gedung</label>
                                        <input type="text" class="form-control" name="name" id="edit_name{{ $item->id }}" value="{{ $item->name }}" placeholder="Masukkan nama gedung" required>
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="edit_code{{ $item->id }}" class="form-label">Kode Gedung</label>
                                        <input type="text" class="form-control" name="code" id="edit_code{{ $item->id }}" value="{{ $item->code }}" placeholder="Masukkan kode gedung" required>
                                        @error('code')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="edit_alamat{{ $item->id }}" class="form-label">Alamat</label>
                                        <textarea class="form-control" name="alamat" id="edit_alamat{{ $item->id }}" placeholder="Masukkan alamat gedung" rows="3">{{ $item->alamat ?? '' }}</textarea>
                                        @error('alamat')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="edit_jumlah_lantai{{ $item->id }}" class="form-label">Jumlah Lantai</label>
                                        <input type="number" class="form-control" name="jumlah_lantai" id="edit_jumlah_lantai{{ $item->id }}" value="{{ $item->jumlah_lantai }}" min="1" required>
                                        @error('jumlah_lantai')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="edit_tahun_dibangun{{ $item->id }}" class="form-label">Tahun Dibangun</label>
                                        <input type="number" class="form-control" name="tahun_dibangun" id="edit_tahun_dibangun{{ $item->id }}" value="{{ $item->tahun_dibangun }}" min="1900" max="{{ date('Y') }}" placeholder="Masukkan tahun dibangun">
                                        @error('tahun_dibangun')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="edit_kondisi{{ $item->id }}" class="form-label">Kondisi</label>
                                        <select class="form-select" name="kondisi" id="edit_kondisi{{ $item->id }}" required>
                                            <option value="Baik" {{ $item->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                                            <option value="Rusak Ringan" {{ $item->kondisi == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                            <option value="Rusak Berat" {{ $item->kondisi == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                        </select>
                                        @error('kondisi')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="is_active" id="edit_is_active{{ $item->id }}" value="1" {{ $item->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label" for="edit_is_active{{ $item->id }}">Aktif</label>
                                        </div>
                                        @error('is_active')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection

@section('custom-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Initialize DataTable
        $(document).ready(function() {
            var table = $('#gedungTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        text: '<i class="fas fa-copy"></i> Copy',
                        className: 'btn btn-secondary btn-sm',
                        exportOptions: {
                            columns: ':not(:last-child)' // Exclude action column
                        }
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv"></i> CSV',
                        className: 'btn btn-success btn-sm',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        filename: function() {
                            return 'Data_Gedung_' + new Date().toISOString().slice(0,10);
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'btn btn-success btn-sm',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        filename: function() {
                            return 'Data_Gedung_' + new Date().toISOString().slice(0,10);
                        },
                        title: 'Data Gedung'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn btn-danger btn-sm',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        filename: function() {
                            return 'Data_Gedung_' + new Date().toISOString().slice(0,10);
                        },
                        title: 'Data Gedung',
                        customize: function(doc) {
                            doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                            doc.styles.tableHeader.fontSize = 10;
                            doc.styles.tableBodyEven.fontSize = 9;
                            doc.styles.tableBodyOdd.fontSize = 9;
                            doc.content[0].text = 'Data Gedung';
                            doc.content[0].alignment = 'center';
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        className: 'btn btn-info btn-sm',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        title: 'Data Gedung',
                        customize: function(win) {
                            $(win.document.body)
                                .css('font-size', '10pt')
                                .prepend('<div style="text-align:center; margin-bottom: 20px;"><h3>Data Gedung</h3><p>Dicetak pada: ' + new Date().toLocaleDateString('id-ID') + '</p></div>');
                            
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }
                ],
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    zeroRecords: "Data tidak ditemukan",
                    info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                    infoEmpty: "Tidak ada data yang tersedia",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    },
                    buttons: {
                        copy: "Salin",
                        copyTitle: "Disalin ke clipboard",
                        copySuccess: {
                            _: "%d baris disalin",
                            1: "1 baris disalin"
                        }
                    }
                },
                responsive: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
                order: [[0, 'asc']],
                initComplete: function() {
                    // Move buttons to custom toolbar
                    var buttons = $('.dt-buttons').detach();
                    $('#exportButtons').append(buttons.html());
                    
                    // Show custom toolbar
                    $('#customToolbar').show();
                    
                    // Hide default DataTables controls
                    $('.dt-buttons').hide();
                    $('#gedungTable_length').hide();
                }
            });
            
            // Handle entries filter change
            $('#entriesSelect').on('change', function() {
                var value = $(this).val();
                table.page.len(value).draw();
            });
            
            // Set initial value for entries select
            $('#entriesSelect').val(table.page.len());
            
            // Initialize Chart
            var ctx = document.getElementById('gedungChart').getContext('2d');
            var gedungChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Baik', 'Rusak Ringan', 'Rusak Berat'],
                    datasets: [{
                        data: [
                            {{ $gedungs->where('kondisi', 'Baik')->count() }},
                            {{ $gedungs->where('kondisi', 'Rusak Ringan')->count() }},
                            {{ $gedungs->where('kondisi', 'Rusak Berat')->count() }}
                        ],
                        backgroundColor: [
                            '#28a745',
                            '#ffc107',
                            '#dc3545'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        title: {
                            display: true,
                            text: 'Kondisi Gedung'
                        }
                    }
                }
            });
        });

        // Image preview
        function previewImage(input, previewId = 'preview') {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Konfirmasi delete dengan SweetAlert
        function confirmDelete(code) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data gedung yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + code).submit();
                }
            });
        }
    </script>
@endsection