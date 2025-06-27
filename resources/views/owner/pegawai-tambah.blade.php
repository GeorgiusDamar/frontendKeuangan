@extends('layouts.main')

@section('judul')
    Tambah Pegawai
@endsection

@section('container')
<div class="container mt-5">
    <h2 class="mb-4">Tambah Pegawai</h2>
    <form id="formTambahPegawai">
        <div class="mb-3">
            <label for="nama_user" class="form-label">Nama Pegawai</label>
            <input type="text" class="form-control" id="nama_user" name="nama_user" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email Pegawai</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="no_hp" class="form-label">No HP</label>
            <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="08xxxxxxxxxx">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required minlength="8">
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required minlength="8">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('owner.pegawai') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

@section('scripttambahan')
<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formTambahPegawai');
    const token = Cookies.get('token');
    const API_URL = "{{ env('API_URL') }}";

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = {
            nama_user: document.getElementById('nama_user').value,
            email: document.getElementById('email').value,
            no_hp: document.getElementById('no_hp').value,
            password: document.getElementById('password').value,
            password_confirmation: document.getElementById('password_confirmation').value
        };
        // console.log(formData);

        fetch(`${API_URL}/users`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(res => res.json())
        .then(data => {
    console.log('Full response:', data);

    // Jika data.errors ada → tampilkan error validasi
    if (data.errors) {
        const errorMessages = Object.values(data.errors).flat().join('\n');
        alert('Gagal:\n' + errorMessages);
    }
    // Jika respons adalah objek user yang valid → artinya sukses
    else if (data.id && data.email) {
        alert('Pegawai berhasil ditambahkan!');
        window.location.href = "{{ route('owner.pegawai') }}";
    }
    // Kalau struktur data tidak dikenali
    else {
        alert('Terjadi kesalahan tidak diketahui');
    }
})

        .catch(err => {
            console.error('Error:', err);
            alert('Gagal mengirim data ke server.');
        });
    });
});
</script>
@endsection
