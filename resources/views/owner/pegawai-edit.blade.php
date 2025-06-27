@extends('layouts.main')

@section('judul')
    Edit Pegawai
@endsection

@section('container')
<div class="container mt-5">
    <h2 class="mb-4">Edit Pegawai</h2>
    <form id="formEditPegawai">
        <input type="hidden" id="pegawai_id">

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
            <label for="password" class="form-label">Password Baru (opsional)</label>
            <input type="password" class="form-control" id="password" name="password" 
                   placeholder="Kosongkan jika tidak ingin mengubah password"
                   autocomplete="new-password">
        </div>
        
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                   autocomplete="new-password">
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
        const token = Cookies.get('token');
        const API_URL = "{{ env('API_URL') }}";

        const urlParams = new URLSearchParams(window.location.search);
        const pegawaiId = urlParams.get('id');

        if (!pegawaiId) {
            alert('ID pegawai tidak ditemukan!');
            window.location.href = "{{ route('owner.pegawai') }}";
            return;
        }

        document.getElementById('pegawai_id').value = pegawaiId;

        // Ambil data pegawai
        fetch(`${API_URL}/users/${pegawaiId}`, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.role !== 'admin') {
                alert('User bukan admin.');
                window.location.href = "{{ route('owner.pegawai') }}";
                return;
            }

            document.getElementById('nama_user').value = data.nama_user;
            document.getElementById('email').value = data.email;
            document.getElementById('no_hp').value = data.no_hp || '';
        })
        .catch(err => {
            console.error('Gagal mengambil data:', err);
            alert('Gagal mengambil data pegawai.');
        });

        // Submit form
        const form = document.getElementById('formEditPegawai');
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const nama_user = document.getElementById('nama_user').value;
            const email = document.getElementById('email').value;
            const no_hp = document.getElementById('no_hp').value;
            const password = document.getElementById('password').value;
            const password_confirmation = document.getElementById('password_confirmation').value;

            const formData = {
                nama_user,
                email,
                no_hp,
            };

            if (password !== '') {
                formData.password = password;
                formData.password_confirmation = password_confirmation;
            }

            fetch(`${API_URL}/users/${pegawaiId}`, {
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
                    if (body.errors) {
                        const errorMsg = Object.values(body.errors).flat().join('\n');
                        alert('Gagal:\n' + errorMsg);
                    } else {
                        alert(body.message || 'Terjadi kesalahan saat update.');
                    }
                    return;
                }

                alert('Data pegawai berhasil diperbarui!');
                window.location.href = "{{ route('owner.pegawai') }}";
            })
            .catch(error => {
                console.error('Update error:', error);
                alert('Gagal memperbarui data pegawai');
            });
        });
    });
</script>
@endsection
