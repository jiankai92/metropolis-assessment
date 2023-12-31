<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VisitorCheckInController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [VisitorCheckInController::class, 'show'])->name('visitor.checkin.show');
Route::post('/visitor/checkin/submit', [VisitorCheckInController::class, 'create'])->name('visitor.checkin.create');
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/visitor/checkin/list', [VisitorCheckInController::class, 'list'])->middleware(['auth', 'verified'])->name('visitor.checkin.list');
Route::post('/visitor/checkin/search', [VisitorCheckInController::class, 'search'])->middleware(['auth', 'verified'])->name('visitor.checkin.search');
Route::post('/admin/checkout', [VisitorCheckInController::class, 'adminCheckout'])->middleware(['auth', 'verified'])->name('admin.checkout');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
