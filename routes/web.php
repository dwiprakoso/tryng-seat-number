<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BuyerController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\DiskonController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\BuyerCheckinController;
use App\Http\Controllers\Admin\CheckinController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OtsSalesController;
use App\Http\Controllers\PaymentWebhookController;
use App\Http\Controllers\Admin\DashboardController;

// Default route mengarah ke order.index
Route::get('/', [OrderController::class, 'index'])->name('order.index');

// Auth routes
Route::get('/sign-in', [AuthController::class, 'index'])->name('sign-in');
Route::post('/sign-in', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/checkin', [BuyerCheckinController::class, 'index'])->name('checkin.index');
Route::post('/checkin/process', [BuyerCheckinController::class, 'processCheckin'])->name('checkin.process');
Route::get('/checkin/stats', [BuyerCheckinController::class, 'getCheckinStats'])->name('checkin.stats');
Route::get('/checkin/history', [BuyerCheckinController::class, 'getCheckinHistory'])->name('checkin.history');
Route::get('/checkin/receipt/{id}', [BuyerCheckinController::class, 'printReceipt'])->name('checkin.receipt');

// Order routes (memindahkan route /order ke path lain untuk menghindari konflik)
Route::get('/orders', [OrderController::class, 'index'])->name('order.list');
Route::get('/order/create/{ticket_id}', [OrderController::class, 'create'])->name('order.create');
Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');

// Manual Payment routes
Route::get('/payment/manual/{external_id}', [OrderController::class, 'manualPayment'])->name('payment.manual');
Route::post('/payment/upload/{external_id}', [OrderController::class, 'uploadPaymentProof'])->name('payment.upload');

// Webhook routes (tanpa middleware auth)
Route::post('/webhook/xendit/invoice', [PaymentWebhookController::class, 'xenditInvoiceCallback'])
    ->name('webhook.xendit.invoice');

// Test webhook untuk development
Route::post('/webhook/test', [PaymentWebhookController::class, 'testWebhook'])
    ->name('webhook.test');

// Payment routes
Route::get('/payment/success', function () {
    return view('payment.success');
})->name('payment.success');

Route::get('/payment/failed', function () {
    return view('payment.failed');
})->name('payment.failed');

Route::get('/ticket/verify/{external_id}', [TicketController::class, 'verify'])->name('ticket.verify');

// Protected admin routes
Route::middleware('auth')->group(function () {
    // Dashboard admin
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/event', [ProductController::class, 'index'])->name('admin.event.index');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');

    Route::get('/tickets', [TicketController::class, 'index'])->name('admin.tickets.index');
    Route::post('/tickets', [TicketController::class, 'store'])->name('admin.tickets.store');
    Route::put('/tickets/{id}', [TicketController::class, 'update'])->name('admin.tickets.update');
    Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('admin.tickets.destroy');

    Route::get('/discounts', [DiskonController::class, 'index'])->name('admin.discounts.index');
    Route::post('/discounts', [DiskonController::class, 'store'])->name('admin.discounts.store');
    Route::get('/discounts/{discount}/edit', [DiskonController::class, 'edit'])->name('admin.discounts.edit');
    Route::put('/discounts/{discount}', [DiskonController::class, 'update'])->name('admin.discounts.update');

    // Route::get('/buyer', [BuyerController::class, 'index'])->name('admin.buyer.index');
    // Route::get('/export-buyers', [BuyerController::class, 'export'])->name('admin.buyer.export');

    // Admin payment confirmation routes
    // Route::post('/buyer/{id}/confirm-payment', [BuyerController::class, 'confirmPayment'])->name('admin.buyer.confirm-payment');
    // Route::post('/buyer/{id}/reject-payment', [BuyerController::class, 'rejectPayment'])->name('admin.buyer.reject-payment');

    // Existing buyer routes
    Route::get('/buyer', [BuyerController::class, 'index'])->name('admin.buyer.index');
    Route::get('/buyer/export', [BuyerController::class, 'export'])->name('admin.buyer.export');

    // New payment confirmation routes
    Route::get('/buyer/{id}/payment-proof', [BuyerController::class, 'getPaymentProof'])->name('admin.buyer.payment-proof');
    Route::post('/buyer/{id}/confirm-payment', [BuyerController::class, 'confirmPayment'])->name('admin.buyer.confirm-payment');
    Route::post('/buyer/{id}/reject-payment', [BuyerController::class, 'rejectPayment'])->name('admin.buyer.reject-payment');

    Route::get('/checkin-list', [CheckinController::class, 'index'])->name('admin.checkin.index');

    Route::get('ots-sales', [OtsSalesController::class, 'index'])->name('admin.ots-sales.index');
    Route::post('ots-sales', [OtsSalesController::class, 'store'])->name('admin.ots-sales.store');
    Route::get('ots-sales/{id}/receipt', [OtsSalesController::class, 'receipt'])->name('admin.ots-sales.receipt');
    Route::delete('ots-sales/{id}', [OtsSalesController::class, 'destroy'])->name('admin.ots-sales.destroy');
    Route::get('/ots-sales/export', [OtsSalesController::class, 'export'])->name('admin.ots-sales.export');
});
