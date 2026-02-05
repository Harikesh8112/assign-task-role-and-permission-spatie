<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    
    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('genurls', App\Http\Controllers\GenerateURLsController::class);
    Route::resource('clients', App\Http\Controllers\ClientController::class);

    Route::get('/invite', [App\Http\Controllers\GenerateURLsController::class, 'invite'])->name('genurls.invite');

    Route::get('/hits/{code}', [App\Http\Controllers\GenerateURLsController::class, 'hits_urls'])->name('hits.urls');

    Route::get('/genurls/pdf/download', [App\Http\Controllers\GenerateURLsController::class, 'genurlsPdfDownload'])->name('genurls.pdf.download');
   
});

require __DIR__.'/auth.php';
