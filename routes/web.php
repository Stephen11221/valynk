<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

Route::view('/login', 'login')->name('login');

Route::post('/login', function () {
    return redirect()->route('admin.dashboard');
})->name('login.authenticate');

Route::view('/register', 'register')->name('register');

Route::post('/register', function (Request $request) {
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        'phone' => ['required', 'string', 'max:30'],
        'account_type' => ['required', 'in:Individual / Family,Provider,Institution,Partner / Other'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'location' => ['nullable', 'string', 'max:100'],
        'terms' => ['accepted'],
    ]);

    User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'phone' => $validated['phone'],
        'account_type' => $validated['account_type'],
        'location' => $validated['location'] ?? null,
        'password' => Hash::make($validated['password']),
    ]);

    return redirect()->route('login')->with('status', 'Your account has been created. You can now log in.');
})->name('register.store');

// Admin Dashboard Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [DashboardController::class, 'users'])->name('users');
    Route::get('/providers', [DashboardController::class, 'providers'])->name('providers');
    Route::get('/matches', [DashboardController::class, 'matches'])->name('matches');
    Route::get('/transactions', [DashboardController::class, 'transactions'])->name('transactions');
    Route::get('/payments', [DashboardController::class, 'payments'])->name('payments');
    Route::get('/subscriptions', [DashboardController::class, 'subscriptions'])->name('subscriptions');
    Route::get('/content', [DashboardController::class, 'content'])->name('content');
    Route::get('/reports', [DashboardController::class, 'reports'])->name('reports');
    Route::get('/communications', [DashboardController::class, 'communications'])->name('communications');
    Route::get('/analytics', [DashboardController::class, 'analytics'])->name('analytics');
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
    Route::get('/audit-logs', [DashboardController::class, 'auditLogs'])->name('audit-logs');
});
