<?php

use App\Http\Controllers\PropertyCategoryController;
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


Route::get('categories', [PropertyCategoryController::class, 'index'])->name('categories.index');

Route::post('properties', [PropertyController::class, 'store'])->name('properties.store');
Route::get('properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('properties/{property}', [PropertyController::class, 'show'])->name('properties.show');
Route::put('properties/{property}', [PropertyController::class, 'update'])->name('properties.update');

Route::get('properties/search', function () {
    return Inertia::render('Properties/Search');
})->name('properties.search');
