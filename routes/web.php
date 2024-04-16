<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CitizenAccountController;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\BusinessUserController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\FamilyCardController;
use App\Http\Controllers\LeaderController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\ResidentReportController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\FinanceReportController;
use App\Http\Controllers\DocumentRequestController;
use App\Models\KartuKeluarga;
use App\Models\User;
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
Route::resource('informasi', InformationController::class)->middleware(['auth', 'verified'])->names([
    'index' => 'informasi.index',
    'show' => 'informasi.show',
    'create' => 'informasi.create',
    'store' => 'informasi.store',
    'edit' => 'informasi.edit',
    'update' => 'informasi.update',
    'destroy' => 'informasi.destroy',
]);
Route::post('/file-upload', [InformationController::class, 'upload'])->name('file.upload');
Route::get('/file-download/{filename}', [InformationController::class, 'download'])->name('file.download');

Route::resource('pelaporan', ResidentReportController::class)->middleware(['auth', 'verified'])->names([
    'index' => 'pelaporan.index',
    'show' => 'pelaporan.show',
    'update' => 'pelaporan.update',
]);

Route::resource('umkm', BusinessUserController::class)->middleware(['auth', 'verified'])->names([
    'index' => 'umkm.index',
    'show' => 'umkm.show',
    'create' => 'umkm.create',
    'store' => 'umkm.store',
    'edit' => 'umkm.edit',
    'update' => 'umkm.update',
    'destroy' => 'umkm.destroy',
]);

Route::resource('keuangan', FinanceReportController::class)->middleware(['auth', 'verified'])->names([
    'index' => 'keuangan.index',
    'show' => 'keuangan.show',
    'create' => 'keuangam.create',
    'store' => 'keuangan.store',
    'edit' => 'keuangan.edit',
    'update' => 'keuangan.update',
    'destroy' => 'keuangan.destroy',
]);

Route::resource('persuratan', DocumentRequestController::class)->middleware(['auth', 'verified'])->names([
    'index' => 'persuratan.index',
    'show' => 'persuratan.show',
]);

/* Warga */
Route::get('/warga/dashboard', [ResidentController::class, 'index'])->middleware(['auth', 'verified'])->name('warga.dashboard');

/* Guest and User */
Route::prefix('profile')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/change-password', [ProfileController::class, 'changePasswordForm'])->name('profile.change-password');
    Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password.post');
    Route::get('/complete-data', [ProfileController::class, 'completeDataForm'])->name('profile.complete-data');
    Route::post('/complete-data', [ProfileController::class, 'completeData'])->name('profile.complete-data.post');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('data-penduduk/keluarga', FamilyCardController::class)
->names([
    'index' => 'data-keluarga.index',
    'create' => 'data-keluarga.create',
    'store' => 'data-keluarga.store',
    'show' => 'data-keluarga.show',
    'edit' => 'data-keluarga.edit',
    'update' => 'data-keluarga.update',
    'destroy' => 'data-keluarga.destroy'
])
->middleware('auth');

Route::resource('data-penduduk/keluarga/{keluargaid}/anggota', CitizenController::class)
->names([
    'index' => 'data-anggota.index',
    'create' => 'data-anggota.create',
    'store' => 'data-anggota.store',
    'show' => 'data-anggota.show',
    'edit' => 'data-anggota.edit',
    'update' => 'data-anggota.update',
    'destroy' => 'data-anggota.destroy'
])
->middleware('auth');

Route::resource('data-akun/penduduk', CitizenAccountController::class)
->names([
    'index' => 'data-akun.index',
    'create' => 'data-akun.create',
    'store' => 'data-akun.store',
    'show' => 'data-akun.show',
    'edit' => 'data-akun.edit',
    'update' => 'data-akun.update',
    'destroy' => 'data-akun.destroy'
])
->middleware('auth');

require __DIR__ . '/auth.php';

Route::get('storage/ktp/{filename}', [StorageController::class, 'storageKTP'])->name('storage.ktp');


Route::get('user', function () {
    return User::all();
})->name('user');
