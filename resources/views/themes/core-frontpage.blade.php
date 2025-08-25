<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    @PwaHead
    <title>{{ (isset($menus) ? $menus . ' - ' : '') . $pages . ' - ' . $academy->name }}</title>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="{{ asset('assets') }}/dist/css/tabler.css" rel="stylesheet" />
    <!-- END GLOBAL MANDATORY STYLES -->
    @yield('custom-css')
    <!-- BEGIN PLUGINS STYLES -->
    <link href="{{ asset('assets') }}/dist/css/tabler-themes.css" rel="stylesheet" />
    <!-- END PLUGINS STYLES -->
    <!-- BEGIN DEMO STYLES -->
    <link href="{{ asset('assets') }}/preview/css/demo.css" rel="stylesheet" />
    <style>
        /* Chat Button Styles */
        .chat-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: var(--tblr-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .chat-button svg {
            color: #fff;
            width: 28px;
            height: 28px;
        }

        .chat-button:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        /* Chat Popup Styles */
        .chat-popup {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 350px;
            background: var(--tblr-bg-surface);
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
            display: none;
            z-index: 1000;
            backdrop-filter: blur(10px);
            border: 1px solid var(--tblr-border-color);
            overflow: hidden;
        }

        .chat-popup.show {
            display: block;
            animation: slideUp 0.3s ease forwards;
        }

        .chat-popup-header {
            padding: 20px;
            border-bottom: 1px solid var(--tblr-border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .chat-popup-body {
            padding: 20px;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .navbar {
            width: 100vw !important;
            margin-left: calc((100vw - 100%) / -2);
            margin-right: calc((100vw - 100%) / -2);
            left: 0;
            right: 0;
            border-radius: 0 !important;
        }
    </style>

    <!-- END DEMO STYLES -->
    <!-- BEGIN CUSTOM FONT -->
    <style>
        @import url("https://rsms.me/inter/inter.css");
    </style>
    <!-- END CUSTOM FONT -->
</head>

<body>
    <!-- BEGIN GLOBAL THEME SCRIPT -->
    <script src="{{ asset('assets') }}/dist/js/tabler-theme.min.js"></script>
    <!-- END GLOBAL THEME SCRIPT -->
    <div class="page">
        <!-- BEGIN NAVBAR  -->
        <header class="navbar navbar-expand-md d-print-none">
            <div class="container-xl">
                <!-- BEGIN NAVBAR TOGGLER -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- END NAVBAR TOGGLER -->
                <!-- BEGIN NAVBAR LOGO -->
                <div class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href="." aria-label="Tabler">
                        <img src="{{ $academy->logo_horizontal }}" style="height: 32px;" alt="Neco Siakad Logo">
                    </a>
                </div>
                <!-- END NAVBAR LOGO -->
                <div class="navbar-nav flex-row order-md-last">
                    <div class="d-none d-md-flex">
                        @include('themes.partials.buttons-navbar')
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown" aria-label="Open user menu">
                            <span class="avatar avatar-sm" style="background-image: url({{ $user == null ? asset('storage/images/profile/default.jpg') : $user->photo }})">
                            </span>
                            <div class="d-none d-xl-block ps-2">
                                <div>{{ $user == null ? 'Guest' : $user->name }}</div>
                                <div class="mt-1 small text-secondary">{{ $user == null ? 'Guest' : $user->type }}</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            @auth
                            <a href="{{ route($spref.'profile-render') }}" class="dropdown-item">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                </svg>
                                Profil
                            </a>

                            <a href="{{ route('auth.handle-logout') }}" class="dropdown-item">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                    <path d="M9 12h12l-3 -3" />
                                    <path d="M18 15l3 -3" />
                                </svg>
                                Keluar
                            </a>
                            @endauth

                            @guest
                            <a href="{{ route('auth.render-signin') }}" class="dropdown-item">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                </svg>
                                Login
                            </a>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <header class="navbar-expand-md">
            <div class="collapse navbar-collapse" id="navbar-menu">
                <div class="navbar">
                    <div class="container-xl">
                        <div class="row flex-column flex-md-row flex-fill align-items-center">
                            <div class="col">
                                <!-- BEGIN NAVBAR MENU -->
                                @include('themes.partials.default-menu')
                                <!-- END NAVBAR MENU -->
                            </div>
                            <div class="col col-md-auto">
                                <ul class="navbar-nav">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSettings">
                                            <span class="badge badge-sm bg-red text-red-fg">New</span>
                                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                <!-- Download SVG icon from http://tabler.io/icons/icon/settings -->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                                    <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                                                    <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                                </svg>
                                            </span>
                                            <span class="nav-link-title"> Settings </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- END NAVBAR  -->
        <div class="page-wrapper">
            <!-- BEGIN PAGE HEADER -->
            <!-- END PAGE HEADER -->
            <!-- BEGIN PAGE BODY -->
            <div class="page-body">
                <div class="container-xl my-auto">
                    @include('sweetalert::alert')
                    @yield('content')
                </div>
            </div>

        </div>
    </div>
    @include('themes.partials.settings')
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('assets') }}/dist/js/tabler.min.js?1747482943" defer></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <!-- BEGIN DEMO SCRIPTS -->
    <script src="./preview/js/demo.min.js?1747482943" defer></script>
    <!-- END DEMO SCRIPTS -->
    @yield('custom-js')
    <!-- BEGIN PAGE SCRIPTS -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var themeConfig = {
                theme: "light",
                "theme-base": "gray",
                "theme-font": "sans-serif",
                "theme-primary": "blue",
                "theme-radius": "1",
            };
            var url = new URL(window.location);
            var form = document.getElementById("offcanvasSettings");
            var resetButton = document.getElementById("reset-changes");
            var checkItems = function() {
                for (var key in themeConfig) {
                    var value = window.localStorage["tabler-" + key] || themeConfig[key];
                    if (!!value) {
                        var radios = form.querySelectorAll(`[name="${key}"]`);
                        if (!!radios) {
                            radios.forEach((radio) => {
                                radio.checked = radio.value === value;
                            });
                        }
                    }
                }
            };
            form.addEventListener("change", function(event) {
                var target = event.target,
                    name = target.name,
                    value = target.value;
                for (var key in themeConfig) {
                    if (name === key) {
                        document.documentElement.setAttribute("data-bs-" + key, value);
                        window.localStorage.setItem("tabler-" + key, value);
                        url.searchParams.set(key, value);
                    }
                }
                window.history.pushState({}, "", url);
            });
            resetButton.addEventListener("click", function() {
                for (var key in themeConfig) {
                    var value = themeConfig[key];
                    document.documentElement.removeAttribute("data-bs-" + key);
                    window.localStorage.removeItem("tabler-" + key);
                    url.searchParams.delete(key);
                }
                checkItems();
                window.history.pushState({}, "", url);
            });
            checkItems();
        });
    </script>
    <!-- END PAGE SCRIPTS -->

    <!-- BEGIN FLOATING CHAT BUTTON -->
    <div class="chat-button" onclick="toggleChatPopup()">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M8 9h8"></path>
            <path d="M8 13h6"></path>
            <path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z"></path>
        </svg>
    </div>
    <div class="chat-popup" id="chatPopup">
        <div class="chat-popup-header">
            <h4 class="m-0">Hubungi Kami</h4>
            <button type="button" class="btn-close" onclick="toggleChatPopup()"></button>
        </div>
        <div class="chat-popup-body">
            <form id="whatsappForm" onsubmit="sendWhatsApp(event)">
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">No. WhatsApp</label>
                    <input type="tel" class="form-control" id="whatsapp" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pesan</label>
                    <textarea class="form-control" id="message" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-whatsapp" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9"></path>
                        <path d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1"></path>
                    </svg>
                    Kirim Pesan
                </button>
            </form>
        </div>
    </div>

    <!-- BEGIN FOOTER -->
    <footer class="footer footer-transparent pt-5 mt-auto border-top">
        <div class="container pb-5">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h3 class="h4">{{ $academy->name }}</h3>
                    <p class="text-muted">{{ $system->app_description }}</p>
                    <div class="social-links mt-4 d-flex gap-2">
                        <a href="#" class="btn btn-icon btn-sm btn-ghost-secondary rounded-circle">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-facebook" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
                            </svg>
                        </a>
                        <a href="#" class="btn btn-icon btn-sm btn-ghost-secondary rounded-circle">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-instagram" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                <path d="M4 4m0 4a4 4 0 0 1 4 -4h8a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4z" />
                                <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                <path d="M16.5 7.5l0 .01" />
                            </svg>
                        </a>
                        <a href="#" class="btn btn-icon btn-sm btn-ghost-secondary rounded-circle">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-youtube" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                <path d="M3 5m0 4a4 4 0 0 1 4 -4h10a4 4 0 0 1 4 4v6a4 4 0 0 1 -4 4h-10a4 4 0 0 1 -4 -4z" />
                                <path d="M10 9l5 3l-5 3z" />
                            </svg>
                        </a>
                        <a href="#" class="btn btn-icon btn-sm btn-ghost-secondary rounded-circle">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                <path d="M4 4l11.733 16h4.267l-11.733 -16z" />
                                <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-2">
                    <h4 class="h5 mb-4">Link Cepat</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="link-secondary">Tentang Kami</a></li>
                        <li class="mb-2"><a href="#" class="link-secondary">Program Studi</a></li>
                        <li class="mb-2"><a href="#" class="link-secondary">Pendaftaran</a></li>
                        <li class="mb-2"><a href="#" class="link-secondary">Beasiswa</a></li>
                        <li class="mb-2"><a href="#" class="link-secondary">Kalender Akademik</a></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-lg-2">
                    <h4 class="h5 mb-4">Mahasiswa</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="link-secondary">SIAKAD</a></li>
                        <li class="mb-2"><a href="#" class="link-secondary">E-Learning</a></li>
                        <li class="mb-2"><a href="#" class="link-secondary">Perpustakaan</a></li>
                        <li class="mb-2"><a href="#" class="link-secondary">Laboratorium</a></li>
                        <li class="mb-2"><a href="#" class="link-secondary">Kemahasiswaan</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h4 class="h5 mb-4">Kontak</h4>
                    <ul class="list-unstyled">
                        <li class="mb-3 d-flex gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-pin" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                                <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z"></path>
                            </svg>
                            <span class="text-muted">{{ $academy->alamat }}</span>
                        </li>
                        <li class="mb-3 d-flex gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                            </svg>
                            <span class="text-muted">{{ $academy->whatsapp }}</span>
                        </li>
                        <li class="mb-3 d-flex gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"></path>
                                <path d="M3 7l9 6l9 -6"></path>
                            </svg>
                            <span class="text-muted">Info : {{ $academy->email_info }}</span>
                        </li>
                        <li class="mb-3 d-flex gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"></path>
                                <path d="M3 7l9 6l9 -6"></path>
                            </svg>
                            <span class="text-muted">Humas : {{ $academy->email_humas }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="border-top">
            <div class="container py-4">
                <div class="row align-items-center">
                    <div class="col-lg-9 text-lg-start text-center">
                        <ul class="list-inline list-inline-dots mb-0">
                            <li class="list-inline-item">Copyright © {{ \Carbon\Carbon::now()->translatedFormat('F Y') }} <a href="{{ $system->app_url }}" class="link-secondary">{{ $system->app_name }} - {{ $academy->name }} </a>. All rights reserved.</li>
                            <li class="list-inline-item"><a href="#" class="link-secondary">Kebijakan Privasi</a></li>
                            <li class="list-inline-item"><a href="#" class="link-secondary">Syarat & Ketentuan</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 mt-3 mt-lg-0 text-lg-end text-center">
                        <img src="{{ $academy->logo_horizontal }}" style="max-width: 200px; max-height: 128px" alt="Logo" class="h-8">
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- END FOOTER -->

    @RegisterServiceWorkerScript

    <script>
        function toggleChatPopup() {
            const popup = document.getElementById('chatPopup');
            popup.classList.toggle('show');
        }

        function sendWhatsApp(event) {
            event.preventDefault();
            const name = document.getElementById('name').value;
            const whatsapp = document.getElementById('whatsapp').value;
            const message = document.getElementById('message').value;

            // Format pesan
            const formattedMessage = `Halo, saya ${name}\n\n${message}`;

            // Buat URL WhatsApp dengan nomor dan pesan
            const whatsappUrl = `https://wa.me/${whatsapp}?text=${encodeURIComponent(formattedMessage)}`;

            // Buka WhatsApp di tab baru
            window.open(whatsappUrl, '_blank');

            // Reset form
            event.target.reset();
            toggleChatPopup();
        }
    </script>

</body>

</html>
