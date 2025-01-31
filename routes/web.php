<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PayableController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\PropertyCategoryController;
use App\Http\Controllers\PropertyController;
use App\Http\Middleware\isAdmin;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;


Route::get('login', function () {
    return Inertia::render('Auth/Login');
})->name('login');

Route::get('admin/login', function () {
    return Inertia::render('Auth/AdminLogin');
})->name('login.admin');



Route::post('auth/otp', [AuthController::class, 'getOtpForLogin'])->name('auth.otp');
Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');

Route::post('login', [AuthController::class, 'adminLogin'])->name('auth.admin-login');


Route::middleware(['auth'])->group(function () {

    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('categories', [PropertyCategoryController::class, 'index'])->name('categories.index');

    Route::get('properties/{property}/payables', [PayableController::class, 'index'])->name('payables.index');

    Route::post('payments', [PaymentController::class, 'store'])->name('payments.store');

    Route::middleware([isAdmin::class])->group(function () {
        Route::get('properties/search', function () {
            return Inertia::render('Properties/Search');
        })->name('properties.search');

        Route::get('/', DashboardController::class)->name('dashboard');

        Route::post('properties', [PropertyController::class, 'store'])->name('properties.store');
        Route::get('properties', [PropertyController::class, 'index'])->name('properties.index');
        Route::get('properties/{property}', [PropertyController::class, 'show'])->name('properties.show');
        Route::put('properties/{property}', [PropertyController::class, 'update'])->name('properties.update');
        Route::delete('properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');

        Route::get('payables/reports', [PayableController::class, 'reports'])->name('payables.reports');
        Route::get('payables/{payable}/print', [PayableController::class, 'print'])->name('payables.print');

        Route::get('people/{nid}/search', [PersonController::class, 'search'])->name('people.search');
    });

    // Route::get('properties/{property}/payments', [PaymentController::class, 'index'])->name('payments.index');
    // Route::get('payments/reports', [PaymentController::class, 'reports'])->name('payments.reports');
});
