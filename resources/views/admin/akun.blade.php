@extends('layouts.main')

@section('judul')
    Daftar Akun
@endsection

@section('container')
<div class="container mt-5"> 
    <a href="/admin/akun-tambah" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Tambah Akun
    </a>
    <table id="akunTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Akun</th>
                <th>Jenis Akun</th>
                <th>Nama Akun</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
<script>
    const API_URL = "{{ env('API_URL') }}";
    const token = Cookies.get('token');

    document.addEventListener("DOMContentLoaded", function () {
        fetch(`${API_URL}/accounts`, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
        .then(res => res.json())
        .then(result => {
            if (!result.data) {
                alert('Gagal memuat data akun');
                return;
            }

            const tableBody = document.querySelector('#akunTable tbody');
            result.data.forEach((akun, index) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${akun.kode_akun}</td>
                    <td>${akun.jenis_akun}</td>
                    <td>${akun.nama_akun}</td>
                    <td>${akun.deskripsi || '-'}</td>
                    <td>
                        <a href="/admin/akun-edit?id=${akun.id}" class="btn btn-sm btn-warning me-1">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button onclick="hapusAkun(${akun.id})" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                tableBody.appendChild(tr);
            });

            new DataTable('#akunTable');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengambil data akun');
        });
    });

    function hapusAkun(id) {
        if (!confirm('Apakah Anda yakin ingin menghapus akun ini?')) return;

        fetch(`${API_URL}/accounts/${id}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
        .then(res => res.json())
        .then(result => {
            alert(result.message);
            location.reload();
        })
        .catch(error => {
            console.error('Gagal menghapus akun:', error);
            alert('Gagal menghapus akun');
        });
    }
</script>
@endpush
