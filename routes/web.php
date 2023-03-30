<?php

use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

Route::get('/', [Controllers\ListingController::class, 'index'])
    ->name('listings.index');

Route::get('/new', [Controllers\ListingController::class, 'create'])
    ->name('listings.create');

Route::post('/new', [Controllers\ListingController::class, 'store'])
    ->name('listings.store');

Route::post('/{listing}/apply', [ApplicationController::class, 'store'])->name('applications.store');

Route::get('/dashboard', function () 
{
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';

Route::get('/{listing}', [Controllers\ListingController::class, 'show'])
    ->name('listings.show');

Route::get('/{listing}/apply', [ApplicationController::class, 'create'])->name('applications.create');
