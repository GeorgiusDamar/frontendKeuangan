@extends('layouts.main')

@section('judul')
    Daftar Pegawai
@endsection

@section('container')
<button class="btn btn-primary mb-3"
    onclick="window.location='{{ route('owner.pegawai-tambah') }}'">
    <i class="fas fa-plus"></i> Tambah
</button>

<hr>

<div class="table-responsive">
    <table id="pegawaiTable" class="table table-striped table-bordered">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Kontak</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="pegawaiData"></tbody>
    </table>
</div>
@endsection

@section('scripttambahan')
<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
<script>
    let pegawaiDataList = [];

    function fetchPegawai() {
    const apiUrl = "{{ env('API_URL') }}/users";
    const token = Cookies.get('token');

    fetch(apiUrl, {
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const table = $('#pegawaiTable');

        if ($.fn.DataTable.isDataTable('#pegawaiTable')) {
            table.DataTable().destroy();
        }

        const tableBody = document.getElementById('pegawaiData');
        tableBody.innerHTML = '';

        if (!Array.isArray(data)) {
            alert('Format data pegawai tidak sesuai');
            return;
        }

        data.forEach((pegawai, index) => {
            const row = document.createElement('tr');
            row.classList.add('text-center');

            row.innerHTML = `
                <td>${index + 1}</td>
                <td class="text-start">${pegawai.nama_user}</td>
                <td class="text-start">${pegawai.email}</td>
                <td class="text-start">${pegawai.no_hp}</td>
                <td>
                    <a href="/owner/pegawai-edit?id=${pegawai.id}" class="btn btn-sm btn-warning me-1">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button onclick="hapusPegawai(${pegawai.id})" class="btn btn-sm btn-danger">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        });

        table.DataTable({
            paging: true,
            searching: true,
            ordering: true
        });
    })
    .catch(error => {
        console.error('Gagal fetch:', error);
        alert('Gagal memuat data pegawai');
    });
}

    function hapusPegawai(id) {
        if (!confirm('Yakin ingin menghapus pegawai ini?')) return;

        const token = Cookies.get('token');
        fetch(`{{ env('API_URL') }}/users/${id}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(result => {
            alert(result.message || 'Pegawai dihapus');
            fetchPegawai(); // Refresh tabel
        })
        .catch(error => {
            console.error('Gagal menghapus:', error);
            alert('Terjadi kesalahan saat menghapus pegawai');
        });
    }

    document.addEventListener('DOMContentLoaded', fetchPegawai);
</script>
@endsection
