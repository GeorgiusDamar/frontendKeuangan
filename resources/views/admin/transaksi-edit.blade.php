@extends('layouts.main')

@section('judul')
    Edit Transaksi
@endsection

@section('container')
<div class="container mt-5">
    <h2 class="mb-4">Edit Transaksi</h2>
    <form id="formEditTransaksi">
        <div class="mb-3">
            <label for="tipe_transaksi" class="form-label">Tipe Transaksi</label>
            <select class="form-control" id="tipe_transaksi" name="tipe_transaksi" required>
                <option value="">-- Pilih Tipe --</option>
                <option value="masuk">Masuk</option>
                <option value="keluar">Keluar</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="nama_akun" class="form-label">Nama Akun</label>
            <select class="form-control" id="nama_akun" name="account_id" required>
                <option value="">-- Pilih Akun --</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="no_bukti" class="form-label">No Bukti</label>
            <input type="text" class="form-control" id="no_bukti" name="no_bukti" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <input type="text" class="form-control" id="deskripsi" name="deskripsi" required>
        </div>

        <div class="mb-3">
            <label for="nominal" class="form-label">Nominal</label>
            <input type="text" class="form-control" id="nominal" name="nominal" required> 
        </div>

        <div class="mb-3">
            <label for="waktu" class="form-label">Waktu</label>
            <input type="date" class="form-control" id="waktu" name="waktu" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('admin.transaksi') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

@section('scripttambahan')
<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", async function () {
    const token = Cookies.get('token');
    const API_URL = "{{ env('API_URL') }}";
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    const nominalInput = document.getElementById('nominal');
    nominalInput.addEventListener('input', function () {
        this.value = formatRupiah(this.value);
    });

    function formatRupiah(angka) {
        return angka.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    if (!id) {
        alert('ID transaksi tidak ditemukan');
        window.location.href = "{{ route('admin.transaksi') }}";
        return;
    }

    // 1. Ambil data akun terlebih dahulu (untuk dropdown)
    let akunList = [];
    try {
        const akunResponse = await fetch(`${API_URL}/accounts/dropdown`, {
            headers: { 'Authorization': `Bearer ${token}` }
        });
        akunList = await akunResponse.json();
        const selectAkun = document.getElementById('nama_akun');
        akunList.forEach(akun => {
            const option = document.createElement('option');
            option.value = akun.id;
            option.textContent = akun.nama_akun;
            selectAkun.appendChild(option);
        });
    } catch (err) {
        console.error('Gagal memuat akun:', err);
        alert('Gagal memuat daftar akun.');
    }

    // 2. Ambil data transaksi
    try {
        const res = await fetch(`${API_URL}/transactions/${id}`, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });
        const result = await res.json();
        if (!result.data) throw new Error('Transaksi tidak ditemukan');

       

        const transaksi = result.data;
        document.getElementById('tipe_transaksi').value = transaksi.tipe_transaksi || '';
        document.getElementById('no_bukti').value = transaksi.no_bukti || '';
        document.getElementById('deskripsi').value = transaksi.deskripsi || '';
        document.getElementById('nominal').value = formatRupiah(String(transaksi.nominal || 0));
        document.getElementById('nama_akun').value = transaksi.account_id || '';
 
        const waktu = new Date(transaksi.waktu);
        if (!isNaN(waktu.getTime())) {
            const yyyy = waktu.getFullYear();
            const mm = String(waktu.getMonth() + 1).padStart(2, '0');
            const dd = String(waktu.getDate()).padStart(2, '0');

            document.getElementById('waktu').value = `${yyyy}-${mm}-${dd}`;
        }
    } catch (err) {
        console.error('Gagal memuat data transaksi:', err);
        alert('Terjadi kesalahan saat mengambil data transaksi.');
    }

    // 3. Kirim data form
    document.getElementById('formEditTransaksi').addEventListener('submit', function (e) {
        e.preventDefault();

        const nominalClean = document.getElementById('nominal').value.replace(/\./g, '');
        const formData = {
            tipe_transaksi: document.getElementById('tipe_transaksi').value,
            account_id: document.getElementById('nama_akun').value,
            deskripsi: document.getElementById('deskripsi').value,
            no_bukti: document.getElementById('no_bukti').value,
            nominal: parseFloat(nominalClean),
            waktu: document.getElementById('waktu').value,
        };

        console.log(formData);

        fetch(`${API_URL}/transactions/${id}`, {
            method: 'PUT',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(res => res.json().then(data => ({ status: res.status, body: data })))
        .then(({ status, body }) => {
            if (status >= 400) {
                alert(body.message || 'Terjadi kesalahan saat memperbarui transaksi.');
                return;
            }

            alert(body.message || 'Transaksi berhasil diperbarui');
            window.location.href = "{{ route('admin.transaksi') }}";
        })
        .catch(err => {
            console.error('Gagal update transaksi:', err);
            alert('Gagal memperbarui transaksi.');
        });
    });
});
</script>
@endsection
