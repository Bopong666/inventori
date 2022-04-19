<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\MasukComponent;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\BarangComponent;
use App\Http\Livewire\KeluarComponent;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Livewire\KategoriComponent;
use App\Http\Livewire\PenggunaComponent;
use App\Http\Livewire\PuskesmasComponent;
use App\Http\Livewire\PermintaanComponent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

route::middleware(['auth'])->group(function () {
    Route::get('/barang', BarangComponent::class)->name('barang');
    Route::get('/kategori', KategoriComponent::class)->name('kategori');
    Route::get('/puskesmas', PuskesmasComponent::class)->name('puskesmas');
    Route::get('/masuk', MasukComponent::class)->name('masuk');
    Route::get('/keluar', KeluarComponent::class)->name('keluar');
    Route::get('/permintaan', PermintaanComponent::class)->name('permintaan');
    Route::get('/laporan-barang', [LaporanController::class, 'barang'])->name('laporan-barang');
    Route::get('/laporan-permintaan', [LaporanController::class, 'permintaan'])->name('laporan-permintaan');
    Route::get('/penguna', PenggunaComponent::class)->name('pengguna');
});

Route::fallback(function () {
    return view('404');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
