<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\FamilyCardController;
use App\Http\Controllers\LeaderController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\ResidentReportController;
use App\Http\Controllers\FinanceReportController;
use App\Models\KartuKeluarga;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Guest */
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('berita', [NewsController::class, 'index'])->name('berita');
Route::post('berita', [NewsController::class, 'index'])->name('berita');
Route::get('berita/{id}', [NewsController::class, 'show'])->name('berita-detail');

Route::get('usaha', [BusinessController::class, 'index'])->name('usaha');
Route::get('usaha/{id}', [BusinessController::class, 'show'])->name('usaha-detail');

/* RT */
Route::get('/dashboard', [LeaderController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/pelaporan', [LeaderController::class, 'pelaporan'])->middleware(['auth', 'verified'])->name('pelaporan');
Route::get('/keuangan', [FinanceReportController::class, 'index'])->name('keuangan');

/* Warga */
Route::get('/warga/dashboard', [ResidentController::class, 'index'])->middleware(['auth', 'verified'])->name('warga.dashboard');

/* Guest and User */
Route::get('/biodata', [ProfileController::class, 'index'])->name('biodata');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('data-keluarga', FamilyCardController::class)->names([
    'index' => 'family-card.index',
    'create' => 'family-card.create',
    'store' => 'family-card.store',
    'show' => 'family-card.show',
    'edit' => 'family-card.edit',
    'update' => 'family-card.update',
    'destroy' => 'family-card.destroy'
])->middleware('auth');

require __DIR__ . '/auth.php';
