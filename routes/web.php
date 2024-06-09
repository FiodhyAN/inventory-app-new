<?php

use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PengajuanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan')->middleware('userHasDept');
    Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');
    
    Route::put('/pengajuan/retur', [PengajuanController::class, 'return'])->name('pengajuan.retur');
    
    Route::get('/about', function () {
        return view('about');
    })->name('about');
});

Route::group(['middleware' => ['auth', 'isSuperadmin'], 'prefix' => 'superadmin'], function () {
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class, 'index'])->name('superadmin.users.index');
        Route::post('/store', [UserController::class, 'store'])->name('superadmin.user.store');
        Route::put('/update', [UserController::class, 'update'])->name('superadmin.user.update');
        Route::post('/update-admin', [UserController::class, 'updateAdmin'])->name('superadmin.user.update-admin');
        Route::get('/edit', [UserController::class, 'edit'])->name('superadmin.user.edit');
        Route::delete('/delete', [UserController::class, 'destroy'])->name('superadmin.user.delete');
        Route::put('/update-department', [UserController::class, 'updateDepartment'])->name('superadmin.user.updateDepartemen');
    });

    Route::group(['prefix' => 'department'], function () {
        Route::post('/store', [DepartemenController::class, 'store'])->name('superadmin.department.store');
        Route::put('/update', [DepartemenController::class, 'update'])->name('superadmin.department.update');
        Route::delete('/delete', [DepartemenController::class, 'destroy'])->name('superadmin.department.delete');
    });
});

Route::group(['middleware' => ['auth', 'isAdmin'], 'prefix' => 'admin-menu'], function () {
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', [KategoriBarangController::class, 'index'])->name('admin.categories.index');
        Route::get('/edit', [KategoriBarangController::class, 'edit'])->name('admin.categories.edit');
        Route::post('/store', [KategoriBarangController::class, 'store'])->name('admin.categories.store');
        Route::put('/update', [KategoriBarangController::class, 'update'])->name('admin.categories.update');
        Route::delete('/delete', [KategoriBarangController::class, 'destroy'])->name('admin.categories.delete');
    });

    Route::group(['prefix' => 'barangs'], function () {
        Route::get('/', [BarangController::class, 'index'])->name('admin.barangs.index');
        Route::post('/store', [BarangController::class, 'store'])->name('admin.barangs.store');
        Route::put('/update-kategori', [BarangController::class, 'updateKategori'])->name('admin.barangs.updateKategori');
        Route::get('/edit', [BarangController::class, 'edit'])->name('admin.barangs.edit');
        Route::put('/update', [BarangController::class, 'update'])->name('admin.barangs.update');
    });

    Route::prefix('pengajuan')->group(function () {
        Route::put('/accept', [PengajuanController::class, 'accept'])->name('admin.pengajuan.accept');
        Route::put('/reject', [PengajuanController::class, 'reject'])->name('admin.pengajuan.reject');
    });
    Route::get('/perjalanan/{barang}', [BarangController::class, 'perjalanan'])->name('admin.barang.perjalanan');
});

require __DIR__ . '/auth.php';