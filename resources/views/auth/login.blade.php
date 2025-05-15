<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login - YukPerpus!</title>
    <link rel="icon" href="{{asset('assets/img/unsplash/logo.png')}}" type="image/x-icon">
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{asset('assets/modules/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/modules/fontawesome/css/all.min.css')}}">
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{asset('assets/modules/bootstrap-social/bootstrap-social.css')}}">
    <link rel="stylesheet" href="{{asset('assets/modules/izitoast/css/iziToast.min.css')}}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/components.css')}}">
    <style>
        /* CSS Variables for Theme */
        :root {
            --bg-gradient-start: #6777ef; /* Warna awal gradasi mode terang */
            --bg-gradient-end: #00b0ff;   /* Warna akhir gradasi mode terang */
            --container-bg: rgba(255, 255, 255, 0.95); /* Background container mode terang */
            --left-col-bg: rgba(103, 119, 239, 0.1); /* Background kolom kiri mode terang */
            --right-col-bg: #ffffff; /* Background kolom kanan mode terang */
            --text-color: #333; /* Warna teks umum mode terang */
            --heading-color: #6777ef; /* Warna judul mode terang */
            --card-title-color: #333; /* Warna judul kartu mode terang */
            --input-border-color: #e0e0e0; /* Warna border input mode terang */
            --input-bg-color: #ffffff; /* Warna background input mode terang */
            --input-text-color: #333; /* Warna teks input mode terang */
            --button-bg: #6777ef; /* Warna background tombol mode terang */
            --button-hover-bg: #5566d9; /* Warna background tombol hover mode terang */
            --link-color: #6777ef; /* Warna link mode terang */
            --muted-text-color: #6c757d; /* Warna teks muted mode terang */
            --social-btn-bg: #ffffff; /* Warna background tombol sosial mode terang */
            --header-text-color: #333; /* Warna teks header mode terang */
            --theme-label-color: #555; /* Warna label tema mode terang */
            --university-text-color: #333; /* Warna teks universitas */
        }

        body.dark-mode {
            --bg-gradient-start: #1a202c; /* Warna awal gradasi mode gelap */
            --bg-gradient-end: #2d3748; /* Warna akhir gradasi mode gelap */
            --container-bg: rgba(45, 55, 72, 0.95); /* Background container mode gelap */
            --left-col-bg: rgba(74, 85, 104, 0.2); /* Background kolom kiri mode gelap */
            --right-col-bg: #2d3748; /* Background kolom kanan mode gelap */
            --text-color: #e2e8f0; /* Warna teks umum mode gelap */
            --heading-color: #90cdf4; /* Warna judul mode gelap */
            --card-title-color: #e2e8f0; /* Warna judul kartu mode gelap */
            --input-border-color: #4a5568; /* Warna border input mode gelap */
            --input-bg-color: #4a5568; /* Warna background input mode gelap */
            --input-text-color: #e2e8f0; /* Warna teks input mode gelap */
            --button-bg: #4299e1; /* Warna background tombol mode gelap */
            --button-hover-bg: #3182ce; /* Warna background tombol hover mode gelap */
            --link-color: #90cdf4; /* Warna link mode gelap */
            --muted-text-color: #a0aec0; /* Warna teks muted mode gelap */
            --social-btn-bg: #4a5568; /* Warna background tombol sosial mode gelap */
            --header-text-color: #e2e8f0; /* Warna teks header mode gelap */
            --theme-label-color: #cbd5e0; /* Warna label tema mode gelap */
            --university-text-color: #e2e8f0; /* Warna teks universitas */
        }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
            position: relative;
            /* Transisi global untuk semua elemen */
            transition: color 0.3s ease;
        }

        body {
            /* Background dengan transisi */
            background: linear-gradient(to right, var(--bg-gradient-start), var(--bg-gradient-end));
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            /* Transisi khusus untuk background */
            transition: background 0.5s ease;
        }

        .fixed-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            color: var(--header-text-color);
            transition: color 0.3s ease;
        }

        .university-info {
            margin-bottom: 15px;
            padding: 10px 15px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            text-align: center;
            color: var(--university-text-color);
            font-weight: 600;
            transition: background-color 0.3s ease, color 0.3s ease;
            line-height: 1.4;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .university-text {
            font-size: 0.9rem;
        }

        .right-switch {
            display: flex; /* Use flexbox to align switch and label */
            align-items: center;
            gap: 10px; /* Space between label and switch */
        }

        .theme-label {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--theme-label-color); /* Use CSS variable */
            transition: color 0.3s ease;
        }

        /* iOS-style Toggle Switch */
        .switch {
          position: relative;
          display: inline-block;
          width: 50px;
          height: 28px;
        }

        .switch input {
          opacity: 0;
          width: 0;
          height: 0;
        }

        .slider {
          position: absolute;
          cursor: pointer;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #ccc; /* Off state background */
          transition: .4s;
          border-radius: 28px;
        }

        .slider:before {
          position: absolute;
          content: "";
          height: 20px;
          width: 20px;
          left: 4px;
          bottom: 4px;
          background-color: white;
          transition: .4s;
          border-radius: 50%;
        }

        input:checked + .slider {
          background-color: #6777ef; /* On state background */
        }

        input:focus + .slider {
          box-shadow: 0 0 1px #6777ef;
        }

        input:checked + .slider:before {
          transform: translateX(22px);
        }

        /* Rounded sliders */
        .slider.round {
          border-radius: 28px;
        }

        .slider.round:before {
          border-radius: 50%;
        }

        .login-container {
            width: 100%;
            max-width: 900px;
            background-color: var(--container-bg); /* Menggunakan variabel untuk background container */
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            display: flex;
            min-height: 600px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }
        
        .login-left, .login-right {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        .login-left {
            background-color: var(--left-col-bg); /* Menggunakan variabel untuk background kolom kiri */
            color: var(--text-color);
        }
        
        .login-right {
            background-color: var(--right-col-bg); /* Menggunakan variabel untuk background kolom kanan */
        }
        
        .login-left h2 {
            color: var(--heading-color);
            margin-bottom: 30px;
            font-weight: 700;
            transition: color 0.3s ease;
        }
        
        .social-buttons {
            width: 100%;
            max-width: 300px;
        }
        
        .social-buttons .btn {
            margin-bottom: 15px;
            border-radius: 8px;
            padding: 12px 20px;
            font-size: 1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--social-btn-bg); /* Menggunakan variabel untuk background tombol sosial */
            color: var(--text-color);
            border-color: var(--input-border-color);
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }
        
        .social-buttons .btn i {
            margin-right: 10px;
        }
        
        .login-card {
            width: 100%;
            max-width: 400px;
        }
        
        .card-header {
            background-color: transparent;
            border-bottom: none;
            padding: 0 0 20px 0;
            text-align: center;
        }
        
        .card-header h4 {
            margin-bottom: 0;
            color: var(--card-title-color);
            font-weight: 700;
            transition: color 0.3s ease;
        }
        
        .card-body {
            padding: 0;
        }
        
        .form-control {
            border-radius: 8px;
            border-color: var(--input-border-color);
            padding: 12px 15px;
            background-color: var(--input-bg-color); /* Menggunakan variabel untuk background input */
            color: var(--input-text-color);
            transition: border-color 0.3s ease, background-color 0.3s ease, color 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--link-color);
            box-shadow: 0 0 0 0.2rem rgba(103, 119, 239, 0.25);
        }
        
        .form-group label {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 8px;
            transition: color 0.3s ease;
        }
        
        .btn-info {
            background-color: var(--button-bg); /* Menggunakan variabel untuk background tombol */
            border-color: var(--button-bg);
            border-radius: 8px;
            padding: 12px 25px;
            font-size: 1rem;
            font-weight: 600;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        
        .btn-info:hover {
            background-color: var(--button-hover-bg);
            border-color: var(--button-hover-bg);
        }
        
        .text-info {
            color: var(--link-color) !important;
            transition: color 0.3s ease;
        }
        
        a.text-info:hover {
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .mt-2 { margin-top: 0.5rem !important; }
        .mb-2 { margin-bottom: 0.5rem !important; }
        .mb-3 { margin-bottom: 1rem !important; }
        .mb-4 { margin-bottom: 1.5rem !important; }
        .d-flex { display: flex !important; }
        .align-items-center { align-items: center !important; }
        .justify-content-center { justify-content: center !important; }
        
        .text-muted {
            color: var(--muted-text-color) !important;
            transition: color 0.3s ease;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .university-info {
                flex-direction: column;
                gap: 10px;
            }
            
            .login-container {
                flex-direction: column;
            }
            
            .login-left, .login-right {
                width: 100%;
                padding: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        {{-- Left Column: Social Login --}}
        <div class="login-left">
            <!-- University info and theme switch moved into the card -->
            <div class="university-info">
                <div class="university-text">
                    Universitas Pelita Bangsa<br>TI.23.C3 - Kelompok 4
                </div>
                <div class="right-switch">
                    <span id="themeLabel" class="theme-label">Tema Terang</span>
                    <label class="switch">
                        <input type="checkbox" id="darkModeToggle">
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
            
            <h2>YukPerpus!</h2>
            <p class="text-muted text-center mb-4">Masuk dengan akun sosial Anda</p>
            <div class="social-buttons">
                <a href="{{ route('auth.google') }}" class="btn btn-outline-danger btn-block">
                    <i class="fab fa-google"></i> Masuk dengan Google
                </a>
                <a href="{{ route('auth.github') }}" class="btn btn-outline-dark btn-block">
                    <i class="fab fa-github"></i> Masuk dengan GitHub
                </a>
                {{-- Add Facebook if needed --}}
                {{-- <a href="{{ route('auth.facebook') }}" class="btn btn-outline-primary btn-block">
                    <i class="fab fa-facebook-f"></i> Masuk dengan Facebook
                </a> --}}
            </div>
        </div>

        {{-- Right Column: Email/Password Login --}}
        <div class="login-right">
            <div class="login-card">
                <div class="card-header">
                    <h4>Login Akun Anda</h4>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible show fade">
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif
                    @if(session('status'))
                        <div class="alert alert-success alert-dismissible show fade">
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                {{ session('status') }}
                            </div>
                        </div>
                    @endif
                    @if(session('sukses'))
                        <div class="alert alert-success alert-dismissible show fade">
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                {{ session('sukses') }}
                            </div>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('login') }}" class="needs-validation">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input id="email" type="email" class="form-control" name="email" tabindex="1" autofocus placeholder="Masukkan Email" value="{{ old('email') }}">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div class="form-group mb-3">
                            <div class="d-block">
                                <label for="password" class="control-label">Password</label>
                                <div class="float-right d-none">
                                    <a href="/forgot-password" class="text-small text-info">
                                        Lupa Password?
                                    </a>
                                </div>
                            </div>
                            <input id="password" type="password" class="form-control" name="password" tabindex="2" placeholder="Masukan Password">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="form-group mb-4">
                            <button type="submit" class="btn btn-info btn-lg btn-block" tabindex="4">
                                Login
                            </button>
                        </div>
                        <div class="form-group text-center">
                            <span>Belum punya akun? </span>
                            <a href="{{ route('register') }}" class="text-info">
                                Daftar Sekarang
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- General JS Scripts -->
    <script src="{{asset('assets/modules/jquery.min.js')}}"></script>
    <script src="{{asset('assets/modules/popper.js')}}"></script>
    <script src="{{asset('assets/modules/tooltip.js')}}"></script>
    <script src="{{asset('assets/modules/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
    <script src="{{asset('assets/modules/moment.min.js')}}"></script>
    <script src="{{asset('assets/js/stisla.js')}}"></script>
    <script src="{{asset('assets/modules/izitoast/js/iziToast.min.js')}}"></script>
    <script src="{{asset('assets/js/scripts.js')}}"></script>
    <script src="{{asset('assets/js/custom.js')}}"></script>

    <script>
        // Dark Mode Script - Improved
        const darkModeToggle = document.getElementById('darkModeToggle');
        const body = document.body;
        const themeLabel = document.getElementById('themeLabel');
        const localStorageKey = 'darkMode';

        // Function to set theme with improved transitions
        function setTheme(isDarkMode) {
            // Apply transitions more smoothly
            if (isDarkMode) {
                body.classList.add('dark-mode');
                themeLabel.textContent = 'Tema Gelap';
                
                // Force reflow to ensure transitions apply
                void body.offsetWidth;
                
                // Update all elements that need theme changes
                document.querySelectorAll('.login-left, .login-right, .form-control, .btn, .university-info').forEach(el => {
                    el.style.transition = 'background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease';
                });
                
                // Update university info style
                updateUniversityInfoStyle(true);
            } else {
                body.classList.remove('dark-mode');
                themeLabel.textContent = 'Tema Terang';
                
                // Force reflow to ensure transitions apply
                void body.offsetWidth;
                
                // Update all elements that need theme changes
                document.querySelectorAll('.login-left, .login-right, .form-control, .btn, .university-info').forEach(el => {
                    el.style.transition = 'background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease';
                });
                
                // Update university info style
                updateUniversityInfoStyle(false);
            }
        }
        
        // Function to update university info style
        function updateUniversityInfoStyle(isDarkMode) {
            const universityInfo = document.querySelector('.university-info');
            if (universityInfo) {
                if (isDarkMode) {
                    universityInfo.style.backgroundColor = 'rgba(74, 85, 104, 0.3)';
                } else {
                    universityInfo.style.backgroundColor = 'rgba(103, 119, 239, 0.1)';
                }
            }
        }

        // Check user's preference from local storage
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem(localStorageKey);
            
            if (savedTheme === 'dark') {
                darkModeToggle.checked = true;
                // Force a timeout to ensure DOM is ready before applying theme
                setTimeout(() => setTheme(true), 50);
            } else {
                darkModeToggle.checked = false;
                setTimeout(() => setTheme(false), 50);
            }
            
            // Apply theme to university info element
            updateUniversityInfoStyle(savedTheme === 'dark');
        });

        // Add event listener to toggle switch with debounce
        let themeChangeTimeout = null;
        darkModeToggle.addEventListener('change', function() {
            // Clear any pending timeouts
            if (themeChangeTimeout) clearTimeout(themeChangeTimeout);
            
            // Set up a new timeout
            themeChangeTimeout = setTimeout(() => {
                if (this.checked) {
                    setTheme(true);
                    localStorage.setItem(localStorageKey, 'dark');
                } else {
                    setTheme(false);
                    localStorage.setItem(localStorageKey, 'light');
                }
            }, 50); // Short delay to prevent transition issues
        });

        // Toast notifications
        @if(session('error'))
        iziToast.error({
            title: 'Gagal Login!',
            message: '{{session('error')}}',
            position: 'topRight'
        });
        @endif
        @if(session('status'))
        iziToast.success({
            title: 'Password Reset!',
            message: '{{session('status')}}',
            position: 'topRight'
        });
        @endif
        @if(session('sukses'))
        iziToast.success({
            title: 'Sukses!',
            message: '{{session('sukses')}}',
            position: 'topRight'
        });
        @endif
    </script>
</body>
</html>