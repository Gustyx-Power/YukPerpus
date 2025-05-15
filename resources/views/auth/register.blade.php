<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport" />
  <title>Register - YukPerpus!</title>
  <link rel="icon" href="{{asset('assets/img/unsplash/logo.png')}}" type="image/x-icon" />

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('assets/modules/bootstrap/css/bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/modules/fontawesome/css/all.min.css')}}" />

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{asset('assets/modules/bootstrap-social/bootstrap-social.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/modules/izitoast/css/iziToast.min.css')}}" />

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/components.css')}}" />

  <style>
    /* === CSS Variables for Theme (copy from login) === */
    :root {
      --bg-gradient-start: #6777ef;
      --bg-gradient-end: #00b0ff;
      --container-bg: rgba(255, 255, 255, 0.95);
      --left-col-bg: rgba(103, 119, 239, 0.1);
      --right-col-bg: #ffffff;
      --text-color: #333;
      --heading-color: #6777ef;
      --card-title-color: #333;
      --input-border-color: #e0e0e0;
      --input-bg-color: #ffffff;
      --input-text-color: #333;
      --button-bg: #6777ef;
      --button-hover-bg: #5566d9;
      --link-color: #6777ef;
      --muted-text-color: #6c757d;
      --social-btn-bg: #ffffff;
      --header-text-color: #333;
      --theme-label-color: #555;
      --university-text-color: #333;
    }

    body.dark-mode {
      --bg-gradient-start: #1a202c;
      --bg-gradient-end: #2d3748;
      --container-bg: rgba(45, 55, 72, 0.95);
      --left-col-bg: rgba(74, 85, 104, 0.2);
      --right-col-bg: #2d3748;
      --text-color: #e2e8f0;
      --heading-color: #90cdf4;
      --card-title-color: #e2e8f0;
      --input-border-color: #4a5568;
      --input-bg-color: #4a5568;
      --input-text-color: #e2e8f0;
      --button-bg: #4299e1;
      --button-hover-bg: #3182ce;
      --link-color: #90cdf4;
      --muted-text-color: #a0aec0;
      --social-btn-bg: #4a5568;
      --header-text-color: #e2e8f0;
      --theme-label-color: #cbd5e0;
      --university-text-color: #e2e8f0;
    }

    /* === Base & Layout === */
    html, body {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: var(--text-color);
      transition: color 0.3s ease;
    }
    body {
      background: linear-gradient(to right, var(--bg-gradient-start), var(--bg-gradient-end));
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      transition: background 0.5s ease;
    }
    .login-container {
      width: 100%;
      max-width: 900px;
      background-color: var(--container-bg);
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
      background-color: var(--left-col-bg);
      color: var(--text-color);
    }
    .login-right {
      background-color: var(--right-col-bg);
    }

    /* === Header & University Info === */
    .university-info {
      margin-bottom: 15px;
      padding: 10px 15px;
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 8px;
      text-align: center;
      color: var(--university-text-color);
      font-weight: 600;
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 100%;
      transition: background-color 0.3s ease, color 0.3s ease;
    }
    .university-text {
      font-size: 0.9rem;
    }
    .right-switch {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .theme-label {
      font-size: 0.9rem;
      font-weight: 500;
      color: var(--theme-label-color);
      transition: color 0.3s ease;
    }
    .switch {
      position: relative;
      display: inline-block;
      width: 50px;
      height: 28px;
    }
    .switch input {
      opacity: 0; width: 0; height: 0;
    }
    .slider {
      position: absolute;
      cursor: pointer;
      top: 0; left: 0; right: 0; bottom: 0;
      background-color: #ccc; transition: .4s;
      border-radius: 28px;
    }
    .slider:before {
      position: absolute; content: "";
      height: 20px; width: 20px; left: 4px; bottom: 4px;
      background-color: white; transition: .4s; border-radius: 50%;
    }
    input:checked + .slider { background-color: #6777ef; }
    input:checked + .slider:before { transform: translateX(22px); }

    /* === Social Buttons === */
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
      background-color: var(--social-btn-bg);
      color: var(--text-color);
      border-color: var(--input-border-color);
      transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
    }
    .social-buttons .btn i { margin-right: 10px; }

    /* === Card (Register form) === */
    .login-card {
      width: 100%;
      max-width: none; /* memanjang penuh kolom kanan */
    }
    .card-header {
      background-color: transparent;
      border-bottom: none;
      padding-bottom: 20px;
      text-align: center;
    }
    .card-header h4 {
      margin: 0; color: var(--card-title-color);
      font-weight: 700; transition: color 0.3s ease;
    }
    .card-body { padding: 0; }

    /* === Form Controls === */
    .form-group {
      margin-bottom: 1.5rem;
    }
    .form-group label {
      font-weight: 600; color: var(--text-color);
      margin-bottom: 8px; display: block;
      transition: color 0.3s ease;
    }
    .form-control {
      width: 100%;
      border-radius: 8px;
      border: 1px solid var(--input-border-color);
      padding: 12px 15px;
      background-color: var(--input-bg-color);
      color: var(--input-text-color);
      transition: border-color 0.3s ease, background-color 0.3s ease, color 0.3s ease;
    }
    .form-control:focus {
      border-color: var(--link-color);
      box-shadow: 0 0 0 0.2rem rgba(103,119,239,0.25);
      outline: none;
    }

    /* === Buttons & Links === */
    .btn-info {
      background-color: var(--button-bg);
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
    a.text-info:hover { text-decoration: underline; }

    /* === Responsive === */
    @media (max-width: 768px) {
      .login-container { flex-direction: column; }
      .login-left, .login-right { width: 100%; padding: 30px; }
      .university-info { flex-direction: column; gap: 10px; }
    }
  </style>
</head>

<body>
  <div class="login-container">
    <!-- LEFT: Social Register & Theme -->
    <div class="login-left">
      <div class="university-info">
        <div class="university-text">
          Universitas Pelita Bangsa<br/>TI.23.C3 - Kelompok 4
        </div>
        <div class="right-switch">
          <span id="themeLabel" class="theme-label">Tema Terang</span>
          <label class="switch">
            <input type="checkbox" id="darkModeToggle"/>
            <span class="slider round"></span>
          </label>
        </div>
      </div>
      <h2>YukPerpus!</h2>
      <p class="text-muted text-center mb-4">Daftar dengan akun sosial Anda</p>
      <div class="social-buttons">
        <a href="{{ route('auth.google') }}" class="btn btn-outline-danger btn-block">
          <i class="fab fa-google"></i> Daftar dengan Google
        </a>
        <a href="{{ route('auth.github') }}" class="btn btn-outline-dark btn-block">
          <i class="fab fa-github"></i> Daftar dengan GitHub
        </a>
      </div>
    </div>

    <!-- RIGHT: Register Form -->
    <div class="login-right">
      <div class="login-card">
        <div class="card-header"><h4>Daftar Akun Baru</h4></div>
        <div class="card-body">
          @if(session('error'))
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                {{ session('error') }}
              </div>
            </div>
          @endif
          @if(session('status'))
            <div class="alert alert-success alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                {{ session('status') }}
              </div>
            </div>
          @endif

          <form method="POST" action="{{ route('register') }}" class="needs-validation">
            @csrf
            <div class="form-group">
              <label for="name">Nama Lengkap</label>
              <input id="name" type="text" class="form-control" name="name" tabindex="1" autofocus placeholder="Masukkan Nama Lengkap" value="{{ old('name') }}" required/>
              <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input id="email" type="email" class="form-control" name="email" tabindex="2" placeholder="Masukkan Email" value="{{ old('email') }}" required/>
              <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input id="password" type="password" class="form-control" name="password" tabindex="3" placeholder="Masukkan Password" required/>
              <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div class="form-group">
              <label for="password_confirmation">Konfirmasi Password</label>
              <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" tabindex="4" placeholder="Konfirmasi Password" required/>
              <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
            <div class="form-group mb-4">
              <button type="submit" class="btn btn-info btn-lg btn-block" tabindex="5">
                Daftar
              </button>
            </div>
            <div class="form-group text-center">
              <span>Sudah punya akun? </span>
              <a href="{{ route('login') }}" class="text-info">Masuk Sekarang</a>
            </div>

            <!-- Hidden Standard Fields -->
            <input type="hidden" name="CompanyCode" value="DEFAULT"/>
            <input type="hidden" name="Status" value="1"/>
            <input type="hidden" name="IsDeleted" value="0"/>
            <input type="hidden" name="CreatedBy" value="system"/>
            <input type="hidden" name="CreatedDate" value="{{ now() }}"/>
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
    // Dark Mode Toggle (reuse from login)
    const darkModeToggle = document.getElementById('darkModeToggle');
    const bodyEl = document.body;
    const themeLabel = document.getElementById('themeLabel');
    const storageKey = 'darkMode';

    function setTheme(dark) {
      if (dark) {
        bodyEl.classList.add('dark-mode');
        themeLabel.textContent = 'Tema Gelap';
      } else {
        bodyEl.classList.remove('dark-mode');
        themeLabel.textContent = 'Tema Terang';
      }
      document.querySelectorAll('.login-left, .login-right, .form-control, .btn, .university-info')
        .forEach(el => el.style.transition = 'background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease');
    }

    document.addEventListener('DOMContentLoaded', () => {
      const saved = localStorage.getItem(storageKey);
      const isDark = saved === 'dark';
      darkModeToggle.checked = isDark;
      setTimeout(() => setTheme(isDark), 50);
    });

    darkModeToggle.addEventListener('change', () => {
      const dark = darkModeToggle.checked;
      setTheme(dark);
      localStorage.setItem(storageKey, dark ? 'dark' : 'light');
    });
  </script>
</body>

</html>
