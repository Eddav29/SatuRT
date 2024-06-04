<?php

use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CitizenAccountController;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\BusinessUserController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\DecisionSupportController;
use App\Http\Controllers\FamilyCardController;
use App\Http\Controllers\FinanceReportController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\InventarisPeminjamanController;
use App\Http\Controllers\ResidentReportController;
use App\Http\Controllers\DocumentRequestController;
use App\Http\Controllers\NewsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::get('berita', [NewsController::class, 'paginate']);
    Route::get('usaha', [BusinessController::class, 'paginate']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('v1')->group(function () {


        Route::middleware('checkRole:Ketua RT,Penduduk')->group(function () {
            Route::get('data-penduduk/keluarga/{id}/anggota', [CitizenController::class, 'list']);

            Route::get('informasi', [InformationController::class, 'list']);
            Route::get('umkm', [BusinessUserController::class, 'list']);
            Route::get('pelaporan', [ResidentReportController::class, 'list']);

            Route::get('persuratan', [DocumentRequestController::class, 'list']);

            Route::get('keuangan/{year}', [FinanceReportController::class, 'listByYear']);

            Route::get('/pengumuman/{id}', [AnnouncementController::class, 'getAnnouncement']);
            Route::get('/pelaporan/{id}', [ResidentReportController::class, 'getResidentReport']);
            Route::get('/laporan-keuangan/{id}', [FinanceReportController::class, 'financeReport']);
        });


        Route::middleware('checkRole:Ketua RT')->group(function () {
            Route::get('pendukung-keputusan/alternatif', [AlternativeController::class, 'list']);
            Route::get('pendukung-keputusan/kriteria', [CriteriaController::class, 'list']);
            Route::get('pendukung-keputusan/ranking/metode/{metode}', [DecisionSupportController::class, 'ranking']);
            Route::get('data-penduduk/keluarga', [FamilyCardController::class, 'list']);

            Route::get('keuangan', [FinanceReportController::class, 'list']);

            Route::get('inventaris/data-inventaris', [InventarisController::class, 'list']);
            Route::get('inventaris/peminjaman', [InventarisPeminjamanController::class, 'list']);

            Route::get('data-akun/penduduk', [CitizenAccountController::class, 'list']);
        });
    });
});
