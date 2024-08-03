<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\Project\Design\AbutmentExternalController;
use App\Http\Controllers\Project\Design\WingExternalLController;
use App\Http\Controllers\Project\DesignController;
use App\Http\Controllers\Project\DocumentController;
use App\Http\Controllers\Project\MemberController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [GuestController::class, 'index'])->name('welcome');
Route::get('/about', [GuestController::class, 'about'])->name('about');

Route::middleware(['auth', 'verified'])->prefix('user')->name('user.')->group(function () {
    Route::get('/profile', [UserController::class, 'show_profile'])->name('profile.show');
    Route::get('/profile/edit', [UserController::class, 'edit_profile'])->name('profile.edit');
    Route::post('/profile', [UserController::class, 'update_profile'])->name('profile.update');
    Route::get('/projects/map', [ProjectController::class, 'map'])->name('projects.map');
    Route::resource('/projects', ProjectController::class)->except('update');
    Route::post('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::prefix('projects/{project}')->name('projects.')->group(function () {
        Route::get('/dashboard', [ProjectController::class, 'dashboard'])->name('dashboard');
        Route::get('/delete-project', [ProjectController::class, 'show_delete'])->name('delete_project');
        Route::delete('/', [ProjectController::class, 'destroy'])->name('destroy');
        Route::post('/members/search', [MemberController::class, 'search'])->name('members.search');
        Route::get('/members/search', [MemberController::class, 'get_search'])->name('members.get_search');
        Route::resource('/members', MemberController::class);
        Route::resource('/documents', DocumentController::class);
        Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
        Route::prefix('designs')->name('designs.')->group(function () {
            Route::get('/', [DesignController::class, 'index'])->name('index');
            Route::get('/create', [DesignController::class, 'create'])->name('create');

            Route::resource('/abutment-external-stability', AbutmentExternalController::class, ['names' => 'abutment_external_stability']);
            Route::get('/abutment-external-stability/{abutment_external_stability}/analyze', [AbutmentExternalController::class, 'analyze'])->name('abutment_external_stability.analyze');
            Route::get('/abutment-external-stability/{abutment_external_stability}/word-report', [AbutmentExternalController::class, 'word_report'])->name('abutment_external_stability.word_report');
            Route::get('/abutment-external-stability/{abutment_external_stability}/excel-report', [AbutmentExternalController::class, 'excel_report'])->name('abutment_external_stability.excel_report');

            Route::resource('/wing-external-stability-ll', WingExternalLController::class, ['names' => 'wing_external_stability_ll']);
            Route::get('/wing-external-stability-ll/{wing_external_stability_ll}/analyze', [WingExternalLController::class, 'analyze'])->name('wing_external_stability_ll.analyze');
            Route::get('/wing-external-stability-ll/{wing_external_stability_ll}/word-report', [WingExternalLController::class, 'word_report'])->name('wing_external_stability_ll.word_report');
            Route::get('/wing-external-stability-ll/{wing_external_stability_ll}/excel-report', [WingExternalLController::class, 'excel_report'])->name('wing_external_stability_ll.excel_report');
        });
    });
});

require __DIR__ . '/auth.php';
