<?php

use App\Http\Controllers\BPGWebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



Route::prefix('v1')->group(function () {
    Route::post('/payment-webhook', BPGWebhookController::class)->name('payments.webhook');
});
