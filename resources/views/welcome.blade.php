<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UMKM Nusantara – Login</title>

  <!-- Bootstrap 5.3 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    :root {
      --brand-cream: #f0d9b5;
      --brand-brown-dark: #b48c5e;
      --cream-bg: #f6efe7;
      --nav-height: 72px;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: var(--cream-bg);
    }

    /* ====== Hero ====== */
    .hero {
     /* Contoh menggunakan proxy */
      background: url('https://images.weserv.nl/?url=sawitindonesia.com/wp-content/uploads/2021/05/jajan-pasar.jpg') center/cover no-repeat;
      min-height: 100vh;
      position: relative;
      color: #fff;
    }
    .hero::after {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(0, 0, 0, .55);
    }
    .hero-content {
      position: relative;
      z-index: 2;
    }

    /* ====== Section Centering ====== */
    .section-center {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    #login { background: var(--cream-bg); }
    #features { background: #fff; }
    #contact { background: var(--cream-bg); }

    /* ====== Components ====== */
    .login-card {
      border-radius: 1rem;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .1);
    }
    .brand-color {
      color: var(--brand-brown-dark);
    }
    .btn-brand {
      background: var(--brand-cream);
      border: none;
      color: #5a3d31;
    }
    .btn-brand:hover {
      background: #e3c6a3;
      color: #000;
    }
    .text-brand {
      color: var(--brand-brown-dark);
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top" style="height: var(--nav-height);">
  <div class="container">
    <a class="navbar-brand fw-bold brand-color" href="#">UMKM Nusantara</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="#login">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="#features">Fitur</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact">Kontak</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero d-flex align-items-center" id="home">
  <div class="container text-center hero-content">
    <h1 class="display-5 fw-semibold">Solusi Keuangan Digital untuk UMKM</h1>
    <p class="lead mb-4">Kelola arus kas, catat transaksi, dan pantau laporan keuangan bisnis Anda dengan mudah dan efisien.</p>
    <a href="#login" class="btn btn-lg btn-brand">Mulai Sekarang</a>
  </div>
</section>


<!-- Login Section -->
<section id="login" class="section-center">
  <div class="container d-flex justify-content-center">
    <div class="card login-card p-4 col-md-6 col-lg-4 align-self-center">
      <h3 class="text-center mb-4 brand-color">Login UMKM</h3>
      
      {{-- LOGIN --}}
      <form id="loginForm" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="nama@usaha.com" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="••••••" required>
        </div>
        <button type="submit" class="btn btn-brand w-100">Masuk</button>
        <div class="text-center mt-3">
            <small>Belum punya akun? <a href="/register" class="brand-color">Daftar di sini</a></small>
        </div>
    </form>
    
    <div id="errorMessage" style="color: red; display:none;"></div>
    
      {{-- <form action="/login" method="POST">
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="nama@usaha.com" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="••••••" required>
        </div>
        <button type="submit" class="btn btn-brand w-100">Masuk</button>
        <div class="text-center mt-3">
          <small>Belum punya akun? <a href="/register" class="brand-color">Daftar di sini</a></small>
        </div>
      </form> --}}
    </div>
  </div>
</section>

<!-- Features Section -->
<section id="features" class="section-center">
  <div class="container py-5 text-center">
    <div class="row mb-4">
      <div class="col">
        <h2 class="fw-bold">Fitur Unggulan</h2>
      </div>
    </div>
    <div class="row g-4">
      <!-- Analitik -->
      <div class="col-md-4">
        <div class="p-4 border rounded-3 h-100">
          <i class="fa-solid fa-chart-line fa-3x mb-3 text-brand"></i>
          <h5 class="fw-semibold">Analitik</h5>
          <p class="text-muted">Pantau laporan keuangan bisnis Anda.</p>
        </div>
      </div>
      <!-- Manajemen -->
      <div class="col-md-4">
        <div class="p-4 border rounded-3 h-100">
          <i class="fa-solid fa-cogs fa-3x mb-3 text-brand"></i>
          <h5 class="fw-semibold">Manajemen</h5>
          <p class="text-muted">Buat dan catat rekening keluar masuk di bisnis Anda.</p>
        </div>
      </div>
      <!-- Pegawai -->
      <div class="col-md-4">
        <div class="p-4 border rounded-3 h-100">
          <i class="fa-solid fa-users fa-3x mb-3 text-brand"></i>
          <h5 class="fw-semibold">Pegawai</h5>
          <p class="text-muted">Kelola pegawai Anda.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Contact Section -->
<section id="contact" class="section-center">
  <div class="container text-center">
    <h2 class="fw-bold mb-4">Hubungi Kami</h2>
    <p class="text-muted mb-4">Punya pertanyaan atau butuh bantuan? Tim kami siap membantu Anda untuk mengembangkan bisnis kuliner.</p>
    <!-- WhatsApp Link -->
    <a href="https://wa.me/62xxxx" class="btn btn-brand btn-lg" target="_blank">
        <i class="fab fa-whatsapp"></i> WhatsApp
    </a>
  </div>
</section>

<!-- Footer -->
<footer class="bg-white py-4 border-top">
  <div class="container text-center">
    <small class="text-muted">&copy; 2025 UMKM Nusantara. All rights reserved.</small>
  </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


{{-- FETCH LOGIN JS --}}
<!-- Mengimpor js-cookie dari CDN -->
<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
<script>
document.getElementById('loginForm').addEventListener('submit', function (event) {
    event.preventDefault();  // Mencegah reload default form

    // Ambil email & password
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // URL API dari .env Laravel Blade
    const apiUrl = "{{ env('API_URL') }}/login";

    // Debug cek input
    console.log('API URL:', apiUrl);
    console.log('Login Data:', { email, password });

    // Kirim request ke API login
    fetch(apiUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Response:', data);

        if (data.token) {
            // ✅ 1) Simpan HANYA token di cookie
            Cookies.set('token', data.token, { path: '/', sameSite: 'Lax', expires: 1 });

            // ✅ 2) Decode payload JWT
            const payloadBase64 = data.token.split('.')[1];
            const payloadJson = atob(payloadBase64.replace(/-/g, '+').replace(/_/g, '/'));
            const payload = JSON.parse(payloadJson);

            console.log('Decoded Payload:', payload);

            // ✅ 3) Ambil role dari payload
            const role = payload.role;

            // ✅ 4) Redirect sesuai role
            if (role === 'owner') {
                window.location.href = "/owner/dashboard";
            } else if (role === 'admin') {
                window.location.href = "/admin/dashboard";
            } else {
                window.location.href = "/dashboard";
            }

        } else {
            // Gagal login
            document.getElementById('errorMessage').textContent = 'Login gagal, pastikan email dan password benar.';
            document.getElementById('errorMessage').style.display = 'block';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('errorMessage').textContent = 'Terjadi kesalahan saat login. Silakan coba lagi.';
        document.getElementById('errorMessage').style.display = 'block';
    });
});
</script>




</body>
</html>
