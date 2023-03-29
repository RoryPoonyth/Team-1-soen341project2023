<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;



Route::get('/',  HomeController::class)
    ->name('listings.index');



Route::get('/new', [ListingController::class, 'create'])
    ->middleware('auth')
    ->name('listings.create');

Route::post('/new', [ListingController::class, 'store'])
    ->name('listings.store');

Route::get('/dashboard', [ListingController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    

Route::get('/{listing}', function(Listing $listing, Request $request){
    return view('applications.show', compact('listing'));
})->name('applications.show');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';

Route::get('/{listing}', [ListingController::class, 'show'])
    ->name('listings.show');

Route::get('/{listing}/apply', [ListingController::class, 'apply'])
    ->name('listings.apply');
