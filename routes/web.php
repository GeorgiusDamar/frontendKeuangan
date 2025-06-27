<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/transaksi', function () {
        return view('admin.transaksi');
    })->name('admin.transaksi');

    Route::get('/transaksi/tambah', function () {
        return view('admin.transaksitambah');
    })->name('admin.transaksi.tambah');

    Route::get('/transaksi-edit', function () {
        return view('admin.transaksi-edit');
    })->name('admin.transaksi-edit');


    

    // pindah ke owner
    Route::get('/laporan', function () {
        return view('admin.laporan');
    })->name('admin.laporan');

    Route::get('/bukubesar', function () {
        return view('admin.bukubesar');
    })->name('admin.bukubesar');

    Route::get('/labarugi', function () {
        return view('admin.labarugi');
    })->name('admin.labarugi');

    Route::get('/neraca', function () {
        return view('admin.neraca');
    })->name('admin.neraca');



    // AKUN
    Route::get('/akun', function () {
        return view('admin.akun');
    })->name('admin.neraca');

    
    Route::get('/akun-edit', function () {
        return view('admin.akun-edit');
    })->name('admin.akun-edit');

    Route::get('/akun-tambah', function () {
        return view('admin.akun-tambah');
    })->name('admin.akun-tambah');


});


Route::prefix('owner')->group(function () {
    
    // DASHBOARD
    Route::get('/', function () {
        return view('owner.dashboard');
    })->name('owner.dashboard');

    
    // PEGAWAI
    Route::get('/pegawai', function () {
        return view('owner.pegawai');
    })->name('owner.pegawai');

    Route::get('/pegawai-tambah', function () {
        return view('owner.pegawai-tambah');
    })->name('owner.pegawai-tambah');

    Route::get('/pegawai-edit', function () {
        return view('owner.pegawai-edit');
    })->name('owner.pegawai-edit');



    // LAPORAN
    Route::get('/jurnal', function () {
        return view('owner.jurnal');
    })->name('owner.jurnal');

    Route::get('/bukubesar', function () {
        return view('owner.bukubesar');
    })->name('owner.bukubesar');

    Route::get('/labarugi', function () {
        return view('owner.labarugi');
    })->name('owner.labarugi');

    Route::get('/neraca', function () {
        return view('owner.neraca');
    })->name('owner.neraca');
});










// Guest
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');



Route::prefix('owner/dashboard')->group(function () {
    Route::get('/', function () {
        return view('owner.dashboard');
    })->name('owner.dashboard');
});


 