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
        #kategoriBarangTable_wrapper .row:first-child {
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
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8 col-12 mb-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $pages ?? 'Daftar Histori Pemeliharaan' }}</h5>
                    <div>
                        @if($is_trash)
                            <a href="{{ route('perawatan.histori-index') }}" class="btn btn-sm btn-secondary me-2">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Utama
                            </a>
                        @else
                            <a href="{{ route('perawatan.histori-trash') }}" class="btn btn-sm btn-warning me-2">
                                <i class="fas fa-trash me-2"></i>Trash
                            </a>
                            <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseForm" aria-expanded="false" aria-controls="collapseForm">
                                <i class="fas fa-plus-circle me-2"></i>Tambah Histori
                            </button>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <!-- Collapsible Form -->
                    @if(!$is_trash)
                        <div class="collapse" id="collapseForm">
                            <div class="card card-body border">
                                <h5 class="card-title mb-3">Tambah Histori Pemeliharaan Baru</h5>
                                <form action="{{ route('perawatan.histori-store') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="jadwal_id" class="form-label">Jadwal (Opsional)</label>
                                            <select class="form-select" name="jadwal_id" id="jadwal_id">
                                                <option value="">Pilih Jadwal (Opsional)</option>
                                                @foreach($jadwal_list as $jadwal)
                                                    <option value="{{ $jadwal->id }}">Jadwal #{{ $jadwal->id }} - {{ $jadwal->barangInventaris->barang->name }} ({{ $jadwal->barangInventaris->nomor_inventaris }})</option>
                                                @endforeach
                                            </select>
                                            @error('jadwal_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="barang_inventaris_id" class="form-label">Barang Inventaris</label>
                                            <select class="form-select" name="barang_inventaris_id" id="barang_inventaris_id" required>
                                                <option value="">Pilih Barang Inventaris</option>
                                                @foreach($barang_inventaris as $barang)
                                                    <option value="{{ $barang->id }}">{{ $barang->barang->name }} ({{ $barang->nomor_inventaris }})</option>
                                                @endforeach
                                            </select>
                                            @error('barang_inventaris_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="petugas_id" class="form-label">Petugas</label>
                                            <select class="form-select" name="petugas_id" id="petugas_id" required>
                                                <option value="">Pilih Petugas</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('petugas_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan</label>
                                            <input type="date" class="form-control" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" required>
                                            @error('tanggal_pelaksanaan')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="hasil_kondisi" class="form-label">Hasil Kondisi</label>
                                            <select class="form-select" name="hasil_kondisi" id="hasil_kondisi" required>
                                                <option value="">Pilih Hasil</option>
                                                <option value="Baik">Baik</option>
                                                <option value="Rusak Ringan">Rusak Ringan</option>
                                                <option value="Rusak Berat">Rusak Berat</option>
                                                <option value="Hilang">Hilang</option>
                                            </select>
                                            @error('hasil_kondisi')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="catatan" class="form-label">Catatan</label>
                                            <textarea class="form-control" name="catatan" id="catatan" rows="3"></textarea>
                                            @error('catatan')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
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
                        <table class="table table-striped table-bordered" id="historiTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jadwal</th>
                                    <th>Barang Inventaris</th>
                                    <th>Petugas</th>
                                    <th>Tanggal Pelaksanaan</th>
                                    <th>Hasil Kondisi</th>
                                    <th>Catatan</th>
                                    @if($is_trash)
                                        <th>Dihapus Oleh</th>
                                        <th>Dihapus Pada</th>
                                    @endif
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($histori as $key => $item)
                                    <tr>
                                        <td data-label="No">{{ ++$key }}</td>
                                        <td data-label="Jadwal">{{ $item->jadwal ? 'Jadwal #' . $item->jadwal->id : '-' }}</td>
                                        <td data-label="Barang Inventaris">{{ $item->barangInventaris ? $item->barangInventaris->barang->name . ' (' . $item->barangInventaris->nomor_inventaris . ')' : '-' }}</td>
                                        <td data-label="Petugas">{{ $item->petugas ? $item->petugas->name : '-' }}</td>
                                        <td data-label="Tanggal Pelaksanaan">{{ $item->tanggal_pelaksanaan ? \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->format('d/m/Y') : '-' }}</td>
                                        <td data-label="Hasil Kondisi">
                                            @if($item->hasil_kondisi == 'Baik')
                                                <span class="badge bg-success">{{ $item->hasil_kondisi }}</span>
                                            @elseif($item->hasil_kondisi == 'Rusak Ringan')
                                                <span class="badge bg-warning">{{ $item->hasil_kondisi }}</span>
                                            @elseif($item->hasil_kondisi == 'Rusak Berat')
                                                <span class="badge bg-danger">{{ $item->hasil_kondisi }}</span>
                                            @elseif($item->hasil_kondisi == 'Hilang')
                                                <span class="badge bg-dark">{{ $item->hasil_kondisi }}</span>
                                            @endif
                                        </td>
                                        <td data-label="Catatan">{{ $item->catatan ?? '-' }}</td>
                                        @if($is_trash)
                                            <td data-label="Dihapus Oleh">{{ $item->deletedBy ? $item->deletedBy->name : '-' }}</td>
                                            <td data-label="Dihapus Pada">{{ $item->deleted_at ? $item->deleted_at->format('d/m/Y H:i') : '-' }}</td>
                                        @endif
                                        <td data-label="Aksi">
                                            @if($is_trash)
                                                <form action="{{ route('perawatan.histori-restore', $item->id) }}" method="POST" class="d-inline restore-form">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" title="Restore">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('perawatan.histori-destroy', $item->id) }}" method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    
                                    <!-- Edit Modal -->
                                    @if(!$is_trash)
                                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Histori Pemeliharaan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('perawatan.histori-update', $item->id) }}" method="post">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="jadwal_id_edit{{ $item->id }}" class="form-label">Jadwal (Opsional)</label>
                                                                <select class="form-select" name="jadwal_id" id="jadwal_id_edit{{ $item->id }}">
                                                                    <option value="">Pilih Jadwal (Opsional)</option>
                                                                    @foreach($jadwal_list as $jadwal)
                                                                        <option value="{{ $jadwal->id }}" {{ $jadwal->id == $item->jadwal_id ? 'selected' : '' }}>Jadwal #{{ $jadwal->id }} - {{ $jadwal->barangInventaris->barang->name }} ({{ $jadwal->barangInventaris->nomor_inventaris }})</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('jadwal_id')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="barang_inventaris_id_edit{{ $item->id }}" class="form-label">Barang Inventaris</label>
                                                                <select class="form-select" name="barang_inventaris_id" id="barang_inventaris_id_edit{{ $item->id }}" required>
                                                                    <option value="">Pilih Barang Inventaris</option>
                                                                    @foreach($barang_inventaris as $barang)
                                                                        <option value="{{ $barang->id }}" {{ $barang->id == $item->barang_inventaris_id ? 'selected' : '' }}>{{ $barang->barang->name }} ({{ $barang->nomor_inventaris }})</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('barang_inventaris_id')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="petugas_id_edit{{ $item->id }}" class="form-label">Petugas</label>
                                                                <select class="form-select" name="petugas_id" id="petugas_id_edit{{ $item->id }}" required>
                                                                    <option value="">Pilih Petugas</option>
                                                                    @foreach($users as $user)
                                                                        <option value="{{ $user->id }}" {{ $user->id == $item->petugas_id ? 'selected' : '' }}>{{ $user->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('petugas_id')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="tanggal_pelaksanaan_edit{{ $item->id }}" class="form-label">Tanggal Pelaksanaan</label>
                                                                <input type="date" class="form-control" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan_edit{{ $item->id }}" value="{{ $item->tanggal_pelaksanaan ? \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->format('Y-m-d') : '' }}" required>
                                                                @error('tanggal_pelaksanaan')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="hasil_kondisi_edit{{ $item->id }}" class="form-label">Hasil Kondisi</label>
                                                                <select class="form-select" name="hasil_kondisi" id="hasil_kondisi_edit{{ $item->id }}" required>
                                                                    <option value="">Pilih Hasil</option>
                                                                    <option value="Baik" {{ $item->hasil_kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                                                                    <option value="Rusak Ringan" {{ $item->hasil_kondisi == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                                                    <option value="Rusak Berat" {{ $item->hasil_kondisi == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                                                    <option value="Hilang" {{ $item->hasil_kondisi == 'Hilang' ? 'selected' : '' }}>Hilang</option>
                                                                </select>
                                                                @error('hasil_kondisi')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="catatan_edit{{ $item->id }}" class="form-label">Catatan</label>
                                                                <textarea class="form-control" name="catatan" id="catatan_edit{{ $item->id }}" rows="3">{{ $item->catatan }}</textarea>
                                                                @error('catatan')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Info Card -->
        <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informasi</h5>
                </div>
                <div class="card-body">
                    <p>Halaman ini digunakan untuk mengelola data histori pemeliharaan barang inventaris.</p>
                    <ul>
                        <li>Klik tombol "Tambah Histori" untuk menambahkan data baru</li>
                        <li>Gunakan tombol "Edit" untuk mengubah informasi histori pemeliharaan</li>
                        <li>Gunakan tombol "Hapus" untuk menghapus data (masuk ke trash)</li>
                        <li>Di halaman trash, Anda dapat merestore data yang telah dihapus</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
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

    <script>
        // Initialize DataTable
        $(document).ready(function() {
            var table = $('#historiTable').DataTable({
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
                            return 'Data_Histori_Pemeliharaan_' + new Date().toISOString().slice(0,10);
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
                            return 'Data_Histori_Pemeliharaan_' + new Date().toISOString().slice(0,10);
                        },
                        title: 'Data Histori Pemeliharaan'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn btn-danger btn-sm',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        filename: function() {
                            return 'Data_Histori_Pemeliharaan_' + new Date().toISOString().slice(0,10);
                        },
                        title: 'Data Histori Pemeliharaan',
                        customize: function(doc) {
                            doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                            doc.styles.tableHeader.fontSize = 10;
                            doc.styles.tableBodyEven.fontSize = 9;
                            doc.styles.tableBodyOdd.fontSize = 9;
                            doc.content[0].text = 'Data Histori Pemeliharaan';
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
                        title: 'Data Histori Pemeliharaan',
                        customize: function(win) {
                            $(win.document.body)
                                .css('font-size', '10pt')
                                .prepend('<div style="text-align:center; margin-bottom: 20px;"><h3>Data Histori Pemeliharaan</h3><p>Dicetak pada: ' + new Date().toLocaleDateString('id-ID') + '</p></div>');
                            
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
                    $('#historiTable_length').hide();
                }
            });
            
            // Handle entries filter change
            $('#entriesSelect').on('change', function() {
                var value = $(this).val();
                table.page.len(value).draw();
            });
            
            // Set initial value for entries select
            $('#entriesSelect').val(table.page.len());
            
            // Delete confirmation
            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                var form = this;
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus akan masuk ke trash!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
            
            // Restore confirmation
            $('.restore-form').on('submit', function(e) {
                e.preventDefault();
                var form = this;
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data akan dikembalikan dari trash!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, restore!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
