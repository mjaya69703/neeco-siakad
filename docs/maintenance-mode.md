# Maintenance Mode - Neco Siakad

Dokumentasi ini menjelaskan cara menggunakan fitur maintenance mode pada aplikasi Neco Siakad.

## Tentang Maintenance Mode

Maintenance mode memungkinkan administrator untuk menonaktifkan akses ke aplikasi sementara saat melakukan pemeliharaan, upgrade, atau perbaikan sistem. Ketika mode ini aktif:

- Pengguna biasa akan melihat halaman maintenance yang informatif
- Administrator tetap dapat mengakses aplikasi (bypass maintenance mode)

## Cara Mengaktifkan/Menonaktifkan Maintenance Mode

### Melalui Panel Admin

1. Login sebagai administrator
2. Buka menu **Pengaturan**
3. Pilih tab **Keamanan**
4. Aktifkan/nonaktifkan toggle **Mode Maintenance**
5. Klik tombol **Simpan**

### Melalui Command Line

Aplikasi menyediakan dua command Artisan untuk mengelola maintenance mode:

#### 1. Command Database

Command ini mengubah status maintenance mode di database:

```bash
# Mengaktifkan maintenance mode
php artisan app:maintenance on

# Menonaktifkan maintenance mode
php artisan app:maintenance off
```

#### 2. Command File Laravel

Command ini mengubah status maintenance mode di database dan juga membuat/menghapus file maintenance Laravel standar:

```bash
# Mengaktifkan maintenance mode
php artisan app:maintenance-mode on

# Menonaktifkan maintenance mode
php artisan app:maintenance-mode off
```

## Cara Kerja Maintenance Mode

Aplikasi menggunakan tiga mekanisme untuk maintenance mode:

1. **Middleware** - `CheckForMaintenanceMode` yang memeriksa status di database dan mengarahkan pengguna non-admin ke halaman maintenance
2. **File Maintenance** - File `storage/framework/maintenance.php` yang dijalankan sebelum aplikasi dimuat dan memeriksa keberadaan file `storage/framework/down`
3. **File Down** - File `storage/framework/down` yang dibuat oleh command `app:maintenance-mode on` sebagai penanda mode maintenance aktif
4. **Kode Akses** - Kode unik yang dihasilkan saat mengaktifkan maintenance mode, memungkinkan akses ke aplikasi selama mode maintenance aktif

## Menggunakan Kode Akses

Saat mode maintenance diaktifkan melalui command line, sistem akan menghasilkan kode akses unik yang dapat digunakan untuk mengakses aplikasi selama mode maintenance aktif.

### Mendapatkan Kode Akses

Kode akses akan ditampilkan di terminal saat mengaktifkan maintenance mode dengan command:

```bash
php artisan app:maintenance-mode on
```

Output akan menampilkan kode akses seperti ini:

```
Mode maintenance berhasil diaktifkan.

KODE AKSES MAINTENANCE: A1B2C3D4
Gunakan kode ini untuk mengakses website selama mode maintenance aktif.
```

Kode akses juga dicatat dalam log Laravel (`storage/logs/laravel.log`) untuk referensi di masa mendatang.

### Menggunakan Kode Akses

Ada dua cara untuk menggunakan kode akses:

1. **Melalui Form di Halaman Maintenance**:
   - Buka halaman maintenance
   - Masukkan kode akses pada form yang tersedia
   - Klik tombol "Akses"

2. **Melalui Parameter URL**:
   - Tambahkan parameter `?access_code=KODE_AKSES` pada URL aplikasi
   - Contoh: `https://example.com/?access_code=A1B2C3D4`

Setelah menggunakan kode akses yang valid, browser akan menyimpan cookie yang memungkinkan akses ke aplikasi selama 24 jam tanpa perlu memasukkan kode akses lagi.

## Kustomisasi Halaman Maintenance

Halaman maintenance dapat dikustomisasi dengan mengedit file view:

```
resources/views/errors/maintenance.blade.php
```

Halaman ini menampilkan:
- Logo aplikasi
- Pesan maintenance
- Form kode akses
- Informasi copyright

## Troubleshooting

### Terjebak di Mode Maintenance

Jika Anda terjebak di mode maintenance dan tidak dapat mengakses panel admin:

1. Gunakan command line untuk menonaktifkan maintenance mode:
   ```bash
   php artisan app:maintenance off
   # atau
   php artisan app:maintenance-mode off
   ```

2. Atau hapus file maintenance secara manual:
   ```bash
   # Di Windows
   del storage\framework\down
   
   # Di Linux/Mac
   rm storage/framework/down
   ```

3. Atau ubah status di database secara langsung:
   ```sql
   UPDATE systems SET maintenance_mode = 0 WHERE id = 1;
   ```

4. Atau gunakan kode akses yang dihasilkan saat mengaktifkan maintenance mode:
   - Tambahkan parameter `?access_code=KODE_AKSES` pada URL aplikasi
   - Contoh: `https://example.com/?access_code=A1B2C3D4`

### Lupa Kode Akses

Jika Anda lupa kode akses yang dihasilkan saat mengaktifkan maintenance mode:

1. Periksa log Laravel untuk menemukan kode akses:
   ```bash
   # Di Windows
   type storage\logs\laravel.log | findstr "KODE AKSES MAINTENANCE"
   
   # Di Linux/Mac
   grep "KODE AKSES MAINTENANCE" storage/logs/laravel.log
   ```

2. Atau periksa isi file `storage/framework/down` untuk mendapatkan kode akses:
   ```bash
   # Di Windows
   type storage\framework\down
   
   # Di Linux/Mac
   cat storage/framework/down
   ```
   Kode akses tersimpan dalam file JSON dengan key `secret`.

### Error Class Not Found

Jika Anda mendapatkan error `Class "App\Models\Pengaturan\System" not found` saat mengakses aplikasi:

1. Hapus file `storage/framework/maintenance.php` dan gunakan command `app:maintenance-mode` sebagai gantinya:
   ```bash
   # Di Windows
   del storage\framework\maintenance.php
   
   # Di Linux/Mac
   rm storage/framework/maintenance.php
   ```

2. Atau pastikan file `storage/framework/down` ada jika ingin mengaktifkan maintenance mode:
   ```bash
   php artisan app:maintenance-mode on
   ```