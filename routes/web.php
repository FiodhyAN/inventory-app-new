<?php

use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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
});

Route::group(['middleware' => ['auth', 'isSuperadmin'], 'prefix' => 'superadmin'], function () {
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class, 'index'])->name('superadmin.users.index');
        Route::post('/store', [UserController::class, 'store'])->name('superadmin.user.store');
        Route::put('/update', [UserController::class, 'update'])->name('superadmin.user.update');
        Route::post('/update-admin', [UserController::class, 'updateAdmin'])->name('superadmin.user.update-admin');
        Route::get('/edit', [UserController::class, 'edit'])->name('superadmin.user.edit');
        Route::delete('/delete', [UserController::class, 'destroy'])->name('superadmin.user.delete');
        Route::put('/update-department', [UserController::class, 'updateDepartment'])->name('superadmin.user.updateDepartement');
    });

    Route::group(['prefix' => 'department'], function () {
        Route::post('/store', [DepartemenController::class, 'store'])->name('superadmin.department.store');
    });
});

require __DIR__ . '/auth.php';
