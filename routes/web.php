<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;


//Home page
Route::get('/',  HomeController::class)
    ->name('listings.index');

//Account dashboard -> contains either listings you have created or Listings applied to 
Route::get('/dashboard', [ListingController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

//Creating new Listing
Route::get('/new', [ListingController::class, 'create'])
    ->middleware('auth')
    ->name('listings.create');

Route::post('/new', [ListingController::class, 'store'])
    ->name('listings.store');


//show listings
Route::get('/{listing}', [ListingController::class, 'show'])
    ->name('listings.show');

//Create an application
Route::get('/{listing}/apply', [ApplicationController::class, 'create'])
    ->name('applications.create');
Route::post('/{listing}/apply', [ApplicationController::class, 'store'])
    ->name('applications.store');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';