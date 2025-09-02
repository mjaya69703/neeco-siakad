<?php

namespace App\Http\Controllers;

// Use Systems
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
// Use Models
use App\Models\Pengaturan\Kampus;
use App\Models\Pengaturan\System;
use App\Models\Referensi\Agama;
use App\Models\Referensi\GolonganDarah;
use App\Models\Referensi\JenisKelamin;
use App\Models\Referensi\Kewarganegaraan;
use App\Models\Referensi\Jabatan;
use App\Models\Referensi\Semester;
use App\Models\Referensi\StatusMahasiswa;
use App\Models\Referensi\Role;
use App\Models\Referensi\Alamat;
use App\Models\Referensi\Pendidikan;
use App\Models\Referensi\Keluarga;
use App\Models\User;

// Use Infra Models
use App\Models\Infra\Gedung;
use App\Models\Infra\Ruangan;

// Use Inventaris Models
use App\Models\Inventaris\KategoriBarang;
use App\Models\Inventaris\Barang;
use App\Models\Inventaris\BarangInventaris;

// Use Transaksi Models
use App\Models\Transaksi\PeminjamanBarang;
use App\Models\Transaksi\PengecekanBarang;
use App\Models\Transaksi\PengajuanPerbaikan;
use App\Models\Transaksi\RiwayatPerbaikan;

// Use Perawatan Models
use App\Models\Perawatan\JadwalPemeliharaan;
use App\Models\Perawatan\HistoriPemeliharaan;


class RootController extends Controller
{
    public function renderHomePage()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = null;
        $data['pages'] = "HomePage";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();

