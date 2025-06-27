@extends('layouts.main')

@section('judul')
    Dashboard GUEST
@endsection

@section('container')
    <div class="card">
        <div class="card-header">
            <h2>HALO, <span class="namaUser">USERNAME</span></h2> <!-- Dynamically filled from JS -->
        </div>
        <div class="card-body">
            <p>Welcome to your dashboard</p>
        </div>
    </div>
@endsection
 