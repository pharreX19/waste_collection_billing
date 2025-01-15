<?php

use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Redirect()->route('login');
});

Route::get('login', function () {
    return Inertia::render('Dashboard');
    // return Inertia::render('Auth/Login');
})->name('login');



Route::get('properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('properties/search', [PropertyController::class, 'search'])->name('properties.search');
Route::get('properties/{id}', [PropertyController::class, 'show'])->name('properties.show');
