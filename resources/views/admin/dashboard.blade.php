@extends('layouts.main')

@section('container')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body text-center p-5">
                    <h1 class="display-5 mb-3">Halo, <span class="namaUser text-primary">USERNAME</span> 👋</h1>
                    <p class="lead text-muted">
                        Selamat datang di dashboard admin. Di sini kamu bisa mengelola transaksi dan akun rekening.
                    </p>
                    <hr class="my-4">

                    <div class="row text-center">
                        <!-- Akun -->
                        <div class="col-md-6 mb-3">
                            <div class="bg-light p-4 rounded shadow-sm h-100">
                                <i class="fas fa-wallet fa-2x text-success mb-2"></i>
                                <h5 class="mb-0">Akun</h5>
                                <small class="text-muted">Kelola daftar akun rekening</small>
                            </div>
                        </div>

                        <!-- Transaksi -->
                        <div class="col-md-6 mb-3">
                            <div class="bg-light p-4 rounded shadow-sm h-100">
                                <i class="fas fa-exchange-alt fa-2x text-primary mb-2"></i>
                                <h5 class="mb-0">Transaksi</h5>
                                <small class="text-muted">Lihat dan input transaksi</small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
