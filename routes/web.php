<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\RootController::class, 'renderHomePage'])->name('root.home-index');

Route::get('/signin', [App\Http\Controllers\AuthController::class, 'renderSignin'])->name('auth.render-signin');
Route::post('/signin', [App\Http\Controllers\AuthController::class, 'handleSignin'])->name('auth.handle-signin');


Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [App\Http\Controllers\AuthController::class, 'handleLogout'])->name('auth.handle-logout');
    // GLOBAL MENU AUTHENTIKASI
    Route::get('/dashboard', [App\Http\Controllers\Private\User\RootController::class, 'renderDashboard'])->name('dashboard-index');
    Route::get('/profile', [App\Http\Controllers\Private\User\RootController::class, 'renderProfile'])->name('profile-index');
    Route::post('/profile', [App\Http\Controllers\Private\User\RootController::class, 'handleProfile'])->name('profile-update');
    Route::delete('/profile/pendidikan/{id}', [App\Http\Controllers\Private\User\RootController::class, 'deletePendidikan'])->name('profile.delete-pendidikan');
    Route::delete('/profile/keluarga/{id}', [App\Http\Controllers\Private\User\RootController::class, 'deleteKeluarga'])->name('profile.delete-keluarga');
    
    Route::get('/pengaturan', [App\Http\Controllers\PengaturanController::class, 'index'])->name('pengaturan-index');
    Route::post('/pengaturan', [App\Http\Controllers\PengaturanController::class, 'update'])->name('pengaturan-update');
    
    // Master Data Referensi
    Route::get('/referensi', [App\Http\Controllers\RootController::class, 'indexReferensi'])->name('referensi-index');
    Route::get('/referensi/agama', [App\Http\Controllers\Referensi\AgamaController::class, 'index'])->name('referensi.agama-index');
    Route::get('/referensi/agama/trashed', [App\Http\Controllers\Referensi\AgamaController::class, 'trash'])->name('referensi.agama-trash');
    Route::post('/referensi/agama', [App\Http\Controllers\Referensi\AgamaController::class, 'store'])->name('referensi.agama-store');
    Route::patch('/referensi/agama/{id}/update', [App\Http\Controllers\Referensi\AgamaController::class, 'update'])->name('referensi.agama-update');
    Route::delete('/referensi/agama/{id}/delete', [App\Http\Controllers\Referensi\AgamaController::class, 'destroy'])->name('referensi.agama-destroy');
    Route::post('/referensi/agama/{id}/restore', [App\Http\Controllers\Referensi\AgamaController::class, 'restore'])->name('referensi.agama-restore');
    
    Route::get('/referensi/golongan-darah', [App\Http\Controllers\Referensi\GolonganDarahController::class, 'index'])->name('referensi.golongan-darah-index');
    Route::get('/referensi/golongan-darah/trashed', [App\Http\Controllers\Referensi\GolonganDarahController::class, 'trash'])->name('referensi.golongan-darah-trash');
    Route::post('/referensi/golongan-darah', [App\Http\Controllers\Referensi\GolonganDarahController::class, 'store'])->name('referensi.golongan-darah-store');
    Route::patch('/referensi/golongan-darah/{id}/update', [App\Http\Controllers\Referensi\GolonganDarahController::class, 'update'])->name('referensi.golongan-darah-update');
    Route::delete('/referensi/golongan-darah/{id}/delete', [App\Http\Controllers\Referensi\GolonganDarahController::class, 'destroy'])->name('referensi.golongan-darah-destroy');
    Route::post('/referensi/golongan-darah/{id}/restore', [App\Http\Controllers\Referensi\GolonganDarahController::class, 'restore'])->name('referensi.golongan-darah-restore');
    
    Route::get('/referensi/jenis-kelamin', [App\Http\Controllers\Referensi\JenisKelaminController::class, 'index'])->name('referensi.jenis-kelamin-index');
    Route::get('/referensi/jenis-kelamin/trashed', [App\Http\Controllers\Referensi\JenisKelaminController::class, 'trash'])->name('referensi.jenis-kelamin-trash');
    Route::post('/referensi/jenis-kelamin', [App\Http\Controllers\Referensi\JenisKelaminController::class, 'store'])->name('referensi.jenis-kelamin-store');
    Route::patch('/referensi/jenis-kelamin/{id}/update', [App\Http\Controllers\Referensi\JenisKelaminController::class, 'update'])->name('referensi.jenis-kelamin-update');
    Route::delete('/referensi/jenis-kelamin/{id}/delete', [App\Http\Controllers\Referensi\JenisKelaminController::class, 'destroy'])->name('referensi.jenis-kelamin-destroy');
    Route::post('/referensi/jenis-kelamin/{id}/restore', [App\Http\Controllers\Referensi\JenisKelaminController::class, 'restore'])->name('referensi.jenis-kelamin-restore');
    
    Route::get('/referensi/kewarganegaraan', [App\Http\Controllers\Referensi\KewarganegaraanController::class, 'index'])->name('referensi.kewarganegaraan-index');
    Route::get('/referensi/kewarganegaraan/trashed', [App\Http\Controllers\Referensi\KewarganegaraanController::class, 'trash'])->name('referensi.kewarganegaraan-trash');
    Route::post('/referensi/kewarganegaraan', [App\Http\Controllers\Referensi\KewarganegaraanController::class, 'store'])->name('referensi.kewarganegaraan-store');
    Route::patch('/referensi/kewarganegaraan/{id}/update', [App\Http\Controllers\Referensi\KewarganegaraanController::class, 'update'])->name('referensi.kewarganegaraan-update');
    Route::delete('/referensi/kewarganegaraan/{id}/delete', [App\Http\Controllers\Referensi\KewarganegaraanController::class, 'destroy'])->name('referensi.kewarganegaraan-destroy');
    Route::post('/referensi/kewarganegaraan/{id}/restore', [App\Http\Controllers\Referensi\KewarganegaraanController::class, 'restore'])->name('referensi.kewarganegaraan-restore');
    
    Route::get('/referensi/semester', [App\Http\Controllers\Referensi\SemesterController::class, 'index'])->name('referensi.semester-index');
    Route::get('/referensi/semester/trashed', [App\Http\Controllers\Referensi\SemesterController::class, 'trash'])->name('referensi.semester-trash');
    Route::post('/referensi/semester', [App\Http\Controllers\Referensi\SemesterController::class, 'store'])->name('referensi.semester-store');
    Route::patch('/referensi/semester/{id}/update', [App\Http\Controllers\Referensi\SemesterController::class, 'update'])->name('referensi.semester-update');
    Route::delete('/referensi/semester/{id}/delete', [App\Http\Controllers\Referensi\SemesterController::class, 'destroy'])->name('referensi.semester-destroy');
    Route::post('/referensi/semester/{id}/restore', [App\Http\Controllers\Referensi\SemesterController::class, 'restore'])->name('referensi.semester-restore');
    
    Route::get('/referensi/status-mahasiswa', [App\Http\Controllers\Referensi\StatusMahasiswaController::class, 'index'])->name('referensi.status-mahasiswa-index');
    Route::get('/referensi/status-mahasiswa/trashed', [App\Http\Controllers\Referensi\StatusMahasiswaController::class, 'trash'])->name('referensi.status-mahasiswa-trash');
    Route::post('/referensi/status-mahasiswa', [App\Http\Controllers\Referensi\StatusMahasiswaController::class, 'store'])->name('referensi.status-mahasiswa-store');
    Route::patch('/referensi/status-mahasiswa/{id}/update', [App\Http\Controllers\Referensi\StatusMahasiswaController::class, 'update'])->name('referensi.status-mahasiswa-update');
    Route::delete('/referensi/status-mahasiswa/{id}/delete', [App\Http\Controllers\Referensi\StatusMahasiswaController::class, 'destroy'])->name('referensi.status-mahasiswa-destroy');
    Route::post('/referensi/status-mahasiswa/{id}/restore', [App\Http\Controllers\Referensi\StatusMahasiswaController::class, 'restore'])->name('referensi.status-mahasiswa-restore');
    
    Route::get('/referensi/jabatan', [App\Http\Controllers\Referensi\JabatanController::class, 'index'])->name('referensi.jabatan-index');
    Route::get('/referensi/jabatan/trashed', [App\Http\Controllers\Referensi\JabatanController::class, 'trash'])->name('referensi.jabatan-trash');
    Route::post('/referensi/jabatan', [App\Http\Controllers\Referensi\JabatanController::class, 'store'])->name('referensi.jabatan-store');
    Route::patch('/referensi/jabatan/{id}/update', [App\Http\Controllers\Referensi\JabatanController::class, 'update'])->name('referensi.jabatan-update');
    Route::delete('/referensi/jabatan/{id}/delete', [App\Http\Controllers\Referensi\JabatanController::class, 'destroy'])->name('referensi.jabatan-destroy');
    Route::post('/referensi/jabatan/{id}/restore', [App\Http\Controllers\Referensi\JabatanController::class, 'restore'])->name('referensi.jabatan-restore');
    
    Route::get('/referensi/role', [App\Http\Controllers\Referensi\RoleController::class, 'index'])->name('referensi.role-index');
    Route::get('/referensi/role/trashed', [App\Http\Controllers\Referensi\RoleController::class, 'trash'])->name('referensi.role-trash');
    Route::post('/referensi/role', [App\Http\Controllers\Referensi\RoleController::class, 'store'])->name('referensi.role-store');
    Route::patch('/referensi/role/{id}/update', [App\Http\Controllers\Referensi\RoleController::class, 'update'])->name('referensi.role-update');
    Route::delete('/referensi/role/{id}/delete', [App\Http\Controllers\Referensi\RoleController::class, 'destroy'])->name('referensi.role-destroy');
    Route::post('/referensi/role/{id}/restore', [App\Http\Controllers\Referensi\RoleController::class, 'restore'])->name('referensi.role-restore');
    
    Route::get('/referensi/alamat', [App\Http\Controllers\Referensi\AlamatController::class, 'index'])->name('referensi.alamat-index');
    Route::get('/referensi/alamat/trashed', [App\Http\Controllers\Referensi\AlamatController::class, 'trash'])->name('referensi.alamat-trash');
    Route::post('/referensi/alamat', [App\Http\Controllers\Referensi\AlamatController::class, 'store'])->name('referensi.alamat-store');
    Route::patch('/referensi/alamat/{id}/update', [App\Http\Controllers\Referensi\AlamatController::class, 'update'])->name('referensi.alamat-update');
    Route::delete('/referensi/alamat/{id}/delete', [App\Http\Controllers\Referensi\AlamatController::class, 'destroy'])->name('referensi.alamat-destroy');
    Route::post('/referensi/alamat/{id}/restore', [App\Http\Controllers\Referensi\AlamatController::class, 'restore'])->name('referensi.alamat-restore');
    
    Route::get('/referensi/keluarga', [App\Http\Controllers\Referensi\KeluargaController::class, 'index'])->name('referensi.keluarga-index');
    Route::get('/referensi/keluarga/trashed', [App\Http\Controllers\Referensi\KeluargaController::class, 'trash'])->name('referensi.keluarga-trash');
    Route::post('/referensi/keluarga', [App\Http\Controllers\Referensi\KeluargaController::class, 'store'])->name('referensi.keluarga-store');
    Route::patch('/referensi/keluarga/{id}/update', [App\Http\Controllers\Referensi\KeluargaController::class, 'update'])->name('referensi.keluarga-update');
    Route::delete('/referensi/keluarga/{id}/delete', [App\Http\Controllers\Referensi\KeluargaController::class, 'destroy'])->name('referensi.keluarga-destroy');
    Route::post('/referensi/keluarga/{id}/restore', [App\Http\Controllers\Referensi\KeluargaController::class, 'restore'])->name('referensi.keluarga-restore');
    
    Route::get('/referensi/pendidikan', [App\Http\Controllers\Referensi\PendidikanController::class, 'index'])->name('referensi.pendidikan-index');
    Route::get('/referensi/pendidikan/trashed', [App\Http\Controllers\Referensi\PendidikanController::class, 'trash'])->name('referensi.pendidikan-trash');
    Route::post('/referensi/pendidikan', [App\Http\Controllers\Referensi\PendidikanController::class, 'store'])->name('referensi.pendidikan-store');
    Route::patch('/referensi/pendidikan/{id}/update', [App\Http\Controllers\Referensi\PendidikanController::class, 'update'])->name('referensi.pendidikan-update');
    Route::delete('/referensi/pendidikan/{id}/delete', [App\Http\Controllers\Referensi\PendidikanController::class, 'destroy'])->name('referensi.pendidikan-destroy');
    Route::post('/referensi/pendidikan/{id}/restore', [App\Http\Controllers\Referensi\PendidikanController::class, 'restore'])->name('referensi.pendidikan-restore');
    
    // Infra Routes
    Route::get('/infra/gedung', [App\Http\Controllers\Master\Infra\GedungController::class, 'index'])->name('infra.gedung-index');
    Route::get('/infra/gedung/trashed', [App\Http\Controllers\Master\Infra\GedungController::class, 'trash'])->name('infra.gedung-trash');
    Route::post('/infra/gedung', [App\Http\Controllers\Master\Infra\GedungController::class, 'store'])->name('infra.gedung-store');
    Route::patch('/infra/gedung/{id}/update', [App\Http\Controllers\Master\Infra\GedungController::class, 'update'])->name('infra.gedung-update');
    Route::delete('/infra/gedung/{id}/delete', [App\Http\Controllers\Master\Infra\GedungController::class, 'destroy'])->name('infra.gedung-destroy');
    Route::post('/infra/gedung/{id}/restore', [App\Http\Controllers\Master\Infra\GedungController::class, 'restore'])->name('infra.gedung-restore');
    
    Route::get('/infra/ruangan', [App\Http\Controllers\Master\Infra\RuanganController::class, 'index'])->name('infra.ruangan-index');
    Route::get('/infra/ruangan/trashed', [App\Http\Controllers\Master\Infra\RuanganController::class, 'trash'])->name('infra.ruangan-trash');
    Route::post('/infra/ruangan', [App\Http\Controllers\Master\Infra\RuanganController::class, 'store'])->name('infra.ruangan-store');
    Route::patch('/infra/ruangan/{id}/update', [App\Http\Controllers\Master\Infra\RuanganController::class, 'update'])->name('infra.ruangan-update');
    Route::delete('/infra/ruangan/{id}/delete', [App\Http\Controllers\Master\Infra\RuanganController::class, 'destroy'])->name('infra.ruangan-destroy');
    Route::post('/infra/ruangan/{id}/restore', [App\Http\Controllers\Master\Infra\RuanganController::class, 'restore'])->name('infra.ruangan-restore');
    
    // Inventaris Routes
    Route::get('/inventaris/kategori-barang', [App\Http\Controllers\Master\Inventaris\KategoriBarangController::class, 'index'])->name('inventaris.kategori-barang-index');
    Route::get('/inventaris/kategori-barang/trashed', [App\Http\Controllers\Master\Inventaris\KategoriBarangController::class, 'trash'])->name('inventaris.kategori-barang-trash');
    Route::post('/inventaris/kategori-barang', [App\Http\Controllers\Master\Inventaris\KategoriBarangController::class, 'store'])->name('inventaris.kategori-barang-store');
    Route::patch('/inventaris/kategori-barang/{id}/update', [App\Http\Controllers\Master\Inventaris\KategoriBarangController::class, 'update'])->name('inventaris.kategori-barang-update');
    Route::delete('/inventaris/kategori-barang/{id}/delete', [App\Http\Controllers\Master\Inventaris\KategoriBarangController::class, 'destroy'])->name('inventaris.kategori-barang-destroy');
    Route::post('/inventaris/kategori-barang/{id}/restore', [App\Http\Controllers\Master\Inventaris\KategoriBarangController::class, 'restore'])->name('inventaris.kategori-barang-restore');
    
    Route::get('/inventaris/barang', [App\Http\Controllers\Master\Inventaris\BarangController::class, 'index'])->name('inventaris.barang-index');
    Route::get('/inventaris/barang/trashed', [App\Http\Controllers\Master\Inventaris\BarangController::class, 'trash'])->name('inventaris.barang-trash');
    Route::post('/inventaris/barang', [App\Http\Controllers\Master\Inventaris\BarangController::class, 'store'])->name('inventaris.barang-store');
    Route::patch('/inventaris/barang/{id}/update', [App\Http\Controllers\Master\Inventaris\BarangController::class, 'update'])->name('inventaris.barang-update');
    Route::delete('/inventaris/barang/{id}/delete', [App\Http\Controllers\Master\Inventaris\BarangController::class, 'destroy'])->name('inventaris.barang-destroy');
    Route::post('/inventaris/barang/{id}/restore', [App\Http\Controllers\Master\Inventaris\BarangController::class, 'restore'])->name('inventaris.barang-restore');
    
    Route::get('/inventaris/barang-inventaris', [App\Http\Controllers\Master\Inventaris\BarangInventarisController::class, 'index'])->name('inventaris.barang-inventaris-index');
    Route::get('/inventaris/barang-inventaris/trashed', [App\Http\Controllers\Master\Inventaris\BarangInventarisController::class, 'trash'])->name('inventaris.barang-inventaris-trash');
    Route::post('/inventaris/barang-inventaris', [App\Http\Controllers\Master\Inventaris\BarangInventarisController::class, 'store'])->name('inventaris.barang-inventaris-store');
    Route::patch('/inventaris/barang-inventaris/{id}/update', [App\Http\Controllers\Master\Inventaris\BarangInventarisController::class, 'update'])->name('inventaris.barang-inventaris-update');
    Route::delete('/inventaris/barang-inventaris/{id}/delete', [App\Http\Controllers\Master\Inventaris\BarangInventarisController::class, 'destroy'])->name('inventaris.barang-inventaris-destroy');
    Route::post('/inventaris/barang-inventaris/{id}/restore', [App\Http\Controllers\Master\Inventaris\BarangInventarisController::class, 'restore'])->name('inventaris.barang-inventaris-restore');
        // Transaksi Barang Routes
    // Peminjaman Barang
    Route::get('/transaksi-barang/peminjaman', [App\Http\Controllers\Master\Transaksi\PeminjamanBarangController::class, 'index'])->name('transaksi-barang.peminjaman-index');
    Route::get('/transaksi-barang/peminjaman/trashed', [App\Http\Controllers\Master\Transaksi\PeminjamanBarangController::class, 'trash'])->name('transaksi-barang.peminjaman-trash');
    Route::post('/transaksi-barang/peminjaman', [App\Http\Controllers\Master\Transaksi\PeminjamanBarangController::class, 'store'])->name('transaksi-barang.peminjaman-store');
    Route::patch('/transaksi-barang/peminjaman/{id}/update', [App\Http\Controllers\Master\Transaksi\PeminjamanBarangController::class, 'update'])->name('transaksi-barang.peminjaman-update');
    Route::delete('/transaksi-barang/peminjaman/{id}/delete', [App\Http\Controllers\Master\Transaksi\PeminjamanBarangController::class, 'destroy'])->name('transaksi-barang.peminjaman-destroy');
    Route::post('/transaksi-barang/peminjaman/{id}/restore', [App\Http\Controllers\Master\Transaksi\PeminjamanBarangController::class, 'restore'])->name('transaksi-barang.peminjaman-restore');

    // Pengecekan Barang
    Route::get('/transaksi-barang/pengecekan', [App\Http\Controllers\Master\Transaksi\PengecekanBarangController::class, 'index'])->name('transaksi-barang.pengecekan-index');
    Route::get('/transaksi-barang/pengecekan/trashed', [App\Http\Controllers\Master\Transaksi\PengecekanBarangController::class, 'trash'])->name('transaksi-barang.pengecekan-trash');
    Route::post('/transaksi-barang/pengecekan', [App\Http\Controllers\Master\Transaksi\PengecekanBarangController::class, 'store'])->name('transaksi-barang.pengecekan-store');
    Route::patch('/transaksi-barang/pengecekan/{id}/update', [App\Http\Controllers\Master\Transaksi\PengecekanBarangController::class, 'update'])->name('transaksi-barang.pengecekan-update');
    Route::delete('/transaksi-barang/pengecekan/{id}/delete', [App\Http\Controllers\Master\Transaksi\PengecekanBarangController::class, 'destroy'])->name('transaksi-barang.pengecekan-destroy');
    Route::post('/transaksi-barang/pengecekan/{id}/restore', [App\Http\Controllers\Master\Transaksi\PengecekanBarangController::class, 'restore'])->name('transaksi-barang.pengecekan-restore');

    // Pengajuan Perbaikan
    Route::get('/transaksi-barang/pengajuan', [App\Http\Controllers\Master\Transaksi\PengajuanPerbaikanController::class, 'index'])->name('transaksi-barang.pengajuan-index');
    Route::get('/transaksi-barang/pengajuan/trashed', [App\Http\Controllers\Master\Transaksi\PengajuanPerbaikanController::class, 'trash'])->name('transaksi-barang.pengajuan-trash');
    Route::post('/transaksi-barang/pengajuan', [App\Http\Controllers\Master\Transaksi\PengajuanPerbaikanController::class, 'store'])->name('transaksi-barang.pengajuan-store');
    Route::patch('/transaksi-barang/pengajuan/{id}/update', [App\Http\Controllers\Master\Transaksi\PengajuanPerbaikanController::class, 'update'])->name('transaksi-barang.pengajuan-update');
    Route::delete('/transaksi-barang/pengajuan/{id}/delete', [App\Http\Controllers\Master\Transaksi\PengajuanPerbaikanController::class, 'destroy'])->name('transaksi-barang.pengajuan-destroy');
    Route::post('/transaksi-barang/pengajuan/{id}/restore', [App\Http\Controllers\Master\Transaksi\PengajuanPerbaikanController::class, 'restore'])->name('transaksi-barang.pengajuan-restore');

    // Riwayat Perbaikan
    Route::get('/transaksi-barang/riwayat', [App\Http\Controllers\Master\Transaksi\RiwayatPerbaikanController::class, 'index'])->name('transaksi-barang.riwayat-index');
    Route::get('/transaksi-barang/riwayat/trashed', [App\Http\Controllers\Master\Transaksi\RiwayatPerbaikanController::class, 'trash'])->name('transaksi-barang.riwayat-trash');
    Route::post('/transaksi-barang/riwayat', [App\Http\Controllers\Master\Transaksi\RiwayatPerbaikanController::class, 'store'])->name('transaksi-barang.riwayat-store');
    Route::patch('/transaksi-barang/riwayat/{id}/update', [App\Http\Controllers\Master\Transaksi\RiwayatPerbaikanController::class, 'update'])->name('transaksi-barang.riwayat-update');
    Route::delete('/transaksi-barang/riwayat/{id}/delete', [App\Http\Controllers\Master\Transaksi\RiwayatPerbaikanController::class, 'destroy'])->name('transaksi-barang.riwayat-destroy');
    Route::post('/transaksi-barang/riwayat/{id}/restore', [App\Http\Controllers\Master\Transaksi\RiwayatPerbaikanController::class, 'restore'])->name('transaksi-barang.riwayat-restore');

});

// Route::group(['prefix' => 'superuser', 'middleware' => ['auth:web','role:Super Admin'], 'as' => 'super.'],function(){

//     // Global Route
//     require __DIR__.'/basic-routes.php';

//     // Master Authority
//     require __DIR__.'/master-routes.php';

// });

