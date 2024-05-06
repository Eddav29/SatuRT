<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CitizenAccountController;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\BusinessUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\FamilyCardController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResidentReportController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\FinanceReportController;
use App\Http\Controllers\DocumentRequestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Models\Kriteria;
use App\Models\KriteriaAlternatif;
use App\Services\DecisionMakerGenerator\DecisionMakerService;
use App\Services\DecisionMakerGenerator\Support\EddasService;
use App\Services\TableGenerator\TableService;
use App\Http\Controllers\DecisionSupportController;
use App\Http\Controllers\FileController;

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
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::resource('informasi', InformationController::class)->middleware(['auth'])->names([
    'index' => 'informasi.index',
    'show' => 'informasi.show',
    'create' => 'informasi.create',
    'store' => 'informasi.store',
    'edit' => 'informasi.edit',
    'update' => 'informasi.update',
    'destroy' => 'informasi.destroy',
]);

Route::post('/file-upload', [InformationController::class, 'upload'])->name('file.upload');

Route::prefix('file')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/{path}/{identifier}', [FileController::class, 'show'])->name('file.show');
    Route::get('/{path}/{identifier}/download', [FileController::class, 'download'])->name('file.download');
});

Route::resource('pelaporan', ResidentReportController::class)->middleware(['auth'])->names([
    'index' => 'pelaporan.index',
    'show' => 'pelaporan.show',
    'update' => 'pelaporan.update',
    'create' => 'pelaporan.create',
    'store' => 'pelaporan.store',
    'edit' => 'pelaporan.edit',
    'destroy' => 'pelaporan.destroy',
]);

Route::resource('umkm', BusinessUserController::class)->middleware(['auth'])->names([
    'index' => 'umkm.index',
    'show' => 'umkm.show',
    'create' => 'umkm.create',
    'store' => 'umkm.store',
    'edit' => 'umkm.edit',
    'update' => 'umkm.update',
    'destroy' => 'umkm.destroy',
]);

Route::resource('keuangan', FinanceReportController::class)->middleware(['auth'])->names([
    'index' => 'keuangan.index',
    'show' => 'keuangan.show',
    'create' => 'keuangan.create',
    'store' => 'keuangan.store',
    'edit' => 'keuangan.edit',
    'update' => 'keuangan.update',
    'destroy' => 'keuangan.destroy',
]);

Route::resource('persuratan', DocumentRequestController::class)->middleware(['auth'])->names([
    'index' => 'persuratan.index',
    'show' => 'persuratan.show',
    'create' => 'persuratan.create',
    'store' => 'persuratan.store',
    'edit' => 'persuratan.edit',
    'update' => 'persuratan.update',
    'destroy' => 'persuratan.destroy',
]);
Route::resource('inventaris', InventarisController::class)->middleware(['auth'])->names([
    'index' => 'inventaris.index',
    'show' => 'inventaris.show',
    'update' => 'inventaris.update',
    'create' => 'inventaris.create',
    'store' => 'inventaris.store',
    'edit' => 'inventaris.edit',
    'destroy' => 'inventaris.destroy',
]);


//Route untuk persetujuan permohonan  surat
Route::get('/persuratan/{id}/approve', [DocumentRequestController::class, 'approve'])->name('persuratan.approve');

// Rute untuk penolakan permohonan surat
Route::post('/persuratan/{id}/reject', [DocumentRequestController::class, 'reject'])->name('persuratan.reject');

Route::prefix('pendukung-keputusan')->middleware(['auth'])->group(function () {
    Route::resource('alternatif', AlternativeController::class)
        ->names([
            'index' => 'spk.index',
            'create' => 'spk.create',
            'store' => 'spk.store',
            'show' => 'spk.show',
            'edit' => 'spk.edit',
            'update' => 'spk.update',
            'destroy' => 'spk.destroy'
        ]);

    Route::resource('kriteria', CriteriaController::class)
        ->names([
            'index' => 'spk.kriteria.index',
        ]);

    Route::get('hasil-keputusan', [DecisionSupportController::class, 'index'])->name('spk.decision-maker.index');
    Route::get('hasil-keputusan/detail/metode/{metode}', [DecisionSupportController::class, 'show'])->name('spk.show.method');
});

/* Guest and User */
Route::prefix('profile')->middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/change-password/{id}', [ProfileController::class, 'changePasswordForm'])->name('profile.change-password');
    Route::post('/change-password/{id}', [ProfileController::class, 'changePassword'])->name('profile.change-password.post');
    Route::get('/complete-data/{id}', [ProfileController::class, 'completeDataForm'])->name('profile.complete-data');
    Route::post('/complete-data/{id}', [ProfileController::class, 'completeData'])->name('profile.complete-data.post');
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
        'edit' => 'data-keluarga.edit',
        'update' => 'data-keluarga.update',
        'destroy' => 'data-keluarga.destroy'
    ])
    ->middleware([
        'auth',
        'checkRole:Ketua RT',
    ])->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

Route::get('data-penduduk/keluarga/{keluarga}', [FamilyCardController::class, 'show'])->name('data-keluarga.show')->middleware(['auth', 'checkRole:Ketua RT,Penduduk']);

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
    ->middleware(['auth', 'checkRole:Ketua RT,Penduduk']);

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
    ->middleware(['auth', 'checkRole:Ketua RT']);

require __DIR__ . '/auth.php';

Route::get('storage/ktp/{filename}', [StorageController::class, 'storageKTP'])->name('storage.ktp');
Route::get('storage/announcement/{filename}', [StorageController::class, 'storageAnnouncement'])->name('storage.announcement');


// Route::get('eddas', function () {
//     $decisionMaker = new DecisionMakerService();
//     $eddasService = new EddasService();
//     $table = "<script src='https://cdn.tailwindcss.com'></script>";
//     $table .= "<section>";
//     $table .= $decisionMaker->getKriteriaTable();
//     $table .= $decisionMaker->getAlternatifTable();
//     $table .= $decisionMaker->createTableService()->createTable($decisionMaker->getData());
//     $table .= $decisionMaker->createTableService()->createTable($eddasService->stepDetermineAverange(3));
//     $table .= $decisionMaker->createTableService()->createTable($eddasService->stepDeterminePDA(3));
//     $table .= $decisionMaker->createTableService()->createTable($eddasService->stepDetermineNDA(3));
//     $table .= $decisionMaker->createTableService()->createTable($eddasService->stepDetermineSPSN(3));
//     $table .= $decisionMaker->createTableService()->createTable($eddasService->stepDetermineNormalizeSPSN(3));
//     $table .= $decisionMaker->createTableService()->createTable($eddasService->stepCalculateAssesmentScore(5));
//     $table .= $decisionMaker->createTableService()->createTable($eddasService->stepRanking(4));
//     $table .= "</section>";

//     return $table;
// });
