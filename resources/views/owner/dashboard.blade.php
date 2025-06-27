@extends('layouts.main')
@section('container')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body text-center p-5">
                        <h1 class="display-5 mb-3">Halo, <span class="namaUser text-primary">USERNAME</span> 👋</h1>
                        <p class="lead text-muted">
                            Selamat datang di dashboard! Di sini kamu bisa melihat laporan dan mengelola pegawai.
                        </p>
                        <hr class="my-4">

                        <!-- Box Kelola Pegawai (Full Width) -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="bg-light p-4 rounded shadow-sm h-100 d-flex align-items-center justify-content-center flex-column">
                                    <i class="fas fa-user-cog fa-2x text-info mb-2"></i>
                                    <h5 class="mb-0">Kelola Pegawai</h5>
                                    <small class="text-muted">Tambah, edit & hapus pegawai</small>
                                </div>
                            </div>
                        </div>

                        <!-- 4 Box Sejajar -->
                        <div class="row text-center">
                            <!-- Jurnal Umum -->
                            <div class="col-md-3 mb-3">
                                <div class="bg-light p-4 rounded shadow-sm h-100">
                                    <i class="fas fa-book fa-2x text-primary mb-2"></i>
                                    <h6 class="mb-0">Jurnal Umum</h6>
                                    <small class="text-muted">Catatan transaksi</small>
                                </div>
                            </div>
                            <!-- Buku Besar -->
                            <div class="col-md-3 mb-3">
                                <div class="bg-light p-4 rounded shadow-sm h-100">
                                    <i class="fas fa-book-open fa-2x text-success mb-2"></i>
                                    <h6 class="mb-0">Buku Besar</h6>
                                    <small class="text-muted">Ringkasan akun</small>
                                </div>
                            </div>
                            <!-- Neraca -->
                            <div class="col-md-3 mb-3">
                                <div class="bg-light p-4 rounded shadow-sm h-100">
                                    <i class="fas fa-balance-scale-left fa-2x text-warning mb-2"></i>
                                    <h6 class="mb-0">Neraca</h6>
                                    <small class="text-muted">Posisi keuangan</small>
                                </div>
                            </div>
                            <!-- Laba Rugi -->
                            <div class="col-md-3 mb-3">
                                <div class="bg-light p-4 rounded shadow-sm h-100">
                                    <i class="fas fa-file-invoice-dollar fa-2x text-danger mb-2"></i>
                                    <h6 class="mb-0">Laba Rugi</h6>
                                    <small class="text-muted">Pendapatan vs Beban</small>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
