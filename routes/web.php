<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/beranda', [Dashboard::class, 'index'])->name('beranda');
