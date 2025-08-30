<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $system->app_name }} - Maintenance Mode</title>
    <link rel="shortcut icon" href="{{ asset('storage/logo/' . $system->app_favicon) }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/tabler.min.css') }}">
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #f5576c);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            font-family: var(--tblr-font-sans-serif);
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        
        .maintenance-container {
            max-width: 650px;
            text-align: center;
            padding: 3rem 2.5rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: fadeInUp 0.8s ease-out;
            position: relative;
            overflow: hidden;
        }
        
        .maintenance-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shine 3s infinite;
            pointer-events: none;
        }
        
        @keyframes shine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }
        
        .header-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        
        .logo {
            max-width: 140px;
            margin-bottom: 1.5rem;
            animation: float 3s ease-in-out infinite;
            filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.1));
        }
        
        .maintenance-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            color: #667eea;
            animation: pulse 2s ease-in-out infinite;
        }
        
        h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            line-height: 1.2;
        }
        
        .subtitle {
            font-size: 1.1rem;
            color: #6c757d;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 0.45rem 1.2rem;
            background: linear-gradient(135deg, #ffecd2, #fcb69f);
            border-radius: 50px;
            font-weight: 600;
            margin-bottom: 0.5rem;
            box-shadow: 0 4px 15px rgba(252, 182, 159, 0.3);
            animation: pulse 2s ease-in-out infinite;
        }
        
        .status-badge svg {
            flex-shrink: 0;
            display: block;
            width: 18px;
            height: 18px;
            margin-top: 1px;
        }
        
        .status-badge span {
            line-height: 1.4;
            display: block;
            padding-top: 1px;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        
        .feature-card {
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .feature-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            color: #667eea;
        }
        
        .feature-title {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }
        
        .feature-desc {
            font-size: 0.9rem;
            color: #6c757d;
            line-height: 1.4;
        }
        
        .progress-container {
            margin: 2rem 0;
        }
        
        .progress-bar {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 1rem;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 10px;
            animation: loading 3s ease-in-out infinite;
        }
        
        .access-code-container {
            margin: 2rem 0;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 10px;
            border: 1px dashed #6c757d;
            transition: all 0.3s ease;
        }
        
        .access-code-container:hover {
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        
        .access-code-container h3 {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            color: #206bc4;
        }
        
        .access-code-container p {
            font-size: 0.9rem;
            margin-bottom: 1rem;
            color: #6c757d;
        }
        
        .access-code-form {
            display: flex;
            gap: 0.5rem;
        }
        
        .access-code-input {
            flex: 1;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            border: 1px solid #ddd;
            transition: border-color 0.3s ease;
        }
        
        .access-code-input:focus {
            outline: none;
            border-color: #206bc4;
            box-shadow: 0 0 0 3px rgba(32, 107, 196, 0.2);
        }
        
        .access-code-button {
            padding: 0.5rem 1rem;
            background: #206bc4;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        
        .access-code-button:hover {
            background: #1a5aa8;
        }
        
        @keyframes loading {
            0%, 100% { width: 30%; }
            50% { width: 70%; }
        }
        
        .footer-text {
            color: #6c757d;
            font-size: 0.9rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        .social-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin: 1rem 0;
        }
        
        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            color: #667eea;
            text-decoration: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .social-link:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
            color: #764ba2;
        }
        
        @media (max-width: 768px) {
            .maintenance-container {
                margin: 1rem;
                padding: 2rem 1.5rem;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="header-section">
            <img src="{{ $system->app_logo_vertikal }}" alt="{{ $system->app_name }}" class="logo">
            
            <div class="status-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M3 21h4l13 -13a1.5 1.5 0 0 0 -4 -4l-13 13v4"></path>
                    <path d="M14.5 5.5l4 4"></path>
                    <path d="M12 8l-5 -5l-4 4l5 5"></path>
                    <path d="M7 8l-1.5 1.5"></path>
                    <path d="M16 12l5 5l-4 4l-5 -5"></path>
                    <path d="M16 17l-1.5 1.5"></path>
                </svg>
                <span>Mode Maintenance</span>
            </div>
        </div>
        
        <h1>Sistem Sedang Dalam Pemeliharaan</h1>
        <p class="subtitle">Mohon maaf atas ketidaknyamanan ini. Kami sedang melakukan upgrade dan peningkatan sistem untuk memberikan pengalaman yang lebih baik kepada Anda.</p>
        
        <div class="progress-container">
            <div class="progress-bar">
                <div class="progress-fill"></div>
            </div>
            <small style="color: #6c757d;">Proses pemeliharaan sedang berlangsung...</small>
        </div>
        
        <div class="access-code-container">
            <h3>Akses dengan Kode</h3>
            <p>Jika Anda memiliki kode akses, masukkan di bawah ini untuk mengakses sistem.</p>
            
            <form action="{{ url('/') }}" method="get" class="access-code-form">
                <input type="text" name="access_code" placeholder="Masukkan kode akses" class="access-code-input" required>
                <button type="submit" class="access-code-button">Akses</button>
            </form>
        </div>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z"></path>
                        <path d="M15 9l-6 6"></path>
                        <path d="M9 9l6 6"></path>
                    </svg>
                </div>
                <div class="feature-title">Peningkatan Keamanan</div>
                <div class="feature-desc">Memperbarui sistem keamanan untuk melindungi data Anda</div>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                        <path d="M12 7v5l3 3"></path>
                    </svg>
                </div>
                <div class="feature-title">Optimasi Performa</div>
                <div class="feature-desc">Meningkatkan kecepatan dan responsivitas aplikasi</div>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 3l8 4.5v9l-8 4.5l-8 -4.5v-9l8 -4.5"></path>
                        <path d="M12 12l8 -4.5"></path>
                        <path d="M12 12v9"></path>
                        <path d="M12 12l-8 -4.5"></path>
                    </svg>
                </div>
                <div class="feature-title">Fitur Baru</div>
                <div class="feature-desc">Menambahkan fitur-fitur inovatif untuk kemudahan Anda</div>
            </div>
        </div>
        
        <div class="social-links">
            <a href="https://facebook.com/{{ $kampus->link_fb }}" class="social-link" title="Facebook">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3"></path>
                </svg>
            </a>
            <a href="https://x.com/{{ $kampus->link_tw }}" class="social-link" title="Twitter">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M22 4.01c-1 .49 -1.98 .689 -3 .99c-1.121 -1.265 -2.783 -1.335 -4.38 -.737s-2.643 2.06 -2.62 3.737v1c-3.245 .083 -6.135 -1.395 -8 -4c0 0 -4.182 7.433 4 11c-1.872 1.247 -3.739 2.088 -6 2c3.308 1.803 6.913 2.423 10.034 1.517c3.58 -1.04 6.522 -3.723 7.651 -7.742a13.84 13.84 0 0 0 .497 -3.753c-.002 -.249 1.51 -2.772 1.818 -4.013z"></path>
                </svg>
            </a>
            <a href="https://instagram.com/{{ $kampus->link_ig }}" class="social-link" title="Instagram">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <rect x="4" y="4" width="16" height="16" rx="4"></rect>
                    <circle cx="12" cy="12" r="3"></circle>
                    <line x1="16.5" y1="7.5" x2="16.5" y2="7.501"></line>
                </svg>
            </a>
        </div>
        
        <div class="footer-text">
            <p><strong>{{ $system->app_name }}</strong> &copy; {{ date('Y') }}<br>
            <small>Terima kasih atas kesabaran Anda</small></p>
        </div>
    </div>
</body>
</html>