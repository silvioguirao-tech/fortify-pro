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

Route::middleware(['auth', 'role:aluno'])->get('/aluno', function () {
    return view('aluno.dashboard');
});
