<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Dashboard;
use App\Livewire\Tests\InstructionsSpeed;
use App\Livewire\Tests\SpeedTask;
use App\Livewire\Tests\EnergyTask;
use App\Livewire\Tests\CapacityTask;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Users as AdminUsers;
use App\Livewire\Admin\Laporan as AdminLaporan;

// Landing page - redirect to dashboard if already logged in
Route::get('/', function () {
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
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // Instruction routes with access control
    Route::view('/instructionspeed', 'livewire.tests.instructions-speed')
        ->name('instructionspeed')
        ->middleware('test.access:speed,instruction');

    Route::view('/instructionEnergy', 'livewire.tests.instructions-energy')
        ->name('instructionEnergy')
        ->middleware('test.access:energy,instruction');

    Route::view('/instructionCapacity', 'livewire.tests.instructions-capacity')
        ->name('instructionCapacity')
        ->middleware('test.access:capacity,instruction');

    // Test routes with access control
    Route::get('/test/speed', SpeedTask::class)
        ->name('test.speed')
        ->middleware('test.access:speed');

    Route::get('/test/energy', EnergyTask::class)
        ->name('test.energy')
        ->middleware('test.access:energy');

    Route::get('/test/capacity', CapacityTask::class)
        ->name('test.capacity')
        ->middleware('test.access:capacity');

    // Logout route
    Route::get('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('admin.dashboard');
    Route::get('/users', AdminUsers::class)->name('admin.users');
    Route::get('/laporan', AdminLaporan::class)->name('admin.laporan');
});

// Route::get('/profile', 'profile')
//     ->middleware(['auth'])
//     ->name('profile');

require __DIR__ . '/auth.php';
