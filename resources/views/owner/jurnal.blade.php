@extends('layouts.main')

@section('judul')
    Laporan Jurnal Umum
@endsection

@section('container')
    <!-- Form pilih Bulan & Tahun -->
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="bulan">Bulan</label>
            <select class="form-control" id="bulan">
                <option value="">-- Pilih Bulan --</option>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}">{{ DateTime::createFromFormat('!m', $i)->format('F') }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-3">
            <label for="tahun">Tahun</label>
            <input type="number" id="tahun" class="form-control" value="{{ date('Y') }}" min="2000">
        </div>
        <div class="col-md-3 align-self-end">
            <button class="btn btn-success" id="cekLaporan">
                <i class="fas fa-search"></i> Cek Laporan
            </button>
        </div>
    </div>

    <hr>

    <!-- Tabel Laporan Jurnal Umum -->
    <div class="table-responsive">
        <table id="laporanTable" class="table table-bordered table-striped">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>No Bukti</th>
                    <th>Nama Akun</th>
                    <th>Deskripsi</th>
                    <th>Debet</th>
                    <th>Kredit</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody id="laporanData"></tbody>
            <tfoot>
                <tr class="text-center">
                    <td colspan="4" style="font-weight:bold; text-align:center;">TOTAL</td>
                    <td id="totalDebet" style="text-align:right; font-weight:bold;">0</td>
                    <td id="totalKredit" style="text-align:right; font-weight:bold;">0</td>
                    <td id="totalSaldo" style="text-align:right; font-weight:bold;">0</td>
                </tr>
            </tfoot>
            
        </table>
    </div>
@endsection

@section('scripttambahan')
<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
<script>
    document.getElementById('cekLaporan').addEventListener('click', function() {
        const bulan = document.getElementById('bulan').value;
        const tahun = document.getElementById('tahun').value;

        if (!bulan || !tahun) {
            alert('Pilih bulan dan isi tahun terlebih dahulu!');
            return;
        }

        const apiUrl = "{{ env('API_URL') }}/reports/jurnal-umum";
        const token = Cookies.get('token');
        console.log(bulan, tahun, apiUrl);  

        if (!token) {
            alert('Token tidak tersedia!');
            return;
        }

        const urlWithParams = `${apiUrl}?bulan=${encodeURIComponent(bulan)}&tahun=${encodeURIComponent(tahun)}`;

        fetch(urlWithParams, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
            // Tidak ada body di GET
        })
        .then(response => {
            if (!response.ok) throw new Error('Gagal ambil data laporan!');
            return response.json();
        })
        .then(data => {
            // Kosongkan tabel dulu
            // Kosongkan tabel dulu
            const tbody = document.getElementById('laporanData');
            tbody.innerHTML = '';

            // Loop data laporan
            if (Array.isArray(data.data)) {
                data.data.forEach((laporan, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="text-center">${index + 1}</td>
                        <td class="text-center">${laporan.no_bukti}</td>
                        <td>${laporan.nama_akun}</td>
                        <td>${laporan.deskripsi}</td>
                        <td class="text-end">${laporan.debet.toLocaleString()}</td>
                        <td class="text-end">${laporan.kredit.toLocaleString()}</td>
                        <td class="text-end">${laporan.saldo.toLocaleString()}</td>
                    `;
                    tbody.appendChild(row);
                });

                // Tampilkan total di footer
                document.getElementById('totalDebet').innerText = data.total_masuk.toLocaleString();
                document.getElementById('totalKredit').innerText = data.total_keluar.toLocaleString();
                document.getElementById('totalSaldo').innerText = data.total_saldo.toLocaleString();
            } else {
                alert('Data laporan tidak valid.');
            }
        })
        .catch(error => {
            console.error(error);
            alert('Terjadi kesalahan! Periksa kembali input atau server.');
        });
    });
</script>
@endsection
