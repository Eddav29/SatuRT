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
use App\Http\Controllers\InventarisPeminjamanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\Auth\ChangePasswordController;
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


Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('guest');

Route::get('berita', [NewsController::class, 'index'])->name('berita')->middleware('guest');
Route::get('berita/{id}', [NewsController::class, 'show'])->name('berita-detail')->middleware('guest');

Route::get('usaha', [BusinessController::class, 'index'])->name('usaha')->middleware('guest');
Route::get('usaha/{id}', [BusinessController::class, 'show'])->name('usaha-detail')->middleware('guest');

require __DIR__ . '/auth.php';

Route::get('storage/announcement/{filename?}', [StorageController::class, 'storageAnnouncement'])->name('storage.announcement');
Route::get('storage/lisence/{filename?}', [StorageController::class, 'storageLisence'])->name('storage.lisence');
Route::get('public/images_storage/{filename?}', [StorageController::class, 'storagePublic'])->name('public');



Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('checkRole:Penduduk')->group(function () {
        Route::resource('persuratan', DocumentRequestController::class)->names([
            'create' => 'persuratan.create',
        ]);
    });

    Route::middleware('checkRole:Ketua RT')->group(function () {
        //Route untuk persetujuan permohonan  surat
        Route::get('/persuratan/{id}/approve', [DocumentRequestController::class, 'approve'])->name('persuratan.approve');
        // Rute untuk penolakan permohonan surat
        Route::get('/persuratan/{id}/reject', [DocumentRequestController::class, 'reject'])->name('persuratan.reject');

        Route::resource('data-penduduk/keluarga', FamilyCardController::class)
            ->names([
                'index' => 'data-keluarga.index',
                'create' => 'data-keluarga.create',
                'store' => 'data-keluarga.store',
                'edit' => 'data-keluarga.edit',
                'update' => 'data-keluarga.update',
                'destroy' => 'data-keluarga.destroy'
            ])->except('show');


        Route::resource('keuangan', FinanceReportController::class)->names([
            'index' => 'keuangan.index',
            'show' => 'keuangan.show',
            'create' => 'keuangan.create',
            'store' => 'keuangan.store',
            'edit' => 'keuangan.edit',
            'update' => 'keuangan.update',
            'destroy' => 'keuangan.destroy',
        ]);

        Route::prefix('pendukung-keputusan')->group(function () {
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


        Route::resource('inventaris/data-inventaris', InventarisController::class)->names([
            'index' => 'inventaris.data-inventaris.index',
            'show' => 'inventaris.data-inventaris.show',
            'update' => 'inventaris.data-inventaris.update',
            'create' => 'inventaris.data-inventaris.create',
            'store' => 'inventaris.data-inventaris.store',
            'edit' => 'inventaris.data-inventaris.edit',
            'destroy' => 'inventaris.data-inventaris.destroy',
        ]);
        Route::resource('inventaris/peminjaman', InventarisPeminjamanController::class)->names([
            'index' => 'inventaris.peminjaman.index',
            'show' => 'inventaris.peminjaman.show',
            'update' => 'inventaris.peminjaman.update',
            'create' => 'inventaris.peminjaman.create',
            'store' => 'inventaris.peminjaman.store',
            'edit' => 'inventaris.peminjaman.edit',
            'destroy' => 'inventaris.peminjaman.destroy',
        ]);

        Route::resource('umkm', BusinessUserController::class)->names([
            'create' => 'umkm.create'
        ])->only(['create']);

        Route::get('/inventaris/peminjaman/selesaikan/{id}', [InventarisPeminjamanController::class, 'selesaikan'])->name('inventaris.peminjaman.selesaikan');

        Route::resource('data-akun/penduduk', CitizenAccountController::class)
            ->names([
                'index' => 'data-akun.index',
                'create' => 'data-akun.create',
                'store' => 'data-akun.store',
                'show' => 'data-akun.show',
                'edit' => 'data-akun.edit',
                'update' => 'data-akun.update',
                'destroy' => 'data-akun.destroy'
            ]);
    });

    Route::middleware('checkRole:Ketua RT,Penduduk')->group(function () {

        Route::put('auth/change-password', [ChangePasswordController::class, 'store']);
        Route::get('storage/ktp/{filename?}', [StorageController::class, 'storageKTP'])->name('storage.ktp');

        Route::get('/persuratan/{id}/pdf', [DocumentRequestController::class, 'generatePdf'])->name('persuratan.pdf');

        Route::resource('data-penduduk/keluarga', FamilyCardController::class)
            ->names([
                'show' => 'data-keluarga.show',
            ])->only('show');


        Route::resource('data-penduduk/keluarga/{keluargaid}/anggota', CitizenController::class)
            ->names([
                'index' => 'data-anggota.index',
                'create' => 'data-anggota.create',
                'store' => 'data-anggota.store',
                'show' => 'data-anggota.show',
                'edit' => 'data-anggota.edit',
                'update' => 'data-anggota.update',
                'destroy' => 'data-anggota.destroy'
            ]);

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


        /* Guest and User */
        Route::prefix('profile')->group(function () {
            Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
            Route::get('/change-password/{id}', [ProfileController::class, 'changePasswordForm'])->name('profile.change-password');
            Route::post('/change-password/{id}', [ProfileController::class, 'changePassword'])->name('profile.change-password.post');
            Route::get('/complete-data/{id}', [ProfileController::class, 'completeDataForm'])->name('profile.complete-data');
            Route::post('/complete-data/{id}', [ProfileController::class, 'completeData'])->name('profile.complete-data.post');
            Route::get('/account', [ProfileController::class, 'account'])->name('profile.account');
            Route::get('/account/{id}', [ProfileController::class, 'accountForm'])->name('profile.account.get');
            Route::post('/account', [ProfileController::class, 'accountStore'])->name('profile.account.post');
        });

        Route::resource('pelaporan', ResidentReportController::class)->names([
            'index' => 'pelaporan.index',
            'show' => 'pelaporan.show',
            'update' => 'pelaporan.update',
            'create' => 'pelaporan.create',
            'store' => 'pelaporan.store',
            'edit' => 'pelaporan.edit',
            'destroy' => 'pelaporan.destroy',
        ]);

        Route::resource('umkm', BusinessUserController::class)->names([
            'index' => 'umkm.index',
            'show' => 'umkm.show',
            'store' => 'umkm.store',
            'edit' => 'umkm.edit',
            'update' => 'umkm.update',
            'destroy' => 'umkm.destroy',
        ])->except(['create']);

        Route::resource('persuratan', DocumentRequestController::class)->names([
            'index' => 'persuratan.index',
            'show' => 'persuratan.show',
            'store' => 'persuratan.store',
            'edit' => 'persuratan.edit',
            'update' => 'persuratan.update',
            'destroy' => 'persuratan.destroy',
        ])->except('create');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('informasi', InformationController::class)->names([
            'index' => 'informasi.index',
            'show' => 'informasi.show',
            'create' => 'informasi.create',
            'store' => 'informasi.store',
            'edit' => 'informasi.edit',
            'update' => 'informasi.update',
            'destroy' => 'informasi.destroy',
        ]);

        Route::prefix('file')->group(function () {
            Route::post('/file-upload', [FileController::class, 'ckeditor_image_upload'])->name('file.upload');
            Route::get('/{path}/{identifier}', [FileController::class, 'show'])->name('file.show');
            Route::get('/{path}/{identifier}/download', [FileController::class, 'download'])->name('file.download');
        });
    });
});
