<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('organisation', 'organisation')
    ->middleware(['auth', 'verified'])
    ->name('organisation');

Route::view('projects', 'projects')
    ->middleware(['auth', 'verified'])
    ->name('projects');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
