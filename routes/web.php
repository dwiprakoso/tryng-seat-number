<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BuyerController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\DiskonController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController;

// Auth routes
Route::get('/sign-in', [AuthController::class, 'index'])->name('sign-in');
Route::post('/sign-in', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected admin routes
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/event', [ProductController::class, 'index'])->name('admin.event.index');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');

    Route::get('tickets', [TicketController::class, 'index'])->name('admin.tickets.index');
    Route::post('tickets', [TicketController::class, 'store'])->name('admin.tickets.store');
    Route::put('tickets/{id}', [TicketController::class, 'update'])->name('admin.tickets.update');
    Route::delete('tickets/{id}', [TicketController::class, 'destroy'])->name('admin.tickets.destroy');

    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/ticket', [TicketController::class, 'index'])->name('admin.ticket.index');
    Route::get('/diskon', [DiskonController::class, 'index'])->name('admin.diskon.index');
    Route::get('/buyer', [BuyerController::class, 'index'])->name('admin.buyer.index');
});
