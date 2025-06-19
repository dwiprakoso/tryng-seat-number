<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BuyerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DiskonController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\TicketController;

// Auth routes
Route::get('/sign-in', [AuthController::class, 'index'])->name('sign-in');
Route::post('/sign-in', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected admin routes
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/event', [EventController::class, 'index'])->name('admin.event.index');
    Route::get('/ticket', [TicketController::class, 'index'])->name('admin.ticket.index');
    Route::get('/diskon', [DiskonController::class, 'index'])->name('admin.diskon.index');
    Route::get('/buyer', [BuyerController::class, 'index'])->name('admin.buyer.index');
});
