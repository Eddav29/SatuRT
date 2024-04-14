<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailRegistrationController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\FamilyCardController;
use App\Http\Controllers\FinanceReportController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\ResidentReportController;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('email', [EmailRegistrationController::class, 'store']);
        Route::delete('logout', [AuthenticatedSessionController::class, 'destroy']);
        // Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->name('email.verification');
    });

    Route::get('data-keluarga-list', [FamilyCardController::class, 'list'])->middleware('api');
    Route::get('informasi-list', [InformationController::class, 'list'])->middleware('api');
    Route::get('pelaporan-list', [ResidentReportController::class, 'list'])->middleware('api');
})->middleware('api');

Route::get('/pengumuman/{id}', [AnnouncementController::class, 'getAnnouncement'])->middleware('api');
Route::get('/pelaporan/{id}', [ResidentReportController::class, 'getResidentReport'])->middleware('api');
Route::get('/laporan-keuangan/{id}', [FinanceReportController::class, 'financeReport'])->middleware('api');
