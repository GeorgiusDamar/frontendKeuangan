@extends('layouts.main')
 

@section('container')
    <div class="card">
        <div class="card-header">
            <h2 class="text-center">Tambah Transaksi</h2>
        </div>
        <div class="card-body">
            <form id="transactionForm">
                <div class="form-group mb-3">
                    <label for="tipe_transaksi">Tipe Transaksi</label>
                    <select name="tipe_transaksi" id="tipe_transaksi" class="form-control" required>
                        <option value="masuk">Masuk</option>
                        <option value="keluar">Keluar</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="account_id">Akun</label>
                    <select name="account_id" id="account_id" class="form-control" required>
                        <option value="">-- Pilih Akun --</option>
                    </select>
                </div>
    
                <div class="form-group mb-3">
                    <label for="no_bukti">Nomor Bukti</label>
                    <input type="text" name="no_bukti" id="no_bukti" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" maxlength="500"></textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="nominal">Nominal</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp.</span> <!-- Menambahkan simbol Rp di sebelah kiri -->
                        <input type="text" name="nominal" id="nominal" class="form-control" required>
                    </div>
                </div>
                

                <div class="form-group mb-3">
                    <label for="waktu">Waktu</label>
                    <input type="date" name="waktu" id="waktu" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
 
                <div class="d-flex mt-3">
                    <button type="submit" class="btn btn-primary me-2">Tambah</button>
                    <a href="{{ route('admin.transaksi') }}" class="btn btn-secondary ms-2">Kembali</a>
                </div>

            </form>
        </div>
    </div>
@endsection


@section('scripttambahan')
<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script> 
<script>
    document.addEventListener('DOMContentLoaded', () => {
      // Menyisipkan API_URL dari Blade
      const apiUrl = "{{ env('API_URL') }}";  // Mengambil API_URL dari .env
  
      // Memuat data akun untuk dropdown
      fetch(`${apiUrl}/accounts/dropdown`)
        .then(response => response.json())
        .then(accounts => {
          const accountDropdown = document.getElementById('account_id');
          accounts.forEach(account => {
            const option = document.createElement('option');
            option.value = account.id;
            option.textContent = account.nama_akun;
            accountDropdown.appendChild(option);
          });
        })
        .catch(error => {
          console.error('Error fetching accounts:', error);
        });
  
      // Format nominal dengan tanda titik (untuk Rp)
      const nominalInput = document.getElementById('nominal');
      nominalInput.addEventListener('input', function () {
        let value = nominalInput.value.replace(/[^\d]/g, ''); // hanya angka
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // format Rp
        nominalInput.value = value;
      });
  
      // Kirim form saat tombol tambah diklik
      const transactionForm = document.getElementById('transactionForm');
      transactionForm.addEventListener('submit', function (e) {
        e.preventDefault();
  
        // Ambil token dari cookies
        const token = Cookies.get('token');
        const payloadBase64 = token.split('.')[1];
        const payloadJson = atob(payloadBase64.replace(/-/g, '+').replace(/_/g, '/'));
        // console.log(token);
        const payload = JSON.parse(payloadJson);
        const user_id = payload.user_id; // Dapatkan user_id dari token
  
        // Ambil data dari form
        const formData = new FormData(transactionForm);
        const data = {
          no_bukti: formData.get('no_bukti'),
          user_id: user_id,
          account_id: formData.get('account_id'),
          tipe_transaksi: formData.get('tipe_transaksi'),
          deskripsi: formData.get('deskripsi'),
          waktu: formData.get('waktu'),
          nominal: formData.get('nominal').replace(/\./g, '').trim(), // Hapus titik dan spasi
        };
  
        // Console log data yang akan dikirim
        // console.log("Data yang akan dikirim:", data);
  
        // Kirim request ke backend untuk menyimpan transaksi
        fetch(`${apiUrl}/transactions`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}` // Mengirimkan token untuk autentikasi
          },
          body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
          alert(result.message);
          // Reset form atau navigasi ke halaman lain jika diperlukan
          transactionForm.reset();
        })
        .catch(error => {
          console.error('Error submitting transaction:', error);
          alert('Terjadi kesalahan. Coba lagi!');
        });
      });
    });
  </script>
  
@endsection
