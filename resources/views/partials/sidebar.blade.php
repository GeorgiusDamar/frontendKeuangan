<!-- Sidebar Client -->
<div class="sidebar bg-dark text-white p-3" style="width: 250px; height: 100vh;">
    <h4 class="text-center mb-4">UMKM Nusantara</h4>
    <hr>

    <!-- Sidebar Menu -->
    <ul class="nav flex-column" id="menu">
        <!-- Default menu items, will be dynamically updated based on role -->
    </ul>

    <hr>

    <!-- User Info -->
    <div class="user-info d-flex justify-content-between align-items-center">
        <span class="namaUser">USERNAME</span> <!-- Dynamically filled from JS -->
        <button id="logoutButton" class="btn btn-danger btn-sm">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </div>
</div>



<!-- Script untuk Menampilkan Nama Pengguna di Sidebar dan Logika Logout -->
<!-- ✅ Script Sidebar: Sesuai JWT Stateless -->
<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const token = Cookies.get('token');
    let role = null;
    let nama_user = null;

    if (token) {
        try {
            // ✅ Decode JWT payload
            const payloadBase64 = token.split('.')[1];
            const payloadJson = atob(payloadBase64.replace(/-/g, '+').replace(/_/g, '/'));
            const payload = JSON.parse(payloadJson);

            role = payload.role;
            nama_user = payload.nama_user; 
        } catch (error) {
            console.error('Error decoding JWT:', error);
            // Jika token rusak, remove & redirect ke home
            Cookies.remove('token', { path: '/' });
            window.location.href = "/";
            return;
        }
    } else {
        // Jika token tidak ada, redirect ke home/login
        window.location.href = "/";
        return;
    }

    // ✅ Update menu berdasarkan role
    const menu = document.getElementById('menu');

    if (role === 'owner') {
        menu.innerHTML = `
            <li class="nav-item">
                <a class="nav-link text-white" href="/owner/dashboard">
                    <i class="fas fa-tachometer-alt"></i> Dashboard Owner
                </a>
            </li>
      
            <li class="nav-item">
                <a class="nav-link text-white" href="/owner/pegawai">
                    <i class="fas fa-users"></i> Pegawai
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white" href="/owner/jurnal">
                    <i class="fas fa-book"></i> Jurnal
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white" href="/owner/bukubesar">
                    <i class="fas fa-book-open"></i> Buku Besar
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white" href="/owner/neraca">
                    <i class="fas fa-balance-scale"></i> Neraca
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white" href="/owner/labarugi">
                    <i class="fas fa-file-invoice-dollar"></i> Laba Rugi
                </a>
            </li>
        `;
    } else if (role === 'admin') {
        menu.innerHTML = `
            <li class="nav-item">
                <a class="nav-link text-white" href="/admin/dashboard">
                    <i class="fas fa-tachometer-alt"></i> Dashboard Admin
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="/admin/akun">
                    <i class="fas fa-wallet"></i> Akun
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white" href="/admin/transaksi">
                    <i class="fas fa-exchange-alt"></i> Transaksi
                </a>
            </li>            

            
        `;
    } else {
        // Jika role tidak valid, tampilkan menu default
        menu.innerHTML = `
            <li class="nav-item">
                <a class="nav-link text-white" href="/">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="/">
                    <i class="fas fa-box"></i> Menu
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="/">
                    <i class="fas fa-sticky-note"></i> Pesan
                </a>
            </li>
        `;
    }

    // ✅ Tampilkan nama_user di sidebar
    const userNameElements = document.querySelectorAll('.namaUser');
    userNameElements.forEach(el => el.innerText = nama_user || "Guest");

    // ✅ Logika Logout: hapus token + redirect ke home
    document.getElementById('logoutButton').addEventListener('click', function() {
        Cookies.remove('token', { path: '/' });
        window.location.href = "/";
    });
});
</script>
