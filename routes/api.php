<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentWebhookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Webhook Routes (tanpa CSRF protection)
Route::post('webhook/xendit/invoice', [PaymentWebhookController::class, 'xenditInvoiceCallback']);

// Test webhook untuk development (optional)
Route::post('webhook/xendit/test', [PaymentWebhookController::class, 'testWebhook']);
