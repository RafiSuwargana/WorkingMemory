<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Dashboard;
use App\Livewire\Tests\Instructions;
use App\Livewire\Tests\SpeedTask;
use App\Livewire\Tests\EnergyTask;
use App\Livewire\Tests\CapacityTask;

// Landing page - redirect to dashboard if already logged in
Route::get('/', function() {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('home');

// Authentication routes (halaman terpisah)
Route::view('/login', 'auth.login-simple')->name('login')->middleware('guest');
Route::view('/register', 'auth.register-simple')->name('register')->middleware('guest');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::view('/instructionspeed', 'livewire.tests.instructions')->name('instructionspeed');
    
    // Test routes
    Route::get('/test/speed', SpeedTask::class)->name('test.speed');
    Route::get('/test/energy', EnergyTask::class)->name('test.energy');
    Route::get('/test/capacity', CapacityTask::class)->name('test.capacity');
    
    // Logout route
    Route::get('/logout', function() {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
