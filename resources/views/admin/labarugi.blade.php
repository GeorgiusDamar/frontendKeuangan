@extends('layouts.main')

@section('judul')
    Laporan Laba Rugi
@endsection

@section('container')
<div class="container my-4"> 

    <form id="filter-form" class="row g-3 mb-4">
        <div class="col-md-3">
            <label for="awal" class="form-label">Dari Tanggal:</label>
            <input type="date" id="awal" class="form-control" value="{{ date('Y-m-01') }}">
        </div>
        <div class="col-md-3">
            <label for="akhir" class="form-label">Sampai Tanggal:</label>
            <input type="date" id="akhir" class="form-control" value="{{ date('Y-m-d') }}">
        </div>
        <div class="col-md-3 align-self-end">
            <button type="submit" class="btn btn-primary">Tampilkan</button>
        </div>
    </form>

    <div id="labarugi-container">
        <div>
            <h5>Pendapatan</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kode Akun</th>
                        <th>Nama Akun</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="pendapatan-body"></tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-end">Total Pendapatan</th>
                        <th id="total-pendapatan">Rp 0</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div>
            <h5>Beban</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kode Akun</th>
                        <th>Nama Akun</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="beban-body"></tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-end">Total Beban</th>
                        <th id="total-beban">Rp 0</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="mt-4">
            <h5 class="text-end">Laba Bersih: <span id="laba-bersih">Rp 0</span></h5>
        </div>
    </div>
</div>
@endsection

@section('scripttambahan')
<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.5/dist/js.cookie.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const token = Cookies.get('token');
        const baseUrl = "{{ env('API_URL') }}";

        function formatRupiah(value) {
            return 'Rp ' + Number(value).toLocaleString('id-ID');
        }

        const loadLabaRugi = (awal, akhir) => {
            fetch(`${baseUrl}/laba-rugi?awal=${awal}&akhir=${akhir}`, {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.status === "success") {
                    const data = result.data;

                    const tbodyPendapatan = document.getElementById('pendapatan-body');
                    const tbodyBeban = document.getElementById('beban-body');
                    const totalPendapatan = document.getElementById('total-pendapatan');
                    const totalBeban = document.getElementById('total-beban');
                    const labaBersih = document.getElementById('laba-bersih');

                    tbodyPendapatan.innerHTML = '';
                    tbodyBeban.innerHTML = '';

                    data.pendapatan.forEach(item => {
                        tbodyPendapatan.innerHTML += `<tr>
                            <td>${item.kode_akun}</td>
                            <td>${item.nama_akun}</td>
                            <td>${formatRupiah(item.total)}</td>
                        </tr>`;
                    });

                    data.beban.forEach(item => {
                        tbodyBeban.innerHTML += `<tr>
                            <td>${item.kode_akun}</td>
                            <td>${item.nama_akun}</td>
                            <td>${formatRupiah(item.total)}</td>
                        </tr>`;
                    });

                    totalPendapatan.textContent = formatRupiah(data.total_pendapatan);
                    totalBeban.textContent = formatRupiah(data.total_beban);
                    labaBersih.textContent = formatRupiah(data.laba_bersih);
                }
            })
            .catch(error => console.error('Gagal fetch data laporan:', error));
        }

        const form = document.getElementById('filter-form');
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const awal = document.getElementById('awal').value;
            const akhir = document.getElementById('akhir').value;
            loadLabaRugi(awal, akhir);
        });

        loadLabaRugi(document.getElementById('awal').value, document.getElementById('akhir').value);
    });
</script>
@endsection
