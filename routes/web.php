<?php

use Illuminate\Support\Facades\Route;

Route::redirect('login', 'app/login')->name('login');
Route::redirect('register', 'app/register')->name('register');
Route::redirect('dashboard', 'app')->name('dashboard');
