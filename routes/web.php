<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AbsensiController;
use Illuminate\Support\Carbon;

Route::get('/', function () {
    return view('signin');
});
Route::get('/signup', function () {
    return view('signup');
})->name('signup');

Route::get('/login', function () {
    return view('signin');
})->name('signin');

Route::controller(LoginController::class)->group(function () {
    Route::post('/signup', 'signup')->name('signup');
    Route::post('/login', 'authenticate')->name('login');
    Route::get('/logout', 'logout')->name('logout');

});
Route::middleware(['auth'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');

    });

    Route::controller(AbsensiController::class)->group(function () {
        Route::post('/api/start-timer', 'startTimer')->name('start.timer');
        Route::post('/api/stop-timer', 'stopTimer')->name('stop.timer');
        Route::get('/api/active-timer', 'getActiveTimer')->name('active.timer');
        Route::get('/api/history-istirahat', 'historyIstirahat')->name('history.istirahat');
    });


Route::get('/server-time', function () {
    return response()->json([
        'server_time' => Carbon::now()->format('Y-m-d H:i:s')
    ]);
});

});