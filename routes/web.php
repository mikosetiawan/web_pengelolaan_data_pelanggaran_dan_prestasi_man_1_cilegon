<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CounselingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SPOController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ViolationController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\GradeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// Public routes
Route::prefix('spo')->group(function () {
    Route::get('/public/spo', [SPOController::class, 'index2'])->name('spo.index2');
    Route::get('/{id}/view-detail-public', [SPOController::class, 'viewDetail2'])->name('spo.view-detail2');
    Route::get('/report/{id}', [SPOController::class, 'report2'])->name('spo.report2');
});


// Dashboard routes
Route::prefix('dashboard')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/data', [DashboardController::class, 'data'])->name('dashboard.data');

        // User management routes
        Route::get('register', [RegisteredUserController::class, 'create'])->name('dashboard.register');
        Route::post('register', [RegisteredUserController::class, 'store'])->name('dashboard.register');
        Route::put('users/{id}', [RegisteredUserController::class, 'update'])->name('users.update');
        Route::delete('users/{id}', [RegisteredUserController::class, 'destroy'])->name('users.destroy');
    });

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Violation routes
    Route::prefix('violations')->group(function () {
        Route::get('/', [ViolationController::class, 'index'])->name('violations.index');
        Route::post('/', [ViolationController::class, 'store'])->name('violations.store');
        Route::put('/{id}', [ViolationController::class, 'update'])->name('violations.update');
        Route::delete('/{id}', [ViolationController::class, 'destroy'])->name('violations.destroy');
    });

    // Pelanggaran routes
    Route::prefix('pelanggaran')->group(function () {
        Route::get('/', [PelanggaranController::class, 'index'])->name('pelanggaran.index');
        Route::post('/', [PelanggaranController::class, 'store'])->name('pelanggaran.store');
        Route::put('/{id}', [PelanggaranController::class, 'update'])->name('pelanggaran.update');
        Route::delete('/{id}', [PelanggaranController::class, 'destroy'])->name('pelanggaran.destroy');
    });

    // SPO routes
    Route::prefix('spo')->group(function () {
        Route::get('/', [SPOController::class, 'index'])->name('spo.index');
        Route::get('/report/{id}', [SPOController::class, 'report'])->name('spo.report');
        Route::get('/{id}/view-detail', [SPOController::class, 'viewDetail'])->name('spo.view-detail');
    });

    // Student routes
    Route::prefix('student')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('student.index');
        Route::post('/', [StudentController::class, 'store'])->name('student.store');
        Route::put('/{id}', [StudentController::class, 'update'])->name('student.update');
        Route::delete('/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
    });

    // Achievement routes
    Route::prefix('achievement')->group(function () {
        Route::get('/', [AchievementController::class, 'index'])->name('achievement.index');
        Route::post('/', [AchievementController::class, 'store'])->name('achievement.store');
        Route::put('/{id}', [AchievementController::class, 'update'])->name('achievement.update');
        Route::delete('/{id}', [AchievementController::class, 'destroy'])->name('achievement.destroy');
    });

    // Counseling routes
    Route::prefix('counseling')->group(function () {
        Route::get('/', [CounselingController::class, 'index'])->name('counseling.index');
        Route::post('/', [CounselingController::class, 'store'])->name('counseling.store');
        Route::put('/{id}', [CounselingController::class, 'update'])->name('counseling.update');
        Route::delete('/{id}', [CounselingController::class, 'destroy'])->name('counseling.destroy');
    });

    // Grade routes
    Route::prefix('grade')->group(function () {
        Route::get('/', [GradeController::class, 'index'])->name('grade.index');
        Route::post('/', [GradeController::class, 'store'])->name('grade.store');
        Route::put('/{id}', [GradeController::class, 'update'])->name('grade.update');
        Route::delete('/{id}', [GradeController::class, 'destroy'])->name('grade.destroy');
        Route::get('/report', [GradeController::class, 'report'])->name('grade.report');
        Route::get('/ranking', [GradeController::class, 'rankingReport'])->name('grade.ranking');

        Route::get('/grade/mipa-ranking-pdf', [GradeController::class, 'downloadMipaRankingPdf'])->name('grade.mipa_ranking_pdf');
        Route::get('/grade/ips-ranking-pdf', [GradeController::class, 'downloadIpsRankingPdf'])->name('grade.ips_ranking_pdf');
    });
});

require __DIR__ . '/auth.php';