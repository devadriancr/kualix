<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('materials/scan', [App\Http\Controllers\MaterialController::class, 'scan'])->name('label-scan');
    Route::get('materials/{material}/inspection', [App\Http\Controllers\MaterialController::class, 'inspect'])->name('materials.inspect');
    Route::post('materials/{material}/inspection', [App\Http\Controllers\MaterialController::class, 'storeInspection'])->name('materials.storeInspection');

    Route::resource('materials', App\Http\Controllers\MaterialController::class);
});
