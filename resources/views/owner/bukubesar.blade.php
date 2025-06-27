@extends('layouts.main')
 

@section('container')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Buku Besar Akuntansi</h2>
        <div id="ledger-container">
            <p class="text-center">Memuat data buku besar...</p>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.5/dist/js.cookie.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const apiUrl = "{{ env('API_URL') }}/bukubesar";
    const token = Cookies.get('token');

    fetch(apiUrl, {
        headers: {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(result => {
        if (result.status === "success") {
            const data = result.data;
            const container = document.getElementById('ledger-container');
            container.innerHTML = '';

            for (const [namaAkun, transaksi] of Object.entries(data)) {
                const card = document.createElement('div');
                card.className = 'card mb-4';

                const header = document.createElement('div');
                header.className = 'card-header';
                header.innerHTML = `<h4>Akun ${namaAkun}</h4>`;

                const body = document.createElement('div');
                body.className = 'card-body';

                const table = document.createElement('table');
                table.className = 'table table-bordered';
                table.innerHTML = `
                    <thead>
                        <tr>
                            <th>No Bukti</th>
                            <th>Tanggal</th>
                            <th>Deskripsi</th>
                            <th>Debit (Rp)</th>
                            <th>Kredit (Rp)</th>
                            <th>Saldo (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${transaksi.map(item => `
                            <tr>
                                <td>${item.no_bukti}</td>
                                <td>${item.waktu}</td>
                                <td>${item.deskripsi}</td>
                                <td>${item.masuk > 0 ? item.masuk.toLocaleString('id-ID') : ''}</td>
                                <td>${item.keluar > 0 ? item.keluar.toLocaleString('id-ID') : ''}</td>
                                <td>${item.saldo.toLocaleString('id-ID')}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                `;

                body.appendChild(table);
                card.appendChild(header);
                card.appendChild(body);
                container.appendChild(card);
            }
        } else {
            document.getElementById('ledger-container').innerHTML = "<p class='text-danger'>Gagal memuat data buku besar.</p>";
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('ledger-container').innerHTML = "<p class='text-danger'>Terjadi kesalahan saat mengambil data.</p>";
    });
});
</script>
@endpush
