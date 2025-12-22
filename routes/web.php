<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])
->prefix('admin')
->name('admin.')
->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

// Use Spatie role middleware 'role:admin' for admin routes
Route::middleware(['auth', 'role:admin'])
->prefix('admin')
->name('admin.')
->group(function () {

    // 👉 rota base /admin
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    })->name('index');
        
    // 👉 rota /admin/dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/users', [
        \App\Http\Controllers\Admin\UserController::class, 'index'
    ])->name('users.index');

    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)
    ->except(['show']);

    Route::post('users/{user}/toggle-two-factor', [\App\Http\Controllers\Admin\UserController::class, 'toggleTwoFactor'])->name('users.toggle_two_factor');
    Route::post('users/{user}/toggle-email-verification', [\App\Http\Controllers\Admin\UserController::class, 'toggleEmailVerification'])->name('users.toggle_email_verification');

    // Admin settings
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/apply-2fa', [\App\Http\Controllers\Admin\SettingsController::class, 'applyTwoFactorToAll'])->name('settings.apply_2fa');

});

    Route::middleware(['auth', 'permission:user.view'])
    ->get('/admin/users', [UserController::class, 'index'])
    ->name('admin.users.index');

    Route::middleware(['auth', 'permission:user.create'])
    ->post('/admin/users', [UserController::class, 'store']);


    Route::middleware(['auth'])
    ->get('/home', function () {
        return view('home');
    })
    ->name('home');


Route::middleware(['auth'])->get('/two-factor', function () {
    return view('auth.two-factor');
});

Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth', 'role:admin'])->get('/admin', function () {
    return view('admin.dashboard');
});

Route::middleware(['auth', 'twofactor.required', 'role:aluno'])->prefix('aluno')->name('aluno.')->group(function () {
    Route::get('/', function () {
        return view('aluno.dashboard');
    })->name('dashboard');

    // Perfil do aluno
    Route::get('/profile', [\App\Http\Controllers\Student\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/2fa/enable', [\App\Http\Controllers\Student\ProfileController::class, 'enableTwoFactor'])->name('profile.2fa.enable');
    Route::post('/profile/2fa/disable', [\App\Http\Controllers\Student\ProfileController::class, 'disableTwoFactor'])->name('profile.2fa.disable');
});

// admin routes should also ensure 2FA when required
Route::middleware(['auth', 'twofactor.required', 'role:admin'])->get('/admin', function () {
    return view('admin.dashboard');
});
