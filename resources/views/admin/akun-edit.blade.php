@extends('layouts.main')

@section('judul')
    Edit Akun
@endsection

@section('container')
<div class="container mt-5">
    <h2 class="mb-4">Edit Akun</h2>
    <form id="editForm">
        <div class="mb-3">
            <label for="kode_akun" class="form-label">Kode Akun</label>
            <input type="text" class="form-control" id="kode_akun" name="kode_akun" readonly>
        </div>
        <div class="mb-3">
            <label for="jenis_akun" class="form-label">Jenis Akun</label>
            <select class="form-select" id="jenis_akun" name="jenis_akun">
                <option value="aset">Aset</option>
                <option value="kewajiban">Kewajiban</option>
                <option value="ekuitas">Ekuitas</option>
                <option value="pendapatan">Pendapatan</option>
                <option value="beban">Beban</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="nama_akun" class="form-label">Nama Akun</label>
            <input type="text" class="form-control" id="nama_akun" name="nama_akun">
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <input type="text" class="form-control" id="deskripsi" name="deskripsi">
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
<script>
    const API_URL = "{{ env('API_URL', 'http://127.0.0.1:8000') }}";
    const token = Cookies.get('token');

    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    // Load data akun
    fetch(`${API_URL}/accounts/${id}`, {
        headers: {
            'Authorization': `Bearer ${token}`
        }
    })
    .then(response => response.json())
    .then(result => {
        const data = result.data;
        if (!data) return alert('Data akun tidak ditemukan');

        document.getElementById('kode_akun').value = data.kode_akun;
        document.getElementById('jenis_akun').value = data.jenis_akun;
        document.getElementById('nama_akun').value = data.nama_akun;
        document.getElementById('deskripsi').value = data.deskripsi || '';
    })
    .catch(error => {
        console.error(error);
        alert('Gagal memuat data akun');
    });

    // Simpan perubahan
    document.getElementById('editForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const data = {
            kode_akun: document.getElementById('kode_akun').value,
            jenis_akun: document.getElementById('jenis_akun').value,
            nama_akun: document.getElementById('nama_akun').value,
            deskripsi: document.getElementById('deskripsi').value,
        };

        fetch(`${API_URL}/accounts/${id}`, {
            method: 'PUT',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(result => {
            alert(result.message);
            window.location.href = '/admin/akun';
        })
        .catch(error => {
            console.error(error);
            alert('Gagal menyimpan perubahan');
        });
    });
</script>
@endpush
