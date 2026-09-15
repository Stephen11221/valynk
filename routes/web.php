<?php

use App\Http\Controllers\Account\DashboardController as AccountDashboardController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProviderController;
use App\Http\Controllers\Admin\SitePageAdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\SitePageController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', [SitePageController::class, 'show'])->defaults('slug', 'home')->name('home');

Route::get('/about', [SitePageController::class, 'show'])->defaults('slug', 'about')->name('about');

Route::get('/how-it-works', [SitePageController::class, 'show'])->defaults('slug', 'how-it-works')->name('how-it-works');

Route::get('/families', [SitePageController::class, 'show'])->defaults('slug', 'families')->name('families');

Route::get('/providers', [SitePageController::class, 'show'])->defaults('slug', 'providers')->name('providers');

Route::get('/institutions', [SitePageController::class, 'show'])->defaults('slug', 'institutions')->name('institutions');

Route::get('/pricing', [SitePageController::class, 'show'])->defaults('slug', 'pricing')->name('pricing');

Route::get('/contact', [SitePageController::class, 'show'])->defaults('slug', 'contact')->name('contact');

Route::get('/solutions', [SitePageController::class, 'show'])->defaults('slug', 'solutions')->name('solutions');

Route::get('/login', [SitePageController::class, 'show'])->defaults('slug', 'login')->name('login');

Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:5,1')->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');
Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', [AccountDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/profile', [AccountDashboardController::class, 'edit'])->name('account.profile.edit');
    Route::put('/dashboard/profile', [AccountDashboardController::class, 'update'])->name('account.profile.update');
});
Route::get('/forgot-password', [PasswordResetController::class, 'requestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendLink'])->middleware('throttle:3,1')->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'resetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->middleware('throttle:5,1')->name('password.update');

Route::get('/register', [SitePageController::class, 'show'])->defaults('slug', 'register')->name('register');

Route::post('/register', function (Request $request) {
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        'phone' => ['required', 'string', 'max:30'],
        'account_type' => ['required', 'in:Individual,Family,Provider,Institution,Partner / Other'],
        'password' => ['required', 'string', 'min:12', 'confirmed'],
        'location' => ['nullable', 'string', 'max:100'],
        'terms' => ['accepted'],
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'phone' => $validated['phone'],
        'account_type' => $validated['account_type'],
        'location' => $validated['location'] ?? null,
        'password' => Hash::make($validated['password']),
    ]);

    if ($request->user()?->is_admin) {
        return redirect()->route('admin.users')->with('status', "{$user->name}'s account was created.");
    }

    return redirect()->route('login')->with('status', 'Your account has been created. You can now log in.');
})->name('register.store');

// Admin Dashboard Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'can:manage-admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [DashboardController::class, 'users'])->name('users');
    Route::get('/users/create', [DashboardController::class, 'createUser'])->name('users.create');
    Route::post('/users', [DashboardController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [DashboardController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [DashboardController::class, 'updateUser'])->name('users.update');
    Route::get('/providers', [ProviderController::class, 'index'])->name('providers');
    Route::get('/providers/create', [ProviderController::class, 'create'])->name('providers.create');
    Route::post('/providers', [ProviderController::class, 'store'])->name('providers.store');
    Route::get('/providers/export', [ProviderController::class, 'export'])->name('providers.export');
    Route::get('/providers/{provider}/edit', [ProviderController::class, 'edit'])->name('providers.edit');
    Route::put('/providers/{provider}', [ProviderController::class, 'update'])->name('providers.update');
    Route::get('/matches', [DashboardController::class, 'matches'])->name('matches');
    Route::get('/transactions', [DashboardController::class, 'transactions'])->name('transactions');
    Route::get('/payments', [DashboardController::class, 'payments'])->name('payments');
    Route::get('/subscriptions', [DashboardController::class, 'subscriptions'])->name('subscriptions');
    Route::get('/content', [SitePageAdminController::class, 'index'])->name('content');
    Route::get('/content/{sitePage}/edit', [SitePageAdminController::class, 'edit'])->name('content.edit');
    Route::put('/content/{sitePage}', [SitePageAdminController::class, 'update'])->name('content.update');
    Route::get('/reports', [DashboardController::class, 'reports'])->name('reports');
    Route::get('/communications', [DashboardController::class, 'communications'])->name('communications');
    Route::get('/analytics', [DashboardController::class, 'analytics'])->name('analytics');
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
    Route::get('/audit-logs', [DashboardController::class, 'auditLogs'])->name('audit-logs');
});
