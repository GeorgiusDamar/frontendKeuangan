@extends('layouts.main')

@section('judul')
    Tambah Akun
@endsection

@section('container')
<div class="container mt-5">
    <h2 class="mb-4">Tambah Akun</h2>
    <form id="tambahForm">
        <div class="mb-3">
            <label for="jenis_akun" class="form-label">Jenis Akun</label>
            <select class="form-select" id="jenis_akun" name="jenis_akun" required>
                <option value="" disabled selected>-- Pilih Jenis Akun --</option>
                <option value="aset">Aset</option>
                <option value="kewajiban">Kewajiban</option>
                <option value="ekuitas">Ekuitas</option>
                <option value="pendapatan">Pendapatan</option>
                <option value="beban">Beban</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="nama_akun" class="form-label">Nama Akun</label>
            <input type="text" class="form-control" id="nama_akun" name="nama_akun" required>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <input type="text" class="form-control" id="deskripsi" name="deskripsi">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/admin/akun" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
<script>
    const API_URL = "{{ env('API_URL') }}";
    const token = Cookies.get('token');

    document.getElementById('tambahForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const data = {
            jenis_akun: document.getElementById('jenis_akun').value,
            nama_akun: document.getElementById('nama_akun').value,
            deskripsi: document.getElementById('deskripsi').value,
        };

        fetch(`${API_URL}/accounts`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(result => {
            if (result.message === 'Account created successfully') {
                alert('Akun berhasil ditambahkan!');
                window.location.href = '/admin/akun';
            } else {
                alert(result.message || 'Gagal menambahkan akun');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan akun');
        });
    });
</script>
@endpush
