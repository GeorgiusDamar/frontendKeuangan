@extends('layouts.main')

@section('judul')
    Laporan Neraca
@endsection

@section('container')
<div class="container my-4">

    <form id="filter-form" class="row g-3 mb-4">
        <div class="col-auto">
            <label for="tanggal" class="form-label">Per Tanggal:</label>
            <input type="date" id="tanggal" class="form-control" value="{{ date('Y-m-d') }}">
        </div>
        <div class="col-auto align-self-end">
            <button type="submit" class="btn btn-primary">Tampilkan</button>
        </div>
    </form>

    <div id="neraca-container">
        @foreach (['aset' => 'Aset', 'kewajiban' => 'Kewajiban', 'ekuitas' => 'Ekuitas'] as $key => $label)
            <div id="{{ $key }}">
                <h5>{{ $label }}</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kode Akun</th>
                            <th>Nama Akun</th>
                            <th>Saldo</th>
                        </tr>
                    </thead>
                    <tbody id="{{ $key }}-body"></tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2" class="text-end">Total {{ $label }}</th>
                            <th id="{{ $key }}-total">Rp 0</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripttambahan')
<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.5/dist/js.cookie.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const token = Cookies.get('token');
        const baseUrl = "{{ env('API_URL') }}";

        const loadNeraca = (tanggal) => {
            fetch(`${baseUrl}/neraca?tanggal=${tanggal}`, {
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

                    const renderTable = (jenis, elementId, totalId) => {
                        const tbody = document.getElementById(elementId);
                        const totalElem = document.getElementById(totalId);
                        tbody.innerHTML = '';

                        data[jenis].akun.forEach(item => {
                            const row = `<tr>
                                <td>${item.kode_akun}</td>
                                <td>${item.nama_akun}</td>
                                <td>Rp ${Number(item.saldo).toLocaleString('id-ID')}</td>
                            </tr>`;
                            tbody.innerHTML += row;
                        });

                        totalElem.textContent = 'Rp ' + Number(data[jenis].total).toLocaleString('id-ID');
                    }

                    renderTable('aset', 'aset-body', 'aset-total');
                    renderTable('kewajiban', 'kewajiban-body', 'kewajiban-total');
                    renderTable('ekuitas', 'ekuitas-body', 'ekuitas-total');
                }
            })
            .catch(error => console.error('Gagal fetch data neraca:', error));
        }

        const form = document.getElementById('filter-form');
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const tanggal = document.getElementById('tanggal').value;
            console.log("push");
            loadNeraca(tanggal);
        });

        // Initial load
        loadNeraca(document.getElementById('tanggal').value);
    });
</script>
@endsection
