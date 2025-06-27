@extends('layouts.main')

@section('judul')
    Daftar Transaksi
@endsection

@section('container')
    <button class="btn btn-primary"
    id="addTransactionButton"
    onclick="window.location='{{ route('admin.transaksi.tambah') }}'">
    <i class="fas fa-plus"></i> Tambah
    </button>

    <hr>

    <div class="table-responsive">
        <table id="transaksiTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Tipe</th>
                    <th class="text-center">Akun</th>
                    <th class="text-center">No Bukti</th>
                    <th class="text-center">Deskripsi</th>
                    <th class="text-center">Nominal</th>
                    <th class="text-center">Waktu</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="transactionData"></tbody>
        </table>
    </div>
@endsection

@section('scripttambahan')
<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
<script>
    let dataTableInstance = null;

    function fetchTransactions() {
        const apiUrl = "{{ env('API_URL') }}/transactions";
        const token = Cookies.get('token');

        if (!token) {
            alert('Token tidak ditemukan!');
            return;
        }

        fetch(apiUrl, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        })
        .then(res => res.json())
        .then(data => {
            if (!Array.isArray(data.data)) {
                alert('Data transaksi tidak valid!');
                return;
            }

            const tableBody = document.getElementById('transactionData');

            // Destroy dan hapus isi tabel lama
            if (dataTableInstance) {
                dataTableInstance.destroy();
            }
            tableBody.innerHTML = '';

            data.data.forEach((transaksi, index) => { 
                const row = document.createElement('tr');
                row.classList.add('text-center');

                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${transaksi.tipe_transaksi}</td>
                    <td class="text-start">${transaksi.nama_akun}</td>
                    <td class="text-start">${transaksi.no_bukti}</td>
                    <td class="text-start">${transaksi.deskripsi}</td>
                    <td class="text-end">${transaksi.nominal.toLocaleString()}</td>
                    <td class="text-left">${transaksi.waktu.toLocaleString()}</td> 
                    <td>
                        <a href="/admin/transaksi-edit?id=${transaksi.id}" class="btn btn-sm btn-warning me-1">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-sm btn-danger" onclick="hapusTransaksi(${transaksi.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                tableBody.appendChild(row);
            });

            // Reinisialisasi DataTable
            dataTableInstance = new DataTable('#transaksiTable', {
                paging: true,
                pageLength: 5,
                searching: true,
                ordering: true,
                destroy: true
            });
        })
        .catch(err => {
            console.error('Gagal mengambil data transaksi:', err);
            alert('Gagal mengambil data transaksi.');
        });
    }

    function hapusTransaksi(id) {
        if (!confirm('Yakin ingin menghapus transaksi ini?')) return;

        const token = Cookies.get('token');
        const apiUrl = `{{ env('API_URL') }}/transactions/${id}`;

        fetch(apiUrl, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message || 'Transaksi berhasil dihapus');
            // Refresh ulang data tabel
            fetchTransactions();
        })
        .catch(err => {
            console.error('Gagal menghapus transaksi:', err);
            alert('Gagal menghapus transaksi.');
        });
    }

    window.addEventListener('DOMContentLoaded', fetchTransactions);
</script>
@endsection
