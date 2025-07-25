<?php

use App\Livewire\RegisterForm;
use App\Livewire\MainPage;
use App\Livewire\BlogPage;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use App\Models\Submission;
use Illuminate\Support\Facades\Storage;

/* NOTE: Do Not Remove
/ Livewire asset handling if using sub folder in domain
*/
Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});
/*
/ END
*/
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',MainPage::class)->name('home');
Route::get('/blog', BlogPage::class)->name('blog');
Route::get('/register', RegisterForm::class)->name('register-form');