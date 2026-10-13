<?php

use App\Http\Controllers\Account\DevelopmentController as Dev;
use App\Http\Controllers\Account\ParentJourneyController;
use Illuminate\Support\Facades\Route;

Route::get('/development/parent-journey', [ParentJourneyController::class, 'index'])->name('development.screens');
Route::get('/development/screens/{screen}', [ParentJourneyController::class, 'show'])->name('development.screens.show');
Route::post('/development/screens/{screen}', [ParentJourneyController::class, 'save'])->middleware('throttle:60,1')->name('development.screens.save');

Route::get('/get-connected', [Dev::class, 'getConnected'])->name('get-connected');
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
    Route::get('/children/{child}/assessment-complete', [Dev::class, 'assessmentComplete'])->whereNumber('child')->name('assessment.complete');
    Route::get('/children/{child}/journey', [Dev::class, 'journey'])->whereNumber('child')->name('journey');
    Route::get('/children/{child}/details', [Dev::class, 'childDetails'])->whereNumber('child')->name('child.details');
    Route::post('/children/{child}/details', [Dev::class, 'saveChildDetails'])->whereNumber('child')->name('child.details.save');
    Route::get('/children/{child}/mindset/{question}', [Dev::class, 'mindset'])->whereNumber(['child', 'question'])->name('mindset');
    Route::post('/children/{child}/mindset/{question}', [Dev::class, 'saveMindset'])->whereNumber(['child', 'question'])->name('mindset.save');
    Route::get('/children/{child}/assessment/{step}', [Dev::class, 'assessment'])->whereNumber(['child', 'step'])->name('assessment');
    Route::post('/children/{child}/assessment/{step}', [Dev::class, 'saveAssessment'])->whereNumber(['child', 'step'])->name('assessment.save');
    Route::get('/reports/{assessment}/enquiry/{screen}', [ParentJourneyController::class, 'enquiry'])->whereNumber('assessment')->name('enquiry');
    Route::post('/reports/{assessment}/enquiry/{screen}', [ParentJourneyController::class, 'saveEnquiry'])->whereNumber('assessment')->name('enquiry.save');
    Route::get('/reports/{assessment}/matches', [Dev::class, 'matches'])->whereNumber('assessment')->name('matches');
    Route::get('/reports/{assessment}/programmes/{programme}', [Dev::class, 'programmeDetails'])->whereNumber('assessment')->name('programme');
    Route::get('/reports/{assessment}', [Dev::class, 'report'])->whereNumber('assessment')->name('report');
    Route::get('/providers', [Dev::class, 'providers'])->name('providers');
    Route::get('/providers/{provider}', [Dev::class, 'provider'])->whereNumber('provider')->name('provider');
    Route::post('/providers/{provider}/connect', [Dev::class, 'connect'])->whereNumber('provider')->name('connect');
    Route::get('/bookings', [Dev::class, 'bookings'])->name('bookings');
    Route::get('/plans', [Dev::class, 'plans'])->name('plans');
    Route::get('/checkout', [Dev::class, 'checkout'])->name('checkout');
});
