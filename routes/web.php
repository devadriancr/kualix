<?php

use Illuminate\Support\Facades\Route;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::resource('roles', App\Http\Controllers\RoleController::class)->except(['show']);
    Route::resource('permissions', App\Http\Controllers\PermissionController::class)->except(['show']);
    Route::resource('users', App\Http\Controllers\UserController::class)->except(['show']);

    Route::get('/',  [App\Http\Controllers\MaterialController::class, 'statistics'])->name('dashboard');
    Route::get('/dashboard', [App\Http\Controllers\MaterialController::class, 'statistics'])->name('dashboard');

    Route::get('materials/scan', [App\Http\Controllers\MaterialController::class, 'scan'])->name('materials.scan');
    Route::post('materials', [App\Http\Controllers\MaterialController::class, 'store'])->name('materials.store');
    Route::get('materials/{material}/inspection', [App\Http\Controllers\MaterialController::class, 'inspect'])->name('materials.inspect');
    Route::post('materials/{material}/inspection', [App\Http\Controllers\MaterialController::class, 'storeInspection'])->name('materials.storeInspection');
    Route::match(['get', 'post'], 'materials/validate', [App\Http\Controllers\MaterialController::class, 'validate'])->name('materials.validate');

    Route::get('materials', [App\Http\Controllers\MaterialController::class, 'index'])->name('materials.index');
    Route::get('materials/{id}/movements', [App\Http\Controllers\MaterialController::class, 'movements'])->name('materials.movements');
});


Route::get('print', [App\Http\Controllers\MaterialController::class, 'print'])->name('print');