        return view('default-content', $data, compact('user'));
    }

    public function indexReferensi()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = null;
        $data['pages'] = "Dashboard Referensi";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();

        // Get reference data counts and statistics
        $data['stats'] = [
            'agama' => Agama::count(),
            'golongan_darah' => GolonganDarah::count(),
            'jenis_kelamin' => JenisKelamin::count(),
            'kewarganegaraan' => Kewarganegaraan::count(),
            'jabatan' => Jabatan::count(),
            'semester' => Semester::count(),
            'status_mahasiswa' => StatusMahasiswa::count(),
            'role' => Role::count(),
            'alamat' => Alamat::count(),
            'pendidikan' => Pendidikan::count(),
            'keluarga' => Keluarga::count(),
            'total_users' => User::count()
        ];

        // Get sample data for each reference type
        $data['sample_data'] = [
            'agamas' => Agama::orderBy('name')->get(),
            'golongan_darahs' => GolonganDarah::orderBy('name')->get(),
            'jenis_kelamins' => JenisKelamin::orderBy('name')->get(),
            'kewarganegaraans' => Kewarganegaraan::orderBy('name')->get(),
            'jabatans' => Jabatan::orderBy('name')->get(),
            'semesters' => Semester::orderBy('name')->get(),
            'status_mahasiswas' => StatusMahasiswa::orderBy('name')->get(),
            'roles' => Role::orderBy('name')->get(),
        ];

        // Get recent activities (limited sample)
        $data['recent_alamats'] = Alamat::with('owner')
            ->latest()
            ->limit(5)
            ->get();
        
        $data['recent_pendidikans'] = Pendidikan::with('owner')
            ->latest()
            ->limit(5)
            ->get();
        
        $data['recent_keluargas'] = Keluarga::with('owner')
            ->latest()
            ->limit(5)
            ->get();

        // User distribution by reference data (only for models with proper relationships)
        $data['user_distribution'] = [
            'by_agama' => User::selectRaw('agama_id, count(*) as total')
                ->whereNotNull('agama_id')
                ->groupBy('agama_id')
                ->with('agama')
                ->get(),
            'by_jenis_kelamin' => User::selectRaw('jenis_kelamin_id, count(*) as total')
                ->whereNotNull('jenis_kelamin_id')
                ->groupBy('jenis_kelamin_id')
                ->with('jenisKelamin')
                ->get(),
            'by_golongan_darah' => User::selectRaw('golongan_darah_id, count(*) as total')
                ->whereNotNull('golongan_darah_id')
                ->groupBy('golongan_darah_id')
                ->with('golonganDarah')
                ->get(),
            'by_kewarganegaraan' => User::selectRaw('kewarganegaraan_id, count(*) as total')
                ->whereNotNull('kewarganegaraan_id')
                ->groupBy('kewarganegaraan_id')
                ->with('kewarganegaraan')
                ->get()
        ];

        return view('dashboard.dashboard-referensi', $data, compact('user'));
    }
    
    public function indexInfra()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = null;
        $data['pages'] = "Dashboard Infrastruktur & Inventaris";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();

        // Get counts for all modules
        $data['stats'] = [
            // Infrastruktur
            'gedung' => Gedung::count(),
            'ruangan' => Ruangan::count(),
            
            // Inventaris
            'kategori_barang' => KategoriBarang::count(),
            'barang' => Barang::count(),
            'barang_inventaris' => BarangInventaris::count(),
            
            // Transaksi
            'peminjaman_barang' => PeminjamanBarang::where('status', 'Dipinjam')->count(),
            'pengecekan_barang' => PengecekanBarang::count(),
            'pengajuan_perbaikan' => PengajuanPerbaikan::count(),
            
            // Perawatan
            'jadwal_pemeliharaan' => JadwalPemeliharaan::count(),
            'histori_pemeliharaan' => HistoriPemeliharaan::count(),
            
            // Calculated stats
            'total_biaya_perbaikan' => RiwayatPerbaikan::sum('biaya'),
            'rata_rata_kondisi_barang' => $this->calculateAverageCondition()
        ];

        // Get condition statistics
        $data['condition_stats'] = $this->getConditionStatistics();
        
        // Get annual statistics
        $data['annual_stats'] = $this->getAnnualStatistics();
        
        // Get monthly statistics
        $data['monthly_stats'] = $this->getMonthlyStatistics();

        // Get recent data for each module
        $data['recent_gedung'] = Gedung::with('ruangans')
            ->latest()
            ->limit(5)
            ->get();
            
        $data['recent_ruangan'] = Ruangan::with('gedung')
            ->latest()
            ->limit(5)
            ->get();
            
        $data['recent_barang_inventaris'] = BarangInventaris::with('barang')
            ->latest()
            ->limit(5)
            ->get();
            
        $data['kategori_barang'] = KategoriBarang::withCount('barangs')
            ->get();
            
        $data['recent_peminjaman'] = PeminjamanBarang::with(['barangInventaris.barang', 'peminjam'])
            ->latest()
            ->limit(5)
            ->get();
            
        $data['recent_pengajuan'] = PengajuanPerbaikan::with(['barangInventaris.barang', 'pengaju'])
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.dashboard-infra', $data, compact('user'));
    }
    
    private function calculateAverageCondition()
    {
        // Calculate average condition of barang inventaris
        $totalItems = BarangInventaris::count();
        if ($totalItems == 0) return 0;
        
        $conditionScores = [
            'Baik' => 100,
            'Rusak Ringan' => 70,
            'Rusak Berat' => 30
        ];
        
        $totalScore = 0;
        $countedItems = 0;
        
        // Get all barang inventaris and calculate average condition score
        $items = BarangInventaris::select('kondisi')->get();
        foreach ($items as $item) {
            if (isset($conditionScores[$item->kondisi])) {
                $totalScore += $conditionScores[$item->kondisi];
                $countedItems++;
            }
        }
        
        return $countedItems > 0 ? ($totalScore / $countedItems) : 0;
    }
    
    private function getConditionStatistics()
    {
        // Get count of items by condition
        $baik = BarangInventaris::where('kondisi', 'Baik')->count();
        $rusakRingan = BarangInventaris::where('kondisi', 'Rusak Ringan')->count();
        $rusakBerat = BarangInventaris::where('kondisi', 'Rusak Berat')->count();
        $total = $baik + $rusakRingan + $rusakBerat;
        
        return [
            'baik' => $baik,
            'rusak_ringan' => $rusakRingan,
            'rusak_berat' => $rusakBerat,
            'total' => $total
        ];
    }
    
    private function getAnnualStatistics()
    {
        // Get current year and last year
        $currentYear = Carbon::now()->year;
        $lastYear = $currentYear - 1;
        
        // Infrastruktur growth
        $gedungLastYear = Gedung::whereYear('created_at', $lastYear)->count();
        $gedungThisYear = Gedung::whereYear('created_at', $currentYear)->count();
        
        $ruanganLastYear = Ruangan::whereYear('created_at', $lastYear)->count();
        $ruanganThisYear = Ruangan::whereYear('created_at', $currentYear)->count();
        
        $infraLastYear = $gedungLastYear + $ruanganLastYear;
        $infraThisYear = $gedungThisYear + $ruanganThisYear;
        
        // Inventaris growth
        $barangLastYear = Barang::whereYear('created_at', $lastYear)->count();
        $barangThisYear = Barang::whereYear('created_at', $currentYear)->count();
        
        $inventarisLastYear = $barangLastYear;
        $inventarisThisYear = $barangThisYear;
        
        // Transaksi growth
        $peminjamanLastYear = PeminjamanBarang::whereYear('created_at', $lastYear)->count();
        $peminjamanThisYear = PeminjamanBarang::whereYear('created_at', $currentYear)->count();
        
        $transaksiLastYear = $peminjamanLastYear;
        $transaksiThisYear = $peminjamanThisYear;
        
        return [
            'gedung' => [
                'tahun_lalu' => $gedungLastYear,
                'tahun_ini' => $gedungThisYear
            ],
            'infrastruktur' => [
                'tahun_lalu' => $infraLastYear,
                'tahun_ini' => $infraThisYear
            ],
            'inventaris' => [
                'tahun_lalu' => $inventarisLastYear,
                'tahun_ini' => $inventarisThisYear
            ],
            'transaksi' => [
                'tahun_lalu' => $transaksiLastYear,
                'tahun_ini' => $transaksiThisYear
            ]
        ];
    }
    
    private function getMonthlyStatistics()
    {
        $currentYear = Carbon::now()->year;
        $monthlyData = [];
        
        // Initialize arrays for each category
        $infrastruktur = [];
        $inventaris = [];
        $transaksi = [];
        
        // Get data for each month (1-12)
        for ($month = 1; $month <= 12; $month++) {
            // Infrastruktur (Gedung + Ruangan)
            $gedungCount = Gedung::whereYear('created_at', $currentYear)
                                ->whereMonth('created_at', $month)
                                ->count();
            $ruanganCount = Ruangan::whereYear('created_at', $currentYear)
                                  ->whereMonth('created_at', $month)
                                  ->count();
            $infrastruktur[] = $gedungCount + $ruanganCount;
            
            // Inventaris (Barang)
            $barangCount = Barang::whereYear('created_at', $currentYear)
                                ->whereMonth('created_at', $month)
                                ->count();
            $inventaris[] = $barangCount;
            
            // Transaksi (Peminjaman)
            $transaksiCount = PeminjamanBarang::whereYear('created_at', $currentYear)
                                             ->whereMonth('created_at', $month)
                                             ->count();
            $transaksi[] = $transaksiCount;
        }
        
        return [
            'infrastruktur' => $infrastruktur,
            'inventaris' => $inventaris,
            'transaksi' => $transaksi
        ];
    }
}