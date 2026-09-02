<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/about', 'about')->name('about');

Route::view('/how-it-works', 'how-it-works')->name('how-it-works');

Route::view('/families', 'families')->name('families');

Route::view('/providers', 'providers')->name('providers');

Route::view('/institutions', 'institutions')->name('institutions');

Route::view('/pricing', 'pricing')->name('pricing');

Route::view('/contact', 'contact')->name('contact');

Route::view('/solutions', 'solutions')->name('solutions');
