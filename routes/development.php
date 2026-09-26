<?php

use App\Http\Controllers\Account\DevelopmentController as Dev;
use Illuminate\Support\Facades\Route;

Route::get('/solutions/performance-confidence', [Dev::class, 'landing'])->name('development.landing');
Route::get('/development/login', [Dev::class, 'login'])->name('development.login');
Route::get('/development/sample-report', [Dev::class, 'sample'])->name('development.sample');
Route::get('/development/sample-report.pdf', [Dev::class, 'samplePdf'])->name('development.sample.pdf');
Route::get('/development/preview/{page}', [Dev::class, 'preview'])->name('development.preview');
Route::middleware('guest')->group(function () {
    Route::get('/development/register', [Dev::class, 'register'])->name('development.register');
    Route::post('/development/register', [Dev::class, 'storeAccount'])->middleware('throttle:5,1')->name('development.register.store');
});
Route::middleware('auth')->prefix('development')->name('development.')->group(function () {
    Route::get('/', [Dev::class, 'home'])->name('home');
    Route::get('/children/create', [Dev::class, 'child'])->name('child');
    Route::post('/children', [Dev::class, 'storeChild'])->name('child.store');
    Route::get('/children/{child}/assessment/{step}', [Dev::class, 'assessment'])->whereNumber(['child', 'step'])->name('assessment');
    Route::post('/children/{child}/assessment/{step}', [Dev::class, 'saveAssessment'])->whereNumber(['child', 'step'])->name('assessment.save');
    Route::get('/reports/{assessment}', [Dev::class, 'report'])->whereNumber('assessment')->name('report');
    Route::get('/providers', [Dev::class, 'providers'])->name('providers');
    Route::get('/providers/{provider}', [Dev::class, 'provider'])->whereNumber('provider')->name('provider');
    Route::post('/providers/{provider}/connect', [Dev::class, 'connect'])->whereNumber('provider')->name('connect');
    Route::get('/bookings', [Dev::class, 'bookings'])->name('bookings');
    Route::get('/plans', [Dev::class, 'plans'])->name('plans');
    Route::get('/checkout', [Dev::class, 'checkout'])->name('checkout');
});
