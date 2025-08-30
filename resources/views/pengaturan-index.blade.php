@extends('themes.core-backpage')

@section('custom-css')
<style>
    .settings-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem;
        border-radius: 10px;
        color: white;
        margin-bottom: 2rem;
    }
    .settings-logo {
        width: 150px;
        height: 150px;
        border-radius: 10px;
        border: 5px solid white;
        object-fit: contain;
        background-color: white;
    }
    .nav-tabs .nav-link.active {
        background-color: #667eea;
        color: white;
        border-color: #667eea;
    }
    .form-section {
        /* background: #f8f9fa; */
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }
    .preview-image {
        max-width: 100px;
        max-height: 100px;
        border-radius: 5px;
        border: 1px solid #ddd;
        margin-top: 10px;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Settings Header -->
                <div class="settings-header">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <img src="{{ $system->app_logo_vertikal }}" alt="Logo Vertikal" class="settings-logo" id="previewLogoVertikal">
                        </div>
                        <div class="col-md-10">
                            <h2 class="mb-0">{{ $system->app_name }}</h2>
                            <p class="mb-1">{{ $system->app_description }}</p>
                            <p class="mb-0"><i class="fas fa-envelope"></i> {{ $system->app_email }} | <i class="fas fa-globe"></i> {{ $system->app_url }}</p>
                        </div>
                    </div>
                </div>

                <!-- Form Update Settings -->
                <form action="{{ route($spref . 'pengaturan-update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#aplikasi" role="tab">
                                <i class="fas fa-cogs"></i> Aplikasi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#kampus" role="tab">
                                <i class="fas fa-university"></i> Kampus
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#logo" role="tab">
                                <i class="fas fa-image"></i> Logo & Favicon
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#alamat" role="tab">
                                <i class="fas fa-map-marker-alt"></i> Alamat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#sosmed" role="tab">
                                <i class="fas fa-share-alt"></i> Sosial Media
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
                        <!-- Tab Aplikasi -->
                        <div class="tab-pane active" id="aplikasi" role="tabpanel">
                            <div class="form-section">
                                <h5 class="mb-3">Informasi Aplikasi</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nama Aplikasi <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="app_name" value="{{ $system->app_name }}" placeholder="Nama Aplikasi" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Versi Aplikasi</label>
                                        <input type="text" class="form-control" name="app_version" value="{{ $system->app_version }}" placeholder="Versi Aplikasi">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Deskripsi Aplikasi</label>
                                        <textarea class="form-control" name="app_description" rows="3" placeholder="Deskripsi singkat tentang aplikasi">{{ $system->app_description }}</textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">URL Aplikasi</label>
                                        <input type="url" class="form-control" name="app_url" value="{{ $system->app_url }}" placeholder="https://example.com">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email Aplikasi</label>
                                        <input type="email" class="form-control" name="app_email" value="{{ $system->app_email }}" placeholder="info@example.com">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Kampus -->
                        <div class="tab-pane" id="kampus" role="tabpanel">
                            <div class="form-section">
                                <h5 class="mb-3">Informasi Kampus</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nama Kampus <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="kampus_name" value="{{ $academy->name }}" placeholder="Nama Kampus" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Domain</label>
                                        <input type="text" class="form-control" name="kampus_domain" value="{{ $academy->domain }}" placeholder="example.com">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Nomor Telepon</label>
                                        <input type="text" class="form-control" name="kampus_phone" value="{{ $academy->phone }}" placeholder="081234567890">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Faximile</label>
                                        <input type="text" class="form-control" name="kampus_faximile" value="{{ $academy->faximile }}" placeholder="081234567890">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">WhatsApp</label>
                                        <input type="text" class="form-control" name="kampus_whatsapp" value="{{ $academy->whatsapp }}" placeholder="081234567890">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email Info</label>
                                        <input type="email" class="form-control" name="kampus_email_info" value="{{ $academy->email_info }}" placeholder="info@example.com">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email Humas</label>
                                        <input type="email" class="form-control" name="kampus_email_humas" value="{{ $academy->email_humas }}" placeholder="humas@example.com">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Logo -->
                        <div class="tab-pane" id="logo" role="tabpanel">
                            <div class="form-section">
                                <h5 class="mb-3">Logo & Favicon</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Favicon</label>
                                        <input type="file" class="form-control" name="app_favicon" accept="image/*" onchange="previewImage(this, 'previewFavicon')">
                                        <small class="text-muted">Ukuran yang disarankan: 32x32 pixel</small>
                                        <div class="mt-2">
                                            <img src="{{ $system->app_favicon }}" alt="Favicon" class="preview-image" id="previewFavicon">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Logo Vertikal</label>
                                        <input type="file" class="form-control" name="app_logo_vertikal" accept="image/*" onchange="previewImage(this, 'previewLogoVertikal')">
                                        <small class="text-muted">Ukuran yang disarankan: 200x200 pixel</small>
                                        <div class="mt-2">
                                            <img src="{{ $system->app_logo_vertikal }}" alt="Logo Vertikal" class="preview-image" id="previewLogoVertikal2">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Logo Horizontal</label>
                                        <input type="file" class="form-control" name="app_logo_horizontal" accept="image/*" onchange="previewImage(this, 'previewLogoHorizontal')">
                                        <small class="text-muted">Ukuran yang disarankan: 300x100 pixel</small>
                                        <div class="mt-2">
                                            <img src="{{ $system->app_logo_horizontal }}" alt="Logo Horizontal" class="preview-image" id="previewLogoHorizontal">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Alamat -->
                        <div class="tab-pane" id="alamat" role="tabpanel">
                            <div class="form-section">
                                <h5 class="mb-3">Alamat Kampus</h5>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Alamat Lengkap</label>
                                        <textarea class="form-control" name="kampus_alamat" rows="3" placeholder="Jl. Contoh No. 123, RT 01/RW 02">{{ $academy->alamat }}</textarea>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">RT</label>
                                        <input type="text" class="form-control" name="kampus_rt" value="{{ $academy->rt }}" placeholder="001">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">RW</label>
                                        <input type="text" class="form-control" name="kampus_rw" value="{{ $academy->rw }}" placeholder="002">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Kelurahan/Desa</label>
                                        <input type="text" class="form-control" name="kampus_kelurahan" value="{{ $academy->kelurahan }}" placeholder="Nama kelurahan/desa">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Kecamatan</label>
                                        <input type="text" class="form-control" name="kampus_kecamatan" value="{{ $academy->kecamatan }}" placeholder="Nama kecamatan">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Kota/Kabupaten</label>
                                        <input type="text" class="form-control" name="kampus_kota_kabupaten" value="{{ $academy->kota_kabupaten }}" placeholder="Nama kota/kabupaten">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Provinsi</label>
                                        <input type="text" class="form-control" name="kampus_provinsi" value="{{ $academy->provinsi }}" placeholder="Nama provinsi">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Kode Pos</label>
                                        <input type="text" class="form-control" name="kampus_kode_pos" value="{{ $academy->kode_pos }}" placeholder="12345" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="form-section">
                                <h5 class="mb-3">Koordinat Lokasi</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Latitude</label>
                                        <input type="text" class="form-control" name="kampus_langtitude" value="{{ $academy->langtitude }}" placeholder="-6.1234567">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Longitude</label>
                                        <input type="text" class="form-control" name="kampus_longitude" value="{{ $academy->longitude }}" placeholder="106.1234567">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Sosial Media -->
                        <div class="tab-pane" id="sosmed" role="tabpanel">
                            <div class="form-section">
                                <h5 class="mb-3">Sosial Media Kampus</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label"><i class="fab fa-instagram"></i> Instagram</label>
                                        <input type="text" class="form-control" name="kampus_instagram" value="{{ $academy->instagram }}" placeholder="@username_instagram">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label"><i class="fab fa-facebook"></i> Facebook</label>
                                        <input type="text" class="form-control" name="kampus_facebook" value="{{ $academy->facebook }}" placeholder="facebook.com/username">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label"><i class="fab fa-linkedin"></i> LinkedIn</label>
                                        <input type="text" class="form-control" name="kampus_linkedin" value="{{ $academy->linkedin }}" placeholder="linkedin.com/in/username">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label"><i class="fab fa-twitter"></i> X/Twitter</label>
                                        <input type="text" class="form-control" name="kampus_xtwitter" value="{{ $academy->xtwitter }}" placeholder="twitter.com/username">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label"><i class="fab fa-tiktok"></i> TikTok</label>
                                        <input type="text" class="form-control" name="kampus_tiktok" value="{{ $academy->tiktok }}" placeholder="tiktok.com/@username">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Keamanan -->
                        <div class="tab-pane" id="keamanan" role="tabpanel">
                            <div class="form-section">
                                <h5 class="mb-3">Pengaturan Keamanan</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="maintenance_mode" name="maintenance_mode" value="1" {{ $system->maintenance_mode ? 'checked' : '' }}>
                                            <label class="form-check-label" for="maintenance_mode">Mode Maintenance</label>
                                        </div>
                                        <small class="text-muted">Aktifkan mode maintenance untuk menonaktifkan akses ke aplikasi sementara.</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="enable_captcha" name="enable_captcha" value="1" {{ $system->enable_captcha ? 'checked' : '' }}>
                                            <label class="form-check-label" for="enable_captcha">Aktifkan CAPTCHA</label>
                                        </div>
                                        <small class="text-muted">Aktifkan CAPTCHA untuk melindungi form login dari bot.</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Batas Percobaan Login</label>
                                        <input type="number" class="form-control" name="max_login_attempts" value="{{ $system->max_login_attempts }}" min="1" max="10">
                                        <small class="text-muted">Jumlah maksimal percobaan login yang diizinkan sebelum akun dikunci.</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Waktu Reset Percobaan Login (detik)</label>
                                        <input type="number" class="form-control" name="login_decay_seconds" value="{{ $system->login_decay_seconds }}" min="30" max="3600">
                                        <small class="text-muted">Waktu (dalam detik) sebelum percobaan login direset.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Pengaturan
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
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection