<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;

Route::get('/', function () {
    return view('welcome');
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
    Route::post('/logout', 'logout')->name('logout');

});
Route::middleware(['auth'])->group(function () {

    Route::controller(ProjectController::class)->group(function () {
        Route::get('/project', 'getAllProjects')->name('projectbyid');
        Route::get('/add_project', 'index')->name('add_project');
        Route::post('/simpan', 'store')->name('project.store');

    });
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');

    });

});