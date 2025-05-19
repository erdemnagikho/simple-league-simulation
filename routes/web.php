<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ResetController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ShowFixtureController;
use App\Http\Controllers\Admin\GenerateFixtureController;
use App\Http\Controllers\Admin\StartSimulationController;
use App\Http\Controllers\Admin\SimulateNextWeekController;
use App\Http\Controllers\Admin\SimulateAllWeeksController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::post('/fixtures/generate', GenerateFixtureController::class)->name('fixtures.generate');
    Route::get('/fixtures', ShowFixtureController::class)->name('fixtures.show');
    Route::get('/simulation/start', StartSimulationController::class)->name('simulation.start');
    Route::post('/simulation/play-next-week', SimulateNextWeekController::class)->name('simulation.play-next-week');
    Route::post('/simulation/play-all-weeks', SimulateAllWeeksController::class)->name('simulation.play-all-weeks');
    Route::post('/reset', ResetController::class)->name('reset');
});

require __DIR__.'/auth.php';
