@extends('themes.core-frontpage')
@section('custom-css')
<style>
/* ====== Landing Page (scoped) ====== */
html, body { height: 100%; }
.lp { --lp-grad: linear-gradient(135deg,#0ea5e9 0%,#3b82f6 45%,#7c3aed 100%); overflow-x:hidden; min-height:100%; display:flex; flex-direction:column; }
.lp-hero{position:relative;overflow:hidden;border-radius:1rem;background:#0b1220;color:#fff;contain:paint}
.lp-hero::before{content:"";position:absolute;inset:0;background:var(--lp-grad);opacity:.15}
.lp-blob{position:absolute;inset:-20% -10% auto auto;width:60vw;max-width:920px;filter:blur(40px);opacity:.35;
  background:radial-gradient(closest-side,rgba(59,130,246,.85),transparent 70%),
             radial-gradient(closest-side,rgba(16,185,129,.65),transparent 70%),
             radial-gradient(closest-side,rgba(124,58,237,.7),transparent 70%)}
.lp-chip{display:inline-flex;align-items:center;gap:.5rem;padding:.4rem .7rem;border-radius:9999px;background:rgba(255,255,255,.16);backdrop-filter:blur(6px)}
.lp-hero h1{letter-spacing:.2px}
.lp-divider{height:2px;background:linear-gradient(90deg,transparent,#3b82f6,#22c55e,#a855f7,transparent)}
.lp-kpi .card{transition:transform .25s ease, box-shadow .25s ease}
.lp-kpi .card:hover{transform:translateY(-6px);box-shadow:0 16px 32px rgba(0,0,0,.18)}
.lp-feature .card{height:100%}
.lp-program .card{transition:transform .2s ease}
.lp-program .card:hover{transform:translateY(-4px)}
.lp-logo img{filter:grayscale(1);opacity:.8;transition:.2s}
.lp-logo img:hover{filter:none;opacity:1}
.lp-badge{font-size:.725rem}
/* helpers & overflow safety */
.text-white-70{color:rgba(255,255,255,.7)!important}
.btn-outline-white{--tblr-btn-color:#fff;--tblr-btn-border-color:rgba(255,255,255,.7)}
.lp [class^='col-'], .lp [class*=' col-']{min-width:0}
.lp img{max-width:100%;height:auto}
.lp .card, .lp .carousel, .lp .btn-list{min-width:0}
.lp .card-title, .lp .text-secondary{word-wrap:break-word}
</style>
@endsection

@section('content')
<div class="lp">
  <!-- HERO -->
  <section class="container-xl lp-hero mt-3 p-4 p-md-5">
    <div class="lp-blob"></div>
    <div class="row align-items-center g-4 position-relative" style="z-index:1">
      <div class="col-lg-7">
        <div class="lp-chip mb-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke="none" d="M0 0h24v24H0z"/><path d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4"/></svg>
          <span>SIAKAD Terpadu • Cepat • Aman</span>
        </div>
        <h1 class="display-5 fw-bold mb-2">Portal Akademik {{ config('app.name','Cakrawala University') }}</h1>
        <p class="lead text-white-70 mb-3">PMB, KRS/KHS, UKT, Presensi, Skripsi, dan Wisuda dalam satu ekosistem terintegrasi.</p>
        <div class="d-flex flex-wrap gap-2 mb-4">
          <a href="{{ url('/siakad') }}" class="btn btn-white">Masuk SIAKAD</a>
          <a href="#program" class="btn btn-white">Lihat Program Studi</a>
          <a href="{{ url('/pmb') }}" class="btn btn-success">Daftar PMB</a>
        </div>
        <div class="card bg-white/75">
          <div class="card-body">
            <form action="{{ url('/siakad/tracking') }}" method="get" class="row g-2 align-items-end">
              <div class="col-md">
                <label class="form-label">Cek Status Pendaftaran / NIM</label>
                <input type="text" name="q" class="form-control" placeholder="Masukkan No. Pendaftaran atau NIM">
              </div>
              <div class="col-auto">
                <button class="btn btn-primary">Cek Status</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-5">
        <div id="heroCarousel" class="carousel slide card shadow-sm" data-bs-ride="carousel" data-bs-interval="5000">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?q=80&w=1600&auto=format&fit=crop" class="d-block w-100" alt="Kampus">
              <div class="card-body">
                <div class="subheader">Pengumuman</div>
                <div class="text-secondary">KRS Genap 2025 dibuka. UKT dapat dicicil online.</div>
              </div>
            </div>
            <div class="carousel-item">
              <img src="https://images.unsplash.com/photo-1532614338840-ab30cf10ed36?q=80&w=1600&auto=format&fit=crop" class="d-block w-100" alt="Perpustakaan">
              <div class="card-body">
                <div class="subheader">Fasilitas</div>
                <div class="text-secondary">Perpustakaan digital, coworking, dan lab modern.</div>
              </div>
            </div>
            <div class="carousel-item">
              <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?q=80&w=1600&auto=format&fit=crop" class="d-block w-100" alt="Karier">
              <div class="card-body">
                <div class="subheader">Karier</div>
                <div class="text-secondary">Career center & jejaring alumni aktif.</div>
              </div>
            </div>
          </div>
          <div class="card-footer d-flex justify-content-between">
            <button class="btn btn-link p-0" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">←</button>
            <button class="btn btn-link p-0" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">→</button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="container-xl"><div class="lp-divider my-4"></div></div>

  <!-- KPI -->
  <section class="container-xl lp-kpi mb-4">
    <div class="row g-3">
      <div class="col-6 col-md-3">
        <div class="card card-sm text-center">
          <div class="card-body">
            <div class="h2 counter" data-target="98">0</div>
            <div class="text-secondary">Kepuasan*</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card card-sm text-center">
          <div class="card-body">
            <div class="h2 counter" data-target="12000">0</div>
            <div class="text-secondary">Mahasiswa</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card card-sm text-center">
          <div class="card-body">
            <div class="h2 counter" data-target="150">0</div>
            <div class="text-secondary">Dosen</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card card-sm text-center">
          <div class="card-body">
            <div class="h2 counter" data-target="35">0</div>
            <div class="text-secondary">Prodi</div>
          </div>
        </div>
      </div>
    </div>
    <div class="text-secondary small mt-1">*Data sampel untuk tampilan.</div>
  </section>

  <!-- FITUR SIAKAD -->
  <section class="container-xl lp-feature mb-5">
    <div class="row row-deck">
      <div class="col-sm-6 col-lg-3">
        <div class="card h-100">
          <div class="ribbon bg-green">Realtime</div>
          <div class="card-body">
            <div class="card-title">KRS & KHS</div>
            <div class="text-secondary">Pilih mata kuliah, nilai update otomatis.</div>
            <a class="btn btn-link p-0" href="{{ url('/siakad/krs') }}">Buka KRS</a>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="card h-100">
          <div class="ribbon bg-azure">Terintegrasi</div>
          <div class="card-body">
            <div class="card-title">Pembayaran UKT</div>
            <div class="text-secondary">VA/E‑Wallet, rekonsiliasi otomatis.</div>
            <a class="btn btn-link p-0" href="{{ url('/siakad/ukt') }}">Lihat Tagihan</a>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="card h-100">
          <div class="ribbon bg-purple">Mobile</div>
          <div class="card-body">
            <div class="card-title">Presensi & Jadwal</div>
            <div class="text-secondary">QR presensi & kalender kuliah.</div>
            <a class="btn btn-link p-0" href="{{ url('/siakad/jadwal') }}">Lihat Jadwal</a>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="card h-100">
          <div class="ribbon bg-orange">Online</div>
          <div class="card-body">
            <div class="card-title">Wisuda & SKPI</div>
            <div class="text-secondary">Pengajuan online, tracking progres.</div>
            <a class="btn btn-link p-0" href="{{ url('/siakad/wisuda') }}">Ajukan</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick shortcuts -->
    <div class="row g-3 mt-1">
      <div class="col-md-3"><a class="btn w-100" href="{{ url('/siakad/transkrip') }}">Unduh Transkrip</a></div>
      <div class="col-md-3"><a class="btn w-100" href="{{ url('/siakad/kartu-mahasiswa') }}">Kartu Mahasiswa</a></div>
      <div class="col-md-3"><a class="btn w-100" href="{{ url('/siakad/beasiswa') }}">Beasiswa</a></div>
      <div class="col-md-3"><a class="btn w-100" href="{{ url('/siakad/bantuan') }}">Pusat Bantuan</a></div>
    </div>

    <!-- PMB Steps -->
    <div class="card mt-4">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <div class="subheader">Alur PMB (Contoh)</div>
            <h3 class="card-title mb-0">Dari Daftar hingga Registrasi Ulang</h3>
          </div>
          <a href="{{ url('/pmb') }}" class="btn btn-primary">Mulai Daftar</a>
        </div>
        <div class="steps steps-vertical steps-counter">
          <div class="step-item"><div class="step-item-icon">1</div><div class="step-item-content"><div class="step-item-title">Buat Akun PMB</div><div class="text-secondary">Lengkapi biodata</div></div></div>
          <div class="step-item"><div class="step-item-icon">2</div><div class="step-item-content"><div class="step-item-title">Unggah Berkas</div><div class="text-secondary">Ijazah, foto, dokumen</div></div></div>
          <div class="step-item"><div class="step-item-icon">3</div><div class="step-item-content"><div class="step-item-title">Ujian / Wawancara</div><div class="text-secondary">Jadwal otomatis</div></div></div>
          <div class="step-item"><div class="step-item-icon">4</div><div class="step-item-content"><div class="step-item-title">Pengumuman</div><div class="text-secondary">Daftar ulang online</div></div></div>
        </div>
      </div>
    </div>
  </section>

  <!-- PROGRAM STUDI -->
  <section id="program" class="container-xl lp-program mb-5">
    <div class="row align-items-center mb-3 g-2">
      <div class="col"><h2 class="mb-0">Program Studi</h2><div class="text-secondary">Filter kategori untuk eksplor cepat.</div></div>
      <div class="col-auto">
        <div class="btn-list">
          <button class="btn btn-outline-primary lp-filter active" data-filter="all">Semua</button>
          <button class="btn btn-outline-primary lp-filter" data-filter="teknik">Teknik/IT</button>
          <button class="btn btn-outline-primary lp-filter" data-filter="bisnis">Bisnis</button>
          <button class="btn btn-outline-primary lp-filter" data-filter="desain">Desain</button>
        </div>
      </div>
    </div>
    @php
      $programs = [
        ['name'=>'Informatika','cat'=>'teknik','desc'=>'AI, Data Science, Software Engineering','img'=>'https://images.unsplash.com/photo-1555066931-4365d14bab8c?q=80&w=1600&auto=format&fit=crop'],
        ['name'=>'Sistem Informasi','cat'=>'teknik','desc'=>'Bisnis Digital, ERP, UI/UX','img'=>'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?q=80&w=1600&auto=format&fit=crop'],
        ['name'=>'Manajemen','cat'=>'bisnis','desc'=>'Kewirausahaan, Keuangan, Pemasaran','img'=>'https://images.unsplash.com/photo-1542744095-291d1f67b221?q=80&w=1600&auto=format&fit=crop'],
        ['name'=>'Akuntansi','cat'=>'bisnis','desc'=>'Audit, Perpajakan, Akuntansi Publik','img'=>'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?q=80&w=1600&auto=format&fit=crop'],
        ['name'=>'Desain Komunikasi Visual','cat'=>'desain','desc'=>'Branding, Motion, Ilustrasi','img'=>'https://images.unsplash.com/photo-1498050108023-c5249f4df085?q=80&w=1600&auto=format&fit=crop']
      ];
    @endphp
    <div class="row row-deck" id="lp-program-list">
      @foreach($programs as $p)
        <div class="col-sm-6 mt-3 col-lg-4 lp-program-item" data-cat="{{ $p['cat'] }}">
          <div class="card h-100 card-link">
            <img src="{{ $p['img'] }}" class="card-img-top" alt="{{ $p['name'] }}">
            <div class="card-body">
              <span class="badge lp-badge mb-2">{{ ucfirst($p['cat']) }}</span>
              <h3 class="card-title">{{ $p['name'] }}</h3>
              <div class="text-secondary">{{ $p['desc'] }}</div>
              <div class="d-flex justify-content-between align-items-center mt-3">
                <a class="btn btn-link p-0" href="{{ url('/prodi/'.Str::slug($p['name'])) }}">Kurikulum</a>
                <a class="btn" href="{{ url('/siakad/pendaftaran?prodi='.urlencode($p['name'])) }}">Daftar</a>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </section>

  <!-- BERITA + FAQ + TESTIMONI -->
  <section class="container-xl mb-5">
    <div class="row g-4">
      <div class="col-lg-7">
        <h2 class="mb-3">Pengumuman & Agenda</h2>
        @php
          $ann = [
            ['title'=>'Pembukaan KRS Semester Genap 2025','date'=>'10 Agustus 2025','img'=>'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=1600&auto=format&fit=crop'],
            ['title'=>'Beasiswa Prestasi Gelombang 2','date'=>'20 Agustus 2025','img'=>'https://images.unsplash.com/photo-1513258496099-48168024aec0?q=80&w=1600&auto=format&fit=crop'],
            ['title'=>'Job Fair Kampus X Industri','date'=>'5 September 2025','img'=>'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?q=80&w=1600&auto=format&fit=crop']
          ];
        @endphp
        <div class="row row-deck">
          @foreach($ann as $a)
          <div class="col-md-6 mt-3">
            <div class="card h-100">
              <img src="{{ $a['img'] }}" class="card-img-top" alt="{{ $a['title'] }}">
              <div class="card-body">
                <div class="text-secondary small">{{ $a['date'] }}</div>
                <h3 class="card-title">{{ $a['title'] }}</h3>
                <a href="{{ url('/berita/'.Str::slug($a['title'])) }}" class="btn btn-link p-0">Baca selengkapnya</a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      <div class="col-lg-5">
        <h2 class="mb-3">Testimoni</h2>
        <div id="testiCarousel" class="carousel slide card" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="card-body">
                <figure>
                  <blockquote class="blockquote">“Kurikulum relevan industri, proses akademik dari KRS sampai wisuda lancar.”</blockquote>
                  <figcaption class="blockquote-footer">Alya — UI/UX Designer</figcaption>
                </figure>
              </div>
            </div>
            <div class="carousel-item"><div class="card-body"><figure><blockquote class="blockquote">“Integrasi UKT bikin administrasi simpel.”</blockquote><figcaption class="blockquote-footer">Bima — Data Engineer</figcaption></figure></div></div>
            <div class="carousel-item"><div class="card-body"><figure><blockquote class="blockquote">“Career center aktif, jaringan alumni kuat.”</blockquote><figcaption class="blockquote-footer">Sinta — Product Manager</figcaption></figure></div></div>
          </div>
          <div class="card-footer d-flex justify-content-between"><button class="btn btn-link p-0" type="button" data-bs-target="#testiCarousel" data-bs-slide="prev">←</button><button class="btn btn-link p-0" type="button" data-bs-target="#testiCarousel" data-bs-slide="next">→</button></div>
        </div>

        <div class="card mt-4">
          <div class="card-body">
            <h3 class="card-title">FAQ</h3>
            <div class="accordion" id="faq-acc">
              <div class="accordion-item">
                <h2 class="accordion-header" id="fq1"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#fq1c">Bagaimana cara daftar PMB?</button></h2>
                <div id="fq1c" class="accordion-collapse collapse show" data-bs-parent="#faq-acc"><div class="accordion-body">Klik "Daftar PMB", buat akun, lengkapi biodata, unggah berkas, ikuti jadwal ujian/wawancara.</div></div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="fq2"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#fq2c">Metode pembayaran UKT?</button></h2>
                <div id="fq2c" class="accordion-collapse collapse" data-bs-parent="#faq-acc"><div class="accordion-body">VA bank, e‑wallet, dan transfer — status otomatis di SIAKAD.</div></div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="fq3"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#fq3c">Ada beasiswa?</button></h2>
                <div id="fq3c" class="accordion-collapse collapse" data-bs-parent="#faq-acc"><div class="accordion-body">Ada jalur prestasi & bantuan finansial. Cek menu Beasiswa.</div></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Mitra & CTA -->
  <section class="container-xl mb-2">
    <div class="card">
      <div class="card-body">
        <div class="row align-items-center g-3">
          <div class="col-lg-3"><div class="subheader">Mitra & Akreditasi</div><div class="text-secondary">Logo contoh</div></div>
          <div class="col-lg-9">
            <div class="row g-3 logos">
              @foreach(range(1,6) as $i)
                <div class="col-4 col-md-2 lp-logo"><img src="https://dummyimage.com/200x80/efefef/aaa&text=Logo+{{ $i }}" class="img-fluid rounded" alt="Mitra {{ $i }}"></div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="bg-azure-lt rounded mt-4 p-4 p-md-5 d-flex align-items-center justify-content-between flex-wrap">
      <div class="pe-3">
        <h2 class="mb-1">Siap bergabung?</h2>
        <div class="text-secondary">Buat akun SIAKAD untuk memulai proses PMB & administrasi.</div>
      </div>
      <div class="d-flex gap-2 mt-3 mt-md-0">
        <a href="{{ url('/register') }}" class="btn btn-success">Buat Akun</a>
        <a href="{{ url('/login') }}" class="btn btn-outline">Masuk</a>
      </div>
    </div>
  </section>
</div>
@endsection

@section('custom-js')
<script>
// Smooth anchor
document.querySelectorAll("a[href^='#']").forEach(a=>{
  a.addEventListener('click',e=>{const id=a.getAttribute('href');if(id.length>1){e.preventDefault();const el=document.querySelector(id);if(el){window.scrollTo({top:el.getBoundingClientRect().top+window.pageYOffset-70,behavior:'smooth'});}}});
});
// Counter on visible
(function(){
  const els=document.querySelectorAll('.counter');
  const io=new IntersectionObserver(entries=>{
    entries.forEach(e=>{ if(!e.isIntersecting) return; const el=e.target; const to=+el.dataset.target; const st=performance.now(); const du=900; const fx=t=>{const p=Math.min(1,(t-st)/du); const v=Math.floor(to*p); el.textContent= to>=1000 ? v.toLocaleString() : v; if(p<1) requestAnimationFrame(fx)}; requestAnimationFrame(fx); io.unobserve(el); });
  },{threshold:.35});
  els.forEach(el=>io.observe(el));
})();
// Program filter
(function(){
  const btns=document.querySelectorAll('.lp-filter');
  const items=[...document.querySelectorAll('.lp-program-item')];
  btns.forEach(b=>b.addEventListener('click',()=>{
    btns.forEach(x=>x.classList.remove('active'));
    b.classList.add('active');
    const f=b.dataset.filter;
    items.forEach(it=>{ const show = f==='all' || it.dataset.cat===f; it.style.display= show ? '' : 'none'; });
  }));
})();
</script>
@endsection
