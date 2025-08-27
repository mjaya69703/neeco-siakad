@extends('themes.core-backpage')

@section('custom-css')
<style>
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem;
        border-radius: 10px;
        color: white;
        margin-bottom: 2rem;
    }
    .profile-photo {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 5px solid white;
        object-fit: cover;
    }
    .nav-tabs .nav-link.active {
        background-color: #667eea;
        color: white;
        border-color: #667eea;
    }
    .form-section {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Profile Header -->
                <div class="profile-header">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <img src="{{ $user->photo }}" alt="Profile Photo" class="profile-photo" id="previewPhoto">
                        </div>
                        <div class="col-md-10">
                            <h2 class="mb-0">{{ $user->name }}</h2>
                            <p class="mb-1">{{ $user->role->name ?? 'No Role' }}</p>
                            <p class="mb-0"><i class="fas fa-envelope"></i> {{ $user->email }} | <i class="fas fa-phone"></i> {{ $user->phone }}</p>
                        </div>
                    </div>
                </div>

                <!-- Form Update Profile -->
                <form action="{{ route($user->prefix . 'profile-update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Hidden inputs for deleted items -->
                    <input type="hidden" name="deleted_pendidikan" id="deleted_pendidikan" value="">
                    <input type="hidden" name="deleted_keluarga" id="deleted_keluarga" value="">
                    
                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#biodata" role="tab">
                                <i class="fas fa-user"></i> Biodata
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#kontak" role="tab">
                                <i class="fas fa-address-card"></i> Kontak & Sosial Media
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#identitas" role="tab">
                                <i class="fas fa-id-card"></i> Identitas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#alamat" role="tab">
                                <i class="fas fa-map-marker-alt"></i> Alamat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#pendidikan" role="tab">
                                <i class="fas fa-graduation-cap"></i> Pendidikan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#keluarga" role="tab">
                                <i class="fas fa-users"></i> Keluarga
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#keamanan" role="tab">
                                <i class="fas fa-lock"></i> Keamanan
                            </a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content p-3">
                        <!-- Tab Biodata -->
                        <div class="tab-pane active" id="biodata" role="tabpanel">
                            <div class="form-section">
                                <h5 class="mb-3">Informasi Dasar</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" value="{{ $user->name }}" placeholder="Masukkan nama lengkap" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control" name="username" value="{{ $user->username }}" placeholder="Masukkan username unik">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Foto Profile</label>
                                        <input type="file" class="form-control" name="photo" accept="image/*" onchange="previewImage(this)">
                                        <small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <select class="form-select" name="jenis_kelamin_id">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            @foreach($jenisKelamins as $jk)
                                                <option value="{{ $jk->id }}" {{ $user->jenis_kelamin_id == $jk->id ? 'selected' : '' }}>
                                                    {{ $jk->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tempat Lahir</label>
                                        <input type="text" class="form-control" name="tempat_lahir" value="{{ $user->tempat_lahir }}" placeholder="Contoh: Jakarta">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" name="tanggal_lahir" value="{{ $user->tanggal_lahir }}" placeholder="YYYY-MM-DD">
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h5 class="mb-3">Informasi Tambahan</h5>
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Agama</label>
                                        <select class="form-select" name="agama_id">
                                            <option value="">Pilih Agama</option>
                                            @foreach($agamas as $agama)
                                                <option value="{{ $agama->id }}" {{ $user->agama_id == $agama->id ? 'selected' : '' }}>
                                                    {{ $agama->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Golongan Darah</label>
                                        <select class="form-select" name="golongan_darah_id">
                                            <option value="">Pilih Golongan Darah</option>
                                            @foreach($golonganDarahs as $gd)
                                                <option value="{{ $gd->id }}" {{ $user->golongan_darah_id == $gd->id ? 'selected' : '' }}>
                                                    {{ $gd->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Kewarganegaraan</label>
                                        <select class="form-select" name="kewarganegaraan_id">
                                            <option value="">Pilih Kewarganegaraan</option>
                                            @foreach($kewarganegaraans as $kwn)
                                                <option value="{{ $kwn->id }}" {{ $user->kewarganegaraan_id == $kwn->id ? 'selected' : '' }}>
                                                    {{ $kwn->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Tinggi Badan (cm)</label>
                                        <input type="text" class="form-control" name="tinggi_badan" value="{{ $user->tinggi_badan }}" placeholder="Contoh: 170">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Berat Badan (kg)</label>
                                        <input type="text" class="form-control" name="berat_badan" value="{{ $user->berat_badan }}" placeholder="Contoh: 65">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Kontak -->
                        <div class="tab-pane" id="kontak" role="tabpanel">
                            <div class="form-section">
                                <h5 class="mb-3">Informasi Kontak</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" value="{{ $user->email }}" placeholder="contoh@email.com" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="phone" value="{{ $user->phone }}" placeholder="Contoh: 081234567890" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h5 class="mb-3">Sosial Media</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label"><i class="fab fa-instagram"></i> Instagram</label>
                                        <input type="text" class="form-control" name="link_ig" value="{{ $user->link_ig }}" placeholder="@username_instagram">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label"><i class="fab fa-facebook"></i> Facebook</label>
                                        <input type="text" class="form-control" name="link_fb" value="{{ $user->link_fb }}" placeholder="facebook.com/username">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label"><i class="fab fa-linkedin"></i> LinkedIn</label>
                                        <input type="text" class="form-control" name="link_in" value="{{ $user->link_in }}" placeholder="linkedin.com/in/username">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Identitas -->
                        <div class="tab-pane" id="identitas" role="tabpanel">
                            <div class="form-section">
                                <h5 class="mb-3">Nomor Identitas</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nomor KK</label>
                                        <input type="text" class="form-control" name="nomor_kk" value="{{ $user->nomor_kk }}" placeholder="1234567890123456" maxlength="16">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nomor KTP</label>
                                        <input type="text" class="form-control" name="nomor_ktp" value="{{ $user->nomor_ktp }}" placeholder="1234567890123456" maxlength="16">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nomor NPWP</label>
                                        <input type="text" class="form-control" name="nomor_npwp" value="{{ $user->nomor_npwp }}" placeholder="123456789012345" maxlength="15">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Alamat -->
                        <div class="tab-pane" id="alamat" role="tabpanel">
                            <div class="form-section">
                                <h5 class="mb-3">Alamat KTP</h5>
                                <div class="row">
                                    <input type="hidden" name="alamat_ktp[id]" value="{{ $user->alamatKtp->first()->id ?? '' }}">
                                    <input type="hidden" name="alamat_ktp[tipe]" value="ktp">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Alamat Lengkap KTP</label>
                                        <textarea class="form-control" name="alamat_ktp[alamat_lengkap]" rows="3" 
                                                  placeholder="Jl. Contoh No. 123, RT 01/RW 02">{{ $user->alamatKtp->first()->alamat_lengkap ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">RT</label>
                                        <input type="text" class="form-control" name="alamat_ktp[rt]" 
                                               value="{{ $user->alamatKtp->first()->rt ?? '' }}" placeholder="001">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">RW</label>
                                        <input type="text" class="form-control" name="alamat_ktp[rw]" 
                                               value="{{ $user->alamatKtp->first()->rw ?? '' }}" placeholder="002">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Kelurahan/Desa</label>
                                        <input type="text" class="form-control" name="alamat_ktp[kelurahan]" 
                                               value="{{ $user->alamatKtp->first()->kelurahan ?? '' }}" placeholder="Nama kelurahan/desa">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Kecamatan</label>
                                        <input type="text" class="form-control" name="alamat_ktp[kecamatan]" 
                                               value="{{ $user->alamatKtp->first()->kecamatan ?? '' }}" placeholder="Nama kecamatan">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Kota/Kabupaten</label>
                                        <input type="text" class="form-control" name="alamat_ktp[kota_kabupaten]" 
                                               value="{{ $user->alamatKtp->first()->kota_kabupaten ?? '' }}" placeholder="Nama kota/kabupaten">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Provinsi</label>
                                        <input type="text" class="form-control" name="alamat_ktp[provinsi]" 
                                               value="{{ $user->alamatKtp->first()->provinsi ?? '' }}" placeholder="Nama provinsi">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Kode Pos</label>
                                        <input type="text" class="form-control" name="alamat_ktp[kode_pos]" 
                                               value="{{ $user->alamatKtp->first()->kode_pos ?? '' }}" placeholder="12345" maxlength="10">
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">Alamat Domisili</h5>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="samaDenganKTP" onchange="copyFromKTP()">
                                        <label class="form-check-label" for="samaDenganKTP">
                                            Sama dengan alamat KTP
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <input type="hidden" name="alamat_domisili[id]" value="{{ $user->alamatDomisili->first()->id ?? '' }}">
                                    <input type="hidden" name="alamat_domisili[tipe]" value="domisili">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Alamat Lengkap Domisili</label>
                                        <textarea class="form-control" name="alamat_domisili[alamat_lengkap]" rows="3" 
                                                  placeholder="Jl. Contoh No. 123, RT 01/RW 02" id="domisili_alamat_lengkap">{{ $user->alamatDomisili->first()->alamat_lengkap ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">RT</label>
                                        <input type="text" class="form-control" name="alamat_domisili[rt]" 
                                               value="{{ $user->alamatDomisili->first()->rt ?? '' }}" placeholder="001" id="domisili_rt">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">RW</label>
                                        <input type="text" class="form-control" name="alamat_domisili[rw]" 
                                               value="{{ $user->alamatDomisili->first()->rw ?? '' }}" placeholder="002" id="domisili_rw">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Kelurahan/Desa</label>
                                        <input type="text" class="form-control" name="alamat_domisili[kelurahan]" 
                                               value="{{ $user->alamatDomisili->first()->kelurahan ?? '' }}" placeholder="Nama kelurahan/desa" id="domisili_kelurahan">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Kecamatan</label>
                                        <input type="text" class="form-control" name="alamat_domisili[kecamatan]" 
                                               value="{{ $user->alamatDomisili->first()->kecamatan ?? '' }}" placeholder="Nama kecamatan" id="domisili_kecamatan">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Kota/Kabupaten</label>
                                        <input type="text" class="form-control" name="alamat_domisili[kota_kabupaten]" 
                                               value="{{ $user->alamatDomisili->first()->kota_kabupaten ?? '' }}" placeholder="Nama kota/kabupaten" id="domisili_kota_kabupaten">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Provinsi</label>
                                        <input type="text" class="form-control" name="alamat_domisili[provinsi]" 
                                               value="{{ $user->alamatDomisili->first()->provinsi ?? '' }}" placeholder="Nama provinsi" id="domisili_provinsi">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Kode Pos</label>
                                        <input type="text" class="form-control" name="alamat_domisili[kode_pos]" 
                                               value="{{ $user->alamatDomisili->first()->kode_pos ?? '' }}" placeholder="12345" maxlength="10" id="domisili_kode_pos">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Pendidikan -->
                        <div class="tab-pane" id="pendidikan" role="tabpanel">
                            <div class="form-section">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">Riwayat Pendidikan</h5>
                                    <button type="button" class="btn btn-sm btn-success" onclick="addPendidikan()">
                                        <i class="fas fa-plus"></i> Tambah Pendidikan
                                    </button>
                                </div>
                                
                                <div id="pendidikan-container">
                                    @forelse($user->pendidikans as $index => $pendidikan)
                                        <div class="card mb-3 pendidikan-item" data-index="{{ $index }}">
                                            <div class="card-body">
                                                <div class="row">
                                                    <input type="hidden" name="pendidikan[{{ $index }}][id]" value="{{ $pendidikan->id }}">
                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Jenjang Pendidikan</label>
                                                        <select class="form-select" name="pendidikan[{{ $index }}][jenjang]" required>
                                                            <option value="">Pilih Jenjang</option>
                                                            <option value="Paket C" {{ $pendidikan->jenjang == 'Paket C' ? 'selected' : '' }}>Paket C</option>
                                                            <option value="SMA" {{ $pendidikan->jenjang == 'SMA' ? 'selected' : '' }}>SMA</option>
                                                            <option value="SMK" {{ $pendidikan->jenjang == 'SMK' ? 'selected' : '' }}>SMK</option>
                                                            <option value="D3" {{ $pendidikan->jenjang == 'D3' ? 'selected' : '' }}>Diploma 3</option>
                                                            <option value="S1" {{ $pendidikan->jenjang == 'S1' ? 'selected' : '' }}>Sarjana (S1)</option>
                                                            <option value="S2" {{ $pendidikan->jenjang == 'S2' ? 'selected' : '' }}>Magister (S2)</option>
                                                            <option value="S3" {{ $pendidikan->jenjang == 'S3' ? 'selected' : '' }}>Doktor (S3)</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label">Nama Institusi</label>
                                                        <input type="text" class="form-control" name="pendidikan[{{ $index }}][nama_institusi]" 
                                                               value="{{ $pendidikan->nama_institusi }}" placeholder="Nama sekolah/universitas" required>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Jurusan/Program Studi</label>
                                                        <input type="text" class="form-control" name="pendidikan[{{ $index }}][jurusan]" 
                                                               value="{{ $pendidikan->jurusan }}" placeholder="Nama jurusan/prodi">
                                                    </div>
                                                    <div class="col-md-2 mb-3">
                                                        <label class="form-label">Aksi</label>
                                                        <button type="button" class="btn btn-danger btn-sm d-block delete-pendidikan" data-index="{{ $index }}">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </div>
                                                    <div class="col-md-2 mb-3">
                                                        <label class="form-label">Tahun Masuk</label>
                                                        <input type="number" class="form-control" name="pendidikan[{{ $index }}][tahun_masuk]" 
                                                               value="{{ $pendidikan->tahun_masuk }}" placeholder="2020" min="1950" max="{{ date('Y') }}">
                                                    </div>
                                                    <div class="col-md-2 mb-3">
                                                        <label class="form-label">Tahun Lulus</label>
                                                        <input type="number" class="form-control" name="pendidikan[{{ $index }}][tahun_lulus]" 
                                                               value="{{ $pendidikan->tahun_lulus }}" placeholder="2024" min="1950" max="{{ date('Y') + 10 }}">
                                                    </div>
                                                    <div class="col-md-2 mb-3">
                                                        <label class="form-label">IPK/Nilai</label>
                                                        <input type="text" class="form-control" name="pendidikan[{{ $index }}][ipk]" 
                                                               value="{{ $pendidikan->ipk }}" placeholder="3.50">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Alamat Institusi</label>
                                                        <textarea class="form-control" name="pendidikan[{{ $index }}][alamat]" rows="2" 
                                                                  placeholder="Alamat lengkap institusi">{{ $pendidikan->alamat }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-muted text-center">Belum ada data pendidikan. Klik tombol "Tambah Pendidikan" untuk menambah data.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Tab Keluarga -->
                        <div class="tab-pane" id="keluarga" role="tabpanel">
                            <div class="form-section">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">Data Keluarga</h5>
                                    <button type="button" class="btn btn-sm btn-success" onclick="addKeluarga()">
                                        <i class="fas fa-plus"></i> Tambah Anggota Keluarga
                                    </button>
                                </div>
                                
                                <div id="keluarga-container">
                                    @forelse($user->keluargas as $index => $keluarga)
                                        <div class="card mb-3 keluarga-item" data-index="{{ $index }}">
                                            <div class="card-body">
                                                <div class="row">
                                                    <input type="hidden" name="keluarga[{{ $index }}][id]" value="{{ $keluarga->id }}">
                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Hubungan Keluarga</label>
                                                        <select class="form-select" name="keluarga[{{ $index }}][hubungan]" required>
                                                            <option value="">Pilih Hubungan</option>
                                                            <option value="Ayah" {{ $keluarga->hubungan == 'Ayah' ? 'selected' : '' }}>Ayah</option>
                                                            <option value="Ibu" {{ $keluarga->hubungan == 'Ibu' ? 'selected' : '' }}>Ibu</option>
                                                            <option value="Suami" {{ $keluarga->hubungan == 'Suami' ? 'selected' : '' }}>Suami</option>
                                                            <option value="Istri" {{ $keluarga->hubungan == 'Istri' ? 'selected' : '' }}>Istri</option>
                                                            <option value="Anak" {{ $keluarga->hubungan == 'Anak' ? 'selected' : '' }}>Anak</option>
                                                            <option value="Kakak" {{ $keluarga->hubungan == 'Kakak' ? 'selected' : '' }}>Kakak</option>
                                                            <option value="Adik" {{ $keluarga->hubungan == 'Adik' ? 'selected' : '' }}>Adik</option>
                                                            <option value="Wali" {{ $keluarga->hubungan == 'Wali' ? 'selected' : '' }}>Wali</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label">Nama Lengkap</label>
                                                        <input type="text" class="form-control" name="keluarga[{{ $index }}][nama]" 
                                                               value="{{ $keluarga->nama }}" placeholder="Nama lengkap anggota keluarga" required>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Pekerjaan</label>
                                                        <input type="text" class="form-control" name="keluarga[{{ $index }}][pekerjaan]" 
                                                               value="{{ $keluarga->pekerjaan }}" placeholder="Pekerjaan/profesi">
                                                    </div>
                                                    <div class="col-md-2 mb-3">
                                                        <label class="form-label">Aksi</label>
                                                        <button type="button" class="btn btn-danger btn-sm d-block delete-keluarga" data-index="{{ $index }}">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Nomor Telepon</label>
                                                        <input type="text" class="form-control" name="keluarga[{{ $index }}][telepon]" 
                                                               value="{{ $keluarga->telepon }}" placeholder="081234567890">
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Tempat Lahir</label>
                                                        <input type="text" class="form-control" name="keluarga[{{ $index }}][tempat_lahir]" 
                                                               value="{{ $keluarga->tempat_lahir }}" placeholder="Jakarta">
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Tanggal Lahir</label>
                                                        <input type="date" class="form-control" name="keluarga[{{ $index }}][tanggal_lahir]" 
                                                               value="{{ $keluarga->tanggal_lahir }}">
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Penghasilan (Rp)</label>
                                                        <input type="number" class="form-control" name="keluarga[{{ $index }}][penghasilan]" 
                                                               value="{{ $keluarga->penghasilan }}" placeholder="5000000">
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-label">Alamat</label>
                                                        <textarea class="form-control" name="keluarga[{{ $index }}][alamat]" rows="2" 
                                                                  placeholder="Alamat lengkap">{{ $keluarga->alamat }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-muted text-center">Belum ada data keluarga. Klik tombol "Tambah Anggota Keluarga" untuk menambah data.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Tab Keamanan -->
                        <div class="tab-pane" id="keamanan" role="tabpanel">
                            <div class="form-section">
                                <h5 class="mb-3">Ubah Password</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Password Lama</label>
                                        <input type="password" class="form-control" name="current_password" placeholder="Masukkan password lama">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Password Baru</label>
                                        <input type="password" class="form-control" name="new_password" placeholder="Minimal 8 karakter">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Konfirmasi Password Baru</label>
                                        <input type="password" class="form-control" name="new_password_confirmation" placeholder="Ulangi password baru">
                                    </div>
                                </div>
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                            </div>

                            <div class="form-section">
                                <h5 class="mb-3">Pengaturan Keamanan</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" name="fst_setup" {{ $user->fst_setup ? 'checked' : '' }}>
                                            <label class="form-check-label">First Time Setup</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" name="tfa_setup" {{ $user->tfa_setup ? 'checked' : '' }}>
                                            <label class="form-check-label">Two Factor Authentication</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        // Validasi file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        const file = input.files[0];
        
        if (!allowedTypes.includes(file.type)) {
            alert('File harus berupa gambar (JPEG, JPG, PNG, atau GIF)');
            input.value = '';
            return;
        }
        
        // Validasi ukuran file (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file maksimal 2MB');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewPhoto = document.getElementById('previewPhoto');
            if (previewPhoto) {
                previewPhoto.src = e.target.result;
            }
        }
        reader.onerror = function() {
            alert('Terjadi kesalahan saat membaca file');
            input.value = '';
        }
        reader.readAsDataURL(file);
    }
}

// Tambahan: Reset preview jika input dikosongkan
document.addEventListener('DOMContentLoaded', function() {
    const photoInput = document.querySelector('input[name="photo"]');
    if (photoInput) {
        photoInput.addEventListener('change', function() {
            if (this.files.length === 0) {
                // Reset ke foto asli jika tidak ada file yang dipilih
                const previewPhoto = document.getElementById('previewPhoto');
                const originalSrc = '{{ $user->photo }}';
                if (previewPhoto && originalSrc) {
                    previewPhoto.src = originalSrc;
                }
            }
        });
    }
});

// Pendidikan Functions
let pendidikanIndex = {{ count($user->pendidikans) }};

function addPendidikan() {
    const container = document.getElementById('pendidikan-container');
    const template = `
        <div class="card mb-3 pendidikan-item" data-index="${pendidikanIndex}">
            <div class="card-body">
                <div class="row">
                    <input type="hidden" name="pendidikan[${pendidikanIndex}][id]" value="">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Jenjang Pendidikan</label>
                        <select class="form-select" name="pendidikan[${pendidikanIndex}][jenjang]" required>
                            <option value="">Pilih Jenjang</option>
                            <option value="Paket C">Paket C</option>
                            <option value="SMA">SMA</option>
                            <option value="SMK">SMK</option>
                            <option value="D3">Diploma 3</option>
                            <option value="S1">Sarjana (S1)</option>
                            <option value="S2">Magister (S2)</option>
                            <option value="S3">Doktor (S3)</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nama Institusi</label>
                        <input type="text" class="form-control" name="pendidikan[${pendidikanIndex}][nama_institusi]" 
                               placeholder="Nama sekolah/universitas" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Jurusan/Program Studi</label>
                        <input type="text" class="form-control" name="pendidikan[${pendidikanIndex}][jurusan]" 
                               placeholder="Nama jurusan/prodi">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Aksi</label>
                        <button type="button" class="btn btn-danger btn-sm d-block delete-pendidikan" data-index="${pendidikanIndex}">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Tahun Masuk</label>
                        <input type="number" class="form-control" name="pendidikan[${pendidikanIndex}][tahun_masuk]" 
                               placeholder="2020" min="1950" max="{{ date('Y') }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Tahun Lulus</label>
                        <input type="number" class="form-control" name="pendidikan[${pendidikanIndex}][tahun_lulus]" 
                               placeholder="2024" min="1950" max="{{ date('Y') + 10 }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">IPK/Nilai</label>
                        <input type="text" class="form-control" name="pendidikan[${pendidikanIndex}][ipk]" 
                               placeholder="3.50">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Alamat Institusi</label>
                        <textarea class="form-control" name="pendidikan[${pendidikanIndex}][alamat]" rows="2" 
                                  placeholder="Alamat lengkap institusi"></textarea>
                    </div>
                </div>
            </div>
        </div>`;
    
    container.insertAdjacentHTML('beforeend', template);
    pendidikanIndex++;
}

// Keluarga Functions
let keluargaIndex = {{ count($user->keluargas) }};



function addKeluarga() {
    const container = document.getElementById('keluarga-container');
    const template = `
        <div class="card mb-3 keluarga-item" data-index="${keluargaIndex}">
            <div class="card-body">
                <div class="row">
                    <input type="hidden" name="keluarga[${keluargaIndex}][id]" value="">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Hubungan Keluarga</label>
                        <select class="form-select" name="keluarga[${keluargaIndex}][hubungan]" required>
                            <option value="">Pilih Hubungan</option>
                            <option value="Ayah">Ayah</option>
                            <option value="Ibu">Ibu</option>
                            <option value="Suami">Suami</option>
                            <option value="Istri">Istri</option>
                            <option value="Anak">Anak</option>
                            <option value="Kakak">Kakak</option>
                            <option value="Adik">Adik</option>
                            <option value="Wali">Wali</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="keluarga[${keluargaIndex}][nama]" 
                               placeholder="Nama lengkap anggota keluarga" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" class="form-control" name="keluarga[${keluargaIndex}][pekerjaan]" 
                               placeholder="Pekerjaan/profesi">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Aksi</label>
                        <button type="button" class="btn btn-danger btn-sm d-block delete-keluarga" data-index="${keluargaIndex}">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" name="keluarga[${keluargaIndex}][telepon]" 
                               placeholder="081234567890">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" name="keluarga[${keluargaIndex}][tempat_lahir]" 
                               placeholder="Jakarta">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="keluarga[${keluargaIndex}][tanggal_lahir]">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Penghasilan (Rp)</label>
                        <input type="number" class="form-control" name="keluarga[${keluargaIndex}][penghasilan]" 
                               placeholder="5000000">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" name="keluarga[${keluargaIndex}][alamat]" rows="2" 
                                  placeholder="Alamat lengkap"></textarea>
                    </div>
                </div>
            </div>
        </div>`;
    
    container.insertAdjacentHTML('beforeend', template);
    keluargaIndex++;
}

// === HAPUS PENDIDIKAN ===
function removePendidikan(index) {
  if (!confirm('Apakah Anda yakin ingin menghapus data pendidikan ini?')) {
    return;
  }

  const item = document.querySelector(`.pendidikan-item[data-index="${index}"]`);
  if (item) {
    item.remove();
    
    // Show "no data" message if no items left
    const container = document.getElementById('pendidikan-container');
    if (container.children.length === 0) {
      container.innerHTML = '<p class="text-muted text-center">Belum ada data pendidikan. Klik tombol "Tambah Pendidikan" untuk menambah data.</p>';
    }
  }
}

function removeKeluarga(index) {
  if (!confirm('Apakah Anda yakin ingin menghapus data keluarga ini?')) {
    return;
  }

  const item = document.querySelector(`.keluarga-item[data-index="${index}"]`);
  if (item) {
    item.remove();
    
    // Show "no data" message if no items left
    const container = document.getElementById('keluarga-container');
    if (container.children.length === 0) {
      container.innerHTML = '<p class="text-muted text-center">Belum ada data keluarga. Klik tombol "Tambah Anggota Keluarga" untuk menambah data.</p>';
    }
  }
}

// Tambahkan function copy alamat KTP ke Domisili
function copyFromKTP() {
    const checkbox = document.getElementById('samaDenganKTP');
    if (checkbox.checked) {
        // Copy alamat KTP ke domisili
        document.getElementById('domisili_alamat_lengkap').value = document.querySelector('textarea[name="alamat_ktp[alamat_lengkap]"]').value;
        document.getElementById('domisili_rt').value = document.querySelector('input[name="alamat_ktp[rt]"]').value;
        document.getElementById('domisili_rw').value = document.querySelector('input[name="alamat_ktp[rw]"]').value;
        document.getElementById('domisili_kelurahan').value = document.querySelector('input[name="alamat_ktp[kelurahan]"]').value;
        document.getElementById('domisili_kecamatan').value = document.querySelector('input[name="alamat_ktp[kecamatan]"]').value;
        document.getElementById('domisili_kota_kabupaten').value = document.querySelector('input[name="alamat_ktp[kota_kabupaten]"]').value;
        document.getElementById('domisili_provinsi').value = document.querySelector('input[name="alamat_ktp[provinsi]"]').value;
        document.getElementById('domisili_kode_pos').value = document.querySelector('input[name="alamat_ktp[kode_pos]"]').value;
    } else {
        // Clear domisili fields
        document.getElementById('domisili_alamat_lengkap').value = '';
        document.getElementById('domisili_rt').value = '';
        document.getElementById('domisili_rw').value = '';
        document.getElementById('domisili_kelurahan').value = '';
        document.getElementById('domisili_kecamatan').value = '';
        document.getElementById('domisili_kota_kabupaten').value = '';
        document.getElementById('domisili_provinsi').value = '';
        document.getElementById('domisili_kode_pos').value = '';
    }
}

// Show success/error messages are now handled by realrashid Alert package automatically
// Event delegation for delete buttons
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(e) {
        // Handle delete pendidikan
        if (e.target.closest('.delete-pendidikan')) {
            e.preventDefault();
            const button = e.target.closest('.delete-pendidikan');
            const index = button.getAttribute('data-index');
            removePendidikan(index);
        }
        
        // Handle delete keluarga
        if (e.target.closest('.delete-keluarga')) {
            e.preventDefault();
            const button = e.target.closest('.delete-keluarga');
            const index = button.getAttribute('data-index');
            removeKeluarga(index);
        }
    });
});
</script>
@endsection

