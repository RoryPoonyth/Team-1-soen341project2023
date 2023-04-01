<?php

use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListingController;

Route::get('/', HomeController::class)
    ->name('listings.index');

// Route::get('/', [Controllers\ListingController::class, 'index'])
//     ->name('listings.index');

Route::get('/new', [Controllers\ListingController::class, 'create'])
    ->name('listings.create');

Route::post('/new', [Controllers\ListingController::class, 'store'])
    ->name('listings.store');

    Route::get('/{listing}/apply', [ApplicationController::class, 'create'])
    ->name('applications.create');

Route::post('/{listing}/apply', [ApplicationController::class, 'store'])
    ->name('applications.store');

Route::get('/dashboard', [ListingController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/dashboard/{listing}', [ApplicationController::class, 'index'])
    ->name('applications.show');

Route::get('/dashboard/{id}/update', [ApplicationController::class, 'edit'])
    ->name('applications.edit');

Route::patch('/dashboard/{id}/update', [ApplicationController::class, 'update'])
    ->name('applications.update');

Route::get('/dashboard/update/{listing}', [ListingController::class, 'edit'])
    ->name('listings.edit');

Route::patch('/dashboard/update/{listing}', [ListingController::class, 'update'])
    ->name('listings.update');



// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';

Route::get('/{listing}', [Controllers\ListingController::class, 'show'])
    ->name('listings.show');


