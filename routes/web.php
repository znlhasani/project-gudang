<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangInController;
use App\Http\Controllers\BarangOutController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\LogHistoryController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Models\BarangIn;

// Landing
Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Auth::routes();

// Dashboard & Home
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// ✅ Middleware: semua yang butuh login
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/Mainpage', function () {
        return view('mainpage');
    })->name('mainpage');

    // Barang Masuk & Keluar
    Route::resource('barang_in', BarangInController::class);
    Route::resource('barang_out', BarangOutController::class);

    // Stock
    Route::get('/Stock', [StockController::class, 'index'])->name('stock.index');

    // Log
    Route::get('/logactivity', [LogActivityController::class, 'index'])->name('logactivity.index');
    Route::get('/loghistory', [LogHistoryController::class, 'index'])->name('loghistory.index');
    Route::resource('log_activity', LogActivityController::class);
    Route::resource('log_history', LogHistoryController::class);

    // About
    Route::get('/about-us', function () {
        return view('about');
    })->name('about');

    // Autocomplete barang
    Route::get('/barang/search', function (Request $request) {
        $query = $request->get('q');
        $barang = BarangIn::where('nama_barang', 'like', "%{$query}%")
            ->pluck('nama_barang');
        return response()->json($barang);
    });

    // Custom logout
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});

// ✅ Middleware: khusus admin
Route::middleware(['auth', 'admin'])->group(function () {
    // Barang Master
    Route::get('/BarangMaster', [BarangController::class, 'index'])->name('barang.master');
    Route::resource('barang', BarangController::class);

    // User management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/make-admin', [UserController::class, 'makeAdmin'])->name('users.makeAdmin');
    Route::post('/users/{user}/make-user', [UserController::class, 'makeUser'])->name('users.makeUser');
});
